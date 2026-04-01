<?php
/**
 * ====================================================
 * MIGRATION: Import de la Base de Données
 * ====================================================
 * Script pour importer les données SQL dans MySQL
 */

require_once __DIR__ . '/config/config.php';

$db = getDB();
$message = '';
$type_message = '';

// Lister les fichiers SQL disponibles
$sql_files = [
    'gestion_notes_complete.sql' => 'Base complète avec toutes les données',
    'gestion_notes.sql' => 'Base de base - structure minimale'
];

$migration_status = [
    'total_queries' => 0,
    'successful_queries' => 0,
    'failed_queries' => 0,
    'errors' => []
];

// Traiter la soumission du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'migrate') {
    $sql_file = $_POST['sql_file'] ?? '';
    $file_path = __DIR__ . '/' . $sql_file;

    if (!file_exists($file_path)) {
        $message = "Fichier non trouvé: $sql_file";
        $type_message = 'error';
    } else {
        // Lire le fichier SQL
        $sql_content = file_get_contents($file_path);
        
        // Diviser les requêtes SQL
        $statements = preg_split('/;[\s]*\n/', $sql_content);
        
        foreach ($statements as $statement) {
            $statement = trim($statement);
            
            if (empty($statement) || strpos($statement, '/*') === 0 || strpos($statement, '--') === 0) {
                continue;
            }

            $migration_status['total_queries']++;

            // Ajouter le point-virgule s'il manque
            if (substr($statement, -1) !== ';') {
                $statement .= ';';
            }

            try {
                if ($db->query($statement)) {
                    $migration_status['successful_queries']++;
                } else {
                    $migration_status['failed_queries']++;
                    $migration_status['errors'][] = [
                        'query' => substr($statement, 0, 100),
                        'error' => $db->error
                    ];
                }
            } catch (Exception $e) {
                $migration_status['failed_queries']++;
                $migration_status['errors'][] = [
                    'query' => substr($statement, 0, 100),
                    'error' => $e->getMessage()
                ];
            }
        }

        if ($migration_status['successful_queries'] > 0) {
            $message = $migration_status['successful_queries'] . ' requête(s) exécutée(s) avec succès';
            $type_message = 'success';
        }

        if ($migration_status['failed_queries'] > 0) {
            $message .= ($message ? ' | ' : '') . $migration_status['failed_queries'] . ' erreur(s)';
            $type_message = 'error';
        }
    }
}

// Vérifier l'état de la base de données
$db_info = [
    'tables' => 0,
    'total_records' => 0,
    'tables_list' => []
];

$query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE()";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $tables = $result->fetch_all(MYSQLI_ASSOC);
        $db_info['tables'] = count($tables);
        
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
                    $db_info['total_records'] += $count;
                    $db_info['tables_list'][$table_name] = $count;
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Migration Base de Données</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-slate-50">

<!-- Header -->
<header class="bg-white shadow-sm p-6 border-b">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-blue-700">Migration Base de Données</h1>
        <p class="text-slate-600 mt-1">Importer les données SQL dans MySQL</p>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-6xl mx-auto p-6 space-y-6">

    <?php if ($message): ?>
    <div class="p-4 rounded-lg <?php echo $type_message === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800'; ?>">
        <div class="flex items-start gap-3">
            <span class="material-symbols-outlined">
                <?php echo $type_message === 'success' ? 'check_circle' : 'error'; ?>
            </span>
            <div>
                <p class="font-semibold"><?php echo htmlspecialchars($message); ?></p>
                <?php if (!empty($migration_status['errors'])): ?>
                <details class="mt-2 cursor-pointer">
                    <summary class="font-semibold text-sm">Afficher les détails des erreurs</summary>
                    <div class="mt-3 space-y-2 text-sm">
                        <?php foreach ($migration_status['errors'] as $error): ?>
                        <div class="bg-white/50 p-2 rounded border-l-2 border-red-500">
                            <p class="font-mono text-xs"><?php echo htmlspecialchars($error['query']); ?>...</p>
                            <p class="text-xs text-red-700"><?php echo htmlspecialchars($error['error']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </details>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulaire de Migration -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-bold mb-4">Importer les données</h2>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="migrate">
                    
                    <div>
                        <label class="block text-sm font-bold uppercase tracking-wider mb-2">Fichier SQL</label>
                        <select name="sql_file" required class="w-full border rounded-lg px-4 py-2">
                            <option value="">-- Sélectionner --</option>
                            <?php foreach ($sql_files as $file => $description): ?>
                            <option value="<?php echo $file; ?>">
                                <?php echo "$file - $description"; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 text-sm">
                        <p class="font-semibold text-yellow-800 flex items-center gap-2">
                            <span class="material-symbols-outlined text-lg">warning</span>
                            Attention
                        </p>
                        <p class="text-yellow-700 mt-1">
                            Cette opération va importer les données dans la base MySQL actuelle.
                            Assurez-vous d'avoir une sauvegarde avant de procéder.
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                        Démarrer la migration
                    </button>
                </form>
            </div>
        </div>

        <!-- État de la Base de Données -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Statistiques -->
            <div class="grid grid-cols-2 gap-4">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-slate-600 font-semibold mb-2">Tables</p>
                    <p class="text-4xl font-bold text-blue-600"><?php echo $db_info['tables']; ?></p>
                </div>
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <p class="text-sm text-slate-600 font-semibold mb-2">Total Records</p>
                    <p class="text-4xl font-bold text-green-600"><?php echo $db_info['total_records']; ?></p>
                </div>
            </div>

            <!-- Liste des Tables -->
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6 border-b font-bold">Contenu de la Base de Données</div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-slate-50 border-b">
                            <tr>
                                <th class="px-4 py-3 text-left font-bold">Table</th>
                                <th class="px-4 py-3 text-right font-bold">Enregistrements</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y">
                            <?php foreach ($db_info['tables_list'] as $table => $count): ?>
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-mono"><?php echo htmlspecialchars($table); ?></td>
                                <td class="px-4 py-3 text-right">
                                    <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-bold">
                                        <?php echo $count; ?>
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Résumé de la Migration -->
            <?php if ($migration_status['total_queries'] > 0): ?>
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h3 class="font-bold mb-4">Résumé de la Migration</h3>
                <div class="space-y-2">
                    <p class="flex justify-between">
                        <span>Total requêtes:</span>
                        <span class="font-bold"><?php echo $migration_status['total_queries']; ?></span>
                    </p>
                    <p class="flex justify-between text-green-600">
                        <span>Réussies:</span>
                        <span class="font-bold"><?php echo $migration_status['successful_queries']; ?></span>
                    </p>
                    <p class="flex justify-between text-red-600">
                        <span>Échouées:</span>
                        <span class="font-bold"><?php echo $migration_status['failed_queries']; ?></span>
                    </p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

</main>

</body>
</html>
