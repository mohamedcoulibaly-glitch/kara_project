<?php
/**
 * ====================================================
 * BACKEND: Tableau de Bord
 * ====================================================
 * Dashboard - Vue d'ensemble statistique
 */

require_once __DIR__ . '/../config/config.php';

$db = getDB();

// Statistiques principales
$stats = [
    'total_etudiants' => 0,
    'total_filieres' => 0,
    'total_ue' => 0,
    'taux_reussite' => 0,
    'moyenne_generale' => 0,
    'recent_etudiants' => [],
    'ues_difficiles' => [],
];

// Total des étudiants
$query = "SELECT COUNT(*) as total FROM etudiant WHERE statut = 'Actif'";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total_etudiants'] = $row['total'];
    }
}

// Total des filières
$query = "SELECT COUNT(*) as total FROM filiere";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total_filieres'] = $row['total'];
    }
}

// Total des UE
$query = "SELECT COUNT(*) as total FROM ue";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $stats['total_ue'] = $row['total'];
    }
}

// Taux de réussite
$query = "SELECT 
          COUNT(CASE WHEN valeur_note >= 10 THEN 1 END) as reussis,
          COUNT(*) as total
          FROM note WHERE session = 'Normale'";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['total'] > 0) {
            $stats['taux_reussite'] = round(($row['reussis'] / $row['total']) * 100, 1);
        }
    }
}

// Moyenne générale
$query = "SELECT AVG(valeur_note) as moyenne FROM note WHERE session = 'Normale'";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        if ($row['moyenne']) {
            $stats['moyenne_generale'] = round($row['moyenne'], 2);
        }
    }
}

// Étudiants récemment inscrits
$query = "SELECT id_etudiant, matricule, nom, prenom, date_inscription 
          FROM etudiant 
          WHERE statut = 'Actif'
          ORDER BY date_inscription DESC 
          LIMIT 10";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $stats['recent_etudiants'] = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// UE avec taux d'échec élevé
$query = "SELECT 
          ec.nom_ec,
          COUNT(CASE WHEN n.valeur_note < 10 THEN 1 END) * 100.0 / COUNT(*) as taux_echec,
          COUNT(*) as nombre_notes
          FROM ec
          LEFT JOIN note n ON ec.id_ec = n.id_ec
          WHERE n.session = 'Normale' OR n.session IS NULL
          GROUP BY ec.id_ec, ec.nom_ec
          HAVING COUNT(*) > 0
          ORDER BY taux_echec DESC
          LIMIT 5";
$stmt = $db->prepare($query);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $stats['ues_difficiles'] = $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Gestion Académique</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-surface text-on-surface min-h-screen">

<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container-lowest flex flex-col p-4 z-50">
    <div class="mb-8 px-2">
        <h1 class="text-lg font-bold text-primary">Portail Académique</h1>
        <p class="text-xs text-slate-500">Gestion LMD v2.0</p>
    </div>
    <nav class="flex-1 space-y-1">
        <a href="../../index.php" class="flex items-center gap-3 px-3 py-2 bg-white text-primary shadow-sm rounded-lg">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>
        <a href="repertoire_etudiants_backend.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">group</span>
            <span class="text-sm">Étudiants</span>
        </a>
        <a href="saisie_notes_moyennes_backend.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">edit_note</span>
            <span class="text-sm">Notes</span>
        </a>
    </nav>
</aside>

<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-md z-40 flex items-center justify-between px-8 shadow-sm">
    <h2 class="text-xl font-bold text-primary">Tableau de Bord Académique</h2>
    <div class="flex items-center gap-4">
        <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full">
            <span class="material-symbols-outlined">notifications</span>
        </button>
        <button class="p-2 text-slate-500 hover:bg-slate-100 rounded-full">
            <span class="material-symbols-outlined">settings</span>
        </button>
    </div>
</header>

<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- KPI Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <!-- Total Étudiants -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                        <span class="material-symbols-outlined">group</span>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">+12%</span>
                </div>
                <p class="text-3xl font-bold"><?php echo $stats['total_etudiants']; ?></p>
                <p class="text-sm text-slate-600 mt-2">Étudiants inscrits</p>
            </div>

            <!-- Total Filières -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-purple-100 rounded-lg text-purple-600">
                        <span class="material-symbols-outlined">account_tree</span>
                    </div>
                </div>
                <p class="text-3xl font-bold"><?php echo $stats['total_filieres']; ?></p>
                <p class="text-sm text-slate-600 mt-2">Filières actives</p>
            </div>

            <!-- Taux de Réussite -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-green-100 rounded-lg text-green-600">
                        <span class="material-symbols-outlined">trending_up</span>
                    </div>
                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">+2.1%</span>
                </div>
                <p class="text-3xl font-bold"><?php echo $stats['taux_reussite']; ?>%</p>
                <p class="text-sm text-slate-600 mt-2">Taux de réussite</p>
            </div>

            <!-- Moyenne Générale -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-orange-100 rounded-lg text-orange-600">
                        <span class="material-symbols-outlined">star</span>
                    </div>
                </div>
                <p class="text-3xl font-bold"><?php echo $stats['moyenne_generale']; ?>/20</p>
                <p class="text-sm text-slate-600 mt-2">Moyenne générale</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Étudiants Récents -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <span class="text-blue-600">Récentes Inscriptions</span>
                    </h3>
                </div>
                <div class="divide-y max-h-96 overflow-y-auto">
                    <?php foreach ($stats['recent_etudiants'] as $etudiant): ?>
                    <div class="p-4 hover:bg-slate-50 flex items-center justify-between">
                        <div>
                            <p class="font-semibold"><?php echo htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']); ?></p>
                            <p class="text-xs text-slate-500"><?php echo htmlspecialchars($etudiant['matricule']); ?></p>
                        </div>
                        <span class="text-xs text-slate-500"><?php echo date('d/m/Y', strtotime($etudiant['date_inscription'])); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- UE Difficiles -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-bold flex items-center gap-2">
                        <span class="text-orange-600">UE Problématiques</span>
                    </h3>
                </div>
                <div class="divide-y max-h-96 overflow-y-auto">
                    <?php foreach ($stats['ues_difficiles'] as $ue): ?>
                    <div class="p-4 hover:bg-slate-50">
                        <div class="flex items-center justify-between mb-2">
                            <p class="font-semibold"><?php echo htmlspecialchars($ue['nom_ec']); ?></p>
                            <span class="text-xs bg-red-100 text-red-600 px-2 py-1 rounded">
                                <?php echo round($ue['taux_echec'], 1); ?>% échecs
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded h-1">
                            <div class="bg-red-500 h-1 rounded" style="width: <?php echo $ue['taux_echec']; ?>%"></div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

    </div>
</main>

</body>
</html>
