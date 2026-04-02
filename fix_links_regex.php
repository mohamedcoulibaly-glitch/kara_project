<?php
$dir = __DIR__ . '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/';

function recursive_regex_fix_links($dir) {
    if (!is_dir($dir)) return;
    $files = scandir($dir);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $dir . DIRECTORY_SEPARATOR . $file;
        if (is_dir($path)) {
            recursive_regex_fix_links($path);
        } elseif (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            $modified = false;

            // Pattern: href="something_backend.php[?anything]"
            // But NOT if already prefixed with <?=
            $pattern_href = '/href="(?!\<\?)([^"]+?_backend\.php(\?[^"]*)?)"/';
            if (preg_match($pattern_href, $content)) {
                $content = preg_replace($pattern_href, 'href="<?= $base_url . $backend_url ?>$1"', $content);
                $modified = true;
            }
            
            $pattern_action = '/action="(?!\<\?)([^"]+?_backend\.php(\?[^"]*)?)"/';
            if (preg_match($pattern_action, $content)) {
                $content = preg_replace($pattern_action, 'action="<?= $base_url . $backend_url ?>$1"', $content);
                $modified = true;
            }

            if ($modified) {
                file_put_contents($path, $content);
                echo "Fixed regex links in: $path\n";
            }
        }
    }
}

recursive_regex_fix_links($dir);
echo "Regex link fix complete.\n";
