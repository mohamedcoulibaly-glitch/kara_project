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
              "primary": "#003fb1",
              "background": "#f7f9fb",
              "secondary-fixed-dim": "#b5c4ff",
              "on-tertiary-fixed-variant": "#802a00",
              "error-container": "#ffdad6",
              "tertiary-container": "#ad3b00",
              "on-primary": "#ffffff",
              "primary-fixed-dim": "#b5c4ff",
              "primary-container": "#1a56db",
              "on-surface": "#191c1e",
              "surface-container-low": "#f2f4f6",
              "outline-variant": "#c3c5d7",
              "on-secondary-container": "#3d4e84",
              "on-primary-fixed": "#00174d",
              "secondary-fixed": "#dbe1ff",
              "tertiary": "#852b00",
              "outline": "#737686",
              "surface-container-lowest": "#ffffff",
              "on-secondary-fixed-variant": "#334479",
              "error": "#ba1a1a",
              "on-primary-fixed-variant": "#003dab",
              "inverse-primary": "#b5c4ff",
              "surface-dim": "#d8dadc",
              "on-error-container": "#93000a",
              "on-error": "#ffffff",
              "on-background": "#191c1e",
              "on-tertiary-fixed": "#380d00",
              "on-surface-variant": "#434654",
              "surface-tint": "#1353d8",
              "on-tertiary-container": "#ffd4c5",
              "on-secondary": "#ffffff",
              "on-primary-container": "#d4dcff",
              "surface-container-high": "#e6e8ea",
              "tertiary-fixed-dim": "#ffb59a",
              "surface-container": "#eceef0",
              "on-secondary-fixed": "#01174b",
              "secondary-container": "#b1c2ff",
              "inverse-surface": "#2d3133",
              "primary-fixed": "#dbe1ff",
              "surface": "#f7f9fb",
              "secondary": "#4b5c92",
              "tertiary-fixed": "#ffdbcf",
              "surface-bright": "#f7f9fb",
              "on-tertiary": "#ffffff",
              "surface-container-highest": "#e0e3e5",
              "surface-variant": "#e0e3e5",
              "inverse-on-surface": "#eff1f3"
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
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
        }
        input:focus {
            box-shadow: 0 0 0 2px rgba(26, 86, 219, 0.2);
            border-color: #1A56DB !important;
        }
    </style>
</head>
<body class="bg-surface text-on-surface min-h-screen">
<!-- TopAppBar -->
<header class="fixed top-0 w-full z-50 bg-[#f7f9fb] flex justify-between items-center px-6 py-3 w-full">
<div class="flex items-center gap-4">
<span class="text-lg font-bold text-[#1A56DB]">Portail AcadÃ©mique LMD</span>
</div>
<div class="flex items-center gap-6">
<div class="hidden md:flex items-center gap-2 bg-surface-container-low px-3 py-1.5 rounded-md text-slate-600">
<span class="material-symbols-outlined text-sm">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-64" placeholder="Rechercher une UE..." type="text"/>
</div>
<div class="flex items-center gap-4">
<span class="material-symbols-outlined text-slate-600 cursor-pointer hover:bg-[#f2f4f6] p-2 rounded-full transition-colors">notifications</span>
<span class="material-symbols-outlined text-slate-600 cursor-pointer hover:bg-[#f2f4f6] p-2 rounded-full transition-colors">settings</span>
<span class="material-symbols-outlined text-slate-600 cursor-pointer hover:bg-[#f2f4f6] p-2 rounded-full transition-colors">help_outline</span>
<div class="w-8 h-8 rounded-full overflow-hidden border border-outline-variant">
<img alt="Avatar" data-alt="Avatar de l'administrateur acadÃ©mique" src="https://lh3.googleusercontent.com/aida-public/AB6AXuBBIUzauJgd0Baep-AX3Ny_GBQKYjathfxgmWT4k8yiz8qCWAZoxn4ayWuH9SJo1eDlndLWuy5bCjMWluPP_3pZW7SKfB6vxqell_vmmnQ3lMPzfri4Vjn9hw0e0kwbs2JasAUbbEEGHPfiaVOM5biYeEnJxA1B6aDttQDKRJesS3yI-LeOFC6Lxt_t7ZIiGRBYFuWtwX-Gy52Sqq6hHSPm3T-pjwfkl0kV9owr2uJyx7KF3NyBCYkEjP4IoRcsAgMu296l6Mr0ubc"/>
</div>
</div>
</div>
</header>
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-[#f2f4f6] flex flex-col h-full p-4 pt-20 z-40">
<div class="mb-8 px-2">
<h2 class="text-[#1A56DB] text-xl font-black">Gestion LMD</h2>
<p class="text-slate-500 text-xs font-medium uppercase tracking-widest mt-1">Administration Centrale</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-white/50 rounded-lg transition-all group" href="#">
<span class="material-symbols-outlined">dashboard</span>
<span class="font-medium text-sm">Tableau de bord</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-white/50 rounded-lg transition-all group" href="#">
<span class="material-symbols-outlined">account_tree</span>
<span class="font-medium text-sm">Offre de Formation</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-white/50 rounded-lg transition-all group" href="#">
<span class="material-symbols-outlined">layers</span>
<span class="font-medium text-sm">Maquettes LMD</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 bg-white text-[#1A56DB] font-bold rounded-lg shadow-sm group" href="#">
<span class="material-symbols-outlined">settings_input_component</span>
<span class="font-medium text-sm">Configurations</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-500 hover:bg-white/50 rounded-lg transition-all group" href="#">
<span class="material-symbols-outlined">settings</span>
<span class="font-medium text-sm">ParamÃ¨tres</span>
</a>
</nav>
<button class="mt-4 bg-[#1A56DB] text-white py-2.5 rounded-lg text-sm font-semibold shadow-md hover:bg-primary transition-all active:scale-95">
            Publier les Maquettes
        </button>
<div class="mt-auto pt-6 border-t border-slate-200 flex flex-col gap-1">
<a class="flex items-center gap-3 px-3 py-2 text-slate-500 hover:bg-white/50 rounded-lg transition-all" href="#">
<span class="material-symbols-outlined text-sm">help</span>
<span class="text-sm">Aide</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 text-error hover:bg-red-50 rounded-lg transition-all" href="#">
<span class="material-symbols-outlined text-sm">logout</span>
<span class="text-sm font-medium">DÃ©connexion</span>
</a>
</div>
</aside>
<!-- Main Content Canvas -->
<main class="ml-64 pt-20 p-8 min-h-screen">
<div class="max-w-7xl mx-auto">
<!-- Page Header -->
<header class="mb-10">
<div class="flex items-center gap-2 text-slate-500 text-xs font-medium mb-2">
<span>CONFIGURATIONS</span>
<span class="material-symbols-outlined text-xs">chevron_right</span>
<span class="text-primary font-bold">COEFFICIENTS UE/EC</span>
</div>
<h1 class="text-3xl font-extrabold text-on-surface tracking-tight">ParamÃ©trage des Maquettes</h1>
<p class="text-on-surface-variant mt-1 text-sm">DÃ©finissez les coefficients, crÃ©dits et volumes horaires par unitÃ© d'enseignement.</p>
</header>
<!-- Context Selector Bento Section -->
<section class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
<div class="lg:col-span-2 bg-surface-container-lowest p-6 rounded-xl border border-white/40 shadow-sm flex flex-col md:flex-row gap-6 items-end">
<div class="flex-1 w-full">
<label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">DÃ©partement d'attache</label>
<select class="w-full bg-surface-container-low border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-primary/20 py-3">
<option>Sciences de l'IngÃ©nieur</option>
<option>MathÃ©matiques &amp; Informatique</option>
<option>Ã‰conomie &amp; Gestion</option>
</select>
</div>
<div class="flex-1 w-full">
<label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">FiliÃ¨re d'Ã‰tude</label>
<select class="w-full bg-surface-container-low border-none rounded-lg text-sm font-medium focus:ring-2 focus:ring-primary/20 py-3">
<option>GÃ©nie Logiciel (Licence)</option>
<option>RÃ©seaux &amp; TÃ©lÃ©coms (Licence)</option>
<option>Intelligence Artificielle (Master)</option>
</select>
</div>
<button class="bg-primary-container text-on-primary-container px-6 py-3 rounded-lg text-sm font-bold flex items-center gap-2 hover:opacity-90 transition-opacity">
<span class="material-symbols-outlined text-sm">filter_list</span>
                        Filtrer
                    </button>
</div>
<div class="bg-primary text-white p-6 rounded-xl shadow-lg relative overflow-hidden flex flex-col justify-between">
<div class="relative z-10">
<span class="text-[0.65rem] font-bold uppercase tracking-[0.2em] opacity-80">RÃ©sumÃ© de l'UE</span>
<h3 class="text-xl font-bold mt-1">Algorithmique Fondamentale</h3>
<p class="text-sm opacity-70">Code: INF101 | Semestre 1</p>
</div>
<div class="flex justify-between items-end relative z-10 mt-4">
<div>
<p class="text-[0.65rem] uppercase opacity-70">Total ECTS</p>
<p class="text-2xl font-black">6.0</p>
</div>
<div class="text-right">
<p class="text-[0.65rem] uppercase opacity-70">Coeff. Global</p>
<p class="text-2xl font-black">4.0</p>
</div>
</div>
<!-- Abstract gradient background -->
<div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16 blur-2xl"></div>
</div>
</section>
<div class="grid grid-cols-1 lg:grid-cols-4 gap-8 items-start">
<!-- Left Panel: UE List -->
<aside class="lg:col-span-1 space-y-3">
<h4 class="text-xs font-black text-slate-400 uppercase px-2 mb-4">UnitÃ©s du Semestre</h4>
<button class="w-full text-left p-4 rounded-xl bg-white border border-primary/20 shadow-sm flex flex-col gap-1 ring-1 ring-primary/10">
<span class="text-[0.65rem] font-bold text-primary">UE OBLIGATOIRE</span>
<span class="text-sm font-bold text-slate-800 leading-tight">INF101 - Algorithmique</span>
</button>
<button class="w-full text-left p-4 rounded-xl bg-surface-container-low hover:bg-white transition-all flex flex-col gap-1 border border-transparent">
<span class="text-[0.65rem] font-bold text-slate-500">UE OBLIGATOIRE</span>
<span class="text-sm font-bold text-slate-600 leading-tight">MAT102 - Analyse 1</span>
</button>
<button class="w-full text-left p-4 rounded-xl bg-surface-container-low hover:bg-white transition-all flex flex-col gap-1 border border-transparent">
<span class="text-[0.65rem] font-bold text-slate-500">UE TRANSVERSALE</span>
<span class="text-sm font-bold text-slate-600 leading-tight">ANG103 - Anglais Technique</span>
</button>
<button class="w-full text-left p-4 rounded-xl bg-surface-container-low hover:bg-white transition-all flex flex-col gap-1 border border-transparent">
<span class="text-[0.65rem] font-bold text-slate-500">UE OPTIONNELLE</span>
<span class="text-sm font-bold text-slate-600 leading-tight">SOC104 - Sociologie NumÃ©rique</span>
</button>
</aside>
<!-- Center Panel: EC Configuration Table -->
<div class="lg:col-span-3">
<div class="bg-surface-container-lowest rounded-xl shadow-sm border border-slate-100 overflow-hidden">
<div class="px-6 py-4 border-b border-surface-container-low bg-surface-container-lowest flex justify-between items-center">
<h2 class="font-bold text-slate-800">Ã‰lÃ©ments Constitutifs (EC)</h2>
<button class="text-primary text-xs font-bold hover:underline flex items-center gap-1">
<span class="material-symbols-outlined text-sm">add</span>
                                Ajouter un EC
                            </button>
</div>
<div class="overflow-x-auto">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low">
<th class="px-6 py-4 text-[0.65rem] font-black text-slate-500 uppercase tracking-widest">Code EC</th>
<th class="px-6 py-4 text-[0.65rem] font-black text-slate-500 uppercase tracking-widest">DÃ©signation</th>
<th class="px-6 py-4 text-[0.65rem] font-black text-slate-500 uppercase tracking-widest text-center">Coeff</th>
<th class="px-6 py-4 text-[0.65rem] font-black text-slate-500 uppercase tracking-widest text-center">ECTS</th>
<th class="px-6 py-4 text-[0.65rem] font-black text-slate-500 uppercase tracking-widest text-center">V.H (CM/TD/TP)</th>
<th class="px-6 py-4"></th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container-low">
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-3 text-sm font-mono w-24" type="text" value="INF101.1"/>
</td>
<td class="px-6 py-4">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-3 text-sm w-full font-medium" type="text" value="Algorithmes de Base &amp; Logique"/>
</td>
<td class="px-6 py-4 text-center">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-sm text-center font-bold w-16" step="0.5" type="number" value="2.0"/>
</td>
<td class="px-6 py-4 text-center">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-sm text-center font-bold w-16" type="number" value="3"/>
</td>
<td class="px-6 py-4">
<div class="flex gap-1 justify-center">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-xs text-center w-10" title="Cours Magistral" type="text" value="15"/>
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-xs text-center w-10" title="Travaux DirigÃ©s" type="text" value="10"/>
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-xs text-center w-10" title="Travaux Pratiques" type="text" value="20"/>
</div>
</td>
<td class="px-6 py-4 text-right">
<button class="text-slate-300 hover:text-error transition-colors">
<span class="material-symbols-outlined text-xl">delete</span>
</button>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors">
<td class="px-6 py-4">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-3 text-sm font-mono w-24" type="text" value="INF101.2"/>
</td>
<td class="px-6 py-4">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-3 text-sm w-full font-medium" type="text" value="Structures de DonnÃ©es LinÃ©aires"/>
</td>
<td class="px-6 py-4 text-center">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-sm text-center font-bold w-16" step="0.5" type="number" value="2.0"/>
</td>
<td class="px-6 py-4 text-center">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-sm text-center font-bold w-16" type="number" value="3"/>
</td>
<td class="px-6 py-4">
<div class="flex gap-1 justify-center">
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-xs text-center w-10" type="text" value="12"/>
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-xs text-center w-10" type="text" value="12"/>
<input class="bg-surface-container-low border-none rounded md py-1.5 px-2 text-xs text-center w-10" type="text" value="24"/>
</div>
</td>
<td class="px-6 py-4 text-right">
<button class="text-slate-300 hover:text-error transition-colors">
<span class="material-symbols-outlined text-xl">delete</span>
</button>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Table Footer / Actions -->
<div class="p-6 bg-surface-container-low/50 flex flex-col md:flex-row justify-between items-center gap-4">
<div class="flex gap-4 items-center">
<div class="px-4 py-2 bg-white rounded-lg border border-slate-200">
<span class="text-[0.65rem] font-bold text-slate-400 block uppercase">Total Coefficients EC</span>
<span class="text-lg font-black text-primary">4.0 / 4.0</span>
</div>
<div class="px-4 py-2 bg-white rounded-lg border border-slate-200">
<span class="text-[0.65rem] font-bold text-slate-400 block uppercase">Total CrÃ©dits UE</span>
<span class="text-lg font-black text-slate-800">6.0 ECTS</span>
</div>
</div>
<div class="flex gap-3">
<button class="px-6 py-3 rounded-lg text-sm font-bold text-slate-600 hover:bg-slate-200 transition-colors">
                                    RÃ©initialiser
                                </button>
<button class="px-8 py-3 rounded-lg text-sm font-bold bg-primary text-white shadow-md hover:bg-primary-container active:scale-95 transition-all">
                                    Enregistrer les modifications
                                </button>
</div>
</div>
</div>
<!-- Warning Message -->
<div class="mt-6 flex gap-4 p-4 rounded-lg bg-tertiary-fixed-dim/20 border border-tertiary/20">
<span class="material-symbols-outlined text-tertiary">info</span>
<div>
<p class="text-xs font-bold text-tertiary uppercase mb-1">Attention RÃ¨glementaire</p>
<p class="text-sm text-on-tertiary-fixed-variant leading-relaxed">
                                Toute modification des coefficients aprÃ¨s le dÃ©but du semestre nÃ©cessite l'approbation du conseil scientifique du dÃ©partement. Les changements seront historisÃ©s.
                            </p>
</div>
</div>
</div>
</div>
</div>
</main>
<!-- Contextual FAB (Only for Main Admin Actions) -->
<div class="fixed bottom-8 right-8 flex flex-col items-end gap-3">
<div class="group flex items-center gap-3">
<span class="bg-on-surface text-white text-[10px] font-bold px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Exporter Maquette PDF</span>
<button class="w-14 h-14 bg-white text-on-surface shadow-xl rounded-full flex items-center justify-center hover:scale-110 active:scale-95 transition-all border border-slate-100">
<span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">picture_as_pdf</span>
</button>
</div>
</div>
</body></html>
