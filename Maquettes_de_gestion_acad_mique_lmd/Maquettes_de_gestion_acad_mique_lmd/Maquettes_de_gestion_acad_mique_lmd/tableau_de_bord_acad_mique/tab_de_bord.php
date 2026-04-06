<?php
require_once __DIR__ . '/../../../../config/config.php';
$page_title = 'Tableau de Bord';
$current_page = 'dashboard';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>
<div class="flex items-center gap-4 flex-1">
<div class="relative w-full max-w-md">
<span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">search</span>
<input class="w-full bg-surface-container-low border-none rounded-full py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-primary/20 transition-all" placeholder="Rechercher un étudiant, une UE..." type="text"/>
</div>
</div>
<div class="flex items-center gap-6">
<button class="relative p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
<span class="material-symbols-outlined">notifications</span>
<span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
</button>
<button class="p-2 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-full transition-colors">
<span class="material-symbols-outlined">settings</span>
</button>
<div class="h-8 w-[1px] bg-slate-200"></div>
<div class="flex items-center gap-3 cursor-pointer group">
<div class="text-right">
<p class="text-sm font-bold text-slate-900 leading-none">Admin Académique</p>
<p class="text-xs text-slate-500">Direction des études</p>
</div>
<img class="w-9 h-9 rounded-full object-cover ring-2 ring-primary/10 group-hover:ring-primary/30 transition-all" data-alt="Photo de profil de l'administrateur" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDi9zIyfvuLhLL9A5A5v3bC3rZiqhJmyDory4-5v8cNz8pCyHhHH6oro-lZLNDd6QfMAqKYpn67Eke6YVGrIhEB2PbuTiCYJ9fyEAcIuF0FFiZ8rPteezeK0pjPQz2M6wFgKeBVTG7EzFYqNyRB8dRmrWGHhTzMQGiG9ynzeAiJjRpnpZXz04ExQ0_awb7GjKTkcWNiuSG3yIxJQeNGxkrK7GNeGSduGxvU4zcAb2zww9FLwiMCEDtiA4GMVww7ebxaxmFeDAPZeCs"/>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="pl-64 pt-16 min-h-screen">
<div class="p-8 max-w-7xl mx-auto space-y-8">
<!-- Page Header -->
<div class="flex justify-between items-end">
<div>
<h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Tableau de Bord</h2>
<p class="text-slate-500 mt-1">Aperçu analytique de la performance académique LMD.</p>
</div>
<div class="flex gap-3">
<button onclick="exportReport()" class="bg-surface-container-low text-on-surface px-4 py-2 rounded-md text-sm font-semibold hover:bg-surface-container-high transition-colors flex items-center gap-2">
<span class="material-symbols-outlined text-lg">download</span>
                        Exporter le rapport
                    </button>
<button onclick="window.location.href='/kara_project/backend/saisie_notes_moyennes_backend.php'" class="bg-primary text-white px-4 py-2 rounded-md text-sm font-semibold hover:opacity-90 transition-opacity flex items-center gap-2 shadow-lg shadow-primary/20">
<span class="material-symbols-outlined text-lg">add</span>
                        Nouvelle saisie
                    </button>
</div>
</div>
<!-- Bento Grid Widgets -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
<!-- Widget: Total Students -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary/10 rounded-lg text-primary">
<span class="material-symbols-outlined">group</span>
</div>
<span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded-full">+4%</span>
</div>
<div>
<p class="text-3xl font-extrabold tracking-tighter">540</p>
<p class="text-sm font-medium text-slate-500">Étudiants inscrits</p>
</div>
</div>
<!-- Widget: Success Rate -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-secondary-container/20 rounded-lg text-secondary">
<span class="material-symbols-outlined">trending_up</span>
</div>
<span class="text-xs font-bold text-primary-container bg-primary/10 px-2 py-1 rounded-full">Stable</span>
</div>
<div>
<p class="text-3xl font-extrabold tracking-tighter">78%</p>
<p class="text-sm font-medium text-slate-500">Taux de réussite global</p>
</div>
</div>
<!-- Widget: Branches -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.04)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-tertiary-fixed-dim/30 rounded-lg text-tertiary">
<span class="material-symbols-outlined">account_tree</span>
</div>
</div>
<div>
<p class="text-3xl font-extrabold tracking-tighter">8</p>
<p class="text-sm font-medium text-slate-500">Filières actives</p>
</div>
</div>
<!-- Widget: Difficult UE -->
<div class="bg-slate-900 text-white p-6 rounded-xl shadow-[0_12px_32px_rgba(25,28,30,0.1)] flex flex-col justify-between">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-white/10 rounded-lg text-white">
<span class="material-symbols-outlined">warning</span>
</div>
</div>
<div>
<div class="flex gap-2 flex-wrap mb-1">
<span class="text-[10px] font-bold uppercase tracking-wider bg-error/20 text-error-container px-2 py-0.5 rounded">Maths I</span>
<span class="text-[10px] font-bold uppercase tracking-wider bg-error/20 text-error-container px-2 py-0.5 rounded">Algorithmique</span>
</div>
<p class="text-sm font-medium text-slate-300">UE les plus critiques</p>
</div>
</div>
</div>
<!-- Main Analytics Section -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
<!-- Performance Graph Area -->
<div class="lg:col-span-2 bg-surface-container-lowest rounded-xl p-8 shadow-[0_12px_32px_rgba(25,28,30,0.04)]">
<div class="flex justify-between items-center mb-10">
<h3 class="text-lg font-bold">Évolution des Moyennes</h3>
<select class="bg-surface-container-low border-none text-xs font-bold rounded-md px-3 py-1.5 focus:ring-0">
<option>Semestre 1 - 2023</option>
<option>Semestre 2 - 2023</option>
</select>
</div>
<!-- SVG Chart Mockup -->
<div class="relative h-[300px] w-full mt-4">
<svg class="w-full h-full" viewbox="0 0 800 300">
<!-- Grid lines -->
<line stroke="#f2f4f6" stroke-width="1" x1="0" x2="800" y1="50" y2="50"></line>
<line stroke="#f2f4f6" stroke-width="1" x1="0" x2="800" y1="150" y2="150"></line>
<line stroke="#f2f4f6" stroke-width="1" x1="0" x2="800" y1="250" y2="250"></line>
<!-- Area Gradient -->
<defs>
<lineargradient id="chartGradient" x1="0" x2="0" y1="0" y2="1">
<stop offset="0%" stop-color="#1a56db" stop-opacity="0.1"></stop>
<stop offset="100%" stop-color="#1a56db" stop-opacity="0"></stop>
</lineargradient>
</defs>
<!-- Main Path -->
<path d="M0,220 Q100,200 200,180 T400,140 T600,160 T800,100" fill="none" stroke="#1a56db" stroke-linecap="round" stroke-width="3"></path>
<path d="M0,220 Q100,200 200,180 T400,140 T600,160 T800,100 L800,300 L0,300 Z" fill="url(#chartGradient)"></path>
<!-- Data Points -->
<circle cx="200" cy="180" fill="#1a56db" r="4"></circle>
<circle cx="400" cy="140" fill="#1a56db" r="4"></circle>
<circle cx="600" cy="160" fill="#1a56db" r="4"></circle>
<circle cx="800" cy="100" fill="#1a56db" r="4"></circle>
</svg>
<!-- Axis Labels -->
<div class="flex justify-between mt-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
<span>Octobre</span>
<span>Novembre</span>
<span>Décembre</span>
<span>Janvier</span>
<span>Février</span>
</div>
</div>
</div>
<!-- Side Activity: Recent Grades -->
<div class="bg-surface-container-lowest rounded-xl p-6 shadow-[0_12px_32px_rgba(25,28,30,0.04)]">
<div class="flex justify-between items-center mb-6">
<h3 class="text-lg font-bold">Dernières Notes</h3>
<a class="text-xs font-bold text-primary hover:underline" href="/kara_project/backend/saisie_notes_par_ec_backend.php">Voir tout</a>
</div>
<div class="space-y-4">
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    AM
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">Alassane M.</p>
<p class="text-[11px] text-slate-500 font-medium">Mathématiques I</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-primary">16.50</p>
<p class="text-[10px] text-slate-400">Il y a 10m</p>
</div>
</div>
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    SK
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">Sarah K.</p>
<p class="text-[11px] text-slate-500 font-medium">Algorithmique</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-error">08.25</p>
<p class="text-[10px] text-slate-400">Il y a 45m</p>
</div>
</div>
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    BJ
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">Bakary J.</p>
<p class="text-[11px] text-slate-500 font-medium">Anglais Tech.</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-primary">14.00</p>
<p class="text-[10px] text-slate-400">Il y a 1h</p>
</div>
</div>
<!-- Grade Row -->
<div class="flex items-center justify-between p-3 rounded-lg hover:bg-surface-container-low transition-colors group">
<div class="flex items-center gap-3">
<div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 font-bold text-xs">
                                    CL
                                </div>
<div>
<p class="text-sm font-bold text-slate-900">Cécile L.</p>
<p class="text-[11px] text-slate-500 font-medium">Bases de Données</p>
</div>
</div>
<div class="text-right">
<p class="text-sm font-black text-primary">19.00</p>
<p class="text-[10px] text-slate-400">Il y a 3h</p>
</div>
</div>
</div>
<div class="mt-8 pt-6 border-t border-slate-50">
<div class="bg-surface-container-low p-4 rounded-lg">
<p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-3">Statut Saisie</p>
<div class="flex justify-between items-center text-sm font-medium">
<span class="text-slate-600">Progrès Saisie S1</span>
<span class="text-primary font-bold">92%</span>
</div>
<div class="w-full bg-white h-1.5 rounded-full mt-2">
<div class="bg-primary h-full rounded-full w-[92%] shadow-sm"></div>
</div>
</div>
</div>
</div>
</div>
<!-- Footer Section: Institutional Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-8 pb-12">
<div class="bg-surface-container-low rounded-xl p-6 flex items-center gap-6">
<div class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center">
<span class="material-symbols-outlined text-primary text-3xl">verified_user</span>
</div>
<div>
<h4 class="font-bold text-slate-900">Validation des Semestres</h4>
<p class="text-sm text-slate-500">65% des étudiants ont déjô  validé l'intégralité de leurs UE du semestre en cours.</p>
</div>
</div>
<div class="bg-surface-container-low rounded-xl p-6 flex items-center gap-6">
<div class="w-16 h-16 bg-white rounded-xl shadow-sm flex items-center justify-center">
<span class="material-symbols-outlined text-secondary text-3xl">history_edu</span>
</div>
<div>
<h4 class="font-bold text-slate-900">Rattrapages Prévisionnels</h4>
<p class="text-sm text-slate-500">Une baisse de 12% des passages en rattrapage est observée par rapport ô  l'année N-1.</p>
</div>
</div>
</div>
</div>
</main>
<!-- Contextual FAB (Suppressed based on layout rules for dashboard context focus, but kept empty for spacing if needed) -->
</body>

<script>
function exportReport() {
    window.location.href = '../../../../backend/rapport_pdf_backend.php';
}
</script>

</html>
