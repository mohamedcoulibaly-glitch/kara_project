<!DOCTYPE html>

<html lang="fr"><head>
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
            vertical-align: middle;
        }
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-[#f7f9fb] dark:bg-slate-900 flex flex-col p-4 z-50">
<div class="flex items-center gap-3 px-2 mb-8">
<div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center">
<span class="material-symbols-outlined text-white" style="font-variation-settings: 'FILL' 1;">account_balance</span>
</div>
<div>
<h1 class="text-lg font-bold tracking-tight text-[#1A56DB]">Portail AcadÃ©mique</h1>
<p class="text-[10px] uppercase tracking-widest text-slate-500 font-bold">Gestion LMD</p>
</div>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-[#f2f4f6] transition-colors duration-200" href="#">
<span class="material-symbols-outlined">domain</span>
<span class="font-medium text-sm">DÃ©partements</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-[#f2f4f6] transition-colors duration-200" href="#">
<span class="material-symbols-outlined">account_tree</span>
<span class="font-medium text-sm">FiliÃ¨res</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg bg-white text-[#1A56DB] font-semibold shadow-sm" href="#">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">library_books</span>
<span class="font-medium text-sm">UnitÃ©s d'Enseignement</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-[#f2f4f6] transition-colors duration-200" href="#">
<span class="material-symbols-outlined">menu_book</span>
<span class="font-medium text-sm">Ã‰lÃ©ments Constitutifs</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-lg text-slate-600 hover:bg-[#f2f4f6] transition-colors duration-200" href="#">
<span class="material-symbols-outlined">group</span>
<span class="font-medium text-sm">Ã‰tudiants</span>
</a>
</nav>
<div class="mt-auto pt-4 border-t border-slate-200">
<button class="w-full bg-primary-container text-white py-3 rounded-lg font-semibold text-sm mb-4 active:scale-[0.98] transition-transform flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-sm">add</span>
                Nouvelle Saisie
            </button>
<a class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-primary transition-colors" href="#">
<span class="material-symbols-outlined">settings</span>
<span class="text-sm">ParamÃ¨tres</span>
</a>
<a class="flex items-center gap-3 px-4 py-2 text-slate-500 hover:text-error transition-colors" href="#">
<span class="material-symbols-outlined">logout</span>
<span class="text-sm">DÃ©connexion</span>
</a>
</div>
</aside>
<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-md z-40 border-b border-[#f2f4f6]/50 flex items-center justify-between px-8">
<h2 class="text-xl font-black text-[#1A56DB]">SystÃ¨me de Gestion AcadÃ©mique</h2>
<div class="flex items-center gap-6">
<div class="relative hidden lg:block">
<input class="bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm w-64 focus:ring-2 focus:ring-primary/20" placeholder="Rechercher une UE..." type="text"/>
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
</div>
<div class="flex items-center gap-4 border-l border-slate-100 pl-6">
<button class="text-slate-500 hover:text-primary transition-colors relative">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-0 right-0 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
</button>
<button class="text-slate-500 hover:text-primary transition-colors">
<span class="material-symbols-outlined">help_outline</span>
</button>
<img alt="Avatar Administrateur" class="w-8 h-8 rounded-full border-2 border-primary-container object-cover" data-alt="Avatar portrait of an administrative director" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCeLEbI3t4yCPlNTVfI_CQGo1kAIPYh7D_pY3bUdzSzppYqR0ZZ2fC4KiHqTeoRBzZo5pUXU_LMlvTeUS7WhtAH74agBsUFpF-3DHRDp0_M2VCxghWkoR6hKeer0dezIj-ttfMMNbqt8MNUerfhtUlMhixUuzbNaIuiaX3DCAbTbOe88bINFscyA20Q-eAO6-nQNcp6zpvb-b98guWcTUZzKhIIjrctoKxZl5nvpne3Zk0x_e53WHln67z-FUQbBT8fj2tS4oYai30"/>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-24 p-8 min-h-screen">
<div class="max-w-6xl mx-auto space-y-10">
<!-- Header Section -->
<div class="flex items-end justify-between">
<div>
<nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">
<span>AcadÃ©mique</span>
<span class="material-symbols-outlined text-xs">chevron_right</span>
<span class="text-primary">Configuration UE/EC</span>
</nav>
<h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Gestion des UnitÃ©s d'Enseignement</h3>
<p class="text-slate-500 mt-1">DÃ©finissez la structure pÃ©dagogique du semestre en cours.</p>
</div>
</div>
<!-- Editor Grid -->
<div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">
<!-- Form Area -->
<div class="xl:col-span-5 space-y-6">
<div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm border border-slate-100/50">
<div class="flex items-center gap-3 mb-8">
<span class="material-symbols-outlined text-primary bg-primary-fixed p-2 rounded-lg" style="font-variation-settings: 'FILL' 1;">edit_square</span>
<h4 class="text-lg font-bold">Nouvelle UnitÃ© (UE)</h4>
</div>
<form class="space-y-6">
<!-- UE Fields -->
<div class="grid grid-cols-2 gap-4">
<div class="col-span-1">
<label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Code UE</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-primary-container transition-all" placeholder="Ex: INF101" type="text"/>
</div>
<div class="col-span-1">
<label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">CrÃ©dits ECTS</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-primary-container transition-all" placeholder="6" type="number"/>
</div>
<div class="col-span-2">
<label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">LibellÃ© de l'UnitÃ©</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-primary-container transition-all" placeholder="Ex: Algorithmique et Structures de DonnÃ©es" type="text"/>
</div>
</div>
<!-- Dynamic EC Section -->
<div class="pt-6 border-t border-slate-100 space-y-4">
<div class="flex items-center justify-between mb-2">
<h5 class="text-sm font-bold text-slate-700">Ã‰lÃ©ments Constitutifs (EC)</h5>
<button class="text-xs font-bold text-primary hover:underline flex items-center gap-1" type="button">
<span class="material-symbols-outlined text-sm">add_circle</span>
                                        AJOUTER UN EC
                                    </button>
</div>
<!-- EC Row 1 -->
<div class="flex gap-3 items-end group">
<div class="flex-1">
<label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nom de l'EC</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-2 text-xs focus:bg-white focus:ring-1 focus:ring-primary transition-all" type="text" value="Programmation C"/>
</div>
<div class="w-24">
<label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Coefficient</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-2 text-xs focus:bg-white focus:ring-1 focus:ring-primary transition-all" type="number" value="2"/>
</div>
<button class="p-2 text-slate-300 hover:text-error transition-colors">
<span class="material-symbols-outlined text-lg">delete</span>
</button>
</div>
<!-- EC Row 2 -->
<div class="flex gap-3 items-end group">
<div class="flex-1">
<label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nom de l'EC</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-2 text-xs focus:bg-white focus:ring-1 focus:ring-primary transition-all" type="text" value="Structures de donnÃ©es"/>
</div>
<div class="w-24">
<label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Coefficient</label>
<input class="w-full bg-surface-container-low border-none rounded-lg px-4 py-2 text-xs focus:bg-white focus:ring-1 focus:ring-primary transition-all" type="number" value="3"/>
</div>
<button class="p-2 text-slate-300 hover:text-error transition-colors">
<span class="material-symbols-outlined text-lg">delete</span>
</button>
</div>
</div>
<button class="w-full bg-primary py-4 text-white rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary-container transition-all active:scale-[0.99] mt-4">
                                ENREGISTRER L'UNITÃ‰ D'ENSEIGNEMENT
                            </button>
</form>
</div>
<!-- Form Tips -->
<div class="bg-secondary-container/20 rounded-xl p-6 border border-secondary-container/30">
<div class="flex gap-4">
<span class="material-symbols-outlined text-secondary">info</span>
<div>
<h6 class="text-sm font-bold text-on-secondary-container">Standard LMD 2024</h6>
<p class="text-xs text-on-secondary-container/80 mt-1 leading-relaxed">
                                    La somme des coefficients des EC doit Ãªtre proportionnelle aux crÃ©dits ECTS de l'UE pour maintenir la cohÃ©rence du systÃ¨me de notation.
                                </p>
</div>
</div>
</div>
</div>
<!-- Display Area -->
<div class="xl:col-span-7 space-y-6">
<div class="flex items-center justify-between">
<h4 class="text-lg font-bold flex items-center gap-2">
<span class="material-symbols-outlined text-slate-400">inventory_2</span>
                            UE EnregistrÃ©es
                        </h4>
<div class="flex gap-2">
<button class="bg-white p-2 rounded-lg border border-slate-100 text-slate-400 hover:text-primary transition-colors">
<span class="material-symbols-outlined">grid_view</span>
</button>
<button class="bg-white p-2 rounded-lg border border-slate-100 text-slate-400 hover:text-primary transition-colors">
<span class="material-symbols-outlined">list</span>
</button>
</div>
</div>
<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
<!-- UE Card 1 -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow p-6 flex flex-col group relative overflow-hidden">
<div class="absolute top-0 right-0 w-24 h-24 bg-primary-container/5 rounded-full -mr-12 -mt-12 group-hover:scale-110 transition-transform"></div>
<div class="flex justify-between items-start mb-4">
<span class="bg-primary-fixed-dim text-on-primary-fixed-variant text-[10px] font-black px-2 py-1 rounded tracking-widest uppercase">INF202</span>
<div class="flex gap-1">
<button class="p-1 text-slate-300 hover:text-primary"><span class="material-symbols-outlined text-sm">edit</span></button>
<button class="p-1 text-slate-300 hover:text-error"><span class="material-symbols-outlined text-sm">delete</span></button>
</div>
</div>
<h5 class="text-base font-bold text-slate-800 leading-tight mb-2">Bases de DonnÃ©es AvancÃ©es</h5>
<div class="mt-auto pt-6 flex items-center justify-between border-t border-slate-50">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary text-sm">history_edu</span>
<span class="text-xs font-semibold text-slate-500">3 Ã‰lÃ©ments (EC)</span>
</div>
<div class="bg-secondary-container px-3 py-1 rounded-full">
<span class="text-[10px] font-black text-on-secondary-container uppercase tracking-widest">6 ECTS</span>
</div>
</div>
</div>
<!-- UE Card 2 -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow p-6 flex flex-col group relative overflow-hidden">
<div class="absolute top-0 right-0 w-24 h-24 bg-tertiary-container/5 rounded-full -mr-12 -mt-12 group-hover:scale-110 transition-transform"></div>
<div class="flex justify-between items-start mb-4">
<span class="bg-tertiary-fixed text-on-tertiary-fixed-variant text-[10px] font-black px-2 py-1 rounded tracking-widest uppercase">MATH101</span>
<div class="flex gap-1">
<button class="p-1 text-slate-300 hover:text-primary"><span class="material-symbols-outlined text-sm">edit</span></button>
<button class="p-1 text-slate-300 hover:text-error"><span class="material-symbols-outlined text-sm">delete</span></button>
</div>
</div>
<h5 class="text-base font-bold text-slate-800 leading-tight mb-2">Analyse MathÃ©matique I</h5>
<div class="mt-auto pt-6 flex items-center justify-between border-t border-slate-50">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary text-sm">history_edu</span>
<span class="text-xs font-semibold text-slate-500">2 Ã‰lÃ©ments (EC)</span>
</div>
<div class="bg-secondary-container px-3 py-1 rounded-full">
<span class="text-[10px] font-black text-on-secondary-container uppercase tracking-widest">4 ECTS</span>
</div>
</div>
</div>
<!-- UE Card 3 -->
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow p-6 flex flex-col group relative overflow-hidden">
<div class="absolute top-0 right-0 w-24 h-24 bg-primary-container/5 rounded-full -mr-12 -mt-12 group-hover:scale-110 transition-transform"></div>
<div class="flex justify-between items-start mb-4">
<span class="bg-primary-fixed-dim text-on-primary-fixed-variant text-[10px] font-black px-2 py-1 rounded tracking-widest uppercase">ANG105</span>
<div class="flex gap-1">
<button class="p-1 text-slate-300 hover:text-primary"><span class="material-symbols-outlined text-sm">edit</span></button>
<button class="p-1 text-slate-300 hover:text-error"><span class="material-symbols-outlined text-sm">delete</span></button>
</div>
</div>
<h5 class="text-base font-bold text-slate-800 leading-tight mb-2">Anglais Technique &amp; Communication</h5>
<div class="mt-auto pt-6 flex items-center justify-between border-t border-slate-50">
<div class="flex items-center gap-2">
<span class="material-symbols-outlined text-secondary text-sm">history_edu</span>
<span class="text-xs font-semibold text-slate-500">1 Ã‰lÃ©ment (EC)</span>
</div>
<div class="bg-secondary-container px-3 py-1 rounded-full">
<span class="text-[10px] font-black text-on-secondary-container uppercase tracking-widest">2 ECTS</span>
</div>
</div>
</div>
<!-- Empty State / Add New -->
<div class="bg-slate-50 rounded-xl border-2 border-dashed border-slate-200 p-6 flex flex-col items-center justify-center text-center group cursor-pointer hover:border-primary-container/30 transition-all">
<div class="w-12 h-12 rounded-full bg-white flex items-center justify-center text-slate-300 group-hover:text-primary transition-colors">
<span class="material-symbols-outlined">add_circle</span>
</div>
<p class="text-xs font-bold text-slate-400 mt-2 uppercase tracking-widest">Ajouter une nouvelle unitÃ©</p>
</div>
</div>
<!-- Statistics / Summary -->
<div class="grid grid-cols-3 gap-6 pt-4">
<div class="bg-white p-4 rounded-xl border border-slate-100">
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total UE</p>
<p class="text-2xl font-black text-primary">12</p>
</div>
<div class="bg-white p-4 rounded-xl border border-slate-100">
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total ECTS</p>
<p class="text-2xl font-black text-primary">30</p>
</div>
<div class="bg-white p-4 rounded-xl border border-slate-100">
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Moyenne Coeff</p>
<p class="text-2xl font-black text-primary">2.4</p>
</div>
</div>
</div>
</div>
</div>
</main>
<!-- Contextual FAB (Suppressing as per mandate on management screens, but kept placeholder for layout awareness) -->
<!-- Suppression logic: Screen is Management Task Focused -->
</body></html>
