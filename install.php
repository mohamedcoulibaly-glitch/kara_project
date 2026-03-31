<?php
/**
 * ====================================================
 * SCRIPT D'INSTALLATION
 * ====================================================
 * À exécuter une seule fois pour initialiser la BD
 * Accès: http://localhost/kara_project/install.php
 */

require_once __DIR__ . '/config/config.php';

$db = getDB();
$message = '';
$erreur = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['install'])) {
    try {
        // Lire le fichier SQL
        $sql_file = __DIR__ . '/gestion_notes_complete.sql';
        
        if (!file_exists($sql_file)) {
            throw new Exception("Fichier SQL non trouvé: $sql_file");
        }
        
        $sql = file_get_contents($sql_file);
        
        // Exécuter les requêtes SQL
        $queries = explode(';', $sql);
        
        foreach ($queries as $query) {
            $query = trim($query);
            if (!empty($query) && strpos($query, '/*') === false) {
                if (!$db->query($query)) {
                    throw new Exception("Erreur SQL: " . $db->error);
                }
            }
        }
        
        $message = "✅ Installation réussie ! La base de données a été créée et les tables initialisées.";
        
        // Créer le dossier logs s'il n'existe pas
        if (!is_dir(__DIR__ . '/logs')) {
            mkdir(__DIR__ . '/logs', 0755, true);
        }
        
    } catch (Exception $e) {
        $erreur = "❌ Erreur: " . $e->getMessage();
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation - Gestion Académique LMD</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 12px;
            padding: 40px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 600px;
            width: 100%;
        }
        
        h1 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 2em;
        }
        
        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 0.95em;
        }
        
        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .info-box h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .info-box ul {
            margin-left: 20px;
            color: #666;
            line-height: 1.8;
        }
        
        .steps {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        
        .steps h3 {
            color: #333;
            margin-bottom: 15px;
        }
        
        .step {
            display: flex;
            margin-bottom: 12px;
            align-items: flex-start;
        }
        
        .step-number {
            background: #667eea;
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            font-weight: bold;
            flex-shrink: 0;
        }
        
        .step-content {
            color: #666;
            font-size: 0.95em;
        }
        
        .button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease;
            width: 100%;
        }
        
        .button:hover {
            transform: translateY(-2px);
        }
        
        .message {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-weight: 500;
        }
        
        .success {
            background: #c8e6c9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }
        
        .error {
            background: #ffcdd2;
            color: #c62828;
            border-left: 4px solid #c62828;
        }
        
        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
        }
        
        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Installation - Gestion Académique LMD</h1>
        <p class="subtitle">Initialisation de la base de données</p>
        
        <?php if ($message): ?>
        <div class="message success"><?php echo $message; ?></div>
        <a href="index.php" class="back-link">← Retourner au Dashboard</a>
        <?php elseif ($erreur): ?>
        <div class="message error"><?php echo $erreur; ?></div>
        <?php endif; ?>
        
        <?php if (!$message): ?>
        <div class="info-box">
            <h3>📋 Informations sur l'Installation</h3>
            <ul>
                <li>Cette page initialise la base de données</li>
                <li>Crée toutes les tables nécessaires</li>
                <li>Insère les données de démonstration</li>
                <li>À exécuter une seule fois</li>
            </ul>
        </div>
        
        <div class="steps">
            <h3>📝 Étapes de l'Installation</h3>
            <div class="step">
                <div class="step-number">1</div>
                <div class="step-content">Création des tables principales (Étudiants, Notes, Filières, etc.)</div>
            </div>
            <div class="step">
                <div class="step-number">2</div>
                <div class="step-content">Création des tables de délibérations et procès-verbaux</div>
            </div>
            <div class="step">
                <div class="step-number">3</div>
                <div class="step-content">Insertion de données de teste</div>
            </div>
            <div class="step">
                <div class="step-number">4</div>
                <div class="step-content">Configuration des index et contraintes</div>
            </div>
        </div>
        
        <form method="POST">
            <button type="submit" name="install" class="button">✅ Procéder à l'Installation</button>
        </form>
        
        <div class="info-box" style="margin-top: 30px; background: #fff3cd; border-left-color: #ffc107;">
            <h3 style="color: #856404;">⚠️ Attention</h3>
            <ul style="color: #856404;">
                <li>Assurez-vous que la base de données existe</li>
                <li>Vérifiez les identifiants dans config/config.php</li>
                <li>Cette action supprimera les données existantes</li>
            </ul>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>
