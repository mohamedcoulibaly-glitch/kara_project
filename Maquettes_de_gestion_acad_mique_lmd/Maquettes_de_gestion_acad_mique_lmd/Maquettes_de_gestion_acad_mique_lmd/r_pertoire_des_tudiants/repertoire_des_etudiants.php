<?php
// === Variables dynamiques du Backend ===
$totalInscrits = isset($stats['total']) ? $stats['total'] : 0;
$actifs = isset($stats['actifs']) ? $stats['actifs'] : 0;
$suspendus = isset($stats['suspendus']) ? $stats['suspendus'] : 0;
$nouveaux = isset($stats['diplomes']) ? $stats['diplomes'] : 0; 

$affichageDebut = count($etudiants) > 0 ? (($page - 1) * $limite) + 1 : 0;
$affichageFin = (($page - 1) * $limite) + count($etudiants);
$infoPagination = count($etudiants) === 0 ? "Aucun étudiant trouvé" : "Affichage de {$affichageDebut} à {$affichageFin} sur {$total_etudiants} étudiants";
$students = $etudiants;
?>

<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<title>LMD AcadÃ©mique - Liste des Ã‰tudiants</title>
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
<span class="text-xl font-bold tracking-tight text-blue-700 dark:text-blue-400">LMD AcadÃ©mique</span>
<div class="hidden md:flex items-center bg-surface-container px-4 py-1.5 rounded-full border border-outline-variant/20">
<span class="material-symbols-outlined text-on-surface-variant text-sm pr-2">search</span>
<input class="bg-transparent border-none focus:ring-0 text-sm w-64 placeholder:text-on-surface-variant" placeholder="Rechercher un Ã©tudiant..." type="text"/>
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
<h2 class="font-black text-blue-800 dark:text-blue-300 text-lg uppercase tracking-wider">Portail AcadÃ©mique</h2>
<p class="text-xs text-slate-500 font-normal">Gestion LMD v2.0</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="../index.php">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">dashboard</span>
<span>Dashboard</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">account_tree</span>
<span>FiliÃ¨res</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 bg-white dark:bg-slate-800 text-blue-700 dark:text-blue-300 shadow-sm rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">group</span>
<span>Ã‰tudiants</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="saisie_notes_par_ec_backend.php">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">edit_note</span>
<span>Notes</span>
</a>
<a class="flex items-center gap-3 px-3 py-2.5 text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-300 hover:bg-white/50 dark:hover:bg-slate-800/50 transition-all rounded-lg group" href="#">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">settings</span>
<span>ParamÃ¨tres</span>
</a>
</nav>
<div class="pt-4 mt-auto border-t border-slate-200 dark:border-slate-800">
<button class="flex items-center gap-3 px-3 py-2.5 w-full text-slate-600 dark:text-slate-400 hover:text-error transition-all rounded-lg group">
<span class="material-symbols-outlined group-hover:translate-x-1 duration-200">logout</span>
<span>DÃ©connexion</span>
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
<span class="text-primary font-bold">Ã‰tudiants</span>
</nav>
<h1 class="text-4xl font-extrabold text-on-background tracking-tighter">Annuaire Ã‰tudiants</h1>
<p class="text-on-surface-variant mt-2 max-w-xl">Consultez, gÃ©rez et exportez la liste complÃ¨te des Ã©tudiants inscrits au titre de l'annÃ©e acadÃ©mique 2023-2024.</p>
</div>
<div class="flex gap-3">
<button class="flex items-center gap-2 px-5 py-2.5 rounded-md border border-outline-variant/40 bg-white text-on-surface font-semibold text-sm hover:bg-surface-container transition-all">
<span class="material-symbols-outlined text-lg">picture_as_pdf</span>
                        Exporter PDF
                    </button>
<button class="flex items-center gap-2 px-6 py-2.5 rounded-md bg-gradient-to-r from-primary to-primary-container text-white font-bold text-sm shadow-sm hover:opacity-90 active:scale-95 transition-all">
<span class="material-symbols-outlined text-lg">add</span>
                        Ajouter Ã‰tudiant
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
<p class="text-xs text-on-surface-variant font-medium uppercase tracking-wider mb-1">Diplômés</p>
<p class="text-3xl font-bold text-tertiary"><?= number_format($nouveaux, 0, ',', ' ') ?></p>
</div>
</div>
<!-- Filters Section -->
<section class="bg-surface-container-low rounded-xl p-6 mb-8">
<form method="get">
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="space-y-1.5">
<label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest px-1">DÃ©partement</label>
<select name="departement" class="w-full bg-white border-none rounded-md text-sm py-2.5 focus:ring-2 focus:ring-primary shadow-sm text-on-surface">
<option value="Tous les dÃ©partements"<?= $filters['departement'] === 'Tous les dÃ©partements' ? ' selected' : '' ?>>Tous les dÃ©partements</option>
<?php foreach ($departements as $dept): ?>
<option value="<?= htmlspecialchars($dept) ?>"<?= $filters['departement'] === $dept ? ' selected' : '' ?>><?= htmlspecialchars($dept) ?></option>
<?php endforeach; ?>
</select>
</div>
<div class="space-y-1.5">
<label class="text-[11px] font-bold text-on-surface-variant uppercase tracking-widest px-1">FiliÃ¨re</label>
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
</form>
</section>
<!-- Table Section -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden border border-outline-variant/5 shadow-sm">
<div class="overflow-x-auto no-scrollbar">
<table class="w-full text-left border-collapse">
<thead>
<tr class="bg-surface-container-low/50">
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Ã‰tudiant</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Matricule</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Nom &amp; PrÃ©nom</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Date de Naissance</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest">Statut</th>
<th class="px-6 py-4 text-[11px] font-bold text-on-surface-variant uppercase tracking-widest text-right">Actions</th>
</tr>
</thead>
<tbody class="divide-y divide-outline-variant/10">
<?php if (is_array($students) && count($students) > 0): ?>
    <?php foreach ($students as $student): ?>
    <?php
        // En cas de champ absent, on dÃ©finit des valeurs par dÃ©faut
        $student['statut'] = $student['statut'] ?? 'Inscrit';
        $statusClass = strtolower($student['statut']) === 'suspendu'
            ? 'bg-tertiary-container text-on-tertiary-container'
            : 'bg-secondary-container text-on-secondary-container';

        // Photo par dÃ©faut si aucune URL fournie
        $photo = $student['photo'] ?? 'https://via.placeholder.com/40?text=U';

        // Les noms de champs date peuvent Ãªtre diffÃ©rents selon la table
        $naissance = $student['date_naissance'] ?? $student['naissance'] ?? 'Non renseignÃ©';
    ?>

    <!-- Ligne Ã©tudiant (boucle) -->
    <tr class="hover:bg-surface-container-low transition-colors group">
        <td class="px-6 py-4">
            <!-- image -->
            <img alt="Avatar Ã©tudiant"
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
            <p class="text-sm">Aucun Ã©tudiant trouvÃ© correspondant Ã  vos critÃ¨res.</p>
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
