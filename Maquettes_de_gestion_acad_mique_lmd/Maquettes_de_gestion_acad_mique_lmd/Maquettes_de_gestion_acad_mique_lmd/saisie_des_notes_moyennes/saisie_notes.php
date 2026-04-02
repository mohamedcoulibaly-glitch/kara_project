<?php
require_once __DIR__ . '/../../../../config/config.php';
$page_title = 'Saisie des Notes';
$current_page = 'notes';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<!-- Header Section -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
<div>
<h1 class="text-2xl font-bold text-on-background tracking-tight">Saisie des Notes</h1>
<p class="text-on-surface-variant text-sm mt-1">Évaluation continue et examen final</p>
</div>
<div class="flex items-center gap-3">
<button class="bg-surface-container-low text-on-surface font-medium px-4 py-2 rounded-md flex items-center gap-2 hover:bg-surface-container transition-colors">
<span class="material-symbols-outlined text-lg">download</span>
<span>Importer CSV</span>
</button>
<button class="bg-primary text-on-primary font-semibold px-6 py-2 rounded-md shadow-md flex items-center gap-2 hover:bg-primary-container transition-all active:scale-95">
<span class="material-symbols-outlined text-lg">save</span>
<span>Enregistrer les notes</span>
</button>
</div>
</div>
<!-- Selection Bar -->
<div class="bg-surface-container-low p-4 rounded-xl mb-8 flex flex-wrap gap-6 items-center">
<div class="flex flex-col gap-1">
<label class="text-[10px] uppercase font-bold text-outline tracking-wider px-1">Filière</label>
<div class="bg-surface-container-lowest px-3 py-2 rounded-md flex items-center gap-2 min-w-[140px] shadow-sm">
<span class="material-symbols-outlined text-blue-600 text-sm">school</span>
<span class="text-sm font-semibold">L1 Informatique</span>
</div>
</div>
<span class="material-symbols-outlined text-outline-variant">chevron_right</span>
<div class="flex flex-col gap-1">
<label class="text-[10px] uppercase font-bold text-outline tracking-wider px-1">Unité d'Enseignement (UE)</label>
<div class="bg-surface-container-lowest px-3 py-2 rounded-md flex items-center gap-2 min-w-[180px] shadow-sm">
<span class="material-symbols-outlined text-blue-600 text-sm">calculate</span>
<span class="text-sm font-semibold">Mathématiques I</span>
</div>
</div>
<span class="material-symbols-outlined text-outline-variant">chevron_right</span>
<div class="flex flex-col gap-1">
<label class="text-[10px] uppercase font-bold text-outline tracking-wider px-1">Élément Constitutif (EC)</label>
<div class="bg-surface-container-lowest border-2 border-primary/20 px-3 py-2 rounded-md flex items-center gap-2 min-w-[140px] shadow-sm">
<span class="material-symbols-outlined text-blue-600 text-sm">functions</span>
<span class="text-sm font-semibold">Algèbre</span>
</div>
</div>
<div class="ml-auto flex items-center gap-4">
<div class="h-10 w-[1px] bg-outline-variant/30"></div>
<div class="flex flex-col items-end">
<span class="text-[10px] uppercase font-bold text-outline tracking-wider">Crédits</span>
<span class="text-lg font-black text-primary">6 ECTS</span>
</div>
</div>
</div>
<!-- Data Grid -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low border-b border-outline-variant/10">
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-24">Matricule</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest">Nom &amp; Prénom</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-40">Session</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-48 text-right">Note / 20</th>
<th class="px-6 py-4 text-[11px] font-bold text-outline uppercase tracking-widest w-32 text-center">Statut</th>
</tr>
</thead>
<tbody class="divide-y divide-surface-container">
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF001</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">AMADOU Bakary</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="14.50"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">Validé</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF002</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">BERNARD Sophie</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="16.75"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">Validé</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF003</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">DIARRA Mamadou</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-error ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="08.00"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-tertiary-container text-on-tertiary-container">Rattrapage</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF004</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">KOVAC Elena</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none" max="20" min="0" step="0.25" type="number" value="12.25"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-secondary-container text-on-secondary-container">Validé</span>
</td>
</tr>
<tr class="hover:bg-surface-container-low transition-colors group">
<td class="px-6 py-4 text-sm font-mono text-on-surface-variant">24INF005</td>
<td class="px-6 py-4 text-sm font-semibold text-on-surface">NGUYEN Anh</td>
<td class="px-6 py-4">
<select class="bg-transparent border-none focus:ring-0 text-xs font-medium text-on-surface-variant cursor-pointer">
<option>Session Normale</option>
<option>Rattrapage</option>
</select>
</td>
<td class="px-6 py-4 text-right">
<input class="w-24 bg-surface-container-highest border-none rounded-md px-3 py-2 text-right font-bold text-primary ghost-border-focus transition-all outline-none border-b-2 border-primary-fixed-dim/30" max="20" min="0" placeholder="--" step="0.25" type="number"/>
</td>
<td class="px-6 py-4 text-center">
<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider bg-surface-variant text-on-surface-variant">En attente</span>
</td>
</tr>
</tbody>
</table>
</div>
<!-- Footer Highlight Stats -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="bg-white p-6 rounded-xl shadow-sm flex items-center justify-between border-l-4 border-primary">
<div>
<p class="text-[11px] font-bold text-outline uppercase tracking-wider">Moyenne de l'EC</p>
<h3 class="text-3xl font-black text-on-background mt-1">12.88 <span class="text-sm font-medium text-outline">/ 20</span></h3>
</div>
<div class="w-12 h-12 rounded-full bg-primary-container/10 flex items-center justify-center">
<span class="material-symbols-outlined text-primary">trending_up</span>
</div>
</div>
<div class="bg-white p-6 rounded-xl shadow-sm flex items-center justify-between border-l-4 border-secondary">
<div>
<p class="text-[11px] font-bold text-outline uppercase tracking-wider">Taux de Réussite</p>
<h3 class="text-3xl font-black text-on-background mt-1">75%</h3>
</div>
<div class="w-12 h-12 rounded-full bg-secondary-container/10 flex items-center justify-center">
<span class="material-symbols-outlined text-secondary">analytics</span>
</div>
</div>
<div class="bg-primary p-6 rounded-xl shadow-lg flex items-center justify-between">
<div>
<p class="text-[11px] font-bold text-primary-fixed-dim uppercase tracking-wider">Moyenne Pondérée UE</p>
<h3 class="text-3xl font-black text-white mt-1">13.45 <span class="text-sm font-medium text-primary-fixed-dim">/ 20</span></h3>
</div>
<div class="flex flex-col items-center">
<span class="text-[10px] font-bold text-white uppercase mb-1">Status UE</span>
<span class="px-3 py-1 bg-white text-primary text-[10px] font-black rounded-full uppercase tracking-tighter">Validée</span>
</div>
</div>
</div>
<!-- Floating Action Indicator (Visual only) -->
<div class="fixed bottom-8 right-8 flex flex-col items-end gap-2 pointer-events-none opacity-0 md:opacity-100">
<div class="bg-on-background text-white px-4 py-2 rounded-lg text-xs font-medium shadow-2xl flex items-center gap-2">
<span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                Toutes les modifications sont synchronisées localement
            </div>
</div>
</main>
</body></html>
