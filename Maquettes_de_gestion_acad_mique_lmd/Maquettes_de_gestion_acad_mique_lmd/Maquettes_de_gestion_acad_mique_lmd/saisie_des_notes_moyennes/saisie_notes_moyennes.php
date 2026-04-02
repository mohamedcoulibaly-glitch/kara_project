<?php
$page_title = 'Saisie des Notes (Moyennes)';
$current_page = 'notes';
include __DIR__ . '/../../../../backend/includes/sidebar.php';

// Variables from backend
$filieres = $filieres ?? [];
$id_filiere = $id_filiere ?? 0;
$id_ue = $id_ue ?? 0;
$id_ec = $id_ec ?? 0;
$unites = $unites ?? [];
$elements = $elements ?? [];
$etudiants = $etudiants ?? [];
$message = $message ?? '';
$type_message = $type_message ?? '';
?>

<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Saisie des Notes Académiques</h1>
    <p class="text-slate-500 mt-2">Enregistrez les résultats par EC pour le calcul des moyennes d'UE et de semestre.</p>
</div>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-lg <?= $type_message === 'success' ? 'bg-green-50 text-green-800 border-l-4 border-green-500' : 'bg-red-50 text-red-800 border-l-4 border-red-500' ?> shadow-sm">
        <?= $message ?>
    </div>
<?php endif; ?>

<!-- Step 1: Selection Filters -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-8 shadow-sm">
    <form method="GET" action="" id="notes-filter-form" class="flex flex-col md:flex-row gap-6">
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Filière</label>
            <select name="filiere" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="window.location.href='?filiere='+this.value">
                <option value="0">Sélectionner une filière</option>
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($f['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Unité d'Enseignement (UE)</label>
            <select name="ue" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="window.location.href='?filiere=<?= $id_filiere ?>&ue='+this.value">
                <option value="0">Sélectionner une UE...</option>
                <?php foreach ($unites as $u): ?>
                    <option value="<?= $u['id_ue'] ?>" <?= ($u['id_ue'] == $id_ue) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u['code_ue'] . ' - ' . $u['libelle_ue']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Élément Constitutif (EC)</label>
            <select name="ec" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('notes-filter-form').submit();">
                <option value="0">Toutes les EC de l'UE</option>
                <?php foreach ($elements as $e): ?>
                    <option value="<?= $e['id_ec'] ?>" <?= ($e['id_ec'] == $id_ec) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($e['code_ec'] . ' - ' . $e['nom_ec']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>

<!-- Step 2: Saisie Tabulaire -->
<?php if ($id_filiere && $id_ue && $id_ec): ?>
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Saisie des notes - Session Normale</h3>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-slate-400">SESSION :</span>
                <select id="session-selector" class="text-xs bg-white border border-slate-200 rounded px-2 py-1 font-bold">
                    <option value="Normale">Normale</option>
                    <option value="Rattrapage">Rattrapage</option>
                </select>
            </div>
        </div>
        
        <form method="POST" action="<?= $base_url . $backend_url ?>saisie_notes_moyennes_backend.php?filiere=<?= $id_filiere ?>&ue=<?= $id_ue ?>&ec=<?= $id_ec ?>">
            <input type="hidden" name="action" value="save_notes">
            <input type="hidden" name="id_ec" value="<?= $id_ec ?>">
            <input type="hidden" name="session" value="Normale" id="session-input">
            
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-xs font-bold text-slate-500 uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Étudiant</th>
                        <th class="px-6 py-4">Matricule</th>
                        <th class="px-6 py-4 text-center w-40">Note Moyenne (/20)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($etudiants)): ?>
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-slate-400 italic">Aucun étudiant inscrit dans cette filière.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($etudiants as $et): ?>
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-800"><?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?></div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs font-mono bg-slate-50 text-slate-500 px-2 py-1 rounded"><?= htmlspecialchars($et['matricule']) ?></span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <input type="number" step="0.01" min="0" max="20" 
                                           name="notes[<?= $et['id_etudiant'] ?>]" 
                                           value="<?= isset($et['note_actuelle']) ? $et['note_actuelle'] : '' ?>"
                                           placeholder="0.00"
                                           class="w-24 text-center bg-slate-50 border-none rounded py-2 text-sm focus:ring-2 focus:ring-primary font-black text-primary">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="px-6 py-8 bg-slate-50 border-t border-slate-100 flex justify-end">
                <button type="submit" class="bg-primary text-white px-12 py-3.5 rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-95 active:scale-[0.98] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span> ENREGISTRER LES NOTES
                </button>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="text-center py-32 bg-white rounded-xl border border-dashed border-slate-300">
        <span class="material-symbols-outlined text-6xl text-slate-200 mb-6 block">edit_note</span>
        <h3 class="text-lg font-bold text-slate-700">Sélection de l'EC cible</h3>
        <p class="text-slate-500 mt-2">Veuillez sélectionner successivement la Filière, l'UE puis l'EC pour accéder à la grille de saisie.</p>
    </div>
<?php endif; ?>

<script>
document.getElementById('session-selector')?.addEventListener('change', function() {
    document.getElementById('session-input').value = this.value;
});
</script>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
