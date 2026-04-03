<?php
/**
 * Pages manquantes d'entrée - redirections
 */

// Saisie des notes
if ($_SERVER['REQUEST_URI'] === '/kara_project/saisie_notes.php') {
    require __DIR__ . '/backend/saisie_notes_par_ec_backend.php';
    exit;
}
?>
