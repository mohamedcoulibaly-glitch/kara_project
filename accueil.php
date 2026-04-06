<?php
/**
 * ====================================================
 * INDEX: Portail Central de Gestion Académique LMD
 * ====================================================
 * Point d'accès centralisé pour tous les modules
 */

require_once __DIR__ . '/config/config.php';

$db = getDB();

// Récupérer quelques statistiques rapides
$stats_quick = [
    'etudiants' => 0,
    'filieres' => 0,
    'notes_saisies' => 0
];

// Total étudiants
$q = "SELECT COUNT(*) as c FROM etudiant WHERE statut = 'Actif'";
$s = $db->prepare($q);
if ($s->execute() && ($r = $s->get_result())) {
    $stats_quick['etudiants'] = $r->fetch_assoc()['c'];
}

// Total filières
$q = "SELECT COUNT(*) as c FROM filiere";
$s = $db->prepare($q);
if ($s->execute() && ($r = $s->get_result())) {
    $stats_quick['filieres'] = $r->fetch_assoc()['c'];
}

// Notes saisies
$q = "SELECT COUNT(*) as c FROM note WHERE session = 'Normale'";
$s = $db->prepare($q);
if ($s->execute() && ($r = $s->get_result())) {
    $stats_quick['notes_saisies'] = $r->fetch_assoc()['c'];
}

$modules = [
    [
        'title' => 'Tableau de Bord',
        'icon' => 'dashboard',
        'url' => 'backend/tableau_de_bord_backend.php',
        'description' => 'Aperçu statistique et KPI du système',
        'color' => 'bg-blue-50 border-blue-200',
        'icon_color' => 'text-blue-600 bg-blue-100'
    ],
    [
        'title' => 'Gestion des Étudiants',
        'icon' => 'group',
        'url' => 'backend/saisie_etudiants_backend.php',
        'description' => 'Inscription et gestion des étudiants',
        'color' => 'bg-green-50 border-green-200',
        'icon_color' => 'text-green-600 bg-green-100'
    ],
    [
        'title' => 'Gestion UE/EC',
        'icon' => 'library_books',
        'url' => 'backend/saisie_ue_ec_backend.php',
        'description' => 'Création et organisation des UE et EC',
        'color' => 'bg-purple-50 border-purple-200',
        'icon_color' => 'text-purple-600 bg-purple-100'
    ],
    [
        'title' => 'Saisie Notes par EC',
        'icon' => 'edit_note',
        'url' => 'backend/saisie_notes_par_ec_backend.php',
        'description' => 'Saisie détaillée des notes par EC',
        'color' => 'bg-orange-50 border-orange-200',
        'icon_color' => 'text-orange-600 bg-orange-100'
    ],
    [
        'title' => 'Saisie Notes Moyennes',
        'icon' => 'grading',
        'url' => 'backend/saisie_notes_moyennes_backend.php',
        'description' => 'Saisie des notes moyennes par UE',
        'color' => 'bg-red-50 border-red-200',
        'icon_color' => 'text-red-600 bg-red-100'
    ],
    [
        'title' => 'Statistiques',
        'icon' => 'analytics',
        'url' => 'backend/statistiques_reussites_backend.php',
        'description' => 'Analyse des réussites par département',
        'color' => 'bg-cyan-50 border-cyan-200',
        'icon_color' => 'text-cyan-600 bg-cyan-100'
    ]
];

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portail Académique LMD - Accueil</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        .module-card {
            transition: all 0.3s ease;
        }
        .module-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 min-h-screen">

<!-- Header -->
<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-blue-800">🎓 Portail Académique LMD</h1>
            <p class="text-sm text-slate-600">Système de Gestion Académique Intégré</p>
        </div>
        <div class="hidden md:flex items-center gap-4">
            <div class="text-right">
                <p class="text-xs font-semibold text-slate-600 uppercase tracking-wide">État du système</p>
                <p class="text-sm text-green-600 font-bold flex items-center gap-1">
                    <span class="w-2 h-2 bg-green-600 rounded-full"></span>
                    En ligne
                </p>
            </div>
        </div>
    </div>
</header>

<!-- Main Content -->
<main class="max-w-7xl mx-auto px-6 py-12">

    <!-- Statistics Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-semibold mb-1">Étudiants Actifs</p>
                    <p class="text-3xl font-bold text-blue-600"><?php echo $stats_quick['etudiants']; ?></p>
                </div>
                <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                    <span class="material-symbols-outlined text-3xl">group</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-semibold mb-1">Filières</p>
                    <p class="text-3xl font-bold text-purple-600"><?php echo $stats_quick['filieres']; ?></p>
                </div>
                <div class="p-3 bg-purple-100 rounded-lg text-purple-600">
                    <span class="material-symbols-outlined text-3xl">account_tree</span>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-600 font-semibold mb-1">Notes Saisies</p>
                    <p class="text-3xl font-bold text-green-600"><?php echo $stats_quick['notes_saisies']; ?></p>
                </div>
                <div class="p-3 bg-green-100 rounded-lg text-green-600">
                    <span class="material-symbols-outlined text-3xl">edit_note</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Title Section -->
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-slate-900 mb-2">Modules Disponibles</h2>
        <p class="text-slate-600">Accédez à l'ensemble des fonctionnalités de gestion académique</p>
    </div>

    <!-- Modules Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
        <?php foreach ($modules as $module): ?>
        <a href="<?= BASE_URL ?>/<?php echo $module['url']; ?>" class="module-card">
            <div class="h-full bg-white rounded-xl shadow-sm border <?php echo $module['color']; ?> p-6 hover:shadow-lg">
                <div class="flex items-start mb-4">
                    <div class="p-3 rounded-lg <?php echo $module['icon_color']; ?>">
                        <span class="material-symbols-outlined text-2xl"><?php echo $module['icon']; ?></span>
                    </div>
                    <span class="ml-auto text-slate-400 material-symbols-outlined">arrow_outward</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2"><?php echo $module['title']; ?></h3>
                <p class="text-sm text-slate-600 leading-relaxed"><?php echo $module['description']; ?></p>
                <div class="mt-4 pt-4 border-t border-slate-200">
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Cliquer pour accéder →</span>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>


    <!-- Footer -->
    <div class="mt-12 text-center text-slate-600 text-sm">
        <p class="mb-2">Système de Gestion Académique LMD v2.0</p>
        <p class="text-xs text-slate-500">
            Pour toute assistance, consultez la documentation ou les logs du système
        </p>
    </div>

</main>

</body>
</html>
