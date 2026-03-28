<!DOCTYPE html>

<html lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "error-container": "#ffdad6",
              "on-primary-fixed": "#00174d",
              "surface-tint": "#1353d8",
              "primary-container": "#1a56db",
              "outline": "#737686",
              "on-surface": "#191c1e",
              "background": "#f7f9fb",
              "on-primary-fixed-variant": "#003dab",
              "surface-container": "#eceef0",
              "on-secondary": "#ffffff",
              "error": "#ba1a1a",
              "surface-container-highest": "#e0e3e5",
              "surface-variant": "#e0e3e5",
              "tertiary-container": "#ad3b00",
              "on-secondary-container": "#3d4e84",
              "outline-variant": "#c3c5d7",
              "inverse-primary": "#b5c4ff",
              "on-secondary-fixed": "#01174b",
              "secondary": "#4b5c92",
              "surface-container-high": "#e6e8ea",
              "on-tertiary": "#ffffff",
              "primary-fixed-dim": "#b5c4ff",
              "on-tertiary-fixed-variant": "#802a00",
              "on-primary-container": "#d4dcff",
              "surface-bright": "#f7f9fb",
              "on-error-container": "#93000a",
              "surface-container-low": "#f2f4f6",
              "inverse-on-surface": "#eff1f3",
              "tertiary-fixed": "#ffdbcf",
              "surface-container-lowest": "#ffffff",
              "secondary-fixed-dim": "#b5c4ff",
              "on-tertiary-fixed": "#380d00",
              "on-surface-variant": "#434654",
              "secondary-container": "#b1c2ff",
              "tertiary": "#852b00",
              "primary-fixed": "#dbe1ff",
              "surface": "#f7f9fb",
              "inverse-surface": "#2d3133",
              "on-background": "#191c1e",
              "surface-dim": "#d8dadc",
              "on-secondary-fixed-variant": "#334479",
              "on-primary": "#ffffff",
              "on-error": "#ffffff",
              "tertiary-fixed-dim": "#ffb59a",
              "secondary-fixed": "#dbe1ff",
              "on-tertiary-container": "#ffd4c5",
              "primary": "#003fb1"
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
    </style>
</head>
<body class="bg-surface text-on-surface flex min-h-screen">
<!-- SideNavBar (Mandatory Shell) -->
<aside class="hidden md:flex flex-col p-4 gap-2 h-screen w-64 border-r border-slate-200/50 bg-slate-50 sticky top-0">
<div class="mb-8 px-2">
<h1 class="text-lg font-black text-slate-900">Gestion LMD</h1>
<p class="text-xs text-slate-500 font-medium font-inter">Portail Décisionnel</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-100 transition-transform hover:translate-x-1 text-sm font-medium font-inter rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                Tableau de Bord
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-100 transition-transform hover:translate-x-1 text-sm font-medium font-inter rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="domain">domain</span>
                Départements
            </a>
<a class="flex items-center gap-3 px-3 py-2 bg-white text-blue-700 shadow-sm rounded-lg transition-transform hover:translate-x-1 text-sm font-medium font-inter" href="#">
<span class="material-symbols-outlined" data-icon="analytics" style="font-variation-settings: 'FILL' 1;">analytics</span>
                Statistiques
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-100 transition-transform hover:translate-x-1 text-sm font-medium font-inter rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="calendar_today">calendar_today</span>
                Années Académiques
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-100 transition-transform hover:translate-x-1 text-sm font-medium font-inter rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="description">description</span>
                Rapports
            </a>
</nav>
<button class="mt-4 bg-primary text-on-primary py-2 px-4 rounded-md text-sm font-semibold hover:bg-primary-container transition-colors shadow-sm">
            Exporter Données
        </button>
<div class="mt-auto pt-4 border-t border-slate-200/50 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-100 transition-transform hover:translate-x-1 text-sm font-medium font-inter rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="help">help</span>
                Aide
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-slate-100 transition-transform hover:translate-x-1 text-sm font-medium font-inter rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
                Déconnexion
            </a>
</div>
</aside>
<div class="flex-1 flex flex-col min-w-0">
<!-- TopAppBar (Mandatory Shell) -->
<header class="fixed top-0 w-full md:w-[calc(100%-16rem)] z-50 bg-white/80 backdrop-blur-md shadow-sm flex justify-between items-center px-6 h-16">
<div class="flex items-center gap-4">
<span class="text-xl font-bold text-blue-700 tracking-tight font-inter">Academia LMD</span>
</div>
<div class="flex items-center gap-6">
<div class="relative hidden sm:block">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" data-icon="search">search</span>
<input class="bg-slate-100 border-none rounded-md pl-10 pr-4 py-1.5 text-sm focus:ring-2 focus:ring-primary/20 w-64" placeholder="Rechercher..." type="text"/>
</div>
<div class="flex items-center gap-2">
<button class="p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
<div class="h-8 w-8 rounded-full bg-primary-container overflow-hidden ml-2 border border-outline-variant/20">
<img alt="Profil Administrateur" class="w-full h-full object-cover" data-alt="Avatar de l'administrateur système" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVUxjADK_fKpqKuivBQYpFAw7dzZffHnnp5lRy4qkn0_cBjY4tslTYzVsLs5aG2SB__Gx8PPpU-H9-op0uoxGWYnTOzv9VSPzu0p5XNhjsekTWMwNCsTtFM_BIaX0dr08BTImOafrsfXcgHrV6Af6lFMqghrRS7wH3ocDVNvaTBv7HYMCTTAd9ejwGDdh0s8MYxsmdWYe4GUNCKHnTS6HAAmb7C9WcJyvmfeOPsq4d1BwOJAOoEzyZhbFU2TQ9h-luhUnM06Qv4tU"/>
</div>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="mt-16 p-8 max-w-7xl mx-auto w-full">
<!-- Section 1: Header & Filters -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
<div>
<h2 class="text-3xl font-extrabold text-on-surface tracking-tight mb-1">Statistiques de Réussite par Département</h2>
<p class="text-on-surface-variant text-sm">Analyse comparative des performances académiques</p>
</div>
<div class="flex items-center gap-3 bg-surface-container-low p-1.5 rounded-xl shadow-sm">
<div class="flex items-center px-3 py-1.5 bg-surface-container-lowest rounded-lg shadow-sm">
<span class="material-symbols-outlined text-sm mr-2" data-icon="calendar_today">calendar_today</span>
<select class="bg-transparent border-none text-sm font-semibold p-0 focus:ring-0">
<option>Année 2023-2024</option>
<option>Année 2022-2023</option>
</select>
</div>
<button class="px-4 py-1.5 text-sm font-semibold text-primary hover:bg-primary/5 rounded-lg transition-colors">
                        Filtres Avancés
                    </button>
</div>
</div>
<!-- Section 2: KPI Summary (Bento Grid Style) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 relative overflow-hidden">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-secondary-container/30 rounded-lg text-secondary">
<span class="material-symbols-outlined" data-icon="school">school</span>
</div>
<span class="text-xs font-bold text-secondary uppercase tracking-wider">Réussite Globale</span>
</div>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-on-surface tracking-tighter">78.4%</span>
<span class="text-xs font-bold text-green-600 flex items-center bg-green-50 px-1.5 py-0.5 rounded">+2.1%</span>
</div>
<p class="text-xs text-on-surface-variant mt-2 font-medium">Par rapport au semestre précédent</p>
<div class="absolute bottom-0 left-0 w-full h-1 bg-secondary-container"></div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 relative overflow-hidden">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary-container/10 rounded-lg text-primary">
<span class="material-symbols-outlined" data-icon="star">star</span>
</div>
<span class="text-xs font-bold text-primary uppercase tracking-wider">Moyenne Générale</span>
</div>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-on-surface tracking-tighter">13.82</span>
<span class="text-xs font-bold text-on-surface-variant">/ 20</span>
</div>
<p class="text-xs text-on-surface-variant mt-2 font-medium">Moyenne de l'institution</p>
<div class="absolute bottom-0 left-0 w-full h-1 bg-primary"></div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 relative overflow-hidden">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-tertiary-fixed/30 rounded-lg text-tertiary">
<span class="material-symbols-outlined" data-icon="verified">verified</span>
</div>
<span class="text-xs font-bold text-tertiary uppercase tracking-wider">ECTS Validés</span>
</div>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-on-surface tracking-tighter">84.0%</span>
<span class="text-xs font-bold text-tertiary-container flex items-center bg-tertiary-fixed/20 px-1.5 py-0.5 rounded">Stable</span>
</div>
<p class="text-xs text-on-surface-variant mt-2 font-medium">Crédits accumulés par les étudiants</p>
<div class="absolute bottom-0 left-0 w-full h-1 bg-tertiary"></div>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
<!-- Section 3: Bar Comparison Chart (Visual Simulation) -->
<div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/10">
<div class="flex justify-between items-center mb-8">
<h3 class="font-bold text-lg text-on-surface">Comparaison par Département (%)</h3>
<div class="flex gap-2">
<div class="flex items-center gap-1.5">
<span class="w-3 h-3 rounded-full bg-primary"></span>
<span class="text-xs font-medium text-on-surface-variant">Réussite</span>
</div>
</div>
</div>
<div class="flex flex-col gap-6">
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Informatique</span>
<span>82%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary rounded-full" style="width: 82%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Gestion</span>
<span>74%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary/70 rounded-full" style="width: 74%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Sciences de la Vie</span>
<span>68%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary/50 rounded-full" style="width: 68%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Droit &amp; Sciences Po</span>
<span>89%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary rounded-full" style="width: 89%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Lettres &amp; Langues</span>
<span>79%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary/60 rounded-full" style="width: 79%"></div>
</div>
</div>
</div>
</div>
<!-- Section 5: Distribution Chart (Mentions) -->
<div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/10 flex flex-col">
<h3 class="font-bold text-lg text-on-surface mb-8">Répartition des Mentions</h3>
<div class="flex-1 flex flex-col justify-center items-center">
<!-- Custom CSS Donut Chart Simulation -->
<div class="relative w-48 h-48 rounded-full border-[16px] border-slate-100 flex items-center justify-center mb-8" style="background: conic-gradient(#003fb1 0% 15%, #4b5c92 15% 45%, #852b00 45% 75%, #e0e3e5 75% 100%); mask: radial-gradient(transparent 58%, black 59%);">
</div>
<div class="grid grid-cols-2 gap-x-6 gap-y-3 w-full">
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-sm bg-primary"></span>
<span class="text-xs font-medium text-on-surface-variant">Bien (15%)</span>
</div>
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-sm bg-secondary"></span>
<span class="text-xs font-medium text-on-surface-variant">Assez Bien (30%)</span>
</div>
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-sm bg-tertiary"></span>
<span class="text-xs font-medium text-on-surface-variant">Passable (30%)</span>
</div>
<div class="flex items-center gap-2">
<span class="w-3 h-3 rounded-sm bg-surface-variant"></span>
<span class="text-xs font-medium text-on-surface-variant">Rattrapage (25%)</span>
</div>
</div>
</div>
</div>
</div>
<!-- Section 4: Detailed Table -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
<div class="p-6 border-b border-surface-container flex justify-between items-center">
<h3 class="font-bold text-lg text-on-surface">Détails par Département</h3>
<div class="flex gap-2">
<button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="filter_list">filter_list</span>
</button>
<button class="p-2 hover:bg-surface-container-low rounded-lg transition-colors">
<span class="material-symbols-outlined text-on-surface-variant" data-icon="download">download</span>
</button>
</div>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-on-surface-variant">Département</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right">Étudiants</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right">Moyenne</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right">Taux de Réussite</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-widest text-on-surface-variant text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">Informatique</span>
<span class="text-xs text-on-surface-variant">Faculté des Sciences</span>
</div>
</td>
<td class="px-6 py-5 text-sm text-on-surface-variant text-right font-medium">1,240</td>
<td class="px-6 py-5 text-sm text-on-surface text-right font-bold tracking-tight">14.12</td>
<td class="px-6 py-5 text-right">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">82.0% VALIDÉ</span>
</td>
<td class="px-6 py-5 text-right">
<button class="text-xs font-bold text-primary hover:text-on-primary-fixed-variant transition-colors">Voir détails par filière</button>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">Gestion</span>
<span class="text-xs text-on-surface-variant">École de Management</span>
</div>
</td>
<td class="px-6 py-5 text-sm text-on-surface-variant text-right font-medium">2,850</td>
<td class="px-6 py-5 text-sm text-on-surface text-right font-bold tracking-tight">12.45</td>
<td class="px-6 py-5 text-right">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">74.5% VALIDÉ</span>
</td>
<td class="px-6 py-5 text-right">
<button class="text-xs font-bold text-primary hover:text-on-primary-fixed-variant transition-colors">Voir détails par filière</button>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">Sciences de la Vie</span>
<span class="text-xs text-on-surface-variant">Faculté des Sciences</span>
</div>
</td>
<td class="px-6 py-5 text-sm text-on-surface-variant text-right font-medium">890</td>
<td class="px-6 py-5 text-sm text-on-surface text-right font-bold tracking-tight">11.90</td>
<td class="px-6 py-5 text-right">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-tertiary-container text-on-tertiary-container">68.2% RATTRAPAGE</span>
</td>
<td class="px-6 py-5 text-right">
<button class="text-xs font-bold text-primary hover:text-on-primary-fixed-variant transition-colors">Voir détails par filière</button>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-sm font-bold text-on-surface">Droit &amp; Sciences Po</span>
<span class="text-xs text-on-surface-variant">Faculté des Sciences Humaines</span>
</div>
</td>
<td class="px-6 py-5 text-sm text-on-surface-variant text-right font-medium">1,120</td>
<td class="px-6 py-5 text-sm text-on-surface text-right font-bold tracking-tight">15.02</td>
<td class="px-6 py-5 text-right">
<span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">89.4% VALIDÉ</span>
</td>
<td class="px-6 py-5 text-right">
<button class="text-xs font-bold text-primary hover:text-on-primary-fixed-variant transition-colors">Voir détails par filière</button>
</td>
</tr>
</tbody>
</table>
</div>
</div>
</main>
</div>
<!-- Mobile Bottom NavBar (Shell Persistence) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-slate-100 flex justify-around py-3 z-50">
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
<span class="text-[10px] font-bold uppercase">Home</span>
</button>
<button class="flex flex-col items-center gap-1 text-blue-700">
<span class="material-symbols-outlined" data-icon="analytics" style="font-variation-settings: 'FILL' 1;">analytics</span>
<span class="text-[10px] font-bold uppercase">Stats</span>
</button>
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined" data-icon="domain">domain</span>
<span class="text-[10px] font-bold uppercase">Depts</span>
</button>
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
<span class="text-[10px] font-bold uppercase">Notifs</span>
</button>
</nav>
</body></html>