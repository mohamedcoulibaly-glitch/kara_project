<?php
$page_title = 'Configuration des Coefficients';
$current_page = 'configuration';
include __DIR__ . '/../../../../backend/includes/sidebar.php';

// Variables from backend
$departements = $departements ?? [];
$filieres = $filieres ?? [];
$id_dept = $id_dept ?? 0;
$id_filiere = $id_filiere ?? 0;
$unites = $unites ?? [];
$message = $message ?? '';
?>

<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Paramétrage des Coefficients</h1>
    <p class="text-slate-500 mt-2">Définissez les coefficients et crédits ECTS par filière pour le calcul automatique des moyennes.</p>
</div>

<!-- Filters Section -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-8 shadow-sm">
    <form method="GET" action="<?= $base_url . $backend_url ?>configuration_coefficients_backend.php" id="config-filter-form" class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Département</label>
            <select name="id_dept" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('config-filter-form').submit();">
                <?php foreach ($departements as $dept): ?>
                    <option value="<?= $dept['id_dept'] ?>" <?= ($dept['id_dept'] == $id_dept) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept['nom_dept']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Filière</label>
            <select name="id_filiere" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('config-filter-form').submit();">
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($f['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>

<!-- Main Config Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <form method="POST" action="<?= $base_url . $backend_url ?>configuration_coefficients_backend.php">
        <input type="hidden" name="action" value="update_coefficients">
        <input type="hidden" name="id_filiere" value="<?= $id_filiere ?>">
        <input type="hidden" name="id_dept" value="<?= $id_dept ?>">
        
        <table class="w-full text-left">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Unité d'Enseignement (UE)</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">Crédits (Défaut)</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center w-32">Crédits (Config)</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center w-32">Coefficient</th>
                    <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center w-32">Vol. Horaire</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if (empty($unites)): ?>
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Aucune UE trouvée pour cette sélection.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($unites as $ue): ?>
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-6 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-bold text-slate-800"><?= htmlspecialchars($ue['code_ue']) ?> - <?= htmlspecialchars($ue['libelle_ue']) ?></span>
                                    <span class="text-[10px] text-slate-400 mt-0.5"><?= htmlspecialchars($ue['elements'] ?: 'Aucun EC') ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-slate-100 text-slate-600 px-2 py-1 rounded text-xs font-bold"><?= $ue['credits_ects'] ?></span>
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="credits_ects[<?= $ue['id_ue'] ?>]" value="<?= $ue['config_credits'] ?: $ue['credits_ects'] ?>" 
                                       class="w-full text-center bg-slate-50 border-none rounded py-1.5 text-sm focus:ring-2 focus:ring-primary font-bold text-primary">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" step="0.1" name="coefficients[<?= $ue['id_ue'] ?>]" value="<?= $ue['config_coeff'] ?: $ue['coefficient'] ?>" 
                                       class="w-full text-center bg-slate-50 border-none rounded py-1.5 text-sm focus:ring-2 focus:ring-primary font-bold text-primary">
                            </td>
                            <td class="px-4 py-2">
                                <input type="number" name="volume_horaire[<?= $ue['id_ue'] ?>]" value="<?= $ue['volume_horaire_total'] ?: $ue['volume_horaire'] ?>" 
                                       class="w-full text-center bg-slate-50 border-none rounded py-1.5 text-sm focus:ring-2 focus:ring-primary font-bold text-slate-600">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="px-6 py-6 bg-slate-50 border-t border-slate-100 flex justify-end">
            <button type="submit" class="bg-primary text-white px-10 py-3 rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-95 active:scale-[0.98] transition-all">
                ENREGISTRER LA CONFIGURATION
            </button>
        </div>
    </form>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
