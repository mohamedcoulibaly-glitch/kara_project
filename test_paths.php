<?php
/**
 * Test des chemins include
 */
echo "Test des chemins include corriges:\n";

// Test 1: Implémenter le chemin depuis backend/carte_etudiant_backend.php
$backend_file = 'C:\xampp\htdocs\kara_project\backend\carte_etudiant_backend.php';
$dir = dirname($backend_file); // C:\xampp\htdocs\kara_project\backend

// Calcul du chemin relatif
$config_path = $dir . '/../config/config.php'; // C:\xampp\htdocs\kara_project\config\config.php

echo "Backend dir: $dir\n";
echo "Config path: $config_path\n";
echo "File exists: " . (file_exists($config_path) ? "✅ OUI" : "❌ NON") . "\n\n";

// Test 2: Vérifier les classes
$classes_path = $dir . '/classes/DataManager.php';
echo "Classes path: $classes_path\n";
echo "File exists: " . (file_exists($classes_path) ? "✅ OUI" : "❌ NON") . "\n\n";

// Test 3: Charger effectivement les fichiers
echo "Tentative de chargement:\n";
try {
    require_once $config_path;
    echo "✅ config.php chargé avec succès\n";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

try {
    require_once $classes_path;
    echo "✅ DataManager.php chargé avec succès\n";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

echo "\n✅ Test terminé avec succès!";
?>
