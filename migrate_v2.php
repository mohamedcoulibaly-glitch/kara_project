<?php
/**
 * ====================================================
 * SCRIPT D'INSTALLATION DE LA BASE DE DONNÉES V2
 * ====================================================
 * Approche: Lecture et exécution ligne par ligne
 */

// Configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'gestion_notes';

echo "═══════════════════════════════════════════════════════════\n";
echo "🔧 Migration Base de Données - Gestion Académique LMD v2.1\n";
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
$sql = "CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci";

if ($mysqli->query($sql)) {
    echo "✅ Base de données créée avec succès\n\n";
} else {
    die("❌ Erreur création BD: " . $mysqli->error . "\n");
}

$mysqli->select_db($db_name);

// Étape 4: Importer les tables - methode améliorée
echo "[4/4] Import des tables et données...\n";

$sql_file = __DIR__ . '/gestion_notes_complete.sql';

if (!file_exists($sql_file)) {
    die("❌ Fichier SQL non trouvé: $sql_file\n");
}

// Lire le fichier
$sql_content = file_get_contents($sql_file);

// Parser les requêtes entre `;`
// Stratégie: on va itérer caractère par caractère pour gérer les requêtes multi-lignes
$queries = array();
$current_query = '';

$lines = explode("\n", $sql_content);
foreach ($lines as $line) {
    // Ignorer les commentaires
    if (trim($line) === '' || strpos(trim($line), '--') === 0) {
        continue;
    }
    
    $current_query .= ' ' . $line;
    
    // Si la ligne se termine par `;`, c'est la fin d'une requête
    if (substr(trim($line), -1) === ';') {
        $query = trim($current_query);
        if (!empty($query)) {
            $queries[] = $query;
        }
        $current_query = '';
    }
}

echo "📝 " . count($queries) . " requêtes détectées\n";
echo "Exécution...\n\n";

$executed = 0;
$errors = 0;

foreach ($queries as $i => $query) {
    $query = trim($query);
    
    if (empty($query)) {
        continue;
    }
    
    // Ignorer les commentaires et les pragmas MySQL
    if (strpos($query, '/*') === 0 || strpos($query, '/*!') === 0 || strpos($query, '--') === 0) {
        continue;
    }
    
    // Afficher la progression
    if (strpos(strtoupper($query), 'CREATE TABLE') === 0) {
        // Extraire le nom de la table
        if (preg_match('/CREATE TABLE.*?`(\w+)`/', $query, $matches)) {
            echo "  • Création de table: " . $matches[1];
        }
    } elseif (strpos(strtoupper($query), 'INSERT INTO') === 0) {
        echo "  • Insertion de données";
    }
    
    // Exécuter la requête
    if ($mysqli->query($query)) {
        echo " ✓\n";
        $executed++;
    } else {
        echo " ✗\n";
        echo "    Erreur: " . $mysqli->error . "\n";
        $errors++;
    }
}

echo "\n━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n";
echo "✅ Requêtes exécutées: $executed\n";
if ($errors > 0) {
    echo "⚠️ Erreurs rencontrées: $errors\n";
}
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━\n\n";

// Vérification finale
echo "═══════════════════════════════════════════════════════════\n";
echo "🔍 Vérification de l'installation...\n";
echo "═══════════════════════════════════════════════════════════\n\n";

// Compter les tables
$result = $mysqli->query("SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$db_name'");
$tables = array();
while ($row = $result->fetch_assoc()) {
    $tables[] = $row['TABLE_NAME'];
}
$table_count = count($tables);

echo "📊 Nombre de tables créées: $table_count/15\n";
echo "\n📋 Tables créées:\n";
foreach ($tables as $table) {
    echo "   ✓ $table\n";
}

if ($table_count === 15) {
    echo "\n✅ Toutes les 15 tables ont été créées correctement!\n";
} else {
    echo "\n⚠️ Attention: " . (15 - $table_count) . " table(s) manquante(s)\n";
}

// Vérifier les données de test
echo "\n📈 Données de test:\n";

$tables_check = array(
    'etudiant' => 'Étudiants',
    'departement' => 'Départements',
    'filiere' => 'Filières',
    'ue' => 'Unités d\'Enseignement',
    'note' => 'Notes',
    'utilisateur' => 'Utilisateurs'
);

foreach ($tables_check as $table => $label) {
    if (in_array($table, $tables)) {
        $result = $mysqli->query("SELECT COUNT(*) as count FROM $table");
        if ($result) {
            $row = $result->fetch_assoc();
            echo "   • $label: " . $row['count'] . " enregistrement(s)\n";
        }
    } else {
        echo "   • $label: ❌ Table non créée\n";
    }
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "✅ MIGRATION COMPLÈTE!\n";
echo "═══════════════════════════════════════════════════════════\n\n";

echo "🎉 La base de données est maintenant prête à l'emploi!\n\n";
echo "Prochaines étapes:\n";
echo "1. Accédez à: http://localhost/kara_project/\n";
echo "2. Ou: http://localhost/kara_project/check.php\n";
echo "3. Puis testez les modules\n\n";

$mysqli->close();

?>
