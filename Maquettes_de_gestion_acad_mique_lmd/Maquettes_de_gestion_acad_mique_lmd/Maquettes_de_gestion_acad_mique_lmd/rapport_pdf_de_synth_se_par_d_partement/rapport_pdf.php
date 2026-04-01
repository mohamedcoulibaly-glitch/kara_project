<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
      tailwind.config = {
        darkMode: "class",
        theme: {
          extend: {
            colors: {
              "surface-bright": "#f7f9fb",
              "tertiary": "#852b00",
              "on-tertiary": "#ffffff",
              "error-container": "#ffdad6",
              "secondary-fixed-dim": "#b5c4ff",
              "surface-container-highest": "#e0e3e5",
              "secondary-fixed": "#dbe1ff",
              "outline": "#737686",
              "surface-dim": "#d8dadc",
              "on-primary-container": "#d4dcff",
              "tertiary-fixed-dim": "#ffb59a",
              "surface-tint": "#1353d8",
              "on-tertiary-fixed": "#380d00",
              "background": "#f7f9fb",
              "on-primary-fixed": "#00174d",
              "on-surface": "#191c1e",
              "tertiary-fixed": "#ffdbcf",
              "secondary": "#4b5c92",
              "primary": "#003fb1",
              "on-secondary-fixed-variant": "#334479",
              "surface-variant": "#e0e3e5",
              "surface": "#f7f9fb",
              "error": "#ba1a1a",
              "primary-fixed-dim": "#b5c4ff",
              "on-primary": "#ffffff",
              "on-secondary-fixed": "#01174b",
              "secondary-container": "#b1c2ff",
              "outline-variant": "#c3c5d7",
              "surface-container-low": "#f2f4f6",
              "on-tertiary-fixed-variant": "#802a00",
              "on-secondary-container": "#3d4e84",
              "inverse-primary": "#b5c4ff",
              "on-surface-variant": "#434654",
              "tertiary-container": "#ad3b00",
              "surface-container-lowest": "#ffffff",
              "on-secondary": "#ffffff",
              "primary-fixed": "#dbe1ff",
              "on-background": "#191c1e",
              "primary-container": "#1a56db",
              "on-primary-fixed-variant": "#003dab",
              "inverse-on-surface": "#eff1f3",
              "on-tertiary-container": "#ffd4c5",
              "inverse-surface": "#2d3133",
              "on-error-container": "#93000a",
              "on-error": "#ffffff",
              "surface-container-high": "#e6e8ea",
              "surface-container": "#eceef0"
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
            vertical-align: middle;
        }
        .a4-document {
            width: 210mm;
            min-height: 297mm;
            padding: 25mm;
            margin: auto;
            background: white;
            box-shadow: 0 12px 32px rgba(25, 28, 30, 0.04);
        }
        @media print {
            body { background: white; }
            .no-print { display: none; }
            .a4-document { box-shadow: none; margin: 0; padding: 15mm; width: 100%; }
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-xl shadow-sm flex justify-between items-center px-8 py-3 w-full mx-auto no-print">
<div class="flex items-center gap-4">
<span class="text-xl font-bold tracking-tighter text-blue-700">LMD Horizon</span>
<nav class="hidden md:flex items-center gap-6 ml-10">
<a class="text-slate-500 hover:text-blue-600 transition-colors" href="#">Tableau de bord</a>
<a class="text-slate-500 hover:text-blue-600 transition-colors" href="#">DÃ©partements</a>
<a class="text-blue-700 font-semibold border-b-2 border-blue-700 pb-1" href="#">Rapports</a>
<a class="text-slate-500 hover:text-blue-600 transition-colors" href="#">ParamÃ¨tres</a>
</nav>
</div>
<div class="flex items-center gap-3">
<button class="p-2 hover:bg-slate-100/50 rounded-lg transition-all active:scale-95 duration-150">
<span class="material-symbols-outlined text-slate-600" data-icon="notifications">notifications</span>
</button>
<div class="h-8 w-8 rounded-full bg-primary-fixed flex items-center justify-center overflow-hidden">
<img alt="Photo de profil administrateur" class="w-full h-full object-cover" data-alt="Admin user profile professional headshot" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQANE1_qR8Bd5Ycuj01JuwqjdMUUOKFbUg0jDhNcVBO506XKfI1CnK8e6UrloDZEEbBnwWSxmaGqv0wYQuMn1JloCbFkvBXP7NLMnZlwSBgegIQNCUodBSHDd01PLg5GaiYZG_1Vy0ATgDHpNSP_7Os6tv4lnWjhU7jjvfLOUcHtXhBysFRkIgGEbklai96cyvtNW2D00WLAZlAnm6jLjo_AisleIJ4ODKEO7zPMP5KRTCcbXSwwUIaVW3iV6Vcp4zlW5-zjyEgqA"/>
</div>
</div>
</header>
<!-- Sidebar (Hidden on Mobile) -->
<aside class="hidden lg:flex flex-col h-screen w-64 fixed left-0 top-0 pt-16 bg-slate-50 border-r border-slate-200/50 no-print">
<div class="px-6 py-8 flex flex-col gap-1">
<div class="h-12 w-12 bg-white rounded-lg flex items-center justify-center mb-4 shadow-sm">
<span class="material-symbols-outlined text-blue-800 text-3xl" data-icon="account_balance">account_balance</span>
</div>
<h2 class="font-black text-blue-800 text-lg">FacultÃ© des Sciences</h2>
<p class="text-xs text-slate-500 font-medium">Portail de Gestion LMD</p>
</div>
<nav class="flex-1 flex flex-col gap-1 mt-4">
<a class="text-slate-600 hover:bg-slate-100 py-3 px-6 transition-all hover:translate-x-1 flex items-center gap-3 text-sm font-medium" href="#">
<span class="material-symbols-outlined text-xl" data-icon="analytics">analytics</span> SynthÃ¨se Globale
            </a>
<a class="bg-blue-50 text-blue-700 rounded-r-full py-3 px-6 flex items-center gap-3 text-sm font-medium" href="#">
<span class="material-symbols-outlined text-xl" data-icon="equalizer" style="font-variation-settings: 'FILL' 1;">equalizer</span> Statistique Mentions
            </a>
<a class="text-slate-600 hover:bg-slate-100 py-3 px-6 transition-all hover:translate-x-1 flex items-center gap-3 text-sm font-medium" href="#">
<span class="material-symbols-outlined text-xl" data-icon="picture_as_pdf">picture_as_pdf</span> Archive PDF
            </a>
<a class="text-slate-600 hover:bg-slate-100 py-3 px-6 transition-all hover:translate-x-1 flex items-center gap-3 text-sm font-medium" href="#">
<span class="material-symbols-outlined text-xl" data-icon="settings">settings</span> Configuration
            </a>
</nav>
<div class="p-6 mt-auto flex flex-col gap-2">
<button class="w-full bg-primary text-white py-2.5 rounded-md text-sm font-semibold shadow-md hover:bg-primary-container transition-all">
                Nouveau Rapport
            </button>
<div class="flex flex-col gap-1 pt-4">
<a class="text-slate-400 hover:text-slate-600 py-1 flex items-center gap-2 text-xs uppercase tracking-widest font-semibold" href="#">
<span class="material-symbols-outlined text-sm" data-icon="help">help</span> Aide
                </a>
<a class="text-slate-400 hover:text-slate-600 py-1 flex items-center gap-2 text-xs uppercase tracking-widest font-semibold" href="#">
<span class="material-symbols-outlined text-sm" data-icon="logout">logout</span> DÃ©connexion
                </a>
</div>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="flex-1 lg:ml-64 pt-24 pb-12 px-4 md:px-8">
<!-- Toolbar Actions -->
<div class="max-w-[210mm] mx-auto mb-8 flex flex-col sm:flex-row justify-between items-center gap-4 no-print">
<div class="flex flex-col">
<h1 class="text-2xl font-headline font-bold text-on-surface tracking-tight">PrÃ©visualisation du Rapport</h1>
<p class="text-sm text-on-surface-variant">DÃ©partement Informatique â€¢ GÃ©nÃ©rÃ© le 24 Mai 2024</p>
</div>
<div class="flex items-center gap-2">
<button class="flex items-center gap-2 px-4 py-2 rounded-md border border-outline-variant hover:bg-surface-container-low transition-colors text-sm font-medium" onclick="window.print()">
<span class="material-symbols-outlined text-lg" data-icon="print">print</span> Imprimer
                </button>
<button class="flex items-center gap-2 px-4 py-2 rounded-md bg-secondary text-on-secondary hover:bg-on-secondary-fixed-variant transition-colors text-sm font-medium">
<span class="material-symbols-outlined text-lg" data-icon="download">download</span> TÃ©lÃ©charger PDF
                </button>
<button class="flex items-center gap-2 px-4 py-2 rounded-md bg-primary text-on-primary hover:bg-primary-container transition-all shadow-sm text-sm font-medium">
<span class="material-symbols-outlined text-lg" data-icon="mail">mail</span> Envoyer par Email
                </button>
</div>
</div>
<!-- Document Preview Container -->
<div class="a4-document border border-slate-100 flex flex-col">
<!-- Header -->
<div class="flex justify-between items-start border-b border-slate-100 pb-8 mb-10">
<div class="flex items-center gap-4">
<div class="w-16 h-16 bg-blue-50 flex items-center justify-center rounded-lg">
<span class="material-symbols-outlined text-4xl text-blue-700" data-icon="account_balance" style="font-variation-settings: 'FILL' 1;">account_balance</span>
</div>
<div>
<h3 class="font-bold text-slate-800 text-lg leading-tight">UniversitÃ© des Sciences AppliquÃ©es</h3>
<p class="text-xs text-slate-500 uppercase tracking-widest font-semibold">Direction des Ã‰tudes &amp; Examens</p>
</div>
</div>
<div class="text-right">
<h2 class="text-sm font-bold text-primary tracking-widest uppercase">Rapport de SynthÃ¨se AcadÃ©mique</h2>
<p class="text-xs text-slate-600 font-medium">AnnÃ©e AcadÃ©mique 2023-2024</p>
<p class="text-[10px] text-slate-400 font-bold uppercase mt-1">Session Normale</p>
</div>
</div>
<!-- Content Area -->
<div class="flex-1 space-y-12">
<!-- 1. RÃ©sumÃ© ExÃ©cutif -->
<section>
<div class="flex items-center gap-2 mb-6">
<div class="h-1 w-8 bg-primary rounded-full"></div>
<h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">01. RÃ©sumÃ© ExÃ©cutif</h4>
</div>
<div class="grid grid-cols-3 gap-6">
<div class="bg-surface-container-low p-6 rounded-lg text-center">
<p class="text-xs font-semibold text-slate-500 uppercase mb-2">Taux de RÃ©ussite</p>
<p class="text-3xl font-black text-primary tracking-tighter">82%</p>
<div class="w-full bg-slate-200 h-1.5 rounded-full mt-3 overflow-hidden">
<div class="bg-primary h-full w-[82%]"></div>
</div>
</div>
<div class="bg-surface-container-low p-6 rounded-lg text-center">
<p class="text-xs font-semibold text-slate-500 uppercase mb-2">Moyenne GÃ©nÃ©rale</p>
<p class="text-3xl font-black text-primary tracking-tighter">14.12</p>
<p class="text-[10px] text-slate-400 font-bold uppercase mt-2">Sur 20 points</p>
</div>
<div class="bg-surface-container-low p-6 rounded-lg text-center">
<p class="text-xs font-semibold text-slate-500 uppercase mb-2">Effectif Total</p>
<p class="text-3xl font-black text-primary tracking-tighter">1,240</p>
<p class="text-[10px] text-slate-400 font-bold uppercase mt-2">Ã‰tudiants Inscrits</p>
</div>
</div>
</section>
<!-- 2. DÃ©tail par FiliÃ¨re -->
<section>
<div class="flex items-center gap-2 mb-6">
<div class="h-1 w-8 bg-primary rounded-full"></div>
<h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">02. DÃ©tail par FiliÃ¨re</h4>
</div>
<div class="overflow-hidden rounded-lg border border-slate-50">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-slate-50 text-[10px] uppercase font-bold text-slate-400 tracking-wider">
<th class="px-6 py-4">FiliÃ¨re d'Ã‰tude</th>
<th class="px-6 py-4 text-center">Effectif</th>
<th class="px-6 py-4 text-right">Taux de Validation</th>
<th class="px-6 py-4 text-right">Moyenne FiliÃ¨re</th>
</tr>
</thead>
<tbody class="text-sm divide-y divide-slate-50">
<tr class="hover:bg-slate-50 transition-colors">
<td class="px-6 py-4 font-semibold text-slate-700">Licence GÃ©nie Logiciel</td>
<td class="px-6 py-4 text-center text-slate-600">450</td>
<td class="px-6 py-4 text-right">
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-[10px] font-bold">85.5%</span>
</td>
<td class="px-6 py-4 text-right font-medium">13.80</td>
</tr>
<tr class="hover:bg-slate-50 transition-colors">
<td class="px-6 py-4 font-semibold text-slate-700">Master Data Science</td>
<td class="px-6 py-4 text-center text-slate-600">120</td>
<td class="px-6 py-4 text-right">
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-[10px] font-bold">92.0%</span>
</td>
<td class="px-6 py-4 text-right font-medium">15.45</td>
</tr>
<tr class="hover:bg-slate-50 transition-colors">
<td class="px-6 py-4 font-semibold text-slate-700">Licence CybersÃ©curitÃ©</td>
<td class="px-6 py-4 text-center text-slate-600">380</td>
<td class="px-6 py-4 text-right">
<span class="px-3 py-1 bg-tertiary-container text-on-tertiary-container rounded-full text-[10px] font-bold">78.2%</span>
</td>
<td class="px-6 py-4 text-right font-medium">12.15</td>
</tr>
<tr class="hover:bg-slate-50 transition-colors">
<td class="px-6 py-4 font-semibold text-slate-700">Master RÃ©seaux &amp; TÃ©lÃ©coms</td>
<td class="px-6 py-4 text-center text-slate-600">290</td>
<td class="px-6 py-4 text-right">
<span class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-[10px] font-bold">81.4%</span>
</td>
<td class="px-6 py-4 text-right font-medium">13.20</td>
</tr>
</tbody>
</table>
</div>
</section>
<!-- 3. RÃ©partition des Mentions (Visual Chart Simulation) -->
<section>
<div class="flex items-center gap-2 mb-6">
<div class="h-1 w-8 bg-primary rounded-full"></div>
<h4 class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">03. RÃ©partition des Mentions</h4>
</div>
<div class="flex items-end justify-between h-48 gap-4 px-12 pt-8">
<div class="flex-1 flex flex-col items-center gap-3">
<div class="w-full bg-primary/20 rounded-t-lg h-[15%] group relative">
<div class="absolute -top-6 w-full text-center text-[10px] font-bold text-slate-500">15%</div>
</div>
<span class="text-[10px] font-bold uppercase text-slate-400 text-center">TrÃ¨s Bien</span>
</div>
<div class="flex-1 flex flex-col items-center gap-3">
<div class="w-full bg-primary/40 rounded-t-lg h-[25%] group relative">
<div class="absolute -top-6 w-full text-center text-[10px] font-bold text-slate-500">25%</div>
</div>
<span class="text-[10px] font-bold uppercase text-slate-400 text-center">Bien</span>
</div>
<div class="flex-1 flex flex-col items-center gap-3">
<div class="w-full bg-primary/60 rounded-t-lg h-[35%] group relative">
<div class="absolute -top-6 w-full text-center text-[10px] font-bold text-slate-500">35%</div>
</div>
<span class="text-[10px] font-bold uppercase text-slate-400 text-center">Assez Bien</span>
</div>
<div class="flex-1 flex flex-col items-center gap-3">
<div class="w-full bg-primary/80 rounded-t-lg h-[15%] group relative">
<div class="absolute -top-6 w-full text-center text-[10px] font-bold text-slate-500">15%</div>
</div>
<span class="text-[10px] font-bold uppercase text-slate-400 text-center">Passable</span>
</div>
<div class="flex-1 flex flex-col items-center gap-3">
<div class="w-full bg-error rounded-t-lg h-[10%] group relative">
<div class="absolute -top-6 w-full text-center text-[10px] font-bold text-error">10%</div>
</div>
<span class="text-[10px] font-bold uppercase text-slate-400 text-center">AjournÃ©</span>
</div>
</div>
</section>
</div>
<!-- Footer Signatures -->
<div class="mt-16 pt-12 border-t border-slate-100 grid grid-cols-2 gap-20">
<div class="text-center">
<p class="text-[10px] font-bold uppercase text-slate-400 mb-20">Le Chef de DÃ©partement</p>
<div class="w-48 h-px bg-slate-200 mx-auto"></div>
<p class="text-xs font-semibold text-slate-600 mt-2">Dr. Jean-Pierre AMANI</p>
</div>
<div class="text-center">
<p class="text-[10px] font-bold uppercase text-slate-400 mb-20">Le Doyen de la FacultÃ©</p>
<div class="w-48 h-px bg-slate-200 mx-auto"></div>
<p class="text-xs font-semibold text-slate-600 mt-2">Pr. HÃ©lÃ¨ne DUBOIS</p>
</div>
</div>
<!-- Meta Info Document -->
<div class="mt-auto pt-8 flex justify-between items-center text-[9px] text-slate-300 uppercase font-black tracking-widest">
<span>LMD Horizon - Academic Management System</span>
<span>ID: REP-FACSCI-2024-0012</span>
<span>Page 1/1</span>
</div>
</div>
</main>
<!-- Global Footer -->
<footer class="w-full py-6 mt-auto bg-white border-t border-slate-100 flex flex-col items-center gap-4 px-8 no-print">
<div class="flex gap-8">
<a class="text-xs uppercase tracking-widest font-semibold text-slate-400 hover:text-slate-600 underline underline-offset-4 opacity-80 hover:opacity-100 transition-opacity" href="#">Mentions LÃ©gales</a>
<a class="text-xs uppercase tracking-widest font-semibold text-slate-400 hover:text-slate-600 underline underline-offset-4 opacity-80 hover:opacity-100 transition-opacity" href="#">Support Technique</a>
<a class="text-xs uppercase tracking-widest font-semibold text-slate-400 hover:text-slate-600 underline underline-offset-4 opacity-80 hover:opacity-100 transition-opacity" href="#">Guide Utilisateur</a>
</div>
<p class="text-[10px] text-slate-400 tracking-wider">Â© 2024 LMD Horizon - SystÃ¨me de Gestion AcadÃ©mique CertifiÃ©</p>
</footer>
</body></html>
