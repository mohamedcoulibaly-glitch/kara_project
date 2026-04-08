<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Système LMD Académique - Délibération Finale</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            backdrop-filter: blur(12px);
            background-color: rgba(224, 227, 229, 0.8);
        }
        /* Custom scrollbar for data density */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #c3c5d7; border-radius: 10px; }
    </style>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-container-high": "#e6e8ea",
                        "error-container": "#ffdad6",
                        "primary-container": "#1a56db",
                        "secondary-container": "#b1c2ff",
                        "on-background": "#191c1e",
                        "inverse-primary": "#b5c4ff",
                        "tertiary-fixed-dim": "#ffb59a",
                        "on-secondary": "#ffffff",
                        "on-primary-container": "#d4dcff",
                        "primary-fixed": "#dbe1ff",
                        "on-tertiary": "#ffffff",
                        "surface-container-highest": "#e0e3e5",
                        "error": "#ba1a1a",
                        "tertiary": "#852b00",
                        "primary": "#003fb1",
                        "on-primary-fixed-variant": "#003dab",
                        "primary-fixed-dim": "#b5c4ff",
                        "on-surface-variant": "#434654",
                        "on-secondary-container": "#3d4e84",
                        "on-primary": "#ffffff",
                        "surface-dim": "#d8dadc",
                        "surface": "#f7f9fb",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#f2f4f6",
                        "background": "#f7f9fb",
                        "outline-variant": "#c3c5d7",
                        "secondary": "#4b5c92",
                        "secondary-fixed": "#dbe1ff",
                        "tertiary-container": "#ad3b00",
                        "surface-tint": "#1353d8",
                        "secondary-fixed-dim": "#b5c4ff",
                        "surface-variant": "#e0e3e5",
                        "on-surface": "#191c1e",
                        "on-primary-fixed": "#00174d",
                        "on-error": "#ffffff",
                        "on-tertiary-fixed": "#380d00",
                        "inverse-on-surface": "#eff1f3",
                        "outline": "#737686",
                        "on-tertiary-fixed-variant": "#802a00",
                        "on-tertiary-container": "#ffd4c5",
                        "on-secondary-fixed-variant": "#334479",
                        "surface-container": "#eceef0",
                        "inverse-surface": "#2d3133",
                        "surface-container-lowest": "#ffffff",
                        "tertiary-fixed": "#ffdbcf",
                        "surface-bright": "#f7f9fb",
                        "on-secondary-fixed": "#01174b"
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
                },
            },
        }
    </script>
</head>
<body class="bg-surface text-on-surface min-h-screen flex">
<!-- SideNavBar (from Shared Components JSON) -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r border-slate-200 bg-slate-50 flex flex-col py-4 space-y-2 z-50">
<div class="px-6 mb-8">
<h1 class="text-lg font-black text-blue-900">Portail Académique</h1>
<p class="text-xs text-slate-500 font-medium">Gestion LMD v2.0</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-200" href="#">
<span class="material-symbols-outlined mr-3" data-icon="dashboard">dashboard</span>
<span class="font-semibold text-sm">Tableau de bord</span>
</a>
<a class="flex items-center px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-200" href="#">
<span class="material-symbols-outlined mr-3" data-icon="account_tree">account_tree</span>
<span class="font-semibold text-sm">Filières</span>
</a>
<a class="flex items-center px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-200" href="#">
<span class="material-symbols-outlined mr-3" data-icon="school">school</span>
<span class="font-semibold text-sm">Étudiants</span>
</a>
<a class="flex items-center px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-200" href="#">
<span class="material-symbols-outlined mr-3" data-icon="grade">grade</span>
<span class="font-semibold text-sm">Notes</span>
</a>
<a class="flex items-center px-4 py-2.5 mx-2 text-slate-600 hover:bg-slate-100 rounded-lg transition-all duration-200" href="#">
<span class="material-symbols-outlined mr-3" data-icon="history_edu">history_edu</span>
<span class="font-semibold text-sm">Rattrapages</span>
</a>
<!-- ACTIVE TAB: DÉLIBÉRATION -->
<a class="flex items-center px-4 py-2.5 bg-blue-50 text-blue-700 rounded-lg mx-2 transition-all duration-200" href="#">
<span class="material-symbols-outlined mr-3" data-icon="gavel" style="font-variation-settings: 'FILL' 1;">gavel</span>
<span class="font-semibold text-sm">Délibération</span>
</a>
</nav>
<div class="mt-auto pt-4 border-t border-slate-200 mx-4">
<a class="flex items-center px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg" href="#">
<span class="material-symbols-outlined mr-3" data-icon="help">help</span>
<span class="text-sm font-semibold">Aide</span>
</a>
<a class="flex items-center px-4 py-2 text-slate-600 hover:bg-slate-100 rounded-lg" href="#">
<span class="material-symbols-outlined mr-3" data-icon="logout">logout</span>
<span class="text-sm font-semibold">Déconnexion</span>
</a>
</div>
</aside>
<!-- Main Content Area -->
<main class="ml-64 flex-1 flex flex-col min-h-screen">
<!-- TopNavBar (from Shared Components JSON) -->
<header class="w-full sticky top-0 z-40 bg-white shadow-sm flex justify-between items-center px-6 py-3">
<div class="flex items-center">
<div class="relative">
<span class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-400">
<span class="material-symbols-outlined text-sm" data-icon="search">search</span>
</span>
<input class="bg-slate-100 border-none rounded-md py-1.5 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary w-64 transition-all" placeholder="Rechercher un PV..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
<div class="h-8 w-px bg-slate-100 mx-2"></div>
<div class="flex items-center gap-3">
<div class="text-right">
<p class="text-xs font-bold text-on-surface">Dr. Kouamé</p>
<p class="text-[10px] text-slate-500 font-medium">Président du Jury</p>
</div>
<img class="w-10 h-10 rounded-full border-2 border-primary/10 object-cover" data-alt="Photo de profil de l'administrateur" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAvmGtF0UG8sNAirPxe2EKzqD8Jr8jYBtVOfc4nRFpxXstxTDfotlzV_JbTlSkMJqqPm4_7PWNYuD4PDIU0eW95pQ7lOgYotaWPl3IsKtW-DOytsHA6lc2mBKIymh8-fGHVEljWBgHPj1XweqHhZOYhSml_hDqR2_jfN4m42-2WRN2Pe66edJOobqa_XBxUJ7Gtek7GbK2txCMzVsSvg9NLzkWema-Wij0KTqBk2SpR-aqSVjTCfYwXeqJJGpuZcTLV97W0LKQlftA"/>
</div>
</div>
</header>
<!-- Content Canvas -->
<div class="p-8 space-y-8 max-w-[1600px] mx-auto w-full">
<!-- Header & Context -->
<div class="flex justify-between items-end">
<div class="space-y-1">
<h2 class="text-3xl font-black tracking-tight text-primary">Procès-Verbal de Délibération</h2>
<div class="flex items-center gap-3">
<span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-xs font-bold tracking-wide uppercase">Session Normale</span>
<span class="text-slate-400 font-medium">|</span>
<span class="text-on-surface-variant font-semibold text-sm">Semestre 1 • Année Académique 2023-2024</span>
</div>
</div>
<div class="flex gap-3">
<button class="flex items-center gap-2 px-4 py-2 bg-surface-container-low text-on-surface-variant font-bold text-sm rounded-md hover:bg-surface-container-high transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="upload_file">upload_file</span>
                        Importer les résultats
                    </button>
<button class="flex items-center gap-2 px-4 py-2 bg-secondary text-white font-bold text-sm rounded-md hover:bg-secondary/90 transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="picture_as_pdf">picture_as_pdf</span>
                        Exporter le PV (PDF)
                    </button>
<button class="flex items-center gap-2 px-5 py-2 bg-primary text-white font-bold text-sm rounded-md hover:shadow-lg hover:shadow-primary/20 transition-all">
<span class="material-symbols-outlined text-lg" data-icon="lock">lock</span>
                        Clôturer la délibération
                    </button>
</div>
</div>
<!-- Bento Statistics Grid -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 flex flex-col justify-between">
<p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-4">Taux d'admission</p>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-primary">78.4%</span>
<span class="text-secondary text-xs font-bold">+2.1% vs S1-22</span>
</div>
<div class="w-full bg-surface-container-low h-1.5 rounded-full mt-4">
<div class="bg-primary h-1.5 rounded-full" style="width: 78.4%"></div>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 flex flex-col justify-between">
<p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-4">Rattrapages</p>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-tertiary">24</span>
<span class="text-slate-400 text-xs font-medium">étudiants concernés</span>
</div>
<p class="text-[10px] text-tertiary font-bold mt-4 uppercase">Traitement prioritaire requis</p>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 flex flex-col justify-between">
<p class="text-slate-500 text-xs font-bold uppercase tracking-widest mb-4">Moyenne la plus haute</p>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-on-surface">17.82</span>
<span class="text-slate-400 text-xs font-medium">/ 20</span>
</div>
<div class="flex items-center gap-2 mt-4">
<img class="w-6 h-6 rounded-full object-cover" data-alt="Portrait major de promo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD3VSn0IqV3VHl9N85Jzw4k6e0_oo7yNdsq4ID0iTgB3878cUOZ8HMDNOxk6zbBZ-38BO_bmq-gP83xS1jozqeb0a1RPNMerT6E5W0gzPTh72vnlI2g7axQ7Ox0cDfqDTV4zGVFiIcDIqtB3vOk1J479Zw8tQhWxvI5I_IaL3pEhdOa5sM4MMeFtUZvwPH9feeSL99wrJJszaw00ViyEF1sWNVKGCPMsCBjkueQE53yKkQSQTbGQKFyGvz4AJeUqO89IKN03i4AThk"/>
<span class="text-[10px] font-bold text-primary truncate">SYLLA Mariam (INFO-2023-01)</span>
</div>
</div>
<div class="bg-primary p-6 rounded-xl shadow-md flex flex-col justify-center items-center text-center">
<span class="material-symbols-outlined text-white/50 text-4xl mb-2" data-icon="verified">verified</span>
<p class="text-white text-xs font-bold uppercase tracking-widest opacity-80">Statut du Procès</p>
<p class="text-white text-xl font-bold mt-1">En cours de validation</p>
</div>
</div>
<!-- Filters & Controls -->
<div class="bg-surface-container-low p-4 rounded-lg flex flex-wrap items-center gap-6">
<div class="flex flex-col gap-1.5 min-w-[200px]">
<label class="text-[10px] font-bold text-slate-500 uppercase px-1">Département</label>
<select class="bg-surface-container-lowest border-none rounded-md text-sm font-semibold text-on-surface py-2 px-3 focus:ring-2 focus:ring-primary">
<option>Sciences de l'Ingénieur</option>
<option>Mathématiques et Info</option>
</select>
</div>
<div class="flex flex-col gap-1.5 min-w-[200px]">
<label class="text-[10px] font-bold text-slate-500 uppercase px-1">Filière</label>
<select class="bg-surface-container-lowest border-none rounded-md text-sm font-semibold text-on-surface py-2 px-3 focus:ring-2 focus:ring-primary">
<option>Informatique de Gestion (L3)</option>
<option>Réseaux et Télécoms (L3)</option>
</select>
</div>
<div class="flex flex-col gap-1.5 min-w-[150px]">
<label class="text-[10px] font-bold text-slate-500 uppercase px-1">Semestre</label>
<select class="bg-surface-container-lowest border-none rounded-md text-sm font-semibold text-on-surface py-2 px-3 focus:ring-2 focus:ring-primary">
<option>Semestre 1</option>
<option>Semestre 2</option>
</select>
</div>
<div class="h-10 w-px bg-outline-variant/30 ml-auto hidden lg:block"></div>
<div class="flex items-center gap-2 bg-surface-container-lowest p-1 rounded-md">
<button class="px-4 py-1.5 bg-primary text-white rounded shadow-sm text-xs font-bold">Liste complète</button>
<button class="px-4 py-1.5 text-slate-500 hover:bg-slate-50 rounded text-xs font-bold transition-colors">Admis</button>
<button class="px-4 py-1.5 text-slate-500 hover:bg-slate-50 rounded text-xs font-bold transition-colors">Rattrapages</button>
</div>
</div>
<!-- Data Table Section -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm border border-outline-variant/10">
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low/50">
<th class="py-4 px-6 text-[11px] font-black text-slate-500 uppercase tracking-wider">Matricule</th>
<th class="py-4 px-6 text-[11px] font-black text-slate-500 uppercase tracking-wider">Nom &amp; Prénom</th>
<th class="py-4 px-4 text-[11px] font-black text-slate-500 uppercase tracking-wider text-center bg-primary/5">UE Base (Coeff 4)</th>
<th class="py-4 px-4 text-[11px] font-black text-slate-500 uppercase tracking-wider text-center bg-primary/5">UE Spé (Coeff 6)</th>
<th class="py-4 px-4 text-[11px] font-black text-slate-500 uppercase tracking-wider text-center bg-primary/5">UE Transv (Coeff 2)</th>
<th class="py-4 px-6 text-[11px] font-black text-primary uppercase tracking-wider text-right">MG Semestre</th>
<th class="py-4 px-6 text-[11px] font-black text-slate-500 uppercase tracking-wider text-center">Crédits ECTS</th>
<th class="py-4 px-6 text-[11px] font-black text-slate-500 uppercase tracking-wider">Décision du Jury</th>
</tr>
</thead>
<tbody class="divide-y divide-slate-50">
<!-- Student Row 1 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-6 text-sm font-bold text-primary tracking-tight">INF23001</td>
<td class="py-4 px-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">ABDOULAYE Fatoumata</span>
<span class="text-[10px] text-slate-400 font-medium">Née le 12/05/2002</span>
</div>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">14.50</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">16.20</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">12.00</span>
</td>
<td class="py-4 px-6 text-right">
<span class="text-base font-black text-primary">14.93</span>
</td>
<td class="py-4 px-6 text-center">
<span class="text-xs font-bold text-secondary bg-secondary-container/20 px-2 py-1 rounded">30 / 30</span>
</td>
<td class="py-4 px-6">
<span class="bg-secondary-container text-on-secondary-container text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">ADMIS</span>
</td>
</tr>
<!-- Student Row 2 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-6 text-sm font-bold text-primary tracking-tight">INF23002</td>
<td class="py-4 px-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">DIOP Moussa</span>
<span class="text-[10px] text-slate-400 font-medium">Né le 05/09/2001</span>
</div>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-tertiary">08.40</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">10.15</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">11.00</span>
</td>
<td class="py-4 px-6 text-right">
<span class="text-base font-black text-on-surface">09.71</span>
</td>
<td class="py-4 px-6 text-center">
<span class="text-xs font-bold text-tertiary bg-tertiary-container/10 px-2 py-1 rounded">18 / 30</span>
</td>
<td class="py-4 px-6">
<span class="bg-tertiary-container text-on-tertiary-container text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">RATTRAPAGE</span>
</td>
</tr>
<!-- Student Row 3 -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-6 text-sm font-bold text-primary tracking-tight">INF23003</td>
<td class="py-4 px-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">GOMEZ Catherine</span>
<span class="text-[10px] text-slate-400 font-medium">Née le 22/02/2002</span>
</div>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">12.00</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">11.45</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">13.50</span>
</td>
<td class="py-4 px-6 text-right">
<span class="text-base font-black text-primary">11.98</span>
</td>
<td class="py-4 px-6 text-center">
<span class="text-xs font-bold text-secondary bg-secondary-container/20 px-2 py-1 rounded">30 / 30</span>
</td>
<td class="py-4 px-6">
<span class="bg-secondary-container text-on-secondary-container text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">ADMIS</span>
</td>
</tr>
<!-- Student Row 4 (Warning State) -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-6 text-sm font-bold text-primary tracking-tight">INF23004</td>
<td class="py-4 px-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">N'GORAN Jean-Eudes</span>
<span class="text-[10px] text-slate-400 font-medium">Né le 30/11/2000</span>
</div>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-error">04.50</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-error">06.20</span>
</td>
<td class="py-4 px-4 text-center">
<span class="text-sm font-semibold text-on-surface">10.00</span>
</td>
<td class="py-4 px-6 text-right">
<span class="text-base font-black text-error">06.26</span>
</td>
<td class="py-4 px-6 text-center">
<span class="text-xs font-bold text-error bg-error-container/20 px-2 py-1 rounded">04 / 30</span>
</td>
<td class="py-4 px-6">
<span class="bg-error text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">EXCLU</span>
</td>
</tr>
<!-- Repeatable Rows Simulation -->
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-6 text-sm font-bold text-primary tracking-tight">INF23005</td>
<td class="py-4 px-6">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">TURE Salif</span>
<span class="text-[10px] text-slate-400 font-medium">Né le 15/03/2002</span>
</div>
</td>
<td class="py-4 px-4 text-center"><span class="text-sm font-semibold">11.00</span></td>
<td class="py-4 px-4 text-center"><span class="text-sm font-semibold">12.50</span></td>
<td class="py-4 px-4 text-center"><span class="text-sm font-semibold">10.00</span></td>
<td class="py-4 px-6 text-right"><span class="text-base font-black text-primary">11.58</span></td>
<td class="py-4 px-6 text-center"><span class="text-xs font-bold text-secondary bg-secondary-container/20 px-2 py-1 rounded">30 / 30</span></td>
<td class="py-4 px-6"><span class="bg-secondary-container text-on-secondary-container text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">ADMIS</span></td>
</tr>
</tbody>
</table>
</div>
<!-- Table Footer / Pagination -->
<div class="bg-surface-container-low/30 px-6 py-4 flex items-center justify-between border-t border-slate-50">
<p class="text-xs text-slate-500 font-semibold">Affichage de 1 à 10 sur 45 étudiants</p>
<div class="flex gap-1">
<button class="p-2 hover:bg-surface-container-high rounded transition-colors">
<span class="material-symbols-outlined text-sm" data-icon="chevron_left">chevron_left</span>
</button>
<button class="px-3 py-1 bg-primary text-white text-xs font-bold rounded">1</button>
<button class="px-3 py-1 hover:bg-surface-container-high text-xs font-bold rounded">2</button>
<button class="px-3 py-1 hover:bg-surface-container-high text-xs font-bold rounded">3</button>
<button class="p-2 hover:bg-surface-container-high rounded transition-colors">
<span class="material-symbols-outlined text-sm" data-icon="chevron_right">chevron_right</span>
</button>
</div>
</div>
</div>
<!-- Validation Info Box -->
<div class="bg-blue-50/50 p-6 rounded-xl border border-blue-100 flex items-start gap-4">
<div class="bg-blue-100 p-2 rounded-lg text-primary">
<span class="material-symbols-outlined" data-icon="info">info</span>
</div>
<div class="space-y-2">
<h4 class="text-sm font-bold text-blue-900">Note de calcul des moyennes</h4>
<p class="text-xs text-blue-800 leading-relaxed max-w-4xl">
                        Les moyennes sont calculées dynamiquement selon le modèle LMD : <span class="font-bold">MG = Σ(Note × Coeff) / Σ(Coeffs)</span>. 
                        Un étudiant est déclaré "ADMIS" s'il obtient une moyenne générale ≥ 10/20 et valide l'ensemble de ses crédits ECTS (30). 
                        Le passage en "RATTRAPAGE" est automatique pour toute UE non validée (note &lt; 10) sans compensation.
                    </p>
</div>
</div>
</div>
<!-- Footer Spacer -->
<footer class="mt-auto py-8 text-center text-slate-400 text-[10px] font-bold uppercase tracking-widest">
            © 2024 Horizon LMD System — Plateforme de Gouvernance Académique
        </footer>
</main>
<!-- FAB for quick action (Suppressed as per rules on detail/transaction pages, but here for context in main view) -->
<button class="fixed bottom-8 right-8 w-14 h-14 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50">
<span class="material-symbols-outlined text-3xl" data-icon="add">add</span>
</button>
</body></html>