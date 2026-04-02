<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/proces_verbal_backend.php';
// Variables from backend: $filieres, $id_filiere, $semestre, $deliberations_list, $message, $page_title, $current_page
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
            <span>Délibérations</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary font-bold">Procès-Verbaux</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Registre des PV</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Accédez à l'historique des procès-verbaux officiels et téléchargez les versions PDF certifiées.</p>
    </div>
</div>

<!-- Filters Section -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-8 shadow-sm">
    <form method="GET" action="<?= $base_url . $backend_url ?>proces_verbal_backend.php" id="pv-filter-form" class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Filière</label>
            <select name="filiere" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('pv-filter-form').submit();">
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($f['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-48">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Semestre</label>
            <select name="semestre" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('pv-filter-form').submit();">
                <?php for ($i=1; $i<=6; $i++): ?>
                    <option value="<?= $i ?>" <?= ($i == $semestre) ? 'selected' : '' ?>>Semestre <?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
    </form>
</div>

<!-- PV List -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left">
        <thead class="bg-slate-50/50 text-xs font-bold text-slate-500 uppercase">
            <tr>
                <th class="px-6 py-4">ID Délibération</th>
                <th class="px-6 py-4">Étudiant</th>
                <th class="px-6 py-4 text-center">Date Délibération</th>
                <th class="px-6 py-4 text-center">Résultat</th>
                <th class="px-6 py-4 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (empty($deliberations_list)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-24 text-center">
                        <span class="material-symbols-outlined text-5xl text-slate-200 mb-4 block">history_edu</span>
                        <p class="text-slate-400 italic">Aucune délibération trouvée pour cette sélection.</p>
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($deliberations_list as $delib): ?>
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="text-xs font-bold font-mono text-primary bg-primary/5 px-2 py-1 rounded">DELIB-<?= $delib['id_deliberation'] ?></span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-col">
                                <span class="text-sm font-bold text-slate-800"><?= htmlspecialchars($delib['nom'] . ' ' . $delib['prenom']) ?></span>
                                <span class="text-[10px] text-slate-400 font-mono"><?= htmlspecialchars($delib['matricule']) ?></span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center text-sm text-slate-500">
                            <?= date('d/m/Y', strtotime($delib['date_deliberation'])) ?>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest <?= $delib['statut'] === 'Admis' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                                <?= htmlspecialchars($delib['statut']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="<?= $base_url . $backend_url ?>proces_verbal_backend.php?id=<?= $delib['id_deliberation'] ?>" class="p-2 text-primary hover:bg-primary/5 rounded transition-colors group" title="Générer PV">
                                    <span class="material-symbols-outlined text-xl">description</span>
                                </a>
                                <button class="p-2 text-slate-300 hover:text-slate-600 rounded transition-colors">
                                    <span class="material-symbols-outlined text-xl">print</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
