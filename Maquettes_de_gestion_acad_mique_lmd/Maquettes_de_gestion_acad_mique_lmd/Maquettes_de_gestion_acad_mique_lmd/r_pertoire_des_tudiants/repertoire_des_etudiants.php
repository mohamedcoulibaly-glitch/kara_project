<?php
// === configuration de la base de données ===
// modifie ces valeurs si ton serveur MySQL a des identifiants différents
$dbHost = '127.0.0.1';
$dbName = 'gestion_notes';
$dbUser = 'root';
$dbPass = ''; // mot de passe vide par défaut pour local (change si besoin)

// === connexion PDO (PHP Data Objects) ===
// PDO est une extension sécurisée pour travailler avec MySQL.
// Si la connexion échoue, script s'arrête et affiche le message.
try {
    $pdo = new PDO("mysql:host={$dbHost};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // déclenche exception en cas d'erreur
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // résultat en tableau associatif
    ]);
} catch (PDOException $e) {
    die('Connexion DB impossible : ' . htmlspecialchars($e->getMessage()));
}

// === lecture des filtres envoyés par le formulaire (méthode GET) ===
// $_GET est un tableau des paramètres de l'URL (ex : ?filiere=...)
$filters = [
    'departement' => $_GET['departement'] ?? 'Tous les départements',
    'filiere' => $_GET['filiere'] ?? 'Toutes les filières',
    'search' => trim($_GET['search'] ?? ''),
];

// === options de filtres dynamiques (saisie dans <select>) ===
// On récupère tous les départements et filières depuis la DB.
$departements = $pdo->query('SELECT nom_dept FROM departement ORDER BY nom_dept')->fetchAll(PDO::FETCH_COLUMN);
$filieres = $pdo->query('SELECT nom_filiere FROM filiere ORDER BY nom_filiere')->fetchAll(PDO::FETCH_COLUMN);

// === construction de la requête SELECT pour les étudiants ===
$where = [];   // conditions WHERE de la requête
$params = [];  // paramètres associés pour éviter les injections SQL

if ($filters['departement'] !== 'Tous les départements') {
    $where[] = 'd.nom_dept = :departement';
    $params[':departement'] = $filters['departement'];
}

if ($filters['filiere'] !== 'Toutes les filières') {
    $where[] = 'f.nom_filiere = :filiere';
    $params[':filiere'] = $filters['filiere'];
}

if ($filters['search'] !== '') {
    // recherche partielle sur matricule, nom, prénom
    $where[] = '(e.matricule LIKE :search OR e.nom LIKE :search OR e.prenom LIKE :search)';
    $params[':search'] = '%' . $filters['search'] . '%';
}

$sql = "SELECT e.*, f.nom_filiere AS filiere, d.nom_dept AS departement
        FROM etudiant e
        LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
        LEFT JOIN departement d ON f.id_dept = d.id_dept";

if (!empty($where)) {
    // Création de la clause WHERE si au moins un filtre est sélectionné
    $sql .= ' WHERE ' . implode(' AND ', $where);
}

$sql .= ' ORDER BY e.nom, e.prenom'; // tri par nom et prénom
$stmt = $pdo->prepare($sql);   // préparation sécurisée
$stmt->execute($params);      // exécution avec paramètres
$students = $stmt->fetchAll() ?? []; // tableau des étudiants affichés (tableau vide par défaut)

// === statistiques simples ===
// total d'étudiants (tous départements confondus)
$totalInscrits = (int)$pdo->query('SELECT COUNT(*) FROM etudiant')->fetchColumn();
// sans champ statut, on suppose tout actif (adapte à ta table si champ existe)
$actifs = $totalInscrits;
$suspendus = 0;
$nouveaux = (int)round($totalInscrits * 0.24); // exemple : 24% comme dans la maquette

$affichageDebut = count($students) > 0 ? 1 : 0;
$affichageFin = count($students);
$infoPagination = count($students) === 0 
    ? "Aucun étudiant trouvé" 
    : "Affichage de {$affichageDebut} à {$affichageFin} sur {$totalInscrits} étudiants";
?>

<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>LMD Académique - Liste des Étudiants</title>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-surface-variant": "#434654",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "outline": "#737686",
                        "on-secondary-container": "#3d4e84",
                        "background": "#f7f9fb",
                        "primary-container": "#1a56db",
                        "primary-fixed-dim": "#b5c4ff",
                        "surface-bright": "#f7f9fb",
                        "on-primary": "#ffffff",
                        "inverse-on-surface": "#eff1f3",
                        "secondary-fixed": "#dbe1ff",
                        "primary-fixed": "#dbe1ff",
                        "on-tertiary-container": "#ffd4c5",
                        "on-secondary": "#ffffff",
                        "on-background": "#191c1e",
                        "inverse-surface": "#2d3133",
                        "surface-variant": "#e0e3e5",
                        "tertiary-container": "#ad3b00",
                        "surface-container-highest": "#e0e3e5",
                        "surface-container": "#eceef0",
                        "tertiary": "#852b00",
                        "surface": "#f7f9fb",
                        "error": "#ba1a1a",
                        "on-secondary-fixed-variant": "#334479",
                        "secondary-container": "#b1c2ff",
                        "surface-dim": "#d8dadc",
                        "tertiary-fixed-dim": "#ffb59a",
                        "surface-container-lowest": "#ffffff",
                        "on-error-container": "#93000a",
                        "surface-tint": "#1353d8",
                        "secondary": "#4b5c92",
                        "on-secondary-fixed": "#01174b",
                        "on-primary-container": "#d4dcff",
                        "primary": "#003fb1",
                        "outline-variant": "#c3c5d7",
                        "inverse-primary": "#b5c4ff",
                        "tertiary-fixed": "#ffdbcf",
                        "on-surface": "#191c1e",
                        "secondary-fixed-dim": "#b5c4ff",
                        "surface-container-high": "#e6e8ea",
                        "on-tertiary-fixed": "#380d00",
                        "on-tertiary": "#ffffff",
                        "on-primary-fixed-variant": "#003dab",
                        "on-tertiary-fixed-variant": "#802a00",
                        "on-primary-fixed": "#00174d",
                        "surface-container-low": "#f2f4f6"
                    },
                    fontFamily: {
                        "headline": ["Inter"],
                        "body": ["Inter"],
                        "label": ["Inter"]
                    },
                    borderRadius: { "DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem" },
                },
            },
        }
    </script>
<style>
        body { font-family: 'Inter', sans-serif; background-color: #f7f9fb; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="text-on-background selection:bg-primary-container selection:text-on-primary-container">
<!-- TopAppBar -->
<header class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md fixed top-0 w-full z-50 shadow-sm dark:shadow-none font-sans antialiased text-slate-900 dark:text-slate-100 h-16 flex justify-between items-center px-6">
<div class="flex items-center gap-8">
<span class="text-xl font-bold tracking-tight text-blue-700 dark:text-blue-400">LMD Académique</span>
<div class="hidden md:flex items-center bg-surface-container px-4 py-1.5 rounded-full border border-outline-variant/20">
<span class="material-symbols-outlined text-on-surface-variant text-sm pr-2">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-64 placeholder:text-on-surface-variant" placeholder="Rechercher un étudiant..." type="text"/>
</div>
</div>
<div class="flex items-center gap-4">
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors rounded-full cursor-pointer active:opacity-70">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400">notifications</span>
</button>
<button class="p-2 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors rounded-full cursor-pointer active:opacity-70">
<span class="material-symbols-outlined text-slate-500 dark:text-slate-400">settings</span>
</button>
<div class="h-8 w-px bg-outline-variant/30 mx-2"></div>
<span class="text-sm font-medium text-slate-600 dark:text-slate-400 cursor-pointer hover:text-blue-700">Aide</span>
<img alt="Photo de profil de l'administrateur" class="h-9 w-9 rounded-full object-cover border border-outline-variant/30" data-alt="Portrait photo of a male administrator" src="https://lh3.googleusercontent.com/aida-public/AB6AXuD1XrgLNMMYItUiyCN0gs6b5NPeLIL0qwuHut__Okq4hWI-hyfLPGTofcAqtadaTbLSo3GzfKP6fLPwaJV8RsV5YLsCPnrdJ8SQ0oj3Zr5M_mP-MPjPzEe04jznepKLlBjp4HSk5b4njpXTxAZKBATvJ1E_DRixqBxh3KL8ygHKTvioNCaOUQ99P5iHuoXqdgj-qxIvQ8E6sEyBOhnB3Jhsyb2VXBFgr-HDv8D3mXRYmIIB8mt28DHnm5JDiucKokhHYC36rUeIGHs"/>
</div>
</header>
<div class="flex pt-16">
<!-- SideNavBar -->
<aside class="fixed left-0 top-16 h-[calc(100vh-64px)] w-64 bg-slate-50 dark:bg-slate-950 flex flex-col py-6 px-4 gap-2 text-sm font-medium Inter border-r-0">
<div class="px-2 mb-8">
<h2 class="font-black text-blue-800 dark:text-blue-300 text-lg uppercase tracking-wider">Portail Académique</h2>
<p class="text-xs text-slate-500 font-normal">Gestion LMD v2.0</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">dashboard</span>
<span>Dashboard</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">account_tree</span>
<span>Filières</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 bg-white dark:bg-slate-800 text-blue-700 dark:text-blue-300 shadow-sm rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">group</span>
<span>Étudiants</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">edit_note</span>
<span>Notes</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">settings</span>
<span>Paramètres</span>
</a>
</nav>
<div class="pt-4 mt-auto border-t border-slate-200 dark:border-slate-800">
<button class="flex items-center gap-3 px-3 py-2.5 w-full text-slate-600 dark:text-slate-400 hover:text-error transition-all rounded-lg group">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">logout</span>
<span>Déconnexion</span>
</button>
</div>
</aside>
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
<button class="flex items-center gap-2 px-6 py-2.5 rounded-md bg-gradient-to-r from-primary to-primary-container text-white font-bold text-sm shadow-sm hover:opacity-90 active:scale-95 transition-all">
<span class="material-symbols-outlined text-lg">add</span>
                        Ajouter Étudiant
                    </button>
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
<p class="text-xs text-on-surface-variant font-medium uppercase tracking-wider mb-1">Nouveaux</p>
<p class="text-3xl font-bold text-tertiary"><?= number_format($nouveaux, 0, ',', ' ') ?></p>
</div>
</div>
<!-- Filters Section -->
<section class="bg-surface-container-low rounded-xl p-6 mb-8">
<form method="get">
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
<option value="Toutes les filières"<?= $filters['filiere'] === 'Toutes les filières' ? ' selected' : '' ?>>Toutes les filières</option>
<?php foreach ($filieres as $fil): ?>
<option value="<?= htmlspecialchars($fil) ?>"<?= $filters['filiere'] === $fil ? ' selected' : '' ?>><?= htmlspecialchars($fil) ?></option>
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
<button class="p-2 rounded-md border border-outline-variant/20 bg-white hover:bg-surface-container transition-all disabled:opacity-30" disabled="">
<span class="material-symbols-outlined text-lg">chevron_left</span>
</button>
<button class="p-2 rounded-md border border-outline-variant/20 bg-white hover:bg-surface-container transition-all">
<span class="material-symbols-outlined text-lg">chevron_right</span>
</button>
</div>
</div>
</div>
</main>
</div>
</body></html>