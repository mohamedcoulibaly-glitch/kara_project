<?php
/**
 * Peuplement massif pour démonstration (étudiants, notes, délibérations, sessions, audit).
 *
 * Prérequis : base `gestion_notes` créée (ex. import de gestion_notes_complete.sql).
 *
 * Usage (XAMPP Windows) :
 *   C:\newXampp\php\php.exe tools/seed_simulation.php
 *   C:\newXampp\php\php.exe tools/seed_simulation.php --only-extra   (pas de nouveaux étudiants : notes/logs supplémentaires)
 */

declare(strict_types=1);

if (php_sapi_name() !== 'cli') {
    http_response_code(403);
    exit('CLI uniquement.');
}

$onlyExtra = in_array('--only-extra', $argv, true);

require_once __DIR__ . '/../config/config.php';

$db = getDB();

function line(string $msg): void
{
    echo $msg . PHP_EOL;
}

function ensureAuditTable(mysqli $db): void
{
    $db->query("CREATE TABLE IF NOT EXISTS `audit_log` (
      `id_audit` int(11) NOT NULL AUTO_INCREMENT,
      `user_id` int(11) NOT NULL,
      `action` varchar(20) NOT NULL,
      `table_name` varchar(64) DEFAULT NULL,
      `record_id` varchar(64) DEFAULT NULL,
      `old_values` text,
      `new_values` text,
      `ip_address` varchar(45) DEFAULT NULL,
      `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
      PRIMARY KEY (`id_audit`),
      KEY `idx_audit_user` (`user_id`),
      KEY `idx_audit_created` (`created_at`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
}

function rowExists(mysqli $db, string $sql): bool
{
    $r = $db->query($sql);
    if (!$r) {
        return false;
    }
    $row = $r->fetch_row();

    return $row && (int) $row[0] > 0;
}

function getScalarInt(mysqli $db, string $sql): int
{
    $r = $db->query($sql);
    if (!$r) {
        return 0;
    }
    $row = $r->fetch_row();

    return $row ? (int) $row[0] : 0;
}

ensureAuditTable($db);
line('Table audit_log : OK');

$demoPass = password_hash('Demo2026!', PASSWORD_DEFAULT);
$adminPass = password_hash('Admin2026!', PASSWORD_DEFAULT);

$st = $db->prepare('UPDATE utilisateur SET password = ? WHERE email = ?');
if ($st) {
    $em = 'admin@univ.local';
    $st->bind_param('ss', $adminPass, $em);
    $st->execute();
    line('Mot de passe admin@univ.local défini sur : Admin2026!');
}

$users = [
    ['Martin', 'Sophie', 'scolarite.sim@univ.local', 'Scolarite'],
    ['Ndiaye', 'Ibrahim', 'directeur.sim@univ.local', 'Directeur'],
    ['Sow', 'Aminata', 'enseignant.sim@univ.local', 'Enseignant'],
];
$insU = $db->prepare('INSERT IGNORE INTO utilisateur (nom, prenom, email, password, role, statut) VALUES (?,?,?,?,?,\'Actif\')');
foreach ($users as $u) {
    if ($insU) {
        $insU->bind_param('sssss', $u[0], $u[1], $u[2], $demoPass, $u[3]);
        $insU->execute();
    }
}
line('Utilisateurs de démo (mot de passe Demo2026!) : scolarite / directeur / enseignant .sim@univ.local');

/* Programme manquant filière 2 (UE 4 INFO) */
if (!rowExists($db, "SELECT 1 FROM programme WHERE id_filiere = 2 AND id_ue = 4 AND semestre = 1 LIMIT 1")) {
    $db->query("INSERT INTO programme (id_filiere, id_ue, semestre, annee_academique) VALUES (2, 4, 1, '2025-2026')");
    line('Programme ajouté : filière 2, semestre 1, UE INFO.');
}

/* Filière 3 : une UE + EC + programme si absent */
if (!rowExists($db, "SELECT 1 FROM programme WHERE id_filiere = 3 AND semestre = 1 LIMIT 1")) {
    $db->query("INSERT INTO ue (code_ue, libelle_ue, credits_ects, coefficient, volume_horaire, id_dept)
        SELECT 'GE-S1-UE-001', 'Introduction à la comptabilité', 6, 1.5, 45, 3 FROM DUAL
        WHERE NOT EXISTS (SELECT 1 FROM ue WHERE code_ue = 'GE-S1-UE-001')");
    $idUeGe = getScalarInt($db, "SELECT id_ue FROM ue WHERE code_ue = 'GE-S1-UE-001' LIMIT 1");
    if ($idUeGe > 0) {
        $db->query("INSERT INTO ec (code_ec, nom_ec, coefficient, volume_horaire, id_ue)
            SELECT 'GE-S1-EC-01', 'Comptabilité générale', 1, 30, {$idUeGe} FROM DUAL
            WHERE NOT EXISTS (SELECT 1 FROM ec WHERE code_ec = 'GE-S1-EC-01')");
        $db->query("INSERT INTO ec (code_ec, nom_ec, coefficient, volume_horaire, id_ue)
            SELECT 'GE-S1-EC-02', 'Analyse financière', 1, 30, {$idUeGe} FROM DUAL
            WHERE NOT EXISTS (SELECT 1 FROM ec WHERE code_ec = 'GE-S1-EC-02')");
        $db->query("INSERT INTO programme (id_filiere, id_ue, semestre, annee_academique) VALUES (3, {$idUeGe}, 1, '2025-2026')");
        line('Maquette semestre 1 ajoutée pour la filière Gestion (GE).');
    }
}

/* Semestre 2 — Génie Logiciel */
if (!rowExists($db, "SELECT 1 FROM ue WHERE code_ue = 'GL-S2-UE-001' LIMIT 1")) {
    $db->query("INSERT INTO ue (code_ue, libelle_ue, credits_ects, coefficient, volume_horaire, id_dept)
        VALUES ('GL-S2-UE-001', 'Structures de données et algorithmes', 6, 1.5, 45, 1)");
}
$idUeS2 = getScalarInt($db, "SELECT id_ue FROM ue WHERE code_ue = 'GL-S2-UE-001' LIMIT 1");
if ($idUeS2 > 0) {
    if (!rowExists($db, "SELECT 1 FROM ec WHERE code_ec = 'GL-S2-EC-01' LIMIT 1")) {
        $db->query("INSERT INTO ec (code_ec, nom_ec, coefficient, volume_horaire, id_ue) VALUES
            ('GL-S2-EC-01', 'Structures de données — Cours', 1, 24, {$idUeS2}),
            ('GL-S2-EC-02', 'Structures de données — TP', 1, 21, {$idUeS2})");
    }
    if (!rowExists($db, "SELECT 1 FROM programme WHERE id_filiere = 1 AND id_ue = {$idUeS2} AND semestre = 2 LIMIT 1")) {
        $db->query("INSERT INTO programme (id_filiere, id_ue, semestre, annee_academique) VALUES (1, {$idUeS2}, 2, '2025-2026')");
        line('Maquette semestre 2 ajoutée pour Génie Logiciel.');
    }
}

$noms = ['Traoré', 'Diallo', 'Koné', 'Ouattara', 'Keita', 'Sangaré', 'Touré', 'Coulibaly', 'Diabaté', 'Camara', 'Bah', 'Cissé', 'Sylla', 'Kanté', 'Doumbia'];
$prenoms = ['Moussa', 'Awa', 'Ibrahim', 'Fatoumata', 'Oumar', 'Mariam', 'Sekou', 'Aminata', 'Cheick', 'Kadiatou', 'Yacouba', 'Hawa', 'Boubacar', 'Djeneba', 'Modibo'];

$insertedStudents = 0;
if (!$onlyExtra) {
    $insE = $db->prepare('INSERT IGNORE INTO etudiant (matricule, nom, prenom, email, telephone, date_naissance, lieu_naissance, sexe, nationalite, id_filiere, semestre_actuel, statut) VALUES (?,?,?,?,?,?,?,?,?,?,?,\'Actif\')');
    for ($i = 1; $i <= 72; $i++) {
        $mat = sprintf('SIM-2026-%04d', $i);
        $email = sprintf('sim2026.%04d@demo.univ', $i);
        $fid = (($i - 1) % 3) + 1;
        $sem = ($fid === 1 && $i % 3 === 0) ? 2 : 1;
        $nom = $noms[$i % count($noms)];
        $prenom = $prenoms[($i * 3) % count($prenoms)];
        $tel = '+22375' . str_pad((string) (100000 + $i), 6, '0', STR_PAD_LEFT);
        $dn = sprintf('2004-%02d-%02d', ($i % 12) + 1, ($i % 27) + 1);
        $lieu = ['Bamako', 'Kayes', 'Sikasso', 'Ségou', 'Koutiala'][$i % 5];
        $sexe = ($i % 2 === 0) ? 'F' : 'M';
        $nat = 'Malienne';
        if ($insE) {
            $insE->bind_param('sssssssssii', $mat, $nom, $prenom, $email, $tel, $dn, $lieu, $sexe, $nat, $fid, $sem);
            $insE->execute();
            if ($insE->affected_rows > 0) {
                $insertedStudents++;
            }
        }
    }
    line("Étudiants simulation (INSERT IGNORE) : {$insertedStudents} nouvelles lignes (~72 matricules SIM-2026-xxxx).");
} else {
    line('Mode --only-extra : étudiants non recréés.');
}

$res = $db->query("SELECT id_etudiant, id_filiere, semestre_actuel FROM etudiant WHERE matricule LIKE 'SIM-2026-%' ORDER BY id_etudiant");
$simEtus = $res ? $res->fetch_all(MYSQLI_ASSOC) : [];
$notesAdded = 0;
$insN = $db->prepare("INSERT INTO note (valeur_note, session, date_examen, id_etudiant, id_ec) VALUES (?, 'Normale', ?, ?, ?)
    ON DUPLICATE KEY UPDATE valeur_note = VALUES(valeur_note)");
foreach ($simEtus as $etu) {
    $fid = (int) $etu['id_filiere'];
    $sem = (int) $etu['semestre_actuel'];
    $q = "SELECT DISTINCT ec.id_ec FROM programme p
          INNER JOIN ec ON ec.id_ue = p.id_ue
          WHERE p.id_filiere = {$fid} AND p.semestre = {$sem}";
    $ecs = $db->query($q);
    if (!$ecs) {
        continue;
    }
    while ($row = $ecs->fetch_assoc()) {
        $idEc = (int) $row['id_ec'];
        $note = round(6 + (lcg_value() * 12), 2);
        if ($note > 20) {
            $note = 20;
        }
        $d = sprintf('2025-%02d-%02d', random_int(5, 6), random_int(10, 28));
        if ($insN) {
            $idEt = (int) $etu['id_etudiant'];
            $insN->bind_param('dsii', $note, $d, $idEt, $idEc);
            $insN->execute();
            if ($db->affected_rows >= 0) {
                $notesAdded++;
            }
        }
    }
}
line("Notes (insert / maj ON DUPLICATE KEY) : opérations sur ~{$notesAdded} couples (étudiant, EC).");

$insD = $db->prepare('INSERT IGNORE INTO deliberation (code_deliberation, id_etudiant, semestre, moyenne_semestre, statut, mention, credits_obtenus, date_deliberation, responsable_deliberation, observations) VALUES (?,?,?,?,?,?,?,?,?,?)');
$delCount = 0;
foreach ($simEtus as $etu) {
    $idEt = (int) $etu['id_etudiant'];
    $sem = (int) $etu['semestre_actuel'];
    $code = 'DEL-SIM-' . $idEt . '-S' . $sem;
    $avg = round(8 + lcg_value() * 10, 2);
    $statut = $avg >= 10 ? 'Admis' : ($avg >= 8 ? 'Redoublant' : 'Ajourné');
    $mention = $avg >= 16 ? 'Très bien' : ($avg >= 14 ? 'Bien' : ($avg >= 12 ? 'Assez bien' : ($avg >= 10 ? 'Passable' : '—')));
    $cr = (int) ($avg >= 10 ? 36 : 12);
    $dateD = '2025-07-15';
    $resp = 'Jury simulation LMD';
    $obs = 'Généré par tools/seed_simulation.php';
    if ($insD) {
        $insD->bind_param('siidssisss', $code, $idEt, $sem, $avg, $statut, $mention, $cr, $dateD, $resp, $obs);
        $insD->execute();
        if ($insD->affected_rows > 0) {
            $delCount++;
        }
    }
}
line("Délibérations (INSERT IGNORE) : {$delCount} nouvelles lignes.");

if (!rowExists($db, "SELECT 1 FROM session_rattrapage WHERE code_session = 'RATTRAP-2026-SIM' LIMIT 1")) {
    $db->query("INSERT INTO session_rattrapage (code_session, date_debut, date_fin, id_filiere, statut, description)
        VALUES ('RATTRAP-2026-SIM', '2026-02-01', '2026-02-28', 1, 'Programmée', 'Session simulation seed')");
    line('Session de rattrapage RATTRAP-2026-SIM créée.');
}

$uid = getScalarInt($db, 'SELECT id_user FROM utilisateur ORDER BY id_user LIMIT 1');
if ($uid > 0) {
    $actions = ['INSERT', 'UPDATE', 'DELETE', 'SELECT'];
    $tables = ['etudiant', 'note', 'utilisateur', 'deliberation', 'programme'];
    $auditStmt = $db->prepare('INSERT INTO audit_log (user_id, action, table_name, record_id, old_values, new_values, ip_address) VALUES (?,?,?,?,?,?,?)');
    $added = 0;
    for ($k = 0; $k < 80; $k++) {
        $act = $actions[$k % count($actions)];
        $tbl = $tables[$k % count($tables)];
        $rid = (string) (100 + $k);
        $old = $k % 2 === 0 ? '{"sim":true}' : null;
        $new = '{"batch":' . $k . '}';
        $ip = '192.168.1.' . ($k % 200 + 10);
        if ($auditStmt) {
            $auditStmt->bind_param('issssss', $uid, $act, $tbl, $rid, $old, $new, $ip);
            $auditStmt->execute();
            $added++;
        }
    }
    line("Lignes d'audit de démo insérées : {$added}.");
}

line('');
line('Terminé. Connexion test : admin@univ.local / Admin2026! — comptes sim : *@demo.univ ou *.sim@univ.local / Demo2026!');
