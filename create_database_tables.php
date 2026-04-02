<?php
// Création des tables de base de données manquantes

require_once 'config/config.php';

$db = getDB();

// Table audit_log
$audit_log_sql = "
CREATE TABLE IF NOT EXISTS audit_log (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  action VARCHAR(50) NOT NULL,
  table_name VARCHAR(100),
  record_id INT,
  old_values JSON,
  new_values JSON,
  ip_address VARCHAR(45),
  user_agent VARCHAR(255),
  timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES utilisateur(id_user)
)";

// Table app_settings
$app_settings_sql = "
CREATE TABLE IF NOT EXISTS app_settings (
  id INT PRIMARY KEY AUTO_INCREMENT,
  setting_key VARCHAR(100) UNIQUE NOT NULL,
  setting_value LONGTEXT,
  setting_type ENUM('string', 'int', 'bool', 'json') DEFAULT 'string',
  setting_category VARCHAR(50),
  description TEXT,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_by INT,
  FOREIGN KEY (updated_by) REFERENCES utilisateur(id_user)
)";

// Table generated_reports
$generated_reports_sql = "
CREATE TABLE IF NOT EXISTS generated_reports (
  id INT PRIMARY KEY AUTO_INCREMENT,
  department_id INT NOT NULL,
  filiere_id INT,
  rapport_type VARCHAR(50) NOT NULL,
  academic_year VARCHAR(20),
  file_path VARCHAR(255) NOT NULL,
  file_size INT,
  created_by INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_downloaded DATETIME,
  deleted_at DATETIME,
  FOREIGN KEY (department_id) REFERENCES departement(id_departement),
  FOREIGN KEY (filiere_id) REFERENCES filiere(id_filiere),
  FOREIGN KEY (created_by) REFERENCES utilisateur(id_user)
)";

// Table exports_history
$exports_history_sql = "
CREATE TABLE IF NOT EXISTS exports_history (
  id INT PRIMARY KEY AUTO_INCREMENT,
  export_type VARCHAR(50) NOT NULL,
  format VARCHAR(10) NOT NULL,
  filters JSON,
  columns_list JSON,
  row_count INT,
  file_path VARCHAR(255) NOT NULL,
  file_size INT,
  created_by INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_downloaded DATETIME,
  download_count INT DEFAULT 0,
  deleted_at DATETIME,
  FOREIGN KEY (created_by) REFERENCES utilisateur(id_user)
)";

// Exécution des requêtes
$tables = [
    'audit_log' => $audit_log_sql,
    'app_settings' => $app_settings_sql,
    'generated_reports' => $generated_reports_sql,
    'exports_history' => $exports_history_sql
];

foreach ($tables as $table_name => $sql) {
    if ($db->query($sql)) {
        echo "✓ Table $table_name créée avec succès<br>";
    } else {
        echo "✗ Erreur lors de la création de $table_name: " . $db->error . "<br>";
    }
}

// Insertion des paramètres par défaut
$default_settings = [
    ['app_name', 'KARA Project', 'string', 'general', 'Nom institution'],
    ['academic_year', '2025-2026', 'string', 'academic', 'Année académique'],
    ['semesters_per_year', '2', 'int', 'academic', 'Nombre semestres'],
    ['ects_per_semester', '30', 'int', 'academic', 'Crédits ECTS par semestre'],
    ['validation_threshold', '10.00', 'string', 'academic', 'Seuil validation'],
    ['smtp_server', 'smtp.gmail.com', 'string', 'email', 'Serveur SMTP'],
    ['smtp_port', '587', 'int', 'email', 'Port SMTP'],
    ['smtp_from_email', 'noreply@institution.edu.dz', 'string', 'email', 'Email expéditeur'],
    ['session_timeout', '60', 'int', 'security', 'Durée session minutes'],
    ['max_login_attempts', '5', 'int', 'security', 'Max tentatives login']
];

$stmt = $db->prepare("INSERT IGNORE INTO app_settings (setting_key, setting_value, setting_type, setting_category, description) VALUES (?, ?, ?, ?, ?)");

foreach ($default_settings as $setting) {
    $stmt->bind_param("sssss", $setting[0], $setting[1], $setting[2], $setting[3], $setting[4]);
    if ($stmt->execute()) {
        echo "✓ Paramètre $setting[0] ajouté<br>";
    } else {
        echo "✗ Erreur pour $setting[0]: " . $db->error . "<br>";
    }
}

echo "<h2>Création des tables terminée</h2>";
echo "<p><a href='login.php'>Retour à la page de connexion</a></p>";
?>