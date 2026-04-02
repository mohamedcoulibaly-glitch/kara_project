<?php
/**
 * logout.php - Détruit la session et redirige vers l'accueil
 */
session_start();
session_unset();
session_destroy();

// Rediriger vers l'index à la racine du projet
header("Location: ../index.php");
exit();
?>
