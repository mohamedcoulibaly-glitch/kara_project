<?php
/**
 * ====================================================
 * BACKEND: Saisie des Notes - Moyennes
 * ====================================================
 * Permet de saisir les notes moyennes par UE/EC
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$db = getDB();
$message = '';
$type_message = '';

// Récupérer les filières
$query = "SELECT id_filiere, nom_filiere FROM filiere ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$filieres = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $filieres = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Récupérer les UE/EC si filière sélectionnée
$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$id_ue = isset($_GET['ue']) ? (int)$_GET['ue'] : 0;
$unites = [];
$elements = [];

if ($id_filiere) {
    // Récupérer les UE pour la filière
    $query = "SELECT DISTINCT ue.id_ue, ue.code_ue, ue.libelle_ue 
              FROM ue ue
              JOIN programme p ON ue.id_ue = p.id_ue
              WHERE p.id_filiere = ?
              ORDER BY ue.code_ue";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $unites = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

if ($id_ue) {
    // Récupérer les EC pour l'UE
    $query = "SELECT id_ec, code_ec, nom_ec, coefficient FROM ec WHERE id_ue = ? ORDER BY code_ec";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_ue);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $elements = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

// Récupérer les notes à saisir
$notes_saisies = [];
$etudiants = [];

if ($id_ue) {
    $query = "SELECT DISTINCT e.id_etudiant, e.matricule, e.nom, e.prenom, f.nom_filiere
              FROM etudiant e
              LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
              WHERE e.id_filiere = ? AND e.statut = 'Actif'
              ORDER BY e.nom, e.prenom";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $etudiants = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    
    // Récupérer les notes existantes
    $query = "SELECT n.id_note, n.id_etudiant, n.id_ec, n.valeur_note, n.session
              FROM note n
              WHERE n.id_ec IN (SELECT id_ec FROM ec WHERE id_ue = ?)
              AND n.session = 'Normale'";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_ue);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $notes_saisies = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

// Traiter l'enregistrement des notes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_notes') {
    $enregistrements = 0;
    $erreurs = 0;
    
    // Récupérer les notes POST
    if (isset($_POST['notes']) && is_array($_POST['notes'])) {
        foreach ($_POST['notes'] as $etudiant_id => $ecs) {
            foreach ($ecs as $ec_id => $valeur_note) {
                if ($valeur_note !== '' && $valeur_note >= 0 && $valeur_note <= 20) {
                    $etudiant_id = (int)$etudiant_id;
                    $ec_id = (int)$ec_id;
                    $valeur_note = (float)$valeur_note;
                    
                    // Vérifier si la note existe déjà
                    $check_query = "SELECT id_note FROM note WHERE id_etudiant = ? AND id_ec = ? AND session = 'Normale'";
                    $check_stmt = $db->prepare($check_query);
                    $check_stmt->bind_param("ii", $etudiant_id, $ec_id);
                    if ($check_stmt->execute()) {
                        $result = $check_stmt->get_result();
                        $existing = $result->fetch_assoc();
                        
                        if ($existing) {
                            // Mettre à jour
                            $update_query = "UPDATE note SET valeur_note = ?, date_modification = NOW() 
                                           WHERE id_etudiant = ? AND id_ec = ? AND session = 'Normale'";
                            $update_stmt = $db->prepare($update_query);
                            $update_stmt->bind_param("dii", $valeur_note, $etudiant_id, $ec_id);
                            if ($update_stmt->execute()) {
                                $enregistrements++;
                            } else {
                                $erreurs++;
                            }
                        } else {
                            // Insérer
                            $insert_query = "INSERT INTO note (id_etudiant, id_ec, valeur_note, session, date_examen)
                                           VALUES (?, ?, ?, 'Normale', NOW())";
                            $insert_stmt = $db->prepare($insert_query);
                            $insert_stmt->bind_param("iid", $etudiant_id, $ec_id, $valeur_note);
                            if ($insert_stmt->execute()) {
                                $enregistrements++;
                            } else {
                                $erreurs++;
                            }
                        }
                    }
                }
            }
        }
    }
    
    if ($enregistrements > 0) {
        $message = "$enregistrements note(s) enregistrée(s) avec succès";
        $type_message = 'success';
    } elseif ($erreurs > 0) {
        $message = "Erreur lors de l'enregistrement de " . $erreurs . " note(s)";
        $type_message = 'error';
    }
}

// Préparer les données pour la vue
$moyennes_data = [
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'id_ue' => $id_ue,
    'unites' => $unites,
    'elements' => $elements,
    'etudiants' => $etudiants,
    'notes_saisies' => $notes_saisies,
    'message' => $message,
    'type_message' => $type_message,
    'page_title' => $page_title ?? 'Saisie des Notes',
    'current_page' => $current_page ?? 'notes'
];

extract($moyennes_data);

// Inclure le fichier frontend
if (!defined('FRONTEND_LOADED')) {
    include __DIR__ . '/../maquettes/saisie_des_notes_moyennes/saisie_des_notes_moyennes.php';
}
?>
