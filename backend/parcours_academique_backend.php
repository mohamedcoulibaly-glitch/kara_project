<?php
/**
 * ====================================================
 * BACKEND: Parcours Académique Complet S1-S6
 * ====================================================
 * Affiche le parcours complet d'un étudiant
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$noteManager = new NoteManager();
$filiereManager = new FiliereManager();
$db = getDB();

// Récupérer l'ID de l'étudiant (?etudiant_id= ou ?id=)
$id_etudiant = (int)($_GET['etudiant_id'] ?? $_GET['id'] ?? 1);

// Récupérer les informations de l'étudiant
$etudiant = $etudiantManager->getById($id_etudiant);

if (!$etudiant) {
    die("Étudiant non trouvé");
}

// Récupérer le relève de notes complet (6 semestres)
$releve_complet = $noteManager->getReleve($id_etudiant);

// Grouper par semestre
$parcours_par_semestre = [];
for ($sem = 1; $sem <= 6; $sem++) {
    $parcours_par_semestre[$sem] = [
        'semestre' => $sem,
        'ues' => [],
        'moyenne_semestre' => 0,
        'credits_obtenus' => 0,
        'statut' => 'En cours'
    ];
}

foreach ($releve_complet as $note) {
    $sem = $note['semestre'];
    if (!isset($parcours_par_semestre[$sem]['ues'][$note['code_ue']])) {
        $parcours_par_semestre[$sem]['ues'][$note['code_ue']] = [
            'code_ue' => $note['code_ue'],
            'libelle_ue' => $note['libelle_ue'],
            'credits_ects' => $note['credits_ects'],
            'notes' => []
        ];
    }
    
    $parcours_par_semestre[$sem]['ues'][$note['code_ue']]['notes'][] = [
        'ec' => $note['nom_ec'],
        'note' => $note['valeur_note'],
        'session' => $note['session']
    ];
}

// Calculer les moyennes et crédits par semestre
foreach ($parcours_par_semestre as &$sem_data) {
    $notes_sem = array_filter($releve_complet, function($n) use ($sem_data) {
        return $n['semestre'] === $sem_data['semestre'];
    });
    
    if (!empty($notes_sem)) {
        $moyennes = array_map(function($n) { return $n['valeur_note']; }, $notes_sem);
        $sem_data['moyenne_semestre'] = array_sum($moyennes) / count($moyennes);
        
        // Crédits uniquement si moyenne >= 10
        if ($sem_data['moyenne_semestre'] >= 10) {
            $credits = array_sum(array_map(function($n) { return $n['credits_ects']; }, $notes_sem));
            $sem_data['credits_obtenus'] = $credits;
            $sem_data['statut'] = 'Admis';
        } else {
            $sem_data['statut'] = $sem_data['moyenne_semestre'] >= 8 ? 'Redoublant' : 'Non Admis';
        }
    }
}

// Calcul global
$credits_totaux = array_sum(array_map(function($s) { return $s['credits_obtenus']; }, $parcours_par_semestre));
$moyenne_generale = $noteManager->getMoyenneGenerale($id_etudiant);

// Préparer les données
$parcours_data = [
    'etudiant' => $etudiant,
    'parcours_par_semestre' => array_values($parcours_par_semestre),
    'credits_totaux' => $credits_totaux,
    'moyenne_generale' => $moyenne_generale,
    'progression_percentage' => min(100, ($credits_totaux / 180) * 100)
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($parcours_data);
    exit;
}

extract($parcours_data);
if (!defined('FRONTEND_LOADED')) {
    include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/parcours_acad_mique_complet_s1_s6/parcours_academique_complet_s1_s6.php';
}

?>
