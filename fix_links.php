<?php
$dir = __DIR__ . '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/';

function recursive_fix_links($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            recursive_fix_links($path);
            continue;
        }
        
        if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            $modified = false;
            
            $backend_files = [
                'saisie_etudiants_backend.php',
                'repertoire_etudiants_backend.php',
                'saisie_deprtement_backend.php',
                'maquette_lmd_backend.php',
                'gestion_filieres_ue_backend.php',
                'saisie_ue_ec_backend.php',
                'saisie_notes_moyennes_backend.php',
                'saisie_notes_par_ec_backend.php',
                'configuration_coefficients_backend.php',
                'deliberation_final_backend.php',
                'proces_verbal_deliberation_backend.php',
                'gestion_sessions_rattrapage_backend.php',
                'statistiques_reussites_backend.php',
                'tableau_de_bord_backend.php',
                'index.php'
            ];

            foreach ($backend_files as $bf) {
                if (strpos($content, 'href="'.$bf.'"') !== false) {
                    $content = str_replace('href="'.$bf.'"', 'href="<?= $base_url . $backend_url ?>'.$bf.'"', $content);
                    $modified = true;
                }
                if (strpos($content, 'action="'.$bf.'"') !== false) {
                    $content = str_replace('action="'.$bf.'"', 'action="<?= $base_url . $backend_url ?>'.$bf.'"', $content);
                    $modified = true;
                }
            }

            if ($modified) {
                file_put_contents($path, $content);
                echo "Fixed links in: $path\n";
            }
        }
    }
}

recursive_fix_links($dir);
echo "Link fix complete.\n";
?>
