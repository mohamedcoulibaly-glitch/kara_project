<?php
/**
 * Vérification des chemins corrigés
 */
echo "Vérification des chemins de fichiers Maquettes:\n";
echo "═══════════════════════════════════════════════\n\n";

$base_dir = __DIR__;
$backend_dir = $base_dir . '/backend';

// Fichiers à tester
$files_to_test = [
    'carte_etudiant.php' => '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/carte_d_tudiant_pdf/carte_etudiant.php',
    'attestaion_de_reussite.php' => '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/attestation_de_r_ussite_pdf/attestaion_de_reussite.php',
    'configuration_des_coefficients_ue_ec.php' => '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/configuration_des_coefficients_ue_ec/configuration_des_coefficients_ue_ec.php',
    'deliberation_final_academique.php' => '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/d_lib_ration_finale_acad_mique/deliberation_final_academique.php',
];

foreach ($files_to_test as $file => $path) {
    $full_path = $base_dir . $path;
    $exists = file_exists($full_path);
    
    echo ($exists ? "✅ " : "❌ ") . $file . "\n";
    echo "   Chemin: " . (strlen($full_path) > 80 ? substr($full_path, 0, 77) . "..." : $full_path) . "\n";
    echo "\n";
}

echo "═══════════════════════════════════════════════\n";
echo "✅ Vérification complète!\n";
?>
