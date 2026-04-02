<?php
/**
 * Fix Extract Script
 * Ensured extract($data_array) is called before template inclusion
 */
$dir = __DIR__ . '/backend/';
$files = scandir($dir);

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
        $path = $dir . $file;
        $content = file_get_contents($path);
        
        // Find the data array variable name (e.g. $pv_data, $repertoire_data, etc)
        if (preg_match('/\$(\w+_data)\s*=\s*\[/', $content, $matches)) {
            $data_var = $matches[1];
            
            // Check if extract($data_var) is NOT already there
            if (strpos($content, "extract(\$$data_var)") === false) {
                // Find where the template is included
                // include ... Maquettes_de_gestion_acad_mique_lmd ...
                if (preg_match('/(include\s+__DIR__\s*\.\s*\'\/\.\.\/Maquettes_de_gestion_acad_mique_lmd)/', $content, $inc_matches)) {
                    $target = $inc_matches[1];
                    $new_content = str_replace($target, "extract(\$$data_var);\n" . $target, $content);
                    file_put_contents($path, $new_content);
                    echo "Fixed extract for: $file (using \$$data_var)\n";
                }
            }
        }
    }
}
echo "Extract fix complete.\n";
