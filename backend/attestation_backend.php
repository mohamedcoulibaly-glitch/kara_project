<?php
/**
 * ====================================================
 * BACKEND: Gestion des Attestations de Réussite
 * ====================================================
 * Récupère les données pour afficher les attestations
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

// Initialiser les managers
$etudiantManager = new EtudiantManager();
$noteManager = new NoteManager();

// Récupérer l'ID de l'étudiant
$id_etudiant = isset($_GET['id']) ? (int)$_GET['id'] : 1; // Par défaut l'étudiant 1

// Récupérer les informations de l'étudiant
$etudiant = $etudiantManager->getById($id_etudiant);

if (!$etudiant) {
    die("Étudiant non trouvé");
}

// Récupérer les données pour l'attestation
$db = getDB();
$semestre = isset($_GET['semestre']) ? (int)$_GET['semestre'] : 1;

// Moyenne générale
$moyenne_generale = $noteManager->getMoyenneSemestre($id_etudiant, $semestre);

// Mention
$mention = getMention($moyenne_generale);

// Crédits ECTS obtenus
$query = "SELECT SUM(ue.credits_ects) as credits_total 
          FROM note n
          JOIN ec ON n.id_ec = ec.id_ec
          JOIN ue ON ec.id_ue = ue.id_ue
          JOIN programme p ON ue.id_ue = p.id_ue
          WHERE n.id_etudiant = ? AND p.semestre = ? 
          AND n.valeur_note >= 10 AND n.session = 'Normale'";

$stmt = $db->prepare($query);
$stmt->bind_param("ii", $id_etudiant, $semestre);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$credits_obtenus = $result['credits_total'] ?? 0;

// Détails des notes par UE
$query = "SELECT DISTINCT
            ue.code_ue,
            ue.libelle_ue,
            ue.credits_ects,
            AVG(n.valeur_note) as moyenne_ue
          FROM note n
          JOIN ec ON n.id_ec = ec.id_ec
          JOIN ue ON ec.id_ue = ue.id_ue
          JOIN programme p ON ue.id_ue = p.id_ue
          WHERE n.id_etudiant = ? AND p.semestre = ? AND n.session = 'Normale'
          GROUP BY ue.id_ue
          ORDER BY ue.code_ue";

$stmt = $db->prepare($query);
$stmt->bind_param("ii", $id_etudiant, $semestre);
$stmt->execute();
$details_ue = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Préparer les données pour le frontend
$attestation_data = [
    'etudiant' => $etudiant,
    'semestre' => $semestre,
    'moyenne_generale' => $moyenne_generale,
    'mention' => $mention,
    'credits_obtenus' => $credits_obtenus,
    'is_admis' => $moyenne_generale >= 10,
    'date_emission' => date('Y-m-d'),
    'code_verification' => 'V' . str_pad($id_etudiant, 2, '0', STR_PAD_LEFT) . '-' . substr(md5(time()), 0, 6),
    'details_ue' => $details_ue
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($attestation_data);
    exit;
}

extract($attestation_data);
// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/attestation_de_r_ussite_pdf/attestaion_de_reussite.php';

?>
