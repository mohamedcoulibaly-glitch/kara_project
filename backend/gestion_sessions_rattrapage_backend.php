<?php
/**
 * ====================================================
 * BACKEND: Gestion des Sessions de Rattrapage
 * ====================================================
 * Gère les sessions de rattrapage et les inscriptions
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$db = getDB();
$message = '';
$type_message = '';

// 1. Récupérer les filières pour les filtres
$query = "SELECT id_filiere, nom_filiere FROM filiere ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$stmt->execute();
$filieres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : (isset($filieres[0]) ? $filieres[0]['id_filiere'] : 0);
$semestre = isset($_GET['semestre']) ? (int)$_GET['semestre'] : 1;

// 2. Traiter la création de session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_session') {
    $date_debut = $_POST['date_debut'] ?? date('Y-m-d');
    $date_fin = $_POST['date_fin'] ?? date('Y-m-d', strtotime('+1 week'));
    $id_fil = (int)($_POST['id_filiere'] ?? $id_filiere);
    $desc = $_POST['description'] ?? 'Session de rattrapage';
    
    $query = "INSERT INTO session_rattrapage (date_debut, date_fin, id_filiere, statut, description) VALUES (?, ?, ?, 'Ouverte', ?)";
    $stmt_ins = $db->prepare($query);
    $stmt_ins->bind_param("ssis", $date_debut, $date_fin, $id_fil, $desc);
    
    if ($stmt_ins->execute()) {
        $message = "Session de rattrapage créée avec succès.";
        $type_message = "success";
    } else {
        $message = "Erreur lors de la création de la session.";
        $type_message = "error";
    }
}

// 3. Recherche des étudiants concernés (ceux qui ont échoué au semestre)
$etudiants_rattrapage = [];
if ($id_filiere && $semestre) {
    // On cherche les étudiants ayant une moyenne semestrielle < 10 en session Normale
    $query = "SELECT d.*, e.matricule, e.nom, e.prenom 
              FROM deliberation d
              JOIN etudiant e ON d.id_etudiant = e.id_etudiant
              WHERE e.id_filiere = ? AND d.semestre = ? AND d.moyenne_semestre < 10";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $id_filiere, $semestre);
    $stmt->execute();
    $resultats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    if (empty($resultats)) {
        // Fallback: Si pas de délibération officielle, on calcule en temps réel
        $query_fallback = "SELECT e.id_etudiant, e.matricule, e.nom, e.prenom, 
                           AVG(n.valeur_note) as moyenne_semestre
                           FROM etudiant e
                           JOIN note n ON e.id_etudiant = n.id_etudiant
                           JOIN ec ON n.id_ec = ec.id_ec
                           JOIN ue ON ec.id_ue = ue.id_ue
                           JOIN programme p ON (ue.id_ue = p.id_ue AND p.id_filiere = e.id_filiere)
                           WHERE e.id_filiere = ? AND p.semestre = ? AND n.session = 'Normale'
                           GROUP BY e.id_etudiant
                           HAVING moyenne_semestre < 10";
        $stmt_fb = $db->prepare($query_fallback);
        $stmt_fb->bind_param("ii", $id_filiere, $semestre);
        $stmt_fb->execute();
        $resultats = $stmt_fb->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    foreach ($resultats as $et) {
        // Pour chaque étudiant, on cherche les UE < 10
        $query_ues = "SELECT ue.id_ue, ue.code_ue, ue.libelle_ue, AVG(n.valeur_note) as moyenne_ue
                      FROM note n
                      JOIN ec ON n.id_ec = ec.id_ec
                      JOIN ue ON ec.id_ue = ue.id_ue
                      JOIN programme p ON (ue.id_ue = p.id_ue AND p.id_filiere = ?)
                      WHERE n.id_etudiant = ? AND p.semestre = ? AND n.session = 'Normale'
                      GROUP BY ue.id_ue
                      HAVING moyenne_ue < 10";
        
        $stmt_ue = $db->prepare($query_ues);
        $stmt_ue->bind_param("iii", $id_filiere, $et['id_etudiant'], $semestre);
        $stmt_ue->execute();
        $et['ues_non_validees'] = $stmt_ue->get_result()->fetch_all(MYSQLI_ASSOC);
        
        if (!empty($et['ues_non_validees'])) {
            $etudiants_rattrapage[] = $et;
        }
    }
}

// 4. Récupérer les sessions existantes
$query = "SELECT s.*, f.nom_filiere 
          FROM session_rattrapage s 
          LEFT JOIN filiere f ON s.id_filiere = f.id_filiere 
          ORDER BY s.date_debut DESC";
$stmt = $db->prepare($query);
$stmt->execute();
$sessions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// 5. Statistiques
$stats = [
    'concernés' => count($etudiants_rattrapage),
    'ue_echouees' => 0
];
foreach($etudiants_rattrapage as $et) {
    $stats['ue_echouees'] += count($et['ues_non_validees']);
}

// Données pour la vue
$rattrapage_data = [
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'semestre' => $semestre,
    'etudiants_rattrapage' => $etudiants_rattrapage,
    'sessions' => $sessions,
    'stats' => $stats,
    'message' => $message,
    'type_message' => $type_message
];

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($rattrapage_data);
    exit;
}

extract($rattrapage_data);
if (!defined('FRONTEND_LOADED')) {
    include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/gestion_des_sessions_de_rattrapage/gestion_des_sessions_de_rattrapage.php';
}
?>
