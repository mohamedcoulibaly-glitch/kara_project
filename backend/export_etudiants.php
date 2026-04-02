<?php
/**
 * export_etudiants.php - Exporte le répertoire des étudiants en format CSV
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$db = getDB();

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;

$query = "SELECT e.matricule, e.nom, e.prenom, e.email, e.telephone, e.date_naissance, f.nom_filiere, e.date_inscription
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          WHERE 1=1";

$params = [];
$types = "";

if (!empty($search)) {
    $query .= " AND (e.nom LIKE ? OR e.prenom LIKE ? OR e.matricule LIKE ?)";
    $search_param = "%$search%";
    $params[] = $search_param;
    $params[] = $search_param;
    $params[] = $search_param;
    $types .= "sss";
}

if ($filiere > 0) {
    $query .= " AND e.id_filiere = ?";
    $params[] = $filiere;
    $types .= "i";
}

$query .= " ORDER BY e.nom ASC";

$stmt = $db->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

// Headers pour téléchargement CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=annuaire_etudiants_' . date('Y-m-d') . '.csv');

$output = fopen('php://output', 'w');

// BOM UTF-8 for Excel
fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));

// En-tête des colonnes
fputcsv($output, ['Matricule', 'Nom', 'Prenom', 'Email', 'Telephone', 'Date Naissance', 'Filiere', 'Inscrit le']);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
exit();
?>
