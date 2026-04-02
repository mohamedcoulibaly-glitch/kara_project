<?php
/**
 * ====================================================
 * BACKEND: Configuration des Coefficients UE/EC
 * ====================================================
 * Gère les coefficients et crédits ECTS par filière
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$db = getDB();
$message = '';
$type_message = '';

// 1. Récupérer les départements pour les filtres
$query = "SELECT * FROM departement ORDER BY nom_dept";
$stmt = $db->prepare($query);
$stmt->execute();
$departements = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// 2. Récupérer le département et la filière sélectionnés
$id_dept = isset($_POST['id_dept']) ? (int)$_POST['id_dept'] : (isset($_GET['id_dept']) ? (int)$_GET['id_dept'] : ($departements[0]['id_dept'] ?? 0));

$query = "SELECT * FROM filiere WHERE id_dept = ? ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id_dept);
$stmt->execute();
$filieres = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

$id_filiere = isset($_POST['id_filiere']) ? (int)$_POST['id_filiere'] : (isset($_GET['id_filiere']) ? (int)$_GET['id_filiere'] : ($filieres[0]['id_filiere'] ?? 0));

// 3. Traiter les mises à jour (BULK)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_coefficients') {
    if (isset($_POST['coefficients']) && is_array($_POST['coefficients'])) {
        $db->begin_transaction();
        try {
            $annee = date('Y') . '-' . (date('Y') + 1);
            
            foreach ($_POST['coefficients'] as $id_ue => $coeff) {
                $credits = (int)($_POST['credits_ects'][$id_ue] ?? 0);
                $volume = (int)($_POST['volume_horaire'][$id_ue] ?? 0);
                $coeff = (float)$coeff;
                $id_ue = (int)$id_ue;
                
                $query = "INSERT INTO configuration_coefficients 
                          (id_filiere, id_ue, coefficient_ue, credit_ects_ue, volume_horaire_total, annee_academique)
                          VALUES (?, ?, ?, ?, ?, ?)
                          ON DUPLICATE KEY UPDATE 
                          coefficient_ue = VALUES(coefficient_ue), 
                          credit_ects_ue = VALUES(credit_ects_ue), 
                          volume_horaire_total = VALUES(volume_horaire_total)";
                
                $stmt = $db->prepare($query);
                $stmt->bind_param("iidiss", $id_filiere, $id_ue, $coeff, $credits, $volume, $annee);
                $stmt->execute();
            }
            $db->commit();
            $message = "Configuration mise à jour avec succès pour la filière sélectionnée.";
            $type_message = "success";
        } catch (Exception $e) {
            $db->rollback();
            $message = "Erreur lors de la mise à jour : " . $e->getMessage();
            $type_message = "error";
        }
    }
}

// 4. Récupérer les UE et leur configuration actuelle
$ues_config = [];
if ($id_filiere) {
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
                (SELECT GROUP_CONCAT(nom_ec SEPARATOR ', ') FROM ec WHERE ec.id_ue = ue.id_ue) as elements
              FROM ue
              JOIN programme p ON ue.id_ue = p.id_ue
              LEFT JOIN configuration_coefficients cc ON (ue.id_ue = cc.id_ue AND cc.id_filiere = ?)
              WHERE p.id_filiere = ?
              ORDER BY ue.code_ue";

    $stmt = $db->prepare($query);
    $stmt->bind_param("ii", $id_filiere, $id_filiere);
    $stmt->execute();
    $ues_config = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// 5. Préparer les données pour la vue
$view_data = [
    'departements' => $departements,
    'id_dept' => $id_dept,
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'unites' => $ues_config, // Nommée 'unites' pour matcher le frontend
    'message' => $message,
    'type_message' => $type_message
];

if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($view_data);
    exit;
}

extract($view_data);
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/configuration_des_coefficients_ue_ec/configuration_des_coefficients_ue_ec.php';
?>
