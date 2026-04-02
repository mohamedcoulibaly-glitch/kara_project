<?php
require_once __DIR__ . '/config/config.php';
$db = getDB();

$queries = [
    // Ensure all columns exist in deliberation
    "ALTER TABLE `deliberation` ADD COLUMN IF NOT EXISTS `code_deliberation` varchar(50) AFTER `id_deliberation`;",
    "ALTER TABLE `deliberation` CHANGE COLUMN IF EXISTS `statut_deliberation` `statut` varchar(20);",
    
    // Ensure session_rattrapage has code_session
    "ALTER TABLE `session_rattrapage` ADD COLUMN IF NOT EXISTS `code_session` varchar(50) NOT NULL AFTER `id_session`;",
    
    // If table doesn't exist, they were created in the previous run, but let's be sure
];

foreach ($queries as $q) {
    $db->query($q);
}
echo "Migration update complete.\n";
