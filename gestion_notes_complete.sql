-- phpMyAdmin SQL Dump
-- Base de données complète pour système de gestion académique LMD
-- Version améliorée avec tables additionnelles

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ========================================
-- 1. TABLE DEPARTEMENT
-- ========================================
CREATE TABLE IF NOT EXISTS `departement` (
  `id_dept` int(11) NOT NULL AUTO_INCREMENT,
  `nom_dept` varchar(100) NOT NULL,
  `code_dept` varchar(20),
  `chef_dept` varchar(100),
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_dept`),
  UNIQUE KEY `code_dept` (`code_dept`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 2. TABLE FILIERE
-- ========================================
CREATE TABLE IF NOT EXISTS `filiere` (
  `id_filiere` int(11) NOT NULL AUTO_INCREMENT,
  `nom_filiere` varchar(100) NOT NULL,
  `code_filiere` varchar(20),
  `responsable` varchar(100),
  `id_dept` int(11),
  `niveau` varchar(50),
  `nb_semestres` int(11) DEFAULT 6,
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_filiere`),
  UNIQUE KEY `code_filiere` (`code_filiere`),
  KEY `id_dept` (`id_dept`),
  FOREIGN KEY (`id_dept`) REFERENCES `departement` (`id_dept`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 3. TABLE UE (Unité d'Enseignement)
-- ========================================
CREATE TABLE IF NOT EXISTS `ue` (
  `id_ue` int(11) NOT NULL AUTO_INCREMENT,
  `code_ue` varchar(20) NOT NULL,
  `libelle_ue` varchar(150) NOT NULL,
  `credits_ects` int(11) DEFAULT 6,
  `coefficient` float DEFAULT 1,
  `volume_horaire` int(11) DEFAULT 0,
  `id_dept` int(11),
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ue`),
  UNIQUE KEY `code_ue` (`code_ue`),
  KEY `id_dept` (`id_dept`),
  FOREIGN KEY (`id_dept`) REFERENCES `departement` (`id_dept`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 4. TABLE EC (Élément Constitutif)
-- ========================================
CREATE TABLE IF NOT EXISTS `ec` (
  `id_ec` int(11) NOT NULL AUTO_INCREMENT,
  `code_ec` varchar(20),
  `nom_ec` varchar(150) NOT NULL,
  `coefficient` float DEFAULT 1,
  `volume_horaire` int(11) DEFAULT 0,
  `id_ue` int(11) NOT NULL,
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_ec`),
  UNIQUE KEY `code_ec` (`code_ec`),
  KEY `id_ue` (`id_ue`),
  FOREIGN KEY (`id_ue`) REFERENCES `ue` (`id_ue`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 5. TABLE PROGRAMME (Maquette LMD)
-- ========================================
CREATE TABLE IF NOT EXISTS `programme` (
  `id_programme` int(11) NOT NULL AUTO_INCREMENT,
  `id_filiere` int(11) NOT NULL,
  `id_ue` int(11) NOT NULL,
  `semestre` int(11) CHECK (`semestre` between 1 and 6),
  `annee_academique` varchar(20),
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_programme`),
  UNIQUE KEY `unique_programme` (`id_filiere`, `id_ue`, `semestre`),
  KEY `id_ue` (`id_ue`),
  FOREIGN KEY (`id_filiere`) REFERENCES `filiere` (`id_filiere`) ON DELETE CASCADE,
  FOREIGN KEY (`id_ue`) REFERENCES `ue` (`id_ue`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 6. TABLE ETUDIANT
-- ========================================
CREATE TABLE IF NOT EXISTS `etudiant` (
  `id_etudiant` int(11) NOT NULL AUTO_INCREMENT,
  `matricule` varchar(20) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100),
  `telephone` varchar(20),
  `date_naissance` date,
  `lieu_naissance` varchar(100),
  `sexe` enum('M', 'F') DEFAULT 'M',
  `nationalite` varchar(50),
  `adresse` text,
  `photo` varchar(255),
  `id_filiere` int(11),
  `semestre_actuel` int(11) DEFAULT 1,
  `statut` enum('Actif', 'Inactif', 'Suspendu', 'Diplômé') DEFAULT 'Actif',
  `date_inscription` timestamp DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_etudiant`),
  UNIQUE KEY `matricule` (`matricule`),
  UNIQUE KEY `email` (`email`),
  KEY `id_filiere` (`id_filiere`),
  FOREIGN KEY (`id_filiere`) REFERENCES `filiere` (`id_filiere`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 7. TABLE NOTE
-- ========================================
CREATE TABLE IF NOT EXISTS `note` (
  `id_note` int(11) NOT NULL AUTO_INCREMENT,
  `valeur_note` decimal(5,2) CHECK (`valeur_note` between 0 and 20),
  `session` enum('Normale', 'Rattrapage') DEFAULT 'Normale',
  `date_examen` date,
  `id_etudiant` int(11) NOT NULL,
  `id_ec` int(11) NOT NULL,
  `date_saisie` timestamp DEFAULT CURRENT_TIMESTAMP,
  `date_modification` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_note`),
  UNIQUE KEY `unique_note` (`id_etudiant`, `id_ec`, `session`),
  KEY `id_etudiant` (`id_etudiant`),
  KEY `id_ec` (`id_ec`),
  FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE,
  FOREIGN KEY (`id_ec`) REFERENCES `ec` (`id_ec`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 8. TABLE SESSION_RATTRAPAGE (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `session_rattrapage` (
  `id_session` int(11) NOT NULL AUTO_INCREMENT,
  `code_session` varchar(20) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `id_filiere` int(11),
  `statut` enum('Programmée', 'En cours', 'Terminée', 'Annulée') DEFAULT 'Programmée',
  `description` text,
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_session`),
  UNIQUE KEY `code_session` (`code_session`),
  KEY `id_filiere` (`id_filiere`),
  FOREIGN KEY (`id_filiere`) REFERENCES `filiere` (`id_filiere`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 9. TABLE INSCRIPTION_RATTRAPAGE (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `inscription_rattrapage` (
  `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
  `id_etudiant` int(11) NOT NULL,
  `id_session` int(11) NOT NULL,
  `id_ec` int(11) NOT NULL,
  `date_inscription` timestamp DEFAULT CURRENT_TIMESTAMP,
  `statut` enum('Inscrit', 'Participé', 'Absent', 'Annulé') DEFAULT 'Inscrit',
  PRIMARY KEY (`id_inscription`),
  UNIQUE KEY `unique_inscription` (`id_etudiant`, `id_session`, `id_ec`),
  KEY `id_etudiant` (`id_etudiant`),
  KEY `id_session` (`id_session`),
  KEY `id_ec` (`id_ec`),
  FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE,
  FOREIGN KEY (`id_session`) REFERENCES `session_rattrapage` (`id_session`) ON DELETE CASCADE,
  FOREIGN KEY (`id_ec`) REFERENCES `ec` (`id_ec`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 10. TABLE DELIBERATION (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `deliberation` (
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
  PRIMARY KEY (`id_deliberation`),
  UNIQUE KEY `code_deliberation` (`code_deliberation`),
  KEY `id_etudiant` (`id_etudiant`),
  FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 11. TABLE PROCES_VERBAL (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `proces_verbal` (
  `id_pv` int(11) NOT NULL AUTO_INCREMENT,
  `code_pv` varchar(30) NOT NULL,
  `id_deliberation` int(11) NOT NULL,
  `date_pv` date NOT NULL,
  `heure_debut` time,
  `heure_fin` time,
  `lieu_reunion` varchar(100),
  `president_jury` varchar(100),
  `membres_jury` text,
  `nombre_presents` int(11),
  `nombre_absents` int(11),
  `resume_pv` text,
  `decisions` text,
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pv`),
  UNIQUE KEY `code_pv` (`code_pv`),
  KEY `id_deliberation` (`id_deliberation`),
  FOREIGN KEY (`id_deliberation`) REFERENCES `deliberation` (`id_deliberation`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 12. TABLE CONFIGURATION_COEFFICIENTS (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `configuration_coefficients` (
  `id_config` int(11) NOT NULL AUTO_INCREMENT,
  `id_filiere` int(11) NOT NULL,
  `id_ue` int(11) NOT NULL,
  `coefficient_ue` float DEFAULT 1,
  `credit_ects_ue` int(11) DEFAULT 6,
  `volume_horaire_total` int(11) DEFAULT 0,
  `annee_academique` varchar(20),
  `date_modification` timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_config`),
  UNIQUE KEY `unique_config` (`id_filiere`, `id_ue`, `annee_academique`),
  KEY `id_filiere` (`id_filiere`),
  KEY `id_ue` (`id_ue`),
  FOREIGN KEY (`id_filiere`) REFERENCES `filiere` (`id_filiere`) ON DELETE CASCADE,
  FOREIGN KEY (`id_ue`) REFERENCES `ue` (`id_ue`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 13. TABLE ATTESTATION_REUSSITE (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `attestation_reussite` (
  `id_attestation` int(11) NOT NULL AUTO_INCREMENT,
  `code_attestation` varchar(30) NOT NULL,
  `id_etudiant` int(11) NOT NULL,
  `semestre` int(11) NOT NULL,
  `moyenne_generale` decimal(5,2),
  `mention` varchar(50),
  `credits_ects_obtenus` int(11),
  `date_emission` date,
  `date_validite` date,
  `statut` enum('Active', 'Expirée', 'Révoquée') DEFAULT 'Active',
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_attestation`),
  UNIQUE KEY `code_attestation` (`code_attestation`),
  KEY `id_etudiant` (`id_etudiant`),
  FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 14. TABLE CARTE_ETUDIANT (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `carte_etudiant` (
  `id_carte` int(11) NOT NULL AUTO_INCREMENT,
  `id_etudiant` int(11) NOT NULL,
  `numero_carte` varchar(30) NOT NULL,
  `date_emission` date,
  `date_expiration` date,
  `statut` enum('Active', 'Expirée', 'Suspendue', 'Annulée') DEFAULT 'Active',
  `qr_code` varchar(255),
  `photo_url` varchar(255),
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_carte`),
  UNIQUE KEY `numero_carte` (`numero_carte`),
  UNIQUE KEY `id_etudiant` (`id_etudiant`),
  FOREIGN KEY (`id_etudiant`) REFERENCES `etudiant` (`id_etudiant`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- 15. TABLE ADMIN UTILISATEURS (NOUVEAU)
-- ========================================
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `prenom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `telephone` varchar(20),
  `role` enum('Admin', 'Enseignant', 'Scolarite', 'Directeur') DEFAULT 'Enseignant',
  `poste` varchar(100),
  `date_embauche` date,
  `statut` enum('Actif', 'Inactif', 'Suspendu') DEFAULT 'Actif',
  `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ========================================
-- INSERT DONNÉES DE TEST
-- ========================================

-- Départements
INSERT INTO `departement` (`nom_dept`, `code_dept`, `chef_dept`) VALUES
('Sciences de l''Ingénieur', 'SI', 'Dr. Jean Dupont'),
('Mathématiques & Informatique', 'MI', 'Dr. Marie Curie'),
('Économie & Gestion', 'EG', 'Dr. Michel Adam');

-- Filières
INSERT INTO `filiere` (`nom_filiere`, `code_filiere`, `responsable`, `id_dept`, `niveau`) VALUES
('Génie Logiciel', 'GL', 'Dr. Kouamé', 1, 'Licence'),
('Informatique', 'INFO', 'Dr. René Levesque', 2, 'Licence'),
('Gestion d''Entreprise', 'GE', 'Dr. Paul Serieux', 3, 'Licence');

-- UE (exemples)
INSERT INTO `ue` (`code_ue`, `libelle_ue`, `credits_ects`, `coefficient`, `volume_horaire`, `id_dept`) VALUES
('GL-S1-UE-001', 'Programmation I', 6, 1.5, 45, 1),
('GL-S1-UE-002', 'Mathématiques Discrètes', 6, 1.5, 45, 1),
('GL-S1-UE-003', 'Architecture des Ordinateurs', 6, 1.5, 45, 1),
('INFO-S1-UE-001', 'Fondamentaux de l''Informatique', 6, 1.5, 45, 2);

-- EC (exemples)
INSERT INTO `ec` (`code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
('GL-S1-EC-001', 'Programmation I Pratique', 1, 22, 1),
('GL-S1-EC-002', 'Programmation I Théorique', 0.5, 23, 1),
('GL-S1-EC-003', 'Mathématiques Discrètes TP', 1, 45, 2),
('GL-S1-EC-004', 'Architecture Matérielle', 1.5, 45, 3);

-- Étudiants d'exemple
INSERT INTO `etudiant` (`matricule`, `nom`, `prenom`, `email`, `telephone`, `date_naissance`, `lieu_naissance`, `sexe`, `nationalite`, `id_filiere`, `statut`) VALUES
('2023-FR-001', 'Koulibaly', 'Mamadou', 'mamadou@email.com', '+223 75123456', '2003-05-15', 'Bamako', 'M', 'Malienne', 1, 'Actif'),
('2023-FR-002', 'Touré', 'Fatima', 'fatima@email.com', '+223 75234567', '2003-08-20', 'Ségou', 'F', 'Malienne', 1, 'Actif'),
('2023-FR-003', 'Diallo', 'Mohamed', 'mohamed@email.com', '+223 75345678', '2004-02-10', 'Kayes', 'M', 'Malienne', 2, 'Actif');

-- Programme (Maquette)
INSERT INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
(1, 1, 1, '2023-2024'),
(1, 2, 1, '2023-2024'),
(1, 3, 1, '2023-2024');

-- Notes d'exemples
INSERT INTO `note` (`valeur_note`, `session`, `date_examen`, `id_etudiant`, `id_ec`) VALUES
(16.5, 'Normale', '2024-01-15', 1, 1),
(14.0, 'Normale', '2024-01-15', 1, 2),
(15.5, 'Normale', '2024-01-16', 1, 3),
(12.5, 'Normale', '2024-01-15', 2, 1);

-- Utilisateur administrateur par défaut
INSERT INTO `utilisateur` (`nom`, `prenom`, `email`, `password`, `role`, `poste`, `statut`) VALUES
('Dupont', 'Jean', 'admin@univ.local', '$2y$10$YourHashedPasswordHere', 'Admin', 'Directeur Académique', 'Actif');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
