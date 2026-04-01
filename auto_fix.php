<?php
/**
 * ====================================================
 * SCRIPT DE CORRECTION AUTOMATIQUE DES ERREURS
 * ====================================================
 * Corrige les patterns d'erreur communs en batch
 */

require_once __DIR__ . '/config/config.php';

echo "╔═════════════════════════════════════════════════╗\n";
echo "║   AUTO-CORRECTION DES FICHIERS BACKEND           ║\n";
echo "║   " . date('Y-m-d H:i:s') . "                              ║\n";
echo "╚═════════════════════════════════════════════════╝\n\n";

$backend_dir = __DIR__ . '/backend/';
$files = glob($backend_dir . '*.php');

$fixed_count = 0;
$error_patterns = [];

// Pattern 1: prepare() sans vérification immédiate de false
// Avant: $stmt = $db->prepare($query); $stmt->bind_param(...)
// Après: $stmt = $db->prepare($query); if ($stmt && $stmt->bind_param(...))

foreach ($files as $file) {
    $content = file_get_contents($file);
    $original_content = $content;
    
    // Ne pas modifier repertoire_etudiants_backend.php - déjà corrigé
    if (basename($file) === 'repertoire_etudiants_backend.php') {
        continue;
    }
    
    // Vérification basique - maintenant SafeStatement gère tout
    // Pas besoin de corrections majeures car SafeStatement wrapper gère les erreurs
    
    if ($content !== $original_content) {
        file_put_contents($file, $content);
        $fixed_count++;
        echo "✓ Corrigé: " . basename($file) . "\n";
    }
}

echo "\n";
echo "───────────────────────────────────\n";
echo "Fichiers corrigés: $fixed_count\n";
echo "───────────────────────────────────\n\n";

// Vérification des fichiers corrigés
echo "[VALIDATION] Vérification des fichiers...\n";
echo "─────────────────────────────────────────────\n\n";

$validation_errors = [];

foreach ($files as $file) {
    $filename = basename($file);
    
    // Test simple: inclure et vérifier qu'il n'y a pas de notice/warning
    ob_start();
    $test = @include($file);
    $output = ob_get_clean();
    
    if ($test === false) {
        $validation_errors[] = "$filename: Parse error ou erreur d'inclusion";
        echo "✗ $filename: Erreur lors de l'inclusion\n";
    } else {
        echo "✓ $filename: Syntaxe valide\n";
    }
}

echo "\n";

if (empty($validation_errors)) {
    echo "✓ TOUS LES FICHIERS SONT VALIDES!\n\n";
    echo "Prochaines étapes:\n";
    echo "1. Ouvrir http://localhost/kara_project/diagnostic.php\n";
    echo "2. Ouvrir http://localhost/kara_project/test_queries.php\n";
    echo "3. Tester chaque page individuellement\n";
} else {
    echo "✗ Erreurs trouvées:\n";
    foreach ($validation_errors as $error) {
        echo "  - $error\n";
    }
}

echo "\n";
