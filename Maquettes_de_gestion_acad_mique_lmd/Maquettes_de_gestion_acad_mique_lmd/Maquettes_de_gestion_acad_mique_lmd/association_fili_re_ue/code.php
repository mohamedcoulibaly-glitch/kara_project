<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
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
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- SideNavBar Anchor -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r-0 bg-[#f7f9fb] dark:bg-slate-900 flex flex-col p-4 z-50">
<div class="mb-8 px-2">
<h1 class="text-lg font-bold tracking-tight text-[#1A56DB] flex items-center gap-2">
<span class="material-symbols-outlined" data-icon="account_balance">account_balance</span>
                Portail Académique
            </h1>
<p class="text-xs text-slate-500 font-medium mt-1">Gestion LMD - Administration</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="domain">domain</span>
                Départements
            </a>
<a class="flex items-center gap-3 px-3 py-2 bg-white text-[#1A56DB] font-semibold shadow-sm transition-transform active:scale-[0.98] text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
                Filières
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="library_books">library_books</span>
                Unités d'Enseignement
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="menu_book">menu_book</span>
                Éléments Constitutifs
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="group">group</span>
                Étudiants
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
<!-- TopAppBar Anchor -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-8 h-16 border-b border-[#f2f4f6]/50 shadow-sm">
<h2 class="text-xl font-black text-[#1A56DB] tracking-tight">Système de Gestion Académique</h2>
<div class="flex items-center gap-6">
<div class="relative group">
<span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
<span class="material-symbols-outlined text-lg" data-icon="search">search</span>
</span>
<input class="pl-10 pr-4 py-1.5 bg-surface-container-low border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-[#1A56DB]/20 transition-all" placeholder="Rechercher une filière..." type="text"/>
</div>
<div class="flex items-center gap-4 text-slate-500">
<button class="hover:bg-slate-50 p-1.5 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="hover:bg-slate-50 p-1.5 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
</button>
<div class="h-8 w-8 rounded-full bg-secondary-container overflow-hidden ring-2 ring-white">
<img alt="Avatar Administrateur" class="h-full w-full object-cover" data-alt="Portrait image of a professional administrator" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3_f_Br9RhLJRBraDU6gXth-nX4e2fUxeGZNHbdBzglDw_XHlTsIHuQjSXnWvWtTTXe2k1Z7eAhbUyyPv_GU3ZGiIMnaRszEwzYQateEnEB_If-SvNx1aEZSPNQLvLn8MkLdlUhapdDlbHOa1ZhvGTOFkw0b5XyPIKcFlsMvSkGF1RcpFaA-331y_2jLwXKmsCluT1hDpKF6Sh9VyagTGeT9hHvNHMPRUNJoUSVEBglPwG3Dy-DHNp0uxXCTCwe-Xt5HWUeKKELF8"/>
</div>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<div class="max-w-7xl mx-auto space-y-8">
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
<div>
<span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">Programme de liaison</span>
<h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Association Filière &amp; Unités d'Enseignement</h3>
<p class="text-slate-500 mt-1 max-w-2xl">Configurez le cursus académique en associant les UE aux filières correspondantes par semestre.</p>
</div>
<div class="flex items-center gap-2">
<button class="px-5 py-2.5 bg-white border border-outline-variant/30 text-slate-700 font-semibold text-sm rounded-md shadow-sm hover:bg-slate-50 transition-all">
                        Annuler les modifications
                    </button>
<button class="px-5 py-2.5 bg-primary text-white font-semibold text-sm rounded-md shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="save">save</span>
                        Enregistrer le Programme
                    </button>
</div>
</div>
<!-- Main Interactive Area: Asymmetric Layout -->
<div class="grid grid-cols-12 gap-8">
<!-- Left Column: Selection Focus (Filière & Semestre) -->
<div class="col-span-12 lg:col-span-4 space-y-6">
<!-- Filière Selection Card -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<label class="block text-sm font-bold text-slate-800 mb-4">Sélectionner une Filière</label>
<div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 hide-scrollbar">
<div class="p-3 bg-primary-fixed-dim/20 border-2 border-primary rounded-lg cursor-pointer transition-all">
<div class="flex items-center justify-between">
<span class="font-bold text-primary text-sm">Génie Logiciel (GL)</span>
<span class="material-symbols-outlined text-primary text-lg" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
</div>
<p class="text-xs text-on-primary-fixed-variant mt-1">Département d'Informatique</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">Réseaux &amp; Télécoms</span>
<span class="text-slate-300 text-xs">RT</span>
</div>
<p class="text-xs text-slate-400 mt-1">Département d'Informatique</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">Banque &amp; Finance</span>
<span class="text-slate-300 text-xs">BF</span>
</div>
<p class="text-xs text-slate-400 mt-1">Département de Gestion</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">Comptabilité &amp; Audit</span>
<span class="text-slate-300 text-xs">CA</span>
</div>
<p class="text-xs text-slate-400 mt-1">Département de Gestion</p>
</div>
</div>
</div>
<!-- Semestre Toggle Selection -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<label class="block text-sm font-bold text-slate-800 mb-4">Choisir le Semestre</label>
<div class="grid grid-cols-3 gap-2">
<button class="py-3 rounded-lg border-2 border-primary bg-primary/5 text-primary font-bold text-sm transition-all">S1</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S2</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S3</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S4</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S5</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S6</button>
</div>
</div>
</div>
<!-- Right Column: UE Selection Grid -->
<div class="col-span-12 lg:col-span-8 space-y-6">
<div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/10">
<div class="flex items-center justify-between mb-8">
<div>
<h4 class="text-lg font-bold text-slate-900">Unités d'Enseignement Disponibles</h4>
<p class="text-sm text-slate-500">Cochez les UE à inclure pour le semestre S1 en Génie Logiciel.</p>
</div>
<div class="flex items-center gap-3">
<span class="text-xs font-bold text-slate-400 px-3 py-1 bg-surface-container rounded-full">12 UE Total</span>
<span class="text-xs font-bold text-primary px-3 py-1 bg-primary-container/20 rounded-full">4 UE Sélectionnées</span>
</div>
</div>
<!-- Search & Filter Bar for UE -->
<div class="flex gap-4 mb-6">
<div class="flex-1 relative">
<span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
<span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
</span>
<input class="w-full pl-9 pr-4 py-2 bg-surface border-transparent rounded-md text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="Filtrer par code ou intitulé..." type="text"/>
</div>
<select class="bg-surface border-transparent rounded-md text-sm px-4 py-2 text-slate-600 focus:ring-0">
<option>Toutes les catégories</option>
<option>Fondamentale</option>
<option>Transversale</option>
<option>Optionnelle</option>
</select>
</div>
<!-- UE Grid (Bento Style Selection Cards) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF101 • 6 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Algorithmique et Structures de Données</h5>
<p class="text-xs text-slate-500 mt-1">Introduction aux structures linéaires et arbres.</p>
</div>
</div>
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF102 • 4 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Architecture des Ordinateurs</h5>
<p class="text-xs text-slate-500 mt-1">Logique booléenne et organisation CPU.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">MAT101 • 5 Crédits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Analyse Mathématique I</h5>
<p class="text-xs text-slate-400 mt-1">Fonctions réelles et calcul intégral.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">ANG101 • 2 Crédits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Anglais Technique I</h5>
<p class="text-xs text-slate-400 mt-1">Vocabulaire informatique et communication.</p>
</div>
</div>
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF103 • 6 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Systèmes d'Exploitation I</h5>
<p class="text-xs text-slate-500 mt-1">Gestion des processus et mémoire vive.</p>
</div>
</div>
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF104 • 3 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Outils Bureautiques Avancés</h5>
<p class="text-xs text-slate-500 mt-1">Maîtrise de LaTeX et scripts automatisés.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">DRO101 • 3 Crédits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Droit du Numérique</h5>
<p class="text-xs text-slate-400 mt-1">RGPD et propriété intellectuelle.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">PHY101 • 4 Crédits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Électronique Fondamentale</h5>
<p class="text-xs text-slate-400 mt-1">Circuits passifs et semi-conducteurs.</p>
</div>
</div>
</div>
<!-- Summary Floating Zone -->
<div class="mt-12 p-4 bg-surface-container-low rounded-lg flex items-center justify-between border-l-4 border-primary">
<div class="flex items-center gap-6">
<div>
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Crédits Totaux</p>
<p class="text-xl font-black text-primary">19 / 30</p>
</div>
<div class="h-10 w-px bg-outline-variant/30"></div>
<div>
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">UE Fondamentales</p>
<p class="text-xl font-black text-slate-800">3</p>
</div>
<div class="h-10 w-px bg-outline-variant/30"></div>
<div>
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">UE Transversales</p>
<p class="text-xl font-black text-slate-800">1</p>
</div>
</div>
<div class="text-right">
<p class="text-xs font-semibold text-slate-500">Statut du Semestre</p>
<span class="inline-block mt-1 px-3 py-1 bg-tertiary-container text-on-tertiary-container rounded-full text-[10px] font-black uppercase tracking-wider">Incomplet</span>
</div>
</div>
</div>
</div>
</div>
<!-- Quick View Section -->
<section class="bg-surface-container p-8 rounded-xl">
<div class="flex items-center gap-3 mb-6">
<span class="material-symbols-outlined text-secondary" data-icon="auto_awesome">auto_awesome</span>
<h4 class="text-lg font-bold text-on-surface">Visualisation de la Maquette Académique</h4>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="bg-white p-5 rounded-lg border border-outline-variant/20">
<h5 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-xs text-primary" data-icon="circle" style="font-variation-settings: 'FILL' 1;">circle</span>
                            Semestre 1
                        </h5>
<ul class="space-y-2">
<li class="text-xs text-slate-600 flex justify-between"><span>INF101 Algorithmique</span> <span class="font-bold">6</span></li>
<li class="text-xs text-slate-600 flex justify-between"><span>INF102 Architecture</span> <span class="font-bold">4</span></li>
<li class="text-xs text-slate-600 flex justify-between"><span>INF103 Systèmes d'Exploitation</span> <span class="font-bold">6</span></li>
</ul>
</div>
<div class="bg-white/50 p-5 rounded-lg border border-dashed border-outline-variant">
<h5 class="text-sm font-bold text-slate-400 mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-xs text-slate-300" data-icon="circle">circle</span>
                            Semestre 2
                        </h5>
<p class="text-center text-xs text-slate-400 py-4 italic">Aucune UE associée</p>
</div>
<div class="bg-white/50 p-5 rounded-lg border border-dashed border-outline-variant">
<h5 class="text-sm font-bold text-slate-400 mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-xs text-slate-300" data-icon="circle">circle</span>
                            Semestre 3
                        </h5>
<p class="text-center text-xs text-slate-400 py-4 italic">Configuration en attente</p>
</div>
</div>
</section>
</div>
</main>
<!-- FAB Suppression Rule Applied (Not present as this is a focused management screen) -->
</body></html>