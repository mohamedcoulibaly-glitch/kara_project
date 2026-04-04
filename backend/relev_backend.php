<?php
/**
 * ====================================================
 * BACKEND: Relevé de Notes Individuelles
 * ====================================================
 * Affiche le relevé de notes détaillé d'un étudiant
 * avec ses notes par UE, EC, et statistiques
 * Paramètres : ?etudiant_id= ou ?id= , optionnel &semestre=1..6
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$db = getDB();

$id_etudiant = (int)($_GET['etudiant_id'] ?? $_GET['id'] ?? ($_POST['id_etudiant'] ?? 0));
$semestre = max(1, min(6, (int)($_GET['semestre'] ?? 1)));

function relevBackendRenderError(string $msg, bool $json): void
{
    if ($json) {
        header('Content-Type: application/json');
        echo json_encode(['erreur' => $msg]);
        exit;
    }
}

if (!$id_etudiant) {
    relevBackendRenderError('ID étudiant manquant (etudiant_id ou id)', isset($_GET['format']) && $_GET['format'] === 'json');
    $etudiant = null;
    $erreur_releve = 'Indiquez un étudiant dans l’URL : <code>?etudiant_id=</code> ou <code>?id=</code>.';
    $parcours = [];
    $moyenne_semestre = 0;
    $credits_obtenus = 0;
    $total_credits = 0;
    $code_verification = '';
    $date_emission = date('Y-m-d');
    $stats_globales = [];
    $releve_par_semestre = [];
    $stats_par_semestre = [];
    $total_credits_parcours = 0;
    $rang_etudiant = 0;
    $total_promotion = 0;
    $situation_pedagogique = '';
    $page_title = 'Relevé de notes';
    $current_page = 'releve';
    if (!defined('FRONTEND_LOADED')) {
        extract(compact(
            'etudiant', 'erreur_releve', 'parcours', 'semestre', 'moyenne_semestre', 'credits_obtenus', 'total_credits',
            'code_verification', 'date_emission', 'stats_globales', 'releve_par_semestre', 'stats_par_semestre',
            'total_credits_parcours', 'rang_etudiant', 'total_promotion', 'situation_pedagogique', 'page_title', 'current_page'
        ));
        include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/relev_de_notes_individuel/relev.php';
    }
    return;
}

$etudiant = $etudiantManager->getById($id_etudiant);

if (!$etudiant) {
    relevBackendRenderError('Étudiant non trouvé', isset($_GET['format']) && $_GET['format'] === 'json');
    $erreur_releve = 'Étudiant introuvable.';
    $parcours = [];
    $moyenne_semestre = 0;
    $credits_obtenus = 0;
    $total_credits = 0;
    $code_verification = '';
    $date_emission = date('Y-m-d');
    $stats_globales = [];
    $releve_par_semestre = [];
    $stats_par_semestre = [];
    $total_credits_parcours = 0;
    $rang_etudiant = 0;
    $total_promotion = 0;
    $situation_pedagogique = '';
    $page_title = 'Relevé de notes';
    $current_page = 'releve';
    if (!defined('FRONTEND_LOADED')) {
        extract(compact(
            'etudiant', 'erreur_releve', 'parcours', 'semestre', 'moyenne_semestre', 'credits_obtenus', 'total_credits',
            'code_verification', 'date_emission', 'stats_globales', 'releve_par_semestre', 'stats_par_semestre',
            'total_credits_parcours', 'rang_etudiant', 'total_promotion', 'situation_pedagogique', 'page_title', 'current_page'
        ));
        include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/relev_de_notes_individuel/relev.php';
    }
    return;
}

// ========================================
// 1. STATISTIQUES GLOBALES
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
$stats_globales = $stmt->get_result()->fetch_assoc() ?: [];

// ========================================
// 2. NOTES PAR SEMESTRE DÉTAILLÉES
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

        if ($note['valeur_note'] !== null && $note['valeur_note'] !== '') {
            $releve_par_semestre[$sem][$ue_code]['notes_ec'][] = $note['valeur_note'];
        }
    }
}

foreach ($releve_par_semestre as &$semestre_ref) {
    foreach ($semestre_ref as &$ue) {
        if (!empty($ue['notes_ec'])) {
            $ue['valeur_ue'] = round(array_sum($ue['notes_ec']) / count($ue['notes_ec']), 2);
            $ue['statut_ue'] = $ue['valeur_ue'] >= 10 ? 'Validée' : 'Non Validée';
        }
    }
}
unset($semestre_ref, $ue);

// ========================================
// 3. CALCULS PAR SEMESTRE
// ========================================
$stats_par_semestre = [];
for ($sem = 1; $sem <= 6; $sem++) {
    if (!isset($releve_par_semestre[$sem])) {
        continue;
    }
    $notes_sem = [];
    $credits_sem = 0;
    $credits_obtenus_sem = 0;

    foreach ($releve_par_semestre[$sem] as $ue) {
        if ($ue['valeur_ue']) {
            $notes_sem[] = $ue['valeur_ue'];
        }
        $credits_sem += (int)$ue['credits_ects'];

        if ($ue['statut_ue'] === 'Validée') {
            $credits_obtenus_sem += (int)$ue['credits_ects'];
        }
    }

    $first_note = !empty($notes_sem) ? $notes_sem[0] : 0;
    $stats_par_semestre[$sem] = [
        'semestre' => $sem,
        'moyenne_semestre' => !empty($notes_sem) ? round(array_sum($notes_sem) / count($notes_sem), 2) : 0,
        'nb_ues' => count($releve_par_semestre[$sem]),
        'ues_validees' => count(array_filter(
            $releve_par_semestre[$sem],
            function ($u) {
                return $u['statut_ue'] === 'Validée';
            }
        )),
        'credits_total' => $credits_sem,
        'credits_obtenus' => $credits_obtenus_sem,
        'statut' => $credits_obtenus_sem >= 30 ? 'Admis' : ($first_note >= 8 ? 'Redoublant' : 'Non Admis')
    ];
}

// ========================================
// 4. RANG
// ========================================
$stmt = $db->prepare("SELECT COUNT(DISTINCT e.id_etudiant) as total_promotion FROM etudiant e WHERE e.id_filiere = ? AND e.statut = 'Actif'");
$stmt->bind_param("i", $etudiant['id_filiere']);
$stmt->execute();
$promotion_result = $stmt->get_result()->fetch_assoc();
$total_promotion = (int)($promotion_result['total_promotion'] ?? 0);

$moy_temp = (float)($stats_globales['moyenne_generale'] ?? 0);
$query_rang_calc = "SELECT COUNT(DISTINCT e.id_etudiant) as rang
FROM etudiant e
LEFT JOIN (
    SELECT n.id_etudiant, AVG(n.valeur_note) as moy
    FROM note n
    WHERE n.session = 'Normale'
    GROUP BY n.id_etudiant
) stats ON e.id_etudiant = stats.id_etudiant
WHERE e.id_filiere = ? AND e.statut = 'Actif' AND stats.moy > ?";

$stmt = $db->prepare($query_rang_calc);
$stmt->bind_param("id", $etudiant['id_filiere'], $moy_temp);
$stmt->execute();
$rang_result = $stmt->get_result()->fetch_assoc();
$rang_etudiant = (int)($rang_result['rang'] ?? 0) + 1;

// ========================================
// 5. SITUATION & DONNÉES VUE RELEV.PHP
// ========================================
$total_credits_parcours = array_sum(array_map(function ($s) {
    return $s['credits_obtenus'] ?? 0;
}, $stats_par_semestre));

$situation_pedagogique = 'En cours';
if ($total_credits_parcours >= 180) {
    $situation_pedagogique = 'Diplômé';
} elseif (($stats_globales['moyenne_generale'] ?? 0) < 8) {
    $situation_pedagogique = 'À risque';
} elseif (($stats_globales['moyenne_generale'] ?? 0) < 10) {
    $situation_pedagogique = 'Redoublant';
}

$ues_list = [];
if (!empty($releve_par_semestre[$semestre])) {
    foreach ($releve_par_semestre[$semestre] as $ue) {
        $notes_rows = [];
        foreach ($ue['elements'] as $el) {
            if ($el['note'] !== null && $el['note'] !== '') {
                $notes_rows[] = [
                    'ec' => $el['nom_ec'],
                    'note' => (float)$el['note'],
                    'session' => $el['session'] ?? 'Normale',
                ];
            }
        }
        $ues_list[] = [
            'code_ue' => $ue['code_ue'],
            'libelle_ue' => $ue['libelle_ue'],
            'coefficient' => null,
            'credits_ects' => (int)$ue['credits_ects'],
            'moyenne_ue' => (float)($ue['valeur_ue'] ?? 0),
            'notes' => $notes_rows,
        ];
    }
}
$parcours = empty($ues_list) ? [] : ['ues' => $ues_list];
$moyenne_semestre = (float)($stats_par_semestre[$semestre]['moyenne_semestre'] ?? 0);
$credits_obtenus = (int)($stats_par_semestre[$semestre]['credits_obtenus'] ?? 0);
$total_credits = (int)($stats_par_semestre[$semestre]['credits_total'] ?? 0);
$code_verification = 'RLV-' . $id_etudiant . '-S' . $semestre . '-' . date('Y');
$date_emission = date('Y-m-d');
$erreur_releve = '';
$page_title = 'Relevé de notes';
$current_page = 'releve';

$releve_data = [
    'etudiant' => $etudiant,
    'stats_globales' => $stats_globales,
    'releve_par_semestre' => $releve_par_semestre,
    'stats_par_semestre' => $stats_par_semestre,
    'credits_totaux_parcours' => $total_credits_parcours,
    'rang_etudiant' => $rang_etudiant,
    'total_promotion' => $total_promotion,
    'situation_pedagogique' => $situation_pedagogique,
    'date_generation' => date('d M Y H:i'),
    'parcours' => $parcours,
    'semestre' => $semestre,
    'moyenne_semestre' => $moyenne_semestre,
    'credits_obtenus' => $credits_obtenus,
    'total_credits' => $total_credits,
    'code_verification' => $code_verification,
    'date_emission' => $date_emission,
    'erreur_releve' => $erreur_releve,
    'page_title' => $page_title,
    'current_page' => $current_page,
];

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($releve_data);
    exit;
}

extract($releve_data);

if (!defined('FRONTEND_LOADED')) {
    include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/relev_de_notes_individuel/relev.php';
}
