<?php
/**
 * ====================================================
 * BACKEND: Répertoire des Étudiants
 * ====================================================
 * Affiche la liste des étudiants avec filtrage
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$db = getDB();

// Paramètres de pagination et filtrage
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limite = 50; // Nombre d'étudiants par page
$offset = ($page - 1) * $limite;

$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$statut = isset($_GET['statut']) ? clean($_GET['statut']) : 'Actif';
$recherche = isset($_GET['recherche']) ? clean($_GET['recherche']) : '';
$tri = isset($_GET['tri']) ? clean($_GET['tri']) : 'nom';

// Récupérer les filières pour le filtre
$query = "SELECT * FROM filiere ORDER BY nom_filiere";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $filieres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $filieres = [];
}

// Construire la requête principale
$query = "SELECT e.*, f.nom_filiere, d.nom_dept 
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          LEFT JOIN departement d ON f.id_dept = d.id_dept
          WHERE e.statut = ?";

$params = [$statut];
$types = "s";

if ($id_filiere) {
    $query .= " AND e.id_filiere = ?";
    $params[] = $id_filiere;
    $types .= "i";
}

if ($recherche) {
    $query .= " AND (e.matricule LIKE ? OR e.nom LIKE ? OR e.prenom LIKE ? OR e.email LIKE ?)";
    $search_term = "%$recherche%";
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= "ssss";
}

// Tri
$tri_valid = ['nom', 'prenom', 'matricule', 'date_inscription'];
$tri = in_array($tri, $tri_valid) ? $tri : 'nom';
$query .= " ORDER BY e.$tri ASC";

// Total avant pagination
$count_query = str_replace("SELECT e.*,", "SELECT COUNT(*) as total,", $query);
$count_query = explode(" ORDER BY", $count_query)[0];

$stmt = $db->prepare($count_query);
$stmt->bind_param($types, ...$params);
if ($stmt->execute()) {
    $count_result = $stmt->get_result()->fetch_assoc();
    $total_etudiants = $count_result['total'] ?? 0;
    $total_pages = ceil($total_etudiants / $limite);
} else {
    $total_etudiants = 0;
    $total_pages = 1;
}

// Ajouter la pagination
$query .= " LIMIT ? OFFSET ?";
$params[] = $limite;
$params[] = $offset;
$types .= "ii";

// Exécuter la requête
$stmt = $db->prepare($query);
$stmt->bind_param($types, ...$params);
if ($stmt->execute()) {
    $etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
} else {
    $etudiants = [];
}

// Récupérer les statistiques globales
$stats_query = "SELECT 
                 COUNT(*) as total,
                 SUM(CASE WHEN statut = 'Actif' THEN 1 ELSE 0 END) as actifs,
                 SUM(CASE WHEN statut = 'Diplômé' THEN 1 ELSE 0 END) as diplomes,
                 SUM(CASE WHEN statut = 'Suspendu' THEN 1 ELSE 0 END) as suspendus,
                 COUNT(DISTINCT id_filiere) as nb_filieres
                FROM etudiant";

$stmt = $db->prepare($stats_query);
if ($stmt === false) {
    logError("Erreur préparation requête stats: " . $db->error);
    $stats = ['total' => 0, 'actifs' => 0, 'diplomes' => 0, 'suspendus' => 0, 'nb_filieres' => 0];
} else {
    if ($stmt->execute()) {
        $stats = $stmt->get_result()->fetch_assoc();
    } else {
        logError("Erreur exécution requête stats: " . $stmt->error);
        $stats = ['total' => 0, 'actifs' => 0, 'diplomes' => 0, 'suspendus' => 0, 'nb_filieres' => 0];
    }
}

// Traiter l'export CSV
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="etudiants_' . date('Y-m-d') . '.csv"');
    
    $output = fopen('php://output', 'w');
    fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF)); // BOM pour UTF-8
    
    // En-têtes
    fputcsv($output, ['Matricule', 'Nom', 'Prénom', 'Email', 'Filière', 'Département', 'Statut', 'Date Inscription']);
    
    // Données
    foreach ($etudiants as $et) {
        fputcsv($output, [
            $et['matricule'],
            $et['nom'],
            $et['prenom'],
            $et['email'],
            $et['nom_filiere'],
            $et['nom_dept'],
            $et['statut'],
            formatDate($et['date_inscription'])
        ]);
    }
    
    fclose($output);
    exit;
}

// Préparer les données
$repertoire_data = [
    'etudiants' => $etudiants,
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'statut' => $statut,
    'recherche' => $recherche,
    'tri' => $tri,
    'page' => $page,
    'total_pages' => $total_pages,
    'total_etudiants' => $total_etudiants,
    'limite' => $limite,
    'stats' => $stats
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($repertoire_data);
    exit;
}

extract($repertoire_data);
// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/r_pertoire_des_tudiants/repertoire_des_etudiants.php';

?>
