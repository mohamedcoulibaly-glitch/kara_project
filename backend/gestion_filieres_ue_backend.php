<?php
/**
 * ====================================================
 * BACKEND: Gestion des Filières et UE/EC
 * ====================================================
 * Gère les structures de filières, UE et EC
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$filiereManager = new FiliereManager();
$db = getDB();

// Récupérer toutes les filières
$filieres = $filiereManager->getAll();

// Récupérer la filière sélectionnée
$id_filiere = isset($_GET['id']) ? (int)$_GET['id'] : (isset($filieres[0]) ? $filieres[0]['id_filiere'] : 0);

// Récupérer la maquette de la filière
$maquette = $id_filiere ? $filiereManager->getMaquette($id_filiere) : [];

// Récupérer les stats
$query = "SELECT 
            COUNT(DISTINCT u.id_ue) as nb_ues,
            COUNT(DISTINCT e.id_ec) as nb_ecs,
            SUM(u.credits_ects) as total_credits
          FROM ue u
          LEFT JOIN programme p ON u.id_ue = p.id_ue AND p.id_filiere = ?
          LEFT JOIN ec e ON u.id_ue = e.id_ue
          WHERE p.id_filiere = ? OR u.id_dept = (SELECT id_dept FROM filiere WHERE id_filiere = ?)";

$stmt = $db->prepare($query);
$stmt->bind_param("iii", $id_filiere, $id_filiere, $id_filiere);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Grouper la maquette par semestre
$maquette_par_semestre = [];
foreach ($maquette as $item) {
    if (!isset($maquette_par_semestre[$item['semestre']])) {
        $maquette_par_semestre[$item['semestre']] = [];
    }
    $maquette_par_semestre[$item['semestre']][] = $item;
}

// Traiter les modifications
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_ue') {
    $id_ue = (int)postParam('id_ue');
    $libelle = postParam('libelle_ue');
    $credits = (int)postParam('credits_ects');
    $coefficient = (float)postParam('coefficient');
    
    $query = "UPDATE ue SET libelle_ue = ?, credits_ects = ?, coefficient = ? WHERE id_ue = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sdii", $libelle, $credits, $coefficient, $id_ue);
    
    $message = $stmt->execute() ? showSuccess('UE mise à jour') : showError('Erreur');
}

// Préparer les données
$filiere_data = [
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'maquette' => $maquette,
    'maquette_par_semestre' => $maquette_par_semestre,
    'stats' => $stats,
    'message' => $message
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($filiere_data);
    exit;
}

// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/gestion_fili_res_ue/gestion_filiere_res_ue.php';

?>
