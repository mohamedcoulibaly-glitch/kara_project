<?php
/**
 * ====================================================
 * INDEX PRINCIPAL - Dashboard
 * ====================================================
 * Point d'accès à l'application
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/backend/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$db = getDB();

// Récupérer les statistiques du tableau de bord
$query = "SELECT 
            COUNT(DISTINCT e.id_etudiant) as total_etudiants,
            COUNT(DISTINCT f.id_filiere) as total_filieres,
            COUNT(DISTINCT n.id_note) as total_notes,
            AVG(n.valeur_note) as moyenne_generale,
            SUM(CASE WHEN e.statut = 'Actif' THEN 1 ELSE 0 END) as etudiants_actifs,
            SUM(CASE WHEN e.statut = 'Diplômé' THEN 1 ELSE 0 END) as etudiants_diplomes
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          LEFT JOIN note n ON e.id_etudiant = n.id_etudiant";

$stats = safeQuerySingle($query);
if (!$stats) {
    $stats = [
        'total_etudiants' => 0,
        'total_filieres' => 0,
        'total_notes' => 0,
        'moyenne_generale' => 0,
        'etudiants_actifs' => 0,
        'etudiants_diplomes' => 0
    ];
}

// Récupérer les étudiants récemment inscrits
$query = "SELECT e.*, f.nom_filiere 
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          ORDER BY e.date_inscription DESC
          LIMIT 10";

$etudiants_recents = safeQuery($query);
if (!$etudiants_recents) {
    $etudiants_recents = [];
}

?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Académique LMD</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#4b5c92",
                        "on-surface": "#191c1e",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "inverse-on-surface": "#eff1f3",
                        "primary": "#003fb1",
                        "on-tertiary-container": "#ffd4c5",
                        "on-primary": "#ffffff",
                        "secondary-container": "#b1c2ff",
                        "on-tertiary-fixed-variant": "#802a00",
                        "inverse-primary": "#b5c4ff",
                        "on-primary-fixed-variant": "#003dab",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed-variant": "#334479",
                        "error-container": "#ffdad6",
                        "surface-tint": "#1353d8",
                        "surface": "#f7f9fb",
                        "on-secondary-fixed": "#01174b",
                        "secondary-fixed": "#dbe1ff",
                        "surface-container": "#eceef0",
                        "primary-fixed-dim": "#b5c4ff",
                        "tertiary-fixed": "#ffdbcf",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-high": "#e6e8ea",
                        "on-background": "#191c1e",
                        "on-primary-fixed": "#00174d",
                        "primary-container": "#1a56db",
                        "error": "#ba1a1a",
                        "tertiary-container": "#ad3b00",
                        "on-primary-container": "#d4dcff",
                        "on-secondary": "#ffffff",
                        "tertiary": "#852b00",
                        "on-tertiary-fixed": "#380d00",
                        "on-tertiary": "#ffffff",
                        "outline-variant": "#c3c5d7",
                        "on-error-container": "#93000a",
                        "primary-fixed": "#dbe1ff",
                        "surface-container-highest": "#e0e3e5",
                        "on-error": "#ffffff",
                        "surface-bright": "#f7f9fb",
                        "tertiary-fixed-dim": "#ffb59a",
                        "secondary-fixed-dim": "#b5c4ff",
                        "outline": "#737686",
                        "surface-variant": "#e0e3e5",
                        "background": "#f7f9fb",
                        "on-secondary-container": "#3d4e84",
                        "on-surface-variant": "#434654"
                    },
                    fontFamily: {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.8);
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }
        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
    <!-- SideNavBar -->
    <aside class="h-screen w-64 fixed left-0 top-0 border-r-0 bg-[#f7f9fb] dark:bg-slate-900 flex flex-col p-4 z-50">
        <div class="mb-8 px-2">
            <h1 class="text-lg font-bold tracking-tight text-[#1A56DB] flex items-center gap-2">
                <span class="material-symbols-outlined" data-icon="account_balance">account_balance</span>
                Portail Académique
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Gestion LMD - Administration</p>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-3 py-2 bg-white text-[#1A56DB] font-semibold shadow-sm transition-transform active:scale-[0.98] text-sm rounded-lg" href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                Tableau de bord
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="backend/repertoire_etudiants_backend.php">
                <span class="material-symbols-outlined" data-icon="group">group</span>
                Étudiants
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="backend/maquette_lmd_backend.php">
                <span class="material-symbols-outlined" data-icon="library_books">library_books</span>
                Maquettes LMD
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="backend/gestion_filieres_ue_backend.php">
                <span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
                Gestion UE/EC
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="backend/configuration_coefficients_backend.php">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                Configuration
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="backend/deliberation_backend.php">
                <span class="material-symbols-outlined" data-icon="gavel">gavel</span>
                Délibérations
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="backend/proces_verbal_backend.php">
                <span class="material-symbols-outlined" data-icon="description">description</span>
                Procès-Verbaux
            </a>
        </nav>
        <button class="mt-4 w-full bg-[#1A56DB] text-white py-2.5 rounded-lg font-semibold text-sm shadow-md hover:bg-[#003fb1] transition-all flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-sm" data-icon="add">add</span>
            Nouvelle Saisie
        </button>
        <div class="mt-auto pt-4 border-t border-[#f2f4f6] space-y-1">
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg" href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                Paramètres
            </a>
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg" href="#">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                Déconnexion
            </a>
        </div>
    </aside>

    <!-- TopAppBar -->
    <header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-8 h-16 border-b border-[#f2f4f6]/50 shadow-sm">
        <h2 class="text-xl font-black text-[#1A56DB] tracking-tight">Système de Gestion Académique</h2>
        <div class="flex items-center gap-6">
            <div class="relative group">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <span class="material-symbols-outlined text-lg" data-icon="search">search</span>
                </span>
                <input class="pl-10 pr-4 py-1.5 bg-surface-container-low border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-[#1A56DB]/20 transition-all" placeholder="Rechercher..." type="text">
            </div>
            <div class="flex items-center gap-4 text-slate-500">
                <button class="hover:bg-slate-50 p-1.5 rounded-full transition-colors active:opacity-80">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                </button>
                <button class="hover:bg-slate-50 p-1.5 rounded-full transition-colors active:opacity-80">
                    <span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
                </button>
                <div class="h-8 w-8 rounded-full bg-secondary-container overflow-hidden ring-2 ring-white">
                    <img alt="Avatar Administrateur" class="h-full w-full object-cover" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3_f_Br9RhLJRBraDU6gXth-nX4e2fUxeGZNHbdBzglDw_XHlTsIHuQjSXnWvWtTTXe2k1Z7eAhbUyyPv_GU3ZGiIMnaRszEwzYQateEnEB_If-SvNx1aEZSPNQLvLn8MkLdlUhapdDlbHOa1ZhvGTOFkw0b5XyPIKcFlsMvSkGF1RcpFaA-331y_2jLwXKmsCluT1hDpKF6Sh9VyagTGeT9hHvNHMPRUNJoUSVEBglPwG3Dy-DHNp0uxXCTCwe-Xt5HWUeKKELF8">
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
        <div class="max-w-7xl mx-auto space-y-8">
            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
                <div>
                    <span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">Aperçu Général</span>
                    <h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Tableau de bord académique</h3>
                    <p class="text-slate-500 mt-1 max-w-2xl">Visualisez les statistiques clés et les dernières activités de votre établissement.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button class="px-5 py-2.5 bg-white border border-outline-variant/30 text-slate-700 font-semibold text-sm rounded-md shadow-sm hover:bg-slate-50 transition-all">
                        Exporter les données
                    </button>
                    <button class="px-5 py-2.5 bg-primary text-white font-semibold text-sm rounded-md shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm" data-icon="refresh">refresh</span>
                        Actualiser
                    </button>
                </div>
            </div>

            <!-- Statistics Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
                    <div class="flex items-center justify-between mb-3">
                        <span class="material-symbols-outlined text-3xl text-primary" data-icon="groups">groups</span>
                        <span class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Total</span>
                    </div>
                    <div class="card-value text-3xl font-bold text-primary mb-1"><?php echo $stats['total_etudiants'] ?? 0; ?></div>
                    <div class="card-label text-sm text-slate-500">Étudiants inscrits</div>
                    <div class="mt-3 pt-3 border-t border-outline-variant/10 flex justify-between text-xs">
                        <span class="text-green-600">Actifs: <?php echo $stats['etudiants_actifs'] ?? 0; ?></span>
                        <span class="text-blue-600">Diplômés: <?php echo $stats['etudiants_diplomes'] ?? 0; ?></span>
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
                    <div class="flex items-center justify-between mb-3">
                        <span class="material-symbols-outlined text-3xl text-secondary" data-icon="account_tree">account_tree</span>
                        <span class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Filières</span>
                    </div>
                    <div class="card-value text-3xl font-bold text-secondary mb-1"><?php echo $stats['total_filieres'] ?? 0; ?></div>
                    <div class="card-label text-sm text-slate-500">Filières actives</div>
                    <div class="mt-3 pt-3 border-t border-outline-variant/10 text-xs text-slate-400">
                        Licences • Masters • Doctorat
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
                    <div class="flex items-center justify-between mb-3">
                        <span class="material-symbols-outlined text-3xl text-tertiary" data-icon="school">school</span>
                        <span class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Moyenne</span>
                    </div>
                    <div class="card-value text-3xl font-bold text-tertiary mb-1"><?php echo round($stats['moyenne_generale'] ?? 0, 2); ?><span class="text-lg">/20</span></div>
                    <div class="card-label text-sm text-slate-500">Moyenne générale</div>
                    <div class="mt-3 pt-3 border-t border-outline-variant/10 text-xs text-slate-400">
                        Toutes filières confondues
                    </div>
                </div>

                <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
                    <div class="flex items-center justify-between mb-3">
                        <span class="material-symbols-outlined text-3xl text-primary-container" data-icon="receipt">receipt</span>
                        <span class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Évaluations</span>
                    </div>
                    <div class="card-value text-3xl font-bold text-primary-container mb-1"><?php echo $stats['total_notes'] ?? 0; ?></div>
                    <div class="card-label text-sm text-slate-500">Notes enregistrées</div>
                    <div class="mt-3 pt-3 border-t border-outline-variant/10 text-xs text-slate-400">
                        Sessions en cours
                    </div>
                </div>
            </div>

            <!-- Modules Section -->
            <section class="bg-surface-container p-8 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary" data-icon="apps">apps</span>
                    <h4 class="text-lg font-bold text-on-surface">Modules d'application</h4>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3">
                    <a href="backend/repertoire_etudiants_backend.php" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">group</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Répertoire Étudiants</span>
                    </a>
                    <a href="backend/maquette_lmd_backend.php" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">library_books</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Maquettes LMD</span>
                    </a>
                    <a href="backend/gestion_filieres_ue_backend.php" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">account_tree</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Gestion UE/EC</span>
                    </a>
                    <a href="backend/configuration_coefficients_backend.php" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">settings</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Configuration</span>
                    </a>
                    <a href="backend/parcours_academique_backend.php?id=1" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">timeline</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Parcours Étudiant</span>
                    </a>
                    <a href="backend/carte_etudiant_backend.php?id=1" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">badge</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Carte Étudiant</span>
                    </a>
                    <a href="backend/attestation_backend.php?id=1" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">description</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Attestation</span>
                    </a>
                    <a href="backend/gestion_sessions_rattrapage_backend.php" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">autorenew</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Sessions Rattrapage</span>
                    </a>
                    <a href="backend/deliberation_backend.php" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">gavel</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Délibérations</span>
                    </a>
                    <a href="backend/proces_verbal_backend.php" class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                        <span class="material-symbols-outlined text-primary text-2xl">receipt_long</span>
                        <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Procès-Verbaux</span>
                    </a>
                </div>
            </section>

            <!-- Recent Students Section -->
            <section class="bg-surface-container p-8 rounded-xl">
                <div class="flex items-center gap-3 mb-6">
                    <span class="material-symbols-outlined text-primary" data-icon="recent_actors">recent_actors</span>
                    <h4 class="text-lg font-bold text-on-surface">Étudiants récemment inscrits</h4>
                    <span class="text-xs bg-primary-container/20 text-primary px-2 py-1 rounded-full ml-auto">Derniers 10 inscrits</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-outline-variant/30">
                                <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Matricule</th>
                                <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nom & Prénom</th>
                                <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Filière</th>
                                <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Statut</th>
                                <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Date Inscription</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($etudiants_recents as $et): ?>
                            <tr class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors">
                                <td class="py-3 px-4 text-sm font-mono text-slate-600"><?php echo htmlspecialchars($et['matricule']); ?></td>
                                <td class="py-3 px-4 text-sm font-medium text-slate-800"><?php echo htmlspecialchars($et['nom'] . ' ' . $et['prenom']); ?></td>
                                <td class="py-3 px-4 text-sm text-slate-600"><?php echo htmlspecialchars($et['nom_filiere'] ?? 'N/A'); ?></td>
                                <td class="py-3 px-4">
                                    <?php if($et['statut'] == 'Actif'): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold">
                                        <span class="material-symbols-outlined text-xs" data-icon="check_circle">check_circle</span>
                                        Actif
                                    </span>
                                    <?php elseif($et['statut'] == 'Diplômé'): ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">
                                        <span class="material-symbols-outlined text-xs" data-icon="school">school</span>
                                        Diplômé
                                    </span>
                                    <?php else: ?>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-gray-50 text-gray-600 rounded-full text-xs font-semibold">
                                        <span class="material-symbols-outlined text-xs" data-icon="pending">pending</span>
                                        <?php echo htmlspecialchars($et['statut']); ?>
                                    </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-500"><?php echo formatDate($et['date_inscription']); ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <?php if(empty($etudiants_recents)): ?>
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">person_off</span>
                    <p class="text-slate-500">Aucun étudiant inscrit pour le moment</p>
                </div>
                <?php endif; ?>
                
                <div class="mt-6 text-right">
                    <a href="backend/repertoire_etudiants_backend.php" class="inline-flex items-center gap-2 text-primary text-sm font-semibold hover:underline">
                        Voir tous les étudiants
                        <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            </section>
        </div>
    </main>
</body>
</html>