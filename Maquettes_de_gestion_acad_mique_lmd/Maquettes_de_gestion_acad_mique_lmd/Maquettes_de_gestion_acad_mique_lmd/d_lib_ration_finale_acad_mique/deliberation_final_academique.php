<?php
$page_title = 'Délibération Finale Académique';
$current_page = 'deliberations';
include __DIR__ . '/../../../../backend/includes/sidebar.php';

// Variables from backend
$id_filiere = $id_filiere ?? 0;
$semestre = $semestre ?? 1;
$filieres = $filieres ?? [];
$etudiants_stats = $etudiants_stats ?? [];
$message = $message ?? '';
?>

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
            <span>Gestion</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary font-bold">Délibérations</span>
        </nav>
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Délibération Académique</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Analysez les résultats de la session et validez les passages de niveau ou les décisions de redoublement.</p>
    </div>
    <div class="flex gap-3">
        <button class="bg-white border text-slate-700 px-5 py-2.5 rounded-lg shadow-sm font-bold text-sm flex items-center gap-2 hover:bg-slate-50">
            <span class="material-symbols-outlined text-[18px]">print</span> Imprimer PV Global
        </button>
    </div>
</div>

<!-- Filters Section -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-8 shadow-sm">
    <form method="GET" action="" id="delib-filter-form" class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Filière concernée</label>
            <select name="filiere" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('delib-filter-form').submit();">
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($f['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-48">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Semestre</label>
            <select name="semestre" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('delib-filter-form').submit();">
                <?php for ($i=1; $i<=6; $i++): ?>
                    <option value="<?= $i ?>" <?= ($i == $semestre) ? 'selected' : '' ?>>Semestre <?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="pt-6">
            <button type="submit" class="bg-primary text-white px-6 py-2.5 rounded-lg flex items-center gap-2 font-bold text-sm shadow-sm transition-transform active:scale-95">
                <span class="material-symbols-outlined text-[18px]">sync</span> Calculer les résultats
            </button>
        </div>
    </form>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center">
            <span class="material-symbols-outlined">group</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Effectif</p>
            <p class="text-xl font-black text-slate-800"><?= count($etudiants_stats) ?></p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-green-50 text-green-600 flex items-center justify-center">
            <span class="material-symbols-outlined">check_circle</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Admis</p>
            <p class="text-xl font-black text-green-600">
                <?php 
                $admis = array_filter($etudiants_stats, fn($e) => $e['moyenne_semestre'] >= 10);
                echo count($admis);
                ?>
            </p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center">
            <span class="material-symbols-outlined">cancel</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Ajournés</p>
            <p class="text-xl font-black text-red-600"><?= count($etudiants_stats) - count($admis) ?></p>
        </div>
    </div>
    <div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center gap-4">
        <div class="h-12 w-12 rounded-full bg-amber-50 text-amber-600 flex items-center justify-center">
            <span class="material-symbols-outlined">analytics</span>
        </div>
        <div>
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Taux</p>
            <p class="text-xl font-black text-amber-600">
                <?= count($etudiants_stats) > 0 ? round((count($admis) / count($etudiants_stats)) * 100) : 0 ?>%
            </p>
        </div>
    </div>
</div>

<!-- Results Table -->
<div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
        <h3 class="font-bold text-slate-800">Registre de délibération</h3>
        <button class="bg-primary text-white px-4 py-2 rounded-lg text-xs font-bold shadow-sm hover:opacity-90">Valider toutes les décisions</button>
    </div>
    <table class="w-full text-left">
        <thead class="bg-slate-50/50 text-xs font-bold text-slate-500 uppercase">
            <tr>
                <th class="px-6 py-4">Étudiant</th>
                <th class="px-6 py-4 text-center">Matricule</th>
                <th class="px-6 py-4 text-center">Moyenne</th>
                <th class="px-6 py-4 text-center">Crédits capitalisés</th>
                <th class="px-6 py-4 text-right">Décision Jury</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            <?php if (empty($etudiants_stats)): ?>
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-400 italic">Veuillez calculer les résultats pour cette filière.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($etudiants_stats as $et): ?>
                    <tr class="hover:bg-slate-50/50">
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-800"><?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?></div>
                        </td>
                        <td class="px-6 py-4 text-center font-mono text-xs text-slate-500"><?= htmlspecialchars($et['matricule']) ?></td>
                        <td class="px-6 py-4 text-center">
                            <span class="font-black text-sm <?= $et['moyenne_semestre'] >= 10 ? 'text-green-600' : 'text-red-600' ?>">
                                <?= number_format($et['moyenne_semestre'], 2, ',', ' ') ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-2 py-0.5 rounded">
                                <?= $et['ues_validees'] ?> / <?= $et['ues_tentees'] ?> UE
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <form method="POST" action="<?= $base_url . $backend_url ?>deliberation_backend.php?filiere=<?= $id_filiere ?>&semestre=<?= $semestre ?>">
                                <input type="hidden" name="action" value="save_deliberation">
                                <input type="hidden" name="id_etudiant" value="<?= $et['id_etudiant'] ?>">
                                <input type="hidden" name="moyenne_semestre" value="<?= $et['moyenne_semestre'] ?>">
                                <input type="hidden" name="code_deliberation" value="DEL-<?= $semestre ?>-<?= $id_filiere ?>-<?= date('Y') ?>">
                                
                                <select name="statut" class="text-[11px] font-bold border-none bg-slate-100 rounded px-3 py-1.5 focus:ring-1 focus:ring-primary appearance-none cursor-pointer">
                                    <option value="Admis" <?= $et['moyenne_semestre'] >= 12 ? 'selected' : '' ?>>Admis</option>
                                    <option value="Admis avec dettes" <?= ($et['moyenne_semestre'] >= 10 && $et['moyenne_semestre'] < 12) ? 'selected' : '' ?>>Admis dettes</option>
                                    <option value="Non Admis" <?= $et['moyenne_semestre'] < 10 ? 'selected' : '' ?>>Non Admis</option>
                                    <option value="Redoublant">Redoublant</option>
                                    <option value="Exclu">Exclu</option>
                                </select>
                                <button type="submit" class="material-symbols-outlined text-primary hover:text-primary-container text-[18px] ml-2">save</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
