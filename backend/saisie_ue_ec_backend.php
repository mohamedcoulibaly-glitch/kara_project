<?php
/**
 * ====================================================
 * BACKEND: Saisie des UE/EC / Unités & Éléments
 * ====================================================
 * Gère la définition des UE et EC par filière
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$filiereManager = new FiliereManager();
$db = getDB();

$message = '';
$type_message = '';

// 1. Traiter la sauvegarde d'une nouvelle UE (Batch EC inclus)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && ($_POST['action'] === 'save_ue' || $_POST['action'] === 'save_ue_batch')) {
    $code_ue = trim($_POST['code_ue'] ?? '');
    $libelle_ue = trim($_POST['libelle_ue'] ?? '');
    $credits_ects = (float)($_POST['credits_ects'] ?? 0);
    $id_filiere = (int)($_GET['filiere'] ?? 0);
    $semestre = (int)($_POST['semestre'] ?? $_GET['semestre'] ?? 1);
    
    if ($code_ue && $libelle_ue && $id_filiere) {
        $db->begin_transaction();
        try {
            // Créer l'UE
            $query_ue = "INSERT INTO ue (code_ue, libelle_ue, credits_ects, id_dept) 
                         VALUES (?, ?, ?, (SELECT id_dept FROM filiere WHERE id_filiere = ?))
                         ON DUPLICATE KEY UPDATE libelle_ue = VALUES(libelle_ue), credits_ects = VALUES(credits_ects)";
            $stmt = $db->prepare($query_ue);
            $stmt->bind_param("ssdi", $code_ue, $libelle_ue, $credits_ects, $id_filiere);
            $stmt->execute();
            $id_ue = $db->insert_id ?: 0;
            
            if (!$id_ue) {
                // Si ON DUPLICATE KEY UPDATE, récupérer l'ID existant
                $res = $db->query("SELECT id_ue FROM ue WHERE code_ue = '$code_ue'");
                $id_ue = $res->fetch_assoc()['id_ue'];
            }
            
            // Lier au programme (filière + semestre)
            $query_prog = "INSERT INTO programme (id_ue, id_filiere, semestre) VALUES (?, ?, ?) 
                          ON DUPLICATE KEY UPDATE semestre = VALUES(semestre)";
            $stmt_p = $db->prepare($query_prog);
            $stmt_p->bind_param("iii", $id_ue, $id_filiere, $semestre);
            $stmt_p->execute();

            // Gestion dynamique des EC
            if (isset($_POST['ecs']) && is_array($_POST['ecs'])) {
                foreach ($_POST['ecs'] as $ecData) {
                    $ecCode = trim($ecData['code'] ?? '');
                    $ecNom = trim($ecData['nom'] ?? '');
                    $ecCoeff = (float)($ecData['coeff'] ?? 1);
                    
                    if ($ecCode && $ecNom) {
                        $query_ec = "INSERT INTO ec (id_ue, code_ec, nom_ec, coefficient) VALUES (?, ?, ?, ?)
                                   ON DUPLICATE KEY UPDATE nom_ec = VALUES(nom_ec), coefficient = VALUES(coefficient)";
                        $stmt_ec = $db->prepare($query_ec);
                        $stmt_ec->bind_param("isss", $id_ue, $ecCode, $ecNom, $ecCoeff);
                        $stmt_ec->execute();
                    }
                }
            }
            
            $db->commit();
            $message = "L'unité $code_ue et ses éléments ont été enregistrés avec succès.";
            $type_message = "success";
        } catch (Exception $e) {
            $db->rollback();
            $message = "Erreur: " . $e->getMessage();
            $type_message = "error";
        }
    }
}

// 2. Traiter la sauvegarde d'un nouvel EC
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_ec') {
    $id_ue = (int)($_POST['id_ue'] ?? 0);
    $code_ec = trim($_POST['code_ec'] ?? '');
    $nom_ec = trim($_POST['nom_ec'] ?? '');
    $coefficient = (float)($_POST['coefficient'] ?? 1);
    
    if ($id_ue && $nom_ec) {
        $query = "INSERT INTO ec (id_ue, code_ec, nom_ec, coefficient) VALUES (?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE nom_ec = VALUES(nom_ec), coefficient = VALUES(coefficient)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("isss", $id_ue, $code_ec, $nom_ec, $coefficient);
        
        if ($stmt->execute()) {
            $message = "L'élément constitutif $nom_ec a été enregistré.";
            $type_message = "success";
        } else {
            $message = "Erreur lors de l'enregistrement de l'EC.";
            $type_message = "error";
        }
    }
}

// 2.1 Traiter la mise à jour d'une UE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_ue') {
    $id_ue = (int)($_POST['id_ue'] ?? 0);
    $code_ue = trim($_POST['code_ue'] ?? '');
    $libelle_ue = trim($_POST['libelle_ue'] ?? '');
    $credits_ects = (float)($_POST['credits_ects'] ?? 0);
    $semestre = (int)($_POST['semestre'] ?? 1);
    $id_filiere = (int)($_GET['filiere'] ?? 0);
    
    if ($id_ue && $code_ue && $libelle_ue) {
        $db->begin_transaction();
        try {
            $query_ue = "UPDATE ue SET code_ue = ?, libelle_ue = ?, credits_ects = ? WHERE id_ue = ?";
            $stmt_ue = $db->prepare($query_ue);
            $stmt_ue->bind_param("ssdi", $code_ue, $libelle_ue, $credits_ects, $id_ue);
            $stmt_ue->execute();
            
            if ($id_filiere) {
                $query_p = "UPDATE programme SET semestre = ? WHERE id_ue = ? AND id_filiere = ?";
                $stmt_p = $db->prepare($query_p);
                $stmt_p->bind_param("iii", $semestre, $id_ue, $id_filiere);
                $stmt_p->execute();
            }
            $db->commit();
            $message = "L'unité $code_ue a été mise à jour.";
            $type_message = "success";
        } catch (Exception $e) {
            $db->rollback();
            $message = "Erreur: " . $e->getMessage();
            $type_message = "error";
        }
    }
}

// 3. Traiter la suppression d'une UE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_ue') {
    $id_ue = (int)($_POST['id_ue'] ?? 0);
    $id_filiere = (int)($_GET['filiere'] ?? 0);
    
    if ($id_ue && $id_filiere) {
        // Vérifier si des notes existent pour les EC de cette UE
        $check_notes = "SELECT COUNT(*) as count FROM note n 
                        JOIN ec e ON n.id_ec = e.id_ec 
                        WHERE e.id_ue = ?";
        $stmt_check = $db->prepare($check_notes);
        $stmt_check->bind_param("i", $id_ue);
        $stmt_check->execute();
        $has_notes = $stmt_check->get_result()->fetch_assoc()['count'] > 0;
        
        if ($has_notes) {
            $message = "Impossible de supprimer cette unité car des notes y sont déjà rattachées.";
            $type_message = "error";
        } else {
            // Supprimer du programme d'abord (contrainte intégrité)
            $query_p = "DELETE FROM programme WHERE id_ue = ? AND id_filiere = ?";
            $stmt_p = $db->prepare($query_p);
            $stmt_p->bind_param("ii", $id_ue, $id_filiere);
            
            if ($stmt_p->execute()) {
                $message = "L'unité a été retirée du programme avec succès.";
                $type_message = "success";
            } else {
                $message = "Erreur lors du retrait de l'unité.";
                $type_message = "error";
            }
        }
    }
}

// 4. Récupérer les données pour la vue
$filieres = $filiereManager->getAll();
$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : ($filieres[0]['id_filiere'] ?? 0);
$semestre = isset($_GET['semestre']) ? (int)$_GET['semestre'] : 1;

$unites = [];
$elements_constitutifs = [];

if ($id_filiere) {
    // Récupérer les UE (via programme)
    $query = "SELECT ue.*, p.semestre 
              FROM ue 
              JOIN programme p ON ue.id_ue = p.id_ue 
              WHERE p.id_filiere = ? 
              ORDER BY ue.code_ue";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    $stmt->execute();
    $unites = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    // Récupérer tous les EC pour ces UE
    if (!empty($unites)) {
        $ue_ids = array_column($unites, 'id_ue');
        $placeholders = implode(',', array_fill(0, count($ue_ids), '?'));
        $query_ec = "SELECT ec.*, ue.code_ue FROM ec 
                    JOIN ue ON ec.id_ue = ue.id_ue 
                    WHERE ec.id_ue IN ($placeholders)";
        $stmt_ec = $db->prepare($query_ec);
        $stmt_ec->bind_param(str_repeat('i', count($ue_ids)), ...$ue_ids);
        $stmt_ec->execute();
        $elements_constitutifs = $stmt_ec->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

// 4. Préparer les données
$view_data = [
    'message' => $message,
    'type_message' => $type_message,
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'semestre' => $semestre,
    'unites' => $unites,
    'elements_constitutifs' => $elements_constitutifs
];

extract($view_data);

// 5. Inclure la vue frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/saisie_ue_ec/saisie_ue_ec.php';
?>
