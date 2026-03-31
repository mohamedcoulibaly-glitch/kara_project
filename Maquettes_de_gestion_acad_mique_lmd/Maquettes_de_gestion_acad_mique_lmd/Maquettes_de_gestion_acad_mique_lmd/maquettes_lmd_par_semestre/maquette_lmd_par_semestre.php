<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>Maquettes LMD - Portail Académique</title>
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
              "on-primary-fixed-variant": "#003dab",
              "background": "#f7f9fb",
              "surface-container": "#eceef0",
              "on-secondary": "#ffffff",
              "error": "#ba1a1a",
              "error-container": "#ffdad6",
              "on-primary-fixed": "#00174d",
              "surface-tint": "#1353d8",
              "primary-container": "#1a56db",
              "outline": "#737686",
              "on-surface": "#191c1e",
              "on-secondary-fixed": "#01174b",
              "surface-container-high": "#e6e8ea",
              "on-tertiary": "#ffffff",
              "secondary": "#4b5c92",
              "primary-fixed-dim": "#b5c4ff",
              "surface-variant": "#e0e3e5",
              "surface-container-highest": "#e0e3e5",
              "tertiary-container": "#ad3b00",
              "outline-variant": "#c3c5d7",
              "inverse-primary": "#b5c4ff",
              "on-secondary-container": "#3d4e84",
              "surface-bright": "#f7f9fb",
              "on-error-container": "#93000a",
              "surface-container-low": "#f2f4f6",
              "inverse-on-surface": "#eff1f3",
              "secondary-fixed-dim": "#b5c4ff",
              "tertiary-fixed": "#ffdbcf",
              "surface-container-lowest": "#ffffff",
              "on-tertiary-fixed-variant": "#802a00",
              "on-primary-container": "#d4dcff",
              "on-secondary-fixed-variant": "#334479",
              "on-primary": "#ffffff",
              "on-error": "#ffffff",
              "tertiary-fixed-dim": "#ffb59a",
              "secondary-fixed": "#dbe1ff",
              "primary": "#003fb1",
              "on-tertiary-container": "#ffd4c5",
              "secondary-container": "#b1c2ff",
              "on-tertiary-fixed": "#380d00",
              "on-surface-variant": "#434654",
              "surface": "#f7f9fb",
              "inverse-surface": "#2d3133",
              "tertiary": "#852b00",
              "primary-fixed": "#dbe1ff",
              "surface-dim": "#d8dadc",
              "on-background": "#191c1e"
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
    </style>
</head>
<body class="bg-background text-on-surface antialiased">
<!-- TopAppBar Shell -->
<header class="fixed top-0 w-full z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm shadow-slate-200/50">
<div class="flex justify-between items-center px-6 py-3 w-full">
<div class="flex items-center gap-8">
<span class="text-xl font-bold tracking-tighter text-blue-700 dark:text-blue-400">Portail Académique LMD</span>
<nav class="hidden md:flex gap-6 items-center font-sans text-sm font-medium tracking-tight">
<a class="text-slate-500 hover:text-blue-600 transition-colors duration-200" href="#">Semestres</a>
<a class="text-blue-700 dark:text-blue-400 border-b-2 border-blue-700 pb-1" href="#">Unités d'Enseignement</a>
<a class="text-slate-500 hover:text-blue-600 transition-colors duration-200" href="#">Parcours</a>
</nav>
</div>
<div class="flex items-center gap-4">
<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors active:scale-95">
<span class="material-symbols-outlined">notifications</span>
</button>
<button class="p-2 text-slate-500 hover:bg-slate-50 rounded-full transition-colors active:scale-95">
<span class="material-symbols-outlined">settings</span>
</button>
<div class="h-8 w-8 rounded-full bg-slate-200 overflow-hidden ml-2">
<img alt="Avatar de l'administrateur" data-alt="Photo de profil de l'administrateur" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBJjU4CfrkJ08k8ZtP_TD_HVpZIc0GDtSaupR8V6YZnzS2kbN4sQZOCfxI3WPrnaLRoXdUqYiT4bHOVYE-lk6WOmrPtU_h6BRD9KvySg6caDwbi5A7HK_Q-YVo8okvpVNxQ2nTxdzQIzZPtOAEpmAlKIPLzbGDAav-uU4CKE6BxQbgCuzjnw203NKnowgoSrrKgxG8xuvpTfDXkVS7aTYAwPiVw1WphzGfZd_fSHVZ2Of0PDi56KvaRC1M8q-3KV2aKdoL-djX5UCE"/>
</div>
</div>
</div>
<div class="bg-slate-100 dark:bg-slate-800 h-[1px] w-full"></div>
</header>
<!-- SideNavBar Shell -->
<aside class="h-screen w-64 fixed left-0 top-0 overflow-y-auto bg-slate-50 dark:bg-slate-950 flex flex-col pt-20 pb-4 gap-2 z-40 hidden md:flex">
<div class="px-6 py-4 flex flex-col gap-1">
<span class="text-lg font-black text-slate-900 dark:text-white">Filière Informatique</span>
<span class="text-xs font-semibold text-slate-500">Licence LMD</span>
</div>
<div class="flex flex-col gap-1 mt-4">
<a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg text-slate-600 hover:bg-slate-200/50 transition-all hover:translate-x-1" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-sans text-sm font-semibold">Tableau de bord</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg bg-white shadow-sm text-blue-700 transition-all hover:translate-x-1" href="#">
<span class="material-symbols-outlined">account_tree</span>
<span class="font-sans text-sm font-semibold">Maquettes S1-S6</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg text-slate-600 hover:bg-slate-200/50 transition-all hover:translate-x-1" href="#">
<span class="material-symbols-outlined">edit_note</span>
<span class="font-sans text-sm font-semibold">Gestion des Notes</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg text-slate-600 hover:bg-slate-200/50 transition-all hover:translate-x-1" href="#">
<span class="material-symbols-outlined">person_add</span>
<span class="font-sans text-sm font-semibold">Inscriptions</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg text-slate-600 hover:bg-slate-200/50 transition-all hover:translate-x-1" href="#">
<span class="material-symbols-outlined">analytics</span>
<span class="font-sans text-sm font-semibold">Rapports</span>
</a>
</div>
<div class="mt-8 px-4">
<button class="w-full py-3 bg-primary text-white rounded-xl font-bold text-sm shadow-md hover:bg-primary-container transition-colors active:scale-95">
                Nouvelle Maquette
            </button>
</div>
<div class="mt-auto flex flex-col gap-1">
<a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg text-slate-600 hover:bg-slate-200/50 transition-all" href="#">
<span class="material-symbols-outlined">help</span>
<span class="font-sans text-sm font-semibold">Aide</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 mx-2 rounded-lg text-slate-600 hover:bg-slate-200/50 transition-all" href="#">
<span class="material-symbols-outlined">logout</span>
<span class="font-sans text-sm font-semibold">Déconnexion</span>
</a>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="md:ml-64 pt-24 px-8 pb-12">
<!-- Dashboard Header -->
<div class="flex flex-col lg:flex-row lg:items-end justify-between mb-10 gap-6">
<div class="space-y-2">
<div class="flex items-center gap-3 text-primary font-semibold text-sm">
<span class="material-symbols-outlined text-sm">school</span>
<span>Licence en Génie Logiciel</span>
</div>
<h1 class="text-4xl font-extrabold tracking-tight text-on-surface">Visualisation de la Maquette</h1>
<p class="text-on-surface-variant font-medium">Parcours académique structuré selon le système LMD.</p>
</div>
<div class="flex items-center gap-3">
<button class="flex items-center gap-2 px-5 py-2.5 bg-surface-container-low text-on-surface rounded-xl font-semibold text-sm hover:bg-surface-container-high transition-colors active:scale-95">
<span class="material-symbols-outlined">print</span>
                    Imprimer la maquette
                </button>
<button class="flex items-center gap-2 px-5 py-2.5 bg-primary text-white rounded-xl font-semibold text-sm shadow-sm hover:bg-primary-container transition-colors active:scale-95">
<span class="material-symbols-outlined">edit</span>
                    Modifier la structure
                </button>
</div>
</div>
<!-- Semester Tabs -->
<div class="flex overflow-x-auto pb-4 gap-2 mb-8 no-scrollbar">
<button class="px-8 py-3 bg-primary text-white rounded-full font-bold text-sm shadow-sm whitespace-nowrap">Semestre 1</button>
<button class="px-8 py-3 bg-surface-container-low text-on-surface hover:bg-surface-container-high rounded-full font-semibold text-sm transition-colors whitespace-nowrap">Semestre 2</button>
<button class="px-8 py-3 bg-surface-container-low text-on-surface hover:bg-surface-container-high rounded-full font-semibold text-sm transition-colors whitespace-nowrap">Semestre 3</button>
<button class="px-8 py-3 bg-surface-container-low text-on-surface hover:bg-surface-container-high rounded-full font-semibold text-sm transition-colors whitespace-nowrap">Semestre 4</button>
<button class="px-8 py-3 bg-surface-container-low text-on-surface hover:bg-surface-container-high rounded-full font-semibold text-sm transition-colors whitespace-nowrap">Semestre 5</button>
<button class="px-8 py-3 bg-surface-container-low text-on-surface hover:bg-surface-container-high rounded-full font-semibold text-sm transition-colors whitespace-nowrap">Semestre 6</button>
</div>
<!-- Semester Summary Card -->
<div class="bg-surface-container-lowest rounded-xl p-8 mb-10 flex flex-col md:flex-row items-center justify-between gap-8 border-none shadow-[0_12px_32px_rgba(25,28,30,0.04)]">
<div class="flex flex-col gap-1">
<span class="text-xs font-bold uppercase tracking-widest text-primary opacity-80">Résumé du Semestre S1</span>
<h2 class="text-2xl font-bold">Semestre de Fondamentaux</h2>
</div>
<div class="flex gap-12">
<div class="text-center">
<p class="text-xs font-semibold text-on-surface-variant uppercase mb-1">Total Crédits</p>
<p class="text-3xl font-black text-primary">30 ECTS</p>
</div>
<div class="text-center">
<p class="text-xs font-semibold text-on-surface-variant uppercase mb-1">Nombre d'UE</p>
<p class="text-3xl font-black text-on-surface">05</p>
</div>
<div class="text-center">
<p class="text-xs font-semibold text-on-surface-variant uppercase mb-1">VH Semestriel</p>
<p class="text-3xl font-black text-on-surface">360h</p>
</div>
</div>
</div>
<!-- UE Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
<!-- UE Card 1 -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col">
<div class="px-6 py-5 bg-surface-container-low flex justify-between items-center">
<div>
<span class="inline-block px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-[10px] font-bold uppercase tracking-wider mb-2">Obligatoire</span>
<h3 class="text-lg font-bold leading-tight">UEF 1.1 : Algorithmique &amp; Programmation</h3>
</div>
<div class="text-right">
<p class="text-2xl font-black text-primary">08</p>
<p class="text-[10px] font-bold text-on-surface-variant">ECTS</p>
</div>
</div>
<div class="p-0">
<table class="w-full text-sm text-left border-collapse">
<thead class="bg-white">
<tr>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase">Élément Constitutif (EC)</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">Coeff.</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">ECTS</th>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">VH (CM/TD/TP)</th>
</tr>
</thead>
<tbody class="divide-y-0">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 font-medium">Bases de l'Algorithmique</td>
<td class="px-4 py-4 text-right">2</td>
<td class="px-4 py-4 text-right font-bold text-primary">4</td>
<td class="px-6 py-4 text-right tabular-nums text-on-surface-variant">24/12/12</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4 font-medium">Langage C - Initiation</td>
<td class="px-4 py-4 text-right">2</td>
<td class="px-4 py-4 text-right font-bold text-primary">4</td>
<td class="px-6 py-4 text-right tabular-nums text-on-surface-variant">20/10/20</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-auto p-4 bg-surface-container-lowest border-t border-slate-50 flex justify-end">
<button class="text-primary text-xs font-bold hover:underline flex items-center gap-1">
                        Détails du syllabus <span class="material-symbols-outlined text-xs">arrow_forward</span>
</button>
</div>
</div>
<!-- UE Card 2 -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col">
<div class="px-6 py-5 bg-surface-container-low flex justify-between items-center">
<div>
<span class="inline-block px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-[10px] font-bold uppercase tracking-wider mb-2">Obligatoire</span>
<h3 class="text-lg font-bold leading-tight">UEF 1.2 : Mathématiques pour l'Informatique</h3>
</div>
<div class="text-right">
<p class="text-2xl font-black text-primary">06</p>
<p class="text-[10px] font-bold text-on-surface-variant">ECTS</p>
</div>
</div>
<div class="p-0">
<table class="w-full text-sm text-left border-collapse">
<thead class="bg-white">
<tr>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase">Élément Constitutif (EC)</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">Coeff.</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">ECTS</th>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">VH (CM/TD/TP)</th>
</tr>
</thead>
<tbody class="divide-y-0">
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4 font-medium">Analyse et Algèbre Linéaire</td>
<td class="px-4 py-4 text-right">2</td>
<td class="px-4 py-4 text-right font-bold text-primary">3</td>
<td class="px-6 py-4 text-right tabular-nums text-on-surface-variant">30/20/00</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4 font-medium">Logique Formelle</td>
<td class="px-4 py-4 text-right">1</td>
<td class="px-4 py-4 text-right font-bold text-primary">3</td>
<td class="px-6 py-4 text-right tabular-nums text-on-surface-variant">15/15/00</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-auto p-4 bg-surface-container-lowest border-t border-slate-50 flex justify-end">
<button class="text-primary text-xs font-bold hover:underline flex items-center gap-1">
                        Détails du syllabus <span class="material-symbols-outlined text-xs">arrow_forward</span>
</button>
</div>
</div>
<!-- UE Card 3 (Transversal) -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col">
<div class="px-6 py-5 bg-surface-container-low flex justify-between items-center">
<div>
<span class="inline-block px-3 py-1 bg-tertiary-container text-on-tertiary-container rounded-full text-[10px] font-bold uppercase tracking-wider mb-2">Transversale</span>
<h3 class="text-lg font-bold leading-tight">UET 1.3 : Langues &amp; Communication</h3>
</div>
<div class="text-right">
<p class="text-2xl font-black text-primary">04</p>
<p class="text-[10px] font-bold text-on-surface-variant">ECTS</p>
</div>
</div>
<div class="p-0">
<table class="w-full text-sm text-left border-collapse">
<thead class="bg-white">
<tr>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase">Élément Constitutif (EC)</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">Coeff.</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">ECTS</th>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">VH (CM/TD/TP)</th>
</tr>
</thead>
<tbody class="divide-y-0">
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4 font-medium">Anglais Technique I</td>
<td class="px-4 py-4 text-right">1</td>
<td class="px-4 py-4 text-right font-bold text-primary">2</td>
<td class="px-6 py-4 text-right tabular-nums text-on-surface-variant">10/20/00</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4 font-medium">Techniques de Comm. Écrite</td>
<td class="px-4 py-4 text-right">1</td>
<td class="px-4 py-4 text-right font-bold text-primary">2</td>
<td class="px-6 py-4 text-right tabular-nums text-on-surface-variant">10/10/00</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-auto p-4 bg-surface-container-lowest border-t border-slate-50 flex justify-end">
<button class="text-primary text-xs font-bold hover:underline flex items-center gap-1">
                        Détails du syllabus <span class="material-symbols-outlined text-xs">arrow_forward</span>
</button>
</div>
</div>
<!-- UE Card 4 (Optionnelle) -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col">
<div class="px-6 py-5 bg-surface-container-low flex justify-between items-center">
<div>
<span class="inline-block px-3 py-1 bg-surface-variant text-on-surface-variant rounded-full text-[10px] font-bold uppercase tracking-wider mb-2">Optionnelle</span>
<h3 class="text-lg font-bold leading-tight">UEO 1.4 : Culture Numérique</h3>
</div>
<div class="text-right">
<p class="text-2xl font-black text-primary">02</p>
<p class="text-[10px] font-bold text-on-surface-variant">ECTS</p>
</div>
</div>
<div class="p-0">
<table class="w-full text-sm text-left border-collapse">
<thead class="bg-white">
<tr>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase">Élément Constitutif (EC)</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">Coeff.</th>
<th class="px-4 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">ECTS</th>
<th class="px-6 py-3 font-semibold text-xs text-on-surface-variant uppercase text-right">VH (CM/TD/TP)</th>
</tr>
</thead>
<tbody class="divide-y-0">
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4 font-medium">Éthique &amp; Droit du Numérique</td>
<td class="px-4 py-4 text-right">1</td>
<td class="px-4 py-4 text-right font-bold text-primary">2</td>
<td class="px-6 py-4 text-right tabular-nums text-on-surface-variant">12/08/00</td>
</tr>
</tbody>
</table>
</div>
<div class="mt-auto p-4 bg-surface-container-lowest border-t border-slate-50 flex justify-end">
<button class="text-primary text-xs font-bold hover:underline flex items-center gap-1">
                        Détails du syllabus <span class="material-symbols-outlined text-xs">arrow_forward</span>
</button>
</div>
</div>
</div>
<!-- Pagination/Navigation simple pour semestres (Mobile fallback) -->
<div class="mt-12 flex justify-between items-center md:hidden">
<button class="p-3 bg-white rounded-xl shadow-sm"><span class="material-symbols-outlined">chevron_left</span></button>
<span class="font-bold">Semestre 1 / 6</span>
<button class="p-3 bg-white rounded-xl shadow-sm"><span class="material-symbols-outlined">chevron_right</span></button>
</div>
</main>
<!-- BottomNavBar (Mobile only) -->
<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-slate-100 flex justify-around py-3 px-4 z-50">
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined">dashboard</span>
<span class="text-[10px] font-bold">Dashboard</span>
</button>
<button class="flex flex-col items-center gap-1 text-blue-700">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">account_tree</span>
<span class="text-[10px] font-bold">Maquettes</span>
</button>
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined">edit_note</span>
<span class="text-[10px] font-bold">Notes</span>
</button>
<button class="flex flex-col items-center gap-1 text-slate-400">
<span class="material-symbols-outlined">person_add</span>
<span class="text-[10px] font-bold">Inscrip.</span>
</button>
</nav>
</body></html>