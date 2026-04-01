<?php
/**
 * ====================================================
 * BACKEND: Statistiques de Réussite par Département
 * ====================================================
 * Analyse comparative des performances académiques
 */

require_once __DIR__ . '/../config/config.php';

$db = getDB();

// Récupérer les départements
$query = "SELECT id_departement, nom_departement FROM departement ORDER BY nom_departement";
$stmt = $db->prepare($query);
$departements = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $departements = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Statistiques par département
$stats_departements = [];
foreach ($departements as $dept) {
    $id_dept = $dept['id_departement'];
    
    // Récupérer les stats pour ce département
    $query = "SELECT 
              COUNT(DISTINCT e.id_etudiant) as nombre_etudiants,
              COUNT(CASE WHEN n.valeur_note >= 10 THEN 1 END) as reussis,
              COUNT(n.id_note) as total_notes,
              AVG(n.valeur_note) as moyenne
              FROM etudiant e
              LEFT JOIN note n ON e.id_etudiant = n.id_etudiant
              WHERE e.id_departement = ? AND e.statut = 'Actif'
              AND (n.session = 'Normale' OR n.session IS NULL)";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_dept);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $row = $result->fetch_assoc();
            $stats_departements[$id_dept] = [
                'nom' => $dept['nom_departement'],
                'nombre_etudiants' => $row['nombre_etudiants'] ?? 0,
                'reussis' => $row['reussis'] ?? 0,
                'total_notes' => $row['total_notes'] ?? 0,
                'moyenne' => $row['moyenne'] ? round($row['moyenne'], 2) : 0,
                'taux_reussite' => ($row['total_notes'] > 0) ? round(($row['reussis'] / $row['total_notes']) * 100, 1) : 0
            ];
        }
    }
}

// Statistiques globales
$query = "SELECT 
          COUNT(DISTINCT e.id_etudiant) as total_etudiants,
          COUNT(CASE WHEN n.valeur_note >= 10 THEN 1 END) as total_reussis,
          COUNT(n.id_note) as total_notes,
          AVG(n.valeur_note) as moyenne_globale,
          MIN(n.valeur_note) as note_min,
          MAX(n.valeur_note) as note_max
          FROM etudiant e
          LEFT JOIN note n ON e.id_etudiant = n.id_etudiant
          WHERE e.statut = 'Actif' AND (n.session = 'Normale' OR n.session IS NULL)";

$stmt = $db->prepare($query);
$stats_globales = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $stats_globales = [
            'total_etudiants' => $row['total_etudiants'] ?? 0,
            'total_reussis' => $row['total_reussis'] ?? 0,
            'total_notes' => $row['total_notes'] ?? 0,
            'moyenne_globale' => $row['moyenne_globale'] ? round($row['moyenne_globale'], 2) : 0,
            'note_min' => $row['note_min'] ?? 0,
            'note_max' => $row['note_max'] ?? 0,
            'taux_global' => ($row['total_notes'] > 0) ? round(($row['total_reussis'] / $row['total_notes']) * 100, 1) : 0
        ];
    }
}

// Répartition par note
$query = "SELECT 
          COUNT(CASE WHEN valeur_note < 5 THEN 1 END) as tres_faible,
          COUNT(CASE WHEN valeur_note >= 5 AND valeur_note < 8 THEN 1 END) as faible,
          COUNT(CASE WHEN valeur_note >= 8 AND valeur_note < 12 THEN 1 END) as moyen,
          COUNT(CASE WHEN valeur_note >= 12 AND valeur_note < 15 THEN 1 END) as bon,
          COUNT(CASE WHEN valeur_note >= 15 THEN 1 END) as excellent
          FROM note WHERE session = 'Normale'";

$stmt = $db->prepare($query);
$repartition = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['tres_faible'] + $row['faible'] + $row['moyen'] + $row['bon'] + $row['excellent'];
        $repartition = [
            'tres_faible' => $total > 0 ? round(($row['tres_faible'] / $total) * 100, 1) : 0,
            'faible' => $total > 0 ? round(($row['faible'] / $total) * 100, 1) : 0,
            'moyen' => $total > 0 ? round(($row['moyen'] / $total) * 100, 1) : 0,
            'bon' => $total > 0 ? round(($row['bon'] / $total) * 100, 1) : 0,
            'excellent' => $total > 0 ? round(($row['excellent'] / $total) * 100, 1) : 0,
        ];
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques de Réussite - Gestion Académique</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-surface text-on-surface min-h-screen">

<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
    <div class="mb-8 px-2">
        <h1 class="text-lg font-bold text-primary">Portail Académique</h1>
        <p class="text-xs text-slate-500">Gestion LMD</p>
    </div>
    <nav class="flex-1 space-y-1">
        <a href="../../index.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>
        <a href="statistiques_reussites_backend.php" class="flex items-center gap-3 px-3 py-2 bg-white text-primary shadow-sm rounded-lg">
            <span class="material-symbols-outlined">analytics</span>
            <span class="text-sm">Statistiques</span>
        </a>
    </nav>
</aside>

<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-md z-40 flex items-center px-8 shadow-sm">
    <h2 class="text-xl font-bold text-primary">Statistiques de Réussite</h2>
</header>

<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
    <div class="max-w-7xl mx-auto space-y-8">

        <!-- KPI Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                <p class="text-sm text-slate-600 font-semibold mb-2">Taux Global</p>
                <p class="text-4xl font-bold text-blue-600"><?php echo $stats_globales['taux_global']; ?>%</p>
                <p class="text-xs text-slate-500 mt-2">Réussite générale</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                <p class="text-sm text-slate-600 font-semibold mb-2">Moyenne Générale</p>
                <p class="text-4xl font-bold text-green-600"><?php echo $stats_globales['moyenne_globale']; ?>/20</p>
                <p class="text-xs text-slate-500 mt-2">Moyenne de l'établissement</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                <p class="text-sm text-slate-600 font-semibold mb-2">Étudiants</p>
                <p class="text-4xl font-bold text-purple-600"><?php echo $stats_globales['total_etudiants']; ?></p>
                <p class="text-xs text-slate-500 mt-2">Total inscrits</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
                <p class="text-sm text-slate-600 font-semibold mb-2">Réussis</p>
                <p class="text-4xl font-bold text-orange-600"><?php echo $stats_globales['total_reussis']; ?></p>
                <p class="text-xs text-slate-500 mt-2">Nombre total</p>
            </div>
        </div>

        <!-- Répartition des Notes -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="text-lg font-bold mb-6">Répartition des Notes</h3>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                <div class="text-center">
                    <div class="w-full bg-red-200 rounded h-40 flex items-end justify-center mb-2">
                        <div class="bg-red-500 w-12 rounded-t" style="height: <?php echo $repartition['tres_faible'] * 1.5; ?>px;"></div>
                    </div>
                    <p class="font-semibold"><?php echo $repartition['tres_faible']; ?>%</p>
                    <p class="text-xs text-slate-600">Très faible &lt;5</p>
                </div>

                <div class="text-center">
                    <div class="w-full bg-orange-200 rounded h-40 flex items-end justify-center mb-2">
                        <div class="bg-orange-500 w-12 rounded-t" style="height: <?php echo $repartition['faible'] * 1.5; ?>px;"></div>
                    </div>
                    <p class="font-semibold"><?php echo $repartition['faible']; ?>%</p>
                    <p class="text-xs text-slate-600">Faible 5-8</p>
                </div>

                <div class="text-center">
                    <div class="w-full bg-yellow-200 rounded h-40 flex items-end justify-center mb-2">
                        <div class="bg-yellow-500 w-12 rounded-t" style="height: <?php echo $repartition['moyen'] * 1.5; ?>px;"></div>
                    </div>
                    <p class="font-semibold"><?php echo $repartition['moyen']; ?>%</p>
                    <p class="text-xs text-slate-600">Moyen 8-12</p>
                </div>

                <div class="text-center">
                    <div class="w-full bg-blue-200 rounded h-40 flex items-end justify-center mb-2">
                        <div class="bg-blue-500 w-12 rounded-t" style="height: <?php echo $repartition['bon'] * 1.5; ?>px;"></div>
                    </div>
                    <p class="font-semibold"><?php echo $repartition['bon']; ?>%</p>
                    <p class="text-xs text-slate-600">Bon 12-15</p>
                </div>

                <div class="text-center">
                    <div class="w-full bg-green-200 rounded h-40 flex items-end justify-center mb-2">
                        <div class="bg-green-500 w-12 rounded-t" style="height: <?php echo $repartition['excellent'] * 1.5; ?>px;"></div>
                    </div>
                    <p class="font-semibold"><?php echo $repartition['excellent']; ?>%</p>
                    <p class="text-xs text-slate-600">Excellent ≥15</p>
                </div>
            </div>
        </div>

        <!-- Statistiques par Département -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b">
                <h3 class="text-lg font-bold">Statistiques par Département</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-3 text-left font-bold text-sm">Département</th>
                            <th class="px-6 py-3 text-center font-bold text-sm">Étudiants</th>
                            <th class="px-6 py-3 text-center font-bold text-sm">Total Notes</th>
                            <th class="px-6 py-3 text-center font-bold text-sm">Réussis</th>
                            <th class="px-6 py-3 text-center font-bold text-sm">Taux Réussite</th>
                            <th class="px-6 py-3 text-center font-bold text-sm">Moyenne</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php foreach ($stats_departements as $id => $stats): ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 font-semibold"><?php echo htmlspecialchars($stats['nom']); ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $stats['nombre_etudiants']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $stats['total_notes']; ?></td>
                            <td class="px-6 py-4 text-center"><?php echo $stats['reussis']; ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-bold">
                                    <?php echo $stats['taux_reussite']; ?>%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center font-semibold"><?php echo $stats['moyenne']; ?>/20</td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</main>

</body>
</html>
