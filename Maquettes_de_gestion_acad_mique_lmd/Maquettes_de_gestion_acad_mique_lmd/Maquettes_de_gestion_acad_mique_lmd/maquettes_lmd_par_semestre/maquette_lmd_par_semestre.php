<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/maquette_lmd_backend.php';
// Variables from backend: $filieres, $id_filiere, $maquette_groupee, $filiere_courante, $page_title, $current_page
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
            <span>Maquettes</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary font-bold">Par Semestre</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Maquette Pédagogique</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Consultez l'organisation détaillée des Unités d'Enseignement et des Crédits ECTS pour chaque semestre.</p>
    </div>
    <div class="flex gap-3">
        <button onclick="downloadMaquettePDF()" class="bg-white border text-slate-700 px-5 py-2.5 rounded-lg shadow-sm font-bold text-sm flex items-center gap-2 hover:bg-slate-50 transition-colors">
            <span class="material-symbols-outlined text-[18px]">download_for_offline</span> Télécharger PDF
        </button>
    </div>
</div>

<!-- Filters Section -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-8 shadow-sm">
    <form method="GET" action="<?= $base_url . $backend_url ?>maquette_lmd_backend.php" id="maquette-filter-form" class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Choisir une filière</label>
            <select name="filiere" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('maquette-filter-form').submit();">
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($f['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-48">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Semestre</label>
            <select name="semestre" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('maquette-filter-form').submit();">
                <?php for ($i=1; $i<=6; $i++): ?>
                    <option value="<?= $i ?>" <?= ($i == $semestre) ? 'selected' : '' ?>>Semestre <?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </form>
</div>

<!-- Maquette Data -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50 border-b border-slate-100">
            <tr>
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">UE / Éléments Constitutifs</th>
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">Code</th>
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">Crédits ECTS</th>
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">Coeff</th>
                <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-center">V.H. Total</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (empty($maquette)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-24 text-center">
                        <span class="material-symbols-outlined text-5xl text-slate-200 mb-4 block">receipt_long</span>
                        <p class="text-slate-400 italic">Aucune donnée de maquette disponible pour ce semestre.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php 
                $total_ects = 0;
                $total_vh = 0;
                foreach ($maquette as $ue): 
                    $total_ects += $ue['credits_ects'];
                    $total_vh += $ue['volume_horaire'] ?? 0;
                ?>
                    <tr class="bg-slate-50/30">
                        <td class="px-6 py-4 font-bold text-slate-800 text-sm"><?= htmlspecialchars($ue['libelle_ue']) ?></td>
                        <td class="px-6 py-4 text-center font-mono text-xs text-primary font-bold"><?= htmlspecialchars($ue['code_ue']) ?></td>
                        <td class="px-6 py-4 text-center">
                            <span class="bg-primary/10 text-primary px-2 py-1 rounded text-xs font-black"><?= $ue['credits_ects'] ?></span>
                        </td>
                        <td class="px-6 py-4 text-center font-bold text-slate-400"><?= number_format($ue['coefficient'] ?? 0, 1) ?></td>
                        <td class="px-6 py-4 text-center font-bold text-slate-600"><?= $ue['volume_horaire'] ?? 0 ?>h</td>
                    </tr>
                    <?php if (!empty($ue['ecs'])): ?>
                        <?php foreach ($ue['ecs'] as $ec): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-3 pl-12 flex items-center gap-2">
                                    <span class="material-symbols-outlined text-[14px] text-slate-300">subdirectory_arrow_right</span>
                                    <span class="text-xs text-slate-600 font-medium"><?= htmlspecialchars($ec['nom_ec']) ?></span>
                                </td>
                                <td class="px-6 py-3 text-center font-mono text-[10px] text-slate-400"><?= htmlspecialchars($ec['code_ec']) ?></td>
                                <td class="px-6 py-3 text-center text-[10px] text-slate-400">-</td>
                                <td class="px-6 py-3 text-center text-xs font-bold text-slate-500"><?= number_format($ec['coefficient'], 1) ?></td>
                                <td class="px-6 py-3 text-center text-xs text-slate-400"><?= $ec['volume_horaire'] ?? 0 ?>h</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
                <!-- Footer Summary -->
                <tr class="bg-slate-800 text-white font-bold">
                    <td class="px-6 py-4 text-xs uppercase tracking-widest">TOTAL SEMESTRE <?= $semestre ?></td>
                    <td class="px-6 py-4"></td>
                    <td class="px-6 py-4 text-center text-lg text-amber-400"><?= $total_ects ?> ECTS</td>
                    <td class="px-6 py-4"></td>
                    <td class="px-6 py-4 text-center"><?= $total_vh ?>h</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
