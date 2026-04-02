<?php
/**
 * ====================================================
 * BACKEND: Gestion des Délibérations Finales
 * ====================================================
 * Gère les délibérations académiques
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$noteManager = new NoteManager();
$deliberationManager = new DeliberationManager();
$db = getDB();

// Récupérer les paramètres
$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$semestre = isset($_GET['semestre']) ? (int)$_GET['semestre'] : 1;
$session = isset($_GET['session']) ? clean($_GET['session']) : 'Session Normale';

// Récupérer les filières
$query = "SELECT * FROM filiere ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$stmt->execute();
$filieres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Si pas de filière sélectionnée, prendre la première
if (!$id_filiere && !empty($filieres)) {
    $id_filiere = $filieres[0]['id_filiere'];
}

// Récupérer les étudiants de la filière
$etudiants_stats = [];
if ($id_filiere) {
    $query = "SELECT 
                e.id_etudiant,
                e.matricule,
                e.nom,
                e.prenom,
                f.nom_filiere,
                AVG(n.valeur_note) as moyenne_semestre,
                COUNT(DISTINCT CASE WHEN n.valeur_note >= 10 THEN n.id_ec END) as ues_validees,
                COUNT(DISTINCT n.id_ec) as ues_tentees
              FROM etudiant e
              LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
              LEFT JOIN note n ON e.id_etudiant = n.id_etudiant 
                               AND n.session = 'Normale'
              LEFT JOIN ec ON n.id_ec = ec.id_ec
              LEFT JOIN ue ON ec.id_ue = ue.id_ue
              LEFT JOIN programme p ON ue.id_ue = p.id_ue 
                                    AND p.id_filiere = e.id_filiere
                                    AND p.semestre = ?
              WHERE e.id_filiere = ?
              GROUP BY e.id_etudiant
              ORDER BY moyenne_semestre DESC";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $semestre, $id_filiere);
    $stmt->execute();
    $etudiants_stats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Compter les statistiques
$stats = [
    'total_etudiants' => count($etudiants_stats),
    'admis' => 0,
    'redoublants' => 0,
    'ajournes' => 0
];

foreach ($etudiants_stats as &$et) {
    $et['statut_deliberation'] = 'En attente';
    $et['mention'] = getMention($et['moyenne_semestre'] ?? 0);
    
    if ($et['moyenne_semestre'] >= 10) {
        $et['statut_deliberation'] = 'Admis';
        $stats['admis']++;
    } elseif ($et['moyenne_semestre'] >= 8) {
        $et['statut_deliberation'] = 'Redoublant';
        $stats['redoublants']++;
    } else {
        $et['statut_deliberation'] = 'Ajourné';
        $stats['ajournes']++;
    }
}

// Traiter les créations de délibérations
$message = '';
$message_type = '';

// Traiter la sauvegarde d'une délibération unique (depuis la table)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_deliberation') {
    $id_etudiant = (int)($_POST['id_etudiant'] ?? 0);
    $statut = clean($_POST['statut'] ?? 'En attente');
    $moyenne_semestre = (float)($_POST['moyenne_semestre'] ?? 0);
    $code_deliberation = clean($_POST['code_deliberation'] ?? '');
    
    if ($id_etudiant && $id_filiere && $semestre) {
        $mention = getMention($moyenne_semestre);
        $credits_obtenus = ($moyenne_semestre >= 10) ? 60 : 0; // 6 UE * 6 crédits par UE
        
        $data = [
            'moyenne_semestre' => $moyenne_semestre,
            'statut' => $statut,
            'mention' => $mention,
            'credits_obtenus' => $credits_obtenus,
            'responsable_deliberation' => $_SESSION['user_name'] ?? 'Admin',
            'observations' => "Délibération du semestre $semestre - Filière $id_filiere"
        ];
        
        if ($deliberationManager->create($id_etudiant, $semestre, $data)) {
            $message_success = "✅ Délibération enregistrée avec succès (Statut: $statut)";
        } else {
            $message_success = "❌ Erreur lors de l'enregistrement";
        }
    } else {
        $message_success = "❌ Données invalides";
    }
    
    // Rediriger avec les paramètres de contexte
    header("Location: " . BASE_URL . "/backend/deliberation_backend.php?filiere=$id_filiere&semestre=$semestre&msg=" . urlencode($message_success));
    exit;
}

// Traiter les créations en bulk de délibérations
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_deliberations') {
    $ids_etudiant = isset($_POST['ids_etudiant']) ? $_POST['ids_etudiant'] : [];
    $responsable = postParam('responsable_deliberation', 'Admin Académique');
    $date_deliberation = postParam('date_deliberation', date('Y-m-d'));
    
    $count_created = 0;
    foreach ($ids_etudiant as $id_et) {
        $id_et = (int)$id_et;
        // Trouver les stats de l'étudiant
        $et_stat = array_filter($etudiants_stats, function($e) use ($id_et) {
            return $e['id_etudiant'] === $id_et;
        });
        
        if (!empty($et_stat)) {
            $et = array_values($et_stat)[0];
            $data = [
                'moyenne_semestre' => $et['moyenne_semestre'],
                'statut' => $et['statut_deliberation'],
                'mention' => $et['mention'],
                'credits_obtenus' => $et['ues_validees'] * 6, // Approximation
                'responsable_deliberation' => $responsable,
                'observations' => "Délibération du semestre $semestre"
            ];
            
            if ($deliberationManager->create($id_et, $semestre, $data)) {
                $count_created++;
            }
        }
    }
    
    $message = "$count_created délibérations créées avec succès";
    $message_type = 'success';
}

// Récupérer les messages depuis GET (après redirection)
if (isset($_GET['msg'])) {
    $message = $_GET['msg'];
    $message_type = 'success';
}

// Préparer les données
$deliberation_data = [
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'semestre' => $semestre,
    'session' => $session,
    'etudiants' => $etudiants_stats,
    'stats' => $stats,
    'message' => $message
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($deliberation_data);
    exit;
}

$etudiants = $etudiants_stats;
extract($deliberation_data);
// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/d_lib_ration_finale_acad_mique/deliberation_final_academique.php';

?>
