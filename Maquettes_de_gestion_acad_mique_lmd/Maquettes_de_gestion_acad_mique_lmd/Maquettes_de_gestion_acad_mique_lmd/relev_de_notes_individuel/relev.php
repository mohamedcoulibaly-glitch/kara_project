<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "outline-variant": "#c3c5d7",
              "on-primary-container": "#d4dcff",
              "inverse-on-surface": "#eff1f3",
              "secondary": "#4b5c92",
              "surface-container": "#eceef0",
              "inverse-primary": "#b5c4ff",
              "inverse-surface": "#2d3133",
              "surface-bright": "#f7f9fb",
              "on-tertiary": "#ffffff",
              "on-error": "#ffffff",
              "surface-dim": "#d8dadc",
              "on-secondary-fixed-variant": "#334479",
              "on-tertiary-fixed": "#380d00",
              "on-primary": "#ffffff",
              "primary-fixed-dim": "#b5c4ff",
              "surface-container-highest": "#e0e3e5",
              "on-tertiary-fixed-variant": "#802a00",
              "primary-container": "#1a56db",
              "on-primary-fixed": "#00174d",
              "on-background": "#191c1e",
              "surface": "#f7f9fb",
              "surface-container-high": "#e6e8ea",
              "on-surface": "#191c1e",
              "on-tertiary-container": "#ffd4c5",
              "error": "#ba1a1a",
              "tertiary-fixed": "#ffdbcf",
              "tertiary-container": "#ad3b00",
              "error-container": "#ffdad6",
              "on-secondary-container": "#3d4e84",
              "on-secondary": "#ffffff",
              "surface-container-lowest": "#ffffff",
              "tertiary": "#852b00",
              "on-secondary-fixed": "#01174b",
              "on-primary-fixed-variant": "#003dab",
              "background": "#f7f9fb",
              "secondary-container": "#b1c2ff",
              "surface-container-low": "#f2f4f6",
              "on-surface-variant": "#434654",
              "surface-variant": "#e0e3e5",
              "surface-tint": "#1353d8",
              "secondary-fixed": "#dbe1ff",
              "on-error-container": "#93000a",
              "secondary-fixed-dim": "#b5c4ff",
              "tertiary-fixed-dim": "#ffb59a",
              "outline": "#737686",
              "primary-fixed": "#dbe1ff",
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
            vertical-align: middle;
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-surface text-on-surface">
<!-- Sidebar Navigation -->
<aside class="hidden md:flex flex-col h-screen w-64 fixed left-0 top-0 bg-slate-50 border-r border-slate-200 z-50">
<div class="p-6">
<h2 class="font-bold text-blue-800 text-lg">Gestion AcadÃ©mique</h2>
<p class="text-xs text-slate-500 font-medium">SystÃ¨me LMD</p>
</div>
<nav class="flex-1 px-4 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-200 transition-all rounded-xl font-medium text-sm" href="#">
<span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                Tableau de bord
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-200 transition-all rounded-xl font-medium text-sm" href="#">
<span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
                FiliÃ¨res
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-blue-700 border-r-4 border-blue-700 bg-blue-50 transition-all rounded-r-none font-semibold text-sm" href="#">
<span class="material-symbols-outlined" data-icon="school">school</span>
                Ã‰tudiants
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-200 transition-all rounded-xl font-medium text-sm" href="#">
<span class="material-symbols-outlined" data-icon="grade">grade</span>
                Notes
            </a>
</nav>
<div class="p-4 border-t border-slate-200 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-200 transition-all rounded-xl font-medium text-sm" href="#">
<span class="material-symbols-outlined" data-icon="help">help</span>
                Aide
            </a>
<a class="flex items-center gap-3 px-4 py-3 text-slate-500 hover:bg-slate-200 transition-all rounded-xl font-medium text-sm" href="#">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
                DÃ©connexion
            </a>
</div>
</aside>
<main class="md:ml-64 min-h-screen">
<!-- Top App Bar -->
<header class="sticky top-0 w-full flex justify-between items-center px-6 py-3 bg-white/80 backdrop-blur-md shadow-sm z-40">
<div class="flex items-center gap-4">
<h1 class="text-xl font-bold tracking-tight text-blue-700 font-inter antialiased">Academia LMD</h1>
</div>
<div class="flex items-center gap-4">
<div class="hidden md:flex bg-surface-container rounded-full px-4 py-1.5 items-center gap-2">
<span class="material-symbols-outlined text-sm text-outline" data-icon="search">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-48" placeholder="Rechercher..." type="text"/>
</div>
<button class="p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="p-2 text-slate-600 hover:bg-slate-100 rounded-full transition-colors">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
</button>
<img alt="Photo de profil de l'Ã©tudiant" class="w-8 h-8 rounded-full border border-outline-variant" data-alt="User profile photo of a male student" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDPycg_MUhFu6EDprvM00V9afLJIqZCI_qSwZotVJun-ViGfcbrCQH1tjjg0erUoj8xzGPGDuPrvB9r2Fn1xB4jdNVOI3LzWKjSTqou-ogLbnEe5gKmykm7gkTdP4m8YU9C6gwD1vrtC74XZA8K_OpLqydwnUSd6mGajFl2B2B1LMWPmjaw47NKf8166LIeELSFgOKhi4zVwizrGp-DwPVAmjEKTmiZSQzXa1uf1EYkpw6I4eF6nk7lPhWczu0QFNzaI-bF8QEzdWo"/>
</div>
</header>
<div class="p-6 md:p-10 space-y-8 max-w-7xl mx-auto">
<!-- Student Profile Hero Section -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6">
<!-- Profile Card -->
<div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-8 flex flex-col md:flex-row items-center md:items-start gap-8 shadow-sm">
<div class="relative">
<img alt="KOUAMÃ‰ Jean-Luc Koffi" class="w-32 h-32 rounded-xl object-cover border-4 border-surface-container" data-alt="Professional portrait of Jean-Luc Koffi" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBPsERi3fTmk62_Tf_DTza8gjGWB15sNedlpUhBfulSCmLwj81iBvLmmgiKOPkJfTpzKcFpMJShQKNWEEK5xMSB3XsKRAIsmeVwx9FbwZ9AMYa1NRwU-_ou-2n-Fv285ZAbiwp_Mx79HFBTDc13s9OyT12O2qY_HmkONDzJAX1RsDNbJOW-x6rdboyRfgkkFahuU7LnxoNjtTrdOfM5iGcTySycct5paU0f4D3qpksH4U_JLudRuxSx40ia-HH7LLdRNuHVUs61Uto"/>
<div class="absolute -bottom-2 -right-2 bg-primary text-white p-1.5 rounded-lg shadow-lg">
<span class="material-symbols-outlined text-sm" data-icon="verified">verified</span>
</div>
</div>
<div class="flex-1 space-y-4 text-center md:text-left">
<div>
<span class="text-xs font-bold text-primary tracking-widest uppercase">Fiche Ã‰tudiant</span>
<h2 class="text-3xl font-extrabold text-on-surface mt-1">KOUAMÃ‰ Jean-Luc Koffi</h2>
<p class="text-on-surface-variant font-medium">Licence GÃ©nie Logiciel â€” Semestre 5</p>
</div>
<div class="grid grid-cols-2 gap-4 pt-4">
<div class="space-y-1">
<p class="text-xs text-outline font-semibold uppercase">Matricule</p>
<p class="text-sm font-bold">23CS-0045</p>
</div>
<div class="space-y-1">
<p class="text-xs text-outline font-semibold uppercase">AnnÃ©e AcadÃ©mique</p>
<p class="text-sm font-bold">2023-2024</p>
</div>
</div>
</div>
<div class="flex flex-col gap-3 w-full md:w-auto">
<button class="flex items-center justify-center gap-2 px-6 py-2.5 bg-primary text-white rounded-md font-semibold text-sm hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined text-lg" data-icon="picture_as_pdf">picture_as_pdf</span>
                            Exporter en PDF
                        </button>
<button class="flex items-center justify-center gap-2 px-6 py-2.5 border border-outline-variant text-on-surface-variant rounded-md font-semibold text-sm hover:bg-surface-container-low transition-colors">
<span class="material-symbols-outlined text-lg" data-icon="share">share</span>
                            Partager
                        </button>
</div>
</div>
<!-- Stats Bento -->
<div class="grid grid-cols-2 gap-4">
<div class="bg-primary text-white p-6 rounded-xl flex flex-col justify-between shadow-lg">
<span class="material-symbols-outlined text-3xl opacity-50" data-icon="analytics">analytics</span>
<div>
<p class="text-4xl font-extrabold tracking-tight">13.45</p>
<p class="text-xs font-medium opacity-80 mt-1 uppercase">Moyenne GÃ©nÃ©rale</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col justify-between shadow-sm border border-surface-container">
<span class="material-symbols-outlined text-3xl text-secondary" data-icon="military_tech">military_tech</span>
<div>
<p class="text-4xl font-extrabold tracking-tight text-on-surface">4<sup>Ã¨me</sup></p>
<p class="text-xs font-medium text-outline mt-1 uppercase">Rang National</p>
</div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl flex flex-col justify-between shadow-sm border border-surface-container">
<span class="material-symbols-outlined text-3xl text-primary" data-icon="task_alt">task_alt</span>
<div>
<p class="text-4xl font-extrabold tracking-tight text-on-surface">30/60</p>
<p class="text-xs font-medium text-outline mt-1 uppercase">CrÃ©dits ECTS</p>
</div>
</div>
<div class="bg-secondary-container p-6 rounded-xl flex flex-col justify-between shadow-sm">
<span class="material-symbols-outlined text-3xl text-on-secondary-container" data-icon="pending_actions">pending_actions</span>
<div>
<p class="text-xl font-extrabold text-on-secondary-container leading-tight">EN COURS</p>
<p class="text-xs font-medium text-on-secondary-container opacity-80 mt-1 uppercase">Statut AnnÃ©e</p>
</div>
</div>
</div>
</section>
<!-- Academic Transcript Table -->
<section class="space-y-6">
<div class="flex items-center justify-between px-2">
<h3 class="text-xl font-bold text-on-surface">DÃ©tails des UnitÃ©s d'Enseignement</h3>
<div class="flex gap-2">
<span class="flex items-center gap-1.5 px-3 py-1 bg-surface-container-low text-on-surface-variant text-xs font-bold rounded-full">
<span class="w-2 h-2 rounded-full bg-secondary"></span> SEMESTRE 5
                        </span>
</div>
</div>
<div class="overflow-hidden bg-surface-container-lowest rounded-xl shadow-sm">
<table class="w-full text-left border-collapse">
<thead class="bg-surface-container-low text-outline font-bold text-[10px] uppercase tracking-widest">
<tr>
<th class="px-6 py-4">Code &amp; LibellÃ© UE</th>
<th class="px-6 py-4 text-right">CrÃ©dits</th>
<th class="px-6 py-4 text-right">Moyenne</th>
<th class="px-6 py-4 text-center">Statut</th>
<th class="px-6 py-4 w-10"></th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<!-- UE 1 -->
<tr class="hover:bg-surface-container-low/50 transition-colors group cursor-pointer">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-xs font-bold text-primary">UE-GL501</span>
<span class="text-sm font-bold text-on-surface">DÃ©veloppement Logiciel AvancÃ©</span>
</div>
</td>
<td class="px-6 py-5 text-right font-bold text-sm">6</td>
<td class="px-6 py-5 text-right font-bold text-sm text-primary">15.20</td>
<td class="px-6 py-5 text-center">
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-[10px] font-bold rounded-full uppercase tracking-wider">ValidÃ©</span>
</td>
<td class="px-6 py-5 text-right">
<span class="material-symbols-outlined text-outline group-hover:text-primary transition-colors" data-icon="expand_more">expand_more</span>
</td>
</tr>
<!-- Sub-table for EC (expanded view simulation) -->
<tr class="bg-surface-container-low/30">
<td class="px-12 py-0" colspan="5">
<div class="border-l-2 border-primary-container ml-2 my-4 space-y-0.5">
<!-- EC Item -->
<div class="flex justify-between items-center py-3 px-6 hover:bg-white rounded-r-lg transition-colors">
<div class="flex flex-col">
<span class="text-[11px] text-outline font-medium">EC 501.1</span>
<span class="text-sm font-semibold text-on-surface-variant">Architecture Cloud-Native</span>
</div>
<div class="flex items-center gap-12">
<div class="text-right">
<p class="text-[10px] text-outline uppercase font-bold">Coef.</p>
<p class="text-xs font-bold">3</p>
</div>
<div class="text-right">
<p class="text-[10px] text-outline uppercase font-bold">Note</p>
<p class="text-xs font-bold text-primary">14.50</p>
</div>
<div class="w-24 text-center">
<span class="text-[10px] text-outline font-bold uppercase">Session Normale</span>
</div>
</div>
</div>
<!-- EC Item -->
<div class="flex justify-between items-center py-3 px-6 hover:bg-white rounded-r-lg transition-colors">
<div class="flex flex-col">
<span class="text-[11px] text-outline font-medium">EC 501.2</span>
<span class="text-sm font-semibold text-on-surface-variant">Microservices &amp; APIs</span>
</div>
<div class="flex items-center gap-12">
<div class="text-right">
<p class="text-[10px] text-outline uppercase font-bold">Coef.</p>
<p class="text-xs font-bold">3</p>
</div>
<div class="text-right">
<p class="text-[10px] text-outline uppercase font-bold">Note</p>
<p class="text-xs font-bold text-primary">15.90</p>
</div>
<div class="w-24 text-center">
<span class="text-[10px] text-outline font-bold uppercase">Session Normale</span>
</div>
</div>
</div>
</div>
</td>
</tr>
<!-- UE 2 -->
<tr class="hover:bg-surface-container-low/50 transition-colors group cursor-pointer">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-xs font-bold text-primary">UE-GL502</span>
<span class="text-sm font-bold text-on-surface">Base de DonnÃ©es et Big Data</span>
</div>
</td>
<td class="px-6 py-5 text-right font-bold text-sm">4</td>
<td class="px-6 py-5 text-right font-bold text-sm text-primary">12.00</td>
<td class="px-6 py-5 text-center">
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-[10px] font-bold rounded-full uppercase tracking-wider">ValidÃ©</span>
</td>
<td class="px-6 py-5 text-right">
<span class="material-symbols-outlined text-outline" data-icon="expand_more">expand_more</span>
</td>
</tr>
<!-- UE 3 -->
<tr class="hover:bg-surface-container-low/50 transition-colors group cursor-pointer">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-xs font-bold text-primary">UE-GL503</span>
<span class="text-sm font-bold text-on-surface">Anglais Technique &amp; Communication</span>
</div>
</td>
<td class="px-6 py-5 text-right font-bold text-sm">2</td>
<td class="px-6 py-5 text-right font-bold text-sm text-error">08.50</td>
<td class="px-6 py-5 text-center">
<span class="px-3 py-1 bg-tertiary-container text-on-tertiary-container text-[10px] font-bold rounded-full uppercase tracking-wider">Rattrapage</span>
</td>
<td class="px-6 py-5 text-right">
<span class="material-symbols-outlined text-outline" data-icon="expand_more">expand_more</span>
</td>
</tr>
<!-- UE 4 -->
<tr class="hover:bg-surface-container-low/50 transition-colors group cursor-pointer">
<td class="px-6 py-5">
<div class="flex flex-col">
<span class="text-xs font-bold text-primary">UE-GL504</span>
<span class="text-sm font-bold text-on-surface">Gestion de Projet Agile</span>
</div>
</td>
<td class="px-6 py-5 text-right font-bold text-sm">3</td>
<td class="px-6 py-5 text-right font-bold text-sm text-primary">16.00</td>
<td class="px-6 py-5 text-center">
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container text-[10px] font-bold rounded-full uppercase tracking-wider">ValidÃ©</span>
</td>
<td class="px-6 py-5 text-right">
<span class="material-symbols-outlined text-outline" data-icon="expand_more">expand_more</span>
</td>
</tr>
</tbody>
</table>
</div>
</section>
<!-- Bottom Disclaimer & Info -->
<footer class="pt-8 border-t border-surface-container flex flex-col md:flex-row justify-between items-start md:items-center gap-4 text-[11px] text-outline font-medium uppercase tracking-widest">
<p>Â© 2024 Academia LMD â€” Document GÃ©nÃ©rÃ© Automatiquement</p>
<div class="flex gap-6">
<span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm" data-icon="lock">lock</span> DonnÃ©es CertifiÃ©es</span>
<span class="flex items-center gap-2"><span class="material-symbols-outlined text-sm" data-icon="verified_user">verified_user</span> Signature NumÃ©rique Active</span>
</div>
</footer>
</div>
</main>
<!-- FAB for quick action (Mobile Only) -->
<button class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center z-50">
<span class="material-symbols-outlined text-2xl" data-icon="picture_as_pdf">picture_as_pdf</span>
</button>
</body></html>
