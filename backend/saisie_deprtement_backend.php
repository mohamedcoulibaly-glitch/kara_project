<?php
/**
 * ====================================================
 * BACKEND: Saisie et Gestion des Départements
 * ====================================================
 * Permet de créer et modifier les départements
 * ainsi que les filières associées
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$db = getDB();
$message = '';
$type_message = '';

// ========================================
// TRAITER LES ACTIONS POST
// ========================================

// Créer un département
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_dept') {
    $nom_dept = clean($_POST['nom_dept'] ?? '');
    $code_dept = clean($_POST['code_dept'] ?? '');
    $chef_dept = clean($_POST['chef_dept'] ?? '');
    
    if (empty($nom_dept)) {
        $message = 'Le nom du département est obligatoire';
        $type_message = 'error';
    } else {
        // Vérifier si le code n'existe pas déjà
        $query_check = "SELECT id_dept FROM departement WHERE code_dept = ? OR nom_dept = ?";
        $stmt = $db->prepare($query_check);
        $stmt->bind_param("ss", $code_dept, $nom_dept);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();
        
        if ($existing) {
            $message = 'Ce département existe déjà';
            $type_message = 'error';
        } else {
            // Insérer le nouveau département
            $query_insert = "INSERT INTO departement (nom_dept, code_dept, chef_dept) 
                           VALUES (?, ?, ?)";
            $stmt = $db->prepare($query_insert);
            $stmt->bind_param("sss", $nom_dept, $code_dept, $chef_dept);
            
            if ($stmt->execute()) {
                $new_dept_id = $db->insert_id;
                $message = 'Département créé avec succès';
                $type_message = 'success';
            } else {
                $message = 'Erreur lors de la création du département';
                $type_message = 'error';
            }
        }
    }
}

// Créer une filière
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_filiere') {
    $id_dept = (int)($_POST['id_dept'] ?? 0);
    $nom_filiere = clean($_POST['nom_filiere'] ?? '');
    $code_filiere = clean($_POST['code_filiere'] ?? '');
    $responsable = clean($_POST['responsable'] ?? '');
    $niveau = clean($_POST['niveau'] ?? 'Licence');
    
    if (empty($nom_filiere) || empty($id_dept)) {
        $message = 'Le nom et le département de la filière sont obligatoires';
        $type_message = 'error';
    } else {
        // Vérifier si le code n'existe pas déjà
        $query_check = "SELECT id_filiere FROM filiere WHERE code_filiere = ? OR (nom_filiere = ? AND id_dept = ?)";
        $stmt = $db->prepare($query_check);
        $stmt->bind_param("ssi", $code_filiere, $nom_filiere, $id_dept);
        $stmt->execute();
        $existing = $stmt->get_result()->fetch_assoc();
        
        if ($existing) {
            $message = 'Cette filière existe déjà dans ce département';
            $type_message = 'error';
        } else {
            // Insérer la nouvelle filière
            $query_insert = "INSERT INTO filiere (nom_filiere, code_filiere, responsable, id_dept, niveau) 
                           VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($query_insert);
            $stmt->bind_param("sssss", $nom_filiere, $code_filiere, $responsable, $id_dept, $niveau);
            
            if ($stmt->execute()) {
                $message = 'Filière créée avec succès';
                $type_message = 'success';
            } else {
                $message = 'Erreur lors de la création de la filière';
                $type_message = 'error';
            }
        }
    }
}

// Mettre à jour un département
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_dept') {
    $id_dept = (int)($_POST['id_dept'] ?? 0);
    $nom_dept = clean($_POST['nom_dept'] ?? '');
    $code_dept = clean($_POST['code_dept'] ?? '');
    $chef_dept = clean($_POST['chef_dept'] ?? '');
    
    if (empty($nom_dept) || empty($id_dept)) {
        $message = 'Données invalides';
        $type_message = 'error';
    } else {
        $query_update = "UPDATE departement SET nom_dept = ?, code_dept = ?, chef_dept = ? 
                        WHERE id_dept = ?";
        $stmt = $db->prepare($query_update);
        $stmt->bind_param("sssi", $nom_dept, $code_dept, $chef_dept, $id_dept);
        
        if ($stmt->execute()) {
            $message = 'Département mis à jour avec succès';
            $type_message = 'success';
        } else {
            $message = 'Erreur lors de la mise à jour';
            $type_message = 'error';
        }
    }
}

// Supprimer un département
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_dept') {
    $id_dept = (int)($_POST['id_dept'] ?? 0);
    
    if ($id_dept) {
        // Vérifier s'il y a des filières associées
        $query_check = "SELECT COUNT(*) as count FROM filiere WHERE id_dept = ?";
        $stmt = $db->prepare($query_check);
        $stmt->bind_param("i", $id_dept);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        if ($result['count'] > 0) {
            $message = 'Impossible de supprimer: des filières sont associées à ce département';
            $type_message = 'error';
        } else {
            $query_delete = "DELETE FROM departement WHERE id_dept = ?";
            $stmt = $db->prepare($query_delete);
            $stmt->bind_param("i", $id_dept);
            
            if ($stmt->execute()) {
                $message = 'Département supprimé avec succès';
                $type_message = 'success';
            } else {
                $message = 'Erreur lors de la suppression';
                $type_message = 'error';
            }
        }
    }
}

// Supprimer une filière
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_filiere') {
    $id_filiere = (int)($_POST['id_filiere'] ?? 0);
    
    if ($id_filiere) {
        $query_delete = "DELETE FROM filiere WHERE id_filiere = ?";
        $stmt = $db->prepare($query_delete);
        $stmt->bind_param("i", $id_filiere);
        
        if ($stmt->execute()) {
            $message = 'Filière supprimée avec succès';
            $type_message = 'success';
        } else {
            $message = 'Erreur lors de la suppression';
            $type_message = 'error';
        }
    }
}

// ========================================
// RÉCUPÉRER LES DONNÉES
// ========================================

// Récupérer tous les départements avec leurs filières
$query_depts = "SELECT d.*, 
        COUNT(DISTINCT f.id_filiere) as nb_filieres,
        COUNT(DISTINCT e.id_etudiant) as nb_etudiants
        FROM departement d
        LEFT JOIN filiere f ON d.id_dept = f.id_dept
        LEFT JOIN etudiant e ON f.id_filiere = e.id_filiere AND e.statut = 'Actif'
        GROUP BY d.id_dept
        ORDER BY d.nom_dept ASC";

$stmt = $db->prepare($query_depts);
$stmt->execute();
$departements = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer les filières pour chaque département
$departements_avec_filieres = [];
foreach ($departements as $dept) {
    $query_filieres = "SELECT f.*, 
            COUNT(e.id_etudiant) as nb_etudiants
            FROM filiere f
            LEFT JOIN etudiant e ON f.id_filiere = e.id_filiere AND e.statut = 'Actif'
            WHERE f.id_dept = ?
            GROUP BY f.id_filiere
            ORDER BY f.nom_filiere ASC";
    
    $stmt = $db->prepare($query_filieres);
    $stmt->bind_param("i", $dept['id_dept']);
    $stmt->execute();
    $dept['filieres'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    $departements_avec_filieres[] = $dept;
}

// Statistiques globales
$query_stats = "SELECT 
    COUNT(DISTINCT d.id_dept) as total_departements,
    COUNT(DISTINCT f.id_filiere) as total_filieres,
    COUNT(DISTINCT e.id_etudiant) as total_etudiants,
    COUNT(DISTINCT ue.id_ue) as total_ues,
    COUNT(DISTINCT ec.id_ec) as total_ecs
FROM departement d
LEFT JOIN filiere f ON d.id_dept = f.id_dept
LEFT JOIN etudiant e ON f.id_filiere = e.id_filiere AND e.statut = 'Actif'
LEFT JOIN ue ON d.id_dept = ue.id_dept
LEFT JOIN ec ON ue.id_ue = ec.id_ue";

$stmt = $db->prepare($query_stats);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Récupérer les options nivaux
$niveaux = ['Licence', 'Master', 'Doctorat', 'DUT'];

// ========================================
// PRÉPARER LES DONNÉES
// ========================================
$saisie_data = [
    'departements' => $departements_avec_filieres,
    'stats' => $stats,
    'niveaux' => $niveaux,
    'message' => $message,
    'type_message' => $type_message
];

// ========================================
// RETOURNER LES DONNÉES
// ========================================

// Si AJAX appelé au format JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($saisie_data);
    exit;
}

// Si AJAX appelé (POST) retourner JSON
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode(['success' => $type_message === 'success', 'message' => $message]);
    exit;
}

// Sinon inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/saisie_d_partements_fili_res/saisie_deprtement.php';

?>
