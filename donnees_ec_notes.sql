-- ========================================
-- INSERTION DES EC ET NOTES CORRECTES
-- Avec les bons IDs après vérification
-- ========================================

SET FOREIGN_KEY_CHECKS = 0;

-- UE IDs: 69-83
-- Étudiant Web Master: 125-139 (ID 14 = 125)
-- Étudiant BD Master: 140-154

-- ========================================
-- 1. INSÉRER EC INFORMATIQUE AVEC BONS IDs
-- ========================================

INSERT IGNORE INTO `ec` (`code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
-- DWEB-M1-001 (Full Stack) - UE 69
('DWEB-M1-001-CM', 'CM: Modern JavaScript ES2022', 1.5, 22, 69),
('DWEB-M1-001-TP', 'TP: Project Web Stack Complet', 1, 23, 69),

-- DWEB-M1-002 (Frontend) - UE 70
('DWEB-M1-002-CM', 'CM: React 18 & Advanced Hooks', 1.5, 22, 70),
('DWEB-M1-002-TP', 'TP: Vue.js 3 Composition API', 1, 23, 70),

-- DWEB-M1-003 (Microservices) - UE 71
('DWEB-M1-003-CM', 'CM: Architecture Microservices', 1.5, 22, 71),
('DWEB-M1-003-TP', 'TP: Kubernetes Orchestration', 1, 23, 71),

-- DWEB-M1-004 (Sécurité) - UE 72
('DWEB-M1-004-CM', 'CM: Web Security Best Practices', 1.2, 22, 72),
('DWEB-M1-004-TP', 'TP: Penetration Testing Web', 0.8, 23, 72),

-- DWEB-M1-005 (DevOps) - UE 73
('DWEB-M1-005-CM', 'CM: CI/CD & Automation', 1.2, 22, 73),
('DWEB-M1-005-TP', 'TP: Jenkins & GitLab CI', 0.8, 23, 73),

-- DWEB-M2-001 (PWA) - UE 74
('DWEB-M2-001-CM', 'CM: Service Workers', 1.2, 22, 74),
('DWEB-M2-001-TP', 'TP: PWA Implementation', 0.8, 23, 74),

-- BDBD-M1-001 (Architecture Big Data) - UE 77
('BDBD-M1-001-CM', 'CM: Distributed Systems', 1.5, 22, 77),
('BDBD-M1-001-TP', 'TP: Cluster Management', 1, 23, 77),

-- BDBD-M1-002 (Hadoop) - UE 78
('BDBD-M1-002-CM', 'CM: HDFS & MapReduce Deep Dive', 1.5, 22, 78),
('BDBD-M1-002-TP', 'TP: Hadoop Cluster Configuration', 1, 23, 78),

-- BDBD-M1-003 (Spark) - UE 79
('BDBD-M1-003-CM', 'CM: Spark RDD & DataFrame', 1.5, 22, 79),
('BDBD-M1-003-TP', 'TP: Scala Functional Programming', 1, 23, 79),

-- BDBD-M1-004 (ML Pipeline) - UE 80
('BDBD-M1-004-CM', 'CM: ML Workflows', 1.2, 22, 80),
('BDBD-M1-004-TP', 'TP: Feature Engineering', 0.8, 23, 80);

-- Get the EC IDs for reference (first ones should start around 81)
-- We'll need these IDs for the notes

-- ========================================
-- 2. INSÉRER NOTES AVEC BONS IDs ÉTUDIANTS
-- ========================================

INSERT IGNORE INTO `note` (`valeur_note`, `session`, `date_examen`, `id_etudiant`, `id_ec`) VALUES
-- Web Master Students (125-139): Full Stack (EC 81-82)
(18.5, 'Normale', '2025-02-15', 125, 81),
(17.5, 'Normale', '2025-02-15', 125, 82),
(19.0, 'Normale', '2025-02-15', 126, 81),
(18.0, 'Normale', '2025-02-15', 126, 82),
(16.0, 'Normale', '2025-02-15', 127, 81),
(15.0, 'Normale', '2025-02-15', 127, 82),
(17.5, 'Normale', '2025-02-15', 128, 81),
(16.5, 'Normale', '2025-02-15', 128, 82),
(19.5, 'Normale', '2025-02-15', 129, 81),
(18.5, 'Normale', '2025-02-15', 129, 82),

-- Frontend Advanced (EC 83-84)
(19.0, 'Normale', '2025-02-16', 125, 83),
(18.0, 'Normale', '2025-02-16', 125, 84),
(19.5, 'Normale', '2025-02-16', 126, 83),
(18.5, 'Normale', '2025-02-16', 126, 84),
(17.0, 'Normale', '2025-02-16', 127, 83),
(16.0, 'Normale', '2025-02-16', 127, 84),
(18.5, 'Normale', '2025-02-16', 128, 83),
(17.5, 'Normale', '2025-02-16', 128, 84),
(20.0, 'Normale', '2025-02-16', 129, 83),
(19.0, 'Normale', '2025-02-16', 129, 84),

-- Microservices (EC 85-86)
(17.5, 'Normale', '2025-02-17', 130, 85),
(16.5, 'Normale', '2025-02-17', 130, 86),
(18.5, 'Normale', '2025-02-17', 131, 85),
(17.5, 'Normale', '2025-02-17', 131, 86),
(15.0, 'Normale', '2025-02-17', 132, 85),
(14.0, 'Normale', '2025-02-17', 132, 86),
(16.5, 'Normale', '2025-02-17', 133, 85),
(15.5, 'Normale', '2025-02-17', 133, 86),
(19.0, 'Normale', '2025-02-17', 134, 85),
(18.0, 'Normale', '2025-02-17', 134, 86),

-- Web Security (EC 87-88)
(16.5, 'Normale', '2025-02-18', 135, 87),
(15.5, 'Normale', '2025-02-18', 135, 88),
(17.5, 'Normale', '2025-02-18', 136, 87),
(16.5, 'Normale', '2025-02-18', 136, 88),
(15.0, 'Normale', '2025-02-18', 137, 87),
(14.0, 'Normale', '2025-02-18', 137, 88),
(16.0, 'Normale', '2025-02-18', 138, 87),
(15.0, 'Normale', '2025-02-18', 138, 88),
(18.0, 'Normale', '2025-02-18', 139, 87),
(17.0, 'Normale', '2025-02-18', 139, 88),

-- Big Data Master (140-154): Architecture (EC 93-94)
(18.0, 'Normale', '2025-02-20', 140, 93),
(17.0, 'Normale', '2025-02-20', 140, 94),
(19.0, 'Normale', '2025-02-20', 141, 93),
(18.0, 'Normale', '2025-02-20', 141, 94),
(16.5, 'Normale', '2025-02-20', 142, 93),
(15.5, 'Normale', '2025-02-20', 142, 94),
(17.5, 'Normale', '2025-02-20', 143, 93),
(16.5, 'Normale', '2025-02-20', 143, 94),
(19.5, 'Normale', '2025-02-20', 144, 93),
(18.5, 'Normale', '2025-02-20', 144, 94),

-- Hadoop Ecosystem (EC 95-96)
(17.5, 'Normale', '2025-02-21', 145, 95),
(16.5, 'Normale', '2025-02-21', 145, 96),
(18.5, 'Normale', '2025-02-21', 146, 95),
(17.5, 'Normale', '2025-02-21', 146, 96),
(15.5, 'Normale', '2025-02-21', 147, 95),
(14.5, 'Normale', '2025-02-21', 147, 96),
(16.5, 'Normale', '2025-02-21', 148, 95),
(15.5, 'Normale', '2025-02-21', 148, 96),
(18.5, 'Normale', '2025-02-21', 149, 95),
(17.5, 'Normale', '2025-02-21', 149, 96),

-- Spark & Scala (EC 97-98)
(19.0, 'Normale', '2025-02-22', 140, 97),
(18.0, 'Normale', '2025-02-22', 140, 98),
(19.5, 'Normale', '2025-02-22', 141, 97),
(18.5, 'Normale', '2025-02-22', 141, 98),
(17.0, 'Normale', '2025-02-22', 142, 97),
(16.0, 'Normale', '2025-02-22', 142, 98),
(18.0, 'Normale', '2025-02-22', 143, 97),
(17.0, 'Normale', '2025-02-22', 143, 98),
(20.0, 'Normale', '2025-02-22', 144, 97),
(19.0, 'Normale', '2025-02-22', 144, 98),

-- ML Pipeline (EC 99-100)
(17.0, 'Normale', '2025-02-23', 150, 99),
(16.0, 'Normale', '2025-02-23', 150, 100),
(18.0, 'Normale', '2025-02-23', 151, 99),
(17.0, 'Normale', '2025-02-23', 151, 100),
(15.5, 'Normale', '2025-02-23', 152, 99),
(14.5, 'Normale', '2025-02-23', 152, 100),
(16.5, 'Normale', '2025-02-23', 153, 99),
(15.5, 'Normale', '2025-02-23', 153, 100),
(18.5, 'Normale', '2025-02-23', 154, 99),
(17.5, 'Normale', '2025-02-23', 154, 100),

-- Rattrapage pour étudiants en difficultés
(15.5, 'Rattrapage', '2025-03-10', 127, 81),
(14.5, 'Rattrapage', '2025-03-10', 127, 82),
(16.0, 'Rattrapage', '2025-03-11', 147, 95),
(15.0, 'Rattrapage', '2025-03-11', 147, 96);

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
