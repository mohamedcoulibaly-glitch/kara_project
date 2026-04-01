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
                        "on-surface": "#191c1e",
                        "on-tertiary-fixed-variant": "#802a00",
                        "on-primary-fixed": "#00174d",
                        "surface-tint": "#1353d8",
                        "on-tertiary-fixed": "#380d00",
                        "primary-container": "#1a56db",
                        "outline": "#737686",
                        "error": "#ba1a1a",
                        "secondary-fixed": "#dbe1ff",
                        "inverse-surface": "#2d3133",
                        "tertiary": "#852b00",
                        "surface-bright": "#f7f9fb",
                        "surface-variant": "#e0e3e5",
                        "surface-dim": "#d8dadc",
                        "tertiary-fixed-dim": "#ffb59a",
                        "secondary-fixed-dim": "#b5c4ff",
                        "on-secondary-fixed": "#01174b",
                        "secondary-container": "#b1c2ff",
                        "primary": "#003fb1",
                        "on-surface-variant": "#434654",
                        "on-tertiary-container": "#ffd4c5",
                        "surface-container-low": "#f2f4f6",
                        "primary-fixed-dim": "#b5c4ff",
                        "surface-container": "#eceef0",
                        "on-error": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-primary-fixed-variant": "#003dab",
                        "inverse-primary": "#b5c4ff",
                        "surface-container-highest": "#e0e3e5",
                        "surface": "#f7f9fb",
                        "on-secondary-fixed-variant": "#334479",
                        "on-error-container": "#93000a",
                        "surface-container-lowest": "#ffffff",
                        "on-background": "#191c1e",
                        "secondary": "#4b5c92",
                        "tertiary-container": "#ad3b00",
                        "tertiary-fixed": "#ffdbcf",
                        "background": "#f7f9fb",
                        "surface-container-high": "#e6e8ea",
                        "on-secondary-container": "#3d4e84",
                        "on-tertiary": "#ffffff",
                        "error-container": "#ffdad6",
                        "outline-variant": "#c3c5d7",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "on-primary-container": "#d4dcff",
                        "primary-fixed": "#dbe1ff"
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
        @media print {
            .no-print { display: none; }
            body { background: white; }
            .a4-container { 
                box-shadow: none !important;
                margin: 0 !important;
                padding: 1.5cm !important;
                width: 100% !important;
                max-width: 100% !important;
            }
        }
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            font-weight: 900;
            color: rgba(0, 0, 0, 0.03);
            pointer-events: none;
            white-space: nowrap;
            z-index: 0;
            user-select: none;
        }
    </style>
</head>
<body class="bg-surface-container-low min-h-screen flex flex-col items-center py-10 antialiased">
<!-- Predicted TopAppBar -->
<header class="no-print fixed top-0 w-full z-50 bg-white dark:bg-slate-900 shadow-sm flex items-center justify-between px-8 py-4 w-full max-w-none">
<div class="text-lg font-bold tracking-tight text-blue-800 dark:text-blue-300">DÃ©libÃ©ration AcadÃ©mique</div>
<div class="flex items-center gap-6">
<button class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors px-3 py-1.5 rounded-md" onclick="window.print()">
<span class="material-symbols-outlined">print</span>
<span class="text-sm font-medium">Imprimer le PV</span>
</button>
<button class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors px-3 py-1.5 rounded-md">
<span class="material-symbols-outlined">download</span>
<span class="text-sm font-medium">Exporter PDF</span>
</button>
<button class="flex items-center gap-2 text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors px-3 py-1.5 rounded-md">
<span class="material-symbols-outlined">share</span>
<span class="text-sm font-medium">Partager</span>
</button>
</div>
</header>
<!-- Sidebar (Suppressed for focused view as per rules) -->
<!-- Main Content: A4 Document Simulation -->
<main class="relative bg-white shadow-2xl w-[210mm] min-h-[297mm] p-12 mt-16 mb-20 overflow-hidden a4-container" id="printable-area">
<!-- Watermark -->
<div class="watermark uppercase">Document Officiel</div>
<!-- Institutional Header -->
<section class="relative z-10 grid grid-cols-12 gap-4 border-b border-slate-100 pb-8 mb-8">
<div class="col-span-3">
<div class="w-20 h-20 bg-primary-container rounded-xl flex items-center justify-center mb-2">
<span class="material-symbols-outlined text-white text-4xl" data-icon="school">school</span>
</div>
<p class="text-[10px] font-black text-primary leading-tight uppercase tracking-tighter">LMD Horizon<br/>Academic System</p>
</div>
<div class="col-span-6 text-center flex flex-col justify-center">
<h1 class="font-headline font-extrabold text-lg text-on-surface uppercase tracking-tight">UniversitÃ© des Sciences AppliquÃ©es</h1>
<p class="text-sm font-medium text-secondary">FacultÃ© des Sciences et Technologies</p>
<p class="text-xs text-outline italic">DÃ©partement de GÃ©nie Logiciel</p>
</div>
<div class="col-span-3 text-right flex flex-col justify-center">
<div class="bg-surface-container-low p-3 rounded-lg">
<p class="text-[10px] font-bold text-outline-variant uppercase">AnnÃ©e AcadÃ©mique</p>
<p class="text-sm font-bold text-primary">2023-2024</p>
</div>
</div>
</section>
<!-- Document Title -->
<section class="relative z-10 text-center mb-10">
<h2 class="font-headline font-black text-2xl text-on-surface tracking-tighter uppercase mb-1">ProcÃ¨s-Verbal de DÃ©libÃ©ration Finale</h2>
<div class="flex justify-center items-center gap-4">
<span class="h-px w-12 bg-outline-variant"></span>
<p class="text-md font-bold text-primary tracking-widest uppercase">Semestre 1 (S1) - Licence GÃ©nie Logiciel</p>
<span class="h-px w-12 bg-outline-variant"></span>
</div>
</section>
<!-- Data Grid -->
<section class="relative z-10 mb-12">
<table class="w-full border-collapse">
<thead>
<tr class="bg-surface-container-low text-on-surface-variant uppercase text-[10px] font-bold tracking-wider">
<th class="py-3 px-4 text-left first:rounded-l-md">Matricule</th>
<th class="py-3 px-4 text-left">Nom &amp; PrÃ©nom</th>
<th class="py-3 px-4 text-right">UE1 (INF101)</th>
<th class="py-3 px-4 text-right">UE2 (MATH101)</th>
<th class="py-3 px-4 text-right">MG</th>
<th class="py-3 px-4 text-center">ECTS/30</th>
<th class="py-3 px-4 text-center last:rounded-r-md">DÃ©cision</th>
</tr>
</thead>
<tbody class="text-sm font-medium">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-4 text-outline font-mono">2023-GL-001</td>
<td class="py-4 px-4 text-on-surface">KOUAMÃ‰ Marc-Antoine</td>
<td class="py-4 px-4 text-right">14.50</td>
<td class="py-4 px-4 text-right">16.20</td>
<td class="py-4 px-4 text-right font-bold text-primary">15.35</td>
<td class="py-4 px-4 text-center">30</td>
<td class="py-4 px-4 text-center">
<span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Admis</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-4 text-outline font-mono">2023-GL-002</td>
<td class="py-4 px-4 text-on-surface">DIOP Fatoumata Zahra</td>
<td class="py-4 px-4 text-right">12.00</td>
<td class="py-4 px-4 text-right">10.50</td>
<td class="py-4 px-4 text-right font-bold text-primary">11.25</td>
<td class="py-4 px-4 text-center">30</td>
<td class="py-4 px-4 text-center">
<span class="bg-secondary-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Admis</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-4 text-outline font-mono">2023-GL-003</td>
<td class="py-4 px-4 text-on-surface">MENSAH Koffi Elias</td>
<td class="py-4 px-4 text-right">09.50</td>
<td class="py-4 px-4 text-right">10.20</td>
<td class="py-4 px-4 text-right font-bold text-tertiary">09.85</td>
<td class="py-4 px-4 text-center">15</td>
<td class="py-4 px-4 text-center">
<span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Rattrapage</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-4 text-outline font-mono">2023-GL-004</td>
<td class="py-4 px-4 text-on-surface">TRAORE Bakary</td>
<td class="py-4 px-4 text-right">11.25</td>
<td class="py-4 px-4 text-right">08.00</td>
<td class="py-4 px-4 text-right font-bold text-secondary">09.63</td>
<td class="py-4 px-4 text-center">18</td>
<td class="py-4 px-4 text-center">
<span class="bg-tertiary-container text-on-tertiary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">Rattrapage</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="py-4 px-4 text-outline font-mono">2023-GL-005</td>
<td class="py-4 px-4 text-on-surface">NGUESSAN Marie-Claire</td>
<td class="py-4 px-4 text-right">07.00</td>
<td class="py-4 px-4 text-right">05.50</td>
<td class="py-4 px-4 text-right font-bold text-error">06.25</td>
<td class="py-4 px-4 text-center">00</td>
<td class="py-4 px-4 text-center">
<span class="bg-error-container text-on-error-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider">AjournÃ©</span>
</td>
</tr>
</tbody>
</table>
</section>
<!-- Stats Bento Grid -->
<section class="relative z-10 grid grid-cols-3 gap-6 mb-16">
<div class="bg-surface-container-low p-6 rounded-xl flex flex-col items-center">
<span class="text-[10px] uppercase font-black tracking-widest text-outline mb-2">Taux de RÃ©ussite</span>
<span class="text-3xl font-black text-primary">40.0%</span>
<span class="text-[10px] text-on-surface-variant font-medium mt-1">2/5 Ã‰tudiants Admis</span>
</div>
<div class="bg-surface-container-low p-6 rounded-xl flex flex-col items-center">
<span class="text-[10px] uppercase font-black tracking-widest text-outline mb-2">Meilleure Moyenne</span>
<span class="text-3xl font-black text-primary">15.35</span>
<span class="text-[10px] text-on-surface-variant font-medium mt-1">2023-GL-001</span>
</div>
<div class="bg-surface-container-low p-6 rounded-xl flex flex-col items-center">
<span class="text-[10px] uppercase font-black tracking-widest text-outline mb-2">Effectif PrÃ©sent</span>
<span class="text-3xl font-black text-primary">05</span>
<span class="text-[10px] text-on-surface-variant font-medium mt-1">Sur 05 inscrits</span>
</div>
</section>
<!-- Signatures Section -->
<section class="relative z-10 mt-auto pt-10 grid grid-cols-3 gap-8">
<div class="text-center">
<p class="text-xs font-bold text-on-surface uppercase mb-12">Le Chef de DÃ©partement</p>
<div class="w-full border-t border-slate-200 pt-2">
<p class="text-[10px] text-outline font-medium">Signature &amp; Cachet</p>
</div>
</div>
<div class="text-center">
<p class="text-xs font-bold text-on-surface uppercase mb-12">Les Membres du Jury</p>
<div class="w-full border-t border-slate-200 pt-2">
<p class="text-[10px] text-outline font-medium">Signatures (x3)</p>
</div>
</div>
<div class="text-center">
<p class="text-xs font-bold text-on-surface uppercase mb-12">Le PrÃ©sident du Jury</p>
<div class="w-full border-t border-slate-200 pt-2">
<p class="text-[10px] text-outline font-medium">Signature &amp; Cachet</p>
</div>
</div>
</section>
<!-- Footer for Document -->
<div class="absolute bottom-12 left-12 right-12 flex justify-between items-end border-t border-slate-100 pt-4">
<div class="flex items-center gap-2">
<img alt="Academic Seal" class="w-6 h-6 rounded-full" data-alt="Seal of the academic institution" src="https://lh3.googleusercontent.com/aida-public/AB6AXuArUPgiwIGg2BI1hzbci8vidovArq8Gs80YrS-NXmqnES2WPXqhkUrReAH_Rlrz2epEWWnuXBAsbuiJEGFaF6gAJiKTsPWNETrJKUGHvRlv43ICzMGgVjWVW9Z3BHzbiT_IUlMFYaBy7uQoBHaMZ3bhrMWNQ5DxnIryyx-Vp5RojTBb2MVeEsUuXAENq6QfD4_7VuRUr_VJ3_9NPipadb3CGOx4ftfgae_9-LZoxpv_yDHdVnDPXIuAW8DeYHsLHOIn4sBBXsGIAH4"/>
<span class="text-[9px] text-outline-variant font-bold uppercase tracking-tight">VÃ©rifiÃ© par SystÃ¨me AcadÃ©mique LMD</span>
</div>
<p class="text-[8px] text-outline italic">Date d'Ã©dition : 24 Mai 2024 - RÃ©f : PV-S1-GL-2023-0042</p>
</div>
</main>
<!-- Predicted Global Footer -->
<footer class="no-print w-full py-6 px-12 flex justify-between items-center bg-white dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800">
<div class="font-inter text-[10px] uppercase tracking-widest text-slate-400">Â© 2024 SystÃ¨me de Gestion LMD AcadÃ©mique - Document Officiel</div>
<div class="flex gap-8">
<a class="font-inter text-[10px] uppercase tracking-widest text-slate-400 hover:text-blue-700 transition-colors" href="#">Mentions LÃ©gales</a>
<a class="font-inter text-[10px] uppercase tracking-widest text-slate-400 hover:text-blue-700 transition-colors" href="#">Support Technique</a>
<a class="font-inter text-[10px] uppercase tracking-widest text-slate-400 hover:text-blue-700 transition-colors" href="#">RÃ¨glement LMD</a>
</div>
</footer>
</body></html>
