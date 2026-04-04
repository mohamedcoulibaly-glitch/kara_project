<?php
/**
 * ====================================================
 * BACKEND: Statistiques de Réussite par Département
 * ====================================================
 * Analyse comparative des performances académiques
 */

require_once __DIR__ . '/../config/config.php';

$db = getDB();

// Récupérer les départements
$query = "SELECT id_dept, nom_dept FROM departement ORDER BY nom_dept";
$stmt = $db->prepare($query);
$departements = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $departements = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Statistiques par département
$stats_departements = [];
foreach ($departements as $dept) {
    $id_dept = $dept['id_dept'];
    
    // Taux de réussite = part d'étudiants actifs avec moyenne générale (session Normale) ≥ 10
    $query = "SELECT 
              COUNT(DISTINCT e.id_etudiant) as nombre_etudiants,
              SUM(CASE WHEN agg.moy >= 10 THEN 1 ELSE 0 END) as etudiants_reussis,
              COUNT(n.id_note) as total_notes,
              AVG(n.valeur_note) as moyenne
              FROM etudiant e
              JOIN filiere f ON e.id_filiere = f.id_filiere
              LEFT JOIN note n ON e.id_etudiant = n.id_etudiant AND n.session = 'Normale'
              LEFT JOIN (
                  SELECT id_etudiant, AVG(valeur_note) as moy FROM note WHERE session = 'Normale' GROUP BY id_etudiant
              ) agg ON agg.id_etudiant = e.id_etudiant
              WHERE f.id_dept = ? AND e.statut = 'Actif'";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_dept);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $nb = (int)($row['nombre_etudiants'] ?? 0);
            $ok = (int)($row['etudiants_reussis'] ?? 0);
            $stats_departements[$id_dept] = [
                'nom' => $dept['nom_dept'],
                'nombre_etudiants' => $nb,
                'reussis' => $ok,
                'total_notes' => (int)($row['total_notes'] ?? 0),
                'moyenne' => $row['moyenne'] ? round($row['moyenne'], 2) : 0,
                'taux_reussite' => $nb > 0 ? round(($ok / $nb) * 100, 1) : 0
            ];
        }
    }
}

// Statistiques globales (même logique : étudiants avec moyenne ≥ 10)
$query = "SELECT 
          COUNT(DISTINCT e.id_etudiant) as total_etudiants,
          SUM(CASE WHEN agg.moy >= 10 THEN 1 ELSE 0 END) as total_reussis,
          COUNT(n.id_note) as total_notes,
          AVG(n.valeur_note) as moyenne_globale,
          MIN(n.valeur_note) as note_min,
          MAX(n.valeur_note) as note_max
          FROM etudiant e
          LEFT JOIN note n ON e.id_etudiant = n.id_etudiant AND n.session = 'Normale'
          LEFT JOIN (
              SELECT id_etudiant, AVG(valeur_note) as moy FROM note WHERE session = 'Normale' GROUP BY id_etudiant
          ) agg ON agg.id_etudiant = e.id_etudiant
          WHERE e.statut = 'Actif'";

$stmt = $db->prepare($query);
$stats_globales = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $te = (int)($row['total_etudiants'] ?? 0);
        $tr = (int)($row['total_reussis'] ?? 0);
        $stats_globales = [
            'total_etudiants' => $te,
            'total_reussis' => $tr,
            'total_notes' => (int)($row['total_notes'] ?? 0),
            'moyenne_globale' => $row['moyenne_globale'] ? round($row['moyenne_globale'], 2) : 0,
            'note_min' => $row['note_min'] ?? 0,
            'note_max' => $row['note_max'] ?? 0,
            'taux_global' => $te > 0 ? round(($tr / $te) * 100, 1) : 0
        ];
    }
}

// Répartition par note
$query = "SELECT 
          COUNT(CASE WHEN valeur_note < 5 THEN 1 END) as tres_faible,
          COUNT(CASE WHEN valeur_note >= 5 AND valeur_note < 8 THEN 1 END) as faible,
          COUNT(CASE WHEN valeur_note >= 8 AND valeur_note < 12 THEN 1 END) as moyen,
          COUNT(CASE WHEN valeur_note >= 12 AND valeur_note < 15 THEN 1 END) as bon,
          COUNT(CASE WHEN valeur_note >= 15 THEN 1 END) as excellent
          FROM note WHERE session = 'Normale'";

$stmt = $db->prepare($query);
$repartition = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['tres_faible'] + $row['faible'] + $row['moyen'] + $row['bon'] + $row['excellent'];
        $repartition = [
            'tres_faible' => $total > 0 ? round(($row['tres_faible'] / $total) * 100, 1) : 0,
            'faible' => $total > 0 ? round(($row['faible'] / $total) * 100, 1) : 0,
            'moyen' => $total > 0 ? round(($row['moyen'] / $total) * 100, 1) : 0,
            'bon' => $total > 0 ? round(($row['bon'] / $total) * 100, 1) : 0,
            'excellent' => $total > 0 ? round(($row['excellent'] / $total) * 100, 1) : 0,
        ];
    }
}


// Préparer les données
$stats_data = [
    'departements' => $departements,
    'stats_departements' => $stats_departements,
    'stats_globales' => $stats_globales,
    'repartition' => $repartition
];

extract($stats_data);

// Inclure le fichier frontend
if (!defined('FRONTEND_LOADED')) {
    include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/statistiques_de_r_ussite_par_d_partement/stats_reussites_departements.php';
}
?>
