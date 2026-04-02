<?php
/**
 * Fix Encoding Script
 * Converts files from potential ISO to UTF-8
 */
$dir = __DIR__ . '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/';

function recursive_fix_encoding($directory) {
    if (!is_dir($directory)) return;
    
    $files = scandir($directory);
    foreach ($files as $file) {
        if ($file === '.' || $file === '..') continue;
        $path = $directory . '/' . $file;
        
        if (is_dir($path)) {
            recursive_fix_encoding($path);
        } else if (pathinfo($path, PATHINFO_EXTENSION) === 'php') {
            $content = file_get_contents($path);
            
            // Check if it's already UTF-8 (simple detection)
            if (!mb_check_encoding($content, 'UTF-8')) {
                // If not UTF-8, it's likely ISO-8859-1 or CP1252
                $newContent = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');
                file_put_contents($path, $newContent);
                echo "Converted ISO -> UTF8: $path\n";
            } else {
                // It might be double-encoded or have specific artifacts
                // Let's replace the most common ones seen in the screenshot
                $replacements = [
                    'Ã©' => 'é',
                    'Ã' => 'à',
                    'Ã¨' => 'è',
                    'Ã«' => 'ë',
                    'Ãª' => 'ê',
                    'Ã®' => 'î',
                    'Ã¯' => 'ï',
                    'Ã´' => 'ô',
                    'Ã»' => 'û',
                    'Ã¹' => 'ù',
                    'Ã§' => 'ç',
                    'Ã‰' => 'É'
                ];
                $newContent = strtr($content, $replacements);
                if ($newContent !== $content) {
                    file_put_contents($path, $newContent);
                    echo "Fixed potential double-encoding or specific chars: $path\n";
                }
            }
        }
    }
}

recursive_fix_encoding($dir);
recursive_fix_encoding(__DIR__ . '/backend/');
echo "Encoding fix complete.\n";
