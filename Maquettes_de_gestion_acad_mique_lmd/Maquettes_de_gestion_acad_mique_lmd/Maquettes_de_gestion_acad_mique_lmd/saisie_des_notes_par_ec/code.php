<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Saisie des Notes - LMD Horizon</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-surface": "#191c1e",
                        "on-tertiary-fixed-variant": "#802a00",
                        "on-primary-fixed": "#00174d",
                        "surface-tint": "#1353d8",
                        "on-tertiary-fixed": "#380d00",
                        "primary-container": "#1a56db",
                        "outline": "#737686",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#dbe1ff",
                        "inverse-surface": "#2d3133",
                        "tertiary": "#852b00",
                        "surface-bright": "#f7f9fb",
                        "surface-variant": "#e0e3e5",
                        "surface-dim": "#d8dadc",
                        "tertiary-fixed-dim": "#ffb59a",
                        "secondary-fixed-dim": "#b5c4ff",
                        "on-secondary-fixed": "#01174b",
                        "secondary-container": "#b1c2ff",
                        "primary": "#003fb1",
                        "on-surface-variant": "#434654",
                        "on-tertiary-container": "#ffd4c5",
                        "surface-container-low": "#f2f4f6",
                        "primary-fixed-dim": "#b5c4ff",
                        "surface-container": "#eceef0",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed-variant": "#003dab",
                        "inverse-primary": "#b5c4ff",
                        "surface-container-highest": "#e0e3e5",
                        "surface": "#f7f9fb",
                        "on-secondary-fixed-variant": "#334479",
                        "on-error-container": "#93000a",
                        "surface-container-lowest": "#ffffff",
                        "on-background": "#191c1e",
                        "secondary": "#4b5c92",
                        "tertiary-container": "#ad3b00",
                        "tertiary-fixed": "#ffdbcf",
                        "background": "#f7f9fb",
                        "surface-container-high": "#e6e8ea",
                        "on-secondary-container": "#3d4e84",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "outline-variant": "#c3c5d7",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "on-primary-container": "#d4dcff",
                        "primary-fixed": "#dbe1ff"
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
        body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }
        .material-symbols-outlined { font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24; }
        .glass-effect { backdrop-filter: blur(12px); }
        input[type="number"]::-webkit-inner-spin-button, 
        input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }
    </style>
</head>
<body class="text-on-surface bg-surface">
<!-- SideNavBar (Authority: Shared Components JSON) -->
<aside class="flex flex-col fixed left-0 top-0 h-full py-6 bg-slate-50 dark:bg-slate-950 h-screen w-64 border-r-0 tonal-shift bg-surface-container-low transition-all duration-150 ease-in-out z-40 hidden md:flex">
<div class="px-6 mb-10 flex items-center gap-3">
<div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center text-white font-bold text-xl">H</div>
<div>
<h2 class="text-lg font-black text-blue-900 dark:text-blue-300 leading-none">LMD Horizon</h2>
<p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold mt-1">Administration</p>
</div>
</div>
<nav class="flex-1 space-y-1 px-3">
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all duration-150" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-sm font-medium Inter">Tableau de bord</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-blue-50 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 border-r-4 border-blue-700 transition-all duration-150" href="#">
<span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
<span class="text-sm font-medium Inter">Filières</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all duration-150" href="#">
<span class="material-symbols-outlined" data-icon="grading">grading</span>
<span class="text-sm font-medium Inter">Notes</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-500 dark:text-slate-500 hover:text-slate-900 dark:hover:text-slate-200 hover:bg-slate-200/50 dark:hover:bg-slate-800/50 transition-all duration-150" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span class="text-sm font-medium Inter">Paramètres</span>
</a>
</nav>
<div class="px-6 py-4 mt-auto">
<div class="flex items-center gap-3 p-3 rounded-xl bg-surface-container-lowest shadow-sm">
<div class="w-8 h-8 rounded-full bg-secondary-container text-on-secondary-container flex items-center justify-center font-bold text-xs">JD</div>
<div class="overflow-hidden">
<p class="text-xs font-bold truncate">Jean Dupont</p>
<p class="text-[10px] text-slate-500 truncate">Administrateur</p>
</div>
</div>
</div>
</aside>
<!-- TopAppBar (Authority: Shared Components JSON) -->
<header class="sticky top-0 z-50 w-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md no-border bg-surface-container-low shadow-sm dark:shadow-none md:pl-64">
<div class="flex items-center justify-between px-6 py-3 w-full">
<div class="flex items-center gap-4">
<span class="text-xl font-bold tracking-tighter text-blue-800 dark:text-blue-400 font-sans antialiased tracking-tight">Portail Académique</span>
</div>
<div class="flex items-center gap-4">
<div class="relative hidden sm:block">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
<input class="pl-10 pr-4 py-2 bg-surface-container text-sm rounded-full border-none focus:ring-2 focus:ring-primary w-64" placeholder="Rechercher un étudiant..." type="text"/>
</div>
<div class="flex items-center gap-2">
<button class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors scale-95 active:scale-90 duration-200">
<span class="material-symbols-outlined text-slate-600 dark:text-slate-400" data-icon="notifications">notifications</span>
</button>
<button class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors scale-95 active:scale-90 duration-200">
<span class="material-symbols-outlined text-slate-600 dark:text-slate-400" data-icon="account_circle">account_circle</span>
</button>
</div>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="md:pl-64 min-h-screen pb-20">
<div class="max-w-7xl mx-auto px-6 py-8">
<!-- Breadcrumbs & Title -->
<div class="mb-8">
<nav class="flex items-center gap-2 text-xs font-medium text-slate-500 mb-2 uppercase tracking-wider">
<span>Configurations</span>
<span class="material-symbols-outlined text-[14px]">chevron_right</span>
<span class="text-primary-container">Saisie des Notes</span>
</nav>
<h1 class="text-3xl font-extrabold tracking-tight text-on-surface">Saisie des Notes par EC</h1>
</div>
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
<!-- Left Section: Filters and Table -->
<div class="lg:col-span-3 space-y-6">
<!-- Filter Bento Grid -->
<section class="bg-surface-container-low p-6 rounded-xl space-y-6">
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
<div class="space-y-2">
<label class="text-xs font-bold text-on-surface-variant uppercase tracking-wide">Filière</label>
<select class="w-full bg-surface-container-lowest border-none rounded-lg text-sm p-3 focus:ring-2 focus:ring-primary shadow-sm">
<option>Génie Logiciel L3</option>
<option>Cyber-sécurité L2</option>
<option>Systèmes &amp; Réseaux L3</option>
</select>
</div>
<div class="space-y-2">
<label class="text-xs font-bold text-on-surface-variant uppercase tracking-wide">Unité d'Enseignement (UE)</label>
<select class="w-full bg-surface-container-lowest border-none rounded-lg text-sm p-3 focus:ring-2 focus:ring-primary shadow-sm">
<option>INF101 - Algorithmique Fondamentale</option>
<option>INF102 - Architecture des Ordinateurs</option>
</select>
</div>
<div class="space-y-2">
<label class="text-xs font-bold text-on-surface-variant uppercase tracking-wide">Élément Constitutif (EC)</label>
<select class="w-full bg-surface-container-lowest border-none rounded-lg text-sm p-3 focus:ring-2 focus:ring-primary shadow-sm">
<option>INF101.1 - Algorithme</option>
<option>INF101.2 - Structures de Données</option>
</select>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<div class="space-y-2">
<label class="text-xs font-bold text-on-surface-variant uppercase tracking-wide">Type de Session</label>
<div class="flex gap-2 p-1 bg-surface-container rounded-lg">
<button class="flex-1 py-2 text-sm font-semibold rounded-md bg-white text-primary shadow-sm">Normale</button>
<button class="flex-1 py-2 text-sm font-medium text-slate-500 hover:bg-white/50 transition-colors">Rattrapage</button>
</div>
</div>
<div class="space-y-2">
<label class="text-xs font-bold text-on-surface-variant uppercase tracking-wide">Date de l'Examen</label>
<input class="w-full bg-surface-container-lowest border-none rounded-lg text-sm p-3 focus:ring-2 focus:ring-primary shadow-sm" type="date" value="2023-10-25"/>
</div>
</div>
</section>
<!-- Data Grid Section -->
<section class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Matricule</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Nom &amp; Prénom</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider text-right">Note (/20)</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider text-center">Statut</th>
<th class="px-6 py-4 text-xs font-bold text-on-surface-variant uppercase tracking-wider">Observations</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<!-- Row 1 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-medium text-slate-500">23G00124</td>
<td class="px-6 py-4 text-sm font-bold">ABENA Marie-Thérèse</td>
<td class="px-6 py-4 text-right">
<input class="w-20 text-right bg-surface-container-low border-none rounded-md text-sm font-bold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary" max="20" min="0" step="0.25" type="number" value="14.50"/>
</td>
<td class="px-6 py-4 text-center">
<span class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider">Validé</span>
</td>
<td class="px-6 py-4">
<input class="w-full bg-transparent border-none text-xs text-slate-500 focus:ring-0 italic" placeholder="Note..." type="text" value="Très bonne participation"/>
</td>
</tr>
<!-- Row 2 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-medium text-slate-500">23G00456</td>
<td class="px-6 py-4 text-sm font-bold">BEKONO Jean-Paul</td>
<td class="px-6 py-4 text-right">
<input class="w-20 text-right bg-surface-container-low border-none rounded-md text-sm font-bold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary" max="20" min="0" step="0.25" type="number" value="08.75"/>
</td>
<td class="px-6 py-4 text-center">
<span class="px-3 py-1 rounded-full bg-tertiary-container text-on-tertiary-container text-[10px] font-bold uppercase tracking-wider">Rattrapage</span>
</td>
<td class="px-6 py-4">
<input class="w-full bg-transparent border-none text-xs text-slate-500 focus:ring-0 italic" placeholder="Note..." type="text" value="Difficultés en logique"/>
</td>
</tr>
<!-- Row 3 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-medium text-slate-500">23G00089</td>
<td class="px-6 py-4 text-sm font-bold">DIOP Mouhamadou</td>
<td class="px-6 py-4 text-right">
<input class="w-20 text-right bg-surface-container-low border-none rounded-md text-sm font-bold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary" max="20" min="0" step="0.25" type="number" value="12.00"/>
</td>
<td class="px-6 py-4 text-center">
<span class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider">Validé</span>
</td>
<td class="px-6 py-4">
<input class="w-full bg-transparent border-none text-xs text-slate-500 focus:ring-0 italic" placeholder="Note..." type="text"/>
</td>
</tr>
<!-- Row 4 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-medium text-slate-500">23G01022</td>
<td class="px-6 py-4 text-sm font-bold">EBOA Samuel</td>
<td class="px-6 py-4 text-right">
<input class="w-20 text-right bg-surface-container-low border-none rounded-md text-sm font-bold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary" max="20" min="0" step="0.25" type="number" value="16.25"/>
</td>
<td class="px-6 py-4 text-center">
<span class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider">Validé</span>
</td>
<td class="px-6 py-4">
<input class="w-full bg-transparent border-none text-xs text-slate-500 focus:ring-0 italic" placeholder="Note..." type="text" value="Excellent travail"/>
</td>
</tr>
<!-- Row 5 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-medium text-slate-500">23G00761</td>
<td class="px-6 py-4 text-sm font-bold">FOTSO Karelle</td>
<td class="px-6 py-4 text-right">
<input class="w-20 text-right bg-surface-container-low border-none rounded-md text-sm font-bold focus:bg-surface-container-lowest focus:ring-2 focus:ring-primary" max="20" min="0" step="0.25" type="number" value="09.50"/>
</td>
<td class="px-6 py-4 text-center">
<span class="px-3 py-1 rounded-full bg-tertiary-container text-on-tertiary-container text-[10px] font-bold uppercase tracking-wider">Rattrapage</span>
</td>
<td class="px-6 py-4">
<input class="w-full bg-transparent border-none text-xs text-slate-500 focus:ring-0 italic" placeholder="Note..." type="text" value="Proche de la moyenne"/>
</td>
</tr>
</tbody>
</table>
</div>
</section>
</div>
<!-- Right Section: Sidebar / UE Summary -->
<aside class="space-y-6">
<!-- UE Summary Card -->
<div class="bg-primary text-on-primary p-6 rounded-xl shadow-lg relative overflow-hidden">
<div class="absolute -right-4 -top-4 opacity-10">
<span class="material-symbols-outlined text-[120px]" data-icon="auto_stories">auto_stories</span>
</div>
<div class="relative z-10">
<h3 class="text-xs font-bold uppercase tracking-widest opacity-80 mb-4">Détails de l'UE</h3>
<div class="space-y-4">
<div class="flex justify-between items-end border-b border-white/20 pb-2">
<span class="text-sm">Coefficient EC</span>
<span class="text-2xl font-black">2.0</span>
</div>
<div class="flex justify-between items-end border-b border-white/20 pb-2">
<span class="text-sm">Crédits ECTS UE</span>
<span class="text-2xl font-black">6.0</span>
</div>
<div class="pt-2">
<span class="text-sm block opacity-80 mb-1">Moyenne de classe actuelle</span>
<div class="flex items-center gap-3">
<span class="text-3xl font-black tracking-tighter">12.20</span>
<span class="px-2 py-0.5 rounded bg-white/20 text-[10px] font-bold">+1.2 vs N-1</span>
</div>
</div>
</div>
</div>
</div>
<!-- Action Panel -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm space-y-3">
<h4 class="text-xs font-bold uppercase text-slate-400 mb-4">Actions de session</h4>
<button class="w-full flex items-center justify-center gap-2 py-3 bg-primary text-white text-sm font-bold rounded-lg hover:bg-primary-container transition-all shadow-md active:scale-95">
<span class="material-symbols-outlined text-[18px]">save</span>
                            Enregistrer les notes
                        </button>
<button class="w-full flex items-center justify-center gap-2 py-3 bg-surface-container text-on-surface-variant text-sm font-bold rounded-lg hover:bg-surface-container-highest transition-all active:scale-95">
<span class="material-symbols-outlined text-[18px]">download</span>
                            Exporter (Excel)
                        </button>
<button class="w-full flex items-center justify-center gap-2 py-3 text-error text-sm font-bold rounded-lg hover:bg-error-container/20 transition-all">
<span class="material-symbols-outlined text-[18px]">restart_alt</span>
                            Réinitialiser
                        </button>
</div>
<!-- Statistics Card -->
<div class="bg-surface-container-low p-6 rounded-xl">
<h4 class="text-xs font-bold uppercase text-on-surface-variant mb-4">Statistiques de Saisie</h4>
<div class="space-y-4">
<div>
<div class="flex justify-between text-[11px] font-bold mb-1">
<span>Taux de Réussite</span>
<span>60%</span>
</div>
<div class="w-full bg-surface-container-highest h-1.5 rounded-full">
<div class="bg-secondary w-[60%] h-full rounded-full"></div>
</div>
</div>
<div class="flex items-center justify-between text-xs">
<span class="text-slate-500">Étudiants saisis</span>
<span class="font-bold">5 / 35</span>
</div>
</div>
</div>
</aside>
</div>
</div>
</main>
<!-- Mobile Navigation (Authority: Shared Components JSON - Bottom Bar Pattern for Mobile) -->
<div class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-100 px-6 py-3 flex justify-between items-center z-50">
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined">dashboard</span>
<span class="text-[10px] font-medium">Tableau</span>
</button>
<button class="flex flex-col items-center gap-1 text-primary">
<span class="material-symbols-outlined">account_tree</span>
<span class="text-[10px] font-bold">Filières</span>
</button>
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined">grading</span>
<span class="text-[10px] font-medium">Notes</span>
</button>
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined">settings</span>
<span class="text-[10px] font-medium">Réglages</span>
</button>
</div>
</body></html>