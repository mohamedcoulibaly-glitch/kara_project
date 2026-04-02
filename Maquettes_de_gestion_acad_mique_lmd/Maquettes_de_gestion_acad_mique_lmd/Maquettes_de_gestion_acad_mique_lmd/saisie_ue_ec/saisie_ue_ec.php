<?php
$page_title = 'Paramétrage UE & Éléments';
$current_page = 'saisie_ue_ec';
include __DIR__ . '/../../../../backend/includes/sidebar.php';

// Variables from backend
$unites = $unites ?? [];
$id_filiere = $id_filiere ?? ($filieres[0]['id_filiere'] ?? 0);
$filieres = $filieres ?? [];
$elements_constitutifs = $elements_constitutifs ?? [];
$message = $message ?? '';
$type_message = $type_message ?? '';
?>

<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-6">
    <div>
        <nav class="flex text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
            <span>Configuration</span>
            <span class="material-symbols-outlined text-[10px]">chevron_right</span>
            <span class="text-primary font-bold">Structure Pédagogique</span>
        </nav>
        <h1 class="text-4xl font-black text-on-surface tracking-tighter">Gestion des Unités (UE/EC)</h1>
        <p class="text-slate-500 mt-2 max-w-xl">Configurez le contenu académique par filière. Ajoutez des unités et décomposez-les en éléments constitutifs.</p>
    </div>
    
    <!-- View Switcher -->
    <div class="flex items-center bg-white p-1 rounded-xl shadow-sm border border-slate-100">
        <button data-view-switch="list" class="p-2 px-4 rounded-lg bg-primary text-white flex items-center gap-2 text-xs font-bold transition-all">
            <span class="material-symbols-outlined text-[18px]">list</span> Liste
        </button>
        <button data-view-switch="grid" class="p-2 px-4 rounded-lg bg-white text-slate-400 hover:bg-slate-50 flex items-center gap-2 text-xs font-bold transition-all">
            <span class="material-symbols-outlined text-[18px]">grid_view</span> Grille
        </button>
    </div>
</div>

<?php if ($message): ?>
    <script>window.onload = () => showToast("<?= addslashes($message) ?>", "<?= $type_message ?>");</script>
<?php endif; ?>

<!-- Filters Section -->
<div class="bg-white p-6 rounded-2xl border border-slate-100 mb-10 shadow-sm flex flex-col md:flex-row gap-6 items-center justify-between">
    <form method="GET" action="" id="filiere-filter-form" class="flex-1 max-w-md w-full">
        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest">Filière d'étude</label>
        <div class="relative">
            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-primary">school</span>
            <select name="filiere" class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl text-sm font-bold text-slate-700 focus:ring-2 focus:ring-primary appearance-none outline-none" onchange="document.getElementById('filiere-filter-form').submit();">
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($f['id_filiere'] == $id_filiere) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($f['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
    
    <button data-modal-target="create-ue-modal" class="bg-slate-900 text-white px-8 py-3.5 rounded-xl font-bold text-sm shadow-xl shadow-slate-200 hover:bg-black transition-all flex items-center gap-2">
        <span class="material-symbols-outlined">add_box</span> Nouvelle Unité
    </button>
</div>

<!-- Main Display Area -->
<div id="maquette-view-container" class="space-y-6">
    <?php if (empty($unites)): ?>
        <div class="text-center py-32 bg-white rounded-3xl border border-dashed border-slate-200 searchable-item">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <span class="material-symbols-outlined text-5xl text-slate-200 scale-150">auto_stories</span>
            </div>
            <h3 class="text-xl font-black text-slate-800">Aucune donnée trouvée</h3>
            <p class="text-slate-400 mt-2 font-medium">Commencez par ajouter des unités d'enseignement pour cette filière.</p>
        </div>
    <?php else: ?>
        <?php foreach ($unites as $ue): ?>
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 hover:shadow-xl hover:border-primary/20 transition-all overflow-hidden group searchable-item">
                <div class="p-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-slate-50/50">
                    <div class="flex items-center gap-4">
                        <div class="h-14 w-14 bg-primary rounded-2xl flex flex-col items-center justify-center text-white p-2">
                            <span class="text-[10px] font-black uppercase opacity-60">UE</span>
                            <span class="text-xs font-black"><?= htmlspecialchars($ue['code_ue']) ?></span>
                        </div>
                        <div>
                            <h5 class="text-lg font-black text-slate-800 leading-tight"><?= htmlspecialchars($ue['libelle_ue']) ?></h5>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="bg-primary/10 text-primary text-[10px] font-black px-2 py-0.5 rounded tracking-widest uppercase">Semestre <?= $ue['semestre'] ?></span>
                                <span class="text-xs font-bold text-slate-400">•</span>
                                <span class="text-xs font-bold text-slate-400"><?= $ue['credits_ects'] ?> Crédits ECTS</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <button data-modal-target="edit-ue-modal-<?= $ue['id_ue'] ?>" class="p-2.5 bg-white border border-slate-100 text-slate-400 hover:text-primary hover:border-primary/50 rounded-xl transition-all shadow-sm" title="Modifier">
                            <span class="material-symbols-outlined text-[18px]">edit</span>
                        </button>
                        <form method="POST" action="<?= $base_url . $backend_url ?>saisie_ue_ec_backend.php?filiere=<?= $id_filiere ?>" class="inline btn-delete-confirm">
                            <input type="hidden" name="action" value="delete_ue">
                            <input type="hidden" name="id_ue" value="<?= $ue['id_ue'] ?>">
                            <button type="submit" class="p-2.5 bg-white border border-slate-100 text-slate-400 hover:text-error hover:border-error/50 rounded-xl transition-all shadow-sm" title="Supprimer">
                                <span class="material-symbols-outlined text-[18px]">delete</span>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MODAL DYNAMIQUE: Editer UE -->
                <div id="edit-ue-modal-<?= $ue['id_ue'] ?>" class="modal-container fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
                    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in duration-300">
                        <div class="p-6 bg-primary text-white flex justify-between items-center">
                            <h4 class="text-sm font-black tracking-tight uppercase">Modifier Unité: <?= $ue['code_ue'] ?></h4>
                            <button data-modal-close class="hover:bg-white/10 p-1 rounded-full"><span class="material-symbols-outlined">close</span></button>
                        </div>
                        <form method="POST" action="<?= $base_url . $backend_url ?>saisie_ue_ec_backend.php?filiere=<?= $id_filiere ?>" class="p-8 space-y-6">
                            <input type="hidden" name="action" value="update_ue">
                            <input type="hidden" name="id_ue" value="<?= $ue['id_ue'] ?>">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Code UE</label>
                                    <input name="code_ue" value="<?= htmlspecialchars($ue['code_ue']) ?>" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" type="text"/>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Crédits ECTS</label>
                                    <input name="credits_ects" value="<?= $ue['credits_ects'] ?>" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" type="number"/>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Semestre</label>
                                    <select name="semestre" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                                        <?php for($i=1;$i<=10;$i++) echo "<option value='$i' ".($ue['semestre']==$i?'selected':'').">$i</option>"; ?>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Libellé</label>
                                    <input name="libelle_ue" value="<?= htmlspecialchars($ue['libelle_ue']) ?>" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" type="text"/>
                                </div>
                            </div>
                            <div class="pt-4 flex justify-end">
                                <button type="submit" class="bg-primary text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:opacity-90 active:scale-95 transition-all">Enregistrer les modifications</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- MODAL DYNAMIQUE: Ajouter EC -->
                <div id="add-ec-modal-<?= $ue['id_ue'] ?>" class="modal-container fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
                    <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in duration-300">
                        <div class="p-6 bg-slate-800 text-white flex justify-between items-center">
                            <h4 class="text-sm font-black tracking-tight uppercase">Ajouter un EC à <?= $ue['code_ue'] ?></h4>
                            <button data-modal-close class="hover:bg-white/10 p-1 rounded-full"><span class="material-symbols-outlined">close</span></button>
                        </div>
                        <form method="POST" action="<?= $base_url . $backend_url ?>saisie_ue_ec_backend.php?filiere=<?= $id_filiere ?>" class="p-8 space-y-6">
                            <input type="hidden" name="action" value="save_ec">
                            <input type="hidden" name="id_ue" value="<?= $ue['id_ue'] ?>">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Code EC</label>
                                    <input name="code_ec" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" placeholder="Ex: EC1" type="text"/>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Coefficient</label>
                                    <input name="coefficient" required step="0.1" value="1" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" type="number"/>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nom de l'élément</label>
                                    <input name="nom_ec" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary" placeholder="Libellé de l'élément constitutif" type="text"/>
                                </div>
                            </div>
                            <div class="pt-4 flex justify-end">
                                <button type="submit" class="bg-slate-800 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg hover:opacity-90 active:scale-95 transition-all">Ajouter cet élément</button>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="px-6 py-4">
                    <div class="flex items-center justify-between mb-4">
                        <h6 class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Éléments Constitutifs (EC)</h6>
                        <span class="text-[10px] font-bold text-primary bg-primary/5 px-2 py-0.5 rounded">STRUCTURE LMD</span>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php 
                        $has_ec = false;
                        foreach ($elements_constitutifs as $ec):
                            if ($ec['code_ue'] === $ue['code_ue']):
                                $has_ec = true;
                        ?>
                            <div class="flex items-center justify-between p-3 bg-slate-50/50 rounded-xl border border-transparent hover:border-slate-200 transition-all">
                                <div class="flex items-center gap-3">
                                    <div class="h-2 w-2 rounded-full bg-primary/40"></div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-700"><?= htmlspecialchars($ec['nom_ec']) ?></span>
                                        <span class="text-[9px] font-black text-slate-400 font-mono"><?= htmlspecialchars($ec['code_ec']) ?></span>
                                    </div>
                                </div>
                                <span class="bg-white px-2 py-1 rounded-lg shadow-sm text-[10px] font-black text-slate-500">Coeff: <?= $ec['coefficient'] ?></span>
                            </div>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                        
                        <!-- Mini Add EC Inline Action -->
                        <div class="flex items-center justify-center p-3 border-2 border-dashed border-slate-100 rounded-xl hover:border-primary/30 group cursor-pointer transition-all" data-modal-target="add-ec-modal-<?= $ue['id_ue'] ?>">
                            <span class="material-symbols-outlined text-slate-300 group-hover:text-primary transition-colors">add_circle</span>
                            <span class="text-[10px] font-black text-slate-400 group-hover:text-primary transition-colors ml-2 uppercase">Ajouter un EC</span>
                        </div>
                    </div>
                    
                    <?php if (!$has_ec): ?>
                        <div class="py-4 text-center">
                            <p class="text-xs italic text-slate-300">Aucun élément rattaché à cette unité.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<!-- MODAL: Création UE + EC Dynamique -->
<div id="create-ue-modal" class="modal-container fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in duration-300">
        <div class="p-6 bg-slate-900 text-white flex justify-between items-center">
            <h4 class="text-lg font-black tracking-tight">Nouvelle Structure d'Enseignement</h4>
            <button data-modal-close class="hover:bg-white/10 p-1 rounded-full"><span class="material-symbols-outlined">close</span></button>
        </div>
        
        <form method="POST" action="<?= $base_url . $backend_url ?>saisie_ue_ec_backend.php?filiere=<?= $id_filiere ?>" class="p-8 space-y-8">
            <input type="hidden" name="action" value="save_ue_batch">
            
            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Code UE</label>
                    <input name="code_ue" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary h-12" placeholder="Ex: INF101" type="text"/>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Crédits ECTS</label>
                    <input name="credits_ects" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary h-12" placeholder="6" type="number"/>
                </div>
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Semestre</label>
                    <select name="semestre" class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary h-12">
                        <?php for($i=1;$i<=6;$i++) echo "<option value='$i'>$i</option>"; ?>
                    </select>
                </div>
                <div class="col-span-3">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Libellé complet de l'Unité</label>
                    <input name="libelle_ue" required class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary h-12" placeholder="Ex: Algorithmique et Programmation" type="text"/>
                </div>
            </div>
            
            <div class="pt-6 border-t border-slate-100">
                <div class="flex items-center justify-between mb-4">
                    <h5 class="text-sm font-black text-slate-800 uppercase tracking-widest">Éléments Constitutifs (DYNAMIQUE)</h5>
                    <button type="button" id="add-ec-row-btn" class="text-xs font-black text-primary hover:underline flex items-center gap-1">
                        <span class="material-symbols-outlined text-[16px]">add_circle</span> AJOUTER UN EC
                    </button>
                </div>
                
                <div id="ec-dynamic-container" class="space-y-3 max-h-60 overflow-y-auto no-scrollbar pr-1">
                    <!-- Dynamic rows go here via JS -->
                </div>
            </div>
            
            <div class="pt-6 flex justify-end gap-3">
                <button type="button" data-modal-close class="px-6 py-3 font-bold text-slate-500 hover:bg-slate-50 rounded-xl transition-all">Annuler</button>
                <button type="submit" class="bg-primary text-white px-10 py-3 rounded-xl font-bold text-sm shadow-xl shadow-primary/20 hover:opacity-90 transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">save_as</span> CRÉER LA STRUCTURE
                </button>
            </div>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
