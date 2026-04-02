<?php
/**
 * ====================================================
 * SCRIPT DE RÉPARATION ET MIGRATION DE LA BASE DE DONNÉES
 * ====================================================
 * Ce script ajoute les colonnes et tables manquantes sans
 * supprimer les données existantes.
 */

require_once __DIR__ . '/config/config.php';

echo "<!DOCTYPE html>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Réparation de la Base de Données</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; color: #333; max-width: 900px; margin: 0 auto; padding: 20px; background: #f4f7f6; }
        .container { background: white; padding: 30px; border-radius: 8px; shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2c3e50; border-bottom: 2px solid #3498db; padding-bottom: 10px; }
        .success { color: #27ae60; font-weight: bold; }
        .error { color: #c0392b; font-weight: bold; background: #fdf2f2; padding: 10px; border-radius: 4px; margin: 10px 0; border-left: 4px solid #c0392b; }
        .info { color: #2980b9; }
        .step { margin-bottom: 10px; padding: 5px 0; border-bottom: 1px solid #eee; }
        .summary { margin-top: 30px; padding: 20px; background: #e8f4f8; border-radius: 8px; }
    </style>
</head>
<body>
<div class='container'>
    <h1>🔧 Réparation du Système de Base de Données</h1>";

$db = getDB();
if (!$db) {
    echo "<div class='error'>Échec de la connexion à la base de données. Vérifiez votre fichier config/config.php</div>";
    exit;
}

function columnExists($table, $column) {
    global $db;
    $result = $db->query("SHOW COLUMNS FROM `$table` LIKE '$column'");
    return $result && $result->num_rows > 0;
}

function tableExists($table) {
    global $db;
    $result = $db->query("SHOW TABLES LIKE '$table'");
    return $result && $result->num_rows > 0;
}

function executeQuery($sql, $description) {
    global $db;
    echo "<div class='step'>$description... ";
    if ($db->query($sql)) {
        echo "<span class='success'>OK</span></div>";
        return true;
    } else {
        echo "<span class='error'>ERREUR: " . $db->error . "</span></div>";
        return false;
    }
}

// --- 1. TABLE UTILISATEUR ---
if (!tableExists('utilisateur')) {
    executeQuery("CREATE TABLE `utilisateur` (
        `id_user` int(11) NOT NULL AUTO_INCREMENT,
        `email` varchar(255) UNIQUE NOT NULL,
        `nom` varchar(100) NOT NULL,
        `prenom` varchar(100) NOT NULL,
        `password` varchar(255) NOT NULL,
        `role` ENUM('Admin', 'Enseignant', 'Coordinateur', 'Scolarite', 'Directeur') NOT NULL DEFAULT 'Enseignant',
        `statut` ENUM('Actif', 'Inactif', 'Suspendu') NOT NULL DEFAULT 'Actif',
        PRIMARY KEY (`id_user`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4", "Création de la table utilisateur");
}

$cols_utilisateur = [
    'last_login' => "ALTER TABLE utilisateur ADD COLUMN last_login TIMESTAMP NULL",
    'nom_utilisateur' => "ALTER TABLE utilisateur ADD COLUMN nom_utilisateur VARCHAR(100) UNIQUE NULL AFTER email",
    'updated_at' => "ALTER TABLE utilisateur ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP",
    'created_at' => "ALTER TABLE utilisateur ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
    'telephone' => "ALTER TABLE utilisateur ADD COLUMN telephone VARCHAR(20) NULL",
    'poste' => "ALTER TABLE utilisateur ADD COLUMN poste VARCHAR(100) NULL",
    'date_embauche' => "ALTER TABLE utilisateur ADD COLUMN date_embauche DATE NULL"
];

foreach ($cols_utilisateur as $col => $sql) {
    if (!columnExists('utilisateur', $col)) {
        executeQuery($sql, "Ajout de la colonne $col à utilisateur");
    }
}

// --- 2. TABLE ETUDIANT ---
$cols_etudiant = [
    'email' => "ALTER TABLE etudiant ADD COLUMN email VARCHAR(100) UNIQUE NULL",
    'telephone' => "ALTER TABLE etudiant ADD COLUMN telephone VARCHAR(20) NULL",
    'lieu_naissance' => "ALTER TABLE etudiant ADD COLUMN lieu_naissance VARCHAR(100) NULL",
    'sexe' => "ALTER TABLE etudiant ADD COLUMN sexe ENUM('M', 'F') DEFAULT 'M'",
    'nationalite' => "ALTER TABLE etudiant ADD COLUMN nationalite VARCHAR(50) NULL",
    'adresse' => "ALTER TABLE etudiant ADD COLUMN adresse TEXT NULL",
    'photo' => "ALTER TABLE etudiant ADD COLUMN photo VARCHAR(255) NULL",
    'semestre_actuel' => "ALTER TABLE etudiant ADD COLUMN semestre_actuel INT DEFAULT 1",
    'statut' => "ALTER TABLE etudiant ADD COLUMN statut ENUM('Actif', 'Inactif', 'Suspendu', 'Diplômé') DEFAULT 'Actif'",
    'date_inscription' => "ALTER TABLE etudiant ADD COLUMN date_inscription TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
    'date_modification' => "ALTER TABLE etudiant ADD COLUMN date_modification TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP"
];

foreach ($cols_etudiant as $col => $sql) {
    if (!columnExists('etudiant', $col)) {
        executeQuery($sql, "Ajout de la colonne $col à etudiant");
    }
}

// --- 3. TABLES SYSTÈME MANQUANTES ---
$tables_systeme = [
    'audit_log' => "CREATE TABLE `audit_log` (
        `id_audit` BIGINT PRIMARY KEY AUTO_INCREMENT,
        `user_id` INT NOT NULL,
        `action` VARCHAR(50) NOT NULL,
        `table_name` VARCHAR(100) NULL,
        `record_id` INT NULL,
        `old_values` TEXT NULL,
        `new_values` TEXT NULL,
        `ip_address` VARCHAR(45) NULL,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    'app_settings' => "CREATE TABLE `app_settings` (
        `id_setting` INT PRIMARY KEY AUTO_INCREMENT,
        `setting_key` VARCHAR(100) UNIQUE NOT NULL,
        `setting_value` TEXT NULL,
        `setting_type` ENUM('string', 'number', 'boolean', 'json') DEFAULT 'string',
        `category` VARCHAR(50) DEFAULT 'general',
        `description` VARCHAR(255) NULL,
        `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    'email_templates' => "CREATE TABLE `email_templates` (
        `id_template` INT PRIMARY KEY AUTO_INCREMENT,
        `template_name` VARCHAR(100) UNIQUE NOT NULL,
        `subject` VARCHAR(255) NOT NULL,
        `body` TEXT NOT NULL,
        `variables` VARCHAR(255) NULL,
        `enabled` BOOLEAN DEFAULT TRUE,
        `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB",
    'session_rattrapage' => "CREATE TABLE `session_rattrapage` (
        `id_session` int(11) NOT NULL AUTO_INCREMENT,
        `code_session` varchar(20) NOT NULL,
        `date_debut` date NOT NULL,
        `date_fin` date NOT NULL,
        `id_filiere` int(11),
        `statut` enum('Programmée', 'En cours', 'Terminée', 'Annulée') DEFAULT 'Programmée',
        `description` text,
        `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id_session`),
        UNIQUE KEY `code_session` (`code_session`)
    ) ENGINE=InnoDB",
    'inscription_rattrapage' => "CREATE TABLE `inscription_rattrapage` (
        `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
        `id_etudiant` int(11) NOT NULL,
        `id_session` int(11) NOT NULL,
        `id_ec` int(11) NOT NULL,
        `date_inscription` timestamp DEFAULT CURRENT_TIMESTAMP,
        `statut` enum('Inscrit', 'Participé', 'Absent', 'Annulé') DEFAULT 'Inscrit',
        PRIMARY KEY (`id_inscription`)
    ) ENGINE=InnoDB",
    'deliberation' => "CREATE TABLE `deliberation` (
        `id_deliberation` int(11) NOT NULL AUTO_INCREMENT,
        `code_deliberation` varchar(30) NOT NULL,
        `id_etudiant` int(11) NOT NULL,
        `semestre` int(11) NOT NULL,
        `moyenne_semestre` decimal(5,2),
        `statut` enum('Admis', 'Redoublant', 'Ajourné', 'En attente') DEFAULT 'En attente',
        `mention` varchar(50),
        `credits_obtenus` int(11) DEFAULT 0,
        `date_deliberation` date,
        `responsable_deliberation` varchar(100),
        `observations` text,
        `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id_deliberation`)
    ) ENGINE=InnoDB",
    'proces_verbal' => "CREATE TABLE `proces_verbal` (
        `id_pv` int(11) NOT NULL AUTO_INCREMENT,
        `code_pv` varchar(30) NOT NULL,
        `id_deliberation` int(11) NOT NULL,
        `date_pv` date NOT NULL,
        `heure_debut` time,
        `heure_fin` time,
        `lieu_reunion` varchar(100),
        `president_jury` varchar(100),
        `membres_jury` text,
        `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id_pv`)
    ) ENGINE=InnoDB",
    'configuration_coefficients' => "CREATE TABLE `configuration_coefficients` (
        `id_config` int(11) NOT NULL AUTO_INCREMENT,
        `id_filiere` int(11) NOT NULL,
        `id_ue` int(11) NOT NULL,
        `coefficient_ue` float DEFAULT 1,
        `credit_ects_ue` int(11) DEFAULT 6,
        `annee_academique` varchar(20),
        PRIMARY KEY (`id_config`)
    ) ENGINE=InnoDB",
    'carte_etudiant' => "CREATE TABLE `carte_etudiant` (
        `id_carte` int(11) NOT NULL AUTO_INCREMENT,
        `id_etudiant` int(11) NOT NULL,
        `numero_carte` varchar(30) NOT NULL,
        `statut` enum('Active', 'Expirée', 'Suspendue', 'Annulée') DEFAULT 'Active',
        `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id_carte`)
    ) ENGINE=InnoDB"
];

foreach ($tables_systeme as $table => $sql) {
    if (!tableExists($table)) {
        executeQuery($sql, "Création de la table $table");
    }
}

// --- 4. COLONNES ADDITIONNELLES POUR LES AUTRES TABLES ---
$cols_autres = [
    'departement' => [
        'code_dept' => "ALTER TABLE departement ADD COLUMN code_dept VARCHAR(20) UNIQUE NULL",
        'chef_dept' => "ALTER TABLE departement ADD COLUMN chef_dept VARCHAR(100) NULL",
        'date_creation' => "ALTER TABLE departement ADD COLUMN date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    ],
    'filiere' => [
        'code_filiere' => "ALTER TABLE filiere ADD COLUMN code_filiere VARCHAR(20) UNIQUE NULL",
        'responsable' => "ALTER TABLE filiere ADD COLUMN responsable VARCHAR(100) NULL",
        'niveau' => "ALTER TABLE filiere ADD COLUMN niveau VARCHAR(50) NULL",
        'nb_semestres' => "ALTER TABLE filiere ADD COLUMN nb_semestres INT DEFAULT 6",
        'date_creation' => "ALTER TABLE filiere ADD COLUMN date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    ],
    'ue' => [
        'coefficient' => "ALTER TABLE ue ADD COLUMN coefficient FLOAT DEFAULT 1",
        'volume_horaire' => "ALTER TABLE ue ADD COLUMN volume_horaire INT DEFAULT 0",
        'id_dept' => "ALTER TABLE ue ADD COLUMN id_dept INT NULL",
        'date_creation' => "ALTER TABLE ue ADD COLUMN date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    ],
    'ec' => [
        'code_ec' => "ALTER TABLE ec ADD COLUMN code_ec VARCHAR(20) UNIQUE NULL",
        'volume_horaire' => "ALTER TABLE ec ADD COLUMN volume_horaire INT DEFAULT 0",
        'date_creation' => "ALTER TABLE ec ADD COLUMN date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    ],
    'programme' => [
        'annee_academique' => "ALTER TABLE programme ADD COLUMN annee_academique VARCHAR(20) NULL",
        'date_creation' => "ALTER TABLE programme ADD COLUMN date_creation TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
    ]
];

foreach ($cols_autres as $table => $cols) {
    if (tableExists($table)) {
        foreach ($cols as $col => $sql) {
            if (!columnExists($table, $col)) {
                executeQuery($sql, "Ajout de la colonne $col à $table");
            }
        }
    }
}

// --- 5. INITIALISATION DE L'ADMIN SI VIDE ---
$res = $db->query("SELECT COUNT(*) as count FROM utilisateur");
$row = $res->fetch_assoc();
if ($row['count'] == 0) {
    echo "<div class='info'>Aucun utilisateur trouvé. Création de l'administrateur par défaut...</div>";
    $pass = password_hash('admin123', PASSWORD_DEFAULT);
    executeQuery("INSERT INTO utilisateur (email, nom, prenom, password, role, statut) 
                 VALUES ('admin@universite.com', 'Administrateur', 'Système', '$pass', 'Admin', 'Actif')", 
                 "Création de l'admin par défaut (admin123)");
}

echo "
    <div class='summary'>
        <h2>✅ Réparation terminée !</h2>
        <p>Toutes les colonnes et tables manquantes ont été traitées. L'application devrait maintenant fonctionner normalement.</p>
        <p><strong>Actions recommandées :</strong></p>
        <ul>
            <li>Supprimez ce fichier (<code>repair_database.php</code>) pour plus de sécurité.</li>
            <li>Accédez au <a href='index.php'>Tableau de Bord</a>.</li>
        </ul>
    </div>
</div>
</body>
</html>";
