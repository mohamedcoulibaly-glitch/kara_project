<?php
// Fix des liens cassés dans les fichiers frontend
$files_to_fix = [
    'Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/tableau_de_bord_acad_mique/tab_de_bord.php',
    'Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/tableau_de_bord_acad_mique/code.php',
    'Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/saisie_des_notes_moyennes/saisie_notes.php',
    'Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/configuration_des_coefficients_ue_ec/configuration_des_coefficients_ue_ec.php',
    'Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/gestion_fili_res_ue/gestion_filiere_res_ue.php'
];

$base_url = '';
$backend_url = 'backend/';

foreach ($files_to_fix as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);

        // Fix tableau de bord
        if (strpos($file, 'tab_de_bord.php') !== false || strpos($file, 'code.php') !== false) {
            $content = str_replace('href="#"', 'href="' . $base_url . 'index.php"', $content);
            $content = str_replace('href="#"', 'href="' . $base_url . $backend_url . 'repertoire_etudiants_backend.php"', $content);
            $content = str_replace('href="#"', 'href="' . $base_url . $backend_url . 'saisie_notes_par_ec_backend.php"', $content);
            $content = str_replace('href="#"', 'href="' . $base_url . $backend_url . 'deliberation_backend.php"', $content);
            $content = str_replace('href="#"', 'href="' . $base_url . $backend_url . 'statistiques_reussites_backend.php"', $content);
            $content = str_replace('href="#"', 'href="' . $base_url . $backend_url . 'logout.php"', $content);
        }

        // Fix saisie_notes
        if (strpos($file, 'saisie_notes.php') !== false) {
            $content = str_replace('href="#"', 'href="' . $base_url . $backend_url . 'saisie_notes_par_ec_backend.php"', $content);
        }

        // Fix configuration
        if (strpos($file, 'configuration_des_coefficients_ue_ec.php') !== false) {
            $content = str_replace('action=""', 'action="' . $base_url . $backend_url . 'configuration_coefficients_backend.php"', $content);
        }

        // Fix gestion filieres
        if (strpos($file, 'gestion_filiere_res_ue.php') !== false) {
            $content = str_replace('<form method="GET"', '<form method="GET" action="' . $base_url . $backend_url . 'gestion_filieres_ue_backend.php"', $content);
        }

        file_put_contents($file, $content);
        echo "✓ Fixé: $file<br>";
    } else {
        echo "✗ Fichier non trouvé: $file<br>";
    }
}

echo "<h2>Fix des liens terminé</h2>";
echo "<p><a href='login.php'>Retour à la page de connexion</a></p>";
?>