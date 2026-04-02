<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/statistiques_reussites_backend.php';
// Variables from backend: $departements, $stats_departements, $stats_globales, $repartition
$page_title = 'Statistiques de Réussite';
$current_page = 'statistiques';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<!-- Section 1: Header & Filters -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-12 gap-4">
<div>
<h2 class="text-3xl font-extrabold text-on-surface tracking-tight mb-1">Statistiques de Réussite par Département</h2>
<p class="text-on-surface-variant text-sm">Analyse comparative des performances académiques</p>
</div>
<div class="flex items-center gap-3 bg-surface-container-low p-1.5 rounded-xl shadow-sm">
<div class="flex items-center px-3 py-1.5 bg-surface-container-lowest rounded-lg shadow-sm">
<span class="material-symbols-outlined text-sm mr-2" data-icon="calendar_today">calendar_today</span>
<select class="bg-transparent border-none text-sm font-semibold p-0 focus:ring-0">
<option>Année 2023-2024</option>
<option>Année 2022-2023</option>
</select>
</div>
<button class="px-4 py-1.5 text-sm font-semibold text-primary hover:bg-primary/5 rounded-lg transition-colors">
                        Filtres Avancés
                    </button>
</div>
</div>
<!-- Section 2: KPI Summary (Bento Grid Style) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 relative overflow-hidden">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-secondary-container/30 rounded-lg text-secondary">
<span class="material-symbols-outlined" data-icon="school">school</span>
</div>
<span class="text-xs font-bold text-secondary uppercase tracking-wider">Réussite Globale</span>
</div>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-on-surface tracking-tighter"><?= $stats_globales['taux_global'] ?>%</span>
<span class="text-xs font-bold text-green-600 flex items-center bg-green-50 px-1.5 py-0.5 rounded">+2.1%</span>
</div>
<p class="text-xs text-on-surface-variant mt-2 font-medium">Réussis: <?= $stats_globales['total_reussis'] ?> / <?= $stats_globales['total_etudiants'] ?></p>
<div class="absolute bottom-0 left-0 w-full h-1 bg-secondary-container"></div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 relative overflow-hidden">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-primary-container/10 rounded-lg text-primary">
<span class="material-symbols-outlined" data-icon="star">star</span>
</div>
<span class="text-xs font-bold text-primary uppercase tracking-wider">Moyenne Générale</span>
</div>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-on-surface tracking-tighter"><?= $stats_globales['moyenne_globale'] ?></span>
<span class="text-xs font-bold text-on-surface-variant">/ 20</span>
</div>
<p class="text-xs text-on-surface-variant mt-2 font-medium">Min: <?= $stats_globales['note_min'] ?> | Max: <?= $stats_globales['note_max'] ?></p>
<div class="absolute bottom-0 left-0 w-full h-1 bg-primary"></div>
</div>
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 relative overflow-hidden">
<div class="flex justify-between items-start mb-4">
<div class="p-2 bg-tertiary-fixed/30 rounded-lg text-tertiary">
<span class="material-symbols-outlined" data-icon="verified">verified</span>
</div>
<span class="text-xs font-bold text-tertiary uppercase tracking-wider">ECTS Validés</span>
</div>
<div class="flex items-baseline gap-2">
<span class="text-4xl font-black text-on-surface tracking-tighter"><?= $stats_globales['taux_global'] ?>%</span>
<span class="text-xs font-bold text-tertiary-container flex items-center bg-tertiary-fixed/20 px-1.5 py-0.5 rounded">Calculé</span>
</div>
<p class="text-xs text-on-surface-variant mt-2 font-medium">Taux basé sur <?= $stats_globales['total_notes'] ?> notes</p>
<div class="absolute bottom-0 left-0 w-full h-1 bg-tertiary"></div>
</div>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
<!-- Section 3: Bar Comparison Chart (Visual Simulation) -->
<div class="lg:col-span-2 bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/10">
<div class="flex justify-between items-center mb-8">
<h3 class="font-bold text-lg text-on-surface">Comparaison par Département (%)</h3>
<div class="flex gap-2">
<div class="flex items-center gap-1.5">
<span class="w-3 h-3 rounded-full bg-primary"></span>
<span class="text-xs font-medium text-on-surface-variant">Réussite</span>
</div>
</div>
</div>
<div class="flex flex-col gap-6">
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Informatique</span>
<span>82%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary rounded-full" style="width: 82%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Gestion</span>
<span>74%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary/70 rounded-full" style="width: 74%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Sciences de la Vie</span>
<span>68%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary/50 rounded-full" style="width: 68%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Droit &amp; Sciences Po</span>
<span>89%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary rounded-full" style="width: 89%"></div>
</div>
</div>
<div class="space-y-2">
<div class="flex justify-between text-xs font-bold uppercase text-on-surface-variant tracking-widest">
<span>Lettres &amp; Langues</span>
<span>79%</span>
</div>
<div class="w-full h-3 bg-surface-container rounded-full overflow-hidden">
<div class="h-full bg-primary/60 rounded-full" style="width: 79%"></div>
</div>
</div>
</div>
</div>
<!-- Section 5: Distribution Chart (Mentions) -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
    <div class="lg:col-span-2 bg-white p-8 rounded-xl shadow-sm border border-outline-variant/10">
        <h3 class="font-bold text-lg text-on-surface mb-6">Répartition par Note</h3>
        <div class="grid grid-cols-5 gap-4">
            <?php foreach($repartition as $label => $val): ?>
            <div class="text-center">
                <div class="w-full bg-slate-50 rounded-lg h-32 flex items-end justify-center mb-2 overflow-hidden">
                    <div class="bg-primary/80 w-full hover:bg-primary transition-all cursor-pointer" style="height: <?= $val ?>%"></div>
                </div>
                <p class="text-xs font-bold text-slate-700"><?= $val ?>%</p>
                <p class="text-[10px] text-slate-400 uppercase font-black tracking-tighter mt-1"><?= str_replace('_', ' ', $label) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="bg-white p-8 rounded-xl shadow-sm border border-outline-variant/10 flex flex-col items-center justify-center">
        <h3 class="font-bold text-sm text-slate-400 uppercase tracking-widest mb-8">Performance Globale</h3>
        <div class="relative w-40 h-40 rounded-full border-[12px] border-slate-50 flex items-center justify-center" style="background: conic-gradient(#1A56DB 0% <?= $stats_globales['taux_global'] ?>%, #e2e8f0 <?= $stats_globales['taux_global'] ?>% 100%);">
            <div class="absolute inset-2 bg-white rounded-full shadow-inner flex flex-col items-center justify-center">
                <span class="text-2xl font-black text-slate-800"><?= $stats_globales['taux_global'] ?>%</span>
                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Validé</span>
            </div>
        </div>
    </div>
</div>

<!-- Section 4: Detailed Table -->
<div class="bg-white rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden">
    <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
        <h3 class="font-bold text-lg text-slate-800">Détails de Performance par Département</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-400 border-b border-slate-100">Département</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 text-center">Inscrits</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 text-center">Moyenne</th>
                    <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-slate-400 border-b border-slate-100 text-right">Taux de Succès</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php foreach ($stats_departements as $id => $stats): ?>
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-5">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded bg-primary/5 flex items-center justify-center text-primary font-black text-xs"><?= substr($stats['nom'], 0, 2) ?></div>
                            <span class="text-sm font-bold text-slate-700"><?= htmlspecialchars($stats['nom']) ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-5 text-sm text-slate-500 text-center font-bold"><?= number_format($stats['nombre_etudiants']) ?></td>
                    <td class="px-6 py-5 text-sm text-primary text-center font-black"><?= number_format($stats['moyenne'], 2) ?></td>
                    <td class="px-6 py-5 text-right">
                        <div class="flex items-center justify-end gap-3">
                            <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-primary rounded-full" style="width: <?= $stats['taux_reussite'] ?>%"></div>
                            </div>
                            <span class="text-xs font-black text-slate-800 w-10"><?= $stats['taux_reussite'] ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</main>
<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
</body></html>
