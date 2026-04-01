<?php
/**
 * ====================================================
 * FICHIER DE DIAGNOSTIC - Détecte les erreurs
 * ====================================================
 * Teste la connexion BD et identifie les problèmes
 */

require_once __DIR__ . '/config/config.php';

echo "<pre>";
echo "╔═════════════════════════════════════════════════╗\n";
echo "║   DIAGNOSTIC - KARA PROJECT                     ║\n";
echo "║   Date: " . date('Y-m-d H:i:s') . "                         ║\n";
echo "╚═════════════════════════════════════════════════╝\n\n";

$errors = [];
$warnings = [];
$info = [];

// ========================================
// Test 1: Configuration
// ========================================
echo "[1] TEST CONFIGURATION\n";
echo "─────────────────────────\n";

if (defined('DB_HOST')) {
    echo "✓ DB_HOST défini: " . DB_HOST . "\n";
} else {
    $errors[] = "DB_HOST non défini";
    echo "✗ DB_HOST non défini\n";
}

if (defined('DB_NAME')) {
    echo "✓ DB_NAME défini: " . DB_NAME . "\n";
} else {
    $errors[] = "DB_NAME non défini";
    echo "✗ DB_NAME non défini\n";
}

if (defined('DB_USER')) {
    echo "✓ DB_USER défini: " . DB_USER . "\n";
} else {
    $warnings[] = "DB_USER non défini (utilise 'root'?)";
    echo "⚠ DB_USER non défini\n";
}

echo "\n";

// ========================================
// Test 2: Connexion à la Base de Données
// ========================================
echo "[2] TEST CONNEXION BASE DE DONNÉES\n";
echo "────────────────────────────────────\n";

try {
    $db = getDB();
    
    if (!$db) {
        $errors[] = "Impossible de récupérer la connexion";
        echo "✗ Connexion null\n";
    } else {
        echo "✓ Connexion établie\n";
        
        // Teste la connexion
        if ($db->ping()) {
            echo "✓ Ping réussi\n";
            $info[] = "Base de données active";
        } else {
            $errors[] = "Ping échoué - Base de données non accessible";
            echo "✗ Ping échoué\n";
        }
        
        // Obtient les informations du serveur
        echo "✓ Version MySQL: " . $db->server_info . "\n";
        echo "✓ Sélection de DB: " . DB_NAME . "\n";
    }
} catch (Exception $e) {
    $errors[] = "Exception lors de la connexion: " . $e->getMessage();
    echo "✗ Exception: " . $e->getMessage() . "\n";
}

echo "\n";

// ========================================
// Test 3: Tables de la Base de Données
// ========================================
echo "[3] TEST TABLES REQUISES\n";
echo "───────────────────────────\n";

$required_tables = [
    'departement' => 'Département',
    'filiere' => 'Filière',
    'etudiant' => 'Étudiant',
    'ue' => 'Unité d\'Enseignement',
    'ec' => 'Élément Constitutif',
    'note' => 'Note',
    'programme' => 'Programme'
];

if ($db) {
    $result = $db->query("SHOW TABLES FROM " . DB_NAME);
    $tables = [];
    if ($result) {
        while ($row = $result->fetch_row()) {
            $tables[] = $row[0];
        }
    }
    
    foreach ($required_tables as $table => $label) {
        if (in_array($table, $tables)) {
            echo "✓ Table '$table' trouvée\n";
        } else {
            $warnings[] = "Table '$table' manquante";
            echo "⚠ Table '$table' manquante\n";
        }
    }
}

echo "\n";

// ========================================
// Test 4: SafeStatement Wrapper
// ========================================
echo "[4] TEST WRAPPER SafeStatement\n";
echo "──────────────────────────────────\n";

if (class_exists('SafeStatement')) {
    echo "✓ Classe SafeStatement existe\n";
    
    // Teste prepare avec simple requête
    $test_query = "SELECT 1";
    $stmt = $db->prepare($test_query);
    
    if ($stmt instanceof SafeStatement) {
        echo "✓ prepare() retourne SafeStatement\n";
        
        if ($stmt->execute()) {
            echo "✓ execute() fonctionne sur SafeStatement\n";
            $result = $stmt->get_result();
            if ($result) {
                echo "✓ get_result() fonctionne\n";
            } else {
                $warnings[] = "get_result() retourne false";
                echo "⚠ get_result() retourne false\n";
            }
        } else {
            $errors[] = "execute() échoue sur SafeStatement";
            echo "✗ execute() échoue\n";
        }
    } else {
        $errors[] = "prepare() ne retourne pas SafeStatement";
        echo "✗ prepare() ne retourne pas SafeStatement\n";
    }
} else {
    $errors[] = "Classe SafeStatement n'existe pas";
    echo "✗ Classe SafeStatement n'existe pas\n";
}

echo "\n";

// ========================================
// Test 5: Requête avec bind_param
// ========================================
echo "[5] TEST REQUÊTE AVEC BIND_PARAM\n";
echo "─────────────────────────────────────\n";

if ($db && class_exists('SafeStatement')) {
    $test_query = "SELECT * FROM departement WHERE id_dept = ?";
    $stmt = $db->prepare($test_query);
    
    if ($stmt instanceof SafeStatement) {
        $id = 1;
        if ($stmt->bind_param("i", $id)) {
            echo "✓ bind_param() réussit\n";
            
            if ($stmt->execute()) {
                echo "✓ execute() après bind_param réussit\n";
            } else {
                $warnings[] = "execute() échoue après bind_param";
                echo "⚠ execute() échoue après bind_param\n";
            }
        } else {
            $errors[] = "bind_param() échoue";
            echo "✗ bind_param() échoue\n";
        }
    }
}

echo "\n";

// ========================================
// RÉSUMÉ
// ========================================
echo "╔═════════════════════════════════════════════════╗\n";
echo "║   RÉSUMÉ DU DIAGNOSTIC                          ║\n";
echo "╚═════════════════════════════════════════════════╝\n\n";

echo "Erreurs critiques: " . count($errors) . "\n";
if (count($errors) > 0) {
    echo "─ " . implode("\n─ ", $errors) . "\n\n";
}

echo "Avertissements: " . count($warnings) . "\n";
if (count($warnings) > 0) {
    echo "⚠ " . implode("\n⚠ ", $warnings) . "\n\n";
}

echo "Informations: " . count($info) . "\n";
if (count($info) > 0) {
    echo "ℹ " . implode("\nℹ ", $info) . "\n\n";
}

if (count($errors) === 0) {
    echo "\n✓ TOUS LES TESTS RÉUSSIS!\n";
    echo "Votre installation semble correcte.\n";
} else {
    echo "\n✗ Problèmes détectés - Veuillez corriger les erreurs ci-dessus\n";
}

echo "\n</pre>";
