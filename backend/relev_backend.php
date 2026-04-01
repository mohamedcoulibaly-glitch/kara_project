<?php
/**
 * ====================================================
 * BACKEND: Relevé de Notes Individuelles
 * ====================================================
 * Affiche le relevé de notes détaillé d'un étudiant
 * avec ses notes par UE, EC, et statistiques
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$noteManager = new NoteManager();
$db = getDB();

// Récupérer l'ID de l'étudiant
$id_etudiant = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_POST['id_etudiant']) ? (int)$_POST['id_etudiant'] : 0);

if (!$id_etudiant) {
    die(json_encode(['erreur' => 'ID étudiant manquant']));
}

// ========================================
// 1. INFORMATIONS ÉTUDIANT
// ========================================
$etudiant = $etudiantManager->getById($id_etudiant);

if (!$etudiant) {
    die(json_encode(['erreur' => 'Étudiant non trouvé']));
}

// ========================================
// 2. STATISTIQUES GLOBALES
// ========================================
$query_stats = "SELECT 
    ROUND(AVG(n.valeur_note), 2) as moyenne_generale,
    COUNT(DISTINCT CASE WHEN n.valeur_note >= 10 THEN sem.semestre END) as semestres_reussis,
    SUM(CASE WHEN n.valeur_note >= 10 THEN ue.credits_ects ELSE 0 END) as credits_obtenus,
    COUNT(DISTINCT ue.id_ue) as nb_ues_evaluees,
    COUNT(DISTINCT n.id_note) as total_notes,
    MIN(n.valeur_note) as note_min,
    MAX(n.valeur_note) as note_max,
    STDDEV(n.valeur_note) as ecart_type
FROM note n
JOIN ec ON n.id_ec = ec.id_ec
JOIN ue ON ec.id_ue = ue.id_ue
JOIN programme sem ON (ue.id_ue = sem.id_ue)
WHERE n.id_etudiant = ? AND n.session = 'Normale'";

$stmt = $db->prepare($query_stats);
$stmt->bind_param("i", $id_etudiant);
$stmt->execute();
$stats_globales = $stmt->get_result()->fetch_assoc();

// ========================================
// 3. NOTES PAR SEMESTRE DÉTAILLÉES
// ========================================
$query_semestres = "SELECT 
    p.semestre,
    ue.id_ue,
    ue.code_ue,
    ue.libelle_ue,
    ue.credits_ects,
    ec.id_ec,
    ec.code_ec,
    ec.nom_ec,
    n.valeur_note,
    n.date_examen,
    n.session,
    CASE 
        WHEN n.valeur_note >= 16 THEN 'Très Bien'
        WHEN n.valeur_note >= 14 THEN 'Bien'
        WHEN n.valeur_note >= 12 THEN 'Assez Bien'
        WHEN n.valeur_note >= 10 THEN 'Passable'
        ELSE 'Non Validé'
    END as mention_note,
    CASE 
        WHEN n.valeur_note >= 10 THEN 'Validée'
        ELSE 'Non Validée'
    END as statut_ue
FROM ue
JOIN programme p ON ue.id_ue = p.id_ue
LEFT JOIN ec ON ue.id_ue = ec.id_ue
LEFT JOIN note n ON (ec.id_ec = n.id_ec AND n.id_etudiant = ? AND n.session = 'Normale')
WHERE p.id_filiere = ?
ORDER BY p.semestre ASC, ue.code_ue ASC, ec.code_ec ASC";

$stmt = $db->prepare($query_semestres);
$stmt->bind_param("ii", $id_etudiant, $etudiant['id_filiere']);
$stmt->execute();
$notes_detaillees = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Grouper les notes par semestre et UE
$releve_par_semestre = [];
foreach ($notes_detaillees as $note) {
    $sem = $note['semestre'];
    $ue_code = $note['code_ue'];
    
    if (!isset($releve_par_semestre[$sem])) {
        $releve_par_semestre[$sem] = [];
    }
    
    if (!isset($releve_par_semestre[$sem][$ue_code])) {
        $releve_par_semestre[$sem][$ue_code] = [
            'id_ue' => $note['id_ue'],
            'code_ue' => $note['code_ue'],
            'libelle_ue' => $note['libelle_ue'],
            'credits_ects' => $note['credits_ects'],
            'elements' => [],
            'notes_ec' => [],
            'valeur_ue' => null,
            'statut_ue' => null
        ];
    }
    
    if ($note['code_ec']) {
        $releve_par_semestre[$sem][$ue_code]['elements'][] = [
            'id_ec' => $note['id_ec'],
            'code_ec' => $note['code_ec'],
            'nom_ec' => $note['nom_ec'],
            'note' => $note['valeur_note'],
            'mention' => $note['mention_note'],
            'date_examen' => $note['date_examen'],
            'session' => $note['session']
        ];
        
        if ($note['valeur_note']) {
            $releve_par_semestre[$sem][$ue_code]['notes_ec'][] = $note['valeur_note'];
        }
    }
}

// Calculer les moyennes et statuts par UE
foreach ($releve_par_semestre as &$semestre) {
    foreach ($semestre as &$ue) {
        if (!empty($ue['notes_ec'])) {
            $ue['valeur_ue'] = round(array_sum($ue['notes_ec']) / count($ue['notes_ec']), 2);
            $ue['statut_ue'] = $ue['valeur_ue'] >= 10 ? 'Validée' : 'Non Validée';
        }
    }
}

// ========================================
// 4. CALCULS PAR SEMESTRE
// ========================================
$stats_par_semestre = [];
for ($sem = 1; $sem <= 6; $sem++) {
    if (isset($releve_par_semestre[$sem])) {
        $notes_sem = [];
        $credits_sem = 0;
        $credits_obtenus_sem = 0;
        
        foreach ($releve_par_semestre[$sem] as $ue) {
            if ($ue['valeur_ue']) {
                $notes_sem[] = $ue['valeur_ue'];
            }
            $credits_sem += $ue['credits_ects'];
            
            if ($ue['statut_ue'] === 'Validée') {
                $credits_obtenus_sem += $ue['credits_ects'];
            }
        }
        
        $stats_par_semestre[$sem] = [
            'semestre' => $sem,
            'moyenne_semestre' => !empty($notes_sem) ? round(array_sum($notes_sem) / count($notes_sem), 2) : 0,
            'nb_ues' => count($releve_par_semestre[$sem]),
            'ues_validees' => count(array_filter($releve_par_semestre[$sem], 
                function($u) { return $u['statut_ue'] === 'Validée'; })),
            'credits_total' => $credits_sem,
            'credits_obtenus' => $credits_obtenus_sem,
            'statut' => $credits_obtenus_sem >= 30 ? 'Admis' : ($notes_sem[0] >= 8 ? 'Redoublant' : 'Non Admis')
        ];
    }
}

// ========================================
// 5. RANG ET POSITION
// ========================================
$query_rang = "SELECT 
    COUNT(DISTINCT e.id_etudiant) as total_promotion
FROM etudiant e
WHERE e.id_filiere = ? AND e.statut = 'Actif'";

$stmt = $db->prepare($query_rang);
$stmt->bind_param("i", $etudiant['id_filiere']);
$stmt->execute();
$promotion_result = $stmt->get_result()->fetch_assoc();
$total_promotion = $promotion_result['total_promotion'] ?? 0;

// Calculer le rang de l'étudiant
$query_rang_calc = "SELECT COUNT(DISTINCT e.id_etudiant) as rang
FROM etudiant e
LEFT JOIN (
    SELECT n.id_etudiant, AVG(n.valeur_note) as moy
    FROM note n
    WHERE n.session = 'Normale'
    GROUP BY n.id_etudiant
) stats ON e.id_etudiant = stats.id_etudiant
WHERE e.id_filiere = ? AND e.statut = 'Actif' AND stats.moy > ?";

$moy_temp = $stats_globales['moyenne_generale'] ?? 0;
$stmt = $db->prepare($query_rang_calc);
$stmt->bind_param("id", $etudiant['id_filiere'], $moy_temp);
$stmt->execute();
$rang_result = $stmt->get_result()->fetch_assoc();
$rang_etudiant = ($rang_result['rang'] ?? 0) + 1;

// ========================================
// 6. SITUATION PÉDAGOGIQUE
// ========================================
$total_credits = array_sum(array_map(function($s) { 
    return $s['credits_obtenus'] ?? 0; 
}, $stats_par_semestre));

$situation = 'En cours';
if ($total_credits >= 180) {
    $situation = 'Diplômé';
} elseif ($stats_globales['moyenne_generale'] < 8) {
    $situation = 'À risque';
} elseif ($stats_globales['moyenne_generale'] < 10) {
    $situation = 'Redoublant';
}

// ========================================
// PRÉPARER LES DONNÉES
// ========================================
$releve_data = [
    'etudiant' => $etudiant,
    'stats_globales' => $stats_globales,
    'releve_par_semestre' => $releve_par_semestre,
    'stats_par_semestre' => $stats_par_semestre,
    'total_credits' => $total_credits,
    'rang_etudiant' => $rang_etudiant,
    'total_promotion' => $total_promotion,
    'situation_pedagogique' => $situation,
    'date_generation' => date('d M Y H:i')
];

// ========================================
// RETOURNER LES DONNÉES
// ========================================

// Si AJAX appelé au format JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($releve_data);
    exit;
}

// Sinon inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/relev_de_notes_individuel/relev.php';

?>
