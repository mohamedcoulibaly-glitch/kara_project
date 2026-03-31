<?php
/**
 * ====================================================
 * SCRIPT D'INSTALLATION DE LA BASE DE DONNÉES
 * ====================================================
 * Exécute directement l'import SQL
 */

// Configuration
$db_host = 'localhost';
$db_user =  'root';
$db_pass = '';
$db_name = 'gestion_notes';

echo "═══════════════════════════════════════════════════════════\n";
echo "🔧 Migration Base de Données - Gestion Académique LMD v2.0\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Étape 1: Connexion sans BD
echo "[1/4] Connexion à MySQL...\n";
$mysqli = new mysqli($db_host, $db_user, $db_pass);

if ($mysqli->connect_error) {
    die("❌ Erreur de connexion: " . $mysqli->connect_error . "\n");
}
echo "✅ Connecté avec succès\n\n";

// Étape 2: Supprimer BD existante
echo "[2/4] Suppression de l'ancienne base (si existe)...\n";
$sql = "DROP DATABASE IF EXISTS `$db_name`";
if ($mysqli->query($sql)) {
    echo "✅ Ancienne base supprimée\n\n";
} else {
    echo "⚠️ Pas d'ancienne base à supprimer\n\n";
}

// Étape 3: Créer nouvelle BD
echo "[3/4] Création de la nouvelle base de données...\n";
$sql = "CREATE DATABASE `$db_name` 
        CHARACTER SET utf8mb4 
        COLLATE utf8mb4_general_ci";

if ($mysqli->query($sql)) {
    echo "✅ Base de données créée avec succès\n\n";
} else {
    die("❌ Erreur création BD: " . $mysqli->error . "\n");
}

// Étape 4: Importer les tables
echo "[4/4] Import des tables et données...\n";
$mysqli->select_db($db_name);

// Lire le fichier SQL
$sql_file = __DIR__ . '/gestion_notes_complete.sql';

if (!file_exists($sql_file)) {
    die("❌ Fichier SQL non trouvé: $sql_file\n");
}

$sql_content = file_get_contents($sql_file);

// Séparer les requêtes
$queries = explode(';', $sql_content);
$query_count = 0;

foreach ($queries as $query) {
    $query = trim($query);
    
    // Ignorer les commentaires et lignes vides
    if (empty($query) || strpos($query, '/*') === 0 || strpos($query, '--') === 0) {
        continue;
    }
    
    // Exécuter la requête
    if ($mysqli->query($query)) {
        $query_count++;
    } else {
        echo "⚠️ Erreur: " . $mysqli->error . "\n";
        echo "Query: " . substr($query, 0, 100) . "...\n\n";
    }
}

echo "✅ $query_count requêtes exécutées avec succès\n\n";

// Vérification finale
echo "═══════════════════════════════════════════════════════════\n";
echo "🔍 Vérification de l'installation...\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Compter les tables
$result = $mysqli->query("SELECT TABLE_NAME FROM information_schema.TABLES 
                         WHERE TABLE_SCHEMA = '$db_name'");
$table_count = $result->num_rows;
echo "📊 Nombre de tables créées: $table_count\n";

// Lister les tables
echo "\n📋 Tables créées:\n";
while ($row = $result->fetch_assoc()) {
    echo "   ✓ " . $row['TABLE_NAME'] . "\n";
}

// Vérifier les données de test
echo "\n📈 Données de test:\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM etudiant");
$row = $result->fetch_assoc();
echo "   • Étudiants: " . $row['count'] . "\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM departement");
$row = $result->fetch_assoc();
echo "   • Départements: " . $row['count'] . "\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM filiere");
$row = $result->fetch_assoc();
echo "   • Filières: " . $row['count'] . "\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM ue");
$row = $result->fetch_assoc();
echo "   • Unités d'Enseignement: " . $row['count'] . "\n";

$result = $mysqli->query("SELECT COUNT(*) as count FROM note");
$row = $result->fetch_assoc();
echo "   • Notes: " . $row['count'] . "\n";

echo "\n═══════════════════════════════════════════════════════════\n";
echo "✅ MIGRATION RÉUSSIE!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "🎉 La base de données est prête à l'emploi!\n\n";
echo "Prochaines étapes:\n";
echo "1. Accédez à: http://localhost/kara_project/\n";
echo "2. Ou lancez: http://localhost/kara_project/check.php\n";
echo "3. Pour voir l'état du système\n\n";

$mysqli->close();

?>
