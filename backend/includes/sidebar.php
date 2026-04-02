<?php
/**
 * ====================================================
 * COMPOSANT PARTAGÉ: Sidebar + Header + Scripts communs
 * ====================================================
 * Inclus par tous les fichiers backend/frontend
 * Variables attendues:
 *   $page_title - Titre de la page
 *   $current_page - Identifiant de la page active (ex: 'dashboard', 'etudiants', etc.)
 */

// Vérifier l'authentification (sauf pour login.php)
if (!isset($skip_auth) || !$skip_auth) {
    if (!isset($_SESSION['user_id'])) {
        // Si on n'est pas sur la page de login, rediriger
        if (basename($_SERVER['PHP_SELF']) !== 'login.php') {
            header("Location: " . BASE_URL . "/login.php?error=session_expiree");
            exit;
        }
    }
}

$page_title = $page_title ?? 'Gestion Académique LMD';
$current_page = $current_page ?? '';

// Déterminer le chemin de base selon le contexte
// On utilise BASE_URL défini dans config.php
$base_url = rtrim(BASE_URL, '/') . '/';
$backend_url = 'backend/';

// Récupérer les informations de l'utilisateur connecté
$current_user = getCurrentUser();
$user_name = $current_user ? $current_user['nom'] . ' ' . $current_user['prenom'] : 'Admin_Kara';
$user_role = $current_user ? $current_user['role'] : 'Super Admin';

// Liens de navigation
$nav_items = [
    ['id' => 'dashboard', 'label' => 'Tableau de bord', 'icon' => 'dashboard', 'href' => $base_url . 'index.php'],
    ['id' => 'etudiants', 'label' => 'Étudiants', 'icon' => 'group', 'href' => $base_url . $backend_url . 'repertoire_etudiants_backend.php'],
    ['id' => 'inscription', 'label' => 'Inscription', 'icon' => 'person_add', 'href' => $base_url . $backend_url . 'saisie_etudiants_backend.php'],
    ['id' => 'departements', 'label' => 'Départements', 'icon' => 'domain', 'href' => $base_url . $backend_url . 'saisie_deprtement_backend.php'],
    ['id' => 'maquettes', 'label' => 'Maquettes LMD', 'icon' => 'library_books', 'href' => $base_url . $backend_url . 'maquette_lmd_backend.php'],
    ['id' => 'ue_ec', 'label' => 'Gestion UE/EC', 'icon' => 'account_tree', 'href' => $base_url . $backend_url . 'gestion_filieres_ue_backend.php'],
    ['id' => 'saisie_ue_ec', 'label' => 'Saisie UE/EC', 'icon' => 'edit_note', 'href' => $base_url . $backend_url . 'saisie_ue_ec_backend.php'],
    ['id' => 'notes', 'label' => 'Saisie Notes', 'icon' => 'grade', 'href' => $base_url . $backend_url . 'saisie_notes_par_ec_backend.php'],
    ['id' => 'configuration', 'label' => 'Configuration', 'icon' => 'settings', 'href' => $base_url . $backend_url . 'configuration_coefficients_backend.php'],
    ['id' => 'deliberations', 'label' => 'Délibérations', 'icon' => 'gavel', 'href' => $base_url . $backend_url . 'deliberation_backend.php'],
    ['id' => 'pv', 'label' => 'Procès-Verbaux', 'icon' => 'description', 'href' => $base_url . $backend_url . 'proces_verbal_backend.php'],
    ['id' => 'rattrapage', 'label' => 'Rattrapage', 'icon' => 'autorenew', 'href' => $base_url . $backend_url . 'gestion_sessions_rattrapage_backend.php'],
    ['id' => 'statistiques', 'label' => 'Statistiques', 'icon' => 'bar_chart', 'href' => $base_url . $backend_url . 'statistiques_reussites_backend.php'],
];
?>
<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Gestion Académique LMD</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
    <script>
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
                        "inverse-primary": "#b5c4ff",
                        "surface-container-lowest": "#ffffff",
                        "error-container": "#ffdad6",
                        "surface-tint": "#1353d8",
                        "surface": "#f7f9fb",
                        "secondary-fixed": "#dbe1ff",
                        "surface-container": "#eceef0",
                        "primary-fixed-dim": "#b5c4ff",
                        "tertiary-fixed": "#ffdbcf",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-high": "#e6e8ea",
                        "on-background": "#191c1e",
                        "primary-container": "#1a56db",
                        "error": "#ba1a1a",
                        "tertiary-container": "#ad3b00",
                        "on-primary-container": "#d4dcff",
                        "on-secondary": "#ffffff",
                        "tertiary": "#852b00",
                        "on-tertiary": "#ffffff",
                        "outline-variant": "#c3c5d7",
                        "on-error-container": "#93000a",
                        "primary-fixed": "#dbe1ff",
                        "surface-container-highest": "#e0e3e5",
                        "on-error": "#ffffff",
                        "surface-bright": "#f7f9fb",
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
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }

        .stat-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px -8px rgba(0, 0, 0, 0.15);
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .sidebar-link {
            transition: all 0.2s ease;
        }

        .sidebar-link:hover {
            transform: translateX(2px);
        }
    </style>
</head>

<body class="bg-surface text-on-surface antialiased">
    <!-- Sidebar -->
    <aside
        class="h-screen w-64 fixed left-0 top-0 border-r-0 bg-[#f7f9fb] flex flex-col p-4 z-50 overflow-y-auto no-scrollbar">
        <div class="mb-6 px-2">
            <h1 class="text-lg font-bold tracking-tight text-[#1A56DB] flex items-center gap-2">
                <span class="material-symbols-outlined">account_balance</span>
                Portail Académique
            </h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Gestion LMD - Administration</p>
        </div>
        <nav class="flex-1 space-y-0.5">
            <?php foreach ($nav_items as $item): ?>
                <a class="sidebar-link flex items-center gap-3 px-3 py-2 <?php
                echo ($current_page === $item['id'])
                    ? 'bg-white text-[#1A56DB] font-semibold shadow-sm'
                    : 'text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] font-medium';
                ?> text-sm rounded-lg" href="<?php echo $item['href']; ?>">
                    <span class="material-symbols-outlined text-[20px]"><?php echo $item['icon']; ?></span>
                    <?php echo $item['label']; ?>
                </a>
            <?php endforeach; ?>
        </nav>
        <div class="mt-auto pt-4 border-t border-[#f2f4f6] space-y-1">
            <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg"
                href="<?php echo $base_url; ?>index.php">
                <span class="material-symbols-outlined">home</span>
                Accueil
            </a>
            <?php if ($current_user && $current_user['role'] === 'Admin'): ?>
                <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg"
                    href="<?php echo $base_url; ?>backend/gestion_utilisateurs_backend.php">
                    <span class="material-symbols-outlined">people</span>
                    Utilisateurs
                </a>
                <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg"
                    href="<?php echo $base_url; ?>backend/audit_logs_backend.php">
                    <span class="material-symbols-outlined">history</span>
                    Audit Logs
                </a>
                <a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg"
                    href="<?php echo $base_url; ?>backend/parametres_systeme_backend.php">
                    <span class="material-symbols-outlined">settings</span>
                    Paramètres
                </a>
            <?php endif; ?>
        </div>
    </aside>

    <!-- Header -->
    <header
        class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-8 h-16 border-b border-[#f2f4f6]/50 shadow-sm transition-all duration-300">
        <div class="flex items-center gap-6">
            <h2 class="text-xl font-black text-[#1A56DB] tracking-tight truncate max-w-xs">
                <?php echo htmlspecialchars($page_title); ?></h2>
            <!-- Functional Search Bar -->
            <div class="hidden lg:flex items-center relative group">
                <span
                    class="material-symbols-outlined absolute left-3 text-slate-400 group-focus-within:text-primary transition-colors text-[20px]">search</span>
                <input id="global-search-input" type="text" placeholder="Rechercher..."
                    class="pl-10 pr-4 py-2 bg-slate-50 border-none rounded-xl text-sm w-64 focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none">
            </div>
        </div>

        <div class="flex items-center gap-5">
            <!-- Notifications Mock -->
            <button class="relative hover:bg-slate-50 p-2 rounded-xl transition-all group" title="Notifications">
                <span class="material-symbols-outlined text-slate-500 group-hover:text-primary">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white"></span>
            </button>

            <!-- Profil Dropdown -->
            <a href="<?= $base_url ?>backend/profil_utilisateur_backend.php"
                class="flex items-center gap-3 pl-4 border-l border-slate-100 group cursor-pointer hover:bg-slate-50 rounded-xl transition-all">
                <div class="text-right hidden sm:block">
                    <p class="text-xs font-black text-slate-800"><?= htmlspecialchars($user_name) ?></p>
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                        <?= htmlspecialchars($user_role) ?></p>
                </div>
                <div
                    class="h-10 w-10 rounded-xl bg-primary/10 overflow-hidden ring-2 ring-white flex items-center justify-center group-hover:ring-primary/20 transition-all">
                    <span class="material-symbols-outlined text-primary scale-110">person</span>
                </div>
            </a>
            <button onclick="if(confirm('Déconnexion ?')) window.location.href='<?= $base_url ?>logout.php';"
                class="hover:text-error p-1 transition-colors" title="Déconnexion">
                <span class="material-symbols-outlined text-slate-400 hover:text-error">logout</span>
            </button>
        </div>
    </header>

    <!-- Main Content -->
    <main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
        <div class="max-w-7xl mx-auto">