-- ========================================
-- DONNÉES DE TEST - NOMS SÉNÉGALAIS
-- Génération de données fictives complètes pour tests
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

-- ========================================
-- TRUNCATE DES TABLES (Vider les anciennes données)
-- ========================================

TRUNCATE TABLE `audit_log`;
TRUNCATE TABLE `proces_verbal`;
TRUNCATE TABLE `attestation_reussite`;
TRUNCATE TABLE `carte_etudiant`;
TRUNCATE TABLE `configuration_coefficients`;
TRUNCATE TABLE `deliberation`;
TRUNCATE TABLE `inscription_rattrapage`;
TRUNCATE TABLE `session_rattrapage`;
TRUNCATE TABLE `note`;
TRUNCATE TABLE `programme`;
TRUNCATE TABLE `etudiant`;
TRUNCATE TABLE `ec`;
TRUNCATE TABLE `ue`;
TRUNCATE TABLE `filiere`;
TRUNCATE TABLE `departement`;
TRUNCATE TABLE `utilisateur`;

-- ========================================
-- 1. INSERTIONS DÉPARTEMENTS
-- ========================================

INSERT INTO `departement` (`nom_dept`, `code_dept`, `chef_dept`) VALUES
('Sciences de l''Ingénieur', 'SI', 'Pr. Cheikh Diallo'),
('Mathématiques & Informatique', 'MI', 'Pr. Aïssatou Diop'),
('Économie & Gestion', 'EG', 'Pr. Mamadou Sarr'),
('Sciences Physiques', 'SP', 'Pr. Aminata Sall'),
('Lettres & Sciences Humaines', 'LSH', 'Pr. Moussa Gueye');

-- ========================================
-- 2. INSERTIONS FILIÈRES
-- ========================================

INSERT INTO `filiere` (`nom_filiere`, `code_filiere`, `responsable`, `id_dept`, `niveau`, `nb_semestres`) VALUES
('Génie Logiciel', 'GL', 'Dr. Ousmane Ken', 1, 'Licence', 6),
('Génie Électronique', 'GE', 'Dr. Yacine Traoré', 1, 'Licence', 6),
('Informatique', 'INFO', 'Dr. Aïda Ndiaye', 2, 'Licence', 6),
('Mathématiques Appliquées', 'MA', 'Dr. Fatou Gueye', 2, 'License', 6),
('Gestion d''Entreprise', 'GEST', 'Dr. Bassirou Touré', 3, 'Licence', 6),
('Comptabilité & Finance', 'CF', 'Dr. Hawa Sall', 3, 'Licence', 6),
('Physique', 'PHY', 'Dr. Ibrahima Bah', 4, 'Licence', 6),
('Chimie', 'CHI', 'Dr. Khady Fall', 4, 'Licence', 6),
('Lettres Modernes', 'LM', 'Dr. Lamine Diouf', 5, 'Licence', 6),
('Histoire & Géographie', 'HG', 'Dr. Marième Kane', 5, 'Licence', 6);

-- ========================================
-- 3. INSERTIONS UE (Unités d'Enseignement)
-- ========================================

INSERT INTO `ue` (`code_ue`, `libelle_ue`, `credits_ects`, `coefficient`, `volume_horaire`, `id_dept`) VALUES
-- Génie Logiciel (2 premiers semestres)
('GL-S1-001', 'Programmation I (Java)', 6, 2, 45, 1),
('GL-S1-002', 'Mathématiques Discrètes', 6, 1.5, 45, 1),
('GL-S1-003', 'Architecture des Ordinateurs', 6, 1.5, 45, 1),
('GL-S1-004', 'Bases de Données I', 6, 2, 45, 1),
('GL-S1-005', 'Anglais Technique', 3, 1, 30, 1),

('GL-S2-001', 'Programmation II (OOP)', 6, 2, 45, 1),
('GL-S2-002', 'Algorithme & Structures', 6, 2, 45, 1),
('GL-S2-003', 'Bases de Données II', 6, 2, 45, 1),
('GL-S2-004', 'Projet Informatique I', 6, 1.5, 45, 1),
('GL-S2-005', 'Communication Professionnelle', 3, 1, 30, 1),

-- Informatique
('INFO-S1-001', 'Fondamentaux Informatique', 6, 1.5, 45, 2),
('INFO-S1-002', 'Python Avancé', 6, 2, 45, 2),
('INFO-S1-003', 'Systèmes d''Exploitation', 6, 1.5, 45, 2),
('INFO-S1-004', 'Web Design I', 6, 1.5, 45, 2),

('INFO-S2-001', 'Réseaux Informatiques', 6, 2, 45, 2),
('INFO-S2-002', 'Administration Systèmes', 6, 2, 45, 2),
('INFO-S2-003', 'Web Design II (PHP)', 6, 2, 45, 2),

-- Gestion d'Entreprise
('GEST-S1-001', 'Économie Générale', 6, 1.5, 45, 3),
('GEST-S1-002', 'Comptabilité Générale', 6, 2, 45, 3),
('GEST-S1-003', 'Management I', 6, 1.5, 45, 3),
('GEST-S1-004', 'Droit Commercial', 6, 1, 45, 3),

('GEST-S2-001', 'Comptabilité Analytique', 6, 2, 45, 3),
('GEST-S2-002', 'Management II', 6, 1.5, 45, 3),
('GEST-S2-003', 'Finance d''Entreprise', 6, 2, 45, 3),

-- Mathématiques Appliquées
('MA-S1-001', 'Algèbre Linéaire', 6, 2, 45, 2),
('MA-S1-002', 'Analyse Réelle', 6, 2, 45, 2),
('MA-S1-003', 'Probabilités I', 6, 1.5, 45, 2),

-- Physique
('PHY-S1-001', 'Mécanique Classique', 6, 2, 45, 4),
('PHY-S1-002', 'Électricité I', 6, 2, 45, 4),
('PHY-S1-003', 'Thermodynamique', 6, 1.5, 45, 4),

-- Chimie
('CHI-S1-001', 'Chimie Générale', 6, 2, 45, 4),
('CHI-S1-002', 'Chimie Organique I', 6, 2, 45, 4),
('CHI-S1-003', 'Chimie Analytique', 6, 1.5, 45, 4);

-- ========================================
-- 4. INSERTIONS EC (Éléments Constitutifs)
-- ========================================

INSERT INTO `ec` (`code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
-- GL-S1-001: Programmation I
('GL-S1-001-TP', 'TP Programmation I', 1.2, 22, 1),
('GL-S1-001-CM', 'CM Programmation I', 0.8, 23, 1),

-- GL-S1-002: Mathématiques Discrètes
('GL-S1-002-CM', 'CM Mathématiques Discrètes', 1, 30, 2),
('GL-S1-002-TD', 'TD Mathématiques Discrètes', 0.5, 15, 2),

-- GL-S1-003: Architecture
('GL-S1-003-CM', 'CM Architecture', 1, 30, 3),
('GL-S1-003-TP', 'TP Architecture', 0.5, 15, 3),

-- GL-S1-004: BD I
('GL-S1-004-CM', 'CM BD I - Modélisation', 1, 30, 4),
('GL-S1-004-TP', 'TP BD I - SQL', 1, 15, 4),

-- GL-S1-005: Anglais
('GL-S1-005-CM', 'CM Anglais Technique', 1, 30, 5),

-- GL-S2-001: Programmation II
('GL-S2-001-TP', 'TP Programmation OOP', 1.2, 22, 6),
('GL-S2-001-CM', 'CM Programmation OOP', 0.8, 23, 6),

-- GL-S2-002: Algorithme
('GL-S2-002-CM', 'CM Algorithme', 1.2, 30, 7),
('GL-S2-002-TP', 'TP Algorithme', 0.8, 15, 7),

-- GL-S2-003: BD II
('GL-S2-003-CM', 'CM BD II - Avancé', 1, 30, 8),
('GL-S2-003-TP', 'TP BD II - NoSQL', 1, 15, 8),

-- GL-S2-004: Projet
('GL-S2-004-PROJ', 'Projet Informatique', 1.5, 45, 9),

-- GL-S2-005: Communication
('GL-S2-005-CM', 'CM Communication', 1, 30, 10),

-- INFO-S1-001
('INFO-S1-001-CM', 'CM Fondamentaux', 1, 30, 11),
('INFO-S1-001-TP', 'TP Fondamentaux', 0.5, 15, 11),

-- INFO-S1-002
('INFO-S1-002-CM', 'CM Python', 1.2, 30, 12),
('INFO-S1-002-TP', 'TP Python', 0.8, 15, 12),

-- INFO-S1-003
('INFO-S1-003-CM', 'CM OS', 1, 30, 13),
('INFO-S1-003-TP', 'TP OS', 0.5, 15, 13),

-- INFO-S1-004
('INFO-S1-004-CM', 'CM Web I', 0.8, 22.5, 14),
('INFO-S1-004-TP', 'TP Web I', 0.7, 22.5, 14),

-- INFO-S2-001
('INFO-S2-001-CM', 'CM Réseaux', 1.2, 30, 15),
('INFO-S2-001-TP', 'TP Réseaux', 0.8, 15, 15),

-- INFO-S2-002
('INFO-S2-002-CM', 'CM Administration', 1, 30, 16),
('INFO-S2-002-TP', 'TP Administration', 1, 15, 16),

-- INFO-S2-003
('INFO-S2-003-CM', 'CM Web II PHP', 1.2, 22.5, 17),
('INFO-S2-003-TP', 'TP Web II PHP', 0.8, 22.5, 17),

-- GEST-S1
('GEST-S1-001-CM', 'CM Économie Générale', 1.5, 45, 18),
('GEST-S1-002-CM', 'CM Comptabilité Générale', 1.5, 45, 19),
('GEST-S1-002-TP', 'TP Comptabilité', 0.5, 0, 19),
('GEST-S1-003-CM', 'CM Management I', 1.5, 45, 20),
('GEST-S1-004-CM', 'CM Droit Commercial', 1, 45, 21),

-- GEST-S2
('GEST-S2-001-CM', 'CM Comptabilité Analytique', 2, 45, 22),
('GEST-S2-002-CM', 'CM Management II', 1.5, 45, 23),
('GEST-S2-003-CM', 'CM Finance d''Entreprise', 2, 45, 24),

-- MA-S1
('MA-S1-001-CM', 'CM Algèbre Linéaire', 1.5, 45, 25),
('MA-S1-002-CM', 'CM Analyse Réelle', 1.5, 45, 26),
('MA-S1-003-CM', 'CM Probabilités', 1.5, 45, 27),

-- PHY-S1
('PHY-S1-001-CM', 'CM Mécanique', 1.5, 45, 28),
('PHY-S1-001-TP', 'TP Mécanique', 0.5, 0, 28),
('PHY-S1-002-CM', 'CM Électricité I', 1.5, 45, 29),
('PHY-S1-003-CM', 'CM Thermodynamique', 1.5, 45, 30),

-- CHI-S1
('CHI-S1-001-CM', 'CM Chimie Générale', 1.5, 45, 31),
('CHI-S1-001-TP', 'TP Chimie Générale', 0.5, 0, 31),
('CHI-S1-002-CM', 'CM Chimie Organique', 1.5, 45, 32),
('CHI-S1-003-CM', 'CM Chimie Analytique', 1.5, 45, 33);

-- ========================================
-- 5. INSERTIONS PROGRAMME (Maquettes LMD)
-- ========================================

INSERT INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
-- Génie Logiciel - Semestre 1
(1, 1, 1, '2024-2025'),
(1, 2, 1, '2024-2025'),
(1, 3, 1, '2024-2025'),
(1, 4, 1, '2024-2025'),
(1, 5, 1, '2024-2025'),

-- Génie Logiciel - Semestre 2
(1, 6, 2, '2024-2025'),
(1, 7, 2, '2024-2025'),
(1, 8, 2, '2024-2025'),
(1, 9, 2, '2024-2025'),
(1, 10, 2, '2024-2025'),

-- Informatique - Semestre 1
(3, 11, 1, '2024-2025'),
(3, 12, 1, '2024-2025'),
(3, 13, 1, '2024-2025'),
(3, 14, 1, '2024-2025'),

-- Informatique - Semestre 2
(3, 15, 2, '2024-2025'),
(3, 16, 2, '2024-2025'),
(3, 17, 2, '2024-2025'),

-- Gestion - Semestre 1
(5, 18, 1, '2024-2025'),
(5, 19, 1, '2024-2025'),
(5, 20, 1, '2024-2025'),
(5, 21, 1, '2024-2025'),

-- Gestion - Semestre 2
(5, 22, 2, '2024-2025'),
(5, 23, 2, '2024-2025'),
(5, 24, 2, '2024-2025'),

-- Mathématiques
(4, 25, 1, '2024-2025'),
(4, 26, 1, '2024-2025'),
(4, 27, 1, '2024-2025'),

-- Physique
(7, 28, 1, '2024-2025'),
(7, 29, 1, '2024-2025'),
(7, 30, 1, '2024-2025'),

-- Chimie
(8, 31, 1, '2024-2025'),
(8, 32, 1, '2024-2025'),
(8, 33, 1, '2024-2025');

-- ========================================
-- 6. INSERTIONS ÉTUDIANTS - NOMS SÉNÉGALAIS
-- ========================================

INSERT INTO `etudiant` (`matricule`, `nom`, `prenom`, `email`, `telephone`, `date_naissance`, `lieu_naissance`, `sexe`, `nationalite`, `id_filiere`, `semestre_actuel`, `statut`) VALUES
-- Génie Logiciel (15 étudiants)
('2024-GL-001', 'Diallo', 'Mamadou', 'mamadou.diallo@univ.sn', '+221 77 123 4567', '2003-05-15', 'Dakar', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-002', 'Touré', 'Fatima', 'fatima.toure@univ.sn', '+221 76 987 6543', '2003-08-20', 'Kaolack', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-003', 'Sall', 'Mohamed', 'mohamed.sall@univ.sn', '+221 77 456 7890', '2003-12-10', 'Thiès', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-004', 'Ken', 'Aïssatou', 'aissatou.ken@univ.sn', '+221 70 234 5678', '2004-03-25', 'Saint-Louis', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-005', 'Cissé', 'Moussa', 'moussa.cisse@univ.sn', '+221 77 345 6789', '2003-07-08', 'Kolda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-006', 'Gueye', 'Hawa', 'hawa.gueye@univ.sn', '+221 76 567 8901', '2004-01-14', 'Matam', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-007', 'Ndiaye', 'Ousmane', 'ousmane.ndiaye@univ.sn', '+221 70 678 9012', '2003-09-22', 'Tambacounda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-008', 'Traoré', 'Khady', 'khady.traore@univ.sn', '+221 77 789 0123', '2003-11-05', 'Ziguinchor', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-009', 'Sarr', 'Lamine', 'lamine.sarr@univ.sn', '+221 76 890 1234', '2003-04-17', 'Kaolack', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-010', 'Bah', 'Marième', 'marieme.bah@univ.sn', '+221 77 901 2345', '2004-06-09', 'Dakar', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-011', 'Fall', 'Cheikh', 'cheikh.fall@univ.sn', '+221 70 012 3456', '2003-10-30', 'Thirès', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-012', 'Diouf', 'Aïda', 'aida.diouf@univ.sn', '+221 76 123 4567', '2003-02-18', 'Saint-Louis', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-013', 'Kane', 'Abdu', 'abdu.kane@univ.sn', '+221 77 234 5678', '2003-08-12', 'Kolda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-014', 'Thiaw', 'Néné', 'nene.thiaw@univ.sn', '+221 77 345 6789', '2004-05-03', 'Kaolack', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('2024-GL-015', 'Seck', 'Babacar', 'babacar.seck@univ.sn', '+221 76 456 7890', '2003-07-21', 'Louga', 'M', 'Sénégalaise', 1, 1, 'Actif'),

-- Informatique (15 étudiants)
('2024-INFO-001', 'Ba', 'Meissa', 'meissa.ba@univ.sn', '+221 70 567 8901', '2003-01-11', 'Dakar', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-002', 'Ndar', 'Yasmine', 'yasmine.ndar@univ.sn', '+221 77 678 9012', '2003-03-28', 'Thiès', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-003', 'Dia', 'Ibrahima', 'ibrahima.dia@univ.sn', '+221 76 789 0123', '2003-11-07', 'Kaolack', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-004', 'Ly', 'Aminata', 'aminata.ly@univ.sn', '+221 77 890 1234', '2004-04-19', 'Saint-Louis', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-005', 'Ba', 'Ady', 'ady.ba@univ.sn', '+221 70 901 2345', '2003-06-26', 'Tambacounda', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-006', 'Guèye', 'Awa', 'awa.gueye@univ.sn', '+221 76 012 3456', '2003-09-05', 'Ziguinchor', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-007', 'Niang', 'Yacine', 'yacine.niang@univ.sn', '+221 77 123 4567', '2003-02-14', 'Dakar', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-008', 'Diop', 'Penda', 'penda.diop@univ.sn', '+221 70 234 5678', '2003-12-21', 'Louga', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-009', 'Ndour', 'Seydina', 'seydina.ndour@univ.sn', '+221 77 345 6789', '2003-08-30', 'Kolda', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-010', 'Cissé', 'Éva', 'eva.cisse@univ.sn', '+221 76 456 7890', '2004-02-16', 'Thiès', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-011', 'Diallo', 'Mouhamed', 'mouhamed.diallo@univ.sn', '+221 77 567 8901', '2003-10-08', 'Saint-Louis', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-012', 'Mbaye', 'Rokhaya', 'rokhaya.mbaye@univ.sn', '+221 70 678 9012', '2003-05-23', 'Dakar', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-013', 'Sarr', 'Birame', 'birame.sarr@univ.sn', '+221 76 789 0123', '2003-07-09', 'Kaolack', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-014', 'Seck', 'Ndeye', 'ndeye.seck@univ.sn', '+221 77 890 1234', '2004-01-25', 'Matam', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('2024-INFO-015', 'Ndiaye', 'Aliou', 'aliou.ndiaye@univ.sn', '+221 70 901 2345', '2003-09-11', 'Ziguinchor', 'M', 'Sénégalaise', 3, 1, 'Actif'),

-- Gestion d'Entreprise (12 étudiants)
('2024-GEST-001', 'Touré', 'Ramatoulaye', 'ramatoulaye.toure@univ.sn', '+221 76 012 3456', '2003-03-17', 'Dakar', 'F', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-002', 'Diallo', 'Bassirou', 'bassirou.diallo@univ.sn', '+221 77 123 4567', '2003-11-22', 'Thiès', 'M', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-003', 'Sall', 'Oumou', 'oumou.sall@univ.sn', '+221 70 234 5678', '2003-04-30', 'Kaolack', 'F', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-004', 'Ken', 'Idrissa', 'idrissa.ken@univ.sn', '+221 76 345 6789', '2003-08-13', 'Saint-Louis', 'M', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-005', 'Cissé', 'Waly', 'waly.cisse@univ.sn', '+221 77 456 7890', '2003-06-07', 'Louga', 'M', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-006', 'Gueye', 'Fatimata', 'fatimata.gueye@univ.sn', '+221 70 567 8901', '2004-02-04', 'Tambacounda', 'F', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-007', 'Ndiaye', 'Habib', 'habib.ndiaye@univ.sn', '+221 76 678 9012', '2003-09-16', 'Kolda', 'M', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-008', 'Traoré', 'Aïda', 'aida.traore@univ.sn', '+221 77 789 0123', '2003-01-29', 'Dakar', 'F', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-009', 'Sarr', 'Mamadou', 'mamadou.sarr@univ.sn', '+221 70 890 1234', '2003-10-11', 'Ziguinchor', 'M', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-010', 'Bah', 'Sokhna', 'sokhna.bah@univ.sn', '+221 77 901 2345', '2003-05-03', 'Saint-Louis', 'F', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-011', 'Fall', 'Samba', 'samba.fall@univ.sn', '+221 76 012 3456', '2003-07-20', 'Kaolack', 'M', 'Sénégalaise', 5, 1, 'Actif'),
('2024-GEST-012', 'Diouf', 'Ndiaye', 'ndiaye.diouf@univ.sn', '+221 77 123 4567', '2004-03-08', 'Thiès', 'F', 'Sénégalaise', 5, 1, 'Actif'),

-- Mathématiques (8 étudiants)
('2024-MA-001', 'Kane', 'Saliou', 'saliou.kane@univ.sn', '+221 70 234 5678', '2003-02-15', 'Dakar', 'M', 'Sénégalaise', 4, 1, 'Actif'),
('2024-MA-002', 'Thiaw', 'Issa', 'issa.thiaw@univ.sn', '+221 76 345 6789', '2003-09-22', 'Matam', 'M', 'Sénégalaise', 4, 1, 'Actif'),
('2024-MA-003', 'Seck', 'Awa', 'awa.seck@univ.sn', '+221 77 456 7890', '2003-06-10', 'Kolda', 'F', 'Sénégalaise', 4, 1, 'Actif'),
('2024-MA-004', 'Ba', 'Ousmane', 'ousmane.ba@univ.sn', '+221 70 567 8901', '2003-11-27', 'Louga', 'M', 'Sénégalaise', 4, 1, 'Actif'),
('2024-MA-005', 'Ndar', 'Pape', 'pape.ndar@univ.sn', '+221 76 678 9012', '2003-04-05', 'Tambacounda', 'M', 'Sénégalaise', 4, 1, 'Actif'),
('2024-MA-006', 'Dia', 'Adama', 'adama.dia@univ.sn', '+221 77 789 0123', '2003-08-18', 'Saint-Louis', 'M', 'Sénégalaise', 4, 1, 'Actif'),
('2024-MA-007', 'Ly', 'Maimouna', 'maimouna.ly@univ.sn', '+221 70 890 1234', '2004-01-12', 'Ziguinchor', 'F', 'Sénégalaise', 4, 1, 'Actif'),
('2024-MA-008', 'Ba', 'Maty', 'maty.ba@univ.sn', '+221 76 901 2345', '2003-07-31', 'Thiès', 'F', 'Sénégalaise', 4, 1, 'Actif'),

-- Physique (10 étudiants)
('2024-PHY-001', 'Guèye', 'Demba', 'demba.gueye@univ.sn', '+221 77 012 3456', '2003-10-19', 'Dakar', 'M', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-002', 'Niang', 'Fatou', 'fatou.niang@univ.sn', '+221 70 123 4567', '2003-05-09', 'Kaolack', 'F', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-003', 'Diop', 'Modou', 'modou.diop@univ.sn', '+221 76 234 5678', '2003-03-26', 'Thiès', 'M', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-004', 'Ndour', 'Amine', 'amine.ndour@univ.sn', '+221 77 345 6789', '2003-09-01', 'Saint-Louis', 'M', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-005', 'Cissé', 'Oumou', 'oumou.cisse@univ.sn', '+221 70 456 7890', '2004-04-15', 'Louga', 'F', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-006', 'Mbaye', 'Sekou', 'sekou.mbaye@univ.sn', '+221 76 567 8901', '2003-08-22', 'Matam', 'M', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-007', 'Sarr', 'Katy', 'katy.sarr@univ.sn', '+221 77 678 9012', '2003-02-07', 'Tambacounda', 'F', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-008', 'Seck', 'Aliou', 'aliou.seck@univ.sn', '+221 70 789 0123', '2003-12-14', 'Kolda', 'M', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-009', 'Ndiaye', 'Sokhna', 'sokhna.ndiaye@univ.sn', '+221 76 890 1234', '2003-06-30', 'Ziguinchor', 'F', 'Sénégalaise', 7, 1, 'Actif'),
('2024-PHY-010', 'Toure', 'Moussa', 'moussa.toure@univ.sn', '+221 77 901 2345', '2003-11-08', 'Dakar', 'M', 'Sénégalaise', 7, 1, 'Actif'),

-- Chimie (10 étudiants)
('2024-CHI-001', 'Diallo', 'Yasmine', 'yasmine.diallo@univ.sn', '+221 70 012 3456', '2003-07-03', 'Dakar', 'F', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-002', 'Touré', 'Cheikh', 'cheikh.toure@univ.sn', '+221 76 123 4567', '2003-04-16', 'Thiès', 'M', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-003', 'Sall', 'Néné', 'nene.sall@univ.sn', '+221 77 234 5678', '2003-09-24', 'Kaolack', 'M', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-004', 'Ken', 'Sokhna', 'sokhna.ken@univ.sn', '+221 70 345 6789', '2004-02-11', 'Saint-Louis', 'F', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-005', 'Cissé', 'Pape', 'pape.cisse@univ.sn', '+221 76 456 7890', '2003-08-05', 'Louga', 'M', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-006', 'Gueye', 'Khady', 'khady.gueye@univ.sn', '+221 77 567 8901', '2003-01-21', 'Tambacounda', 'F', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-007', 'Ndiaye', 'Yacine', 'yacine.ndiaye@univ.sn', '+221 70 678 9012', '2003-10-13', 'Kolda', 'M', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-008', 'Traoré', 'Marième', 'marieme.traore@univ.sn', '+221 76 789 0123', '2003-05-28', 'Dakar', 'F', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-009', 'Sarr', 'Idy', 'idy.sarr@univ.sn', '+221 77 890 1234', '2003-03-02', 'Ziguinchor', 'M', 'Sénégalaise', 8, 1, 'Actif'),
('2024-CHI-010', 'Bah', 'Kadiatou', 'kadiatou.bah@univ.sn', '+221 70 901 2345', '2003-11-19', 'Dakar', 'F', 'Sénégalaise', 8, 1, 'Actif');

-- ========================================
-- 7. INSERTIONS NOTES
-- ========================================

INSERT INTO `note` (`valeur_note`, `session`, `date_examen`, `id_etudiant`, `id_ec`) VALUES
-- Étudiant 1 - GL-S1 (Mamadou Diallo)
(16.5, 'Normale', '2025-01-15', 1, 1),
(15.0, 'Normale', '2025-01-16', 1, 2),
(14.5, 'Normale', '2025-01-18', 1, 3),
(17.0, 'Normale', '2025-01-15', 1, 4),
(13.5, 'Normale', '2025-01-17', 1, 5),

-- Étudiant 2 - GL-S1 (Fatima Touré)
(18.5, 'Normale', '2025-01-15', 2, 1),
(17.0, 'Normale', '2025-01-16', 2, 2),
(16.5, 'Normale', '2025-01-18', 2, 3),
(15.5, 'Normale', '2025-01-15', 2, 4),
(14.0, 'Normale', '2025-01-17', 2, 5),

-- Étudiant 3 - GL-S1 (Mohamed Sall)
(12.5, 'Normale', '2025-01-15', 3, 1),
(11.0, 'Normale', '2025-01-16', 3, 2),
(10.5, 'Normale', '2025-01-18', 3, 3),
(9.5, 'Normale', '2025-01-15', 3, 4),
(8.0, 'Normale', '2025-01-17', 3, 5),
(14.0, 'Rattrapage', '2025-02-10', 3, 1),
(13.5, 'Rattrapage', '2025-02-11', 3, 2),

-- Étudiant 4 - GL-S1 (Aïssatou Ken)
(17.5, 'Normale', '2025-01-15', 4, 1),
(16.0, 'Normale', '2025-01-16', 4, 2),
(15.0, 'Normale', '2025-01-18', 4, 3),
(16.5, 'Normale', '2025-01-15', 4, 4),
(15.0, 'Normale', '2025-01-17', 4, 5),

-- Étudiant 5 - GL-S1 (Moussa Cissé)
(14.0, 'Normale', '2025-01-15', 5, 1),
(13.5, 'Normale', '2025-01-16', 5, 2),
(12.5, 'Normale', '2025-01-18', 5, 3),
(13.0, 'Normale', '2025-01-15', 5, 4),
(12.0, 'Normale', '2025-01-17', 5, 5),

-- Étudiant 6 - GL-S1 (Hawa Gueye)
(15.5, 'Normale', '2025-01-15', 6, 1),
(14.0, 'Normale', '2025-01-16', 6, 2),
(13.5, 'Normale', '2025-01-18', 6, 3),
(14.5, 'Normale', '2025-01-15', 6, 4),
(13.0, 'Normale', '2025-01-17', 6, 5),

-- INFO étudiants (16 et suivants)
(16.0, 'Normale', '2025-01-20', 16, 20),
(15.5, 'Normale', '2025-01-21', 16, 21),
(14.5, 'Normale', '2025-01-22', 16, 22),

(18.0, 'Normale', '2025-01-20', 17, 20),
(17.0, 'Normale', '2025-01-21', 17, 21),
(16.5, 'Normale', '2025-01-22', 17, 22),

(13.0, 'Normale', '2025-01-20', 18, 20),
(12.5, 'Normale', '2025-01-21', 18, 21),
(11.5, 'Normale', '2025-01-22', 18, 22),
(15.5, 'Rattrapage', '2025-02-15', 18, 20),

(17.5, 'Normale', '2025-01-20', 19, 20),
(16.0, 'Normale', '2025-01-21', 19, 21),
(15.5, 'Normale', '2025-01-22', 19, 22),

-- GEST étudiants
(14.5, 'Normale', '2025-01-25', 28, 48),
(13.0, 'Normale', '2025-01-26', 28, 49),
(12.5, 'Normale', '2025-01-27', 28, 50),

(16.5, 'Normale', '2025-01-25', 29, 48),
(15.0, 'Normale', '2025-01-26', 29, 49),
(14.5, 'Normale', '2025-01-27', 29, 50),

(11.0, 'Normale', '2025-01-25', 30, 48),
(10.5, 'Normale', '2025-01-26', 30, 49),
(10.0, 'Normale', '2025-01-27', 30, 50),

-- Mathématiques
(15.5, 'Normale', '2025-01-30', 36, 56),
(14.0, 'Normale', '2025-01-31', 36, 57),

(17.0, 'Normale', '2025-01-30', 37, 56),
(16.5, 'Normale', '2025-01-31', 37, 57);

-- ========================================
-- 8. INSERTIONS SESSION RATTRAPAGE
-- ========================================

INSERT INTO `session_rattrapage` (`code_session`, `date_debut`, `date_fin`, `id_filiere`, `statut`, `description`) VALUES
('RAT-24-01-GL', '2025-02-10', '2025-02-20', 1, 'Programmée', 'Session de rattrapage Génie Logiciel S1 2024-2025'),
('RAT-24-01-INFO', '2025-02-10', '2025-02-20', 3, 'Programmée', 'Session de rattrapage Informatique S1 2024-2025'),
('RAT-24-01-GEST', '2025-02-10', '2025-02-20', 5, 'Programmée', 'Session de rattrapage Gestion S1 2024-2025'),
('RAT-24-01-MA', '2025-02-17', '2025-02-27', 4, 'Programmée', 'Session de rattrapage Mathématiques S1 2024-2025');

-- ========================================
-- 9. INSERTIONS INSCRIPTION RATTRAPAGE
-- ========================================

INSERT INTO `inscription_rattrapage` (`id_etudiant`, `id_session`, `id_ec`, `statut`) VALUES
(3, 1, 1, 'Inscrit'),
(3, 1, 2, 'Inscrit'),
(18, 2, 20, 'Inscrit'),
(30, 3, 48, 'Inscrit');

-- ========================================
-- 10. INSERTIONS DÉLIBÉRATION
-- ========================================

INSERT INTO `deliberation` (`code_deliberation`, `id_etudiant`, `semestre`, `moyenne_semestre`, `statut`, `mention`, `credits_obtenus`, `date_deliberation`, `responsable_deliberation`, `observations`) VALUES
('DEL-24-GL-001-01', 1, 1, 15.3, 'Admis', 'Bien', 30, '2025-02-01', 'Dr. Ousmane Ken', 'Étudiant très assidu'),
('DEL-24-GL-002-01', 2, 1, 16.3, 'Admis', 'Très bien', 30, '2025-02-01', 'Dr. Ousmane Ken', 'Excellent travail'),
('DEL-24-GL-003-01', 3, 1, 10.5, 'Redoublant', 'Faible', 18, '2025-02-01', 'Dr. Ousmane Ken', 'À améliorer'),
('DEL-24-GL-004-01', 4, 1, 16.0, 'Admis', 'Très bien', 30, '2025-02-01', 'Dr. Ousmane Ken', 'Bon travail'),
('DEL-24-GL-005-01', 5, 1, 13.0, 'Admis', 'Assez bien', 30, '2025-02-01', 'Dr. Ousmane Ken', 'À consolider'),

('DEL-24-INFO-001-01', 16, 1, 15.0, 'Admis', 'Bien', 24, '2025-02-02', 'Dr. Aïda Ndiaye', 'Travail correct'),
('DEL-24-INFO-002-01', 17, 1, 17.2, 'Admis', 'Très bien', 24, '2025-02-02', 'Dr. Aïda Ndiaye', 'Excellent'),
('DEL-24-INFO-003-01', 18, 1, 12.0, 'Ajourné', 'Faible', 12, '2025-02-02', 'Dr. Aïda Ndiaye', 'Session rattrapage requise'),

('DEL-24-GEST-001-01', 28, 1, 13.3, 'Admis', 'Assez bien', 24, '2025-02-03', 'Dr. Bassirou Diallo', 'Bon début'),
('DEL-24-GEST-002-01', 29, 1, 15.3, 'Admis', 'Bien', 24, '2025-02-03', 'Dr. Bassirou Diallo', 'Progrès observés'),
('DEL-24-GEST-003-01', 30, 1, 10.5, 'Redoublant', 'Faible', 12, '2025-02-03', 'Dr. Bassirou Diallo', 'À reprendre'),

('DEL-24-MA-001-01', 36, 1, 14.75, 'Admis', 'Bien', 18, '2025-02-04', 'Dr. Fatou Gueye', 'Correct'),
('DEL-24-MA-002-01', 37, 1, 16.75, 'Admis', 'Très bien', 18, '2025-02-04', 'Dr. Fatou Gueye', 'Très bon');

-- ========================================
-- 11. INSERTIONS UTILISATEURS (Admin, Enseignants, etc.)
-- ========================================

INSERT INTO `utilisateur` (`nom`, `prenom`, `email`, `password`, `telephone`, `role`, `poste`, `date_embauche`, `statut`) VALUES
-- Administrateur
('Diallo', 'Cheikh', 'admin@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 111 9999', 'Admin', 'Directeur Général', '2020-09-01', 'Actif'),

-- Enseignants Génie Logiciel
('Ken', 'Ousmane', 'ousmane.ken@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0001', 'Enseignant', 'Professeur', '2021-01-15', 'Actif'),
('Traoré', 'Yacine', 'yacine.traore@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0002', 'Enseignant', 'Maître Assistant', '2021-06-01', 'Actif'),

-- Enseignants Informatique
('Ndiaye', 'Aïda', 'aida.ndiaye@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0003', 'Enseignant', 'Professeur', '2020-08-20', 'Actif'),
('Seck', 'Alassane', 'alassane.seck@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0004', 'Enseignant', 'Assistant', '2022-02-01', 'Actif'),

-- Enseignants Gestion
('Diallo', 'Bassirou', 'bassirou.diallo@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0005', 'Enseignant', 'Professeur', '2019-09-10', 'Actif'),
('Sall', 'Mariama', 'mariama.sall@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0006', 'Enseignant', 'Maître Assistant', '2021-01-05', 'Actif'),

-- Personnels Scolarité
('Fall', 'Samba', 'samba.fall@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0007', 'Scolarite', 'Chef Scolarité', '2018-01-20', 'Actif'),
('Cissé', 'Oumou', 'oumou.cisse@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0008', 'Scolarite', 'Assistant Scolarité', '2022-06-01', 'Actif'),

-- Directeurs de Département
('Gueye', 'Mamadou', 'mamadou.gueye@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0009', 'Directeur', 'Directeur SI', '2020-01-01', 'Actif'),
('Bah', 'Awa', 'awa.bah@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0010', 'Directeur', 'Directeur MI', '2020-01-01', 'Actif'),
('Sarr', 'Lamine', 'lamine.sarr@univ.sn', '$2y$10$wPEE3eKk1Q1F0z6VvVvvJOjVOaOYvVSO1e8gvZ8n8eT9.L8bW8Mti', '+221 77 222 0011', 'Directeur', 'Directeur EG', '2020-01-01', 'Actif');

-- ========================================
-- 12. INSERTIONS ATTESTATIONS DE RÉUSSITE
-- ========================================

INSERT INTO `attestation_reussite` (`code_attestation`, `id_etudiant`, `semestre`, `moyenne_generale`, `mention`, `credits_ects_obtenus`, `date_emission`, `date_validite`, `statut`) VALUES
('ATT-24-GL-001-S1', 1, 1, 15.3, 'Bien', 30, '2025-02-15', '2026-02-15', 'Active'),
('ATT-24-GL-002-S1', 2, 1, 16.3, 'Très bien', 30, '2025-02-15', '2026-02-15', 'Active'),
('ATT-24-INFO-001-S1', 16, 1, 15.0, 'Bien', 24, '2025-02-16', '2026-02-16', 'Active'),
('ATT-24-INFO-002-S1', 17, 1, 17.2, 'Très bien', 24, '2025-02-16', '2026-02-16', 'Active'),
('ATT-24-GEST-001-S1', 28, 1, 13.3, 'Assez bien', 24, '2025-02-17', '2026-02-17', 'Active'),
('ATT-24-GEST-002-S1', 29, 1, 15.3, 'Bien', 24, '2025-02-17', '2026-02-17', 'Active'),
('ATT-24-MA-001-S1', 36, 1, 14.75, 'Bien', 18, '2025-02-18', '2026-02-18', 'Active'),
('ATT-24-MA-002-S1', 37, 1, 16.75, 'Très bien', 18, '2025-02-18', '2026-02-18', 'Active');

-- ========================================
-- 13. INSERTIONS CARTES ÉTUDIANTES
-- ========================================

INSERT INTO `carte_etudiant` (`id_etudiant`, `numero_carte`, `date_emission`, `date_expiration`, `statut`, `qr_code`, `photo_url`) VALUES
(1, 'CARTE-GL-2024-001', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-001', '/uploads/photos/etudiant_001.jpg'),
(2, 'CARTE-GL-2024-002', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-002', '/uploads/photos/etudiant_002.jpg'),
(3, 'CARTE-GL-2024-003', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-003', '/uploads/photos/etudiant_003.jpg'),
(4, 'CARTE-GL-2024-004', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-004', '/uploads/photos/etudiant_004.jpg'),
(5, 'CARTE-GL-2024-005', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-005', '/uploads/photos/etudiant_005.jpg'),
(6, 'CARTE-GL-2024-006', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-006', '/uploads/photos/etudiant_006.jpg'),
(7, 'CARTE-GL-2024-007', '2024-09-01', '2025-09-01', 'Suspendue', 'QR-GL-2024-007', '/uploads/photos/etudiant_007.jpg'),
(8, 'CARTE-GL-2024-008', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-008', '/uploads/photos/etudiant_008.jpg'),
(9, 'CARTE-GL-2024-009', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-009', '/uploads/photos/etudiant_009.jpg'),
(10, 'CARTE-GL-2024-010', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-010', '/uploads/photos/etudiant_010.jpg'),
(11, 'CARTE-GL-2024-011', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-011', '/uploads/photos/etudiant_011.jpg'),
(12, 'CARTE-GL-2024-012', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-012', '/uploads/photos/etudiant_012.jpg'),
(13, 'CARTE-GL-2024-013', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-013', '/uploads/photos/etudiant_013.jpg'),
(14, 'CARTE-GL-2024-014', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-014', '/uploads/photos/etudiant_014.jpg'),
(15, 'CARTE-GL-2024-015', '2024-09-01', '2025-09-01', 'Active', 'QR-GL-2024-015', '/uploads/photos/etudiant_015.jpg'),
(16, 'CARTE-INFO-2024-001', '2024-09-01', '2025-09-01', 'Active', 'QR-INFO-2024-001', '/uploads/photos/etudiant_016.jpg'),
(17, 'CARTE-INFO-2024-002', '2024-09-01', '2025-09-01', 'Active', 'QR-INFO-2024-002', '/uploads/photos/etudiant_017.jpg'),
(18, 'CARTE-INFO-2024-003', '2024-09-01', '2025-09-01', 'Active', 'QR-INFO-2024-003', '/uploads/photos/etudiant_018.jpg'),
(28, 'CARTE-GEST-2024-001', '2024-09-01', '2025-09-01', 'Active', 'QR-GEST-2024-001', '/uploads/photos/etudiant_028.jpg'),
(29, 'CARTE-GEST-2024-002', '2024-09-01', '2025-09-01', 'Active', 'QR-GEST-2024-002', '/uploads/photos/etudiant_029.jpg'),
(30, 'CARTE-GEST-2024-003', '2024-09-01', '2025-09-01', 'Active', 'QR-GEST-2024-003', '/uploads/photos/etudiant_030.jpg'),
(36, 'CARTE-MA-2024-001', '2024-09-01', '2025-09-01', 'Active', 'QR-MA-2024-001', '/uploads/photos/etudiant_036.jpg'),
(37, 'CARTE-MA-2024-002', '2024-09-01', '2025-09-01', 'Active', 'QR-MA-2024-002', '/uploads/photos/etudiant_037.jpg');

-- ========================================
-- 14. INSERTIONS CONFIGURATION COEFFICIENTS
-- ========================================

INSERT INTO `configuration_coefficients` (`id_filiere`, `id_ue`, `coefficient_ue`, `credit_ects_ue`, `volume_horaire_total`, `annee_academique`) VALUES
(1, 1, 2.0, 6, 45, '2024-2025'),
(1, 2, 1.5, 6, 45, '2024-2025'),
(1, 3, 1.5, 6, 45, '2024-2025'),
(1, 4, 2.0, 6, 45, '2024-2025'),
(1, 5, 1.0, 3, 30, '2024-2025'),
(3, 11, 1.5, 6, 45, '2024-2025'),
(3, 12, 2.0, 6, 45, '2024-2025'),
(3, 13, 1.5, 6, 45, '2024-2025'),
(3, 14, 1.5, 6, 45, '2024-2025'),
(5, 18, 1.5, 6, 45, '2024-2025'),
(5, 19, 2.0, 6, 45, '2024-2025'),
(5, 20, 1.5, 6, 45, '2024-2025'),
(5, 21, 1.0, 6, 45, '2024-2025');

-- ========================================
-- 15. INSERTIONS AUDIT LOG (Logs d'activités)
-- ========================================

INSERT INTO `audit_log` (`user_id`, `action`, `table_name`, `record_id`, `old_values`, `new_values`, `ip_address`, `created_at`) VALUES
(1, 'CREATE', 'etudiant', '1', NULL, 'nom=Diallo, prenom=Mamadou, matricule=2024-GL-001', '127.0.0.1', NOW()),
(1, 'CREATE', 'etudiant', '2', NULL, 'nom=Touré, prenom=Fatima, matricule=2024-GL-002', '127.0.0.1', NOW()),
(1, 'CREATE', 'note', '1', NULL, 'id_etudiant=1, id_ec=1, valeur_note=16.5', '127.0.0.1', NOW()),
(1, 'UPDATE', 'deliberation', 'DEL-24-GL-001-01', 'statut=En attente', 'statut=Admis', '127.0.0.1', NOW()),
(1, 'CREATE', 'utilisateur', '2', NULL, 'nom=Ken, prenom=Ousmane, role=Enseignant', '127.0.0.1', NOW()),
(2, 'CREATE', 'note', '5', NULL, 'id_etudiant=1, id_ec=1, valeur_note=16.5', '192.168.1.100', NOW());

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
