<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Parcours AcadÃ©mique Complet - Gestion LMD</title>
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
                "secondary-container": "#b1c2ff",
                "secondary": "#4b5c92",
                "on-tertiary": "#ffffff",
                "on-error": "#ffffff",
                "secondary-fixed": "#dbe1ff",
                "tertiary-fixed-dim": "#ffb59a",
                "outline-variant": "#c3c5d7",
                "on-tertiary-fixed-variant": "#802a00",
                "on-secondary-container": "#3d4e84",
                "on-secondary-fixed": "#01174b",
                "on-surface-variant": "#434654",
                "primary": "#003fb1",
                "surface-container": "#eceef0",
                "background": "#f7f9fb",
                "inverse-on-surface": "#eff1f3",
                "surface": "#f7f9fb",
                "primary-fixed": "#dbe1ff",
                "on-tertiary-fixed": "#380d00",
                "surface-container-lowest": "#ffffff",
                "surface-dim": "#d8dadc",
                "error-container": "#ffdad6",
                "inverse-primary": "#b5c4ff",
                "primary-container": "#1a56db",
                "on-error-container": "#93000a",
                "outline": "#737686",
                "on-tertiary-container": "#ffd4c5",
                "tertiary-container": "#ad3b00",
                "on-secondary": "#ffffff",
                "surface-container-highest": "#e0e3e5",
                "on-surface": "#191c1e",
                "surface-container-low": "#f2f4f6",
                "primary-fixed-dim": "#b5c4ff",
                "on-primary-fixed-variant": "#003dab",
                "tertiary-fixed": "#ffdbcf",
                "surface-container-high": "#e6e8ea",
                "on-primary": "#ffffff",
                "error": "#ba1a1a",
                "surface-variant": "#e0e3e5",
                "on-background": "#191c1e",
                "tertiary": "#852b00",
                "on-secondary-fixed-variant": "#334479",
                "secondary-fixed-dim": "#b5c4ff",
                "inverse-surface": "#2d3133",
                "on-primary-fixed": "#00174d",
                "surface-tint": "#1353d8",
                "surface-bright": "#f7f9fb",
                "on-primary-container": "#d4dcff"
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
            vertical-align: middle;
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-surface text-on-surface selection:bg-primary-fixed selection:text-on-primary-fixed">
<div class="flex min-h-screen">
<!-- SideNavBar - Execution from JSON -->
<aside class="hidden md:flex flex-col h-screen w-64 bg-slate-50 border-r-0 font-sans antialiased text-sm font-medium tracking-tight p-4 shrink-0 sticky top-0">
<div class="flex items-center gap-3 px-2 mb-8">
<div class="w-10 h-10 bg-primary-container rounded-xl flex items-center justify-center text-white shadow-sm">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">school</span>
</div>
<div>
<h1 class="text-xl font-bold tracking-tighter text-blue-700 leading-none">Gestion LMD</h1>
<p class="text-[10px] text-slate-500 uppercase tracking-widest mt-1">SystÃ¨me Universitaire</p>
</div>
</div>
<nav class="space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 transition-colors duration-200 ease-in-out rounded-lg scale-95 active:scale-100 transition-transform" href="../index.php">
<span class="material-symbols-outlined">dashboard</span>
<span>Tableau de bord</span>
</a>
<!-- Active Tab: Cours/Academic matching current intent -->
<a class="flex items-center gap-3 px-3 py-2.5 bg-white text-blue-700 font-semibold shadow-sm rounded-lg scale-95 active:scale-100 transition-transform" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">menu_book</span>
<span>Cours</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 transition-colors duration-200 ease-in-out rounded-lg scale-95 active:scale-100 transition-transform" href="#">
<span class="material-symbols-outlined">group</span>
<span>Ã‰tudiants</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 transition-colors duration-200 ease-in-out rounded-lg scale-95 active:scale-100 transition-transform" href="#">
<span class="material-symbols-outlined">grade</span>
<span>Notes</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 hover:bg-slate-100 transition-colors duration-200 ease-in-out rounded-lg scale-95 active:scale-100 transition-transform" href="#">
<span class="material-symbols-outlined">settings</span>
<span>ParamÃ¨tres</span>
</a>
</nav>
<div class="mt-auto p-4 bg-slate-100 rounded-xl">
<div class="flex items-center gap-3">
<img alt="Avatar de l'utilisateur" class="w-10 h-10 rounded-full border-2 border-white shadow-sm" data-alt="Portrait photo of a university administrator" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD8l27MtHtupWStAGdgpzkHIEqAqIJD5im4upvqm82Idn66NuLUQ0pVHfVlHe467mAMIrP32S6JK8LeovJVqCiEfNllzYaZzYkJBhMu3i1fL1oomm-finU0kB4POvopEgJtThxyRvRere3graeqY9R3qFZhgGTPDJNmbTBev45dVF-FLopO00HJ65KGBzyiu7VVw1dyntmrewan3aO3FacwfrrtM5blLR6a5rt03L41YKolg_Zk0660gQGr-ayp0l3NrglDErV4eck"/>
<div class="overflow-hidden">
<p class="font-bold text-slate-900 truncate text-xs">Dr. Jean Dupont</p>
<p class="text-slate-500 text-[10px] truncate">Admin AcadÃ©mique</p>
</div>
</div>
</div>
</aside>
<!-- Main Content Canvas -->
<div class="flex-1 flex flex-col min-w-0">
<!-- TopNavBar - Execution from JSON -->
<header class="w-full h-16 sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100 flex items-center justify-between px-6 shrink-0">
<div class="flex items-center gap-4">
<button class="md:hidden text-slate-900">
<span class="material-symbols-outlined">menu</span>
</button>
<h2 class="text-lg font-black text-slate-900">Parcours AcadÃ©mique</h2>
</div>
<div class="flex items-center gap-4">
<div class="hidden sm:flex items-center bg-slate-100 px-3 py-1.5 rounded-full w-64">
<span class="material-symbols-outlined text-slate-400 text-lg mr-2">search</span>
<input class="bg-transparent border-none focus:ring-0 text-xs w-full placeholder:text-slate-400" placeholder="Rechercher un Ã©tudiant..." type="text"/>
</div>
<div class="flex items-center gap-2">
<button class="p-2 text-slate-500 hover:text-blue-600 transition-opacity opacity-80 hover:opacity-100">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="p-2 text-slate-500 hover:text-blue-600 transition-opacity opacity-80 hover:opacity-100">
<span class="material-symbols-outlined">help_outline</span>
</button>
</div>
</div>
</header>
<main class="p-4 md:p-8 space-y-8 max-w-7xl mx-auto w-full">
<!-- Student Header Section -->
<section class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
<div class="lg:col-span-8 flex flex-col md:flex-row items-center md:items-start gap-6 bg-surface-container-low p-6 rounded-xl border border-outline-variant/20 shadow-sm">
<img alt="Student Profile" class="w-24 h-24 md:w-32 md:h-32 rounded-xl object-cover shadow-md" data-alt="University student formal portrait photo" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAU8bwxAFa5n7LWuiBzunbGCirIkptm0H4_El8XBlqO_X0V5mYSGOHtqb9zN59R0VSKWijPMmjUFgHBLMocg93nhTvzgIjOQPdfcuFxuZpqkSpBEBtU_WEJuTRlk2XrEtmZK1L2TDr3_9w9lGdFRjaE6de59xkPvKEA6mD9J1ZwfvmcWTYagqxmvnUvc8n4OUL-CwryHa6NSiR2MmUgaQSS-DldF5AUpIwTsfZzfT39YNQWwZVlh2MCCj7OuQpjLDlfDDHqTuVOr1w"/>
<div class="flex-1 text-center md:text-left">
<div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-2">
<h3 class="text-2xl font-extrabold tracking-tight text-on-surface">Mamadou Koulibaly</h3>
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-[10px] font-bold uppercase tracking-wider rounded-full self-center md:self-auto">ADMIS</span>
</div>
<div class="grid grid-cols-1 sm:grid-cols-2 gap-y-2 text-sm text-on-surface-variant mb-4">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-lg">badge</span>
<span class="font-medium">Matricule:</span> 2021-CS-442
                                </div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-lg">account_tree</span>
<span class="font-medium">FiliÃ¨re:</span> GÃ©nie Logiciel (GL)
                                </div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-lg">calendar_today</span>
<span class="font-medium">Promotion:</span> 2021-2024
                                </div>
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-primary text-lg">location_on</span>
<span class="font-medium">Campus:</span> Bamako Main
                                </div>
</div>
<div class="flex flex-wrap gap-2 justify-center md:justify-start">
<button class="flex items-center gap-2 px-4 py-2 bg-primary text-white text-xs font-bold rounded-md hover:bg-primary-container transition-all">
<span class="material-symbols-outlined text-sm">download</span>
                                    TÃ‰LÃ‰CHARGER RELEVÃ‰ GLOBAL
                                </button>
<button class="flex items-center gap-2 px-4 py-2 bg-surface-container-lowest border border-outline-variant/30 text-xs font-bold rounded-md hover:bg-surface-container transition-all">
<span class="material-symbols-outlined text-sm">mail</span>
                                    CONTACTER
                                </button>
</div>
</div>
</div>
<!-- Global Progress Card -->
<div class="lg:col-span-4 bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm space-y-6 self-stretch flex flex-col justify-center">
<div class="space-y-1">
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">Progression Licence</p>
<div class="flex items-end justify-between">
<span class="text-4xl font-black text-primary tracking-tighter">150 / 180</span>
<span class="text-sm font-semibold text-primary/60 mb-1">ECTS</span>
</div>
<div class="w-full h-2 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary w-[83%] rounded-full"></div>
</div>
</div>
<div class="grid grid-cols-2 gap-4">
<div class="p-3 bg-surface-container-low rounded-lg">
<p class="text-[9px] font-bold text-slate-500 uppercase">Moyenne GÃ©nÃ©rale</p>
<p class="text-xl font-black text-on-surface">14.82<span class="text-xs text-slate-400 ml-1 font-normal">/20</span></p>
</div>
<div class="p-3 bg-surface-container-low rounded-lg">
<p class="text-[9px] font-bold text-slate-500 uppercase">Semestres ValidÃ©s</p>
<p class="text-xl font-black text-on-surface">5 <span class="text-xs text-slate-400 ml-1 font-normal">/ 6</span></p>
</div>
</div>
</div>
</section>
<!-- Semester Timeline/Grid -->
<section class="space-y-6">
<div class="flex items-center justify-between px-2">
<h4 class="text-xl font-bold tracking-tight text-on-surface flex items-center gap-2">
<span class="w-1.5 h-6 bg-primary rounded-full"></span>
                            DÃ©tail du Parcours AcadÃ©mique
                        </h4>
<div class="flex items-center gap-4 text-xs font-medium text-slate-500">
<span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-secondary-container"></span> ValidÃ©</span>
<span class="flex items-center gap-1"><span class="w-2.5 h-2.5 rounded-full bg-tertiary-fixed-dim"></span> En cours</span>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
<!-- S1 Card -->
<div class="bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/10 shadow-sm flex flex-col hover:shadow-md transition-shadow">
<div class="flex items-start justify-between mb-4">
<div>
<h5 class="text-lg font-extrabold text-on-surface">Semestre 1</h5>
<p class="text-[10px] text-slate-400 font-medium">Session Automne 2021</p>
</div>
<span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[9px] font-bold uppercase rounded-full">VALIDÃ‰</span>
</div>
<div class="grid grid-cols-2 gap-4 mb-4 border-y border-outline-variant/10 py-3">
<div class="text-center border-r border-outline-variant/10">
<p class="text-[9px] text-slate-500 uppercase font-bold">Moyenne</p>
<p class="text-lg font-black text-primary">13.45</p>
</div>
<div class="text-center">
<p class="text-[9px] text-slate-500 uppercase font-bold">CrÃ©dits</p>
<p class="text-lg font-black text-primary">30/30</p>
</div>
</div>
<ul class="space-y-2 flex-1">
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Algorithmique &amp; C</span>
<span class="font-bold">14.00</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Architecture Ordinateurs</span>
<span class="font-bold">12.50</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">MathÃ©matiques DiscrÃ¨tes</span>
<span class="font-bold">13.85</span>
</li>
</ul>
</div>
<!-- S2 Card -->
<div class="bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/10 shadow-sm flex flex-col hover:shadow-md transition-shadow">
<div class="flex items-start justify-between mb-4">
<div>
<h5 class="text-lg font-extrabold text-on-surface">Semestre 2</h5>
<p class="text-[10px] text-slate-400 font-medium">Session Printemps 2022</p>
</div>
<span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[9px] font-bold uppercase rounded-full">VALIDÃ‰</span>
</div>
<div class="grid grid-cols-2 gap-4 mb-4 border-y border-outline-variant/10 py-3">
<div class="text-center border-r border-outline-variant/10">
<p class="text-[9px] text-slate-500 uppercase font-bold">Moyenne</p>
<p class="text-lg font-black text-primary">15.20</p>
</div>
<div class="text-center">
<p class="text-[9px] text-slate-500 uppercase font-bold">CrÃ©dits</p>
<p class="text-lg font-black text-primary">30/30</p>
</div>
</div>
<ul class="space-y-2 flex-1">
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Programmation OrientÃ©e Objet</span>
<span class="font-bold">16.50</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">SystÃ¨mes d'Exploitation</span>
<span class="font-bold">14.20</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Anglais Technique II</span>
<span class="font-bold">15.00</span>
</li>
</ul>
</div>
<!-- S3 Card -->
<div class="bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/10 shadow-sm flex flex-col hover:shadow-md transition-shadow">
<div class="flex items-start justify-between mb-4">
<div>
<h5 class="text-lg font-extrabold text-on-surface">Semestre 3</h5>
<p class="text-[10px] text-slate-400 font-medium">Session Automne 2022</p>
</div>
<span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[9px] font-bold uppercase rounded-full">VALIDÃ‰</span>
</div>
<div class="grid grid-cols-2 gap-4 mb-4 border-y border-outline-variant/10 py-3">
<div class="text-center border-r border-outline-variant/10">
<p class="text-[9px] text-slate-500 uppercase font-bold">Moyenne</p>
<p class="text-lg font-black text-primary">14.10</p>
</div>
<div class="text-center">
<p class="text-[9px] text-slate-500 uppercase font-bold">CrÃ©dits</p>
<p class="text-lg font-black text-primary">30/30</p>
</div>
</div>
<ul class="space-y-2 flex-1">
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Bases de DonnÃ©es (SQL)</span>
<span class="font-bold">15.75</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">RÃ©seaux Informatiques</span>
<span class="font-bold">12.00</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">ThÃ©orie des Graphes</span>
<span class="font-bold">14.50</span>
</li>
</ul>
</div>
<!-- S4 Card -->
<div class="bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/10 shadow-sm flex flex-col hover:shadow-md transition-shadow">
<div class="flex items-start justify-between mb-4">
<div>
<h5 class="text-lg font-extrabold text-on-surface">Semestre 4</h5>
<p class="text-[10px] text-slate-400 font-medium">Session Printemps 2023</p>
</div>
<span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[9px] font-bold uppercase rounded-full">VALIDÃ‰</span>
</div>
<div class="grid grid-cols-2 gap-4 mb-4 border-y border-outline-variant/10 py-3">
<div class="text-center border-r border-outline-variant/10">
<p class="text-[9px] text-slate-500 uppercase font-bold">Moyenne</p>
<p class="text-lg font-black text-primary">16.35</p>
</div>
<div class="text-center">
<p class="text-[9px] text-slate-500 uppercase font-bold">CrÃ©dits</p>
<p class="text-lg font-black text-primary">30/30</p>
</div>
</div>
<ul class="space-y-2 flex-1">
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">DÃ©v. Web AvancÃ©</span>
<span class="font-bold">18.00</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">GÃ©nie Logiciel II</span>
<span class="font-bold">15.50</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">ProbabilitÃ©s &amp; Stats</span>
<span class="font-bold">15.50</span>
</li>
</ul>
</div>
<!-- S5 Card -->
<div class="bg-surface-container-lowest rounded-xl p-5 border border-outline-variant/10 shadow-sm flex flex-col hover:shadow-md transition-shadow">
<div class="flex items-start justify-between mb-4">
<div>
<h5 class="text-lg font-extrabold text-on-surface">Semestre 5</h5>
<p class="text-[10px] text-slate-400 font-medium">Session Automne 2023</p>
</div>
<span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[9px] font-bold uppercase rounded-full">VALIDÃ‰</span>
</div>
<div class="grid grid-cols-2 gap-4 mb-4 border-y border-outline-variant/10 py-3">
<div class="text-center border-r border-outline-variant/10">
<p class="text-[9px] text-slate-500 uppercase font-bold">Moyenne</p>
<p class="text-lg font-black text-primary">15.00</p>
</div>
<div class="text-center">
<p class="text-[9px] text-slate-500 uppercase font-bold">CrÃ©dits</p>
<p class="text-lg font-black text-primary">30/30</p>
</div>
</div>
<ul class="space-y-2 flex-1">
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">SÃ©curitÃ© Informatique</span>
<span class="font-bold">14.00</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Gestion de Projet IT</span>
<span class="font-bold">16.00</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Intelligence Artificielle</span>
<span class="font-bold">15.00</span>
</li>
</ul>
</div>
<!-- S6 Card (Active/Current) -->
<div class="bg-surface-container-lowest rounded-xl p-5 border-2 border-primary/20 shadow-md flex flex-col scale-105 z-10">
<div class="flex items-start justify-between mb-4">
<div>
<h5 class="text-lg font-extrabold text-primary">Semestre 6</h5>
<p class="text-[10px] text-slate-400 font-medium uppercase tracking-wider">Session Actuelle</p>
</div>
<span class="px-2 py-0.5 bg-tertiary-fixed text-on-tertiary-fixed text-[9px] font-bold uppercase rounded-full">EN COURS</span>
</div>
<div class="grid grid-cols-2 gap-4 mb-4 border-y border-outline-variant/10 py-3">
<div class="text-center border-r border-outline-variant/10">
<p class="text-[9px] text-slate-500 uppercase font-bold">Moyenne Prov.</p>
<p class="text-lg font-black text-primary">--</p>
</div>
<div class="text-center">
<p class="text-[9px] text-slate-500 uppercase font-bold">CrÃ©dits Prov.</p>
<p class="text-lg font-black text-primary">00/30</p>
</div>
</div>
<ul class="space-y-3 flex-1">
<li class="flex flex-col gap-1">
<div class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant font-medium">Projet de Fin d'Ã‰tudes (PFE)</span>
<span class="text-[10px] text-primary bg-primary/5 px-1.5 rounded italic">Soutenance prÃ©vue</span>
</div>
<div class="w-full h-1 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary w-[65%]"></div>
</div>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Stage Professionnel</span>
<span class="font-bold text-slate-300">TBD</span>
</li>
<li class="flex items-center justify-between text-xs">
<span class="text-on-surface-variant">Entreprenariat</span>
<span class="font-bold text-primary">17.00</span>
</li>
</ul>
<button class="mt-4 w-full py-2 bg-primary-container text-white text-[10px] font-bold rounded-md hover:bg-primary transition-colors uppercase tracking-widest">
                                Saisir Notes S6
                            </button>
</div>
</div>
</section>
<!-- Comparative Metrics -->
<section class="grid grid-cols-1 lg:grid-cols-2 gap-6">
<div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/10">
<h4 class="text-sm font-bold text-on-surface mb-6 flex items-center gap-2">
<span class="material-symbols-outlined text-primary">show_chart</span>
                            Ã‰volution des Moyennes Semestrielles
                        </h4>
<div class="h-48 flex items-end justify-between gap-4 px-2">
<div class="flex-1 flex flex-col items-center gap-2">
<div class="w-full bg-primary/20 rounded-t-lg transition-all hover:bg-primary/40" style="height: 67.25%;"></div>
<span class="text-[10px] font-bold text-slate-500">S1</span>
</div>
<div class="flex-1 flex flex-col items-center gap-2">
<div class="w-full bg-primary/20 rounded-t-lg transition-all hover:bg-primary/40" style="height: 76%;"></div>
<span class="text-[10px] font-bold text-slate-500">S2</span>
</div>
<div class="flex-1 flex flex-col items-center gap-2">
<div class="w-full bg-primary/20 rounded-t-lg transition-all hover:bg-primary/40" style="height: 70.5%;"></div>
<span class="text-[10px] font-bold text-slate-500">S3</span>
</div>
<div class="flex-1 flex flex-col items-center gap-2">
<div class="w-full bg-primary/20 rounded-t-lg transition-all hover:bg-primary/40" style="height: 81.75%;"></div>
<span class="text-[10px] font-bold text-slate-500">S4</span>
</div>
<div class="flex-1 flex flex-col items-center gap-2">
<div class="w-full bg-primary/20 rounded-t-lg transition-all hover:bg-primary/40" style="height: 75%;"></div>
<span class="text-[10px] font-bold text-slate-500">S5</span>
</div>
<div class="flex-1 flex flex-col items-center gap-2">
<div class="w-full bg-slate-200 rounded-t-lg border-t-2 border-dashed border-slate-300" style="height: 40%;"></div>
<span class="text-[10px] font-bold text-slate-500">S6</span>
</div>
</div>
</div>
<div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/10 flex flex-col">
<h4 class="text-sm font-bold text-on-surface mb-4">RÃ©partition des CrÃ©dits par Domaine</h4>
<div class="space-y-4 flex-1 flex flex-col justify-center">
<div class="space-y-1">
<div class="flex justify-between text-[10px] font-bold uppercase tracking-wide">
<span class="text-slate-600">Informatique Fondamentale</span>
<span class="text-primary">60 / 60 ECTS</span>
</div>
<div class="w-full h-1.5 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary w-full"></div>
</div>
</div>
<div class="space-y-1">
<div class="flex justify-between text-[10px] font-bold uppercase tracking-wide">
<span class="text-slate-600">MathÃ©matiques &amp; Sciences</span>
<span class="text-primary">30 / 30 ECTS</span>
</div>
<div class="w-full h-1.5 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary w-full"></div>
</div>
</div>
<div class="space-y-1">
<div class="flex justify-between text-[10px] font-bold uppercase tracking-wide">
<span class="text-slate-600">GÃ©nie Logiciel &amp; Projets</span>
<span class="text-primary">45 / 60 ECTS</span>
</div>
<div class="w-full h-1.5 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary w-[75%]"></div>
</div>
</div>
<div class="space-y-1">
<div class="flex justify-between text-[10px] font-bold uppercase tracking-wide">
<span class="text-slate-600">Langues &amp; Culture</span>
<span class="text-primary">15 / 30 ECTS</span>
</div>
<div class="w-full h-1.5 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary w-[50%]"></div>
</div>
</div>
</div>
</div>
</section>
</main>
<footer class="mt-auto border-t border-outline-variant/10 py-6 px-8 flex flex-col sm:flex-row items-center justify-between gap-4">
<p class="text-[10px] text-slate-400 font-medium">Â© 2024 PARCOURS ACADÃ‰MIQUE - DIRECTION DES SYSTÃˆMES D'INFORMATION</p>
<div class="flex items-center gap-6">
<a class="text-[10px] font-bold text-slate-500 hover:text-primary transition-colors" href="#">POLITIQUE DE CONFIDENTIALITÃ‰</a>
<a class="text-[10px] font-bold text-slate-500 hover:text-primary transition-colors" href="#">SUPPORT TECHNIQUE</a>
</div>
</footer>
</div>
</div>
</body></html>
