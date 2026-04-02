<?php
/**
 * Script de migration pour adapter la base de données existante
 */

require_once __DIR__ . '/config/config.php';

echo "<h1>Migration de la base de données</h1>";

try {
    $db = getDB();

    // Migration SQL
    $sql = file_get_contents(__DIR__ . '/fix_user_table_migration.sql');

    // Exécuter chaque requête
    $queries = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($queries as $query) {
        if (empty($query) || strpos($query, '--') === 0)
            continue;

        if ($db->query($query) === FALSE) {
            echo "<p style='color:orange'>Warning: " . $db->error . "</p>";
        } else {
            echo "<p style='color:green'>✓ " . substr($query, 0, 50) . "...</p>";
        }
    }

    echo "<h2>Migration terminée avec succès!</h2>";
    echo "<p>La table utilisateur a été mise à jour et les tables système ont été créées.</p>";
    echo "<p><a href='login.php'>Aller à la page de connexion</a></p>";

} catch (Exception $e) {
    echo "<p style='color:red'>Erreur: " . $e->getMessage() . "</p>";
}
?>

<style>
    body {
        font-family: Arial, sans-serif;
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
    }

    h1 {
        color: #1a56db;
    }

    h2 {
        color: #16a34a;
    }

    p {
        color: #334155;
    }
</style>