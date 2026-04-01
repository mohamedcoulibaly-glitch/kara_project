<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>LMD AcadÃ©mique - Tableau de Bord</title>
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
                    fontFamily: {
                        "headline": ["Inter", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"]
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
                },
            },
        }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-surface text-on-surface font-body antialiased">
<!-- SideNavBar Shell -->
<aside class="fixed left-0 top-0 h-full w-64 bg-slate-50 dark:bg-slate-950 flex flex-col py-6 px-4 gap-2 z-50">
<div class="mb-8 px-2">
<h1 class="font-black text-blue-800 dark:text-blue-300 text-xl tracking-tight">Portail AcadÃ©mique</h1>
<p class="text-xs text-slate-500 font-medium">Gestion LMD v2.0</p>
</div>
<nav class="flex-1 space-y-1">
<!-- Active State: Dashboard -->
<a class="flex items-center gap-3 px-3 py-2.5 bg-white dark:bg-slate-800 text-blue-700 dark:text-blue-300 shadow-sm rounded-lg group transition-all" href="#">
<span class="material-symbols-outlined text-[22px]">dashboard</span>
<span class="text-sm font-medium Inter group-hover:translate-x-1 duration-200">Dashboard</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg group transition-all" href="#">
<span class="material-symbols-outlined text-[22px]">account_tree</span>
<span class="text-sm font-medium Inter group-hover:translate-x-1 duration-200">FiliÃ¨res</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg group transition-all" href="#">
<span class="material-symbols-outlined text-[22px]">group</span>
<span class="text-sm font-medium Inter group-hover:translate-x-1 duration-200">Ã‰tudiants</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg group transition-all" href="#">
<span class="material-symbols-outlined text-[22px]">edit_note</span>
<span class="text-sm font-medium Inter group-hover:translate-x-1 duration-200">Notes</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 rounded-lg group transition-all" href="#">
<span class="material-symbols-outlined text-[22px]">settings</span>
<span class="text-sm font-medium Inter group-hover:translate-x-1 duration-200">ParamÃ¨tres</span>
</a>
</nav>
<div class="mt-auto pt-6 border-t border-slate-200 dark:border-slate-800 space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-error dark:hover:text-error rounded-lg group transition-all" href="#">
<span class="material-symbols-outlined text-[22px]">logout</span>
<span class="text-sm font-medium Inter group-hover:translate-x-1 duration-200">DÃ©connexion</span>
</a>
</div>
</aside>
<!-- TopAppBar Shell -->
<header class="fixed top-0 right-0 left-64 h-16 glass-header z-40 flex justify-between items-center px-8 shadow-sm dark:shadow-none">
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Rechercher un Ã©tudiant, une UE..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<button class="relative p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
</button>
<button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
<span class="material-symbols-outlined">settings</span>
</button>
<div class="h-8 w-[1px] bg-slate-200"></div>
<div class="flex items-center gap-3 cursor-pointer group">
<div class="text-right">
<p class="text-sm font-bold text-slate-900 leading-none">Admin AcadÃ©mique</p>
<p class="text-xs text-slate-500">Direction des Ã©tudes</p>
</div>
<img class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group-hover:ring-primary/30 transition-all" data-alt="Photo de profil de l'administrateur" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDi9zIyfvuLhLL9A5A5v3bC3rZiqhJmyDory4-5v8cNz8pCyHhHH6oro-lZLNDd6QfMAqKYpn67Eke6YVGrIhEB2PbuTiCYJ9fyEAcIuF0FFiZ8rPteezeK0pjPQz2M6wFgKeBVTG7EzFYqNyRB8dRmrWGHhTzMQGiG9ynzeAiJjRpnpZXz04ExQ0_awb7GjKTkcWNiuSG3yIxJQeNGxkrK7GNeGSduGxvU4zcAb2zww9FLwiMCEDtiA4GMVww7ebxaxmFeDAPZeCs"/>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="pl-64 pt-16 min-h-screen">
<div class="p-8 max-w-7xl mx-auto space-y-8">
<!-- Page Header -->
<div class="flex justify-between items-end">
<div>
<h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Tableau de Bord</h2>
<p class="text-slate-500 mt-1">AperÃ§u analytique de la performance acadÃ©mique LMD.</p>
</div>
<div class="flex gap-3">
<button class="bg-surface-container-low text-on-surface px-4 py-2 rounded-md text-sm font-semibold hover:bg-surface-container-high transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-lg">download</span>
                        Exporter le rapport
                    </button>
<button class="bg-primary text-white px-4 py-2 rounded-md text-sm font-semibold hover:opacity-90 transition-opacity flex items-center gap-2 shadow-lg shadow-primary/20">
<span class="material-symbols-outlined text-lg">add</span>
                        Nouvelle saisie
                    </button>
</div>
</div>
<!-- Bento Grid Widgets -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
<!-- Widget: Total Students -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">group</span>
</div>
<span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+4%</span>
</div>
<div>
<p class="text-3xl font-extrabold tracking-tighter">540</p>
<p class="text-sm font-medium text-slate-500">Ã‰tudiants inscrits</p>
</div>
</div>
<!-- Widget: Success Rate -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-secondary-container/20 rounded-lg text-secondary">
<span class="material-symbols-outlined">trending_up</span>
</div>
<span class="text-xs font-bold text-primary-container bg-primary/10 px-2 py-1 rounded-full">Stable</span>
</div>
<div>
<p class="text-3xl font-extrabold tracking-tighter">78%</p>
<p class="text-sm font-medium text-slate-500">Taux de rÃ©ussite global</p>
</div>
</div>
<!-- Widget: Branches -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-tertiary-fixed-dim/30 rounded-lg text-tertiary">
<span class="material-symbols-outlined">account_tree</span>
</div>
</div>
<div>
<p class="text-3xl font-extrabold tracking-tighter">8</p>
<p class="text-sm font-medium text-slate-500">FiliÃ¨res actives</p>
</div>
</div>
<!-- Widget: Difficult UE -->
<div class="bg-slate-900 text-white p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.1)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-white/10 rounded-lg text-white">
<span class="material-symbols-outlined">warning</span>
</div>
</div>
<div>
<div class="flex gap-2 flex-wrap mb-1">
<span class="text-[10px] font-bold uppercase tracking-wider bg-error/20 text-error-container px-2 py-0.5 rounded">Maths I</span>
<span class="text-[10px] font-bold uppercase tracking-wider bg-error/20 text-error-container px-2 py-0.5 rounded">Algorithmique</span>
</div>
<p class="text-sm font-medium text-slate-300">UE les plus critiques</p>
</div>
</div>
</div>
<!-- Main Analytics Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Performance Graph Area -->
<div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-8 shadow-[0_12px_32px_rgba(25,28,30,0.04)]">
<div class="flex justify-between items-center mb-10">
<h3 class="text-lg font-bold">Ã‰volution des Moyennes</h3>
<select class="bg-surface-container-low border-none text-xs font-bold rounded-md px-3 py-1.5 focus:ring-0">
<option>Semestre 1 - 2023</option>
<option>Semestre 2 - 2023</option>
</select>
</div>
<!-- SVG Chart Mockup -->
<div class="relative h-[300px] w-full mt-4">
<svg class="w-full h-full" viewbox="0 0 800 300">
<!-- Grid lines -->
<line stroke="#f2f4f6" stroke-width="1" x1="0" x2="800" y1="50" y2="50"></line>
<line stroke="#f2f4f6" stroke-width="1" x1="0" x2="800" y1="150" y2="150"></line>
<line stroke="#f2f4f6" stroke-width="1" x1="0" x2="800" y1="250" y2="250"></line>
<!-- Area Gradient -->
<defs>
<lineargradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
<stop offset="0%" stop-color="#1a56db" stop-opacity="0.1"></stop>
<stop offset="100%" stop-color="#1a56db" stop-opacity="0"></stop>
</lineargradient>
</defs>
<!-- Main Path -->
<path d="M0,220 Q100,200 200,180 T400,140 T600,160 T800,100" fill="none" stroke="#1a56db" stroke-linecap="round" stroke-width="3"></path>
<path d="M0,220 Q100,200 200,180 T400,140 T600,160 T800,100 L800,300 L0,300 Z" fill="url(#chartGradient)"></path>
<!-- Data Points -->
<circle cx="200" cy="180" fill="#1a56db" r="4"></circle>
<circle cx="400" cy="140" fill="#1a56db" r="4"></circle>
<circle cx="600" cy="160" fill="#1a56db" r="4"></circle>
<circle cx="800" cy="100" fill="#1a56db" r="4"></circle>
</svg>
<!-- Axis Labels -->
<div class="flex justify-between mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
<span>Octobre</span>
<span>Novembre</span>
<span>DÃ©cembre</span>
<span>Janvier</span>
<span>FÃ©vrier</span>
</div>
</div>
</div>
<!-- Side Activity: Recent Grades -->
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_12px_32px_rgba(25,28,30,0.04)]">
<div class="flex justify-between items-center mb-6">
<h3 class="text-lg font-bold">DerniÃ¨res Notes</h3>
<a class="text-xs font-bold text-primary hover:underline" href="#">Voir tout</a>
</div>
<div class="space-y-4">
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    AM
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">Alassane M.</p>
<p class="text-[11px] text-slate-500 font-medium">MathÃ©matiques I</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-primary">16.50</p>
<p class="text-[10px] text-slate-400">Il y a 10m</p>
</div>
</div>
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    SK
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">Sarah K.</p>
<p class="text-[11px] text-slate-500 font-medium">Algorithmique</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-error">08.25</p>
<p class="text-[10px] text-slate-400">Il y a 45m</p>
</div>
</div>
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    BJ
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">Bakary J.</p>
<p class="text-[11px] text-slate-500 font-medium">Anglais Tech.</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-primary">14.00</p>
<p class="text-[10px] text-slate-400">Il y a 1h</p>
</div>
</div>
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    CL
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">CÃ©cile L.</p>
<p class="text-[11px] text-slate-500 font-medium">Bases de DonnÃ©es</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-primary">19.00</p>
<p class="text-[10px] text-slate-400">Il y a 3h</p>
</div>
</div>
</div>
<div class="mt-8 pt-6 border-t border-slate-50">
<div class="bg-surface-container-low p-4 rounded-lg">
<p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Statut Saisie</p>
<div class="flex justify-between items-center text-sm font-medium">
<span class="text-slate-600">ProgrÃ¨s Saisie S1</span>
<span class="text-primary font-bold">92%</span>
</div>
<div class="w-full bg-white h-1.5 rounded-full mt-2">
<div class="bg-primary h-full rounded-full w-[92%] shadow-sm"></div>
</div>
</div>
</div>
</div>
</div>
<!-- Footer Section: Institutional Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-12">
<div class="bg-surface-container-low rounded-xl p-6 flex items-center gap-6">
<div class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
</div>
<div>
<h4 class="font-bold text-slate-900">Validation des Semestres</h4>
<p class="text-sm text-slate-500">65% des Ã©tudiants ont dÃ©jÃ  validÃ© l'intÃ©gralitÃ© de leurs UE du semestre en cours.</p>
</div>
</div>
<div class="bg-surface-container-low rounded-xl p-6 flex items-center gap-6">
<div class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center">
<span class="material-symbols-outlined text-secondary text-3xl">history_edu</span>
</div>
<div>
<h4 class="font-bold text-slate-900">Rattrapages PrÃ©visionnels</h4>
<p class="text-sm text-slate-500">Une baisse de 12% des passages en rattrapage est observÃ©e par rapport Ã  l'annÃ©e N-1.</p>
</div>
</div>
</div>
</div>
</main>
<!-- Contextual FAB (Suppressed based on layout rules for dashboard context focus, but kept empty for spacing if needed) -->
</body></html>
