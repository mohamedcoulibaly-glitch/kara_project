<?php
/**
 * ====================================================
 * SCRIPT CLI: Migration Base de Données
 * ====================================================
 * Importe les données SQL dans MySQL
 * Usage: php import_database.php
 */

require_once __DIR__ . '/config/config.php';

echo "\n";
echo "═══════════════════════════════════════════════════\n";
echo "  ✓ MIGRATION BASE DE DONNÉES - GESTION ACADÉMIQUE\n";
echo "═══════════════════════════════════════════════════\n\n";

$db = getDB();

if (!$db) {
    echo "❌ ERREUR: Impossible de connecter à la base de données\n";
    echo "   Vérifiez la configuration dans config/config.php\n\n";
    exit(1);
}

echo "✓ Connexion à MySQL établie\n";
echo "✓ Base de données: " . DB_NAME . "\n\n";

// Fichier SQL à importer
$sql_file = __DIR__ . '/gestion_notes_complete.sql';

if (!file_exists($sql_file)) {
    echo "❌ ERREUR: Fichier SQL non trouvé: $sql_file\n\n";
    exit(1);
}

echo "📂 Fichier: gestion_notes_complete.sql\n";
echo "📊 Taille: " . round(filesize($sql_file) / 1024, 2) . " KB\n\n";

// Lire le contenu SQL
echo "⏳ Lecture du fichier SQL...\n";
$sql_content = file_get_contents($sql_file);
echo "   ✓ " . strlen($sql_content) . " caractères lus\n\n";

// Diviser les requêtes
echo "⏳ Parsing des requêtes SQL...\n";
$statements = preg_split('/;[\s]*\n/', $sql_content);

$total_queries = 0;
$successful_queries = 0;
$failed_queries = 0;
$errors = [];

foreach ($statements as $statement) {
    $statement = trim($statement);
    
    // Ignorer les commentaires et lignes vides
    if (empty($statement) || 
        strpos($statement, '/*') === 0 || 
        strpos($statement, '--') === 0 ||
        strpos($statement, '#') === 0) {
        continue;
    }

    $total_queries++;

    // Ajouter le point-virgule si manquant
    if (substr($statement, -1) !== ';') {
        $statement .= ';';
    }

    // Limiter l'affichage de la requête
    $display_query = substr($statement, 0, 80);
    if (strlen($statement) > 80) {
        $display_query .= '...';
    }

    try {
        if ($db->query($statement)) {
            $successful_queries++;
            echo "   ✓ [" . str_pad($total_queries, 3, ' ', STR_PAD_LEFT) . "] " . $display_query . "\n";
        } else {
            $failed_queries++;
            $errors[] = [
                'query' => substr($statement, 0, 100),
                'error' => $db->error
            ];
            echo "   ✗ [" . str_pad($total_queries, 3, ' ', STR_PAD_LEFT) . "] " . $display_query . "\n";
            echo "      Erreur: " . $db->error . "\n";
        }
    } catch (Exception $e) {
        $failed_queries++;
        $errors[] = [
            'query' => substr($statement, 0, 100),
            'error' => $e->getMessage()
        ];
        echo "   ✗ [" . str_pad($total_queries, 3, ' ', STR_PAD_LEFT) . "] " . $display_query . "\n";
        echo "      Erreur: " . $e->getMessage() . "\n";
    }
}

// Résumé
echo "\n";
echo "═══════════════════════════════════════════════════\n";
echo "  📊 RÉSUMÉ DE L'IMPORT\n";
echo "═══════════════════════════════════════════════════\n\n";

printf("  Total requêtes:      %3d\n", $total_queries);
printf("  ✓ Réussies:          %3d (%.1f%%)\n", $successful_queries, $total_queries > 0 ? ($successful_queries/$total_queries)*100 : 0);
printf("  ✗ Échouées:          %3d (%.1f%%)\n\n", $failed_queries, $total_queries > 0 ? ($failed_queries/$total_queries)*100 : 0);

// Vérifier l'état de la BD
echo "═══════════════════════════════════════════════════\n";
echo "  📋 VÉRIFICATION DE LA BASE DE DONNÉES\n";
echo "═══════════════════════════════════════════════════\n\n";

$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE()";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $tables = $result->fetch_all(MYSQLI_ASSOC);
        $table_count = count($tables);
        printf("  Tables créées: %d\n\n", $table_count);
        
        $total_records = 0;
        foreach ($tables as $table) {
            $table_name = $table['TABLE_NAME'];
            
            // Compter les enregistrements
            $count_query = "SELECT COUNT(*) as count FROM " . $db->real_escape_string($table_name);
            $count_stmt = $db->prepare($count_query);
            if ($count_stmt->execute()) {
                $count_result = $count_stmt->get_result();
                if ($count_result) {
                    $row = $count_result->fetch_assoc();
                    $count = $row['count'];
                    $total_records += $count;
                    printf("  • %-25s %6d enregistrements\n", $table_name, $count);
                }
            }
        }
        printf("\n  Total: %d enregistrements\n\n", $total_records);
    }
}

// Résultat final
echo "═══════════════════════════════════════════════════\n";
if ($failed_queries === 0 && $successful_queries > 0) {
    echo "\n  ✅ MIGRATION RÉUSSIE!\n\n";
    echo "  La base de données a été importée avec succès.\n";
    echo "  Vous pouvez maintenant utiliser le système.\n";
    echo "\n  Accueil: http://localhost/kara_project/accueil.php\n";
    exit(0);
} elseif ($failed_queries > 0) {
    echo "\n  ⚠️  IMPORT PARTIEL\n\n";
    printf("  %d requête(s) ont échoué sur %d\n\n", $failed_queries, $total_queries);
    
    if (!empty($errors)) {
        echo "  Erreurs rencontrées:\n";
        foreach ($errors as $i => $error) {
            echo "    " . ($i + 1) . ". " . $error['query'] . "\n";
            echo "       → " . $error['error'] . "\n";
        }
    }
    
    exit(1);
} else {
    echo "\n  ⚠️  AUCUNE REQUÊTE À IMPORTER\n\n";
    exit(1);
}

?>
