-- ========================================
-- DONNÉES INFORMATIQUE FINALES - APPROCHE CORRIGÉE
-- ========================================

SET FOREIGN_KEY_CHECKS = 0;

-- Nettoyer les notes bidon des vieilles EC qui n'ont pas de bon contexte
DELETE FROM note WHERE id_etudiant >= 71 AND id_etudiant <= 154 AND id_ec > 100;

-- Nettoyer les EC informatique mal placées
DELETE FROM ec WHERE code_ec LIKE 'DWEB%' OR code_ec LIKE 'BDBD-M%';

-- ========================================
-- 1. CRÉER UE INFORMATIQUE CORRECTES
-- ========================================

-- UE pour département 11 (Informatique Avancée)
INSERT IGNORE INTO `ue` (`id_ue`, `code_ue`, `libelle_ue`, `credits_ects`, `coefficient`, `volume_horaire`, `id_dept`) VALUES
(69, 'DWEB-M1-001', 'Full Stack JavaScript Moderne', 6, 2.5, 45, 11),
(70, 'DWEB-M1-002', 'Frameworks Frontend Avancés', 6, 2.5, 45, 11),
(71, 'DWEB-M1-003', 'Microservices & Architecture Cloud', 6, 2.5, 45, 11),
(72, 'DWEB-M1-004', 'Sécurité Applicative Web', 6, 2, 45, 11),
(73, 'DWEB-M1-005', 'DevOps & Déploiement', 6, 2, 45, 11),
(74, 'DWEB-M2-001', 'Progressive Web Apps (PWA)', 6, 2, 45, 11),
(75, 'DWEB-M2-002', 'Optimisation Performance Web', 6, 2, 45, 11),
(76, 'DWEB-M2-003', 'Technologies Émergentes Web', 6, 1.5, 45, 11),
(77, 'BDBD-M1-001', 'Architecture Big Data Avancée', 6, 2.5, 45, 11),
(78, 'BDBD-M1-002', 'Hadoop Ecosystem Complet', 6, 2.5, 45, 11),
(79, 'BDBD-M1-003', 'Spark & Scala Avancé', 6, 2.5, 45, 11),
(80, 'BDBD-M1-004', 'Machine Learning Pipeline', 6, 2, 45, 11),
(81, 'BDBD-M2-001', 'Real-time Streaming (Kafka)', 6, 2, 45, 11),
(82, 'BDBD-M2-002', 'Data Lakes & Data Governance', 6, 2, 45, 11),
(83, 'BDBD-M2-003', 'Advanced Analytics', 6, 1.5, 45, 11);

-- ========================================
-- 1b. CRÉER PROGRAMMES (relation filière-UE-semestre)
-- ========================================

-- Programme pour Filière 16 (Dev Web) - Semestre 1
INSERT IGNORE INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
(16, 69, 1, '2024-2025'),
(16, 70, 1, '2024-2025'),
(16, 71, 1, '2024-2025'),
(16, 72, 1, '2024-2025'),
(16, 73, 1, '2024-2025');

-- Programme pour Filière 16 (Dev Web) - Semestre 2
INSERT IGNORE INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
(16, 74, 2, '2024-2025'),
(16, 75, 2, '2024-2025'),
(16, 76, 2, '2024-2025');

-- Programme pour Filière 17 (Big Data) - Semestre 1
INSERT IGNORE INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
(17, 77, 1, '2024-2025'),
(17, 78, 1, '2024-2025'),
(17, 79, 1, '2024-2025'),
(17, 80, 1, '2024-2025');

-- Programme pour Filière 17 (Big Data) - Semestre 2
INSERT IGNORE INTO `programme` (`id_filiere`, `id_ue`, `semestre`, `annee_academique`) VALUES
(17, 81, 2, '2024-2025'),
(17, 82, 2, '2024-2025'),
(17, 83, 2, '2024-2025');

-- ========================================
-- 2. INSÉRER EC INFORMATIQUE AVEC BONNES RELATIONS
-- ========================================

INSERT INTO `ec` (`code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
-- Full Stack - UE 69
('DWEB-M1-001-CM', 'CM: Modern JavaScript ES2022', 1.5, 22, 69),
('DWEB-M1-001-TP', 'TP: Project Web Stack Complet', 1, 23, 69),

-- Frontend - UE 70
('DWEB-M1-002-CM', 'CM: React 18 & Advanced Hooks', 1.5, 22, 70),
('DWEB-M1-002-TP', 'TP: Vue.js 3 Composition API', 1, 23, 70),

-- Microservices - UE 71
('DWEB-M1-003-CM', 'CM: Architecture Microservices', 1.5, 22, 71),
('DWEB-M1-003-TP', 'TP: Kubernetes Orchestration', 1, 23, 71),

-- Sécurité - UE 72
('DWEB-M1-004-CM', 'CM: Web Security Best Practices', 1.2, 22, 72),
('DWEB-M1-004-TP', 'TP: Penetration Testing Web', 0.8, 23, 72),

-- DevOps - UE 73
('DWEB-M1-005-CM', 'CM: CI/CD & Automation', 1.2, 22, 73),
('DWEB-M1-005-TP', 'TP: Jenkins & GitLab CI', 0.8, 23, 73),

-- PWA - UE 74
('DWEB-M2-001-CM', 'CM: Service Workers', 1.2, 22, 74),
('DWEB-M2-001-TP', 'TP: PWA Implementation', 0.8, 23, 74),

-- Architecture BigData - UE 77
('BDBD-M1-001-CM', 'CM: Distributed Systems', 1.5, 22, 77),
('BDBD-M1-001-TP', 'TP: Cluster Management', 1, 23, 77),

-- Hadoop - UE 78
('BDBD-M1-002-CM', 'CM: HDFS & MapReduce Deep Dive', 1.5, 22, 78),
('BDBD-M1-002-TP', 'TP: Hadoop Cluster Configuration', 1, 23, 78),

-- Spark - UE 79
('BDBD-M1-003-CM', 'CM: Spark RDD & DataFrame', 1.5, 22, 79),
('BDBD-M1-003-TP', 'TP: Scala Functional Programming', 1, 23, 79),

-- ML Pipeline - UE 80
('BDBD-M1-004-CM', 'CM: ML Workflows', 1.2, 22, 80),
('BDBD-M1-004-TP', 'TP: Feature Engineering', 0.8, 23, 80);

-- ========================================
-- 3. INSÉRER NOTES ÉTUDIANTS AVEC BONS IDs
-- ========================================

-- After SELECT MAX(id_ec), we know EC start at 125
-- Will need to query the real IDs after insertion

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
