-- ====================================================
-- MIGRATION: Tables système pour l'authentification et l'audit
-- ====================================================
-- Exécuter ce fichier dans la base de données gestion_notes

-- Table pour les utilisateurs (si elle n'existe pas déjà)
CREATE TABLE IF NOT EXISTS utilisateur (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE NOT NULL,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Enseignant', 'Coordinateur') NOT NULL DEFAULT 'Enseignant',
    statut ENUM('Actif', 'Inactif') NOT NULL DEFAULT 'Actif',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    INDEX idx_email (email),
    INDEX idx_role (role),
    INDEX idx_statut (statut)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table audit_log pour tracer les actions
CREATE TABLE IF NOT EXISTS audit_log (
    id_audit BIGINT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    action VARCHAR(50) NOT NULL COMMENT 'INSERT, UPDATE, DELETE, LOGIN, LOGOUT, etc.',
    table_name VARCHAR(100) NULL COMMENT 'Table concernée par l''action',
    record_id INT NULL COMMENT 'ID de l''enregistrement concerné',
    old_values TEXT NULL COMMENT 'Anciennes valeurs en JSON',
    new_values TEXT NULL COMMENT 'Nouvelles valeurs en JSON',
    ip_address VARCHAR(45) NULL COMMENT 'Adresse IP de l''utilisateur',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_action (action),
    INDEX idx_table_name (table_name),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table app_settings pour les paramètres système
CREATE TABLE IF NOT EXISTS app_settings (
    id_setting INT PRIMARY KEY AUTO_INCREMENT,
    setting_key VARCHAR(100) UNIQUE NOT NULL,
    setting_value TEXT NULL,
    setting_type ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    category VARCHAR(50) DEFAULT 'general' COMMENT 'general, email, academic, security',
    description VARCHAR(255) NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    FOREIGN KEY (updated_by) REFERENCES utilisateur(id_user) ON DELETE SET NULL,
    INDEX idx_category (category)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table email_templates pour les modèles d'emails
CREATE TABLE IF NOT EXISTS email_templates (
    id_template INT PRIMARY KEY AUTO_INCREMENT,
    template_name VARCHAR(100) UNIQUE NOT NULL,
    subject VARCHAR(255) NOT NULL,
    body TEXT NOT NULL,
    variables VARCHAR(255) NULL COMMENT 'Variables disponibles: {nom}, {email}, etc.',
    enabled BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_enabled (enabled)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table generated_reports pour l'historique des rapports
CREATE TABLE IF NOT EXISTS generated_reports (
    id_report INT PRIMARY KEY AUTO_INCREMENT,
    department_id INT NULL,
    created_by INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    file_path VARCHAR(500) NOT NULL,
    report_type VARCHAR(50) NOT NULL,
    status ENUM('pending', 'completed', 'failed') DEFAULT 'pending',
    FOREIGN KEY (created_by) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_created_at (created_at),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Table exports_history pour l'historique des exports
CREATE TABLE IF NOT EXISTS exports_history (
    id_export INT PRIMARY KEY AUTO_INCREMENT,
    export_type VARCHAR(50) NOT NULL,
    user_id INT NOT NULL,
    filters TEXT NULL COMMENT 'Filtres appliqués en JSON',
    file_path VARCHAR(500) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES utilisateur(id_user) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_export_type (export_type),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ====================================================
-- INSERTION DES DONNÉES PAR DÉFAUT
-- ====================================================

-- Utilisateur admin par défaut (mot de passe: admin123)
-- Le mot de passe est haché avec password_hash('admin123', PASSWORD_DEFAULT)
INSERT IGNORE INTO utilisateur (id_user, email, nom, prenom, password, role, statut) 
VALUES (1, 'admin@universite.com', 'Administrateur', 'Système', 
'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin', 'Actif');

-- Paramètres système par défaut
INSERT IGNORE INTO app_settings (setting_key, setting_value, setting_type, category, description) VALUES
-- Général
('app_name', 'Gestion Académique LMD', 'string', 'general', 'Nom de l''application'),
('academic_year', '2024-2025', 'string', 'general', 'Année académique en cours'),
('university_name', 'Université', 'string', 'general', 'Nom de l''université'),
-- Email
('smtp_host', '', 'string', 'email', 'Serveur SMTP'),
('smtp_port', '587', 'number', 'email', 'Port SMTP'),
('smtp_username', '', 'string', 'email', 'Nom d''utilisateur SMTP'),
('smtp_password', '', 'string', 'email', 'Mot de passe SMTP'),
('email_from', 'noreply@universite.com', 'string', 'email', 'Email d''expédition'),
('email_reply_to', 'support@universite.com', 'string', 'email', 'Email de réponse'),
-- Académique
('semesters_per_year', '2', 'number', 'academic', 'Nombre de semestres par an'),
('credits_per_semester', '30', 'number', 'academic', 'Crédits ECTS par semestre'),
('passing_grade', '10', 'number', 'academic', 'Seuil de validation (/20)'),
-- Sécurité
('session_timeout', '3600', 'number', 'security', 'Durée de session en secondes'),
('max_login_attempts', '5', 'number', 'security', 'Nombre maximum de tentatives de connexion'),
('maintenance_mode', 'false', 'boolean', 'security', 'Mode maintenance activé');

-- Modèles d'emails par défaut
INSERT IGNORE INTO email_templates (template_name, subject, body, variables, enabled) VALUES
('resultats_etudiant', 'Vos résultats académiques - {semestre}', 
'Dear {nom} {prenom},\n\nVos résultats pour le {semestre} sont disponibles.\nMoyenne: {moyenne}\nMention: {mention}\n\nConnectez-vous à votre espace pour plus de détails.\n\nCordialement,\nL''administration', 
'{nom}, {prenom}, {semestre}, {moyenne}, {mention}', TRUE),
('avertissement_notes', 'Alerte: Notes insuffisantes', 
'Dear {nom} {prenom},\n\nNous attirons votre attention sur vos notes en {matiere}.\nNote actuelle: {note}\n\nVeuillez consulter votre enseignant.\n\nCordialement,\nL''administration', 
'{nom}, {prenom}, {matiere}, {note}', TRUE),
('confirmation_deliberation', 'Confirmation de délibération', 
'Dear {nom} {prenom},\n\nVotre situation académique a été examinée.\nDécision: {decision}\n\nPour plus d''informations, contactez le secrétariat.\n\nCordialement,\nLa commission de délibération', 
'{nom}, {prenom}, {decision}', TRUE);

-- ====================================================
-- INDEX ET CONTRAINTES ADDITIONNELS
-- ====================================================

-- Ajouter des index pour améliorer les performances
CREATE INDEX IF NOT EXISTS idx_etudiant_email ON etudiant(email);
CREATE INDEX IF NOT EXISTS idx_etudiant_statut ON etudiant(statut);
CREATE INDEX IF NOT EXISTS idx_note_session ON note(session);
CREATE INDEX IF NOT EXISTS idx_ue_semestre ON ue(semestre);