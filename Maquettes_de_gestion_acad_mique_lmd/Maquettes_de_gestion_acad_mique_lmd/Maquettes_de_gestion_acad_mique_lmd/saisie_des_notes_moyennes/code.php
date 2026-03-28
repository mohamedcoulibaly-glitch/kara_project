<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .ghost-border-focus:focus-within {
            outline: 2px solid rgba(0, 63, 177, 0.2);
            background-color: #ffffff !important;
        }
    </style>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-surface-variant": "#434654",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "outline": "#737686",
                        "on-secondary-container": "#3d4e84",
                        "background": "#f7f9fb",
                        "primary-container": "#1a56db",
                        "primary-fixed-dim": "#b5c4ff",
                        "surface-bright": "#f7f9fb",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "secondary-fixed": "#dbe1ff",
                        "primary-fixed": "#dbe1ff",
                        "on-tertiary-container": "#ffd4c5",
                        "on-secondary": "#ffffff",
                        "on-background": "#191c1e",
                        "inverse-surface": "#2d3133",
                        "surface-variant": "#e0e3e5",
                        "tertiary-container": "#ad3b00",
                        "surface-container-highest": "#e0e3e5",
                        "surface-container": "#eceef0",
                        "tertiary": "#852b00",
                        "surface": "#f7f9fb",
                        "error": "#ba1a1a",
                        "on-secondary-fixed-variant": "#334479",
                        "secondary-container": "#b1c2ff",
                        "surface-dim": "#d8dadc",
                        "tertiary-fixed-dim": "#ffb59a",
                        "surface-container-lowest": "#ffffff",
                        "on-error-container": "#93000a",
                        "surface-tint": "#1353d8",
                        "secondary": "#4b5c92",
                        "on-secondary-fixed": "#01174b",
                        "on-primary-container": "#d4dcff",
                        "primary": "#003fb1",
                        "outline-variant": "#c3c5d7",
                        "inverse-primary": "#b5c4ff",
                        "tertiary-fixed": "#ffdbcf",
                        "on-surface": "#191c1e",
                        "secondary-fixed-dim": "#b5c4ff",
                        "surface-container-high": "#e6e8ea",
                        "on-tertiary-fixed": "#380d00",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#003dab",
                        "on-tertiary-fixed-variant": "#802a00",
                        "on-primary-fixed": "#00174d",
                        "surface-container-low": "#f2f4f6"
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
                },
            },
        }
    </script>
</head>
<body class="bg-surface text-on-surface min-h-screen">
<!-- TopAppBar -->
<header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md fixed top-0 w-full z-50 shadow-sm dark:shadow-none">
<div class="flex justify-between items-center px-6 h-16 w-full">
<div class="flex items-center gap-8">
<span class="text-xl font-bold tracking-tight text-blue-700 dark:text-blue-400">LMD Académique</span>
<div class="hidden md:flex items-center bg-surface-container-low px-3 py-1.5 rounded-md gap-2">
<span class="material-symbols-outlined text-outline text-sm">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-64" placeholder="Rechercher un étudiant..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<div class="flex items-center gap-2 text-slate-500 hover:bg-slate-100 p-2 rounded-lg transition-colors cursor-pointer">
<span class="material-symbols-outlined">help_outline</span>
<span class="text-sm font-medium">Aide</span>
</div>
<div class="flex items-center gap-3 border-l border-outline-variant pl-4">
<span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:bg-slate-100 p-2 rounded-lg transition-colors">notifications</span>
<span class="material-symbols-outlined text-on-surface-variant cursor-pointer hover:bg-slate-100 p-2 rounded-lg transition-colors">settings</span>
<div class="w-8 h-8 rounded-full overflow-hidden bg-primary-container flex items-center justify-center">
<img alt="Photo de profil de l'administrateur" class="w-full h-full object-cover" data-alt="Portrait photo of an academic administrator" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBe8wh2OtvCpK1FUNJtemqzOrGZ0JHuLyTf8AAzzFEjlCtV-NsM7sRMAZFu2LWxCNoBBsFp0BUAKsi-_APJhynf1cU9c5Q-gc-RVBw9OhDPnC_cP8526H1h9NMGj1Tb4msNlLDKR90BE28827PBwyIOCK9hWHs-BS9soTjgzPceuHpwsdQWTs-jiGF39FcpJTl2KTAhFy7ETP5n0PCUw39NNxeAH-R-HoEGTRPgOgOzPYdAkziV7ntunZuCLvb4JIL68rv-Rjh3xPI"/>
</div>
</div>
</div>
</div>
</header>
<!-- SideNavBar -->
<aside class="fixed left-0 top-0 h-full w-64 bg-slate-50 dark:bg-slate-950 py-6 px-4 flex flex-col gap-2 z-40 mt-16">
<div class="mb-8 px-2">
<div class="flex items-center gap-3">
<div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-on-primary">
<span class="material-symbols-outlined">school</span>
</div>
<div>
<h2 class="font-black text-blue-800 dark:text-blue-300 text-sm leading-tight uppercase tracking-wider">Portail Académique</h2>
<p class="text-xs text-slate-500">Gestion LMD v2.0</p>
</div>
</div>
</div>
<nav class="flex-1 flex flex-col gap-1">
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all group rounded-lg" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">dashboard</span>
<span class="text-sm font-medium">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all group rounded-lg" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">account_tree</span>
<span class="text-sm font-medium">Filières</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all group rounded-lg" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">group</span>
<span class="text-sm font-medium">Étudiants</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 bg-white dark:bg-slate-800 text-blue-700 dark:text-blue-300 shadow-sm rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">edit_note</span>
<span class="text-sm font-semibold">Notes</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all group rounded-lg" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">settings</span>
<span class="text-sm font-medium">Paramètres</span>
</a>
</nav>
<div class="mt-auto pt-6 border-t border-outline-variant/20">
<a class="flex items-center gap-3 px-4 py-3 text-error hover:bg-error-container/20 transition-all rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">logout</span>
<span class="text-sm font-medium">Déconnexion</span>
</a>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
<div>
<h1 class="text-2xl font-bold text-on-background tracking-tight">Saisie des Notes</h1>
<p class="text-on-surface-variant text-sm mt-1">Évaluation continue et examen final</p>
</div>
<div class="flex items-center gap-3">
<button class="bg-surface-container-low text-on-surface font-medium px-4 py-2 rounded-md flex items-center gap-2 hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined text-lg">download</span>
<span>Importer CSV</span>
</button>
<button class="bg-primary text-on-primary font-semibold px-6 py-2 rounded-md shadow-md flex items-center gap-2 hover:bg-primary-container transition-all active:scale-95">
<span class="material-symbols-outlined text-lg">save</span>
<span>Enregistrer les notes</span>
</button>
</div>
</div>
<!-- Selection Bar -->
<div class="bg-surface-container-low p-4 rounded-xl mb-8 flex flex-wrap gap-6 items-center">
<div class="flex flex-col gap-1">
<label class="text-[10px] uppercase font-bold text-outline tracking-wider px-1">Filière</label>
<div class="bg-surface-container-lowest px-3 py-2 rounded-md flex items-center gap-2 min-w-[140px] shadow-sm">
<span class="material-symbols-outlined text-blue-600 text-sm">school</span>
<span class="text-sm font-semibold">L1 Informatique</span>
</div>
</div>
<span class="material-symbols-outlined text-outline-variant">chevron_right</span>
<div class="flex flex-col gap-1">
<label class="text-[10px] uppercase font-bold text-outline tracking-wider px-1">Unité d'Enseignement (UE)</label>
<div class="bg-surface-container-lowest px-3 py-2 rounded-md flex items-center gap-2 min-w-[180px] shadow-sm">
<span class="material-symbols-outlined text-blue-600 text-sm">calculate</span>
<span class="text-sm font-semibold">Mathématiques I</span>
</div>
</div>
<span class="material-symbols-outlined text-outline-variant">chevron_right</span>
<div class="flex flex-col gap-1">
<label class="text-[10px] uppercase font-bold text-outline tracking-wider px-1">Élément Constitutif (EC)</label>
<div class="bg-surface-container-lowest border-2 border-primary/20 px-3 py-2 rounded-md flex items-center gap-2 min-w-[140px] shadow-sm">
<span class="material-symbols-outlined text-blue-600 text-sm">functions</span>
<span class="text-sm font-semibold">Algèbre</span>
</div>
</div>
<div class="ml-auto flex items-center gap-4">
<div class="h-10 w-[1px] bg-outline-variant/30"></div>
<div class="flex flex-col items-end">
<span class="text-[10px] uppercase font-bold text-outline tracking-wider">Crédits</span>
<span class="text-lg font-black text-primary">6 ECTS</span>
</div>
</div>
</div>
<!-- Data Grid -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant/10">
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-24">Matricule</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest">Nom &amp; Prénom</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-40">Session</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-48 text-right">Note / 20</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-32 text-center">Statut</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF001</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">AMADOU Bakary</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="14.50"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">Validé</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF002</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">BERNARD Sophie</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="16.75"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">Validé</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF003</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">DIARRA Mamadou</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-error ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="08.00"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-tertiary-container text-on-tertiary-container">Rattrapage</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF004</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">KOVAC Elena</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="12.25"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">Validé</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF005</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">NGUYEN Anh</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none border-b-2 border-primary-fixed-dim/30" max="20" min="0" placeholder="--" step="0.25" type="number"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-surface-variant text-on-surface-variant">En attente</span>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Footer Highlight Stats -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="bg-white p-6 rounded-xl shadow-sm flex items-center justify-between border-l-4 border-primary">
<div>
<p class="text-[11px] font-bold text-outline uppercase tracking-wider">Moyenne de l'EC</p>
<h3 class="text-3xl font-black text-on-background mt-1">12.88 <span class="text-sm font-medium text-outline">/ 20</span></h3>
</div>
<div class="w-12 h-12 rounded-full bg-primary-container/10 flex items-center justify-center">
<span class="material-symbols-outlined text-primary">trending_up</span>
</div>
</div>
<div class="bg-white p-6 rounded-xl shadow-sm flex items-center justify-between border-l-4 border-secondary">
<div>
<p class="text-[11px] font-bold text-outline uppercase tracking-wider">Taux de Réussite</p>
<h3 class="text-3xl font-black text-on-background mt-1">75%</h3>
</div>
<div class="w-12 h-12 rounded-full bg-secondary-container/10 flex items-center justify-center">
<span class="material-symbols-outlined text-secondary">analytics</span>
</div>
</div>
<div class="bg-primary p-6 rounded-xl shadow-lg flex items-center justify-between">
<div>
<p class="text-[11px] font-bold text-primary-fixed-dim uppercase tracking-wider">Moyenne Pondérée UE</p>
<h3 class="text-3xl font-black text-white mt-1">13.45 <span class="text-sm font-medium text-primary-fixed-dim">/ 20</span></h3>
</div>
<div class="flex flex-col items-center">
<span class="text-[10px] font-bold text-white uppercase mb-1">Status UE</span>
<span class="px-3 py-1 bg-white text-primary text-[10px] font-black rounded-full uppercase tracking-tighter">Validée</span>
</div>
</div>
</div>
<!-- Floating Action Indicator (Visual only) -->
<div class="fixed bottom-8 right-8 flex flex-col items-end gap-2 pointer-events-none opacity-0 md:opacity-100">
<div class="bg-on-background text-white px-4 py-2 rounded-lg text-xs font-medium shadow-2xl flex items-center gap-2">
<span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Toutes les modifications sont synchronisées localement
            </div>
</div>
</main>
</body></html>