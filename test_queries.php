<?php
/**
 * ====================================================
 * TEST DE RÉCUPÉRATION DES DONNÉES
 * ====================================================
 * Teste les requêtes principales du système
 */

require_once __DIR__ . '/config/config.php';

$log = [];

function test_log($message, $status = 'OK') {
    global $log;
    $log[] = [
        'time' => date('H:i:s'),
        'message' => $message,
        'status' => $status
    ];
    echo "[$status] $message\n";
}

echo "╔═════════════════════════════════════════════════╗\n";
echo "║   TEST DES REQUÊTES - KARA PROJECT              ║\n";
echo "║   " . date('Y-m-d H:i:s') . "                              ║\n";
echo "╚═════════════════════════════════════════════════╝\n\n";

$db = getDB();

if (!$db) {
    test_log("Connexion base de données", "ERREUR");
    die("Impossible de se connecter à la base de données\n");
}

test_log("Connexion base de données", "OK");

// Test 1: Lister les départements
echo "\n[TEST 1] Récupération des départements\n";
echo "──────────────────────────────────────\n";

$query = "SELECT * FROM departement LIMIT 5";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $depts = $result->fetch_all(MYSQLI_ASSOC);
        test_log("Requête departement: " . count($depts) . " ligne(s)", "OK");
    } else {
        test_log("get_result() échoue pour departement", "ERREUR");
    }
} else {
    test_log("Requête departement échoue", "ERREUR");
}

// Test 2: Lister les étudiants
echo "\n[TEST 2] Récupération des étudiants\n";
echo "───────────────────────────────────────\n";

$query = "SELECT e.*, f.nom_filiere FROM etudiant e LEFT JOIN filiere f ON e.id_filiere = f.id_filiere LIMIT 5";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $etudiants = $result->fetch_all(MYSQLI_ASSOC);
        test_log("Requête etudiant: " . count($etudiants) . " ligne(s)", "OK");
    } else {
        test_log("get_result() échoue pour etudiant", "ERREUR");
    }
} else {
    test_log("Requête etudiant échoue", "ERREUR");
}

// Test 3: Requête avec WHERE et bind_param
echo "\n[TEST 3] Requête avec bind_param (WHERE)\n";
echo "──────────────────────────────────────────\n";

$query = "SELECT * FROM departement WHERE id_dept = ?";
$stmt = $db->prepare($query);
$id = 1;

if ($stmt->bind_param("i", $id)) {
    test_log("bind_param réussit", "OK");
    
    if ($stmt->execute()) {
        test_log("execute après bind_param réussit", "OK");
        
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            test_log("get_result après execute réussit", "OK");
        } else {
            test_log("get_result échoue", "ERREUR");
        }
    } else {
        test_log("execute après bind_param échoue", "ERREUR");
    }
} else {
    test_log("bind_param échoue", "ERREUR");
}

// Test 4: Statistiques globales
echo "\n[TEST 4] Requête d'agrégation\n";
echo "───────────────────────────────────\n";

$query = "SELECT COUNT(*) as total, COUNT(DISTINCT id_filiere) as filieres FROM etudiant";
$stmt = $db->prepare($query);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $stats = $result->fetch_assoc();
        test_log("Statistiques: " . $stats['total'] . " étudiants, " . $stats['filieres'] . " filières", "OK");
    } else {
        test_log("get_result échoue pour stats", "ERREUR");
    }
} else {
    test_log("Requête stats échoue", "ERREUR");
}

// Test 5: Requête complexe avec JOIN
echo "\n[TEST 5] Requête complexe avec JOIN\n";
echo "────────────────────────────────────────\n";

$query = "SELECT e.nom, e.prenom, f.nom_filiere, d.nom_dept 
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          LEFT JOIN departement d ON f.id_dept = d.id_dept
          LIMIT 5";
$stmt = $db->prepare($query);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $data = $result->fetch_all(MYSQLI_ASSOC);
        test_log("Requête JOIN: " . count($data) . " ligne(s)", "OK");
    } else {
        test_log("get_result échoue pour JOIN", "ERREUR");
    }
} else {
    test_log("Requête JOIN échoue", "ERREUR");
}

// Test 6: SafeStatement type check
echo "\n[TEST 6] Vérification du type SafeStatement\n";
echo "──────────────────────────────────────────────\n";

$stmt = $db->prepare("SELECT 1");
if ($stmt instanceof SafeStatement) {
    test_log("prepare() retourne SafeStatement", "OK");
} else {
    test_log("prepare() ne retourne pas SafeStatement: " . get_class($stmt), "ERREUR");
}

// Résumé des logs
echo "\n\n╔═════════════════════════════════════════════════╗\n";
echo "║   RÉSUMÉ - " . count($log) . " tests effectués" . str_repeat(" ", 30 - strlen(count($log))) . "║\n";
echo "╚═════════════════════════════════════════════════╝\n\n";

$ok_count = count(array_filter($log, fn($l) => $l['status'] === 'OK'));
$error_count = count(array_filter($log, fn($l) => $l['status'] === 'ERREUR'));

echo "✓ Succès: $ok_count\n";
echo "✗ Erreurs: $error_count\n\n";

if ($error_count === 0) {
    echo "✓ TOUS LES TESTS RÉUSSIS!\n";
} else {
    echo "✗ Problèmes détectés - voir les erreurs ci-dessus\n";
}
