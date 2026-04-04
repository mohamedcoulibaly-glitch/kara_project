<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/saisie_notes_par_ec_backend.php';
// Variables from backend: $filieres, $id_filiere, $id_ue, $id_ec, $session, $date_examen, $unites, $elements, $etudiants, $message, $type_message
$page_title = 'Saisie des Notes par EC';
$current_page = 'notes';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Saisie Détaillée des Notes</h1>
    <p class="text-slate-500 mt-2">Gestion des notes par Élément Constitutif (EC). Sélectionnez la session et la date de l'examen.</p>
</div>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-lg <?= $type_message === 'success' ? 'bg-green-50 text-green-800 border-l-4 border-green-500' : 'bg-red-50 text-red-800 border-l-4 border-red-500' ?> shadow-sm">
        <?= $message ?>
    </div>
<?php endif; ?>

<!-- Step 1: Selection Filters -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-8 shadow-sm">
    <form method="GET" action="" id="ec-notes-filter-form" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
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
            <div>
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
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Élément Constitutif (EC)</label>
                <select name="ec" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('ec-notes-filter-form').submit();">
                    <option value="0">Sélectionner une EC...</option>
                    <?php foreach ($elements as $e): ?>
                        <option value="<?= $e['id_ec'] ?>" <?= ($e['id_ec'] == $id_ec) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($e['code_ec'] . ' - ' . $e['nom_ec']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-4 border-t border-slate-100">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Type de Session</label>
                <div class="flex gap-2">
                    <label class="flex-1 flex items-center justify-center gap-2 py-2 border rounded-lg cursor-pointer transition-all <?= $session === 'Normale' ? 'bg-primary/10 border-primary text-primary font-bold' : 'bg-slate-50 border-slate-200 text-slate-400 font-medium' ?>">
                        <input type="radio" name="session" value="Normale" class="hidden" <?= $session === 'Normale' ? 'checked' : '' ?> onchange="document.getElementById('ec-notes-filter-form').submit();"> Normale
                    </label>
                    <label class="flex-1 flex items-center justify-center gap-2 py-2 border rounded-lg cursor-pointer transition-all <?= $session === 'Rattrapage' ? 'bg-amber-50 border-amber-500 text-amber-700 font-bold' : 'bg-slate-50 border-slate-200 text-slate-400 font-medium' ?>">
                        <input type="radio" name="session" value="Rattrapage" class="hidden" <?= $session === 'Rattrapage' ? 'checked' : '' ?> onchange="document.getElementById('ec-notes-filter-form').submit();"> Rattrapage
                    </label>
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Date de l'Examen</label>
                <input name="date_examen" type="date" value="<?= $date_examen ?>" class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700" onchange="document.getElementById('ec-notes-filter-form').submit();"/>
            </div>
        </div>
    </form>
</div>

<!-- Step 2: Saisie Tabulaire -->
<?php if ($id_filiere && $id_ue && $id_ec): ?>
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="font-bold text-slate-800">Grille de saisie - <?= $session ?></h3>
            <span class="text-xs font-bold text-primary bg-primary/10 px-2 py-1 rounded">Date: <?= date('d/m/Y', strtotime($date_examen)) ?></span>
        </div>
        
        <form method="POST" action="<?= $base_url . $backend_url ?>saisie_notes_par_ec_backend.php?filiere=<?= $id_filiere ?>&ue=<?= $id_ue ?>&ec=<?= $id_ec ?>&session=<?= $session ?>&date_examen=<?= $date_examen ?>">
            <input type="hidden" name="action" value="save_notes_ec">
            <input type="hidden" name="id_ec" value="<?= $id_ec ?>">
            <input type="hidden" name="session" value="<?= $session ?>">
            <input type="hidden" name="date_examen" value="<?= $date_examen ?>">
            
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 text-xs font-bold text-slate-500 uppercase border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4">Étudiant</th>
                        <th class="px-6 py-4 text-center">Matricule</th>
                        <th class="px-6 py-4 text-right w-40">Note (/20)</th>
                        <th class="px-6 py-4 text-right w-64">Observations</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($etudiants)): ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 italic">Aucun étudiant éligible trouvé pour ces paramètres.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($etudiants as $et): ?>
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-slate-800"><?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?></div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span class="text-xs font-mono bg-slate-50 text-slate-500 px-2 py-1 rounded"><?= htmlspecialchars($et['matricule']) ?></span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <?php 
                                        $valeur = isset($notes_saisies[$et['id_etudiant']]) ? $notes_saisies[$et['id_etudiant']]['valeur_note'] : '';
                                    ?>
                                    <input type="number" step="0.01" min="0" max="20" 
                                           name="notes[<?= $et['id_etudiant'] ?>][valeur_note]" 
                                           value="<?= $valeur ?>"
                                           placeholder="0.00"
                                           class="w-24 text-right bg-slate-50 border-none rounded py-2 text-sm focus:ring-2 focus:ring-primary font-black text-primary">
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <input type="text" name="notes[<?= $et['id_etudiant'] ?>][observation]" 
                                           value="<?= isset($et['observation']) ? htmlspecialchars($et['observation']) : '' ?>"
                                           placeholder="Observation..."
                                           class="w-full text-xs italic bg-transparent border-none text-slate-400 focus:ring-0">
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="px-6 py-8 bg-slate-50 border-t border-slate-100 flex justify-end gap-3">
                <button type="submit" class="bg-primary text-white px-12 py-3.5 rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-95 active:scale-[0.98] transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save</span> ENREGISTRER LES RÉSULTATS
                </button>
            </div>
        </form>
    </div>
<?php else: ?>
    <div class="text-center py-32 bg-white rounded-xl border border-dashed border-slate-300">
        <span class="material-symbols-outlined text-6xl text-slate-200 mb-6 block">edit_document</span>
        <h3 class="text-lg font-bold text-slate-700">Sélection du module cible</h3>
        <p class="text-slate-500 mt-2">Veuillez sélectionner les critères ci-dessus pour lancer la saisie des notes.</p>
    </div>
<?php endif; ?>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
