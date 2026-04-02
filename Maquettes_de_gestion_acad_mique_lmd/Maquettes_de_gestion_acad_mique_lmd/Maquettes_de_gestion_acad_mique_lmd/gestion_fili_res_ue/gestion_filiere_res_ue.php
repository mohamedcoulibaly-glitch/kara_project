<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/gestion_filieres_ue_backend.php';
// Variables extracted from backend: $filieres, $id_filiere, $maquette_par_semestre, $stats, $message, $page_title, $current_page
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Header -->
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
            <span>Gestion</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary font-bold">Filières & UE</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Gestion des Filières et UE</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Organisez la structure de votre offre de formation. Associez les Unités d'Enseignement aux filières.</p>
    </div>
</div>

<?php if ($message): ?>
    <div class="mb-6"><?= $message ?></div>
<?php endif; ?>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-primary/10 flex items-center justify-center text-primary">
            <span class="material-symbols-outlined text-2xl">book</span>
        </div>
        <div>
            <p class="text-3xl font-bold text-primary"><?= $stats['nb_ues'] ?? 0 ?></p>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Unités d'Enseignement</p>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-secondary/10 flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined text-2xl">menu_book</span>
        </div>
        <div>
            <p class="text-3xl font-bold text-secondary"><?= $stats['nb_ecs'] ?? 0 ?></p>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Éléments Constitutifs</p>
        </div>
    </div>
    <div class="bg-surface-container-lowest p-6 rounded-xl border border-outline-variant/10 shadow-sm flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-tertiary/10 flex items-center justify-center text-tertiary">
            <span class="material-symbols-outlined text-2xl">stars</span>
        </div>
        <div>
            <p class="text-3xl font-bold text-tertiary"><?= $stats['total_credits'] ?? 0 ?></p>
            <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Total Crédits ECTS</p>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-8 flex items-center justify-between">
    <div class="flex-1 max-w-sm">
        <form method="GET" action="<?= $base_url . $backend_url ?>gestion_filieres_ue_backend.php" id="filiere-form">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Sélectionnez une filière</label>
            <select name="id" class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('filiere-form').submit();">
                <?php foreach ($filieres as $filiere): ?>
                    <option value="<?= $filiere['id_filiere'] ?>" <?= ($filiere['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($filiere['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>
    <a href="<?= $base_url . $backend_url ?>saisie_ue_ec_backend.php" class="bg-primary text-white px-5 py-2.5 rounded-lg font-bold text-sm shadow-sm hover:shadow-md hover:scale-[1.02] transition-all flex items-center gap-2">
        <span class="material-symbols-outlined text-[20px]">add</span>
        Nouvelle UE/EC
    </a>
</div>

<!-- Maquette Affichage -->
<?php if (empty($maquette_par_semestre)): ?>
    <div class="text-center py-16 bg-white rounded-xl border border-outline-variant/20 shadow-sm">
        <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 block">account_tree</span>
        <h3 class="text-lg font-bold text-slate-700 mb-1">Aucune UE associée</h3>
        <p class="text-slate-500">Cette filière ne possède pas encore de structure d'enseignement associée.</p>
        <a href="<?= $base_url . $backend_url ?>saisie_ue_ec_backend.php" class="inline-flex items-center gap-2 mt-4 text-primary font-semibold hover:underline">
            Créer une structure <span class="material-symbols-outlined text-sm">arrow_forward</span>
        </a>
    </div>
<?php else: ?>
    <div class="space-y-6">
        <?php foreach ($maquette_par_semestre as $semestre => $ues): ?>
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 overflow-hidden">
                <div class="bg-surface-container-low px-6 py-4 border-b border-outline-variant/20 flex items-center justify-between">
                    <h3 class="font-bold text-slate-800 flex items-center gap-2">
                        <span class="bg-primary text-white w-6 h-6 rounded text-xs flex items-center justify-center">S<?= $semestre ?></span>
                        Semestre <?= $semestre ?>
                    </h3>
                </div>
                <div class="p-0">
                    <table class="w-full text-left">
                        <thead class="text-xs font-bold uppercase text-slate-500 bg-slate-50">
                            <tr>
                                <th class="py-3 px-6">Code & Libellé de l'UE</th>
                                <th class="py-3 px-6 text-center">Crédits</th>
                                <th class="py-3 px-6 text-center">Coef.</th>
                                <th class="py-3 px-6">Éléments Constitutifs (EC)</th>
                                <th class="py-3 px-6 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <?php foreach ($ues as $ue): ?>
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-mono text-xs text-primary font-bold mb-1"><?= htmlspecialchars($ue['code_ue']) ?></div>
                                        <div class="font-medium text-slate-800 text-sm"><?= htmlspecialchars($ue['libelle_ue']) ?></div>
                                    </td>
                                    <td class="py-4 px-6 text-center">
                                        <span class="bg-green-100 text-green-800 font-bold px-2 py-1 rounded text-xs inline-block min-w-[30px]"><?= $ue['credits_ects'] ?></span>
                                    </td>
                                    <td class="py-4 px-6 text-center font-bold text-slate-600 text-sm">
                                        <?= $ue['coefficient_ue'] ?? $ue['coefficient'] ?? '-' ?>
                                    </td>
                                    <td class="py-4 px-6">
                                        <?php if ($ue['elements']): ?>
                                            <div class="text-xs text-slate-600 whitespace-pre-wrap leading-relaxed max-w-sm"><?= htmlspecialchars(str_replace(',', "\n• ", "• ".$ue['elements'])) ?></div>
                                        <?php else: ?>
                                            <span class="text-xs text-slate-400 italic">Aucun EC défini</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="py-4 px-6 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <button data-modal-target="edit-ue-modal-<?= $ue['id_ue'] ?>" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-primary hover:text-white transition-colors" title="Modifier">
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                            </button>
                                            <form method="POST" action="<?= $base_url . $backend_url ?>gestion_filieres_ue_backend.php?id=<?= $id_filiere ?>" class="inline btn-delete-confirm">
                                                <input type="hidden" name="action" value="delete_ue">
                                                <input type="hidden" name="id_ue" value="<?= $ue['id_ue'] ?>">
                                                <button type="submit" class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-error hover:text-white transition-colors" title="Supprimer de la filière">
                                                    <span class="material-symbols-outlined text-[18px]">delete_sweep</span>
                                                </button>
                                            </form>
                                        </div>

                                        <!-- MODAL DYNAMIQUE: Editer UE -->
                                        <div id="edit-ue-modal-<?= $ue['id_ue'] ?>" class="modal-container fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4 text-left">
                                            <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in duration-300">
                                                <div class="p-6 bg-primary text-white flex justify-between items-center">
                                                    <h4 class="text-sm font-black tracking-tight uppercase">Modifier Unité: <?= $ue['code_ue'] ?></h4>
                                                    <button type="button" data-modal-close class="hover:bg-white/10 p-1 rounded-full"><span class="material-symbols-outlined">close</span></button>
                                                </div>
                                                <form method="POST" action="<?= $base_url . $backend_url ?>gestion_filieres_ue_backend.php?id=<?= $id_filiere ?>" class="p-8 space-y-6">
                                                    <input type="hidden" name="action" value="update_ue">
                                                    <input type="hidden" name="id_ue" value="<?= $ue['id_ue'] ?>">
                                                    <div class="grid grid-cols-2 gap-4">
                                                        <div class="col-span-2">
                                                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Libellé de l'UE</label>
                                                            <input name="libelle_ue" value="<?= htmlspecialchars($ue['libelle_ue']) ?>" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" type="text"/>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Crédits ECTS</label>
                                                            <input name="credits_ects" value="<?= $ue['credits_ects'] ?>" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" type="number"/>
                                                        </div>
                                                        <div>
                                                            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Coefficient</label>
                                                            <input name="coefficient" value="<?= $ue['coefficient_ue'] ?? $ue['coefficient'] ?? 1 ?>" required step="0.1" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" type="number"/>
                                                        </div>
                                                    </div>
                                                    <div class="pt-4 flex justify-end">
                                                        <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg hover:opacity-90 active:scale-95 transition-all">Sauvegarder</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
