<?php
/**
 * ====================================================
 * BACKEND: Procès-Verbal de Délibération
 * ====================================================
 * Gère et affiche les procès-verbaux de délibération
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$deliberationManager = new DeliberationManager();
$db = getDB();

// Récupérer les paramètres
$id_deliberation = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$semestre = isset($_GET['semestre']) ? (int)$_GET['semestre'] : 1;

// Récupérer les filières
$query = "SELECT * FROM filiere ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$stmt->execute();
$filieres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Si filière spécifiée, récupérer les délibérations de cette filière
$deliberations_list = [];
if ($id_filiere) {
    $query = "SELECT d.*, e.matricule, e.nom, e.prenom, f.nom_filiere
              FROM deliberation d
              JOIN etudiant e ON d.id_etudiant = e.id_etudiant
              LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
              WHERE e.id_filiere = ? AND d.semestre = ?
              ORDER BY d.date_deliberation DESC";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $id_filiere, $semestre);
    $stmt->execute();
    $deliberations_list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Si une délibération spécifiée, récupérer ses détails
$deliberation_detail = null;
$pv = null;
if ($id_deliberation) {
    $deliberation_detail = $deliberationManager->getById($id_deliberation);
    
    // Récupérer le PV associé
    $query = "SELECT * FROM proces_verbal WHERE id_deliberation = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_deliberation);
    $stmt->execute();
    $pv = $stmt->get_result()->fetch_assoc();
    
    // Si pas de PV, en créer un
    if (!$pv && $deliberation_detail) {
        $code_pv = 'PV-' . date('YmdHis');
        $query = "INSERT INTO proces_verbal 
                  (id_deliberation, code_pv, date_pv, lieu_reunion, president_jury, statut)
                  VALUES (?, ?, NOW(), 'Salle de Réunion', 'Admin Académique', 'Programmé')";
        
        $stmt = $db->prepare($query);
        $stmt->bind_param("is", $id_deliberation, $code_pv);
        $stmt->execute();
        
        $pv = [
            'id_pv' => $db->insert_id,
            'code_pv' => $code_pv,
            'date_pv' => date('Y-m-d'),
            'lieu_reunion' => 'Salle de Réunion',
            'president_jury' => 'Admin Académique',
            'membres_jury' => '',
            'resume_pv' => '',
            'decisions' => ''
        ];
    }
}

// Récupérer les statistiques globales
$query = "SELECT 
            COUNT(*) as total_deliberations,
            SUM(CASE WHEN statut = 'Admis' THEN 1 ELSE 0 END) as admis,
            SUM(CASE WHEN statut = 'Redoublant' THEN 1 ELSE 0 END) as redoublants,
            SUM(CASE WHEN statut = 'Ajourné' THEN 1 ELSE 0 END) as ajournes
          FROM deliberation
          WHERE semestre = ?";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $semestre);
$stmt->execute();
$stats = $stmt->get_result()->fetch_assoc();

// Traiter la mises à jour du PV
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_pv') {
    $id_pv = (int)postParam('id_pv');
    $heure_debut = postParam('heure_debut');
    $heure_fin = postParam('heure_fin');
    $membres_jury = postParam('membres_jury');
    $resume_pv = postParam('resume_pv');
    $decisions = postParam('decisions');
    
    $query = "UPDATE proces_verbal 
              SET heure_debut = ?, heure_fin = ?, membres_jury = ?, resume_pv = ?, decisions = ?
              WHERE id_pv = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssssi", $heure_debut, $heure_fin, $membres_jury, $resume_pv, $decisions, $id_pv);
    
    $message = $stmt->execute() ? showSuccess('PV mis à jour') : showError('Erreur');
}

// Préparer les données
$pv_data = [
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'semestre' => $semestre,
    'deliberations_list' => $deliberations_list,
    'deliberation_detail' => $deliberation_detail,
    'pv' => $pv,
    'stats' => $stats,
    'message' => $message
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($pv_data);
    exit;
}

// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/proc_s_verbal_de_d_lib_ration_pdf/proces_verbal_de_deliberation.php';

?>
