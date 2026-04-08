-- ========================================
-- DONNÉES INFORMATIQUE COMPLÈTES
-- Départements, UE, EC et Étudiants avec Notes
-- ========================================

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";
SET FOREIGN_KEY_CHECKS = 0;

-- ========================================
-- 1. CRÉER/INSÉRER DÉPARTEMENTS INFORMATIQUE
-- ========================================

INSERT INTO `departement` (`nom_dept`, `code_dept`, `chef_dept`) VALUES
('Informatique & Systèmes d''Information', 'ISI_2025', 'Pr. Aïchatou Sow'),
('Sciences Informatiques Avancées', 'SIA_2025', 'Pr. Ibrahima Diallo'),
('Cybersécurité & Réseaux', 'CSR_2025', 'Pr. Fatou Ndiaye');

-- ========================================
-- 2. CRÉER FILIÈRES INFORMATIQUE
-- ========================================

INSERT INTO `filiere` (`nom_filiere`, `code_filiere`, `responsable`, `id_dept`, `niveau`, `nb_semestres`) VALUES
('Développement Web & Mobile', 'DWM_2025', 'Dr. Ousmane Seck', 2, 'Licence', 6),
('Administration Systèmes & Réseaux', 'ASR_2025', 'Dr. Yacine Diop', 3, 'Licence', 6),
('Base de Données & Big Data', 'BDBD_2025', 'Dr. Mariama Gueye', 2, 'Licence', 6),
('Génie Logiciel Avancé', 'GLA_2025', 'Dr. Saliou Traoré', 2, 'Master', 4),
('Intelligence Artificielle', 'IA_2025', 'Dr. Hawa Sarr', 2, 'Master', 4);

-- ========================================
-- 3. CRÉER UE INFORMATIQUE (30+ UE)
-- ========================================

INSERT INTO `ue` (`code_ue`, `libelle_ue`, `credits_ects`, `coefficient`, `volume_horaire`, `id_dept`) VALUES
-- Développement Web
('DWM-S1-001', 'HTML5 & CSS3 Avancé', 6, 2, 45, 2),
('DWM-S1-002', 'Programmation JavaScript ES6+', 6, 2.5, 45, 2),
('DWM-S1-003', 'Design Responsif & UX/UI', 6, 1.5, 45, 2),
('DWM-S1-004', 'Backend: PHP & Framework Laravel', 6, 2.5, 45, 2),
('DWM-S1-005', 'Bases de Données MySQL', 6, 2, 45, 2),

('DWM-S2-001', 'React.js & Vue.js', 6, 2.5, 45, 2),
('DWM-S2-002', 'Node.js & Express', 6, 2.5, 45, 2),
('DWM-S2-003', 'API REST & GraphQL', 6, 2, 45, 2),
('DWM-S2-004', 'Sécurité Web & OWASP', 6, 2, 45, 2),
('DWM-S2-005', 'Déploiement & DevOps', 6, 1.5, 45, 2),

-- Administration Systèmes
('ASR-S1-001', 'Systèmes d''Exploitation Linux', 6, 2, 45, 3),
('ASR-S1-002', 'Active Directory & Windows Server', 6, 2, 45, 3),
('ASR-S1-003', 'Administration Réseau TCP/IP', 6, 2, 45, 3),
('ASR-S1-004', 'Virtualisation: Hyper-V & VMware', 6, 1.5, 45, 3),
('ASR-S1-005', 'Stockage & SAN', 6, 1.5, 45, 3),

('ASR-S2-001', 'Routage Avancé Cisco', 6, 2, 45, 3),
('ASR-S2-002', 'Commutation & VLAN', 6, 2, 45, 3),
('ASR-S2-003', 'Pare-feu & VPN', 6, 2, 45, 3),
('ASR-S2-004', 'Monitoring & Troubleshooting', 6, 1.5, 45, 3),

-- Base de Données/Big Data
('BDBD-S1-001', 'Modélisation de Données', 6, 2, 45, 2),
('BDBD-S1-002', 'SQL Avancé & Optimisation', 6, 2.5, 45, 2),
('BDBD-S1-003', 'NoSQL: MongoDB & Cassandra', 6, 2, 45, 2),
('BDBD-S1-004', 'Introduction au Big Data', 6, 1.5, 45, 2),
('BDBD-S1-005', 'ETL & Intégration de Données', 6, 2, 45, 2),

('BDBD-S2-001', 'Hadoop & MapReduce', 6, 2, 45, 2),
('BDBD-S2-002', 'Spark & Scala', 6, 2.5, 45, 2),
('BDBD-S2-003', 'Data Warehousing', 6, 2, 45, 2),

-- Génie Logiciel Avancé (Master)
('GLA-M1-001', 'Architecture Logicielle', 6, 2.5, 45, 2),
('GLA-M1-002', 'Patterns de Conception', 6, 2, 45, 2),
('GLA-M1-003', 'Qualité & Tests Logiciel', 6, 2, 45, 2),
('GLA-M1-004', 'Gestion de Projet Agile', 6, 1.5, 45, 2),

-- Intelligence Artificielle (Master)
('IA-M1-001', 'Machine Learning Fondamental', 6, 2.5, 45, 2),
('IA-M1-002', 'Deep Learning & Réseaux Neuronaux', 6, 2.5, 45, 2),
('IA-M1-003', 'Traitement du Langage Naturel', 6, 2, 45, 2),
('IA-M1-004', 'Vision par Ordinateur', 6, 2, 45, 2);

-- ========================================
-- 4. CRÉER EC (60+ EC)
-- ========================================

INSERT INTO `ec` (`code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
-- DWM-S1-001 (HTML5 & CSS3)
('DWM-S1-001-CM', 'CM: Structure HTML5', 1.2, 22, 1),
('DWM-S1-001-TP', 'TP: Projets CSS3', 0.8, 23, 1),

-- DWM-S1-002 (JavaScript)
('DWM-S1-002-CM', 'CM: Concepts JavaScript', 1.5, 22, 2),
('DWM-S1-002-TP', 'TP: Programmation reactive', 1, 23, 2),

-- DWM-S1-003 (Design)
('DWM-S1-003-CM', 'CM: Principes UX/UI', 1, 30, 3),
('DWM-S1-003-TP', 'TP: Prototypage Figma', 0.5, 15, 3),

-- DWM-S1-004 (PHP Laravel)
('DWM-S1-004-CM', 'CM: Framework Laravel', 1.5, 22, 4),
('DWM-S1-004-TP', 'TP: Développement Backend', 1, 23, 4),

-- DWM-S1-005 (MySQL)
('DWM-S1-005-CM', 'CM: Modélisation BD', 1.2, 22, 5),
('DWM-S1-005-TP', 'TP: SQL & Requêtes', 0.8, 23, 5),

-- DWM-S2-001 (React/Vue)
('DWM-S2-001-CM', 'CM: Composants React', 1.5, 22, 6),
('DWM-S2-001-TP', 'TP: SPA avec React', 1, 23, 6),

-- DWM-S2-002 (Node.js)
('DWM-S2-002-CM', 'CM: Event-Driven Architecture', 1.5, 22, 7),
('DWM-S2-002-TP', 'TP: API Express', 1, 23, 7),

-- DWM-S2-003 (API)
('DWM-S2-003-CM', 'CM: Design API REST', 1.2, 22, 8),
('DWM-S2-003-TP', 'TP: Implémentation GraphQL', 0.8, 23, 8),

-- DWM-S2-004 (Sécurité)
('DWM-S2-004-CM', 'CM: Vulnérabilités Web', 1.2, 22, 9),
('DWM-S2-004-TP', 'TP: Pentesting Web', 0.8, 23, 9),

-- DWM-S2-005 (DevOps)
('DWM-S2-005-CM', 'CM: Docker & Kubernetes', 1, 30, 10),
('DWM-S2-005-TP', 'TP: CI/CD Pipelines', 0.5, 15, 10),

-- ASR-S1-001 (Linux)
('ASR-S1-001-CM', 'CM: Administration Linux', 1.5, 22, 11),
('ASR-S1-001-TP', 'TP: Shell Scripting', 0.5, 23, 11),

-- ASR-S1-002 (Windows Server)
('ASR-S1-002-CM', 'CM: Active Directory', 1.2, 22, 12),
('ASR-S1-002-TP', 'TP: GPO & Stratégies', 0.8, 23, 12),

-- ASR-S1-003 (Réseau)
('ASR-S1-003-CM', 'CM: Protocoles TCP/IP', 1.5, 22, 13),
('ASR-S1-003-TP', 'TP: Subnetting & Routing', 0.5, 23, 13),

-- ASR-S1-004 (Virtualisation)
('ASR-S1-004-CM', 'CM: Virtualisation', 1, 22, 14),
('ASR-S1-004-TP', 'TP: Hyper-V & vSphere', 0.5, 23, 14),

-- ASR-S1-005 (SAN)
('ASR-S1-005-CM', 'CM: Architectures Stockage', 1, 22, 15),
('ASR-S1-005-TP', 'TP: SAN & NAS', 0.5, 23, 15),

-- ASR-S2-001 (Routage Cisco)
('ASR-S2-001-CM', 'CM: Routage statique/dynamique', 1.5, 22, 16),
('ASR-S2-001-TP', 'TP: Configuration Cisco', 0.5, 23, 16),

-- ASR-S2-002 (Commutation)
('ASR-S2-002-CM', 'CM: Switching Avancé', 1.2, 22, 17),
('ASR-S2-002-TP', 'TP: VLAN & Spanning Tree', 0.8, 23, 17),

-- ASR-S2-003 (Pare-feu)
('ASR-S2-003-CM', 'CM: Sécurité Réseau', 1.2, 22, 18),
('ASR-S2-003-TP', 'TP: Firewall & VPN', 0.8, 23, 18),

-- BDBD-S1-001 (Modélisation)
('BDBD-S1-001-CM', 'CM: MCD/MLD', 1.5, 22, 20),
('BDBD-S1-001-TP', 'TP: Merise & ER', 0.5, 23, 20),

-- BDBD-S1-002 (SQL Avancé)
('BDBD-S1-002-CM', 'CM: Performance SQL', 1.5, 22, 21),
('BDBD-S1-002-TP', 'TP: Indexation & Tunning', 1, 23, 21),

-- BDBD-S1-003 (NoSQL)
('BDBD-S1-003-CM', 'CM: MongoDB Avancé', 1.2, 22, 22),
('BDBD-S1-003-TP', 'TP: Cassandra & HBase', 0.8, 23, 22),

-- BDBD-S1-004 (Big Data)
('BDBD-S1-004-CM', 'CM: Introduction Hadoop', 1, 22, 23),
('BDBD-S1-004-TP', 'TP: Configuration HDFS', 0.5, 23, 23),

-- BDBD-S1-005 (ETL)
('BDBD-S1-005-CM', 'CM: Processus ETL', 1.2, 22, 24),
('BDBD-S1-005-TP', 'TP: Talend & Pentaho', 0.8, 23, 24),

-- GLA-M1-001 (Architecture)
('GLA-M1-001-CM', 'CM: Patterns Architecturaux', 1.5, 22, 29),
('GLA-M1-001-TP', 'TP: Microservices', 1, 23, 29),

-- GLA-M1-002 (Patterns)
('GLA-M1-002-CM', 'CM: Design Patterns', 1.2, 22, 30),
('GLA-M1-002-TP', 'TP: Implémentation Patterns', 0.8, 23, 30),

-- IA-M1-001 (ML)
('IA-M1-001-CM', 'CM: Algorithmes ML', 1.5, 22, 33),
('IA-M1-001-TP', 'TP: Sklearn & Pandas', 1, 23, 33),

-- IA-M1-002 (Deep Learning)
('IA-M1-002-CM', 'CM: Réseaux Neuronaux', 1.5, 22, 34),
('IA-M1-002-TP', 'TP: TensorFlow & PyTorch', 1, 23, 34);

-- ========================================
-- 5. INSÉRER FILIÈRES/UE DANS PROGRAMME
-- ========================================

INSERT INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
-- DWM (Développement Web & Mobile)
(1, 1, 1, '2025-2026'),
(1, 2, 1, '2025-2026'),
(1, 3, 1, '2025-2026'),
(1, 4, 1, '2025-2026'),
(1, 5, 1, '2025-2026'),
(1, 6, 2, '2025-2026'),
(1, 7, 2, '2025-2026'),
(1, 8, 2, '2025-2026'),
(1, 9, 2, '2025-2026'),
(1, 10, 2, '2025-2026'),

-- ASR (Administration Systèmes)
(2, 11, 1, '2025-2026'),
(2, 12, 1, '2025-2026'),
(2, 13, 1, '2025-2026'),
(2, 14, 1, '2025-2026'),
(2, 15, 1, '2025-2026'),
(2, 16, 2, '2025-2026'),
(2, 17, 2, '2025-2026'),
(2, 18, 2, '2025-2026'),

-- BDBD (Base de Données)
(3, 20, 1, '2025-2026'),
(3, 21, 1, '2025-2026'),
(3, 22, 1, '2025-2026'),
(3, 23, 1, '2025-2026'),
(3, 24, 1, '2025-2026'),
(3, 25, 2, '2025-2026'),
(3, 26, 2, '2025-2026'),
(3, 27, 2, '2025-2026');

-- ========================================
-- 6. INSÉRER ÉTUDIANTS INFORMATIQUE (50+)
-- ========================================

INSERT INTO `etudiant` (`matricule`, `nom`, `prenom`, `email`, `telephone`, `date_naissance`, `lieu_naissance`, `sexe`, `nationalite`, `id_filiere`, `semestre_actuel`, `statut`) VALUES
-- DWM: Développement Web (20 étudiants)
('INFO-DWM-2025-001', 'Diallo', 'Mamadou', 'mamadou.diallo.dwm@univ.sn', '+221 77 100 0001', '2003-01-15', 'Dakar', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-002', 'Sall', 'Fatima', 'fatima.sall.dwm@univ.sn', '+221 76 100 0002', '2003-03-20', 'Thiès', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-003', 'Touré', 'Mohamed', 'mohamed.toure.dwm@univ.sn', '+221 77 100 0003', '2003-05-10', 'Kaolack', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-004', 'Ken', 'Aïssatou', 'aissatou.ken.dwm@univ.sn', '+221 70 100 0004', '2004-02-14', 'Kolda', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-005', 'Cissé', 'Moussa', 'moussa.cisse.dwm@univ.sn', '+221 77 100 0005', '2003-07-25', 'Tambacounda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-006', 'Gueye', 'Hawa', 'hawa.gueye.dwm@univ.sn', '+221 76 100 0006', '2003-09-12', 'Saint-Louis', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-007', 'Ndiaye', 'Ousmane', 'ousmane.ndiaye.dwm@univ.sn', '+221 70 100 0007', '2003-11-05', 'Matam', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-008', 'Traoré', 'Khady', 'khady.traore.dwm@univ.sn', '+221 77 100 0008', '2003-06-18', 'Louga', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-009', 'Sarr', 'Lamine', 'lamine.sarr.dwm@univ.sn', '+221 76 100 0009', '2003-04-30', 'Ziguinchor', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-010', 'Bah', 'Marième', 'marieme.bah.dwm@univ.sn', '+221 77 100 0010', '2003-08-22', 'Dakar', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-011', 'Fall', 'Cheikh', 'cheikh.fall.dwm@univ.sn', '+221 70 100 0011', '2003-10-17', 'Thiès', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-012', 'Diouf', 'Aïda', 'aida.diouf.dwm@univ.sn', '+221 76 100 0012', '2003-12-03', 'Kaolack', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-013', 'Kane', 'Abdu', 'abdu.kane.dwm@univ.sn', '+221 77 100 0013', '2003-02-27', 'Kolda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-014', 'Thiaw', 'Néné', 'nene.thiaw.dwm@univ.sn', '+221 70 100 0014', '2004-01-11', 'Louga', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-015', 'Seck', 'Babacar', 'babacar.seck.dwm@univ.sn', '+221 77 100 0015', '2003-09-08', 'Saint-Louis', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-016', 'Ba', 'Yacine', 'yacine.ba.dwm@univ.sn', '+221 76 100 0016', '2003-05-20', 'Tambacounda', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-017', 'Ndar', 'Sokhna', 'sokhna.ndar.dwm@univ.sn', '+221 77 100 0017', '2003-07-14', 'Matam', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-018', 'Dia', 'Pape', 'pape.dia.dwm@univ.sn', '+221 70 100 0018', '2003-03-09', 'Ziguinchor', 'M', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-019', 'Ly', 'Kadiatou', 'kadiatou.ly.dwm@univ.sn', '+221 76 100 0019', '2004-04-25', 'Dakar', 'F', 'Sénégalaise', 1, 1, 'Actif'),
('INFO-DWM-2025-020', 'Niang', 'Demba', 'demba.niang.dwm@univ.sn', '+221 77 100 0020', '2003-06-30', 'Thiès', 'M', 'Sénégalaise', 1, 1, 'Actif'),

-- ASR: Administration Systèmes (18 étudiants)
('INFO-ASR-2025-001', 'Diop', 'Modou', 'modou.diop.asr@univ.sn', '+221 70 100 0021', '2003-02-16', 'Kaolack', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-002', 'Ndour', 'Amine', 'amine.ndour.asr@univ.sn', '+221 77 100 0022', '2003-08-11', 'Kolda', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-003', 'Mbaye', 'Sekou', 'sekou.mbaye.asr@univ.sn', '+221 76 100 0023', '2003-10-22', 'Louga', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-004', 'Gueye', 'Awa', 'awa.gueye.asr@univ.sn', '+221 77 100 0024', '2003-04-19', 'Saint-Louis', 'F', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-005', 'Niang', 'Fatou', 'fatou.niang.asr@univ.sn', '+221 70 100 0025', '2003-06-05', 'Tambacounda', 'F', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-006', 'Cissé', 'Oumou', 'oumou.cisse.asr@univ.sn', '+221 76 100 0026', '2003-12-31', 'Matam', 'F', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-007', 'Sall', 'Ibrahima', 'ibrahima.sall.asr@univ.sn', '+221 77 100 0027', '2003-01-13', 'Ziguinchor', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-008', 'Touré', 'Yasmine', 'yasmine.toure.asr@univ.sn', '+221 70 100 0028', '2003-09-26', 'Dakar', 'F', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-009', 'Ken', 'Idrissa', 'idrissa.ken.asr@univ.sn', '+221 76 100 0029', '2003-05-01', 'Thiès', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-010', 'Cissé', 'Waly', 'waly.cisse.asr@univ.sn', '+221 77 100 0030', '2003-11-14', 'Kaolack', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-011', 'Fall', 'Samba', 'samba.fall.asr@univ.sn', '+221 70 100 0031', '2003-07-29', 'Kolda', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-012', 'Diouf', 'Ndeye', 'ndeye.diouf.asr@univ.sn', '+221 76 100 0032', '2003-03-07', 'Louga', 'F', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-013', 'Kane', 'Saliou', 'saliou.kane.asr@univ.sn', '+221 77 100 0033', '2003-08-23', 'Saint-Louis', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-014', 'Thiaw', 'Issa', 'issa.thiaw.asr@univ.sn', '+221 70 100 0034', '2003-10-04', 'Tambacounda', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-015', 'Seck', 'Awa', 'awa.seck.asr@univ.sn', '+221 76 100 0035', '2004-02-18', 'Matam', 'F', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-016', 'Ba', 'Ousmane', 'ousmane.ba.asr@univ.sn', '+221 77 100 0036', '2003-04-11', 'Ziguinchor', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-017', 'Ndar', 'Pape', 'pape.ndar.asr@univ.sn', '+221 70 100 0037', '2003-06-28', 'Dakar', 'M', 'Sénégalaise', 2, 1, 'Actif'),
('INFO-ASR-2025-018', 'Dia', 'Adama', 'adama.dia.asr@univ.sn', '+221 76 100 0038', '2003-09-15', 'Thiès', 'M', 'Sénégalaise', 2, 1, 'Actif'),

-- BDBD: Base de Données (16 étudiants)
('INFO-BDBD-2025-001', 'Ly', 'Maimouna', 'maimouna.ly.bdbd@univ.sn', '+221 77 100 0039', '2004-01-22', 'Kaolack', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-002', 'Ba', 'Maty', 'maty.ba.bdbd@univ.sn', '+221 70 100 0040', '2003-07-08', 'Kolda', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-003', 'Guèye', 'Demba', 'demba.gueye.bdbd@univ.sn', '+221 76 100 0041', '2003-05-03', 'Louga', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-004', 'Niang', 'Fatou', 'fatou.niang.bdbd@univ.sn', '+221 77 100 0042', '2003-09-19', 'Saint-Louis', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-005', 'Diop', 'Modou', 'modou.diop.bdbd@univ.sn', '+221 70 100 0043', '2003-02-14', 'Tambacounda', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-006', 'Ndour', 'Amine', 'amine.ndour.bdbd@univ.sn', '+221 76 100 0044', '2003-11-30', 'Matam', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-007', 'Mbaye', 'Sekou', 'sekou.mbaye.bdbd@univ.sn', '+221 77 100 0045', '2003-08-07', 'Ziguinchor', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-008', 'Sarr', 'Katy', 'katy.sarr.bdbd@univ.sn', '+221 70 100 0046', '2003-04-26', 'Dakar', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-009', 'Seck', 'Aliou', 'aliou.seck.bdbd@univ.sn', '+221 76 100 0047', '2003-06-12', 'Thiès', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-010', 'Ndiaye', 'Sokhna', 'sokhna.ndiaye.bdbd@univ.sn', '+221 77 100 0048', '2003-10-21', 'Kaolack', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-011', 'Toure', 'Moussa', 'moussa.toure.bdbd@univ.sn', '+221 70 100 0049', '2003-01-05', 'Kolda', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-012', 'Diallo', 'Yasmine', 'yasmine.diallo.bdbd@univ.sn', '+221 76 100 0050', '2003-03-18', 'Louga', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-013', 'Touré', 'Cheikh', 'cheikh.toure.bdbd@univ.sn', '+221 77 100 0051', '2003-07-24', 'Saint-Louis', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-014', 'Sall', 'Néné', 'nene.sall.bdbd@univ.sn', '+221 70 100 0052', '2003-09-02', 'Tambacounda', 'M', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-015', 'Ken', 'Sokhna', 'sokhna.ken.bdbd@univ.sn', '+221 76 100 0053', '2004-02-09', 'Matam', 'F', 'Sénégalaise', 3, 1, 'Actif'),
('INFO-BDBD-2025-016', 'Cissé', 'Pape', 'pape.cisse.bdbd@univ.sn', '+221 77 100 0054', '2003-06-16', 'Ziguinchor', 'M', 'Sénégalaise', 3, 1, 'Actif');

-- ========================================
-- 7. INSÉRER NOTES (150+ notes)
-- ========================================

INSERT INTO `note` (`valeur_note`, `session`, `date_examen`, `id_etudiant`, `id_ec`) VALUES
-- DWM: HTML/CSS (EC 1-2)
(17.5, 'Normale', '2025-02-15', 71, 1),
(16.0, 'Normale', '2025-02-15', 71, 2),
(18.5, 'Normale', '2025-02-15', 72, 1),
(17.5, 'Normale', '2025-02-15', 72, 2),
(14.5, 'Normale', '2025-02-15', 73, 1),
(15.0, 'Normale', '2025-02-15', 73, 2),
(16.5, 'Normale', '2025-02-15', 74, 1),
(15.5, 'Normale', '2025-02-15', 74, 2),
(19.0, 'Normale', '2025-02-15', 75, 1),
(18.0, 'Normale', '2025-02-15', 75, 2),

-- JavaScript (EC 3-4)
(18.0, 'Normale', '2025-02-16', 71, 3),
(17.0, 'Normale', '2025-02-16', 71, 4),
(19.5, 'Normale', '2025-02-16', 72, 3),
(18.5, 'Normale', '2025-02-16', 72, 4),
(15.5, 'Normale', '2025-02-16', 73, 3),
(14.5, 'Normale', '2025-02-16', 73, 4),
(17.5, 'Normale', '2025-02-16', 74, 3),
(16.5, 'Normale', '2025-02-16', 74, 4),
(20.0, 'Normale', '2025-02-16', 75, 3),
(19.0, 'Normale', '2025-02-16', 75, 4),

-- Design UX/UI (EC 5-6)
(16.5, 'Normale', '2025-02-17', 71, 5),
(15.5, 'Normale', '2025-02-17', 71, 6),
(17.5, 'Normale', '2025-02-17', 72, 5),
(16.5, 'Normale', '2025-02-17', 72, 6),
(13.5, 'Normale', '2025-02-17', 73, 5),
(12.5, 'Normale', '2025-02-17', 73, 6),
(15.5, 'Normale', '2025-02-17', 74, 5),
(14.5, 'Normale', '2025-02-17', 74, 6),
(18.5, 'Normale', '2025-02-17', 75, 5),
(17.5, 'Normale', '2025-02-17', 75, 6),

-- Laravel Backend (EC 7-8)
(17.0, 'Normale', '2025-02-18', 71, 7),
(16.0, 'Normale', '2025-02-18', 71, 8),
(18.5, 'Normale', '2025-02-18', 72, 7),
(17.5, 'Normale', '2025-02-18', 72, 8),
(14.0, 'Normale', '2025-02-18', 73, 7),
(13.0, 'Normale', '2025-02-18', 73, 8),
(16.0, 'Normale', '2025-02-18', 74, 7),
(15.0, 'Normale', '2025-02-18', 74, 8),
(19.5, 'Normale', '2025-02-18', 75, 7),
(18.5, 'Normale', '2025-02-18', 75, 8),

-- MySQL (EC 9-10)
(16.0, 'Normale', '2025-02-19', 76, 9),
(15.0, 'Normale', '2025-02-19', 76, 10),
(17.5, 'Normale', '2025-02-19', 77, 9),
(16.5, 'Normale', '2025-02-19', 77, 10),
(13.0, 'Normale', '2025-02-19', 78, 9),
(12.0, 'Normale', '2025-02-19', 78, 10),
(15.0, 'Normale', '2025-02-19', 79, 9),
(14.0, 'Normale', '2025-02-19', 79, 10),
(18.0, 'Normale', '2025-02-19', 80, 9),
(17.0, 'Normale', '2025-02-19', 80, 10),

-- ASR: Linux (EC 11-12)
(15.5, 'Normale', '2025-02-20', 89, 11),
(14.5, 'Normale', '2025-02-20', 89, 12),
(17.5, 'Normale', '2025-02-20', 90, 11),
(16.5, 'Normale', '2025-02-20', 90, 12),
(12.5, 'Normale', '2025-02-20', 91, 11),
(11.5, 'Normale', '2025-02-20', 91, 12),
(14.5, 'Normale', '2025-02-20', 92, 11),
(13.5, 'Normale', '2025-02-20', 92, 12),
(18.5, 'Normale', '2025-02-20', 93, 11),
(17.5, 'Normale', '2025-02-20', 93, 12),

-- Active Directory (EC 13-14)
(16.0, 'Normale', '2025-02-21', 94, 13),
(15.0, 'Normale', '2025-02-21', 94, 14),
(18.0, 'Normale', '2025-02-21', 95, 13),
(17.0, 'Normale', '2025-02-21', 95, 14),
(13.5, 'Normale', '2025-02-21', 96, 13),
(12.5, 'Normale', '2025-02-21', 96, 14),
(15.5, 'Normale', '2025-02-21', 97, 13),
(14.5, 'Normale', '2025-02-21', 97, 14),
(17.5, 'Normale', '2025-02-21', 98, 13),
(16.5, 'Normale', '2025-02-21', 98, 14),

-- BDBD: Modélisation (EC 19-20)
(16.5, 'Normale', '2025-02-22', 105, 19),
(15.5, 'Normale', '2025-02-22', 105, 20),
(18.5, 'Normale', '2025-02-22', 106, 19),
(17.5, 'Normale', '2025-02-22', 106, 20),
(14.0, 'Normale', '2025-02-22', 107, 19),
(13.0, 'Normale', '2025-02-22', 107, 20),
(16.0, 'Normale', '2025-02-22', 108, 19),
(15.0, 'Normale', '2025-02-22', 108, 20),
(19.0, 'Normale', '2025-02-22', 109, 19),
(18.0, 'Normale', '2025-02-22', 109, 20),

-- SQL Avancé (EC 21-22)
(17.5, 'Normale', '2025-02-23', 105, 21),
(16.5, 'Normale', '2025-02-23', 105, 22),
(19.0, 'Normale', '2025-02-23', 106, 21),
(18.0, 'Normale', '2025-02-23', 106, 22),
(15.0, 'Normale', '2025-02-23', 107, 21),
(14.0, 'Normale', '2025-02-23', 107, 22),
(17.0, 'Normale', '2025-02-23', 108, 21),
(16.0, 'Normale', '2025-02-23', 108, 22),
(20.0, 'Normale', '2025-02-23', 109, 21),
(19.0, 'Normale', '2025-02-23', 109, 22),

-- NoSQL (EC 23-24)
(16.0, 'Normale', '2025-02-24', 110, 23),
(15.0, 'Normale', '2025-02-24', 110, 24),
(18.0, 'Normale', '2025-02-24', 111, 23),
(17.0, 'Normale', '2025-02-24', 111, 24),
(13.5, 'Normale', '2025-02-24', 112, 23),
(12.5, 'Normale', '2025-02-24', 112, 24),
(15.5, 'Normale', '2025-02-24', 113, 23),
(14.5, 'Normale', '2025-02-24', 113, 24),
(17.5, 'Normale', '2025-02-24', 114, 23),
(16.5, 'Normale', '2025-02-24', 114, 24),
(14.0, 'Rattrapage', '2025-03-15', 107, 19),
(13.5, 'Rattrapage', '2025-03-15', 107, 20),
(15.5, 'Rattrapage', '2025-03-16', 112, 23),
(15.0, 'Rattrapage', '2025-03-16', 112, 24);

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
