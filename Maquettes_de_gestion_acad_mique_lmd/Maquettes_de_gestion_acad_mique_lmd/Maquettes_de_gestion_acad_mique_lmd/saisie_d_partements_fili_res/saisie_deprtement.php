<?php
$page_title = 'Paramétrage Structure Académique';
$current_page = 'departements';
include __DIR__ . '/../../../../backend/includes/sidebar.php';

// Variables assumed to be extracted from backend
$departements = $departements ?? [];
$filieres = $filieres ?? [];
$message = $message ?? '';
$type_message = $type_message ?? '';
?>

<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-lg <?= $type_message === 'success' ? 'bg-green-50 text-green-800 border-l-4 border-green-500' : 'bg-red-50 text-red-800 border-l-4 border-red-500' ?> shadow-sm">
        <?= $message ?>
    </div>
<?php endif; ?>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">
    <!-- Form Area -->
    <div class="lg:col-span-5 space-y-8">
        <!-- Add Department -->
        <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm border border-slate-100/50">
            <div class="flex items-center gap-3 mb-8">
                <span class="material-symbols-outlined text-primary bg-primary/10 p-2 rounded-lg" style="font-variation-settings: 'FILL' 1;">account_balance</span>
                <h4 class="text-lg font-bold">Nouveau Département</h4>
            </div>
            
            <form method="POST" action="<?= $base_url . $backend_url ?>saisie_deprtement_backend.php" class="space-y-6">
                <input type="hidden" name="action" value="create_dept">
                
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Code</label>
                        <input name="code_dept" required class="w-full bg-slate-50 border-none rounded-lg px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-primary transition-all" placeholder="Ex: SET" type="text"/>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Chef Dpt.</label>
                        <input name="chef_dept" class="w-full bg-slate-50 border-none rounded-lg px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-primary transition-all" placeholder="Nom..." type="text"/>
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nom du Département</label>
                        <input name="nom_dept" required class="w-full bg-slate-50 border-none rounded-lg px-4 py-3 text-sm focus:bg-white focus:ring-2 focus:ring-primary transition-all" placeholder="Ex: Sciences et Technologies" type="text"/>
                    </div>
                </div>
                
                <button type="submit" class="w-full bg-primary py-4 text-white rounded-lg font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-[0.99] mt-4">
                    CRÉER LE DÉPARTEMENT
                </button>
            </form>
        </div>

        <!-- Add Filiere -->
        <div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm border border-slate-100/50">
            <div class="flex items-center gap-3 mb-8">
                <span class="material-symbols-outlined text-secondary bg-secondary/10 p-2 rounded-lg" style="font-variation-settings: 'FILL' 1;">account_tree</span>
                <h4 class="text-lg font-bold">Nouvelle Filière</h4>
            </div>
            
            <form method="POST" action="<?= $base_url . $backend_url ?>saisie_deprtement_backend.php" class="space-y-6">
                <input type="hidden" name="action" value="create_filiere">
                
                <div class="space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Département de rattachement</label>
                        <select name="id_dept" required class="w-full bg-slate-50 border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary">
                            <option value="">Sélectionner un département...</option>
                            <?php foreach ($departements as $dept): ?>
                                <option value="<?= $dept['id_dept'] ?>"><?= htmlspecialchars($dept['nom_dept']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Code Filière</label>
                            <input name="code_filiere" class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-xs focus:ring-2 focus:ring-primary" placeholder="Ex: GL" type="text"/>
                        </div>
                        <div class="col-span-1">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Niveau</label>
                            <select name="niveau" class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-xs focus:ring-2 focus:ring-primary">
                                <option value="Licence">Licence</option>
                                <option value="Master">Master</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nom de la Filière</label>
                            <input name="nom_filiere" required class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-xs focus:ring-2 focus:ring-primary" placeholder="Ex: Génie Logiciel" type="text"/>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full bg-slate-800 py-3 text-white rounded-lg font-bold text-sm hover:bg-slate-900 transition-all active:scale-[0.99]">
                        AJOUTER LA FILIÈRE
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Display Area -->
    <div class="lg:col-span-7 space-y-6">
        <div class="flex items-center justify-between mb-2">
            <h4 class="text-lg font-bold text-slate-800">Structure de l'Établissement</h4>
        </div>

        <?php if (empty($departements)): ?>
            <div class="text-center py-24 bg-slate-50 rounded-xl border border-dashed border-slate-300">
                <span class="material-symbols-outlined text-6xl text-slate-300 mb-4 block">domain_disabled</span>
                <p class="text-slate-500 font-medium">Aucun département configuré pour le moment.</p>
            </div>
        <?php else: ?>
            <div class="space-y-6">
                <?php foreach ($departements as $dept): ?>
                    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
                        <div class="bg-primary/5 px-6 py-4 flex justify-between items-center border-b border-primary/10">
                            <div>
                                <h5 class="text-base font-bold text-primary"><?= htmlspecialchars($dept['nom_dept']) ?></h5>
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-0.5">Code: <?= htmlspecialchars($dept['code_dept']) ?> | Chef: <?= htmlspecialchars($dept['chef_dept'] ?? 'N/A') ?></p>
                            </div>
                            <!-- Manage Dept -->
                            <div class="flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <button onclick="submitDelete('<?= $base_url . $backend_url ?>saisie_deprtement_backend.php', 'delete_dept', <?= $dept['id_dept'] ?>, 'id_dept')" class="p-1.5 text-slate-400 hover:text-error transition-colors" title="Supprimer le département">
                                    <span class="material-symbols-outlined text-sm">delete</span>
                                </button>
                            </div>
                        </div>
                        <div class="px-6 py-4">
                            <ul class="space-y-3">
                                <?php 
                                $has_filiere = false;
                                foreach ($filieres as $f) {
                                    if ($f['id_dept'] == $dept['id_dept']) {
                                        $has_filiere = true; ?>
                                        <li class="flex items-center justify-between group">
                                            <div class="flex items-center gap-3">
                                                <span class="w-1.5 h-1.5 rounded-full bg-primary/40 group-hover:bg-primary transition-colors"></span>
                                                <span class="text-sm font-medium text-slate-700"><?= htmlspecialchars($f['nom_filiere']) ?></span>
                                                <span class="text-[9px] font-bold text-slate-400 border border-slate-100 px-1.5 rounded uppercase"><?= htmlspecialchars($f['niveau']) ?></span>
                                            </div>
                                            <div class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button class="p-1 text-slate-300 hover:text-primary"><span class="material-symbols-outlined text-sm">edit</span></button>
                                                <button onclick="submitDelete('<?= $base_url . $backend_url ?>saisie_deprtement_backend.php', 'delete_filiere', <?= $f['id_filiere'] ?>, 'id_filiere')" class="p-1 text-slate-300 hover:text-error">
                                                    <span class="material-symbols-outlined text-sm">delete</span>
                                                </button>
                                            </div>
                                        </li>
                                <?php
                                    }
                                }
                                if (!$has_filiere) echo '<li class="text-xs italic text-slate-400">Aucune filière configurée.</li>';
                                ?>
                            </ul>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
