-- ========================================
-- DONNÉES DE TEST COMPLÈTES - NOMS SÉNÉGALAIS
-- Genération de données fictives pour tests
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ========================================
-- DÉSACTIVER LES CONTRAINTES DE CLÉS ÉTRANGÈRES
-- ========================================

SET FOREIGN_KEY_CHECKS = 0;

-- ========================================
-- SUPPRIMER LES DONNÉES EXISTANTES
-- ========================================

DELETE FROM `audit_log` WHERE 1=1;
DELETE FROM `proces_verbal` WHERE 1=1;
DELETE FROM `attestation_reussite` WHERE 1=1;
DELETE FROM `carte_etudiant` WHERE 1=1;
DELETE FROM `configuration_coefficients` WHERE 1=1;
DELETE FROM `deliberation` WHERE 1=1;
DELETE FROM `inscription_rattrapage` WHERE 1=1;
DELETE FROM `session_rattrapage` WHERE 1=1;
DELETE FROM `note` WHERE 1=1;
DELETE FROM `programme` WHERE 1=1;
DELETE FROM `etudiant` WHERE 1=1;
DELETE FROM `ec` WHERE 1=1;
DELETE FROM `ue` WHERE 1=1;
DELETE FROM `filiere` WHERE 1=1;
DELETE FROM `departement` WHERE 1=1;
DELETE FROM `utilisateur` WHERE 1=1;

-- ========================================
-- RÉACTIVER LES CONTRAINTES DE CLÉS ÉTRANGÈRES
-- ========================================

SET FOREIGN_KEY_CHECKS = 1;

-- ========================================
-- 1. INSERTIONS DÉPARTEMENTS
-- ========================================

INSERT INTO `departement` (`id_dept`, `nom_dept`, `code_dept`, `chef_dept`) VALUES
(1, 'Sciences de l''Ingénieur', 'SI_2025', 'Pr. Cheikh Diallo'),
(2, 'Mathématiques & Informatique', 'MI_2025', 'Pr. Aïssatou Diop'),
(3, 'Économie & Gestion', 'EG_2025', 'Pr. Mamadou Sarr'),
(4, 'Sciences Physiques', 'SP_2025', 'Pr. Aminata Sall'),
(5, 'Lettres & Sciences Humaines', 'LSH_2025', 'Pr. Moussa Gueye');

-- ========================================
-- 2. INSERTIONS FILIÈRES
-- ========================================

INSERT INTO `filiere` (`id_filiere`, `nom_filiere`, `code_filiere`, `responsable`, `id_dept`, `niveau`, `nb_semestres`) VALUES
(1, 'Génie Logiciel', 'GL_2025', 'Dr. Ousmane Ken', 1, 'Licence', 6),
(2, 'Génie Électronique', 'GE_2025', 'Dr. Yacine Traoré', 1, 'Licence', 6),
(3, 'Informatique', 'INFO_2025', 'Dr. Aïda Ndiaye', 2, 'Licence', 6),
(4, 'Mathématiques Appliquées', 'MA_2025', 'Dr. Fatou Gueye', 2, 'Licence', 6),
(5, 'Gestion d''Entreprise', 'GEST_2025', 'Dr. Bassirou Touré', 3, 'Licence', 6),
(6, 'Comptabilité & Finance', 'CF_2025', 'Dr. Hawa Sall', 3, 'Licence', 6),
(7, 'Physique', 'PHY_2025', 'Dr. Ibrahima Bah', 4, 'Licence', 6),
(8, 'Chimie', 'CHI_2025', 'Dr. Khady Fall', 4, 'Licence', 6),
(9, 'Lettres Modernes', 'LM_2025', 'Dr. Lamine Diouf', 5, 'Licence', 6),
(10, 'Histoire & Géographie', 'HG_2025', 'Dr. Marième Kane', 5, 'Licence', 6);

-- ========================================
-- 3. INSERTIONS UE (Unités d'Enseignement)
-- ========================================

INSERT INTO `ue` (`id_ue`, `code_ue`, `libelle_ue`, `credits_ects`, `coefficient`, `volume_horaire`, `id_dept`) VALUES
-- Génie Logiciel (2 premiers semestres)
(1, 'GL-S1-001-2025', 'Programmation I (Java)', 6, 2, 45, 1),
(2, 'GL-S1-002-2025', 'Mathématiques Discrètes', 6, 1.5, 45, 1),
(3, 'GL-S1-003-2025', 'Architecture des Ordinateurs', 6, 1.5, 45, 1),
(4, 'GL-S1-004-2025', 'Bases de Données I', 6, 2, 45, 1),
(5, 'GL-S1-005-2025', 'Anglais Technique', 3, 1, 30, 1),

(6, 'GL-S2-001-2025', 'Programmation II (OOP)', 6, 2, 45, 1),
(7, 'GL-S2-002-2025', 'Algorithme & Structures', 6, 2, 45, 1),
(8, 'GL-S2-003-2025', 'Bases de Données II', 6, 2, 45, 1),
(9, 'GL-S2-004-2025', 'Projet Informatique I', 6, 1.5, 45, 1),
(10, 'GL-S2-005-2025', 'Communication Professionnelle', 3, 1, 30, 1),

-- Informatique
(11, 'INFO-S1-001-2025', 'Fondamentaux Informatique', 6, 1.5, 45, 2),
(12, 'INFO-S1-002-2025', 'Python Avancé', 6, 2, 45, 2),
(13, 'INFO-S1-003-2025', 'Systèmes d''Exploitation', 6, 1.5, 45, 2),
(14, 'INFO-S1-004-2025', 'Web Design I', 6, 1.5, 45, 2),

(15, 'INFO-S2-001-2025', 'Réseaux Informatiques', 6, 2, 45, 2),
(16, 'INFO-S2-002-2025', 'Administration Systèmes', 6, 2, 45, 2),
(17, 'INFO-S2-003-2025', 'Web Design II (PHP)', 6, 2, 45, 2),

-- Gestion d'Entreprise
(18, 'GEST-S1-001-2025', 'Économie Générale', 6, 1.5, 45, 3),
(19, 'GEST-S1-002-2025', 'Comptabilité Générale', 6, 2, 45, 3),
(20, 'GEST-S1-003-2025', 'Management I', 6, 1.5, 45, 3),
(21, 'GEST-S1-004-2025', 'Droit Commercial', 6, 1, 45, 3),

(22, 'GEST-S2-001-2025', 'Comptabilité Analytique', 6, 2, 45, 3),
(23, 'GEST-S2-002-2025', 'Management II', 6, 1.5, 45, 3),
(24, 'GEST-S2-003-2025', 'Finance d''Entreprise', 6, 2, 45, 3),

-- Mathématiques Appliquées
(25, 'MA-S1-001-2025', 'Algèbre Linéaire', 6, 2, 45, 2),
(26, 'MA-S1-002-2025', 'Analyse Réelle', 6, 2, 45, 2),
(27, 'MA-S1-003-2025', 'Probabilités I', 6, 1.5, 45, 2),

-- Physique
(28, 'PHY-S1-001-2025', 'Mécanique Classique', 6, 2, 45, 4),
(29, 'PHY-S1-002-2025', 'Électricité I', 6, 2, 45, 4),
(30, 'PHY-S1-003-2025', 'Thermodynamique', 6, 1.5, 45, 4),

-- Chimie
(31, 'CHI-S1-001-2025', 'Chimie Générale', 6, 2, 45, 4),
(32, 'CHI-S1-002-2025', 'Chimie Organique I', 6, 2, 45, 4),
(33, 'CHI-S1-003-2025', 'Chimie Analytique', 6, 1.5, 45, 4);

-- ========================================
-- 4. INSERTIONS EC (Éléments Constitutifs)
-- ========================================

INSERT INTO `ec` (`id_ec`, `code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
-- GL-S1-001: Programmation I
(1, 'GL-S1-001-TP-2025', 'TP Programmation I', 1.2, 22, 1),
(2, 'GL-S1-001-CM-2025', 'CM Programmation I', 0.8, 23, 1),

-- GL-S1-002: Mathématiques Discrètes
(3, 'GL-S1-002-CM-2025', 'CM Mathématiques Discrètes', 1, 30, 2),
(4, 'GL-S1-002-TD-2025', 'TD Mathématiques Discrètes', 0.5, 15, 2),

-- GL-S1-003: Architecture
(5, 'GL-S1-003-CM-2025', 'CM Architecture', 1, 30, 3),
(6, 'GL-S1-003-TP-2025', 'TP Architecture', 0.5, 15, 3),

-- GL-S1-004: BD I
(7, 'GL-S1-004-CM-2025', 'CM BD I - Modélisation', 1, 30, 4),
(8, 'GL-S1-004-TP-2025', 'TP BD I - SQL', 1, 15, 4),

-- GL-S1-005: Anglais
(9, 'GL-S1-005-CM-2025', 'CM Anglais Technique', 1, 30, 5),

-- GL-S2-001: Programmation II
(10, 'GL-S2-001-TP-2025', 'TP Programmation OOP', 1.2, 22, 6),
(11, 'GL-S2-001-CM-2025', 'CM Programmation OOP', 0.8, 23, 6),

-- GL-S2-002: Algorithme
(12, 'GL-S2-002-CM-2025', 'CM Algorithme', 1.2, 30, 7),
(13, 'GL-S2-002-TP-2025', 'TP Algorithme', 0.8, 15, 7),

-- GL-S2-003: BD II
(14, 'GL-S2-003-CM-2025', 'CM BD II - Avancé', 1, 30, 8),
(15, 'GL-S2-003-TP-2025', 'TP BD II - NoSQL', 1, 15, 8),

-- GL-S2-004: Projet
(16, 'GL-S2-004-PROJ-2025', 'Projet Informatique', 1.5, 45, 9),

-- GL-S2-005: Communication
(17, 'GL-S2-005-CM-2025', 'CM Communication', 1, 30, 10),

-- INFO-S1-001
(18, 'INFO-S1-001-CM-2025', 'CM Fondamentaux', 1, 30, 11),
(19, 'INFO-S1-001-TP-2025', 'TP Fondamentaux', 0.5, 15, 11),

-- INFO-S1-002
(20, 'INFO-S1-002-CM-2025', 'CM Python', 1.2, 30, 12),
(21, 'INFO-S1-002-TP-2025', 'TP Python', 0.8, 15, 12),

-- INFO-S1-003
(22, 'INFO-S1-003-CM-2025', 'CM OS', 1, 30, 13),
(23, 'INFO-S1-003-TP-2025', 'TP OS', 0.5, 15, 13),

-- INFO-S1-004
(24, 'INFO-S1-004-CM-2025', 'CM Web I', 0.8, 22.5, 14),
(25, 'INFO-S1-004-TP-2025', 'TP Web I', 0.7, 22.5, 14),

-- INFO-S2-001
(26, 'INFO-S2-001-CM-2025', 'CM Réseaux', 1.2, 30, 15),
(27, 'INFO-S2-001-TP-2025', 'TP Réseaux', 0.8, 15, 15),

-- INFO-S2-002
(28, 'INFO-S2-002-CM-2025', 'CM Administration', 1, 30, 16),
(29, 'INFO-S2-002-TP-2025', 'TP Administration', 1, 15, 16),

-- INFO-S2-003
(30, 'INFO-S2-003-CM-2025', 'CM Web II PHP', 1.2, 22.5, 17),
(31, 'INFO-S2-003-TP-2025', 'TP Web II PHP', 0.8, 22.5, 17),

-- GEST-S1
(32, 'GEST-S1-001-CM-2025', 'CM Économie Générale', 1.5, 45, 18),
(33, 'GEST-S1-002-CM-2025', 'CM Comptabilité Générale', 1.5, 45, 19),
(34, 'GEST-S1-002-TP-2025', 'TP Comptabilité', 0.5, 0, 19),
(35, 'GEST-S1-003-CM-2025', 'CM Management I', 1.5, 45, 20),
(36, 'GEST-S1-004-CM-2025', 'CM Droit Commercial', 1, 45, 21),

-- GEST-S2
(37, 'GEST-S2-001-CM-2025', 'CM Comptabilité Analytique', 2, 45, 22),
(38, 'GEST-S2-002-CM-2025', 'CM Management II', 1.5, 45, 23),
(39, 'GEST-S2-003-CM-2025', 'CM Finance d''Entreprise', 2, 45, 24),

-- MA-S1
(40, 'MA-S1-001-CM-2025', 'CM Algèbre Linéaire', 1.5, 45, 25),
(41, 'MA-S1-002-CM-2025', 'CM Analyse Réelle', 1.5, 45, 26),
(42, 'MA-S1-003-CM-2025', 'CM Probabilités', 1.5, 45, 27),

-- PHY-S1
(43, 'PHY-S1-001-CM-2025', 'CM Mécanique', 1.5, 45, 28),
(44, 'PHY-S1-001-TP-2025', 'TP Mécanique', 0.5, 0, 28),
(45, 'PHY-S1-002-CM-2025', 'CM Électricité I', 1.5, 45, 29),
(46, 'PHY-S1-003-CM-2025', 'CM Thermodynamique', 1.5, 45, 30),

-- CHI-S1
(47, 'CHI-S1-001-CM-2025', 'CM Chimie Générale', 1.5, 45, 31),
(48, 'CHI-S1-001-TP-2025', 'TP Chimie Générale', 0.5, 0, 31),
(49, 'CHI-S1-002-CM-2025', 'CM Chimie Organique', 1.5, 45, 32),
(50, 'CHI-S1-003-CM-2025', 'CM Chimie Analytique', 1.5, 45, 33);

-- ========================================
-- 5. INSERTIONS PROGRAMME (Maquettes LMD)
-- ========================================

INSERT INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
-- Génie Logiciel - Semestre 1
(1, 1, 1, '2025-2026'),
(1, 2, 1, '2025-2026'),
(1, 3, 1, '2025-2026'),
(1, 4, 1, '2025-2026'),
(1, 5, 1, '2025-2026'),

-- Génie Logiciel - Semestre 2
(1, 6, 2, '2025-2026'),
(1, 7, 2, '2025-2026'),
(1, 8, 2, '2025-2026'),
(1, 9, 2, '2025-2026'),
(1, 10, 2, '2025-2026'),

-- Informatique - Semestre 1
(3, 11, 1, '2025-2026'),
(3, 12, 1, '2025-2026'),
(3, 13, 1, '2025-2026'),
(3, 14, 1, '2025-2026'),

-- Informatique - Semestre 2
(3, 15, 2, '2025-2026'),
(3, 16, 2, '2025-2026'),
(3, 17, 2, '2025-2026'),

-- Gestion - Semestre 1
(5, 18, 1, '2025-2026'),
(5, 19, 1, '2025-2026'),
(5, 20, 1, '2025-2026'),
(5, 21, 1, '2025-2026'),

-- Gestion - Semestre 2
(5, 22, 2, '2025-2026'),
(5, 23, 2, '2025-2026'),
(5, 24, 2, '2025-2026'),

-- Mathématiques
(4, 25, 1, '2025-2026'),
(4, 26, 1, '2025-2026'),
(4, 27, 1, '2025-2026'),

-- Physique
(7, 28, 1, '2025-2026'),
(7, 29, 1, '2025-2026'),
(7, 30, 1, '2025-2026'),

-- Chimie
(8, 31, 1, '2025-2026'),
(8, 32, 1, '2025-2026'),
(8, 33, 1, '2025-2026');

-- ========================================
-- 6. INSERTIONS ÉTUDIANTS - NOMS SÉNÉGALAIS
-- ========================================

INSERT INTO `etudiant` (`id_etudiant`, `matricule`, `nom`, `prenom`, `email`, `telephone`, `date_naissance`, `lieu_naissance`, `sexe`, `nationalite`, `id_filiere`, `semestre_actuel`, `statut`) VALUES
-- Génie Logiciel (15 étudiants)
(1, 'KARA-GL-2025-001', 'Diallo', 'Mamadou', 'mamadou.diallo@kara.sn', '+221 77 123 4567', '2003-05-15', 'Dakar', 'M', 'Sénégalaise', 1, 1, 'Actif'),
(2, 'KARA-GL-2025-002', 'Touré', 'Fatima', 'fatima.toure@kara.sn', '+221 76 987 6543', '2003-08-20', 'Kaolack', 'F', 'Sénégalaise', 1, 1, 'Actif'),
(3, 'KARA-GL-2025-003', 'Sall', 'Mohamed', 'mohamed.sall@kara.sn', '+221 77 456 7890', '2003-12-10', 'Thiès', 'M', 'Sénégalaise', 1, 1, 'Actif'),
(4, 'KARA-GL-2025-004', 'Ken', 'Aïssatou', 'aissatou.ken@kara.sn', '+221 70 234 5678', '2004-03-25', 'Saint-Louis', 'F', 'Sénégalaise', 1, 1, 'Actif'),
(5, 'KARA-GL-2025-005', 'Cissé', 'Moussa', 'moussa.cisse@kara.sn', '+221 77 345 6789', '2003-07-08', 'Kolda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
(6, 'KARA-GL-2025-006', 'Gueye', 'Hawa', 'hawa.gueye@kara.sn', '+221 76 567 8901', '2004-01-14', 'Matam', 'F', 'Sénégalaise', 1, 1, 'Actif'),
(7, 'KARA-GL-2025-007', 'Ndiaye', 'Ousmane', 'ousmane.ndiaye@kara.sn', '+221 70 678 9012', '2003-09-22', 'Tambacounda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
(8, 'KARA-GL-2025-008', 'Traoré', 'Khady', 'khady.traore@kara.sn', '+221 77 789 0123', '2003-11-05', 'Ziguinchor', 'F', 'Sénégalaise', 1, 1, 'Actif'),
(9, 'KARA-GL-2025-009', 'Sarr', 'Lamine', 'lamine.sarr@kara.sn', '+221 76 890 1234', '2003-04-17', 'Kaolack', 'M', 'Sénégalaise', 1, 1, 'Actif'),
(10, 'KARA-GL-2025-010', 'Bah', 'Marième', 'marieme.bah@kara.sn', '+221 77 901 2345', '2004-06-09', 'Dakar', 'F', 'Sénégalaise', 1, 1, 'Actif'),
(11, 'KARA-GL-2025-011', 'Fall', 'Cheikh', 'cheikh.fall@kara.sn', '+221 70 012 3456', '2003-10-30', 'Thiès', 'M', 'Sénégalaise', 1, 1, 'Actif'),
(12, 'KARA-GL-2025-012', 'Diouf', 'Aïda', 'aida.diouf@kara.sn', '+221 76 123 4567', '2003-02-18', 'Saint-Louis', 'F', 'Sénégalaise', 1, 1, 'Actif'),
(13, 'KARA-GL-2025-013', 'Kane', 'Abdu', 'abdu.kane@kara.sn', '+221 77 234 5678', '2003-08-12', 'Kolda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
(14, 'KARA-GL-2025-014', 'Thiaw', 'Néné', 'nene.thiaw@kara.sn', '+221 77 345 6789', '2004-05-03', 'Kaolack', 'F', 'Sénégalaise', 1, 1, 'Actif'),
(15, 'KARA-GL-2025-015', 'Seck', 'Babacar', 'babacar.seck@kara.sn', '+221 76 456 7890', '2003-07-21', 'Louga', 'M', 'Sénégalaise', 1, 1, 'Actif'),

-- Informatique (15 étudiants)
(16, 'KARA-INFO-2025-001', 'Ba', 'Meissa', 'meissa.ba@kara.sn', '+221 70 567 8901', '2003-01-11', 'Dakar', 'M', 'Sénégalaise', 3, 1, 'Actif'),
(17, 'KARA-INFO-2025-002', 'Ndar', 'Yasmine', 'yasmine.ndar@kara.sn', '+221 77 678 9012', '2003-03-28', 'Thiès', 'F', 'Sénégalaise', 3, 1, 'Actif'),
(18, 'KARA-INFO-2025-003', 'Dia', 'Ibrahima', 'ibrahima.dia@kara.sn', '+221 76 789 0123', '2003-11-07', 'Kaolack', 'M', 'Sénégalaise', 3, 1, 'Actif'),
(19, 'KARA-INFO-2025-004', 'Ly', 'Aminata', 'aminata.ly@kara.sn', '+221 77 890 1234', '2004-04-19', 'Saint-Louis', 'F', 'Sénégalaise', 3, 1, 'Actif'),
(20, 'KARA-INFO-2025-005', 'Ba', 'Ady', 'ady.ba@kara.sn', '+221 70 901 2345', '2003-06-26', 'Tambacounda', 'M', 'Sénégalaise', 3, 1, 'Actif'),
(21, 'KARA-INFO-2025-006', 'Guèye', 'Awa', 'awa.gueye@kara.sn', '+221 76 012 3456', '2003-09-05', 'Ziguinchor', 'F', 'Sénégalaise', 3, 1, 'Actif'),
(22, 'KARA-INFO-2025-007', 'Niang', 'Yacine', 'yacine.niang@kara.sn', '+221 77 123 4567', '2003-02-14', 'Dakar', 'M', 'Sénégalaise', 3, 1, 'Actif'),
(23, 'KARA-INFO-2025-008', 'Diop', 'Penda', 'penda.diop@kara.sn', '+221 70 234 5678', '2003-12-21', 'Louga', 'F', 'Sénégalaise', 3, 1, 'Actif'),
(24, 'KARA-INFO-2025-009', 'Ndour', 'Seydina', 'seydina.ndour@kara.sn', '+221 77 345 6789', '2003-08-30', 'Kolda', 'M', 'Sénégalaise', 3, 1, 'Actif'),
(25, 'KARA-INFO-2025-010', 'Cissé', 'Éva', 'eva.cisse@kara.sn', '+221 76 456 7890', '2004-02-16', 'Thiès', 'F', 'Sénégalaise', 3, 1, 'Actif'),
(26, 'KARA-INFO-2025-011', 'Diallo', 'Mouhamed', 'mouhamed.diallo@kara.sn', '+221 77 567 8901', '2003-10-08', 'Saint-Louis', 'M', 'Sénégalaise', 3, 1, 'Actif'),
(27, 'KARA-INFO-2025-012', 'Mbaye', 'Rokhaya', 'rokhaya.mbaye@kara.sn', '+221 70 678 9012', '2003-05-23', 'Dakar', 'F', 'Sénégalaise', 3, 1, 'Actif'),
(28, 'KARA-INFO-2025-013', 'Sarr', 'Birame', 'birame.sarr@kara.sn', '+221 76 789 0123', '2003-07-09', 'Kaolack', 'M', 'Sénégalaise', 3, 1, 'Actif'),
(29, 'KARA-INFO-2025-014', 'Seck', 'Ndeye', 'ndeye.seck@kara.sn', '+221 77 890 1234', '2004-01-25', 'Matam', 'F', 'Sénégalaise', 3, 1, 'Actif'),
(30, 'KARA-INFO-2025-015', 'Ndiaye', 'Aliou', 'aliou.ndiaye@kara.sn', '+221 70 901 2345', '2003-09-11', 'Ziguinchor', 'M', 'Sénégalaise', 3, 1, 'Actif'),

-- Gestion d'Entreprise (12 étudiants)
(31, 'KARA-GEST-2025-001', 'Touré', 'Ramatoulaye', 'ramatoulaye.toure@kara.sn', '+221 76 012 3456', '2003-03-17', 'Dakar', 'F', 'Sénégalaise', 5, 1, 'Actif'),
(32, 'KARA-GEST-2025-002', 'Diallo', 'Bassirou', 'bassirou.diallo@kara.sn', '+221 77 123 4567', '2003-11-22', 'Thiès', 'M', 'Sénégalaise', 5, 1, 'Actif'),
(33, 'KARA-GEST-2025-003', 'Sall', 'Oumou', 'oumou.sall@kara.sn', '+221 70 234 5678', '2003-04-30', 'Kaolack', 'F', 'Sénégalaise', 5, 1, 'Actif'),
(34, 'KARA-GEST-2025-004', 'Ken', 'Idrissa', 'idrissa.ken@kara.sn', '+221 76 345 6789', '2003-08-13', 'Saint-Louis', 'M', 'Sénégalaise', 5, 1, 'Actif'),
(35, 'KARA-GEST-2025-005', 'Cissé', 'Waly', 'waly.cisse@kara.sn', '+221 77 456 7890', '2003-06-07', 'Louga', 'M', 'Sénégalaise', 5, 1, 'Actif'),
(36, 'KARA-GEST-2025-006', 'Gueye', 'Fatimata', 'fatimata.gueye@kara.sn', '+221 70 567 8901', '2004-02-04', 'Tambacounda', 'F', 'Sénégalaise', 5, 1, 'Actif'),
(37, 'KARA-GEST-2025-007', 'Ndiaye', 'Habib', 'habib.ndiaye@kara.sn', '+221 76 678 9012', '2003-09-16', 'Kolda', 'M', 'Sénégalaise', 5, 1, 'Actif'),
(38, 'KARA-GEST-2025-008', 'Traoré', 'Aïda', 'aida.traore@kara.sn', '+221 77 789 0123', '2003-01-29', 'Dakar', 'F', 'Sénégalaise', 5, 1, 'Actif'),
(39, 'KARA-GEST-2025-009', 'Sarr', 'Mamadou', 'mamadou.sarr@kara.sn', '+221 70 890 1234', '2003-10-11', 'Ziguinchor', 'M', 'Sénégalaise', 5, 1, 'Actif'),
(40, 'KARA-GEST-2025-010', 'Bah', 'Sokhna', 'sokhna.bah@kara.sn', '+221 77 901 2345', '2003-05-03', 'Saint-Louis', 'F', 'Sénégalaise', 5, 1, 'Actif'),
(41, 'KARA-GEST-2025-011', 'Fall', 'Samba', 'samba.fall@kara.sn', '+221 76 012 3456', '2003-07-20', 'Kaolack', 'M', 'Sénégalaise', 5, 1, 'Actif'),
(42, 'KARA-GEST-2025-012', 'Diouf', 'Ndiaye', 'ndiaye.diouf@kara.sn', '+221 77 123 4567', '2004-03-08', 'Thiès', 'F', 'Sénégalaise', 5, 1, 'Actif'),

-- Mathématiques (8 étudiants)
(43, 'KARA-MA-2025-001', 'Kane', 'Saliou', 'saliou.kane@kara.sn', '+221 70 234 5678', '2003-02-15', 'Dakar', 'M', 'Sénégalaise', 4, 1, 'Actif'),
(44, 'KARA-MA-2025-002', 'Thiaw', 'Issa', 'issa.thiaw@kara.sn', '+221 76 345 6789', '2003-09-22', 'Matam', 'M', 'Sénégalaise', 4, 1, 'Actif'),
(45, 'KARA-MA-2025-003', 'Seck', 'Awa', 'awa.seck@kara.sn', '+221 77 456 7890', '2003-06-10', 'Kolda', 'F', 'Sénégalaise', 4, 1, 'Actif'),
(46, 'KARA-MA-2025-004', 'Ba', 'Ousmane', 'ousmane.ba@kara.sn', '+221 70 567 8901', '2003-11-27', 'Louga', 'M', 'Sénégalaise', 4, 1, 'Actif'),
(47, 'KARA-MA-2025-005', 'Ndar', 'Pape', 'pape.ndar@kara.sn', '+221 76 678 9012', '2003-04-05', 'Tambacounda', 'M', 'Sénégalaise', 4, 1, 'Actif'),
(48, 'KARA-MA-2025-006', 'Dia', 'Adama', 'adama.dia@kara.sn', '+221 77 789 0123', '2003-08-18', 'Saint-Louis', 'M', 'Sénégalaise', 4, 1, 'Actif'),
(49, 'KARA-MA-2025-007', 'Ly', 'Maimouna', 'maimouna.ly@kara.sn', '+221 70 890 1234', '2004-01-12', 'Ziguinchor', 'F', 'Sénégalaise', 4, 1, 'Actif'),
(50, 'KARA-MA-2025-008', 'Ba', 'Maty', 'maty.ba@kara.sn', '+221 76 901 2345', '2003-07-31', 'Thiès', 'F', 'Sénégalaise', 4, 1, 'Actif'),

-- Physique (10 étudiants)
(51, 'KARA-PHY-2025-001', 'Guèye', 'Demba', 'demba.gueye@kara.sn', '+221 77 012 3456', '2003-10-19', 'Dakar', 'M', 'Sénégalaise', 7, 1, 'Actif'),
(52, 'KARA-PHY-2025-002', 'Niang', 'Fatou', 'fatou.niang@kara.sn', '+221 70 123 4567', '2003-05-09', 'Kaolack', 'F', 'Sénégalaise', 7, 1, 'Actif'),
(53, 'KARA-PHY-2025-003', 'Diop', 'Modou', 'modou.diop@kara.sn', '+221 76 234 5678', '2003-03-26', 'Thiès', 'M', 'Sénégalaise', 7, 1, 'Actif'),
(54, 'KARA-PHY-2025-004', 'Ndour', 'Amine', 'amine.ndour@kara.sn', '+221 77 345 6789', '2003-09-01', 'Saint-Louis', 'M', 'Sénégalaise', 7, 1, 'Actif'),
(55, 'KARA-PHY-2025-005', 'Cissé', 'Oumou', 'oumou.cisse@kara.sn', '+221 70 456 7890', '2004-04-15', 'Louga', 'F', 'Sénégalaise', 7, 1, 'Actif'),
(56, 'KARA-PHY-2025-006', 'Mbaye', 'Sekou', 'sekou.mbaye@kara.sn', '+221 76 567 8901', '2003-08-22', 'Matam', 'M', 'Sénégalaise', 7, 1, 'Actif'),
(57, 'KARA-PHY-2025-007', 'Sarr', 'Katy', 'katy.sarr@kara.sn', '+221 77 678 9012', '2003-02-07', 'Tambacounda', 'F', 'Sénégalaise', 7, 1, 'Actif'),
(58, 'KARA-PHY-2025-008', 'Seck', 'Aliou', 'aliou.seck@kara.sn', '+221 70 789 0123', '2003-12-14', 'Kolda', 'M', 'Sénégalaise', 7, 1, 'Actif'),
(59, 'KARA-PHY-2025-009', 'Ndiaye', 'Sokhna', 'sokhna.ndiaye@kara.sn', '+221 76 890 1234', '2003-06-30', 'Ziguinchor', 'F', 'Sénégalaise', 7, 1, 'Actif'),
(60, 'KARA-PHY-2025-010', 'Toure', 'Moussa', 'moussa.toure@kara.sn', '+221 77 901 2345', '2003-11-08', 'Dakar', 'M', 'Sénégalaise', 7, 1, 'Actif'),

-- Chimie (10 étudiants)
(61, 'KARA-CHI-2025-001', 'Diallo', 'Yasmine', 'yasmine.diallo@kara.sn', '+221 70 012 3456', '2003-07-03', 'Dakar', 'F', 'Sénégalaise', 8, 1, 'Actif'),
(62, 'KARA-CHI-2025-002', 'Touré', 'Cheikh', 'cheikh.toure@kara.sn', '+221 76 123 4567', '2003-04-16', 'Thiès', 'M', 'Sénégalaise', 8, 1, 'Actif'),
(63, 'KARA-CHI-2025-003', 'Sall', 'Néné', 'nene.sall@kara.sn', '+221 77 234 5678', '2003-09-24', 'Kaolack', 'M', 'Sénégalaise', 8, 1, 'Actif'),
(64, 'KARA-CHI-2025-004', 'Ken', 'Sokhna', 'sokhna.ken@kara.sn', '+221 70 345 6789', '2004-02-11', 'Saint-Louis', 'F', 'Sénégalaise', 8, 1, 'Actif'),
(65, 'KARA-CHI-2025-005', 'Cissé', 'Pape', 'pape.cisse@kara.sn', '+221 76 456 7890', '2003-08-05', 'Louga', 'M', 'Sénégalaise', 8, 1, 'Actif'),
(66, 'KARA-CHI-2025-006', 'Gueye', 'Khady', 'khady.gueye@kara.sn', '+221 77 567 8901', '2003-01-21', 'Tambacounda', 'F', 'Sénégalaise', 8, 1, 'Actif'),
(67, 'KARA-CHI-2025-007', 'Ndiaye', 'Yacine', 'yacine.ndiaye@kara.sn', '+221 70 678 9012', '2003-10-13', 'Kolda', 'M', 'Sénégalaise', 8, 1, 'Actif'),
(68, 'KARA-CHI-2025-008', 'Traoré', 'Marième', 'marieme.traore@kara.sn', '+221 76 789 0123', '2003-05-28', 'Dakar', 'F', 'Sénégalaise', 8, 1, 'Actif'),
(69, 'KARA-CHI-2025-009', 'Sarr', 'Idy', 'idy.sarr@kara.sn', '+221 77 890 1234', '2003-03-02', 'Ziguinchor', 'M', 'Sénégalaise', 8, 1, 'Actif'),
(70, 'KARA-CHI-2025-010', 'Bah', 'Kadiatou', 'kadiatou.bah@kara.sn', '+221 70 901 2345', '2003-11-19', 'Dakar', 'F', 'Sénégalaise', 8, 1, 'Actif');

-- ========================================
-- 7. INSERTIONS NOTES
-- ========================================

INSERT INTO `note` (`id_note`, `valeur_note`, `session`, `date_examen`, `id_etudiant`, `id_ec`) VALUES
-- Étudiants GL
(1, 16.5, 'Normale', '2025-02-15', 1, 1),
(2, 15.0, 'Normale', '2025-02-16', 1, 2),
(3, 14.5, 'Normale', '2025-02-18', 1, 3),
(4, 18.5, 'Normale', '2025-02-15', 2, 1),
(5, 17.0, 'Normale', '2025-02-16', 2, 2),
(6, 12.5, 'Normale', '2025-02-15', 3, 1),
(7, 11.0, 'Normale', '2025-02-16', 3, 2),
(8, 14.0, 'Rattrapage', '2025-03-10', 3, 1),
(9, 17.5, 'Normale', '2025-02-15', 4, 1),
(10, 16.0, 'Normale', '2025-02-16', 4, 2),

-- Étudiants INFO
(11, 16.0, 'Normale', '2025-02-20', 16, 20),
(12, 15.5, 'Normale', '2025-02-21', 16, 21),
(13, 18.0, 'Normale', '2025-02-20', 17, 20),
(14, 17.0, 'Normale', '2025-02-21', 17, 21),
(15, 13.0, 'Normale', '2025-02-20', 18, 20),
(16, 12.5, 'Normale', '2025-02-21', 18, 21),
(17, 15.5, 'Rattrapage', '2025-03-15', 18, 20),

-- Étudiants GEST
(18, 14.5, 'Normale', '2025-02-25', 31, 32),
(19, 13.0, 'Normale', '2025-02-26', 31, 33),
(20, 16.5, 'Normale', '2025-02-25', 32, 32),
(21, 15.0, 'Normale', '2025-02-26', 32, 33),

-- Étudiants MA
(22, 15.5, 'Normale', '2025-02-28', 43, 40),
(23, 14.0, 'Normale', '2025-03-01', 43, 41),
(24, 17.0, 'Normale', '2025-02-28', 44, 40),
(25, 16.5, 'Normale', '2025-03-01', 44, 41),

-- Étudiants PHY
(26, 15.5, 'Normale', '2025-03-05', 51, 43),
(27, 14.0, 'Normale', '2025-03-06', 51, 45),
(28, 17.0, 'Normale', '2025-03-05', 52, 43),
(29, 16.5, 'Normale', '2025-03-06', 52, 45),

-- Étudiants CHI
(30, 16.5, 'Normale', '2025-03-10', 61, 47),
(31, 15.0, 'Normale', '2025-03-11', 61, 49),
(32, 18.0, 'Normale', '2025-03-10', 62, 47),
(33, 16.5, 'Normale', '2025-03-11', 62, 49),
(34, 19.0, 'Normale', '2025-03-10', 63, 47),
(35, 17.5, 'Normale', '2025-03-11', 63, 49);

-- ========================================
-- 8. INSERTIONS SESSION RATTRAPAGE
-- ========================================

INSERT INTO `session_rattrapage` (`id_session`, `code_session`, `date_debut`, `date_fin`, `id_filiere`, `statut`, `description`) VALUES
(1, 'RAT-25-01-GL', '2025-03-10', '2025-03-20', 1, 'Programmée', 'Session de rattrapage Génie Logiciel S1 2025'),
(2, 'RAT-25-01-INFO', '2025-03-10', '2025-03-20', 3, 'Programmée', 'Session de rattrapage Informatique S1 2025'),
(3, 'RAT-25-01-GEST', '2025-03-10', '2025-03-20', 5, 'Programmée', 'Session de rattrapage Gestion S1 2025'),
(4, 'RAT-25-01-MA', '2025-03-17', '2025-03-27', 4, 'Programmée', 'Session de rattrapage Mathématiques S1 2025');

-- ========================================
-- 9. UTILISATEURS (Admin, Enseignants, etc.)
-- ========================================

INSERT INTO `utilisateur` (`id_user`, `nom`, `prenom`, `email`, `password`, `telephone`, `role`, `poste`, `date_embauche`, `statut`) VALUES
-- Administrateur
(1, 'Diallo', 'Cheikh', 'admin@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 111 9999', 'Admin', 'Directeur Général', '2024-09-01', 'Actif'),

-- Enseignants
(2, 'Ken', 'Ousmane', 'ousmane.ken@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0001', 'Enseignant', 'Professeur', '2024-01-15', 'Actif'),
(3, 'Traoré', 'Yacine', 'yacine.traore@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0002', 'Enseignant', 'Maître Assistant', '2024-06-01', 'Actif'),
(4, 'Ndiaye', 'Aïda', 'aida.ndiaye@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0003', 'Enseignant', 'Professeur', '2023-08-20', 'Actif'),
(5, 'Seck', 'Alassane', 'alassane.seck@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0004', 'Enseignant', 'Assistant', '2024-02-01', 'Actif'),

-- Personnel Scolarité
(6, 'Fall', 'Samba', 'samba.fall@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0007', 'Scolarite', 'Chef Scolarité', '2021-01-20', 'Actif'),
(7, 'Cissé', 'Oumou', 'oumou.cisse@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0008', 'Scolarite', 'Assistant Scolarité', '2024-06-01', 'Actif'),

-- Directeurs
(8, 'Gueye', 'Mamadou', 'mamadou.gueye@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0009', 'Directeur', 'Directeur SI', '2023-01-01', 'Actif'),
(9, 'Bah', 'Awa', 'awa.bah@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0010', 'Directeur', 'Directeur MI', '2023-01-01', 'Actif'),
(10, 'Sarr', 'Lamine', 'lamine.sarr@kara.sn', '$2y$10$J5Yy8b6Y8g2N3T9P0X1Q2Z3C4V5B6N7M8A9K0L1M2N3O4P5Q6R7S8', '+221 77 222 0011', 'Directeur', 'Directeur EG', '2023-01-01', 'Actif');

-- ========================================
-- 10. ATTESTATIONS DE RÉUSSITE
-- ========================================

INSERT INTO `attestation_reussite` (`id_attestation`, `code_attestation`, `id_etudiant`, `semestre`, `moyenne_generale`, `mention`, `credits_ects_obtenus`, `date_emission`, `date_validite`, `statut`) VALUES
(1, 'ATT-25-GL-001-S1', 1, 1, 15.3, 'Bien', 30, '2025-03-15', '2026-03-15', 'Active'),
(2, 'ATT-25-GL-002-S1', 2, 1, 16.3, 'Très bien', 30, '2025-03-15', '2026-03-15', 'Active'),
(3, 'ATT-25-INFO-001-S1', 16, 1, 15.0, 'Bien', 24, '2025-03-16', '2026-03-16', 'Active'),
(4, 'ATT-25-INFO-002-S1', 17, 1, 17.2, 'Très bien', 24, '2025-03-16', '2026-03-16', 'Active'),
(5, 'ATT-25-GEST-001-S1', 31, 1, 13.3, 'Assez bien', 24, '2025-03-17', '2026-03-17', 'Active'),
(6, 'ATT-25-GEST-002-S1', 32, 1, 15.3, 'Bien', 24, '2025-03-17', '2026-03-17', 'Active'),
(7, 'ATT-25-MA-001-S1', 43, 1, 14.75, 'Bien', 18, '2025-03-18', '2026-03-18', 'Active'),
(8, 'ATT-25-MA-002-S1', 44, 1, 16.75, 'Très bien', 18, '2025-03-18', '2026-03-18', 'Active');

-- ========================================
-- 11. DÉLIBÉRATIONS
-- ========================================

INSERT INTO `deliberation` (`id_deliberation`, `code_deliberation`, `id_etudiant`, `semestre`, `moyenne_semestre`, `statut`, `mention`, `credits_obtenus`, `date_deliberation`, `responsable_deliberation`, `observations`) VALUES
(1, 'DEL-25-GL-001-01', 1, 1, 15.3, 'Admis', 'Bien', 30, '2025-03-01', 'Dr. Ousmane Ken', 'Étudiant très assidu'),
(2, 'DEL-25-GL-002-01', 2, 1, 16.3, 'Admis', 'Très bien', 30, '2025-03-01', 'Dr. Ousmane Ken', 'Excellent travail'),
(3, 'DEL-25-GL-003-01', 3, 1, 10.5, 'Redoublant', 'Faible', 18, '2025-03-01', 'Dr. Ousmane Ken', 'À améliorer'),
(4, 'DEL-25-INFO-001-01', 16, 1, 15.0, 'Admis', 'Bien', 24, '2025-03-02', 'Dr. Aïda Ndiaye', 'Travail correct'),
(5, 'DEL-25-INFO-002-01', 17, 1, 17.2, 'Admis', 'Très bien', 24, '2025-03-02', 'Dr. Aïda Ndiaye', 'Excellent'),
(6, 'DEL-25-GEST-001-01', 31, 1, 13.3, 'Admis', 'Assez bien', 24, '2025-03-03', 'Dr. Bassirou Diallo', 'Bon début'),
(7, 'DEL-25-GEST-002-01', 32, 1, 15.3, 'Admis', 'Bien', 24, '2025-03-03', 'Dr. Bassirou Diallo', 'Progrès observés'),
(8, 'DEL-25-MA-001-01', 43, 1, 14.75, 'Admis', 'Bien', 18, '2025-03-04', 'Dr. Fatou Gueye', 'Correct'),
(9, 'DEL-25-MA-002-01', 44, 1, 16.75, 'Admis', 'Très bien', 18, '2025-03-04', 'Dr. Fatou Gueye', 'Très bon');

-- ========================================
-- 12. CARTES ÉTUDIANTES
-- ========================================

INSERT INTO `carte_etudiant` (`id_carte`, `id_etudiant`, `numero_carte`, `date_emission`, `date_expiration`, `statut`, `qr_code`, `photo_url`) VALUES
(1, 1, 'CARTE-KARA-GL-2025-001', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2025-001', '/uploads/photos/etudiant_001.jpg'),
(2, 2, 'CARTE-KARA-GL-2025-002', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2025-002', '/uploads/photos/etudiant_002.jpg'),
(3, 3, 'CARTE-KARA-GL-2025-003', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2025-003', '/uploads/photos/etudiant_003.jpg'),
(4, 16, 'CARTE-KARA-INFO-2025-001', '2024-09-01', '2025-09-01', 'Active', 'QR-INFO-2025-001', '/uploads/photos/etudiant_016.jpg'),
(5, 17, 'CARTE-KARA-INFO-2025-002', '2024-09-01', '2025-09-01', 'Active', 'QR-INFO-2025-002', '/uploads/photos/etudiant_017.jpg'),
(6, 31, 'CARTE-KARA-GEST-2025-001', '2024-09-01', '2025-09-01', 'Active', 'QR-GEST-2025-001', '/uploads/photos/etudiant_031.jpg'),
(7, 32, 'CARTE-KARA-GEST-2025-002', '2024-09-01', '2025-09-01', 'Active', 'QR-GEST-2025-002', '/uploads/photos/etudiant_032.jpg'),
(8, 43, 'CARTE-KARA-MA-2025-001', '2024-09-01', '2025-09-01', 'Active', 'QR-MA-2025-001', '/uploads/photos/etudiant_043.jpg'),
(9, 51, 'CARTE-KARA-PHY-2025-001', '2024-09-01', '2025-09-01', 'Active', 'QR-PHY-2025-001', '/uploads/photos/etudiant_051.jpg'),
(10, 61, 'CARTE-KARA-CHI-2025-001', '2024-09-01', '2025-09-01', 'Active', 'QR-CHI-2025-001', '/uploads/photos/etudiant_061.jpg');

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
