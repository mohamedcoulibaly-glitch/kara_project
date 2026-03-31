<?php
/**
 * ====================================================
 * BACKEND: Gestion des Sessions de Rattrapage
 * ====================================================
 * Gère les sessions de rattrapage et les inscriptions
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$sessionRattrapageManager = new SessionRattrapageManager();
$etudiantManager = new EtudiantManager();
$db = getDB();

// Récupérer les sessions de rattrapage
$sessions = $sessionRattrapageManager->getAll();

// Récupérer les statistiques globales
$query = "SELECT 
            COUNT(DISTINCT s.id_session) as nb_sessions,
            SUM(CASE WHEN s.statut = 'En cours' THEN 1 ELSE 0 END) as sessions_actives,
            COUNT(DISTINCT ir.id_inscription) as total_inscrits,
            COUNT(DISTINCT CASE WHEN ir.statut = 'Participé' THEN ir.id_inscription END) as participants
          FROM session_rattrapage s
          LEFT JOIN inscription_rattrapage ir ON s.id_session = ir.id_session";

$stmt = $db->prepare($query);
$stmt->execute();
$stats_globales = $stmt->get_result()->fetch_assoc();

// Détails des sessions avec inscrits
$sessions_details = [];
foreach ($sessions as $session) {
    $inscrits = $sessionRattrapageManager->getInscrits($session['id_session']);
    $session['inscrits'] = $inscrits;
    $session['nb_inscrits'] = count($inscrits);
    $sessions_details[] = $session;
}

// Traiter la création de session
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_session') {
    $data = [
        'date_debut' => postParam('date_debut'),
        'date_fin' => postParam('date_fin'),
        'id_filiere' => (int)postParam('id_filiere'),
        'statut' => 'Programmée',
        'description' => postParam('description')
    ];
    
    if ($sessionRattrapageManager->create($data)) {
        $message = showSuccess('Session créée avec succès');
    }
}

// Traiter l'inscription des étudiants
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'inscription') {
    $id_etudiant = (int)postParam('id_etudiant');
    $id_session = (int)postParam('id_session');
    $ids_ec = isset($_POST['ids_ec']) ? $_POST['ids_ec'] : [];
    
    $count = 0;
    foreach ($ids_ec as $id_ec) {
        if ($sessionRattrapageManager->inscribeEtudiant($id_etudiant, $id_session, (int)$id_ec)) {
            $count++;
        }
    }
    
    $message = showSuccess("Étudiant inscrit à $count EC(s)");
}

// Préparer les données
$rattrapage_data = [
    'sessions' => $sessions_details,
    'stats' => $stats_globales,
    'message' => $message
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($rattrapage_data);
    exit;
}

// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/gestion_des_sessions_de_rattrapage/gestion_des_sessions_de_rattrapage.php';

?>
