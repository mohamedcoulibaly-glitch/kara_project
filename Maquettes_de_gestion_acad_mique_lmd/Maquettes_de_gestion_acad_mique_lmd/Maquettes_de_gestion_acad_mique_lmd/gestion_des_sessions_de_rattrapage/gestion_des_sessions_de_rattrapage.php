<?php
define('FRONTEND_LOADED', true);
require_once __DIR__ . '/../../../../backend/gestion_sessions_rattrapage_backend.php';
// Variables from backend: $filieres, $id_filiere, $semestre, $etudiants_rattrapage, $sessions, $stats, $message, $type_message
$page_title = 'Gestion des Sessions de Rattrapage';
$current_page = 'rattrapage';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Header -->
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex text-[10px] font-black text-slate-400 mb-2 gap-2 uppercase tracking-widest">
            <span>Gestion</span>
            <span class="material-symbols-outlined text-[12px]">chevron_right</span>
            <span class="text-primary">Sessions de Rattrapage</span>
        </nav>
        <h1 class="text-4xl font-black text-slate-800 tracking-tighter">Sessions de Rattrapage</h1>
        <p class="text-slate-500 mt-2 max-w-xl font-medium">Listez les étudiants ajournés à la session normale et organisez leur repêchage.</p>
    </div>
    <div>
        <button data-modal-target="create-session-modal" class="flex items-center gap-2 px-8 py-3 rounded-xl bg-slate-900 text-white font-black text-sm shadow-xl shadow-slate-200 hover:bg-black active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[20px]">add</span> NOUVELLE SESSION
        </button>
    </div>
</div>

<?php if ($message): ?>
    <script>window.onload = () => showToast("<?= addslashes($message) ?>", "<?= $type_message ?>");</script>
<?php endif; ?>

<!-- Stats Ext. -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-amber-500 bg-amber-50 p-2 rounded-lg" style="font-variation-settings: 'FILL' 1;">priority_high</span>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Étudiants Concernés</span>
        </div>
        <p class="text-3xl font-black text-amber-600 pl-11"><?= $stats['concernés'] ?></p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg" style="font-variation-settings: 'FILL' 1;">auto_stories</span>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">UE à Repasser</span>
        </div>
        <p class="text-3xl font-black text-primary pl-11"><?= $stats['ue_echouees'] ?></p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <span class="material-symbols-outlined text-green-500 bg-green-50 p-2 rounded-lg" style="font-variation-settings: 'FILL' 1;">event_available</span>
            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Sessions Ouvertes</span>
        </div>
        <p class="text-3xl font-black text-green-600 pl-11"><?= count($sessions) ?></p>
    </div>
</div>

<!-- Filters -->
<div class="bg-white p-6 rounded-2xl border border-slate-100 mb-10 shadow-sm">
    <form method="GET" action="" id="rat-filter-form" class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 px-1">Filière</label>
            <select name="filiere" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary font-bold text-slate-700 appearance-none pointer-events-auto" onchange="this.form.submit()">
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($f['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 px-1">Semestre</label>
            <select name="semestre" class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary font-bold text-slate-700 appearance-none" onchange="this.form.submit()">
                <?php for ($i=1; $i<=10; $i++): ?>
                    <option value="<?= $i ?>" <?= ($i == $semestre) ? 'selected' : '' ?>>Semestre <?= $i ?></option>
                <?php endfor; ?>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-slate-100 text-slate-500 font-black text-xs py-4 rounded-xl hover:bg-slate-200 transition-all uppercase tracking-widest">
                Rafraîchir les données
            </button>
        </div>
    </form>
</div>

<!-- Listing Etudiants Ajournés -->
<div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden mb-12">
    <div class="px-8 py-5 border-b border-slate-50 flex justify-between items-center bg-slate-50/50">
        <h3 class="text-sm font-black text-slate-800 uppercase tracking-widest">Candidats au rattrapage</h3>
        <button onclick="window.print()" class="text-[10px] font-black text-primary hover:underline flex items-center gap-1">
            <span class="material-symbols-outlined text-[18px]">print</span> IMPRIMER LA LISTE
        </button>
    </div>
    
    <?php if (empty($etudiants_rattrapage)): ?>
        <div class="text-center py-24">
            <div class="w-20 h-20 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-4xl text-green-500">celebration</span>
            </div>
            <h3 class="text-xl font-black text-slate-800 tracking-tight">Aucun étudiant au rattrapage</h3>
            <p class="text-slate-400 text-sm font-medium mt-2">Félicitations, tous les étudiants de cette sélection ont validé !</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/30">
                        <th class="py-4 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Étudiant concerné</th>
                        <th class="py-4 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">Matricule</th>
                        <th class="py-4 px-8 text-center text-[10px] font-black text-slate-400 uppercase tracking-widest">Moyenne Session 1</th>
                        <th class="py-4 px-8 text-[10px] font-black text-slate-400 uppercase tracking-widest">UE(s) à repasser</th>
                        <th class="py-4 px-8"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    <?php foreach ($etudiants_rattrapage as $et): ?>
                    <tr class="hover:bg-slate-50/50 transition-all group">
                        <td class="py-5 px-8">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-800"><?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?></span>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Candidat éligible</span>
                            </div>
                        </td>
                        <td class="py-5 px-8">
                            <span class="text-xs font-mono font-black text-primary px-2 py-1 bg-primary/5 rounded"><?= htmlspecialchars($et['matricule']) ?></span>
                        </td>
                        <td class="py-5 px-8 text-center">
                            <div class="inline-flex flex-col">
                                <span class="text-base font-black text-red-500"><?= number_format($et['moyenne_semestre'], 2, ',', ' ') ?> / 20</span>
                                <span class="text-[9px] font-bold text-slate-400 uppercase">Non Admis</span>
                            </div>
                        </td>
                        <td class="py-5 px-8">
                            <div class="flex flex-wrap gap-2">
                                <?php foreach ($et['ues_non_validees'] as $ue): ?>
                                    <div class="flex flex-col bg-slate-50 px-3 py-2 rounded-lg border border-slate-100 group-hover:bg-white transition-colors">
                                        <span class="text-[10px] font-black text-slate-800"><?= $ue['code_ue'] ?></span>
                                        <span class="text-[9px] font-bold text-slate-400"><?= number_format($ue['moyenne_ue'], 2) ?>/20</span>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        <td class="py-5 px-8 text-right">
                             <a href="<?= $base_url . $backend_url ?>saisie_notes_par_ec_backend.php?filiere=<?= $id_filiere ?>&session=Rattrapage" class="px-4 py-2 bg-white border border-slate-200 text-primary font-black text-[10px] rounded-xl hover:bg-primary hover:text-white transition-all uppercase tracking-widest shadow-sm">
                                Organiser
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Création Session -->
<div id="create-session-modal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[100] hidden items-center justify-center p-4">
    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
        <div class="px-8 py-6 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
            <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight">Ouvrir une Session</h3>
            <button data-modal-close class="text-slate-400 hover:text-slate-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form method="POST" action="<?= $base_url . $backend_url ?>gestion_sessions_rattrapage_backend.php" class="p-8 space-y-6">
            <input type="hidden" name="action" value="create_session">
            <input type="hidden" name="id_filiere" value="<?= $id_filiere ?>">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Date début</label>
                    <input type="date" name="date_debut" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-sm font-bold text-slate-700">
                </div>
                <div class="space-y-2">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Date fin</label>
                    <input type="date" name="date_fin" required class="w-full bg-slate-50 border-none rounded-xl py-3 px-4 text-sm font-bold text-slate-700">
                </div>
            </div>
            
            <div class="space-y-2">
                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest">Description / Libellé</label>
                <input type="text" name="description" placeholder="Ex: Rattrapage Semestre <?= $semestre ?>" class="w-full bg-slate-50 border-none rounded-xl py-4 px-4 text-sm font-bold text-slate-700 shadow-inner">
            </div>
            
            <div class="pt-4">
                <button type="submit" class="w-full bg-primary py-4 text-white rounded-2xl font-black text-sm shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all uppercase tracking-widest">
                    Lancer la Session
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
