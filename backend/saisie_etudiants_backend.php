<?php
/**
 * ====================================================
 * BACKEND: Saisie des Étudiants / Inscription
 * ====================================================
 * Gère l'inscription et la recherche des étudiants
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$filiereManager = new FiliereManager();
$db = getDB();

$message = '';
$type_message = '';

// 1. Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_student') {
    $matricule = trim($_POST['matricule'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $date_naissance = !empty($_POST['date_naissance']) ? $_POST['date_naissance'] : null;
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $id_filiere = !empty($_POST['filiere']) ? (int)$_POST['filiere'] : null;
    
    // Gérer le téléchargement de la photo
    $photo_path = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = __DIR__ . '/../uploads/photos/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
        
        if (in_array($file_extension, $allowed_extensions)) {
            if ($_FILES['photo']['size'] <= 2 * 1024 * 1024) { // Max 2MB
                $new_filename = 'photo_' . $matricule . '_' . time() . '.' . $file_extension;
                $destination = $upload_dir . $new_filename;
                
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $destination)) {
                    $photo_path = 'uploads/photos/' . $new_filename;
                }
            } else {
                $message = "Erreur : La photo ne doit pas dépasser 2 Mo.";
                $type_message = "error";
            }
        } else {
            $message = "Erreur : Format de photo non valide (JPG, PNG uniquement).";
            $type_message = "error";
        }
    }
    
    // Vérifier si le matricule existe déjà
    $query = "SELECT id_etudiant FROM etudiant WHERE matricule = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $matricule);
    $stmt->execute();
    if ($stmt->get_result()->num_rows > 0) {
        $message = "Erreur : Le matricule $matricule est déjà utilisé.";
        $type_message = "error";
    } else {
        $data = [
            'matricule' => $matricule,
            'nom' => $nom,
            'prenom' => $prenom,
            'date_naissance' => $date_naissance,
            'email' => $email,
            'telephone' => $telephone,
            'id_filiere' => $id_filiere,
            'statut' => 'Actif',
            'date_inscription' => date('Y-m-d H:i:s')
        ];
        
        // Ajouter la photo si elle existe
        if ($photo_path) {
            $data['photo'] = $photo_path;
        }
        
        if ($etudiantManager->create($data)) {
            $message = "L'étudiant $nom $prenom a été inscrit avec succès.";
            $type_message = "success";
        } else {
            $message = "Une erreur est survenue lors de l'inscription.";
            $type_message = "error";
        }
    }
}

// 2. Gérer la recherche et la pagination
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filiere_filter = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 10;
$offset = ($page - 1) * $limit;

// Récupérer les filières pour le formulaire
$filieres = $filiereManager->getAll();

// Récupérer les étudiants récents ou recherchés
$query = "SELECT e.*, f.nom_filiere 
          FROM etudiant e 
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere 
          WHERE 1=1";
$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND (e.nom LIKE ? OR e.prenom LIKE ? OR e.matricule LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if ($filiere_filter > 0) {
    $query .= " AND e.id_filiere = ?";
    $params[] = $filiere_filter;
    $types .= "i";
}

$query .= " ORDER BY e.date_inscription DESC LIMIT ?, ?";
$params[] = $offset;
$params[] = $limit;
$types .= "ii";

$stmt = $db->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Compter pour la pagination
$count_query = "SELECT COUNT(*) as total FROM etudiant WHERE 1=1";
if (!empty($search)) $count_query .= " AND (nom LIKE ? OR prenom LIKE ? OR matricule LIKE ?)";
if ($filiere_filter > 0) $count_query .= " AND id_filiere = $filiere_filter";

$stmt_count = $db->prepare($count_query);
if (!empty($search)) {
    $stmt_count->bind_param("sss", $search_param, $search_param, $search_param);
}
$stmt_count->execute();
$total = $stmt_count->get_result()->fetch_assoc()['total'];
$total_pages = ceil($total / $limit);

// 3. Préparer les données pour la vue
$view_data = [
    'message' => $message,
    'type_message' => $type_message,
    'filieres' => $filieres,
    'etudiants' => $etudiants,
    'search' => $search,
    'filiere_filter' => $filiere_filter,
    'total' => $total,
    'page' => $page,
    'total_pages' => $total_pages
];

extract($view_data);

// 4. Inclure la vue frontend
include __DIR__ . '/../maquettes/saisie_tudiants_inscriptions/saisie_etudiants.php';
?>
