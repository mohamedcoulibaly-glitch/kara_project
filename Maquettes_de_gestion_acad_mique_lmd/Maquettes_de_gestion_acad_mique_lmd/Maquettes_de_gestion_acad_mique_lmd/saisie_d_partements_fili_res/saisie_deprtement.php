<?php
/**
 * ====================================================
 * FRONTEND: Saisie et Gestion des DÃ©partements
 * ====================================================
 * Affichage du formulaire et liste des dÃ©partements
 * IntÃ©grÃ© avec le backend: saisie_deprtement_backend.php
 */

// Assurer que les variables sont dÃ©finies
$departements = $departements ?? [];
$stats = $stats ?? [];
$niveaux = $niveaux ?? ['Licence', 'Master', 'Doctorat'];
$message = $message ?? '';
$type_message = $type_message ?? '';
?>
<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
<script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
    </style>
<script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "secondary": "#4b5c92",
                        "on-surface": "#191c1e",
                        "surface-dim": "#d8dadc",
                        "inverse-surface": "#2d3133",
                        "inverse-on-surface": "#eff1f3",
                        "primary": "#003fb1",
                        "on-tertiary-container": "#ffd4c5",
                        "on-primary": "#ffffff",
                        "secondary-container": "#b1c2ff",
                        "on-tertiary-fixed-variant": "#802a00",
                        "inverse-primary": "#b5c4ff",
                        "on-primary-fixed-variant": "#003dab",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-fixed-variant": "#334479",
                        "error-container": "#ffdad6",
                        "surface-tint": "#1353d8",
                        "surface": "#f7f9fb",
                        "on-secondary-fixed": "#01174b",
                        "secondary-fixed": "#dbe1ff",
                        "surface-container": "#eceef0",
                        "primary-fixed-dim": "#b5c4ff",
                        "tertiary-fixed": "#ffdbcf",
                        "surface-container-low": "#f2f4f6",
                        "surface-container-high": "#e6e8ea",
                        "on-background": "#191c1e",
                        "on-primary-fixed": "#00174d",
                        "primary-container": "#1a56db",
                        "error": "#ba1a1a",
                        "tertiary-container": "#ad3b00",
                        "on-primary-container": "#d4dcff",
                        "on-secondary": "#ffffff",
                        "tertiary": "#852b00",
                        "on-tertiary-fixed": "#380d00",
                        "on-tertiary": "#ffffff",
                        "outline-variant": "#c3c5d7",
                        "on-error-container": "#93000a",
                        "primary-fixed": "#dbe1ff",
                        "surface-container-highest": "#e0e3e5",
                        "on-error": "#ffffff",
                        "surface-bright": "#f7f9fb",
                        "tertiary-fixed-dim": "#ffb59a",
                        "secondary-fixed-dim": "#b5c4ff",
                        "outline": "#737686",
                        "surface-variant": "#e0e3e5",
                        "background": "#f7f9fb",
                        "on-secondary-container": "#3d4e84",
                        "on-surface-variant": "#434654"
                    },
                    borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
                },
            },
        }
    </script>
</head>
<body class="bg-surface text-on-surface antialiased min-h-screen">
<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r-0 bg-[#f7f9fb] dark:bg-slate-900 z-50">
<div class="flex flex-col h-full p-4 font-['Inter'] antialiased text-sm font-medium">
<div class="flex items-center gap-3 px-2 mb-8">
<img alt="Logo AcadÃ©mique LMD" class="rounded-lg" data-alt="Official academic institution circular logo emblem" src="https://lh3.googleusercontent.com/aida-public/AB6AXuAEPG-Buq6JdvhUA03LAmRgL4SswuPF3cQJp8Fnu83Kyv-kTElfsIQP-qoWERCrQWkkWnh9qPjk46OMlm-VnbMyMP-cSHfBdMzBF1gjjomr2rQ_kYvGshNKoZtb7M2KqCioRSWDaSPKzmXXaQd0UL7Ss8VBoztBQTtcY9xOdXZwNF0FtOBLhtJBGpgiD3mAIByFpyWIVjEyQc146rDMI3rcpdk8GrTxb658465o4dwRpPa0ZESqLIKBvd_ccrV3fWE0RYNMTV5is5o"/>
<div>
<h1 class="text-lg font-bold tracking-tight text-[#1A56DB]">Portail AcadÃ©mique</h1>
<p class="text-[10px] text-slate-500 uppercase tracking-wider">Gestion LMD - Administration</p>
</div>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl bg-white dark:bg-slate-800 text-[#1A56DB] dark:text-blue-400 font-semibold shadow-sm transition-transform active:scale-[0.98]" href="#">
<span class="material-symbols-outlined" data-icon="domain">domain</span>
<span>DÃ©partements</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-[#f2f4f6] dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
<span>FiliÃ¨res</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-[#f2f4f6] dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="library_books">library_books</span>
<span>UnitÃ©s d'Enseignement</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-[#f2f4f6] dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="menu_book">menu_book</span>
<span>Ã‰lÃ©ments Constitutifs</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-[#f2f4f6] dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="group">group</span>
<span>Ã‰tudiants</span>
</a>
</nav>
<button class="mt-4 flex items-center justify-center gap-2 bg-primary-container text-on-primary py-3 rounded-xl font-bold hover:opacity-90 transition-all active:scale-[0.98]">
<span class="material-symbols-outlined text-sm" data-icon="add">add</span>
                Nouvelle Saisie
            </button>
<div class="mt-auto pt-4 space-y-1 border-t border-surface-container">
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-[#f2f4f6] dark:hover:bg-slate-800 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
<span>ParamÃ¨tres</span>
</a>
<a class="flex items-center gap-3 px-4 py-3 rounded-xl text-error/80 hover:bg-error-container/20 transition-colors duration-200" href="#">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
<span>DÃ©connexion</span>
</a>
</div>
</div>
</aside>
<!-- Main Content Area -->
<main class="ml-64 min-h-screen">
<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-[#f2f4f6]/50 dark:border-slate-800 shadow-sm dark:shadow-none h-16 flex items-center justify-between px-8">
<div class="flex items-center gap-4">
<span class="text-xl font-black text-[#1A56DB] font-['Inter']">SystÃ¨me de Gestion AcadÃ©mique</span>
</div>
<div class="flex items-center gap-6">
<div class="relative flex items-center">
<span class="material-symbols-outlined absolute left-3 text-slate-400 text-lg" data-icon="search">search</span>
<input class="pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-primary/20" placeholder="Rechercher un dÃ©partement..." type="text"/>
</div>
<div class="flex items-center gap-3 border-l border-surface-container pl-6">
<button class="text-slate-500 hover:text-primary transition-colors"><span class="material-symbols-outlined" data-icon="notifications">notifications</span></button>
<button class="text-slate-500 hover:text-primary transition-colors"><span class="material-symbols-outlined" data-icon="help_outline">help_outline</span></button>
<div class="h-8 w-8 rounded-full overflow-hidden ml-2 ring-2 ring-primary/10">
<img alt="Avatar Administrateur" data-alt="Portrait of a professional academic administrator avatar" src="https://lh3.googleusercontent.com/aida-public/AB6AXuDCYH-GJVAGuPQBps5qF7H1rPjbMKB24bBObBYd7-PZPXVwwA-qLCccOcsjQ1LyKqYaMg7rLB91ObD-ZSRTXPsT5PWSKa0MeocUSVgmSjfNGUgwVwJgEhLfaMjAkqtAN1jwpxaw4sM3dwD3gUP60J12KgCCJd58TibbVaNxxCC2FEXJ9eQXCPcNJ-CjSbEKXKqAoT4WxkGI8OBnKbC7o9ZBzZkIKdHnsyT213Q7-SZ6tTI7QlL5Cb7j1i56Rw7TTSur0O97mdWg_WQ"/>
</div>
</div>
</div>
</header>
<!-- Page Content -->
<div class="pt-24 px-10 pb-12">
<div class="mb-10">
<h2 class="text-3xl font-extrabold tracking-tight text-on-surface">Configuration AcadÃ©mique</h2>
<p class="text-slate-500 mt-1">Structurez les dÃ©partements et leurs filiÃ¨res de formation associÃ©es.</p>
</div>
<!-- Grid Layout -->
<div class="grid grid-cols-12 gap-10 items-start">
<!-- Left: Entry Form -->
<div class="col-span-12 lg:col-span-5 sticky top-24">
<div class="bg-surface-container-lowest rounded-xl p-8 shadow-sm border border-outline-variant/10">
<div class="flex items-center gap-2 mb-6 text-primary">
<span class="material-symbols-outlined text-lg" data-icon="edit_square" data-weight="fill" style="font-variation-settings: 'FILL' 1;">edit_square</span>
<span class="text-xs font-bold uppercase tracking-widest">Saisie de DonnÃ©es</span>
</div>

<?php if ($message): ?>
<div class="mb-4 p-4 rounded-xl <?php echo ($type_message === 'success') ? 'bg-green-50 text-green-700' : 'bg-red-50 text-red-700'; ?>">
<p class="text-sm font-medium"><?php echo htmlspecialchars($message); ?></p>
</div>
<?php endif; ?>

<form method="POST" class="space-y-8">
<input type="hidden" name="action" value="create_dept"/>

<!-- Section DÃ©partement -->
<div>
<label for="nom_dept" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nom du DÃ©partement *</label>
<div class="relative">
<input id="nom_dept" name="nom_dept" class="w-full bg-surface-container-low border-none rounded-xl py-4 px-5 text-on-surface placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all text-sm font-medium" placeholder="ex: Informatique et Sciences NumÃ©riques" type="text" required/>
</div>
</div>

<div>
<label for="code_dept" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Code du DÃ©partement</label>
<div class="relative">
<input id="code_dept" name="code_dept" class="w-full bg-surface-container-low border-none rounded-xl py-4 px-5 text-on-surface placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all text-sm font-medium" placeholder="ex: DEPT-INFO" type="text"/>
</div>
</div>

<div>
<label for="chef_dept" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Chef de DÃ©partement</label>
<div class="relative">
<input id="chef_dept" name="chef_dept" class="w-full bg-surface-container-low border-none rounded-xl py-4 px-5 text-on-surface placeholder:text-slate-400 focus:bg-white focus:ring-2 focus:ring-primary/10 transition-all text-sm font-medium" placeholder="ex: Dr. Jean Dupont" type="text"/>
</div>
</div>

<!-- Section FiliÃ¨res Dynamiques -->
<div class="space-y-4">
<div class="flex items-center justify-between">
<label class="block text-xs font-bold text-slate-500 uppercase tracking-wider">FiliÃ¨res AssociÃ©es (Optionnel)</label>
<button type="button" class="add-filiere text-primary text-[11px] font-bold flex items-center gap-1 hover:underline">
<span class="material-symbols-outlined text-sm" data-icon="add_circle">add_circle</span>
AJOUTER UNE FILIÃˆRE
</button>
</div>
<div id="filieres-container" class="space-y-3">
<!-- FiliÃ¨re inputs dynamiques -->
</div>
</div>

<div class="pt-6 border-t border-surface-container">
<button class="w-full bg-primary text-white py-4 rounded-xl font-bold text-sm shadow-xl shadow-primary/20 hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-2" type="submit">
<span class="material-symbols-outlined text-lg" data-icon="save">save</span>
Enregistrer le DÃ©partement
</button>
</div>
</form>
</div>
<div class="mt-6 p-6 bg-secondary-fixed rounded-xl flex items-center gap-4">
<div class="h-10 w-10 bg-white rounded-full flex items-center justify-center text-primary shadow-sm">
<span class="material-symbols-outlined" data-icon="info">info</span>
</div>
<p class="text-xs font-medium text-on-secondary-fixed leading-relaxed">
Chaque dÃ©partement doit possÃ©der au moins une filiÃ¨re active pour Ãªtre Ã©ligible au paramÃ©trage des UE.
</p>
</div>
</div>
<!-- Right: List / Summary -->
<div class="col-span-12 lg:col-span-7 space-y-6">
<div class="flex items-center justify-between px-2">
<h3 class="text-lg font-bold text-on-surface">RÃ©pertoire des DÃ©partements (<?php echo count($departements); ?>)</h3>
<?php if (!empty($stats)): ?>
<div class="text-xs text-slate-500 space-x-3">
<span>ðŸ“Š <?php echo $stats['total_filieres'] ?? 0; ?> FiliÃ¨res</span>
<span>ðŸ‘¥ <?php echo $stats['total_etudiants'] ?? 0; ?> Ã‰tudiants</span>
</div>
<?php endif; ?>
</div>

<?php if (empty($departements)): ?>
<div class="bg-surface-container-low/20 rounded-xl border border-dashed border-outline-variant/60 p-10 flex flex-col items-center justify-center text-center opacity-60">
<div class="h-16 w-16 bg-surface-container rounded-full flex items-center justify-center mb-4">
<span class="material-symbols-outlined text-3xl text-slate-400" data-icon="school">school</span>
</div>
<h4 class="font-bold text-slate-500">Aucun DÃ©partement</h4>
<p class="text-xs text-slate-400 max-w-[240px] mt-1">Utilisez le formulaire Ã  gauche pour enregistrer le premier dÃ©partement de formation.</p>
</div>
<?php else: ?>
<?php foreach ($departements as $dept): ?>
<!-- Department Card -->
<div class="bg-surface-container-lowest rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow group">
<div class="p-6 flex items-center justify-between bg-surface-container-low/30">
<div class="flex items-center gap-4">
<div class="h-12 w-12 bg-primary/5 text-primary rounded-xl flex items-center justify-center">
<span class="material-symbols-outlined text-3xl" data-icon="school">school</span>
</div>
<div>
<h4 class="font-bold text-on-surface"><?php echo htmlspecialchars($dept['nom_dept']); ?></h4>
<p class="text-[11px] text-slate-500 uppercase tracking-tighter">
Code: <?php echo htmlspecialchars($dept['code_dept'] ?? 'N/A'); ?> | 
Chef: <?php echo htmlspecialchars($dept['chef_dept'] ?? 'N/A'); ?>
</p>
</div>
</div>
<div class="flex items-center gap-2">
<button class="edit-dept h-8 w-8 flex items-center justify-center rounded-lg hover:bg-white text-slate-400 hover:text-primary transition-all" data-id="<?php echo $dept['id_dept']; ?>" title="Modifier">
<span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
</button>
<button class="delete-dept h-8 w-8 flex items-center justify-center rounded-lg hover:bg-white text-slate-400 hover:text-error transition-all" data-id="<?php echo $dept['id_dept']; ?>" title="Supprimer" onclick="return confirm('ÃŠtes-vous sÃ»r?');">
<span class="material-symbols-outlined text-lg" data-icon="delete_forever">delete_forever</span>
</button>
</div>
</div>

<?php if (isset($dept['filieres']) && !empty($dept['filieres'])): ?>
<div class="p-6">
<div class="grid grid-cols-2 gap-3">
<?php foreach ($dept['filieres'] as $filiere): ?>
<div class="p-3 bg-surface rounded-lg flex items-center justify-between group/item">
<span class="text-sm font-medium text-slate-700"><?php echo htmlspecialchars($filiere['nom_filiere']); ?></span>
<span class="px-2 py-0.5 bg-secondary-container text-on-secondary-container text-[10px] font-bold rounded-full uppercase tracking-tighter"><?php echo htmlspecialchars($filiere['niveau'] ?? 'Licence'); ?></span>
</div>
<?php endforeach; ?>
</div>
</div>
<?php endif; ?>
</div>
<?php endforeach; ?>
<?php endif; ?>
</main>
</body></html>
