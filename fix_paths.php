<?php
$dir = __DIR__ . '/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/';
$it = new RecursiveDirectoryIterator($dir);
foreach (new RecursiveIteratorIterator($it) as $file) {
    if ($file->getExtension() == 'php') {
        $content = file_get_contents($file);
        $new_content = str_replace(
            "include __DIR__ . '/../../../../../backend/includes/sidebar.php';",
            "include __DIR__ . '/../../../../backend/includes/sidebar.php';",
            $content
        );
        $new_content = str_replace(
             "include __DIR__ . '/../../../../../backend/includes/footer.php';",
             "include __DIR__ . '/../../../../backend/includes/footer.php';",
             $new_content
        );
        if ($content !== $new_content) {
            file_put_contents($file, $new_content);
            echo "Updated: " . $file->getFilename() . "\n";
        }
    }
}
echo "Path fix complete.\n";
