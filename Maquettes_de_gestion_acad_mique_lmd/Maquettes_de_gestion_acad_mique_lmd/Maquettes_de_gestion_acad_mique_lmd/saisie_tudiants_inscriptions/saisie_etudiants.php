<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Saisie Ã‰tudiants - Portail AcadÃ©mique LMD</title>
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
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
        }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- SideNavBar (Shared Component) -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r-0 bg-[#f7f9fb] dark:bg-slate-900 flex flex-col h-full p-4 z-50">
<div class="mb-8 px-2">
<h1 class="text-lg font-bold tracking-tight text-[#1A56DB]">Portail AcadÃ©mique</h1>
<p class="text-xs text-slate-500 font-medium">Gestion LMD - Administration</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-['Inter'] antialiased text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="domain">domain</span>
                DÃ©partements
            </a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-['Inter'] antialiased text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
                FiliÃ¨res
            </a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-['Inter'] antialiased text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="library_books">library_books</span>
                UnitÃ©s d'Enseignement
            </a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-['Inter'] antialiased text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="menu_book">menu_book</span>
                Ã‰lÃ©ments Constitutifs
            </a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg bg-white dark:bg-slate-800 text-[#1A56DB] dark:text-blue-400 font-semibold shadow-sm font-['Inter'] antialiased text-sm" href="#">
<span class="material-symbols-outlined" data-icon="group" style="font-variation-settings: 'FILL' 1;">group</span>
                Ã‰tudiants
            </a>
</nav>
<button class="mt-4 mb-8 w-full py-2.5 bg-primary text-on-primary rounded-lg font-semibold text-sm active:scale-[0.98] transition-transform">
            Nouvelle Saisie
        </button>
<div class="pt-4 border-t border-slate-200 dark:border-slate-800 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
                ParamÃ¨tres
            </a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-400 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 text-sm font-medium" href="#">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
                DÃ©connexion
            </a>
</div>
</aside>
<!-- TopAppBar (Shared Component) -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-[#f2f4f6]/50 dark:border-slate-800 flex items-center justify-between px-8 h-16">
<div class="flex items-center gap-4">
<h2 class="text-xl font-black text-[#1A56DB]">SystÃ¨me de Gestion AcadÃ©mique</h2>
</div>
<div class="flex items-center gap-6">
<div class="relative hidden lg:block">
<span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 material-symbols-outlined text-xl" data-icon="search">search</span>
<input class="pl-10 pr-4 py-1.5 bg-surface-container-low border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-primary/20" placeholder="Rechercher un Ã©tudiant..." type="text"/>
</div>
<div class="flex items-center gap-3">
<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
</button>
<div class="h-8 w-8 rounded-full bg-slate-200 overflow-hidden ml-2 ring-2 ring-primary/10">
<img alt="Avatar Administrateur" class="h-full w-full object-cover" data-alt="Portrait photo of a male administrator" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCtgUzoj7YEUNEHgtOiX4sTOYKfyXYqQS2UA39q_4hmGqzKrBU2TRRz3M3CiR5tQeEDnZqI_O80KSWhQtNikP5I3AEhOZL42JYnRcRDNcwF2qbQ_DCobTWTuBvq97qaqvRJkz5wEYsDvyP_N75LeJPBwkJ4K4luSp0u0acoN0ZVWmHBI3ZnJuzV9KM7rqn-6mAbAqg9QoiLys8cKVRb-zVm36rqPrXSBqJ-CODJfGgjnFP-8m26gZUGRx4WYDwEukm2LXfhz0TQiAI"/>
</div>
</div>
</div>
</header>
<!-- Main Content -->
<main class="ml-64 pt-16 min-h-screen">
<div class="p-8 max-w-7xl mx-auto">
<!-- Page Header -->
<div class="mb-10">
<h3 class="text-3xl font-extrabold tracking-tight text-on-surface mb-2">Inscription Ã‰tudiant</h3>
<p class="text-slate-500 max-w-2xl">Enregistrez un nouvel Ã©tudiant dans le systÃ¨me LMD. Assurez-vous que toutes les informations d'Ã©tat civil correspondent aux piÃ¨ces officielles.</p>
</div>
<!-- Registration Form Section - Bento Layout -->
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-12">
<!-- Main Form Body -->
<div class="lg:col-span-8 space-y-8">
<div class="bg-surface-container-lowest p-8 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)]">
<div class="flex items-center gap-3 mb-8 pb-4 border-b border-surface-container">
<span class="material-symbols-outlined text-primary" data-icon="person_add">person_add</span>
<h4 class="text-lg font-bold">Informations Personnelles</h4>
</div>
<form class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-8">
<!-- Matricule -->
<div class="md:col-span-1">
<label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">NumÃ©ro Matricule</label>
<div class="relative">
<input class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="Ex: LMD-2024-001" type="text"/>
<span class="absolute right-3 top-1/2 -translate-y-1/2 material-symbols-outlined text-slate-300 text-lg" data-icon="fingerprint">fingerprint</span>
</div>
</div>
<!-- FiliÃ¨re Selection -->
<div class="md:col-span-1">
<label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">FiliÃ¨re d'inscription</label>
<select class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all appearance-none outline-none">
<option disabled="" selected="" value="">SÃ©lectionner une filiÃ¨re</option>
<option>Informatique de Gestion (L1)</option>
<option>GÃ©nie Logiciel (L2)</option>
<option>RÃ©seaux &amp; TÃ©lÃ©coms (L1)</option>
<option>Cyber-sÃ©curitÃ© (M1)</option>
<option>Intelligence Artificielle (M2)</option>
</select>
</div>
<!-- Nom -->
<div class="md:col-span-1">
<label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Nom de famille</label>
<input class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="Entrez le nom" type="text"/>
</div>
<!-- PrÃ©nom -->
<div class="md:col-span-1">
<label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">PrÃ©noms</label>
<input class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="Entrez les prÃ©noms" type="text"/>
</div>
<!-- Date de naissance -->
<div class="md:col-span-1">
<label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Date de naissance</label>
<div class="relative">
<input class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" type="date"/>
</div>
</div>
<!-- Lieu de naissance -->
<div class="md:col-span-1">
<label class="block text-xs font-bold uppercase tracking-wider text-slate-500 mb-2">Lieu de naissance</label>
<input class="w-full bg-surface-container-low border-none rounded-lg py-3 px-4 text-sm focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all outline-none" placeholder="Ville, Pays" type="text"/>
</div>
</form>
</div>
<div class="flex justify-end gap-4">
<button class="px-6 py-3 rounded-lg font-bold text-sm text-slate-500 hover:bg-slate-100 transition-colors">RÃ©initialiser</button>
<button class="px-10 py-3 rounded-lg font-bold text-sm bg-primary text-on-primary shadow-lg shadow-primary/20 hover:bg-primary-container transition-all flex items-center gap-2">
                            Valider l'inscription
                            <span class="material-symbols-outlined text-lg" data-icon="check_circle">check_circle</span>
</button>
</div>
</div>
<!-- Profile Photo Upload & Status -->
<aside class="lg:col-span-4 space-y-6">
<!-- Photo Upload -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] text-center">
<h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-6 text-left">Photo d'identitÃ©</h4>
<div class="relative group cursor-pointer border-2 border-dashed border-outline-variant/30 rounded-xl p-8 hover:border-primary/50 hover:bg-primary/5 transition-all">
<div class="mb-4">
<span class="material-symbols-outlined text-5xl text-slate-300" data-icon="add_a_photo">add_a_photo</span>
</div>
<p class="text-sm font-medium text-slate-600">Glissez-dÃ©posez la photo ici</p>
<p class="text-[10px] text-slate-400 mt-1">PNG, JPG ou JPEG (Max. 2 Mo)</p>
<input class="absolute inset-0 opacity-0 cursor-pointer" type="file"/>
</div>
<div class="mt-6 p-4 bg-surface-container-low rounded-lg text-left">
<div class="flex items-start gap-3">
<span class="material-symbols-outlined text-primary text-xl" data-icon="info">info</span>
<p class="text-[11px] text-slate-500 leading-relaxed">Format recommandÃ© : 4x4cm, fond uni blanc ou bleu clair, visage centrÃ©.</p>
</div>
</div>
</div>
<!-- Enrollment Summary Card -->
<div class="bg-primary text-on-primary p-6 rounded-xl shadow-lg relative overflow-hidden">
<div class="relative z-10">
<h4 class="text-xs font-bold uppercase tracking-widest opacity-70 mb-4">Statistiques Session 2024</h4>
<div class="space-y-4">
<div class="flex justify-between items-end">
<span class="text-sm">Inscrits ce jour</span>
<span class="text-2xl font-black">12</span>
</div>
<div class="w-full bg-white/20 h-1 rounded-full overflow-hidden">
<div class="bg-white h-full w-[65%]"></div>
</div>
<p class="text-[10px] opacity-80">Objectif journalier atteint Ã  65%</p>
</div>
</div>
<!-- Abstract pattern background -->
<div class="absolute -right-8 -bottom-8 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
</div>
</aside>
</div>
<!-- Recent Students List -->
<section class="mt-16">
<div class="flex items-center justify-between mb-6">
<div>
<h4 class="text-xl font-bold">Derniers Ã‰tudiants Inscrits</h4>
<p class="text-sm text-slate-500">AperÃ§u en temps rÃ©el des enregistrements rÃ©cents.</p>
</div>
<button class="flex items-center gap-2 text-primary font-bold text-sm hover:underline">
                        Voir tout le registre
                        <span class="material-symbols-outlined text-sm" data-icon="arrow_forward">arrow_forward</span>
</button>
</div>
<div class="bg-surface-container-lowest rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] overflow-hidden">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low/50">
<th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Ã‰tudiant</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Matricule</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">FiliÃ¨re</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Date Inscription</th>
<th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Statut</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<tr class="group hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="h-10 w-10 rounded-full bg-slate-100 overflow-hidden">
<img alt="Student 1" class="h-full w-full object-cover" data-alt="Portrait of a young male student" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBQSm8RRj6RIKq_8eHog7Mf52J0sIa4jVmgmfjjbirH4K8FsSjcoxkIS6h72RsT4igSFlLjv3j7vaEbz0aE5Cw6GGwcaW3q28LuEKWd5oW-tZOtqz-ANaYfSbC4V-62LxDFdL3jENREYcB6SAxuspqP1-r8-0JkgQjxFs420IWTnMXBWDIPNP0sPf-RULBg3nc__wPdMsNUYxQjGjZ5sLBMPKwDQvSY81h4FRl1biNb2LlC0Sivl4jMw8CuQ10hHR5uBkcOvCPl7as"/>
</div>
<div>
<p class="text-sm font-bold text-on-surface">KAMARA Ismael</p>
<p class="text-xs text-slate-500">NÃ© le 12/05/2003</p>
</div>
</div>
</td>
<td class="px-6 py-4 text-sm font-medium text-slate-600">LMD-2024-156</td>
<td class="px-6 py-4 text-sm text-slate-600">GÃ©nie Logiciel (L3)</td>
<td class="px-6 py-4 text-sm text-slate-500">14 Oct. 2024, 09:45</td>
<td class="px-6 py-4 text-right">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-secondary-container text-on-secondary-container">
                                        ValidÃ©
                                    </span>
</td>
</tr>
<tr class="group hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="h-10 w-10 rounded-full bg-slate-100 overflow-hidden">
<img alt="Student 2" class="h-full w-full object-cover" data-alt="Portrait of a young female student" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBWeMqMAByEK2IhrDTw1jdr4-ncv0G0PhexqduJaSSff79zJMlDcsfVyP3z0hB3TWyQWvw-k_T3RlxQMu7aKrehcaN-kCxrU5WltaPc1DWN-bnv497B3lqsKAMkP-RvHstyUEC0M-ZDuCZ7UcmtsC1VrJpDOaj6256g_XUjWLKQJii8Fg10bJWG0BiI9i9Y8g9AkliSiIqffmiHaS4aoJ4TzgQs5d7MDANn99WN7gCY6kllgCsokFPIpi0bkZ6u8nEoyc4LDqpam1s"/>
</div>
<div>
<p class="text-sm font-bold text-on-surface">TRAORE Mariam</p>
<p class="text-xs text-slate-500">NÃ© le 25/08/2004</p>
</div>
</div>
</td>
<td class="px-6 py-4 text-sm font-medium text-slate-600">LMD-2024-157</td>
<td class="px-6 py-4 text-sm text-slate-600">Infographie (L1)</td>
<td class="px-6 py-4 text-sm text-slate-500">14 Oct. 2024, 10:12</td>
<td class="px-6 py-4 text-right">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-secondary-container text-on-secondary-container">
                                        ValidÃ©
                                    </span>
</td>
</tr>
<tr class="group hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4">
<div class="flex items-center gap-3">
<div class="h-10 w-10 rounded-full bg-slate-100 overflow-hidden">
<img alt="Student 3" class="h-full w-full object-cover" data-alt="Portrait of a young male student in profile" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBqITQoiKjdgE-tNMur7qjheD-BGrbTFwKHsteNcPwwWZuh4Ue6Fgj9I5enTGSoTJRO8Yr1Qc31gDoeD0hM_kAx41iH8Ke5dUCq1hPTNGYKj8GHNQ-D05v0zuOXszmvzpbM---gc1nDUiyFaYKPdbu-bAauSz_otMgy3ltxAXb4jgTavb0lzpLb4OGrzOXvmqKCyX_jzv5ScNeLwSpHC6hKdyAsrGJckXEhThSCT6Qc_3gGrQdGNCrN0enw3JwnjWWOF06ssdarpcY"/>
</div>
<div>
<p class="text-sm font-bold text-on-surface">DIALLO Mamadou</p>
<p class="text-xs text-slate-500">NÃ© le 05/01/2002</p>
</div>
</div>
</td>
<td class="px-6 py-4 text-sm font-medium text-slate-600">LMD-2024-158</td>
<td class="px-6 py-4 text-sm text-slate-600">Cyber-sÃ©curitÃ© (M1)</td>
<td class="px-6 py-4 text-sm text-slate-500">14 Oct. 2024, 11:30</td>
<td class="px-6 py-4 text-right">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold tracking-wider uppercase bg-tertiary-container text-on-tertiary-container">
                                        En attente
                                    </span>
</td>
</tr>
</tbody>
</table>
</div>
</section>
</div>
</main>
<!-- FAB (Floating Action Button) - Contextual for high-level screens -->
<button class="fixed bottom-8 right-8 h-14 w-14 bg-primary text-on-primary rounded-full shadow-2xl flex items-center justify-center active:scale-95 transition-transform group">
<span class="material-symbols-outlined text-2xl" data-icon="print">print</span>
<span class="absolute right-full mr-4 bg-inverse-surface text-inverse-on-surface px-3 py-1.5 rounded-lg text-xs font-bold opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Imprimer Formulaire
        </span>
</button>
</body></html>
