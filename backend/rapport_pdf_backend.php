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
    CASE 
        WHEN AVG(n.valeur_note) >= 16 THEN 'Très Bien'
        WHEN AVG(n.valeur_note) >= 14 THEN 'Bien'
        WHEN AVG(n.valeur_note) >= 12 THEN 'Assez Bien'
        WHEN AVG(n.valeur_note) >= 10 THEN 'Passable'
        ELSE 'Non Admis'
    END as mention,
    COUNT(DISTINCT e.id_etudiant) as nombre_etudiants,
    ROUND(AVG(n.valeur_note), 2) as moyenne_mention
FROM etudiant e
LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
LEFT JOIN note n ON e.id_etudiant = n.id_etudiant AND n.session = ?
WHERE e.statut = 'Actif' AND f.id_dept = ?
GROUP BY mention
ORDER BY CASE 
    WHEN mention = 'Très Bien' THEN 1
    WHEN mention = 'Bien' THEN 2
    WHEN mention = 'Assez Bien' THEN 3
    WHEN mention = 'Passable' THEN 4
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
$stmt->bind_param("iss", $id_dept, $session);
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

// Si AJAX appelé au format JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($rapport_data);
    exit;
}

// Sinon inclure le fichier frontend
extract($rapport_data);
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/rapport_pdf_de_synth_se_par_d_partement/rapport_pdf.php';

?>
