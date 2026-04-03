<?php
// === Appel du Backend ===
include __DIR__ . '/../../../../backend/repertoire_etudiants_backend.php';

// === Variables dynamiques du Backend ===
$totalInscrits = isset($stats['total']) ? $stats['total'] : 0;
$actifs = isset($stats['actifs']) ? $stats['actifs'] : 0;
$suspendus = isset($stats['suspendus']) ? $stats['suspendus'] : 0;
$nouveaux = isset($stats['diplomes']) ? $stats['diplomes'] : 0; 

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limite = 10;
$etudiants = isset($etudiants) ? $etudiants : [];
$total_etudiants = isset($total_etudiants) ? $total_etudiants : 0;

$affichageDebut = count($etudiants) > 0 ? (($page - 1) * $limite) + 1 : 0;
$affichageFin = (($page - 1) * $limite) + count($etudiants);
$infoPagination = count($etudiants) === 0 ? "Aucun étudiant trouvé" : "Affichage de {$affichageDebut} à {$affichageFin} sur {$total_etudiants} étudiants";
$students = $etudiants;

// Initialiser filters s'il n'existe pas
$filters = [
    'departement' => $_GET['departement'] ?? 'Tous les départements',
    'filiere' => isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0,
    'statut' => $_GET['statut'] ?? 'Tous les statuts',
    'search' => $_GET['search'] ?? ''
];

$id_filiere = $filters['filiere'];
$recherche = $filters['search'];
$departements = isset($departements) ? $departements : [];
$filieres = isset($filieres) ? $filieres : [];

?>

<?php
$page_title = 'Annuaire Étudiants';
$current_page = 'etudiants';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>
<!-- Main Content -->
<main class="ml-64 w-full p-8 min-h-screen bg-surface">
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12">
<div>
<nav class="flex text-xs font-medium text-slate-500 mb-2 gap-2 uppercase tracking-widest">
<span>Gestion</span>
<span class="material-symbols-outlined text-[10px]">chevron_right</span>
<span class="text-primary font-bold">Étudiants</span>
</nav>
<h1 class="text-4xl font-extrabold text-on-background tracking-tighter">Annuaire Étudiants</h1>
<p class="text-on-surface-variant mt-2 max-w-xl">Consultez, gérez et exportez la liste complète des étudiants inscrits au titre de l'année académique 2023-2024.</p>
</div>
<div class="flex gap-3">
<button class="flex items-center gap-2 px-5 py-2.5 rounded-md border border-outline-variant/40 bg-white text-on-surface font-semibold text-sm hover:bg-surface-container transition-all">
<span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                        Exporter PDF
                    </button>
<a href="/kara_project/backend/saisie_etudiants_backend.php" class="flex items-center gap-2 px-6 py-2.5 rounded-md bg-gradient-to-r from-primary to-primary-container text-white font-bold text-sm shadow-sm hover:opacity-90 active:scale-95 transition-all">
<span class="material-symbols-outlined text-lg">add</span>
                        Ajouter Étudiant</a>
</div>
</div>
<!-- Dashboard Bento / Stats Row -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
<div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10">
<p class="text-xs text-on-surface-variant font-medium uppercase tracking-wider mb-1">Total Inscrits</p>
<p class="text-3xl font-bold text-primary"><?= number_format($totalInscrits, 0, ',', ' ') ?></p>
</div>
<div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10">
<p class="text-xs text-on-surface-variant font-medium uppercase tracking-wider mb-1">Actifs</p>
<p class="text-3xl font-bold text-secondary"><?= number_format($actifs, 0, ',', ' ') ?></p>
</div>
<div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10">
<p class="text-xs text-on-surface-variant font-medium uppercase tracking-wider mb-1">Suspendus</p>
<p class="text-3xl font-bold text-error"><?= number_format($suspendus, 0, ',', ' ') ?></p>
</div>
<div class="bg-surface-container-lowest p-5 rounded-xl border border-outline-variant/10">
<p class="text-xs text-on-surface-variant font-medium uppercase tracking-wider mb-1">Diplômés</p>
<p class="text-3xl font-bold text-tertiary"><?= number_format($nouveaux, 0, ',', ' ') ?></p>
</div>
</div>
<!-- Filters Section -->
<section class="bg-surface-container-low rounded-xl p-6 mb-8">
<form method="get" class="space-y-4">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="space-y-1.5">
<label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest px-1">Département</label>
<select name="departement" class="w-full bg-white border-none rounded-md text-sm py-2.5 focus:ring-2 focus:ring-primary shadow-sm text-on-surface">
<option value="Tous les départements"<?= $filters['departement'] === 'Tous les départements' ? ' selected' : '' ?>>Tous les départements</option>
<?php foreach ($departements as $dept): ?>
<option value="<?= htmlspecialchars($dept) ?>"<?= $filters['departement'] === $dept ? ' selected' : '' ?>><?= htmlspecialchars($dept) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="space-y-1.5">
<label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest px-1">Filière</label>
<select name="filiere" class="w-full bg-white border-none rounded-md text-sm py-2.5 focus:ring-2 focus:ring-primary shadow-sm text-on-surface">
<option value="0" <?php echo ($id_filiere == 0) ? 'selected' : ''; ?>>Toutes les filières</option>
<?php foreach ($filieres as $fil): ?>
<option value="<?php echo $fil['id_filiere']; ?>" <?php echo ($id_filiere == $fil['id_filiere']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($fil['nom_filiere']); ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="space-y-1.5">
<label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest px-1">Recherche Rapide</label>
<div class="relative">
<input name="search" value="<?= htmlspecialchars($filters['search']) ?>" class="w-full bg-white border-none rounded-md text-sm py-2.5 pl-10 focus:ring-2 focus:ring-primary shadow-sm text-on-surface" placeholder="Nom ou matricule..." type="text"/>
<span class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-lg">search</span>
</div>
</div>
</div>
<div class="flex gap-3 justify-end">
<button type="submit" class="flex items-center gap-2 px-4 py-2 rounded-md bg-primary text-white font-semibold text-sm hover:opacity-90 transition-all">
<span class="material-symbols-outlined text-lg">search</span>
Rechercher
</button>
<button type="reset" class="flex items-center gap-2 px-4 py-2 rounded-md border border-outline-variant/40 bg-white text-on-surface font-semibold text-sm hover:bg-surface-container transition-all">
Réinitialiser
</button>
</div>
</form>
</section>
<!-- Table Section -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/5 shadow-sm">
<div class="overflow-x-auto no-scrollbar">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low/50">
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Étudiant</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Matricule</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Nom &amp; Prénom</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Date de Naissance</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Statut</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
<?php if (is_array($students) && count($students) > 0): ?>
    <?php foreach ($students as $student): ?>
    <?php
        // En cas de champ absent, on définit des valeurs par défaut
        $student['statut'] = $student['statut'] ?? 'Inscrit';
        $statusClass = strtolower($student['statut']) === 'suspendu'
            ? 'bg-tertiary-container text-on-tertiary-container'
            : 'bg-secondary-container text-on-secondary-container';

        // Photo par défaut si aucune URL fournie
        $photo = $student['photo'] ?? 'https://via.placeholder.com/40?text=U';

        // Les noms de champs date peuvent être différents selon la table
        $naissance = $student['date_naissance'] ?? $student['naissance'] ?? 'Non renseigné';
    ?>

    <!-- Ligne étudiant (boucle) -->
    <tr class="hover:bg-surface-container-low transition-colors group">
        <td class="px-6 py-4">
            <!-- image -->
            <img alt="Avatar étudiant"
                 class="w-10 h-10 rounded-full border border-outline-variant/20 object-cover<?= strtolower($student['statut']) === 'suspendu' ? ' opacity-60' : '' ?>"
                 src="<?= htmlspecialchars($photo) ?>"/>
        </td>
        <td class="px-6 py-4 font-mono text-sm font-semibold text-primary"><?= htmlspecialchars($student['matricule'] ?? '---') ?></td>
        <td class="px-6 py-4">
            <div class="flex flex-col">
                <span class="text-sm font-bold text-on-surface"><?= htmlspecialchars($student['nom'] ?? '---') ?></span>
                <span class="text-xs text-on-surface-variant"><?= htmlspecialchars($student['prenom'] ?? '---') ?></span>
            </div>
        </td>
        <td class="px-6 py-4 text-sm text-on-surface-variant"><?= htmlspecialchars($naissance) ?></td>
        <td class="px-6 py-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider <?= $statusClass ?>"><?= htmlspecialchars($student['statut']) ?></span>
        </td>
        <td class="px-6 py-4 text-right">
            <!-- actions (bouton) -->
            <button class="p-1.5 rounded-full hover:bg-white text-on-surface-variant group-hover:text-primary transition-all">
                <span class="material-symbols-outlined text-xl">more_vert</span>
            </button>
        </td>
    </tr>
    <?php endforeach; ?>
<?php else: ?>
    <tr>
        <td colspan="6" class="px-6 py-8 text-center text-on-surface-variant">
            <p class="text-sm">Aucun étudiant trouvé correspondant à vos critères.</p>
        </td>
    </tr>
<?php endif; ?>
</tbody>
</table>
</div>
<!-- Pagination Footer -->
<div class="bg-surface-container-low/30 px-6 py-4 flex items-center justify-between">
<p class="text-xs text-on-surface-variant font-medium"><?= htmlspecialchars($infoPagination) ?></p>
<div class="flex gap-2">
<?php 
$query_params = '';
if ($filters['departement'] !== 'Tous les départements') $query_params .= '&departement=' . urlencode($filters['departement']);
if ($filters['filiere'] != 0) $query_params .= '&filiere=' . $filters['filiere'];
if ($filters['search'] !== '') $query_params .= '&search=' . urlencode($filters['search']);

$prevDisabled = ($page <= 1) ? 'disabled' : '';
$nextDisabled = (($page * $limite) >= $total_etudiants) ? 'disabled' : '';
?>
<a href="?page=<?= max(1, $page - 1) . $query_params ?>" class="p-2 rounded-md border border-outline-variant/20 bg-white hover:bg-surface-container transition-all <?= $prevDisabled ? 'opacity-30 cursor-not-allowed' : '' ?>" <?= $prevDisabled ? 'onclick="return false"' : '' ?>>
<span class="material-symbols-outlined text-lg">chevron_left</span>
</a>
<span class="text-xs text-on-surface-variant px-3 py-2 font-medium">Page <?= $page ?></span>
<a href="?page=<?= $page + 1 . $query_params ?>" class="p-2 rounded-md border border-outline-variant/20 bg-white hover:bg-surface-container transition-all <?= $nextDisabled ? 'opacity-30 cursor-not-allowed' : '' ?>" <?= $nextDisabled ? 'onclick="return false"' : '' ?>>
<span class="material-symbols-outlined text-lg">chevron_right</span>
</a>
</div>
</div>
</div>
<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
