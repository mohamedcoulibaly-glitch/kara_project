<?php
/**
 * ====================================================
 * BACKEND: Répertoire des Étudiants
 * ====================================================
 * Affiche la liste des étudiants avec filtrage et pagination
 */

require_once __DIR__ . '/../config/config.php';

// Récupération des paramètres
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$limite = 10;
$offset = ($page - 1) * $limite;

$departement_filtre = $_GET['departement'] ?? 'Tous les départements';
$filiere_filtre = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$search_filtre = $_GET['search'] ?? '';

try {
    $db = getDB();
    if (!$db) {
        throw new Exception("Connexion à la base de données impossible");
    }

    // === Récupérer les listes de départements et filières ===
    $stmt_depts = $db->prepare("SELECT DISTINCT COALESCE(d.nom_dept, 'Sans département') as nom_dept 
                                FROM filiere f 
                                LEFT JOIN departement d ON f.id_dept = d.id_dept 
                                ORDER BY nom_dept");
    if ($stmt_depts) {
        $stmt_depts->execute();
        $result_depts = $stmt_depts->get_result();
        $departements = [];
        while ($row = $result_depts->fetch_assoc()) {
            $departements[] = $row['nom_dept'];
        }
    } else {
        $departements = [];
    }

    $stmt_filieres = $db->prepare("SELECT id_filiere, nom_filiere FROM filiere ORDER BY nom_filiere");
    if ($stmt_filieres) {
        $stmt_filieres->execute();
        $filieres = $stmt_filieres->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $filieres = [];
    }

    // === Construction de la requête avec filtres ===
    $where = "1=1";
    $params = [];
    $types = "";

    if ($departement_filtre !== 'Tous les départements') {
        $where .= " AND COALESCE(d.nom_dept, 'Sans département') = ?";
        $params[] = $departement_filtre;
        $types .= "s";
    }

    if ($filiere_filtre > 0) {
        $where .= " AND e.id_filiere = ?";
        $params[] = $filiere_filtre;
        $types .= "i";
    }

    if (!empty($search_filtre)) {
        $where .= " AND (e.nom LIKE ? OR e.prenom LIKE ? OR e.matricule LIKE ?)";
        $search_term = "%{$search_filtre}%";
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
        $types .= "sss";
    }

    // === Compter le total d'étudiants ===
    $sql_count = "
        SELECT COUNT(*) as total
        FROM etudiant e
        LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
        LEFT JOIN departement d ON f.id_dept = d.id_dept
        WHERE {$where}
    ";
    $stmt_count = $db->prepare($sql_count);
    if ($stmt_count && !empty($params)) {
        $stmt_count->bind_param($types, ...$params);
    }
    $stmt_count->execute();
    $total_etudiants = (int)$stmt_count->get_result()->fetch_assoc()['total'];

    // === Récupérer les étudiants paginés ===
    $sql_etudiants = "
        SELECT 
            e.id_etudiant, 
            e.matricule, 
            e.nom, 
            e.prenom, 
            e.date_naissance, 
            e.photo,
            e.statut,
            f.nom_filiere,
            d.nom_dept
        FROM etudiant e
        LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
        LEFT JOIN departement d ON f.id_dept = d.id_dept
        WHERE {$where}
        ORDER BY e.nom, e.prenom
        LIMIT ?, ?
    ";
    
    $stmt_etudiants = $db->prepare($sql_etudiants);
    if ($stmt_etudiants) {
        // Ajouter les paramètres de pagination
        $params[] = $offset;
        $params[] = $limite;
        $types .= "ii";
        $stmt_etudiants->bind_param($types, ...$params);
        $stmt_etudiants->execute();
        $etudiants = $stmt_etudiants->get_result()->fetch_all(MYSQLI_ASSOC);
    } else {
        $etudiants = [];
    }

    // === Calculer les statistiques ===
    $sql_stats = "
        SELECT
            COUNT(*) as total,
            SUM(CASE WHEN statut = 'Actif' THEN 1 ELSE 0 END) as actifs,
            SUM(CASE WHEN statut = 'Suspendu' THEN 1 ELSE 0 END) as suspendus,
            SUM(CASE WHEN statut = 'Diplômé' THEN 1 ELSE 0 END) as diplomes
        FROM etudiant
    ";
    
    $stmt_stats = $db->prepare($sql_stats);
    if ($stmt_stats) {
        $stmt_stats->execute();
        $stats = $stmt_stats->get_result()->fetch_assoc();
    } else {
        $stats = ['total' => 0, 'actifs' => 0, 'suspendus' => 0, 'diplomes' => 0];
    }
    
    // Valeurs par défaut
    $stats['total'] = (int)($stats['total'] ?? 0);
    $stats['actifs'] = (int)($stats['actifs'] ?? 0);
    $stats['suspendus'] = (int)($stats['suspendus'] ?? 0);
    $stats['diplomes'] = (int)($stats['diplomes'] ?? 0);

} catch (Exception $e) {
    error_log("Erreur dans repertoire_etudiants_backend.php: " . $e->getMessage());
    $etudiants = [];
    $departements = [];
    $filieres = [];
    $stats = ['total' => 0, 'actifs' => 0, 'suspendus' => 0, 'diplomes' => 0];
    $total_etudiants = 0;
}

// ====================================================
// FRONTEND UI - Répertoire des Étudiants
// ====================================================
// Only render inline UI when this file is accessed directly, not when included by a Maquette
if (basename($_SERVER['PHP_SELF']) === 'repertoire_etudiants_backend.php') {

$page_title = 'Répertoire des Étudiants';
$current_page = 'etudiants';
include __DIR__ . '/includes/sidebar.php';

$total_pages = $total_etudiants > 0 ? ceil($total_etudiants / $limite) : 1;
?>

<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
    <div>
        <span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">Gestion des Étudiants</span>
        <h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Répertoire des Étudiants</h3>
        <p class="text-slate-500 mt-1 max-w-2xl">Consultez, recherchez et gérez tous les étudiants inscrits dans l'établissement.</p>
    </div>
    <div class="flex items-center gap-2">
        <a href="<?= $base_url ?>backend/export_etudiants.php<?= !empty($search_filtre) ? '?search=' . urlencode($search_filtre) : '' ?><?= $filiere_filtre > 0 ? (empty($search_filtre) ? '?' : '&') . 'filiere=' . $filiere_filtre : '' ?>"
           class="px-5 py-2.5 bg-white border border-outline-variant/30 text-slate-700 font-semibold text-sm rounded-md shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">download</span>
            Exporter CSV
        </a>
        <a href="<?= $base_url ?>backend/saisie_etudiants_backend.php"
           class="px-5 py-2.5 bg-primary text-white font-semibold text-sm rounded-md shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">person_add</span>
            Inscrire un Étudiant
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="bg-white p-5 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl text-primary">groups</span>
            <span class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-0.5 rounded-full">Total</span>
        </div>
        <div class="text-2xl font-bold text-primary"><?= $stats['total'] ?></div>
        <div class="text-xs text-slate-500 mt-1">Étudiants enregistrés</div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl text-green-600">check_circle</span>
            <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-0.5 rounded-full">Actifs</span>
        </div>
        <div class="text-2xl font-bold text-green-600"><?= $stats['actifs'] ?></div>
        <div class="text-xs text-slate-500 mt-1">Étudiants actifs</div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl text-orange-600">pause_circle</span>
            <span class="text-xs font-bold text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full">Suspendus</span>
        </div>
        <div class="text-2xl font-bold text-orange-600"><?= $stats['suspendus'] ?></div>
        <div class="text-xs text-slate-500 mt-1">Étudiants suspendus</div>
    </div>
    <div class="bg-white p-5 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
        <div class="flex items-center justify-between mb-2">
            <span class="material-symbols-outlined text-2xl text-blue-600">school</span>
            <span class="text-xs font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full">Diplômés</span>
        </div>
        <div class="text-2xl font-bold text-blue-600"><?= $stats['diplomes'] ?></div>
        <div class="text-xs text-slate-500 mt-1">Étudiants diplômés</div>
    </div>
</div>

<!-- Search & Filter Bar -->
<div class="bg-white rounded-xl shadow-sm border border-outline-variant/10 p-4 mb-6">
    <form method="GET" action="" class="flex flex-col md:flex-row gap-3 items-end">
        <div class="flex-1">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Rechercher</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                <input type="text" name="search" value="<?= htmlspecialchars($search_filtre) ?>"
                       placeholder="Nom, prénom ou matricule..."
                       class="w-full pl-10 pr-4 py-2.5 bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none font-medium">
            </div>
        </div>
        <div class="w-full md:w-48">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Département</label>
            <select name="departement"
                    class="w-full py-2.5 px-3 bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none font-medium">
                <option value="Tous les départements">Tous</option>
                <?php foreach ($departements as $dept): ?>
                    <option value="<?= htmlspecialchars($dept) ?>" <?= $departement_filtre === $dept ? 'selected' : '' ?>>
                        <?= htmlspecialchars($dept) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-full md:w-48">
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Filière</label>
            <select name="filiere"
                    class="w-full py-2.5 px-3 bg-surface-container-low border-none rounded-lg text-sm focus:ring-2 focus:ring-primary outline-none font-medium">
                <option value="0">Toutes</option>
                <?php foreach ($filieres as $fil): ?>
                    <option value="<?= $fil['id_filiere'] ?>" <?= $filiere_filtre == $fil['id_filiere'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($fil['nom_filiere']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit"
                    class="px-5 py-2.5 bg-primary text-white font-semibold text-sm rounded-lg shadow-sm hover:bg-primary-container transition-all flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">filter_list</span>
                Filtrer
            </button>
            <a href="<?= $base_url ?>backend/repertoire_etudiants_backend.php"
               class="px-4 py-2.5 bg-slate-100 text-slate-600 font-semibold text-sm rounded-lg hover:bg-slate-200 transition-all flex items-center gap-1">
                <span class="material-symbols-outlined text-sm">clear</span>
                Reset
            </a>
        </div>
    </form>
</div>

<!-- Results Info -->
<div class="flex items-center justify-between mb-4">
    <p class="text-sm text-slate-500">
        <span class="font-bold text-on-surface"><?= $total_etudiants ?></span> étudiant(s) trouvé(s)
        <?php if (!empty($search_filtre)): ?>
            pour "<span class="font-semibold text-primary"><?= htmlspecialchars($search_filtre) ?></span>"
        <?php endif; ?>
    </p>
    <p class="text-xs text-slate-400">Page <?= $page ?> / <?= $total_pages ?></p>
</div>

<!-- Students Table -->
<div class="bg-white rounded-xl shadow-sm border border-outline-variant/10 overflow-hidden mb-6">
    <?php if (empty($etudiants)): ?>
        <div class="text-center py-16">
            <span class="material-symbols-outlined text-6xl text-slate-200 mb-4 block">person_off</span>
            <h4 class="text-lg font-bold text-slate-400 mb-1">Aucun étudiant trouvé</h4>
            <p class="text-sm text-slate-400">Essayez de modifier vos critères de recherche.</p>
        </div>
    <?php else: ?>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant/20">
                        <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Photo</th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Matricule</th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nom & Prénom</th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Filière</th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Département</th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Statut</th>
                        <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/10">
                    <?php foreach ($etudiants as $etudiant): ?>
                        <tr class="hover:bg-surface-container-low/50 transition-colors">
                            <td class="py-3 px-4">
                                <div class="w-9 h-9 rounded-lg bg-primary/10 flex items-center justify-center">
                                    <?php if (!empty($etudiant['photo'])): ?>
                                        <img src="<?= htmlspecialchars($etudiant['photo']) ?>" alt="Photo" class="w-9 h-9 rounded-lg object-cover">
                                    <?php else: ?>
                                        <span class="material-symbols-outlined text-primary text-lg">person</span>
                                    <?php endif; ?>
                                </div>
                            </td>
                            <td class="py-3 px-4">
                                <span class="text-sm font-mono text-slate-600 bg-surface-container px-2 py-0.5 rounded">
                                    <?= htmlspecialchars($etudiant['matricule']) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <p class="text-sm font-semibold text-slate-800">
                                    <?= htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']) ?>
                                </p>
                                <?php if (!empty($etudiant['date_naissance'])): ?>
                                    <p class="text-xs text-slate-400 mt-0.5">
                                        Né(e) le <?= date('d/m/Y', strtotime($etudiant['date_naissance'])) ?>
                                    </p>
                                <?php endif; ?>
                            </td>
                            <td class="py-3 px-4 text-sm text-slate-600"><?= htmlspecialchars($etudiant['nom_filiere'] ?? 'N/A') ?></td>
                            <td class="py-3 px-4 text-sm text-slate-600"><?= htmlspecialchars($etudiant['nom_dept'] ?? 'N/A') ?></td>
                            <td class="py-3 px-4">
                                <?php
                                $statut = $etudiant['statut'] ?? 'Actif';
                                $statut_class = match($statut) {
                                    'Actif' => 'bg-green-50 text-green-700',
                                    'Diplômé' => 'bg-blue-50 text-blue-700',
                                    'Suspendu' => 'bg-orange-50 text-orange-700',
                                    'Inactif' => 'bg-gray-50 text-gray-600',
                                    default => 'bg-gray-50 text-gray-600'
                                };
                                $statut_icon = match($statut) {
                                    'Actif' => 'check_circle',
                                    'Diplômé' => 'school',
                                    'Suspendu' => 'pause_circle',
                                    'Inactif' => 'cancel',
                                    default => 'pending'
                                };
                                ?>
                                <span class="inline-flex items-center gap-1 px-2 py-1 <?= $statut_class ?> rounded-full text-xs font-semibold">
                                    <span class="material-symbols-outlined text-xs"><?= $statut_icon ?></span>
                                    <?= htmlspecialchars($statut) ?>
                                </span>
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-1">
                                    <a href="<?= $base_url ?>backend/parcours_academique_backend.php?id=<?= $etudiant['id_etudiant'] ?>"
                                       class="p-1.5 rounded-lg hover:bg-primary/10 text-primary transition-all" title="Parcours">
                                        <span class="material-symbols-outlined text-lg">timeline</span>
                                    </a>
                                    <a href="<?= $base_url ?>backend/relev_backend.php?id=<?= $etudiant['id_etudiant'] ?>"
                                       class="p-1.5 rounded-lg hover:bg-blue-50 text-blue-600 transition-all" title="Relevé de Notes">
                                        <span class="material-symbols-outlined text-lg">description</span>
                                    </a>
                                    <a href="<?= $base_url ?>backend/carte_etudiant_backend.php?id=<?= $etudiant['id_etudiant'] ?>"
                                       class="p-1.5 rounded-lg hover:bg-green-50 text-green-600 transition-all" title="Carte Étudiant">
                                        <span class="material-symbols-outlined text-lg">badge</span>
                                    </a>
                                    <a href="<?= $base_url ?>backend/attestation_backend.php?id=<?= $etudiant['id_etudiant'] ?>"
                                       class="p-1.5 rounded-lg hover:bg-purple-50 text-purple-600 transition-all" title="Attestation">
                                        <span class="material-symbols-outlined text-lg">verified</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
<div class="flex items-center justify-center gap-2 mb-8">
    <?php if ($page > 1): ?>
        <a href="?page=<?= $page - 1 ?>&search=<?= urlencode($search_filtre) ?>&departement=<?= urlencode($departement_filtre) ?>&filiere=<?= $filiere_filtre ?>"
           class="flex items-center gap-1 px-4 py-2 bg-white border border-outline-variant/30 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all">
            <span class="material-symbols-outlined text-sm">chevron_left</span>
            Précédent
        </a>
    <?php endif; ?>

    <?php
    $start = max(1, $page - 2);
    $end = min($total_pages, $page + 2);
    for ($i = $start; $i <= $end; $i++):
    ?>
        <a href="?page=<?= $i ?>&search=<?= urlencode($search_filtre) ?>&departement=<?= urlencode($departement_filtre) ?>&filiere=<?= $filiere_filtre ?>"
           class="w-10 h-10 flex items-center justify-center rounded-lg text-sm font-bold transition-all
                  <?= $i === $page ? 'bg-primary text-white shadow-sm' : 'bg-white border border-outline-variant/30 text-slate-600 hover:bg-slate-50' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?page=<?= $page + 1 ?>&search=<?= urlencode($search_filtre) ?>&departement=<?= urlencode($departement_filtre) ?>&filiere=<?= $filiere_filtre ?>"
           class="flex items-center gap-1 px-4 py-2 bg-white border border-outline-variant/30 rounded-lg text-sm font-medium text-slate-600 hover:bg-slate-50 transition-all">
            Suivant
            <span class="material-symbols-outlined text-sm">chevron_right</span>
        </a>
    <?php endif; ?>
</div>
<?php endif; ?>

<?php include __DIR__ . '/includes/footer.php'; ?>

<?php
} // Fermer le if (basename($_SERVER['PHP_SELF']) === 'repertoire_etudiants_backend.php')
?>
