<?php
/**
 * ====================================================
 * VUE: Répertoire des Étudiants
 * ====================================================
 */

// === Synchronisation avec les variables du Backend ===
$total_etudiants = $total_etudiants ?? 0;
$total_pages = $total_pages ?? 1;
$page = $page ?? 1;
$limit = $limite ?? 50;
$search = $recherche ?? '';
$id_filiere = $id_filiere ?? 0;
$etudiants = $etudiants ?? [];

$affichageDebut = count($etudiants) > 0 ? (($page - 1) * $limit) + 1 : 0;
$affichageFin = (($page - 1) * $limit) + count($etudiants);
$infoPagination = count($etudiants) === 0 ? "Aucun étudiant trouvé" : "Affichage de {$affichageDebut} à {$affichageFin} sur {$total_etudiants} étudiants";

$page_title = 'Annuaire Étudiants';
$current_page = 'etudiants';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
    <div>
        <nav class="flex text-[10px] font-black text-slate-400 mb-2 gap-2 uppercase tracking-widest">
            <span>Gestion</span>
            <span class="material-symbols-outlined text-[12px]">chevron_right</span>
            <span class="text-primary font-bold">Annuaire Étudiants</span>
        </nav>
        <h1 class="text-4xl font-black text-slate-800 tracking-tighter">Répertoire Académique</h1>
        <p class="text-slate-500 mt-2 max-w-xl font-medium leading-relaxed">Consultez l'ensemble de la population étudiante. Filtrez par filière ou utilisez la recherche globale.</p>
    </div>
    <div class="flex gap-3">
        <a href="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php?export=csv&recherche=<?= urlencode($search) ?>&filiere=<?= $id_filiere ?>" class="flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 font-bold text-sm hover:bg-slate-50 hover:shadow-sm transition-all" title="Télécharger CSV">
            <span class="material-symbols-outlined text-[20px]">download</span> Exporter CSV
        </a>
        <a href="<?= $base_url . $backend_url ?>export_etudiants_pdf.php?filiere=<?= $id_filiere ?>" class="flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 font-bold text-sm hover:bg-slate-50 hover:shadow-sm transition-all" title="Télécharger PDF">
            <span class="material-symbols-outlined text-[20px]">description</span> Exporter PDF
        </a>
        <button onclick="window.print()" class="flex items-center gap-2 px-5 py-3 rounded-xl border border-slate-200 bg-white text-slate-700 font-bold text-sm hover:bg-slate-50 hover:shadow-sm transition-all">
            <span class="material-symbols-outlined text-[20px]">print</span> IMPRIMER
        </button>
        <a href="<?= $base_url . $backend_url ?>saisie_etudiants_backend.php" class="flex items-center gap-2 px-8 py-3 rounded-xl bg-slate-900 text-white font-black text-sm shadow-xl shadow-slate-200 hover:bg-black active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[20px]">add</span> NOUVEAU
        </a>
    </div>
</div>

<!-- Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-2 px-1">Total Inscrits</p>
        <p class="text-3xl font-black text-primary leading-none"><?= number_format($stats['total'] ?? 0, 0, ',', ' ') ?></p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-2 px-1">Étudiants Actifs</p>
        <p class="text-3xl font-black text-green-600 leading-none"><?= number_format($stats['actifs'] ?? 0, 0, ',', ' ') ?></p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-2 px-1">Diplômés</p>
        <p class="text-3xl font-black text-slate-800 leading-none"><?= number_format($stats['diplomes'] ?? 0, 0, ',', ' ') ?></p>
    </div>
    <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest mb-2 px-1">Suspendus</p>
        <p class="text-3xl font-black text-red-500 leading-none"><?= number_format($stats['suspendus'] ?? 0, 0, ',', ' ') ?></p>
    </div>
</div>

<!-- Filters Section -->
<section class="bg-white rounded-2xl border border-slate-100 p-6 mb-10 shadow-sm">
    <form method="GET" action="<?= $base_url . $backend_url ?>repertoire_etudiants_backend.php" id="repertoire-filter-form" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div class="md:col-span-2 relative group">
            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest px-1">Recherche Globale</label>
            <span class="material-symbols-outlined absolute left-3 top-[38px] text-slate-400 group-focus-within:text-primary transition-colors text-[20px]">search</span>
            <input name="recherche" value="<?= htmlspecialchars($search) ?>" class="w-full bg-slate-50 border-none rounded-xl text-sm py-3.5 pl-10 focus:ring-2 focus:ring-primary focus:bg-white shadow-sm text-slate-700 font-bold transition-all" placeholder="Nom, prénom ou matricule..." type="text"/>
        </div>
        <div>
            <label class="block text-[10px] font-black text-slate-400 uppercase mb-2 tracking-widest px-1">Filière</label>
            <select name="filiere" class="w-full bg-slate-50 border-none rounded-xl text-sm py-3.5 px-4 focus:ring-2 focus:ring-primary shadow-sm text-slate-700 font-bold appearance-none outline-none" onchange="this.form.submit()">
                <option value="0">Toutes les filières</option>
                <?php foreach ($filieres as $f): ?>
                    <option value="<?= $f['id_filiere'] ?>" <?= ($id_filiere == $f['id_filiere']) ? 'selected' : '' ?>><?= htmlspecialchars($f['nom_filiere']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full bg-primary/10 text-primary font-black text-xs py-4 rounded-xl hover:bg-primary hover:text-white transition-all uppercase tracking-widest">
                FILTRER
            </button>
        </div>
    </form>
</section>

<!-- Table Section -->
<div class="bg-white rounded-2xl overflow-hidden border border-slate-100 shadow-sm mb-12">
    <div class="overflow-x-auto no-scrollbar">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50">
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Étudiant</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Matricule</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Filière</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Inscrit le</th>
                    <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Statut</th>
                    <th class="px-6 py-4 text-right"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                <?php if (!empty($etudiants)): ?>
                    <?php foreach ($etudiants as $et): ?>
                    <tr class="hover:bg-slate-50/80 transition-all group searchable-item">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="h-10 w-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-400 font-black text-xs group-hover:bg-primary group-hover:text-white transition-all duration-300 uppercase">
                                    <?= substr($et['nom'], 0, 1) . substr($et['prenom'], 0, 1) ?>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-black text-slate-800"><?= htmlspecialchars($et['nom'] . ' ' . $et['prenom']) ?></span>
                                    <span class="text-[10px] font-bold text-slate-400 lowercase"><?= htmlspecialchars($et['email']) ?></span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-xs font-mono font-black text-primary bg-primary/5 px-2 py-1 rounded"><?= htmlspecialchars($et['matricule']) ?></span>
                        </td>
                        <td class="px-6 py-4 text-xs font-bold text-slate-600 truncate max-w-[150px]"><?= htmlspecialchars($et['nom_filiere']) ?></td>
                        <td class="px-6 py-4 text-[10px] font-black text-slate-400 tracking-wider">
                            <?= date('d M Y', strtotime($et['date_inscription'])) ?>
                        </td>
                        <td class="px-6 py-4">
                             <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase tracking-widest <?= $et['statut'] == 'Actif' ? 'bg-green-50 text-green-600' : 'bg-red-50 text-red-600' ?>">
                                <?= htmlspecialchars($et['statut']) ?>
                             </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="<?= $base_url . $backend_url ?>carte_etudiant_backend.php?id=<?= $et['id_etudiant'] ?>" class="p-2 hover:bg-white rounded-lg text-slate-400 hover:text-primary shadow-sm border border-transparent hover:border-slate-100" title="Carte">
                                    <span class="material-symbols-outlined text-[20px]">badge</span>
                                </a>
                                <a href="#" class="p-2 hover:bg-white rounded-lg text-slate-400 hover:text-primary shadow-sm border border-transparent hover:border-slate-100">
                                    <span class="material-symbols-outlined text-[20px]">edit</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-24 text-center">
                            <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                                <span class="material-symbols-outlined text-4xl text-slate-200">person_search</span>
                            </div>
                            <h3 class="text-lg font-black text-slate-800">Aucun étudiant trouvé</h3>
                            <p class="text-slate-400 text-xs font-medium">Affinez vos filtres ou lancez une nouvelle recherche.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <!-- Pagination Footer -->
    <div class="bg-slate-50/50 px-8 py-5 flex items-center justify-between border-t border-slate-100">
        <p class="text-[10px] text-slate-400 font-black uppercase tracking-widest italic"><?= htmlspecialchars($infoPagination) ?></p>
        <div class="flex gap-2">
            <a href="?page=<?= max(1, $page-1) ?>&filiere=<?= $id_filiere ?>&recherche=<?= urlencode($search) ?>" class="h-9 w-9 flex items-center justify-center rounded-xl border border-slate-200 bg-white hover:bg-primary hover:text-white transition-all text-slate-500 <?= $page <= 1 ? 'pointer-events-none opacity-30' : '' ?>">
                <span class="material-symbols-outlined text-[18px]">chevron_left</span>
            </a>
            <div class="h-9 flex items-center px-4 bg-white border border-slate-200 rounded-xl text-xs font-black text-primary">
                <?= $page ?> / <?= $total_pages ?>
            </div>
            <a href="?page=<?= min($total_pages, $page+1) ?>&filiere=<?= $id_filiere ?>&recherche=<?= urlencode($search) ?>" class="h-9 w-9 flex items-center justify-center rounded-xl border border-slate-200 bg-white hover:bg-primary hover:text-white transition-all text-slate-500 <?= $page >= $total_pages ? 'pointer-events-none opacity-30' : '' ?>">
                <span class="material-symbols-outlined text-[18px]">chevron_right</span>
            </a>
        </div>
    </div>
</div>

<!-- Floating Action Button (FAB) -->
<a href="<?= $base_url . $backend_url ?>saisie_etudiants_backend.php" class="fixed bottom-8 right-8 h-16 w-16 bg-primary text-white rounded-full shadow-2xl flex items-center justify-center hover:scale-110 active:scale-95 transition-all z-50 group">
    <span class="material-symbols-outlined text-[32px] group-hover:rotate-90 transition-transform duration-300">add</span>
    <div class="absolute right-full mr-4 bg-slate-900 text-white px-4 py-2 rounded-xl text-[10px] font-black opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none shadow-xl uppercase tracking-widest">
        Nouvelle Inscription
    </div>
</a>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
