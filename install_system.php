<?php
/**
 * ====================================================
 * INSTALLATEUR SYSTÈME
 * ====================================================
 * Script d'installation des tables système
 */

// Configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'gestion_notes';

echo "<h1>Installation du Système</h1>";
echo "<p>Création des tables système...</p>";

try {
    // Connexion sans base de données sélectionnée
    $conn = new mysqli($db_host, $db_user, $db_pass);

    if ($conn->connect_error) {
        die("Échec de la connexion: " . $conn->connect_error);
    }

    // Créer la base si elle n'existe pas
    $conn->query("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci");
    $conn->select_db($db_name);

    // Lire le fichier SQL
    $sql_file = __DIR__ . '/create_system_tables.sql';
    if (!file_exists($sql_file)) {
        die("Fichier SQL introuvable: $sql_file");
    }

    $sql = file_get_contents($sql_file);

    // Exécuter chaque requête
    $queries = array_filter(array_map('trim', explode(';', $sql)));

    foreach ($queries as $query) {
        if (empty($query) || strpos($query, '--') === 0)
            continue;

        if ($conn->query($query) === FALSE) {
            // Ignorer les erreurs de type "table exists"
            if (
                strpos($conn->error, 'already exists') === false &&
                strpos($conn->error, 'Duplicate') === false
            ) {
                echo "<p style='color:orange'>Warning: " . $conn->error . "</p>";
            }
        }
    }

    echo "<h2>✅ Installation terminée!</h2>";
    echo "<h3>Tables créées:</h3>";
    echo "<ul>";

    $tables = $conn->query("SHOW TABLES");
    while ($row = $tables->fetch_row()) {
        echo "<li>" . htmlspecialchars($row[0]) . "</li>";
    }
    echo "</ul>";

    echo "<h3>Utilisateur admin par défaut:</h3>";
    echo "<ul>";
    echo "<li>Email: <strong>admin@universite.com</strong></li>";
    echo "<li>Mot de passe: <strong>admin123</strong></li>";
    echo "</ul>";

    echo "<p><a href='login.php'>Aller à la page de connexion</a></p>";

    $conn->close();

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

    h3 {
        color: #475569;
        margin-top: 20px;
    }

    p {
        color: #334155;
    }

    ul {
        color: #475569;
    }

    a {
        color: #1a56db;
        font-weight: bold;
    }
</style>