<?php
/**
 * ====================================================
 * FICHIER D'AIDE - Vérification du Système
 * ====================================================
 * Accès: http://localhost/kara_project/check.php
 */

require_once __DIR__ . '/config/config.php';

// Couleurs pour l'affichage
$colors = [
    'success' => '#2e7d32',
    'error' => '#c62828',
    'warning' => '#f57f17'
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification du Système</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }
        h1 {
            color: #667eea;
            margin-bottom: 30px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background: #f5f5f5;
            padding: 15px;
            border-left: 4px solid #667eea;
            margin-bottom: 15px;
            font-weight: 600;
        }
        .check-item {
            padding: 12px;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .check-item:last-child {
            border-bottom: none;
        }
        .status {
            padding: 5px 12px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 0.85em;
        }
        .status-ok {
            background: #c8e6c9;
            color: #2e7d32;
        }
        .status-error {
            background: #ffcdd2;
            color: #c62828;
        }
        .status-warning {
            background: #ffe0b2;
            color: #e65100;
        }
        .info-text {
            color: #666;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .action-btn {
            display: inline-block;
            margin-top: 15px;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
        }
        .action-btn:hover {
            background: #764ba2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🔍 Vérification du Système</h1>
        
        <!-- PHP Version -->
        <div class="section">
            <div class="section-title">📦 Environment PHP</div>
            <div class="check-item">
                <span>Version PHP</span>
                <span class="status status-ok"><?php echo phpversion(); ?></span>
            </div>
            <div class="check-item">
                <span>Extension MySQLi</span>
                <span class="status <?php echo extension_loaded('mysqli') ? 'status-ok' : 'status-error'; ?>">
                    <?php echo extension_loaded('mysqli') ? '✅ OK' : '❌ Manquante'; ?>
                </span>
            </div>
            <div class="check-item">
                <span>Extension JSON</span>
                <span class="status <?php echo extension_loaded('json') ? 'status-ok' : 'status-error'; ?>">
                    <?php echo extension_loaded('json') ? '✅ OK' : '❌ Manquante'; ?>
                </span>
            </div>
        </div>
        
        <!-- Base de Données -->
        <div class="section">
            <div class="section-title">🗄️ Base de Données</div>
            <?php
                try {
                    $db = getDB();
                    $connected = true;
                    $error = '';
                } catch (Exception $e) {
                    $connected = false;
                    $error = $e->getMessage();
                }
            ?>
            <div class="check-item">
                <span>Connexion MySQL</span>
                <span class="status <?php echo $connected ? 'status-ok' : 'status-error'; ?>">
                    <?php echo $connected ? '✅ Connectée' : '❌ Erreur'; ?>
                </span>
            </div>
            <?php if (!$connected): ?>
            <div class="info-text">❌ Erreur: <?php echo $error; ?></div>
            <?php else: ?>
            <div class="check-item">
                <span>Hôte</span>
                <span><?php echo DB_HOST; ?></span>
            </div>
            <div class="check-item">
                <span>Base de Données</span>
                <span><?php echo DB_NAME; ?></span>
            </div>
            <div class="check-item">
                <span>Charset</span>
                <span><?php echo DB_CHARSET; ?></span>
            </div>
            <?php
                // Vérifier les tables
                $result = $db->query("SHOW TABLES FROM " . DB_NAME);
                $nb_tables = $result ? $result->num_rows : 0;
                $status = $nb_tables > 0 ? 'status-ok' : 'status-warning';
                $text = $nb_tables > 0 ? "✅ $nb_tables tables" : "⚠️ Aucune table";
            ?>
            <div class="check-item">
                <span>Tables Créées</span>
                <span class="status <?php echo $status; ?>"><?php echo $text; ?></span>
            </div>
            <?php
                if ($nb_tables > 0) {
                    // Vérifier les données
                    $result = $db->query("SELECT COUNT(*) as count FROM etudiant");
                    $nb_etudiants = $result ? $result->fetch_assoc()['count'] : 0;
                    $status = $nb_etudiants > 0 ? 'status-ok' : 'status-warning';
                    $text = $nb_etudiants > 0 ? "✅ $nb_etudiants étudiants" : "⚠️ Pas de données";
                }
            ?>
            <div class="check-item">
                <span>Données Étudiants</span>
                <span class="status <?php echo $status; ?>"><?php echo $text; ?></span>
            </div>
            <?php endif; ?>
        </div>
        
        <!-- Système de Fichiers -->
        <div class="section">
            <div class="section-title">📁 Système de Fichiers</div>
            <?php
                $dirs = [
                    ['nom' => 'Dossier Backend', 'path' => __DIR__ . '/backend'],
                    ['nom' => 'Dossier Config', 'path' => __DIR__ . '/config'],
                    ['nom' => 'Dossier Logs', 'path' => __DIR__ . '/logs'],
                    ['nom' => 'Dossier Frontend', 'path' => __DIR__ . '/Maquettes_de_gestion_acad_mique_lmd']
                ];
                
                foreach ($dirs as $dir):
                    $exists = is_dir($dir['path']);
                    $readable = $exists && is_readable($dir['path']);
                    $status = $exists && $readable ? 'status-ok' : 'status-warning';
                    $text = $exists && $readable ? '✅ OK' : ($exists ? '⚠️ Non lisible' : '❌ Absent');
            ?>
            <div class="check-item">
                <span><?php echo $dir['nom']; ?></span>
                <span class="status <?php echo $status; ?>"><?php echo $text; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Classes PHP -->
        <div class="section">
            <div class="section-title">🔧 Classes & Fonctions</div>
            <?php
                $classes = [
                    ['name' => 'Database', 'file' => __DIR__ . '/config/config.php'],
                    ['name' => 'EtudiantManager', 'file' => __DIR__ . '/backend/classes/DataManager.php'],
                    ['name' => 'NoteManager', 'file' => __DIR__ . '/backend/classes/DataManager.php'],
                    ['name' => 'FiliereManager', 'file' => __DIR__ . '/backend/classes/DataManager.php'],
                ];
                
                foreach ($classes as $class):
                    $exists = file_exists($class['file']);
                    $status = $exists ? 'status-ok' : 'status-error';
                    $text = $exists ? '✅ Définie' : '❌ Manquante';
            ?>
            <div class="check-item">
                <span><?php echo $class['name']; ?></span>
                <span class="status <?php echo $status; ?>"><?php echo $text; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Fichiers Importants -->
        <div class="section">
            <div class="section-title">📄 Fichiers Important</div>
            <?php
                $files = [
                    ['name' => 'config.php', 'path' => __DIR__ . '/config/config.php'],
                    ['name' => 'DataManager.php', 'path' => __DIR__ . '/backend/classes/DataManager.php'],
                    ['name' => 'Frontend Files', 'path' => __DIR__ . '/Maquettes_de_gestion_acad_mique_lmd'],
                    ['name' => 'gestion_notes_complete.sql', 'path' => __DIR__ . '/gestion_notes_complete.sql'],
                ];
                
                foreach ($files as $file):
                    $status = file_exists($file['path']) ? 'status-ok' : 'status-error';
                    $text = file_exists($file['path']) ? '✅ Présent' : '❌ Manquant';
            ?>
            <div class="check-item">
                <span><?php echo $file['name']; ?></span>
                <span class="status <?php echo $status; ?>"><?php echo $text; ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Actions -->
        <div class="section">
            <a href="install.php" class="action-btn">🔧 Installer la BD</a>
            <a href="index.php" class="action-btn">📊 Dashboard</a>
        </div>
    </div>
</body>
</html>
