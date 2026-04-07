-- ========================================
-- DONNÉES INFORMATIQUE SPÉCIALISÉE
-- Insertion directe des depts, UE, EC, Étudiants et Notes
-- ========================================

SET FOREIGN_KEY_CHECKS = 0;

-- ========================================
-- 1. AJOUTER DÉPARTEMENT INFORMATIQUE
-- ========================================

INSERT IGNORE INTO `departement` (`id_dept`, `nom_dept`, `code_dept`, `chef_dept`) VALUES
(11, 'Informatique Avancée', 'INFO_ADV_2025', 'Pr. Alassane Sarr');

-- ========================================
-- 2. CRÉER FILIÈRE INFORMATIQUE MASTER
-- ========================================

INSERT IGNORE INTO `filiere` (`nom_filiere`, `code_filiere`, `responsable`, `id_dept`, `niveau`, `nb_semestres`) VALUES
('Développement Web Avancé', 'DEV_WEB_ADV_2025', 'Dr. Moussa Diallo', 11, 'Master', 4),
('Bases de Données & Big Data', 'BD_BIG_DATA_2025', 'Dr. Mariama Fall', 11, 'Master', 4);

-- ========================================
-- 3. CRÉER UE INFORMATIQUE AVANCÉE
-- ========================================

INSERT INTO `ue` (`code_ue`, `libelle_ue`, `credits_ects`, `coefficient`, `volume_horaire`, `id_dept`) VALUES
-- Web Avancé
('DWEB-M1-001', 'Full Stack JavaScript Moderne', 6, 2.5, 45, 11),
('DWEB-M1-002', 'Frameworks Frontend Avancés', 6, 2.5, 45, 11),
('DWEB-M1-003', 'Microservices & Architecture Cloud', 6, 2.5, 45, 11),
('DWEB-M1-004', 'Sécurité Applicative Web', 6, 2, 45, 11),
('DWEB-M1-005', 'DevOps & Déploiement', 6, 2, 45, 11),

('DWEB-M2-001', 'Progressive Web Apps (PWA)', 6, 2, 45, 11),
('DWEB-M2-002', 'Optimisation Performance Web', 6, 2, 45, 11),
('DWEB-M2-003', 'Technologies Émergentes Web', 6, 1.5, 45, 11),

-- Big Data & Bases de Données
('BDBD-M1-001', 'Architecture Big Data Avancée', 6, 2.5, 45, 11),
('BDBD-M1-002', 'Hadoop Ecosystem Complet', 6, 2.5, 45, 11),
('BDBD-M1-003', 'Spark & Scala Avancé', 6, 2.5, 45, 11),
('BDBD-M1-004', 'Machine Learning Pipeline', 6, 2, 45, 11),

('BDBD-M2-001', 'Real-time Streaming (Kafka)', 6, 2, 45, 11),
('BDBD-M2-002', 'Data Lakes & Data Governance', 6, 2, 45, 11),
('BDBD-M2-003', 'Advanced Analytics', 6, 1.5, 45, 11);

-- ========================================
-- 4. CRÉER EC INFORMATIQUE
-- ========================================

INSERT INTO `ec` (`code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
-- DWEB-M1-001 (Full Stack)
('DWEB-M1-001-CM', 'CM: Modern JavaScript ES2022', 1.5, 22, 34),
('DWEB-M1-001-TP', 'TP: Project Web Stack Complet', 1, 23, 34),

-- DWEB-M1-002 (Frontend)
('DWEB-M1-002-CM', 'CM: React 18 & Advanced Hooks', 1.5, 22, 35),
('DWEB-M1-002-TP', 'TP: Vue.js 3 Composition API', 1, 23, 35),

-- DWEB-M1-003 (Microservices)
('DWEB-M1-003-CM', 'CM: Architecture Microservices', 1.5, 22, 36),
('DWEB-M1-003-TP', 'TP: Kubernetes Orchestration', 1, 23, 36),

-- DWEB-M1-004 (Sécurité)
('DWEB-M1-004-CM', 'CM: Web Security Best Practices', 1.2, 22, 37),
('DWEB-M1-004-TP', 'TP: Penetration Testing Web', 0.8, 23, 37),

-- DWEB-M1-005 (DevOps)
('DWEB-M1-005-CM', 'CM: CI/CD & Automation', 1.2, 22, 38),
('DWEB-M1-005-TP', 'TP: Jenkins & GitLab CI', 0.8, 23, 38),

-- DWEB-M2-001 (PWA)
('DWEB-M2-001-CM', 'CM: Service Workers', 1.2, 22, 39),
('DWEB-M2-001-TP', 'TP: PWA Implementation', 0.8, 23, 39),

-- BDBD-M1-001 (Architecture Big Data)
('BDBD-M1-001-CM', 'CM: Distributed Systems', 1.5, 22, 42),
('BDBD-M1-001-TP', 'TP: Cluster Management', 1, 23, 42),

-- BDBD-M1-002 (Hadoop)
('BDBD-M1-002-CM', 'CM: HDFS & MapReduce Deep Dive', 1.5, 22, 43),
('BDBD-M1-002-TP', 'TP: Hadoop Cluster Configuration', 1, 23, 43),

-- BDBD-M1-003 (Spark)
('BDBD-M1-003-CM', 'CM: Spark RDD & DataFrame', 1.5, 22, 44),
('BDBD-M1-003-TP', 'TP: Scala Functional Programming', 1, 23, 44),

-- BDBD-M1-004 (ML Pipeline)
('BDBD-M1-004-CM', 'CM: ML Workflows', 1.2, 22, 45),
('BDBD-M1-004-TP', 'TP: Feature Engineering', 0.8, 23, 45);

-- ========================================
-- 5. INSÉRER NOUVEAUX ÉTUDIANTS INFORMATIQUE
-- ========================================

INSERT INTO `etudiant` (`matricule`, `nom`, `prenom`, `email`, `telephone`, `date_naissance`, `lieu_naissance`, `sexe`, `nationalite`, `id_filiere`, `semestre_actuel`, `statut`) VALUES
-- Développement Web Avancé (15 étudiants Master)
('INFO-WEB-MASTER-001', 'Diallo', 'Mamadou', 'mamadou.online@universite.sn', '+221 77 200 0001', '2000-01-15', 'Dakar', 'M', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-002', 'Sall', 'Fatima', 'fatima.web@universite.sn', '+221 76 200 0002', '2000-03-22', 'Thiès', 'F', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-003', 'Touré', 'Mohamed', 'mohamed.dev@universite.sn', '+221 77 200 0003', '2000-05-10', 'Kaolack', 'M', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-004', 'Ken', 'Aïssatou', 'aissatou.web@universite.sn', '+221 70 200 0004', '2001-02-14', 'Kolda', 'F', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-005', 'Cissé', 'Moussa', 'moussa.master@universite.sn', '+221 77 200 0005', '2000-07-25', 'Tambacounda', 'M', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-006', 'Gueye', 'Hawa', 'hawa.dev@universite.sn', '+221 76 200 0006', '2000-09-12', 'Saint-Louis', 'F', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-007', 'Ndiaye', 'Ousmane', 'ousmane.dev@universite.sn', '+221 70 200 0007', '2000-11-05', 'Matam', 'M', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-008', 'Traoré', 'Khady', 'khady.dev@universite.sn', '+221 77 200 0008', '2000-06-18', 'Louga', 'F', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-009', 'Sarr', 'Lamine', 'lamine.dev@universite.sn', '+221 76 200 0009', '2000-04-30', 'Ziguinchor', 'M', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-010', 'Bah', 'Marième', 'marieme.dev@universite.sn', '+221 77 200 0010', '2000-08-22', 'Dakar', 'F', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-011', 'Fall', 'Cheikh', 'cheikh.dev@universite.sn', '+221 70 200 0011', '2000-10-17', 'Thiès', 'M', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-012', 'Diouf', 'Aïda', 'aida.dev@universite.sn', '+221 76 200 0012', '2000-12-03', 'Kaolack', 'F', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-013', 'Kane', 'Abdu', 'abdu.dev@universite.sn', '+221 77 200 0013', '2000-02-27', 'Kolda', 'M', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-014', 'Thiaw', 'Néné', 'nene.dev@universite.sn', '+221 70 200 0014', '2001-01-11', 'Louga', 'F', 'Sénégalaise', 11, 1, 'Actif'),
('INFO-WEB-MASTER-015', 'Seck', 'Babacar', 'babacar.dev@universite.sn', '+221 77 200 0015', '2000-09-08', 'Saint-Louis', 'M', 'Sénégalaise', 11, 1, 'Actif'),

-- Big Data & Bases de Données (15 étudiants Master)
('INFO-BD-MASTER-001', 'Ba', 'Yacine', 'yacine.data@universite.sn', '+221 76 200 0016', '2000-05-20', 'Tambacounda', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-002', 'Ndar', 'Sokhna', 'sokhna.data@universite.sn', '+221 77 200 0017', '2000-07-14', 'Matam', 'F', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-003', 'Dia', 'Pape', 'pape.data@universite.sn', '+221 70 200 0018', '2000-03-09', 'Ziguinchor', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-004', 'Ly', 'Kadiatou', 'kadiatou.data@universite.sn', '+221 76 200 0019', '2001-04-25', 'Dakar', 'F', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-005', 'Niang', 'Demba', 'demba.data@universite.sn', '+221 77 200 0020', '2000-06-30', 'Thiès', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-006', 'Diop', 'Modou', 'modou.data@universite.sn', '+221 70 200 0021', '2000-02-16', 'Kaolack', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-007', 'Ndour', 'Amine', 'amine.data@universite.sn', '+221 76 200 0022', '2000-08-11', 'Kolda', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-008', 'Mbaye', 'Sekou', 'sekou.data@universite.sn', '+221 77 200 0023', '2000-10-22', 'Louga', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-009', 'Gueye', 'Awa', 'awa.data@universite.sn', '+221 70 200 0024', '2000-04-19', 'Saint-Louis', 'F', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-010', 'Niang', 'Fatou', 'fatou.data@universite.sn', '+221 76 200 0025', '2000-06-05', 'Tambacounda', 'F', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-011', 'Cissé', 'Oumou', 'oumou.data@universite.sn', '+221 77 200 0026', '2000-12-31', 'Matam', 'F', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-012', 'Sall', 'Ibrahima', 'ibrahima.data@universite.sn', '+221 70 200 0027', '2000-01-13', 'Ziguinchor', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-013', 'Touré', 'Yasmine', 'yasmine.data@universite.sn', '+221 76 200 0028', '2000-09-26', 'Dakar', 'F', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-014', 'Ken', 'Idrissa', 'idrissa.data@universite.sn', '+221 77 200 0029', '2000-05-01', 'Thiès', 'M', 'Sénégalaise', 12, 1, 'Actif'),
('INFO-BD-MASTER-015', 'Cissé', 'Waly', 'waly.data@universite.sn', '+221 70 200 0030', '2000-11-14', 'Kaolack', 'M', 'Sénégalaise', 12, 1, 'Actif');

-- ========================================
-- 6. INSÉRER NOTES ÉTUDIANTS INFORMATIQUE (80+ notes)
-- ========================================

INSERT INTO `note` (`valeur_note`, `session`, `date_examen`, `id_etudiant`, `id_ec`) VALUES
-- Web Dev Master: Full Stack (EC 61-62)
(18.5, 'Normale', '2025-02-15', 121, 61),
(17.5, 'Normale', '2025-02-15', 121, 62),
(19.0, 'Normale', '2025-02-15', 122, 61),
(18.0, 'Normale', '2025-02-15', 122, 62),
(16.0, 'Normale', '2025-02-15', 123, 61),
(15.0, 'Normale', '2025-02-15', 123, 62),
(17.5, 'Normale', '2025-02-15', 124, 61),
(16.5, 'Normale', '2025-02-15', 124, 62),
(19.5, 'Normale', '2025-02-15', 125, 61),
(18.5, 'Normale', '2025-02-15', 125, 62),

-- Frontend Advanced (EC 63-64)
(19.0, 'Normale', '2025-02-16', 121, 63),
(18.0, 'Normale', '2025-02-16', 121, 64),
(19.5, 'Normale', '2025-02-16', 122, 63),
(18.5, 'Normale', '2025-02-16', 122, 64),
(17.0, 'Normale', '2025-02-16', 123, 63),
(16.0, 'Normale', '2025-02-16', 123, 64),
(18.5, 'Normale', '2025-02-16', 124, 63),
(17.5, 'Normale', '2025-02-16', 124, 64),
(20.0, 'Normale', '2025-02-16', 125, 63),
(19.0, 'Normale', '2025-02-16', 125, 64),

-- Microservices (EC 65-66)
(17.5, 'Normale', '2025-02-17', 126, 65),
(16.5, 'Normale', '2025-02-17', 126, 66),
(18.5, 'Normale', '2025-02-17', 127, 65),
(17.5, 'Normale', '2025-02-17', 127, 66),
(15.0, 'Normale', '2025-02-17', 128, 65),
(14.0, 'Normale', '2025-02-17', 128, 66),
(16.5, 'Normale', '2025-02-17', 129, 65),
(15.5, 'Normale', '2025-02-17', 129, 66),
(19.0, 'Normale', '2025-02-17', 130, 65),
(18.0, 'Normale', '2025-02-17', 130, 66),

-- Web Security (EC 67-68)
(16.5, 'Normale', '2025-02-18', 131, 67),
(15.5, 'Normale', '2025-02-18', 131, 68),
(17.5, 'Normale', '2025-02-18', 132, 67),
(16.5, 'Normale', '2025-02-18', 132, 68),
(15.0, 'Normale', '2025-02-18', 133, 67),
(14.0, 'Normale', '2025-02-18', 133, 68),
(16.0, 'Normale', '2025-02-18', 134, 67),
(15.0, 'Normale', '2025-02-18', 134, 68),
(18.0, 'Normale', '2025-02-18', 135, 67),
(17.0, 'Normale', '2025-02-18', 135, 68),

-- Big Data Master: Architecture (EC 73-74)
(18.0, 'Normale', '2025-02-20', 136, 73),
(17.0, 'Normale', '2025-02-20', 136, 74),
(19.0, 'Normale', '2025-02-20', 137, 73),
(18.0, 'Normale', '2025-02-20', 137, 74),
(16.5, 'Normale', '2025-02-20', 138, 73),
(15.5, 'Normale', '2025-02-20', 138, 74),
(17.5, 'Normale', '2025-02-20', 139, 73),
(16.5, 'Normale', '2025-02-20', 139, 74),
(19.5, 'Normale', '2025-02-20', 140, 73),
(18.5, 'Normale', '2025-02-20', 140, 74),

-- Hadoop Ecosystem (EC 75-76)
(17.5, 'Normale', '2025-02-21', 141, 75),
(16.5, 'Normale', '2025-02-21', 141, 76),
(18.5, 'Normale', '2025-02-21', 142, 75),
(17.5, 'Normale', '2025-02-21', 142, 76),
(15.5, 'Normale', '2025-02-21', 143, 75),
(14.5, 'Normale', '2025-02-21', 143, 76),
(16.5, 'Normale', '2025-02-21', 144, 75),
(15.5, 'Normale', '2025-02-21', 144, 76),
(18.5, 'Normale', '2025-02-21', 145, 75),
(17.5, 'Normale', '2025-02-21', 145, 76),

-- Spark & Scala (EC 77-78)
(19.0, 'Normale', '2025-02-22', 136, 77),
(18.0, 'Normale', '2025-02-22', 136, 78),
(19.5, 'Normale', '2025-02-22', 137, 77),
(18.5, 'Normale', '2025-02-22', 137, 78),
(17.0, 'Normale', '2025-02-22', 138, 77),
(16.0, 'Normale', '2025-02-22', 138, 78),
(18.0, 'Normale', '2025-02-22', 139, 77),
(17.0, 'Normale', '2025-02-22', 139, 78),
(20.0, 'Normale', '2025-02-22', 140, 77),
(19.0, 'Normale', '2025-02-22', 140, 78),

-- ML Pipeline (EC 79-80)
(17.0, 'Normale', '2025-02-23', 146, 79),
(16.0, 'Normale', '2025-02-23', 146, 80),
(18.0, 'Normale', '2025-02-23', 147, 79),
(17.0, 'Normale', '2025-02-23', 147, 80),
(15.5, 'Normale', '2025-02-23', 148, 79),
(14.5, 'Normale', '2025-02-23', 148, 80),
(16.5, 'Normale', '2025-02-23', 149, 79),
(15.5, 'Normale', '2025-02-23', 149, 80),
(18.5, 'Normale', '2025-02-23', 150, 79),
(17.5, 'Normale', '2025-02-23', 150, 80),

-- Rattrapage pour étudiants en difficultés
(15.5, 'Rattrapage', '2025-03-10', 128, 65),
(14.5, 'Rattrapage', '2025-03-10', 128, 66),
(16.0, 'Rattrapage', '2025-03-11', 143, 75),
(15.0, 'Rattrapage', '2025-03-11', 143, 76);

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
