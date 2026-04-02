-- Migration pour adapter la table utilisateur existante
-- Ajout des colonnes nécessaires pour le système d'authentification complet

ALTER TABLE `utilisateur` 
ADD COLUMN IF NOT EXISTS `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
ADD COLUMN IF NOT EXISTS `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
ADD COLUMN IF NOT EXISTS `last_login` TIMESTAMP NULL,
ADD COLUMN IF NOT EXISTS `nom_utilisateur` VARCHAR(100) UNIQUE NULL AFTER `email`;

-- Mettre à jour les utilisateurs existants
UPDATE `utilisateur` SET `nom_utilisateur` = `email` WHERE `nom_utilisateur` IS NULL;

-- Créer les tables système manquantes
CREATE TABLE IF NOT EXISTS `audit_log` (
    `id_audit` BIGINT PRIMARY KEY AUTO_INCREMENT,
    `user_id` INT NOT NULL,
    `action` VARCHAR(50) NOT NULL,
    `table_name` VARCHAR(100) NULL,
    `record_id` INT NULL,
    `old_values` TEXT NULL,
    `new_values` TEXT NULL,
    `ip_address` VARCHAR(45) NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`user_id`) REFERENCES `utilisateur`(`id_user`) ON DELETE CASCADE,
    INDEX `idx_user_id` (`user_id`),
    INDEX `idx_action` (`action`),
    INDEX `idx_table_name` (`table_name`),
    INDEX `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `app_settings` (
    `id_setting` INT PRIMARY KEY AUTO_INCREMENT,
    `setting_key` VARCHAR(100) UNIQUE NOT NULL,
    `setting_value` TEXT NULL,
    `setting_type` ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
    `category` VARCHAR(50) DEFAULT 'general',
    `description` VARCHAR(255) NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `updated_by` INT NULL,
    FOREIGN KEY (`updated_by`) REFERENCES `utilisateur`(`id_user`) ON DELETE SET NULL,
    INDEX `idx_category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `email_templates` (
    `id_template` INT PRIMARY KEY AUTO_INCREMENT,
    `template_name` VARCHAR(100) UNIQUE NOT NULL,
    `subject` VARCHAR(255) NOT NULL,
    `body` TEXT NOT NULL,
    `variables` VARCHAR(255) NULL,
    `enabled` BOOLEAN DEFAULT TRUE,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX `idx_enabled` (`enabled`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insérer les paramètres système par défaut
INSERT IGNORE INTO `app_settings` (`setting_key`, `setting_value`, `setting_type`, `category`, `description`) VALUES
('app_name', 'Gestion Académique LMD', 'string', 'general', 'Nom de l''application'),
('academic_year', '2024-2025', 'string', 'general', 'Année académique en cours'),
('university_name', 'Université', 'string', 'general', 'Nom de l''université'),
('session_timeout', '3600', 'number', 'security', 'Durée de session en secondes'),
('max_login_attempts', '5', 'number', 'security', 'Nombre maximum de tentatives de connexion'),
('maintenance_mode', 'false', 'boolean', 'security', 'Mode maintenance activé');

-- Insérer les modèles d'emails par défaut
INSERT IGNORE INTO `email_templates` (`template_name`, `subject`, `body`, `variables`, `enabled`) VALUES
('resultats_etudiant', 'Vos résultats académiques - {semestre}', 
'Dear {nom} {prenom},\n\nVos résultats pour le {semestre} sont disponibles.\nMoyenne: {moyenne}\nMention: {mention}\n\nConnectez-vous à votre espace pour plus de détails.\n\nCordialement,\nL''administration', 
'{nom}, {prenom}, {semestre}, {moyenne}, {mention}', TRUE),
('avertissement_notes', 'Alerte: Notes insuffisantes', 
'Dear {nom} {prenom},\n\nNous attirons votre attention sur vos notes en {matiere}.\nNote actuelle: {note}\n\nVeuillez consulter votre enseignant.\n\nCordialement,\nL''administration', 
'{nom}, {prenom}, {matiere}, {note}', TRUE);

-- Mettre à jour le mot de passe de l'utilisateur admin existant si besoin
-- (Si le mot de passe n'est pas déjà haché)
UPDATE `utilisateur` SET `password` = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi' 
WHERE `email` = 'admin@univ.local' AND `password` = '$2y$10$YourHashedPasswordHere';