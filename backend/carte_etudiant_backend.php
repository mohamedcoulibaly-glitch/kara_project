<?php
/**
 * ====================================================
 * BACKEND: Gestion de la Carte Étudiant
 * ====================================================
 * Récupère les données et génère la carte étudiante
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$db = getDB();

// Récupérer l'ID de l'étudiant
$id_etudiant = isset($_GET['id']) ? (int)$_GET['id'] : 1;

// Récupérer les informations de l'étudiant
$etudiant = $etudiantManager->getById($id_etudiant);

if (!$etudiant) {
    die("Étudiant non trouvé");
}

// Récupérer ou créer la carte
$query = "SELECT * FROM carte_etudiant WHERE id_etudiant = ?";
$stmt = $db->prepare($query);
$stmt->bind_param("i", $id_etudiant);
$stmt->execute();
$carte = $stmt->get_result()->fetch_assoc();

if (!$carte) {
    // Créer une nouvelle carte
    $numero_carte = 'CARTE-' . date('Y') . '-' . str_pad($id_etudiant, 5, '0', STR_PAD_LEFT);
    $qr_code = 'https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=' . urlencode($numero_carte);
    
    $query = "INSERT INTO carte_etudiant (id_etudiant, numero_carte, date_emission, 
                                          date_expiration, statut, qr_code) 
              VALUES (?, ?, ?, ?, 'Active', ?)";
    
    $date_emission = date('Y-m-d');
    $date_expiration = date('Y-m-d', strtotime('+1 year'));
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("issss", $id_etudiant, $numero_carte, $date_emission, $date_expiration, $qr_code);
    $stmt->execute();
    
    $carte = [
        'id_carte' => $db->insert_id,
        'numero_carte' => $numero_carte,
        'date_emission' => $date_emission,
        'date_expiration' => $date_expiration,
        'statut' => 'Active',
        'qr_code' => $qr_code
    ];
}

// Récupérer le statut de l'étudiant en termes de progression
$query = "SELECT COUNT(DISTINCT p.id_ue) as ues_prevues,
                 COUNT(DISTINCT CASE WHEN n.id_note IS NOT NULL 
                                   AND n.valeur_note >= 10 THEN n.id_ec END) as ues_validees,
                 COUNT(DISTINCT CASE WHEN n.id_note IS NOT NULL 
                                   AND n.valeur_note < 10 THEN n.id_ec END) as ues_non_validees
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          LEFT JOIN programme p ON f.id_filiere = p.id_filiere 
                                AND p.semestre <= e.semestre_actuel
          LEFT JOIN ue u ON p.id_ue = u.id_ue
          LEFT JOIN ec ON u.id_ue = ec.id_ue
          LEFT JOIN note n ON n.id_etudiant = e.id_etudiant 
                           AND n.id_ec = ec.id_ec
          WHERE e.id_etudiant = ?";

$stmt = $db->prepare($query);
$stmt->bind_param("i", $id_etudiant);
$stmt->execute();
$progression = $stmt->get_result()->fetch_assoc();

// Préparer les données pour le frontend
$carte_data = [
    'etudiant' => $etudiant,
    'carte' => $carte,
    'progression' => $progression,
    'estValide' => $carte['statut'] === 'Active' && strtotime($carte['date_expiration']) > time()
];

// Si AJAX, retourner JSON
if (isset($_GET['format']) && $_GET['format'] === 'json') {
    header('Content-Type: application/json');
    echo json_encode($carte_data);
    exit;
}

// Inclure le fichier frontend
include __DIR__ . '/../Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/carte_d_tudiant_pdf/carte_etudiant.php';

?>
