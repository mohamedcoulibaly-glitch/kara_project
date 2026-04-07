SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `ec` (`code_ec`, `nom_ec`, `coefficient`, `volume_horaire`, `id_ue`) VALUES
('DWEB-M1-001-CM', 'CM: Modern JavaScript ES2022', 1.5, 22, 69),
('DWEB-M1-001-TP', 'TP: Project Web Stack Complet', 1, 23, 69),
('DWEB-M1-002-CM', 'CM: React 18 & Advanced Hooks', 1.5, 22, 70),
('DWEB-M1-002-TP', 'TP: Vue.js 3 Composition API', 1, 23, 70),
('DWEB-M1-003-CM', 'CM: Architecture Microservices', 1.5, 22, 71),
('DWEB-M1-003-TP', 'TP: Kubernetes Orchestration', 1, 23, 71),
('DWEB-M1-004-CM', 'CM: Web Security Best Practices', 1.2, 22, 72),
('DWEB-M1-004-TP', 'TP: Penetration Testing Web', 0.8, 23, 72),
('DWEB-M1-005-CM', 'CM: CI/CD & Automation', 1.2, 22, 73),
('DWEB-M1-005-TP', 'TP: Jenkins & GitLab CI', 0.8, 23, 73),
('DWEB-M2-001-CM', 'CM: Service Workers', 1.2, 22, 74),
('DWEB-M2-001-TP', 'TP: PWA Implementation', 0.8, 23, 74),
('BDBD-M1-001-CM', 'CM: Distributed Systems', 1.5, 22, 77),
('BDBD-M1-001-TP', 'TP: Cluster Management', 1, 23, 77),
('BDBD-M1-002-CM', 'CM: HDFS & MapReduce Deep Dive', 1.5, 22, 78),
('BDBD-M1-002-TP', 'TP: Hadoop Cluster Configuration', 1, 23, 78),
('BDBD-M1-003-CM', 'CM: Spark RDD & DataFrame', 1.5, 22, 79),
('BDBD-M1-003-TP', 'TP: Scala Functional Programming', 1, 23, 79),
('BDBD-M1-004-CM', 'CM: ML Workflows', 1.2, 22, 80),
('BDBD-M1-004-TP', 'TP: Feature Engineering', 0.8, 23, 80);

SET FOREIGN_KEY_CHECKS = 1;
COMMIT;
