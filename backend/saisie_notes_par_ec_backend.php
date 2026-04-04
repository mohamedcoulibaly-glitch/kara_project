<?php
/**
 * ====================================================
 * BACKEND: Saisie des Notes par EC
 * ====================================================
 * Permet de saisir les notes détaillées par Élément Constitutif
 */

require_once __DIR__ . '/../config/config.php';

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
$id_ec = isset($_GET['ec']) ? (int)$_GET['ec'] : 0;
$session = isset($_GET['session']) ? $_GET['session'] : 'Normale';
$date_examen = isset($_GET['date_examen']) ? $_GET['date_examen'] : date('Y-m-d');

$unites = [];
$elements = [];
$etudiants = [];
$notes_saisies = [];

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

if ($id_ec) {
    // Récupérer les étudiants
    $query = "SELECT e.id_etudiant, e.matricule, e.nom, e.prenom, f.nom_filiere
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

    // Récupérer les notes existantes pour cet EC
    $query = "SELECT id_note, id_etudiant, valeur_note FROM note 
              WHERE id_ec = ? AND session = ?
              ORDER BY id_etudiant";
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $id_ec, $session);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $notes_array = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($notes_array as $note) {
                $notes_saisies[$note['id_etudiant']] = $note;
            }
        }
    }
}

// Traiter l'enregistrement des notes (formulaire envoie action=save_notes_ec)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])
    && in_array($_POST['action'], ['save_notes', 'save_notes_ec'], true)) {
    $enregistrements = 0;
    $erreurs = 0;

    $id_ec_save = isset($_POST['id_ec']) ? (int)$_POST['id_ec'] : $id_ec;
    $session_save = isset($_POST['session']) ? $_POST['session'] : $session;
    $date_examen_save = isset($_POST['date_examen']) ? $_POST['date_examen'] : $date_examen;
    if ($id_ec_save) {
        $id_ec = $id_ec_save;
    }
    if ($session_save !== '') {
        $session = $session_save;
    }
    if ($date_examen_save !== '') {
        $date_examen = $date_examen_save;
    }

    if (isset($_POST['notes']) && is_array($_POST['notes'])) {
        foreach ($_POST['notes'] as $etudiant_id => $data) {
            if (isset($data['valeur_note']) && $data['valeur_note'] !== '') {
                $valeur_note = (float)$data['valeur_note'];
                if ($valeur_note >= 0 && $valeur_note <= 20) {
                    $etudiant_id = (int)$etudiant_id;
                    $id_ec = (int)$id_ec;
                
                // Vérifier si la note existe
                $check_query = "SELECT id_note FROM note WHERE id_etudiant = ? AND id_ec = ? AND session = ?";
                $check_stmt = $db->prepare($check_query);
                $check_stmt->bind_param("iis", $etudiant_id, $id_ec, $session);
                if ($check_stmt->execute()) {
                    $result = $check_stmt->get_result();
                    $existing = $result->fetch_assoc();
                    
                    if ($existing) {
                        // Mettre à jour
                        $update_query = "UPDATE note SET valeur_note = ?, date_modification = NOW() 
                                       WHERE id_etudiant = ? AND id_ec = ? AND session = ?";
                        $update_stmt = $db->prepare($update_query);
                        $update_stmt->bind_param("diis", $valeur_note, $etudiant_id, $id_ec, $session);
                        if ($update_stmt->execute()) {
                            $enregistrements++;
                        } else {
                            $erreurs++;
                        }
                    } else {
                        // Insérer
                        $insert_query = "INSERT INTO note (id_etudiant, id_ec, valeur_note, session, date_examen)
                                       VALUES (?, ?, ?, ?, ?)";
                        $insert_stmt = $db->prepare($insert_query);
                        $insert_stmt->bind_param("iidss", $etudiant_id, $id_ec, $valeur_note, $session, $date_examen);
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



$page_title = 'Saisie des Notes par EC';
$current_page = 'notes';

// Préparer les données pour la vue
$notes_data = [
    'filieres' => $filieres,
    'id_filiere' => $id_filiere,
    'id_ue' => $id_ue,
    'id_ec' => $id_ec,
    'session' => $session,
    'date_examen' => $date_examen,
    'unites' => $unites,
    'elements' => $elements,
    'etudiants' => $etudiants,
    'notes_saisies' => $notes_saisies,
    'message' => $message,
    'type_message' => $type_message,
    'page_title' => $page_title,
    'current_page' => $current_page
];

extract($notes_data);

// Inclure le fichier frontend
if (!defined('FRONTEND_LOADED')) {
    include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/saisie_des_notes_par_ec/saisie_des_notes_par_ec.php';
}
?>
