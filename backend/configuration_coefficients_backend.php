<?php
/**
 * ====================================================
 * BACKEND: Configuration des Coefficients UE/EC
 * ====================================================
 * Gère les coefficients et crédits ECTS
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$filiereManager = new FiliereManager();
$db = getDB();

// Récupérer les départements
$query = "SELECT * FROM departement ORDER BY nom_dept";
$stmt = $db->prepare($query);
$stmt->execute();
$departements = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer le département sélectionné
$id_dept = isset($_POST['id_dept']) ? (int)$_POST['id_dept'] : (isset($departements[0]) ? $departements[0]['id_dept'] : 0);

// Récupérer les filières du département
$query = "SELECT * FROM filiere WHERE id_dept = ? ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id_dept);
$stmt->execute();
$filieres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$id_filiere = isset($_POST['id_filiere']) ? (int)$_POST['id_filiere'] : (isset($filieres[0]) ? $filieres[0]['id_filiere'] : 0);

// Récupérer les UE et leur configuration
$query = "SELECT 
            ue.id_ue,
            ue.code_ue,
            ue.libelle_ue,
            ue.credits_ects,
            ue.coefficient,
            ue.volume_horaire,
            cc.coefficient_ue as config_coeff,
            cc.credit_ects_ue as config_credits,
            cc.volume_horaire_total,
            COUNT(ec.id_ec) as nb_ec,
            GROUP_CONCAT(ec.nom_ec SEPARATOR ', ') as elements
          FROM ue
          LEFT JOIN configuration_coefficients cc ON (ue.id_ue = cc.id_ue AND cc.id_filiere = ?)
          LEFT JOIN programme p ON (ue.id_ue = p.id_ue AND p.id_filiere = ?)
          LEFT JOIN ec ON ue.id_ue = ec.id_ue
          WHERE ue.id_dept = ? OR p.id_filiere = ?
          GROUP BY ue.id_ue
          ORDER BY ue.code_ue";

$stmt = $db->prepare($query);
$stmt->bind_param("iiii", $id_filiere, $id_filiere, $id_dept, $id_filiere);
$stmt->execute();
$ues_config = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Traiter les mises à jour
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_config') {
    $id_ue = (int)$_POST['id_ue'];
    $coefficient = (float)$_POST['coefficient'];
    $credits = (int)$_POST['credits'];
    $volume = (int)$_POST['volume'];
    $annee = date('Y-Y+1', strtotime('next year'));
    
    $query = "INSERT INTO configuration_coefficients 
              (id_filiere, id_ue, coefficient_ue, credit_ects_ue, volume_horaire_total, annee_academique)
              VALUES (?, ?, ?, ?, ?, ?)
              ON DUPLICATE KEY UPDATE 
              coefficient_ue = ?, credit_ects_ue = ?, volume_horaire_total = ?";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("iidiiidii", $id_filiere, $id_ue, $coefficient, $credits, $volume, $annee,
                      $coefficient, $credits, $volume);
    
    if ($stmt->execute()) {
        $message = showSuccess("Configuration mise à jour avec succès");
    } else {
        $message = showError("Erreur lors de la mise à jour");
    }
}

// Préparer les données
$config_data = [
    'departements' => $departements,
    'id_dept' => $id_dept,
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'ues_config' => $ues_config,
    'message' => $message
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($config_data);
    exit;
}

// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/configuration_des_coefficients_ue_ec/configuration_des_coefficients_ue_ec.php';

?>
