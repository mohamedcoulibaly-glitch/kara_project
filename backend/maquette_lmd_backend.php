<?php
/**
 * ====================================================
 * BACKEND: Visualisation Maquettes LMD par Semestre
 * ====================================================
 * Affiche les maquettes structurées par semestre
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$filiereManager = new FiliereManager();
$db = getDB();

// Récupérer toutes les filières
$query = "SELECT f.*, d.nom_dept, COUNT(e.id_etudiant) as nb_etudiants 
          FROM filiere f
          LEFT JOIN departement d ON f.id_dept = d.id_dept
          LEFT JOIN etudiant e ON f.id_filiere = e.id_filiere
          GROUP BY f.id_filiere
          ORDER BY f.nom_filiere";

$stmt = $db->prepare($query);
$stmt->execute();
$filieres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer la filière sélectionnée
$id_filiere = isset($_GET['id']) ? (int)$_GET['id'] : (isset($filieres[0]) ? $filieres[0]['id_filiere'] : 0);

// Récupérer la maquette complète
$maquette_complete = [];
if ($id_filiere) {
    $query = "SELECT 
                p.semestre,
                ue.id_ue,
                ue.code_ue,
                ue.libelle_ue,
                ue.credits_ects,
                ue.coefficient,
                ue.volume_horaire,
                GROUP_CONCAT(ec.nom_ec SEPARATOR ', ') as elements,
                COUNT(ec.id_ec) as nb_ec
              FROM programme p
              JOIN ue ON p.id_ue = ue.id_ue
              LEFT JOIN ec ON ue.id_ue = ec.id_ue
              WHERE p.id_filiere = ?
              GROUP BY p.semestre, ue.id_ue
              ORDER BY p.semestre, ue.code_ue";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    $stmt->execute();
    $maquette_complete = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Grouper par semestre
$maquette_groupee = [];
foreach ($maquette_complete as $ue) {
    $sem = $ue['semestre'];
    if (!isset($maquette_groupee[$sem])) {
        $maquette_groupee[$sem] = [
            'semestre' => $sem,
            'ues' => [],
            'total_credits' => 0,
            'total_heures' => 0
        ];
    }
    $maquette_groupee[$sem]['ues'][] = $ue;
    $maquette_groupee[$sem]['total_credits'] += $ue['credits_ects'];
    $maquette_groupee[$sem]['total_heures'] += $ue['volume_horaire'];
}

// Récupérer la filière courante
$filiere_courante = null;
foreach ($filieres as $f) {
    if ($f['id_filiere'] === $id_filiere) {
        $filiere_courante = $f;
        break;
    }
}

// Préparer les données
$page_title = 'Maquette LMD';
$current_page = 'maquettes';

$maquette_data = [
    'page_title' => $page_title,
    'current_page' => $current_page,
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'filiere_courante' => $filiere_courante,
    'maquette_groupee' => $maquette_groupee
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($maquette_data);
    exit;
}

extract($maquette_data);
// Inclure le fichier frontend
if (!defined('FRONTEND_LOADED')) {
    include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/maquettes_lmd_par_semestre/maquette_lmd_par_semestre.php';
}

?>
