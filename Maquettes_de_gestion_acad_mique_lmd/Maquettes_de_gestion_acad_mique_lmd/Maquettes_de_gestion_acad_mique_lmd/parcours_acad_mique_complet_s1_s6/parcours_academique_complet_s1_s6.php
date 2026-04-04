<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/parcours_academique_backend.php';
$page_title = 'Parcours Académique S1-S6';
$current_page = 'parcours';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Header -->
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex items-center text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
            <a href="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php" class="hover:text-primary transition-colors">Répertoire</a>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary font-bold">Parcours de l'Étudiant</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Parcours Académique Complet</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Aperçu détaillé de l'évolution de l'étudiant du Semestre 1 au Semestre 6.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php" class="bg-white border border-outline-variant/30 text-slate-600 px-4 py-2.5 rounded-lg text-sm font-bold shadow-sm hover:bg-slate-50 transition-colors flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            Retour 
        </a>
        <button class="bg-primary hover:bg-primary-container text-white px-5 py-2.5 rounded-lg text-sm font-bold shadow-md shadow-primary/20 transition-all flex items-center gap-2" onclick="window.print()">
            <span class="material-symbols-outlined text-sm">print</span>
            Imprimer
        </button>
    </div>
</div>

<!-- Profil de l'étudiant -->
<div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6 mb-8 flex flex-col md:flex-row gap-8 items-center md:items-start max-w-5xl">
    <div class="h-28 w-28 rounded-full bg-slate-100 border-4 border-white shadow-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
        <?php if (!empty($etudiant['photo_url'])): ?>
            <img src="<?= htmlspecialchars($etudiant['photo_url']) ?>" alt="Photo étudiant" class="h-full w-full object-cover">
        <?php else: ?>
            <span class="material-symbols-outlined text-5xl text-slate-300">person</span>
        <?php endif; ?>
    </div>
    <div class="flex-1 text-center md:text-left">
        <div class="flex flex-wrap items-center justify-center md:justify-start gap-3 mb-2">
            <h2 class="text-2xl font-black text-slate-800"><?= htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']) ?></h2>
            <span class="bg-primary/10 text-primary border border-primary/20 px-3 py-1 rounded-full text-xs font-bold font-mono tracking-widest">
                <?= htmlspecialchars($etudiant['matricule']) ?>
            </span>
        </div>
        <div class="flex flex-wrap justify-center md:justify-start gap-4 gap-y-2 text-sm text-slate-600 mb-4">
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">school</span> <?= htmlspecialchars($etudiant['nom_filiere']) ?></span>
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">domain</span> <?= htmlspecialchars($etudiant['nom_dept']) ?></span>
            <span class="flex items-center gap-1"><span class="material-symbols-outlined text-[16px]">cake</span> <?= htmlspecialchars(date('d/m/Y', strtotime($etudiant['date_naissance']))) ?></span>
        </div>
        
        <!-- Progression Bar -->
        <div class="w-full max-w-md">
            <div class="flex justify-between text-xs font-bold uppercase mb-1.5">
                <span class="text-slate-500">Progression LMD (<?= $credits_totaux ?>/180 ECTS)</span>
                <span class="text-primary"><?= number_format($progression_percentage, 1) ?>%</span>
            </div>
            <div class="h-2.5 w-full bg-slate-100 rounded-full overflow-hidden">
                <div class="h-full bg-primary rounded-full" style="width: <?= $progression_percentage ?>%"></div>
            </div>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/20 shadow-sm text-center min-w-[160px]">
        <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Moyenne Générale</span>
        <span class="block text-3xl font-black <?= $moyenne_generale >= 10 ? 'text-green-600' : 'text-red-500' ?>">
            <?= number_format($moyenne_generale, 2, ',', ' ') ?>
        </span>
        <span class="block text-xs font-medium text-slate-500 mt-1">/ 20</span>
    </div>
</div>

<!-- Grille des semestres -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-7xl">
    <?php foreach ($parcours_par_semestre as $sem): ?>
        <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 overflow-hidden flex flex-col">
            <!-- Header Semestre -->
            <div class="px-5 py-4 flex justify-between items-center border-b border-outline-variant/20 
                        <?= $sem['statut'] == 'Admis' ? 'bg-green-50/50' : ($sem['statut'] == 'En cours' ? 'bg-slate-50' : 'bg-red-50/50') ?>">
                <h3 class="font-bold text-slate-800 text-lg flex items-center gap-2">
                    <span class="bg-slate-800 text-white w-7 h-7 rounded text-xs flex items-center justify-center shadow-sm">S<?= $sem['semestre'] ?></span>
                    Semestre <?= $sem['semestre'] ?>
                </h3>
                <div class="flex items-center gap-3">
                    <?php if ($sem['statut'] == 'Admis'): ?>
                        <span class="bg-green-100 text-green-700 font-bold px-2.5 py-1 rounded text-[10px] uppercase tracking-wider flex items-center gap-1 border border-green-200">
                            <span class="material-symbols-outlined text-[14px]">check_circle</span> Validé
                        </span>
                    <?php elseif ($sem['moyenne_semestre'] > 0): ?>
                        <span class="bg-red-100 text-red-700 font-bold px-2.5 py-1 rounded text-[10px] uppercase tracking-wider flex items-center gap-1 border border-red-200">
                            <span class="material-symbols-outlined text-[14px]">cancel</span> Non Validé
                        </span>
                    <?php else: ?>
                        <span class="bg-slate-200 text-slate-600 font-bold px-2.5 py-1 rounded text-[10px] uppercase tracking-wider flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">pending</span> En attente
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Statistiques Semestre -->
            <div class="grid grid-cols-2 bg-slate-50/50 divide-x divide-slate-100 border-b border-outline-variant/10 text-center">
                <div class="py-3">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Moyenne</span>
                    <span class="block text-xl font-black <?= $sem['moyenne_semestre'] >= 10 ? 'text-green-600' : ($sem['moyenne_semestre'] > 0 ? 'text-red-500' : 'text-slate-400') ?>">
                        <?= $sem['moyenne_semestre'] > 0 ? number_format($sem['moyenne_semestre'], 2, ',', ' ') : '-' ?>
                    </span>
                </div>
                <div class="py-3">
                    <span class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Crédits ECTS</span>
                    <span class="block text-xl font-black <?= $sem['credits_obtenus'] > 0 ? 'text-primary' : 'text-slate-400' ?>">
                        <?= $sem['credits_obtenus'] ?> <span class="text-sm font-medium">/ 30</span>
                    </span>
                </div>
            </div>
            
            <!-- Liste des UEs -->
            <div class="flex-1 p-0 overflow-y-auto max-h-80">
                <?php if (empty($sem['ues'])): ?>
                    <div class="p-8 text-center text-slate-400 text-sm italic">
                        Aucune note enregistrée pour ce semestre.
                    </div>
                <?php else: ?>
                    <div class="divide-y divide-slate-100">
                        <?php foreach ($sem['ues'] as $ue): ?>
                            <div class="p-4 hover:bg-slate-50 transition-colors">
                                <div class="flex justify-between items-start mb-2">
                                    <div>
                                        <span class="font-mono text-[10px] text-primary font-bold px-1.5 py-0.5 bg-primary/10 rounded mr-1"><?= $ue['code_ue'] ?></span>
                                        <span class="font-bold text-sm text-slate-700"><?= htmlspecialchars($ue['libelle_ue']) ?></span>
                                    </div>
                                    <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-2 py-0.5 rounded-full border border-slate-200">
                                        <?= $ue['credits_ects'] ?> ECTS
                                    </span>
                                </div>
                                <div class="ml-2 pl-3 border-l-2 border-slate-200 space-y-1.5 mt-2">
                                    <?php foreach ($ue['notes'] as $note): ?>
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="text-slate-500 truncate mr-3" title="<?= htmlspecialchars($note['ec']) ?>">
                                                • <?= htmlspecialchars($note['ec']) ?>
                                            </span>
                                            <div class="flex items-center gap-2 flex-shrink-0">
                                                <span class="italic text-[10px] text-slate-400"><?= $note['session'] ?></span>
                                                <strong class="w-10 text-right <?= $note['note'] >= 10 ? 'text-green-600' : 'text-red-500' ?>">
                                                    <?= number_format($note['note'], 2, ',', ' ') ?>
                                                </strong>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <!-- Boutons de document par semestre -->
            <div class="px-4 py-3 bg-surface-container-lowest border-t border-outline-variant/10 flex justify-end gap-2">
                <a href="<?= $base_url . $backend_url ?>relev_backend.php?id=<?= $etudiant['id_etudiant'] ?>&semestre=<?= $sem['semestre'] ?>" class="text-[11px] font-bold text-primary hover:text-primary-container px-3 py-1.5 rounded bg-primary/5 hover:bg-primary/10 transition-colors flex items-center gap-1">
                    <span class="material-symbols-outlined text-sm">receipt_long</span> Relevé
                </a>
                <a href="<?= $base_url . $backend_url ?>attestation_backend.php?id=<?= $etudiant['id_etudiant'] ?>&semestre=<?= $sem['semestre'] ?>" class="text-[11px] font-bold text-secondary hover:text-secondary-container px-3 py-1.5 rounded bg-secondary/5 hover:bg-secondary/10 transition-colors flex items-center gap-1 <?= $sem['statut'] != 'Admis' ? 'opacity-50 pointer-events-none' : '' ?>">
                    <span class="material-symbols-outlined text-sm">workspace_premium</span> Attestation
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<!-- Styles pour impression -->
<style type="text/css">
@media print {
    aside, header, nav, button, a {
        display: none !important;
    }
    main {
        margin: 0 !important;
        padding: 0 !important;
        width: 100% !important;
    }
    .shadow-sm, .shadow-md, .shadow-lg {
        box-shadow: none !important;
        border: 1px solid #e2e8f0 !important;
    }
    body {
        background-color: white !important;
    }
    .max-h-80 {
        max-height: none !important;
    }
}
</style>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
