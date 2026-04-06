<?php
/**
 * ====================================================
 * BACKEND: Rapport Synthèse Académique par Département
 * ====================================================
 * Génère des rapports avec statistiques académiques
 * et taux de réussite par département et filière
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

// Vérifier l'authentification
if (!isset($_SESSION['user_id'])) {
    header("Location: " . BASE_URL . "/login.php?error=session_expiree");
    exit;
}

$db = getDB();

// Récupérer les paramètres
$id_dept = isset($_GET['id_dept']) ? (int)$_GET['id_dept'] : 0;
$annee_academique = isset($_GET['annee']) ? $_GET['annee'] : date('Y') . '-' . (date('Y') + 1);
$session = isset($_GET['session']) ? $_GET['session'] : 'Normale';

// Récupérer tous les départements
$query_depts = "SELECT * FROM departement ORDER BY nom_dept";
$stmt = $db->prepare($query_depts);
$stmt->execute();
$departements = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Si aucun département n'est spécifié, prendre le premier
if (!$id_dept && !empty($departements)) {
    $id_dept = $departements[0]['id_dept'];
}

// ========================================
// 1. RÉSUMÉ EXÉCUTIF - Statistiques globales
// ========================================
$query_resume = "SELECT 
    COUNT(DISTINCT e.id_etudiant) as total_etudiants,
    COUNT(DISTINCT CASE WHEN n.valeur_note >= 10 THEN e.id_etudiant END) as etudiants_reussis,
    AVG(n.valeur_note) as moyenne_generale,
    COUNT(DISTINCT f.id_filiere) as nb_filieres,
    COUNT(DISTINCT ue.id_ue) as nb_ues,
    COUNT(DISTINCT ec.id_ec) as nb_ecs
FROM departement d
LEFT JOIN filiere f ON d.id_dept = f.id_dept
LEFT JOIN etudiant e ON f.id_filiere = e.id_filiere
LEFT JOIN note n ON e.id_etudiant = n.id_etudiant AND n.session = ?
LEFT JOIN ec ON n.id_ec = ec.id_ec
LEFT JOIN ue ON ec.id_ue = ue.id_ue
WHERE d.id_dept = ?";

$stmt = $db->prepare($query_resume);
$stmt->bind_param("si", $session, $id_dept);
$stmt->execute();
$resume = $stmt->get_result()->fetch_assoc();

// Calculer le taux de réussite
$taux_reussite = ($resume['total_etudiants'] > 0) 
    ? ceil(($resume['etudiants_reussis'] / $resume['total_etudiants']) * 100) 
    : 0;

// ========================================
// 2. STATISTIQUES PAR FILIÈRE
// ========================================
$query_filieres = "SELECT 
    f.id_filiere,
    f.nom_filiere,
    f.code_filiere,
    COUNT(DISTINCT e.id_etudiant) as effectif,
    COUNT(DISTINCT CASE WHEN n.valeur_note >= 10 THEN e.id_etudiant END) as reussis,
    AVG(n.valeur_note) as moyenne_filiere,
    MIN(n.valeur_note) as note_min,
    MAX(n.valeur_note) as note_max,
    STDDEV(n.valeur_note) as ecart_type
FROM filiere f
LEFT JOIN etudiant e ON f.id_filiere = e.id_filiere AND e.statut = 'Actif'
LEFT JOIN note n ON e.id_etudiant = n.id_etudiant AND n.session = ?
WHERE f.id_dept = ?
GROUP BY f.id_filiere
ORDER BY f.nom_filiere";

$stmt = $db->prepare($query_filieres);
$stmt->bind_param("si", $session, $id_dept);
$stmt->execute();
$filieres_stats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculer taux de validation par filière
foreach ($filieres_stats as &$filiere) {
    $filiere['taux_validation'] = ($filiere['effectif'] > 0) 
        ? ceil(($filiere['reussis'] / $filiere['effectif']) * 100) 
        : 0;
}

// ========================================
// 3. DISTRIBUTION DES MENTIONS
// ========================================
$query_mentions = "SELECT 
    mention,
    COUNT(*) as nombre_etudiants,
    ROUND(AVG(moy_etudiant), 2) as moyenne_mention
FROM (
    SELECT 
        e.id_etudiant,
        ROUND(AVG(n.valeur_note), 2) as moy_etudiant,
        CASE 
            WHEN ROUND(AVG(n.valeur_note), 2) >= 16 THEN 'Très Bien'
            WHEN ROUND(AVG(n.valeur_note), 2) >= 14 THEN 'Bien'
            WHEN ROUND(AVG(n.valeur_note), 2) >= 12 THEN 'Assez Bien'
            WHEN ROUND(AVG(n.valeur_note), 2) >= 10 THEN 'Passable'
            ELSE 'Non Admis'
        END as mention
    FROM etudiant e
    LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
    LEFT JOIN note n ON e.id_etudiant = n.id_etudiant AND n.session = ?
    WHERE e.statut = 'Actif' AND f.id_dept = ?
    GROUP BY e.id_etudiant
) temp
GROUP BY mention
ORDER BY CASE mention
    WHEN 'Très Bien' THEN 1
    WHEN 'Bien' THEN 2
    WHEN 'Assez Bien' THEN 3
    WHEN 'Passable' THEN 4
    ELSE 5
END";

$stmt = $db->prepare($query_mentions);
$stmt->bind_param("si", $session, $id_dept);
$stmt->execute();
$mentions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// ========================================
// 4. TOP ÉTUDIANTS (Meilleures moyennes)
// ========================================
$query_top_etudiants = "SELECT 
    e.id_etudiant,
    e.matricule,
    e.nom,
    e.prenom,
    f.nom_filiere,
    ROUND(AVG(n.valeur_note), 2) as moyenne_etudiant,
    COUNT(DISTINCT n.id_note) as nb_notes
FROM etudiant e
LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
LEFT JOIN note n ON e.id_etudiant = n.id_etudiant AND n.session = ?
WHERE e.statut = 'Actif' AND f.id_dept = ?
GROUP BY e.id_etudiant
HAVING nb_notes > 0
ORDER BY moyenne_etudiant DESC
LIMIT 10";

$stmt = $db->prepare($query_top_etudiants);
$stmt->bind_param("si", $session, $id_dept);
$stmt->execute();
$top_etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// ========================================
// 5. ANALYSE PAR SEMESTRE
// ========================================
$query_semestres = "SELECT 
    p.semestre,
    COUNT(DISTINCT e.id_etudiant) as total_sem,
    COUNT(DISTINCT CASE WHEN n.valeur_note >= 10 THEN e.id_etudiant END) as admis_sem,
    ROUND(AVG(n.valeur_note), 2) as moyenne_sem,
    COUNT(DISTINCT ue.id_ue) as nb_ues_sem
FROM programme p
LEFT JOIN ue ON p.id_ue = ue.id_ue
LEFT JOIN ec ON ue.id_ue = ec.id_ue
LEFT JOIN note n ON ec.id_ec = n.id_ec AND n.session = ?
LEFT JOIN etudiant e ON n.id_etudiant = e.id_etudiant
LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
WHERE f.id_dept = ? AND e.statut = 'Actif'
GROUP BY p.semestre
ORDER BY p.semestre ASC";

$stmt = $db->prepare($query_semestres);
$stmt->bind_param("si", $session, $id_dept);
$stmt->execute();
$semestres_stats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculer taux d'admission par semestre
foreach ($semestres_stats as &$sem) {
    $sem['taux_admission'] = ($sem['total_sem'] > 0) 
        ? ceil(($sem['admis_sem'] / $sem['total_sem']) * 100) 
        : 0;
}

// ========================================
// 6. STATISTIQUES DÉTAILLÉES PAR UE
// ========================================
$query_ues = "SELECT 
    ue.id_ue,
    ue.code_ue,
    ue.libelle_ue,
    ue.credits_ects,
    COUNT(DISTINCT n.id_note) as nb_notes,
    ROUND(AVG(n.valeur_note), 2) as moyenne_ue,
    COUNT(DISTINCT CASE WHEN n.valeur_note >= 10 THEN n.id_etudiant END) as reussis_ue,
    COUNT(DISTINCT CASE WHEN n.valeur_note < 10 THEN n.id_etudiant END) as echoues_ue
FROM ue
LEFT JOIN ec ON ue.id_ue = ec.id_ue
LEFT JOIN note n ON ec.id_ec = n.id_ec AND n.session = ?
LEFT JOIN etudiant e ON n.id_etudiant = e.id_etudiant
LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
WHERE (f.id_dept = ? OR ue.id_dept = ?) AND (e.statut = 'Actif' OR e.statut IS NULL)
GROUP BY ue.id_ue
ORDER BY ue.code_ue ASC";

$stmt = $db->prepare($query_ues);
$stmt->bind_param("sii", $session, $id_dept, $id_dept);
$stmt->execute();
$ues_stats = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// ========================================
// 7. ÉVOLUTION TEMPORELLE
// ========================================
$query_evolution = "SELECT 
    DATE_FORMAT(n.date_examen, '%Y-%m') as mois,
    COUNT(DISTINCT e.id_etudiant) as nb_candidats,
    COUNT(DISTINCT CASE WHEN n.valeur_note >= 10 THEN e.id_etudiant END) as admis,
    ROUND(AVG(n.valeur_note), 2) as moyenne_mois
FROM note n
LEFT JOIN etudiant e ON n.id_etudiant = e.id_etudiant
LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
WHERE f.id_dept = ? AND n.session = ? AND (e.statut = 'Actif' OR e.statut IS NULL)
GROUP BY mois
ORDER BY mois DESC
LIMIT 12";

$stmt = $db->prepare($query_evolution);
$stmt->bind_param("is", $id_dept, $session);
$stmt->execute();
$evolution = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// ========================================
// PRÉPARER LES DONNÉES
// ========================================
$rapport_data = [
    'departements' => $departements,
    'id_dept' => $id_dept,
    'annee_academique' => $annee_academique,
    'session' => $session,
    'resume' => $resume,
    'taux_reussite' => $taux_reussite,
    'filieres_stats' => $filieres_stats,
    'mentions' => $mentions,
    'top_etudiants' => $top_etudiants,
    'semestres_stats' => $semestres_stats,
    'ues_stats' => $ues_stats,
    'evolution' => $evolution,
    'date_generation' => date('d M Y')
];

// ========================================
// RETOURNER LES DONNÉES
// ========================================

// Export téléchargeable (HTML imprimable en PDF depuis le navigateur — pas de lib mPDF/TCPDF dans le dépôt)
if (!empty($_GET['download']) && (string)$_GET['download'] === '1') {
    header('Content-Type: text/html; charset=UTF-8');
    header('Content-Disposition: attachment; filename="rapport_synthese_' . date('Y-m-d') . '.html"');
    extract($rapport_data);
    $nom_dept = '';
    foreach ($departements as $d) {
        if ((int)$d['id_dept'] === (int)$id_dept) {
            $nom_dept = $d['nom_dept'] ?? '';
            break;
        }
    }
    ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Rapport synthèse — <?= htmlspecialchars($nom_dept) ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #222; }
        h1 { color: #003fb1; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px; font-size: 12px; text-align: left; }
        th { background: #f0f4f8; }
        .meta { color: #666; font-size: 13px; margin-bottom: 24px; }
    </style>
</head>
<body>
    <h1>Rapport académique par département</h1>
    <p class="meta">Département : <strong><?= htmlspecialchars($nom_dept) ?></strong> — Année : <?= htmlspecialchars($annee_academique) ?> — Session : <?= htmlspecialchars($session) ?> — Généré le <?= htmlspecialchars($date_generation) ?></p>
    <p>Taux de réussite global (indicateur synthétique) : <strong><?= (int)$taux_reussite ?> %</strong></p>
    <h2>Effectifs et moyennes par filière</h2>
    <table>
        <thead><tr><th>Filière</th><th>Effectif</th><th>Réussis</th><th>Moyenne</th><th>Taux validation</th></tr></thead>
        <tbody>
        <?php foreach ($filieres_stats as $f): ?>
            <tr>
                <td><?= htmlspecialchars($f['nom_filiere'] ?? '') ?></td>
                <td><?= (int)($f['effectif'] ?? 0) ?></td>
                <td><?= (int)($f['reussis'] ?? 0) ?></td>
                <td><?= htmlspecialchars((string)round($f['moyenne_filiere'] ?? 0, 2)) ?></td>
                <td><?= (int)($f['taux_validation'] ?? 0) ?> %</td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p style="margin-top:32px;font-size:11px;color:#888;">Document généré par le portail LMD — pour obtenir un PDF, ouvrez ce fichier et utilisez « Imprimer » puis « Enregistrer au format PDF ».</p>
</body>
</html>
    <?php
    exit;
}

// Si AJAX appelé au format JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($rapport_data);
    exit;
}

// ========================================
// GESTION MAQUETTE LMD PDF
// ========================================
if (isset($_GET['type']) && $_GET['type'] === 'maquette') {
    $id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
    $semestre = isset($_GET['semestre']) ? (int)$_GET['semestre'] : 1;
    
    // Récupérer les infos de la filière
    $query = "SELECT f.*, d.nom_dept FROM filiere f LEFT JOIN departement d ON f.id_dept = d.id_dept WHERE f.id_filiere = ?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    $stmt->execute();
    $filiere_info = $stmt->get_result()->fetch_assoc();
    
    // Récupérer la maquette
    $query = "SELECT 
                ue.id_ue,
                ue.code_ue,
                ue.libelle_ue,
                ue.credits_ects,
                ue.coefficient,
                ue.volume_horaire,
                (SELECT GROUP_CONCAT(ec.nom_ec SEPARATOR ', ') FROM ec WHERE ec.id_ue = ue.id_ue) as elements
              FROM programme p
              JOIN ue ON p.id_ue = ue.id_ue
              WHERE p.id_filiere = ? AND p.semestre = ?
              ORDER BY ue.code_ue";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $id_filiere, $semestre);
    $stmt->execute();
    $maquette_items = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Calculer les totaux
    $total_credits = array_sum(array_column($maquette_items, 'credits_ects'));
    $total_heures = array_sum(array_column($maquette_items, 'volume_horaire'));
    
    // Export HTML pour PDF
    if (!empty($_GET['download']) && $_GET['download'] === '1') {
        header('Content-Type: text/html; charset=UTF-8');
        header('Content-Disposition: attachment; filename="maquette_' . ($filiere_info['nom_filiere'] ?? 'lmd') . '_s' . $semestre . '_' . date('Y-m-d') . '.html"');
        ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Maquette LMD - <?= htmlspecialchars($filiere_info['nom_filiere'] ?? '') ?> - Semestre <?= $semestre ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 24px; color: #222; }
        h1 { color: #003fb1; font-size: 24px; }
        h2 { color: #333; font-size: 18px; margin-top: 24px; }
        table { border-collapse: collapse; width: 100%; margin-top: 16px; }
        th, td { border: 1px solid #ccc; padding: 8px 12px; font-size: 12px; text-align: left; }
        th { background: #f0f4f8; font-weight: bold; }
        .meta { color: #666; font-size: 13px; margin-bottom: 24px; }
        .total-row { background: #1e293b; color: white; font-weight: bold; }
        .header-info { background: #f8fafc; padding: 16px; border-radius: 8px; margin-bottom: 24px; }
    </style>
</head>
<body>
    <div class="header-info">
        <h1>Maquette Pédagogique LMD</h1>
        <p class="meta">
            <strong>Filière :</strong> <?= htmlspecialchars($filiere_info['nom_filiere'] ?? '') ?><br>
            <strong>Département :</strong> <?= htmlspecialchars($filiere_info['nom_dept'] ?? 'N/A') ?><br>
            <strong>Semestre :</strong> <?= $semestre ?><br>
            <strong>Date de génération :</strong> <?= date('d/m/Y H:i') ?>
        </p>
    </div>

    <h2>Unités d'Enseignement</h2>
    <table>
        <thead>
            <tr>
                <th>Code UE</th>
                <th>Libellé</th>
                <th>Crédits ECTS</th>
                <th>Coefficient</th>
                <th>Volume Horaire</th>
                <th>Éléments Constitutifs</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($maquette_items as $ue): ?>
            <tr>
                <td><?= htmlspecialchars($ue['code_ue'] ?? '') ?></td>
                <td><?= htmlspecialchars($ue['libelle_ue'] ?? '') ?></td>
                <td style="text-align:center; font-weight:bold;"><?= (int)$ue['credits_ects'] ?></td>
                <td style="text-align:center;"><?= number_format($ue['coefficient'] ?? 0, 1) ?></td>
                <td style="text-align:center;"><?= (int)$ue['volume_horaire'] ?>h</td>
                <td><?= htmlspecialchars($ue['elements'] ?? 'Aucun') ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2">TOTAL SEMESTRE <?= $semestre ?></td>
                <td style="text-align:center;"><?= $total_credits ?> ECTS</td>
                <td></td>
                <td style="text-align:center;"><?= $total_heures ?>h</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <p style="margin-top:32px;font-size:11px;color:#888;">
        Document généré par le portail LMD — pour obtenir un PDF, ouvrez ce fichier et utilisez « Imprimer » puis « Enregistrer au format PDF ».
    </p>
</body>
</html>
        <?php
        exit;
    }
    
    // Rediriger vers le téléchargement
    header('Location: rapport_pdf_backend.php?type=maquette&filiere=' . $id_filiere . '&semestre=' . $semestre . '&download=1');
    exit;
}

// Récupérer les informations du département courant
$departement_info = null;
foreach ($departements as $d) {
    if ((int)$d['id_dept'] === (int)$id_dept) {
        $departement_info = $d;
        break;
    }
}

// Préparer les variables attendues par le frontend
$stats_globales = [
    'total_inscrits' => $resume['total_etudiants'] ?? 0,
    'admis' => $resume['etudiants_reussis'] ?? 0,
    'total_filieres' => $resume['nb_filieres'] ?? 0
];

$taux_reussite_filiere = [];
foreach ($filieres_stats as $f) {
    $taux_reussite_filiere[] = [
        'filiere' => $f['nom_filiere'] ?? 'Inconnue',
        'taux' => $f['taux_validation'] ?? 0,
        'admis' => $f['reussis'] ?? 0,
        'total' => $f['effectif'] ?? 0
    ];
}

$repartition_statuts = [];
foreach ($mentions as $m) {
    $statut = 'ADMIS';
    if ($m['mention'] === 'Non Admis') {
        $statut = 'AJOURNE';
    } elseif ($m['moyenne_mention'] >= 10 && $m['moyenne_mention'] < 12) {
        $statut = 'ADMIS';
    }
    $repartition_statuts[] = [
        'statut_deliberation' => $statut,
        'total' => $m['nombre_etudiants'] ?? 0
    ];
}

// Note: $top_etudiants is already in the correct format from the query
// The frontend expects $top_etudiants with fields: nom, prenom, matricule, nom_filiere, moyenne_semestre, mention

// Define date_generation for the frontend
$date_generation = date('Y-m-d H:i:s');

include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/rapport_pdf_de_synth_se_par_d_partement/rapport_pdf.php';

?>
