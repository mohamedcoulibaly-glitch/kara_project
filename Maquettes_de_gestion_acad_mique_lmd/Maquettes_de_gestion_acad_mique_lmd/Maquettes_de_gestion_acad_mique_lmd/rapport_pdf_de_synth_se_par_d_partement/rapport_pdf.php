<?php
$page_title = 'Rapport de Synthèse';
$current_page = 'dashboard';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Header Options -->
<div class="mb-6 flex flex-col md:flex-row md:justify-between md:items-center gap-4 print:hidden">
    <div>
        <nav class="flex items-center text-[10px] font-bold text-slate-500 mb-1 gap-1 uppercase tracking-widest">
            <a href="../../index.php" class="hover:text-primary">Dashboard</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary">Rapport Départemental</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight">Rapport de Synthèse Analytique</h1>
    </div>
    <div class="flex gap-3">
        <button class="bg-primary hover:bg-primary-container text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md shadow-primary/20 transition-all flex items-center gap-2" onclick="window.print()">
            <span class="material-symbols-outlined text-sm">picture_as_pdf</span>
            Exporter PDF
        </button>
    </div>
</div>

<!-- A4 Page Container -->
<div class="bg-white mx-auto shadow-sm border border-slate-200 overflow-hidden print:shadow-none print:border-none print:w-full max-w-5xl" style="font-family: 'Inter', sans-serif;">
    
    <!-- En-tête du Rapport -->
    <div class="bg-slate-800 text-white p-10 flex justify-between items-center print:bg-white print:text-black print:border-b-4 print:border-slate-800">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <span class="material-symbols-outlined text-4xl opacity-80 print:text-black">analytics</span>
                <span class="text-xs font-bold uppercase tracking-[0.2em] opacity-80">Rapport Annuel</span>
            </div>
            <h1 class="text-4xl font-black uppercase tracking-tight leading-none mb-2">
                <?= htmlspecialchars($departement_info['nom_dept'] ?? 'Département') ?>
            </h1>
            <p class="text-sm font-mono opacity-70">
                Code: <?= htmlspecialchars($departement_info['code_dept'] ?? 'N/A') ?> | Chef de Dpt: <?= htmlspecialchars($departement_info['chef_dept'] ?? 'Non assigné') ?>
            </p>
        </div>
        <div class="text-right">
            <div class="text-[10px] uppercase font-bold tracking-widest opacity-60 mb-1">Généré le</div>
            <div class="text-lg font-bold font-mono bg-white/10 px-4 py-2 rounded border border-white/20 print:bg-transparent print:border-slate-400 print:text-black">
                <?= date('d M Y - H:i', strtotime($date_generation)) ?>
            </div>
        </div>
    </div>
    
    <div class="p-10 space-y-10">
        <!-- Chiffres Clés -->
        <section>
            <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-4 border-b border-slate-200 pb-2">Chiffres Clés</h2>
            <div class="grid grid-cols-4 gap-6">
                <div class="p-6 bg-slate-50 rounded-xl border border-slate-100 flex flex-col print:border-slate-300">
                    <span class="material-symbols-outlined text-primary mb-2 text-3xl">school</span>
                    <span class="text-4xl font-black text-slate-800 mb-1"><?= $stats_globales['total_inscrits'] ?? 0 ?></span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Inscrits G.</span>
                </div>
                <div class="p-6 bg-slate-50 rounded-xl border border-slate-100 flex flex-col print:border-slate-300">
                    <span class="material-symbols-outlined text-green-500 mb-2 text-3xl">verified</span>
                    <span class="text-4xl font-black text-slate-800 mb-1"><?= $stats_globales['admis'] ?? 0 ?></span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Admis G.</span>
                </div>
                <div class="p-6 bg-slate-50 rounded-xl border border-slate-100 flex flex-col print:border-slate-300">
                    <span class="material-symbols-outlined text-slate-400 mb-2 text-3xl">account_tree</span>
                    <span class="text-4xl font-black text-slate-800 mb-1"><?= $stats_globales['total_filieres'] ?? 0 ?></span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Filières</span>
                </div>
                <div class="p-6 bg-slate-50 rounded-xl border border-slate-100 flex flex-col print:border-slate-300 relative overflow-hidden">
                    <span class="material-symbols-outlined text-secondary absolute -right-2 -top-2 text-6xl opacity-10">trending_up</span>
                    <span class="material-symbols-outlined text-secondary mb-2 text-3xl">trending_up</span>
                    <?php $taux = ($stats_globales['total_inscrits'] > 0) ? ($stats_globales['admis'] / $stats_globales['total_inscrits']) * 100 : 0; ?>
                    <span class="text-4xl font-black text-slate-800 mb-1"><?= round($taux, 1) ?><span class="text-2xl text-slate-400">%</span></span>
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Taux de Réussite Glob.</span>
                </div>
            </div>
        </section>

        <div class="grid grid-cols-2 gap-10 print:grid-cols-2 print:break-inside-avoid">
            <!-- Réussites par Filière -->
            <section>
                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-4 border-b border-slate-200 pb-2 flex justify-between items-center">
                    <span>Performance par Filière</span>
                    <span class="material-symbols-outlined text-sm">bar_chart</span>
                </h2>
                
                <?php if (empty($taux_reussite_filiere)): ?>
                    <p class="text-sm text-slate-400 italic py-4">Données insuffisantes pour les filières.</p>
                <?php else: ?>
                    <div class="space-y-5">
                        <?php foreach ($taux_reussite_filiere as $f): ?>
                            <div>
                                <div class="flex justify-between items-end mb-1">
                                    <span class="text-sm font-bold text-slate-700 truncate mr-2" title="<?= htmlspecialchars($f['filiere']) ?>">
                                        <?= htmlspecialchars($f['filiere']) ?>
                                    </span>
                                    <span class="text-xs font-black <?= $f['taux'] >= 50 ? 'text-primary' : 'text-red-500' ?>">
                                        <?= round($f['taux'], 1) ?>%
                                    </span>
                                </div>
                                <div class="h-2 w-full bg-slate-100 rounded-full overflow-hidden print:border print:border-slate-300 print:bg-white">
                                    <div class="h-full <?= $f['taux'] >= 50 ? 'bg-primary' : 'bg-red-500' ?> print:bg-slate-800" style="width: <?= $f['taux'] ?>%"></div>
                                </div>
                                <div class="text-[10px] text-slate-500 mt-1">
                                    <?= $f['admis'] ?> admis sur <?= $f['total'] ?> au total
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </section>
            
            <!-- Répartition des Statuts -->
            <section>
                <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-4 border-b border-slate-200 pb-2 flex justify-between items-center">
                    <span>Répartition des Décisions</span>
                    <span class="material-symbols-outlined text-sm">pie_chart</span>
                </h2>
                
                <?php if (empty($repartition_statuts)): ?>
                    <p class="text-sm text-slate-400 italic py-4">Aucune délibération enregistrée.</p>
                <?php else: ?>
                    <div class="bg-white rounded-xl overflow-hidden print:border print:border-slate-300">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-slate-50 text-[10px] font-bold uppercase text-slate-500 border-b border-slate-100">
                                <tr>
                                    <th class="py-3 px-4">Statut</th>
                                    <th class="py-3 px-4 text-center">Effectif</th>
                                    <th class="py-3 px-4 text-right">Proportion</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                <?php foreach ($repartition_statuts as $r): ?>
                                <?php 
                                    $colorClass = 'text-slate-600'; $bgClass = 'bg-slate-50';
                                    if(strtoupper($r['statut_deliberation']) == 'ADMIS') { $colorClass = 'text-green-600'; $bgClass = 'bg-green-100'; }
                                    if(strtoupper($r['statut_deliberation']) == 'REDOUBLANT') { $colorClass = 'text-amber-500'; $bgClass = 'bg-amber-100'; }
                                    if(strtoupper($r['statut_deliberation']) == 'AJOURNE') { $colorClass = 'text-red-600'; $bgClass = 'bg-red-100'; }
                                ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="py-3 px-4 font-bold <?= $colorClass ?>">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full <?= $bgClass ?>"></div>
                                            <?= htmlspecialchars($r['statut_deliberation']) ?>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4 text-center font-mono font-bold text-slate-700">
                                        <?= $r['total'] ?>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <span class="bg-slate-100 px-2 py-1 rounded text-xs font-bold text-slate-500 print:border print:border-slate-300">
                                            <?= round(($r['total'] / $stats_globales['total_inscrits']) * 100, 1) ?>%
                                        </span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </section>
        </div>
        
        <!-- Top Étudiants (Majorité) -->
        <section class="print:break-before-auto">
            <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400 mb-4 border-b border-slate-200 pb-2 flex justify-between items-center">
                <span>Majors de Promotion (Top 10)</span>
                <span class="material-symbols-outlined text-sm">workspace_premium</span>
            </h2>
            
            <?php if (empty($top_etudiants)): ?>
                <p class="text-sm text-slate-400 italic py-4">Générez des délibérations pour afficher le classement.</p>
            <?php else: ?>
                <div class="border border-slate-200 rounded-xl overflow-hidden print:border-slate-300">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 border-b border-slate-200 text-[10px] font-bold uppercase text-slate-500">
                            <tr>
                                <th class="py-3 px-4 w-12 text-center">Rang</th>
                                <th class="py-3 px-4">Étudiant</th>
                                <th class="py-3 px-4">Filière</th>
                                <th class="py-3 px-4 text-center">Moyenne</th>
                                <th class="py-3 px-4 text-center">Mention</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php $rang = 1; foreach ($top_etudiants as $top): ?>
                                <?php 
                                    $moyenne = $top['moyenne_etudiant'] ?? 0;
                                    $mention = 'Non Admis';
                                    if ($moyenne >= 16) $mention = 'Très Bien';
                                    elseif ($moyenne >= 14) $mention = 'Bien';
                                    elseif ($moyenne >= 12) $mention = 'Assez Bien';
                                    elseif ($moyenne >= 10) $mention = 'Passable';
                                ?>
                                <tr class="<?= $rang <= 3 ? 'bg-[#1A56DB]/5 print:bg-transparent' : 'bg-white' ?>">
                                    <td class="py-3 px-4 text-center font-black <?= $rang == 1 ? 'text-[#FFD700]' : ($rang == 2 ? 'text-[#C0C0C0]' : ($rang == 3 ? 'text-[#CD7F32]' : 'text-slate-400')) ?>">
                                        <?= $rang++ ?>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="font-bold text-slate-800"><?= htmlspecialchars(($top['nom'] ?? '') . ' ' . ($top['prenom'] ?? '')) ?></div>
                                        <div class="text-[10px] font-mono text-slate-500"><?= htmlspecialchars($top['matricule'] ?? '') ?></div>
                                    </td>
                                    <td class="py-3 px-4 text-xs font-medium text-slate-600 truncate max-w-[200px]" title="<?= htmlspecialchars($top['nom_filiere'] ?? '') ?>">
                                        <?= htmlspecialchars($top['nom_filiere'] ?? '') ?>
                                    </td>
                                    <td class="py-3 px-4 text-center font-mono font-bold <?= $moyenne >= 14 ? 'text-primary' : 'text-slate-700' ?>">
                                        <?= number_format($moyenne, 2, ',', ' ') ?>
                                    </td>
                                    <td class="py-3 px-4 text-center">
                                        <span class="text-[10px] font-bold uppercase bg-slate-100 text-slate-600 px-2 py-1 rounded print:border print:border-slate-300">
                                            <?= $mention ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

    </div>
</div>

<style>
@media print {
    body { background: white !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
}
</style>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
