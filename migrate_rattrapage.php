<?php
require_once __DIR__ . '/config/config.php';
$db = getDB();

$queries = [
    "CREATE TABLE IF NOT EXISTS `session_rattrapage` (
      `id_session` int(11) NOT NULL AUTO_INCREMENT,
      `code_session` varchar(50) NOT NULL,
      `date_debut` date,
      `date_fin` date,
      `id_filiere` int(11),
      `statut` varchar(20) DEFAULT 'Programmée',
      `description` text,
      `date_creation` timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id_session`),
      UNIQUE KEY `code_session` (`code_session`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",

    "CREATE TABLE IF NOT EXISTS `inscription_rattrapage` (
      `id_inscription` int(11) NOT NULL AUTO_INCREMENT,
      `id_etudiant` int(11) NOT NULL,
      `id_session` int(11) NOT NULL,
      `id_ec` int(11) NOT NULL,
      `statut` varchar(20) DEFAULT 'Inscrit',
      `date_inscription` timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id_inscription`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;",
    
    "CREATE TABLE IF NOT EXISTS `deliberation` (
      `id_deliberation` int(11) NOT NULL AUTO_INCREMENT,
      `code_deliberation` varchar(50),
      `id_etudiant` int(11) NOT NULL,
      `semestre` int(11) NOT NULL,
      `moyenne_semestre` decimal(5,2),
      `statut` varchar(20),
      `mention` varchar(20),
      `credits_obtenus` int(11),
      `responsable_deliberation` varchar(100),
      `observations` text,
      `date_deliberation` timestamp DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id_deliberation`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;"
];

foreach ($queries as $q) {
    if ($db->query($q)) {
        echo "Table ensured via query: " . substr($q, 0, 50) . "...\n";
    } else {
        echo "Error: " . $db->error . " in query: " . $q . "\n";
    }
}
echo "Migration complete.\n";
