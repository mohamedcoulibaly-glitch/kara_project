<?php
// gestion_filieres_ue.php
// Ce fichier gÃ¨re l'affichage et l'association des filiÃ¨res avec les unitÃ©s d'enseignement

// Configuration de la base de donnÃ©es
$host = 'localhost';
$dbname = 'gestion_notes';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Initialisation des variables
$filiere_selectionnee = isset($_POST['id_filiere']) ? $_POST['id_filiere'] : (isset($_GET['id_filiere']) ? $_GET['id_filiere'] : null);
$semestre_selectionne = isset($_POST['semestre']) ? $_POST['semestre'] : (isset($_GET['semestre']) ? $_GET['semestre'] : 1);

// Traitement de l'enregistrement du programme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enregistrer_programme') {
    $id_filiere = $_POST['id_filiere'];
    $semestre = $_POST['semestre'];
    $ue_selectionnees = isset($_POST['ue_selectionnees']) ? $_POST['ue_selectionnees'] : [];
    
    try {
        // Supprimer les associations existantes pour cette filiÃ¨re et ce semestre
        $sql = "DELETE FROM programme WHERE id_filiere = :id_filiere AND semestre = :semestre";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_filiere' => $id_filiere,
            ':semestre' => $semestre
        ]);
        
        // InsÃ©rer les nouvelles associations
        $sql = "INSERT INTO programme (id_filiere, id_ue, semestre) VALUES (:id_filiere, :id_ue, :semestre)";
        $stmt = $pdo->prepare($sql);
        
        foreach ($ue_selectionnees as $id_ue) {
            $stmt->execute([
                ':id_filiere' => $id_filiere,
                ':id_ue' => $id_ue,
                ':semestre' => $semestre
            ]);
        }
        
        $message_success = "Programme enregistrÃ© avec succÃ¨s !";
    } catch(PDOException $e) {
        $message_error = "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}

// RÃ©cupÃ©ration des filiÃ¨res avec leurs dÃ©partements
$sql = "SELECT f.id_filiere, f.nom_filiere, d.nom_dept 
        FROM filiere f 
        LEFT JOIN departement d ON f.id_dept = d.id_dept 
        ORDER BY f.nom_filiere";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$filieres = $stmt->fetchAll(PDO::FETCH_ASSOC);

// RÃ©cupÃ©ration des unitÃ©s d'enseignement disponibles
$sql = "SELECT id_ue, code_ue, libelle_ue, credits_ects FROM ue ORDER BY code_ue";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$ues = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si une filiÃ¨re est sÃ©lectionnÃ©e, rÃ©cupÃ©rer les UE dÃ©jÃ  associÃ©es pour chaque semestre
$ue_associees_par_semestre = [];
if ($filiere_selectionnee) {
    $sql = "SELECT id_ue, semestre FROM programme WHERE id_filiere = :id_filiere";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_filiere' => $filiere_selectionnee]);
    $programmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    foreach ($programmes as $programme) {
        $ue_associees_par_semestre[$programme['semestre']][] = $programme['id_ue'];
    }
}

// RÃ©cupÃ©ration des UE associÃ©es au semestre sÃ©lectionnÃ© pour la visualisation
$programme_visualisation = [];
if ($filiere_selectionnee) {
    $sql = "SELECT ue.id_ue, ue.code_ue, ue.libelle_ue, ue.credits_ects, p.semestre 
            FROM programme p 
            JOIN ue ON p.id_ue = ue.id_ue 
            WHERE p.id_filiere = :id_filiere 
            ORDER BY p.semestre, ue.code_ue";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_filiere' => $filiere_selectionnee]);
    $programme_visualisation = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Regrouper par semestre pour la visualisation
$ue_par_semestre = [];
foreach ($programme_visualisation as $item) {
    $ue_par_semestre[$item['semestre']][] = $item;
}
?>















<!DOCTYPE html>

<html class="light" lang="fr"><head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1.0" name="viewport"/>
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
            fontFamily: {
              "headline": ["Inter"],
              "body": ["Inter"],
              "label": ["Inter"]
            },
            borderRadius: {"DEFAULT": "0.125rem", "lg": "0.25rem", "xl": "0.5rem", "full": "0.75rem"},
          },
        },
      }
    </script>
<style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        body { font-family: 'Inter', sans-serif; }
        .glass-panel {
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.8);
        }
        .hide-scrollbar::-webkit-scrollbar { display: none; }
    </style>
</head>
<body class="bg-surface text-on-surface antialiased">
<!-- SideNavBar Anchor -->
<aside class="h-screen w-64 fixed left-0 top-0 border-r-0 bg-[#f7f9fb] dark:bg-slate-900 flex flex-col p-4 z-50">
<div class="mb-8 px-2">
<h1 class="text-lg font-bold tracking-tight text-[#1A56DB] flex items-center gap-2">
<span class="material-symbols-outlined" data-icon="account_balance">account_balance</span>
                Portail AcadÃ©mique
            </h1>
<p class="text-xs text-slate-500 font-medium mt-1">Gestion LMD - Administration</p>
</div>
<nav class="flex-1 space-y-1">
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="domain">domain</span>
                DÃ©partements
            </a>
<a class="flex items-center gap-3 px-3 py-2 bg-white text-[#1A56DB] font-semibold shadow-sm transition-transform active:scale-[0.98] text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="account_tree">account_tree</span>
                FiliÃ¨res
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="library_books">library_books</span>
                UnitÃ©s d'Enseignement
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="menu_book">menu_book</span>
                Ã‰lÃ©ments Constitutifs
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] transition-colors duration-200 font-medium text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="group">group</span>
                Ã‰tudiants
            </a>
</nav>
<button class="mt-4 w-full bg-[#1A56DB] text-white py-2.5 rounded-lg font-semibold text-sm shadow-md hover:bg-[#003fb1] transition-all flex items-center justify-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="add">add</span>
            Nouvelle Saisie
        </button>
<div class="mt-auto pt-4 border-t border-[#f2f4f6] space-y-1">
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="settings">settings</span>
                ParamÃ¨tres
            </a>
<a class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:text-[#1A56DB] hover:bg-[#f2f4f6] text-sm rounded-lg" href="#">
<span class="material-symbols-outlined" data-icon="logout">logout</span>
                DÃ©connexion
            </a>
</div>
</aside>
<!-- TopAppBar Anchor -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-white/80 backdrop-blur-md flex items-center justify-between px-8 h-16 border-b border-[#f2f4f6]/50 shadow-sm">
<h2 class="text-xl font-black text-[#1A56DB] tracking-tight">SystÃ¨me de Gestion AcadÃ©mique</h2>
<div class="flex items-center gap-6">
<div class="relative group">
<span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
<span class="material-symbols-outlined text-lg" data-icon="search">search</span>
</span>
<input class="pl-10 pr-4 py-1.5 bg-surface-container-low border-none rounded-full text-sm w-64 focus:ring-2 focus:ring-[#1A56DB]/20 transition-all" placeholder="Rechercher une filiÃ¨re..." type="text"/>
</div>
<div class="flex items-center gap-4 text-slate-500">
<button class="hover:bg-slate-50 p-1.5 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="notifications">notifications</span>
</button>
<button class="hover:bg-slate-50 p-1.5 rounded-full transition-colors active:opacity-80">
<span class="material-symbols-outlined" data-icon="help_outline">help_outline</span>
</button>
<div class="h-8 w-8 rounded-full bg-secondary-container overflow-hidden ring-2 ring-white">
<img alt="Avatar Administrateur" class="h-full w-full object-cover" data-alt="Portrait image of a professional administrator" src="https://lh3.googleusercontent.com/aida-public/AB6AXuC3_f_Br9RhLJRBraDU6gXth-nX4e2fUxeGZNHbdBzglDw_XHlTsIHuQjSXnWvWtTTXe2k1Z7eAhbUyyPv_GU3ZGiIMnaRszEwzYQateEnEB_If-SvNx1aEZSPNQLvLn8MkLdlUhapdDlbHOa1ZhvGTOFkw0b5XyPIKcFlsMvSkGF1RcpFaA-331y_2jLwXKmsCluT1hDpKF6Sh9VyagTGeT9hHvNHMPRUNJoUSVEBglPwG3Dy-DHNp0uxXCTCwe-Xt5HWUeKKELF8"/>
</div>
</div>
</div>
</header>
<!-- Main Content Canvas -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
<div class="max-w-7xl mx-auto space-y-8">
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
<div>
<span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">Programme de liaison</span>
<h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Association FiliÃ¨re &amp; UnitÃ©s d'Enseignement</h3>
<p class="text-slate-500 mt-1 max-w-2xl">Configurez le cursus acadÃ©mique en associant les UE aux filiÃ¨res correspondantes par semestre.</p>
</div>
<div class="flex items-center gap-2">
<button class="px-5 py-2.5 bg-white border border-outline-variant/30 text-slate-700 font-semibold text-sm rounded-md shadow-sm hover:bg-slate-50 transition-all">
                        Annuler les modifications
                    </button>
<button class="px-5 py-2.5 bg-primary text-white font-semibold text-sm rounded-md shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
<span class="material-symbols-outlined text-sm" data-icon="save">save</span>
                        Enregistrer le Programme
                    </button>
</div>
</div>
<!-- Main Interactive Area: Asymmetric Layout -->
<div class="grid grid-cols-12 gap-8">
<!-- Left Column: Selection Focus (FiliÃ¨re & Semestre) -->
<div class="col-span-12 lg:col-span-4 space-y-6">
<!-- FiliÃ¨re Selection Card -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<label class="block text-sm font-bold text-slate-800 mb-4">SÃ©lectionner une FiliÃ¨re</label>
<div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 hide-scrollbar">
<div class="p-3 bg-primary-fixed-dim/20 border-2 border-primary rounded-lg cursor-pointer transition-all">
<div class="flex items-center justify-between">
<span class="font-bold text-primary text-sm">GÃ©nie Logiciel (GL)</span>
<span class="material-symbols-outlined text-primary text-lg" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
</div>
<p class="text-xs text-on-primary-fixed-variant mt-1">DÃ©partement d'Informatique</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">RÃ©seaux &amp; TÃ©lÃ©coms</span>
<span class="text-slate-300 text-xs">RT</span>
</div>
<p class="text-xs text-slate-400 mt-1">DÃ©partement d'Informatique</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">Banque &amp; Finance</span>
<span class="text-slate-300 text-xs">BF</span>
</div>
<p class="text-xs text-slate-400 mt-1">DÃ©partement de Gestion</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">ComptabilitÃ© &amp; Audit</span>
<span class="text-slate-300 text-xs">CA</span>
</div>
<p class="text-xs text-slate-400 mt-1">DÃ©partement de Gestion</p>
</div>
</div>
</div>
<!-- Semestre Toggle Selection -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<label class="block text-sm font-bold text-slate-800 mb-4">Choisir le Semestre</label>
<div class="grid grid-cols-3 gap-2">
<button class="py-3 rounded-lg border-2 border-primary bg-primary/5 text-primary font-bold text-sm transition-all">S1</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S2</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S3</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S4</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S5</button>
<button class="py-3 rounded-lg border border-outline-variant/30 hover:bg-surface-container-low text-slate-600 font-semibold text-sm transition-all">S6</button>
</div>
</div>
</div>
<!-- Right Column: UE Selection Grid -->
<div class="col-span-12 lg:col-span-8 space-y-6">
<div class="bg-surface-container-lowest p-8 rounded-xl shadow-sm border border-outline-variant/10">
<div class="flex items-center justify-between mb-8">
<div>
<h4 class="text-lg font-bold text-slate-900">UnitÃ©s d'Enseignement Disponibles</h4>
<p class="text-sm text-slate-500">Cochez les UE Ã  inclure pour le semestre S1 en GÃ©nie Logiciel.</p>
</div>
<div class="flex items-center gap-3">
<span class="text-xs font-bold text-slate-400 px-3 py-1 bg-surface-container rounded-full">12 UE Total</span>
<span class="text-xs font-bold text-primary px-3 py-1 bg-primary-container/20 rounded-full">4 UE SÃ©lectionnÃ©es</span>
</div>
</div>
<!-- Search & Filter Bar for UE -->
<div class="flex gap-4 mb-6">
<div class="flex-1 relative">
<span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
<span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
</span>
<input class="w-full pl-9 pr-4 py-2 bg-surface border-transparent rounded-md text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="Filtrer par code ou intitulÃ©..." type="text"/>
</div>
<select class="bg-surface border-transparent rounded-md text-sm px-4 py-2 text-slate-600 focus:ring-0">
<option>Toutes les catÃ©gories</option>
<option>Fondamentale</option>
<option>Transversale</option>
<option>Optionnelle</option>
</select>
</div>
<!-- UE Grid (Bento Style Selection Cards) -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF101 â€¢ 6 CrÃ©dits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Algorithmique et Structures de DonnÃ©es</h5>
<p class="text-xs text-slate-500 mt-1">Introduction aux structures linÃ©aires et arbres.</p>
</div>
</div>
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF102 â€¢ 4 CrÃ©dits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Architecture des Ordinateurs</h5>
<p class="text-xs text-slate-500 mt-1">Logique boolÃ©enne et organisation CPU.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">MAT101 â€¢ 5 CrÃ©dits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Analyse MathÃ©matique I</h5>
<p class="text-xs text-slate-400 mt-1">Fonctions rÃ©elles et calcul intÃ©gral.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">ANG101 â€¢ 2 CrÃ©dits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Anglais Technique I</h5>
<p class="text-xs text-slate-400 mt-1">Vocabulaire informatique et communication.</p>
</div>
</div>
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF103 â€¢ 6 CrÃ©dits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">SystÃ¨mes d'Exploitation I</h5>
<p class="text-xs text-slate-500 mt-1">Gestion des processus et mÃ©moire vive.</p>
</div>
</div>
<!-- UE Card Selected -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-primary-container/5 border-2 border-primary/40 flex gap-4 hover:border-primary transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-primary bg-primary flex items-center justify-center">
<span class="material-symbols-outlined text-white text-[14px] font-bold" data-icon="check">check</span>
</div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF104 â€¢ 3 CrÃ©dits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Outils Bureautiques AvancÃ©s</h5>
<p class="text-xs text-slate-500 mt-1">MaÃ®trise de LaTeX et scripts automatisÃ©s.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">DRO101 â€¢ 3 CrÃ©dits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Droit du NumÃ©rique</h5>
<p class="text-xs text-slate-400 mt-1">RGPD et propriÃ©tÃ© intellectuelle.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">PHY101 â€¢ 4 CrÃ©dits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Ã‰lectronique Fondamentale</h5>
<p class="text-xs text-slate-400 mt-1">Circuits passifs et semi-conducteurs.</p>
</div>
</div>
</div>
<!-- Summary Floating Zone -->
<div class="mt-12 p-4 bg-surface-container-low rounded-lg flex items-center justify-between border-l-4 border-primary">
<div class="flex items-center gap-6">
<div>
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">CrÃ©dits Totaux</p>
<p class="text-xl font-black text-primary">19 / 30</p>
</div>
<div class="h-10 w-px bg-outline-variant/30"></div>
<div>
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">UE Fondamentales</p>
<p class="text-xl font-black text-slate-800">3</p>
</div>
<div class="h-10 w-px bg-outline-variant/30"></div>
<div>
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">UE Transversales</p>
<p class="text-xl font-black text-slate-800">1</p>
</div>
</div>
<div class="text-right">
<p class="text-xs font-semibold text-slate-500">Statut du Semestre</p>
<span class="inline-block mt-1 px-3 py-1 bg-tertiary-container text-on-tertiary-container rounded-full text-[10px] font-black uppercase tracking-wider">Incomplet</span>
</div>
</div>
</div>
</div>
</div>
<!-- Quick View Section -->
<section class="bg-surface-container p-8 rounded-xl">
<div class="flex items-center gap-3 mb-6">
<span class="material-symbols-outlined text-secondary" data-icon="auto_awesome">auto_awesome</span>
<h4 class="text-lg font-bold text-on-surface">Visualisation de la Maquette AcadÃ©mique</h4>
</div>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
<div class="bg-white p-5 rounded-lg border border-outline-variant/20">
<h5 class="text-sm font-bold text-slate-800 mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-xs text-primary" data-icon="circle" style="font-variation-settings: 'FILL' 1;">circle</span>
                            Semestre 1
                        </h5>
<ul class="space-y-2">
<li class="text-xs text-slate-600 flex justify-between"><span>INF101 Algorithmique</span> <span class="font-bold">6</span></li>
<li class="text-xs text-slate-600 flex justify-between"><span>INF102 Architecture</span> <span class="font-bold">4</span></li>
<li class="text-xs text-slate-600 flex justify-between"><span>INF103 SystÃ¨mes d'Exploitation</span> <span class="font-bold">6</span></li>
</ul>
</div>
<div class="bg-white/50 p-5 rounded-lg border border-dashed border-outline-variant">
<h5 class="text-sm font-bold text-slate-400 mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-xs text-slate-300" data-icon="circle">circle</span>
                            Semestre 2
                        </h5>
<p class="text-center text-xs text-slate-400 py-4 italic">Aucune UE associÃ©e</p>
</div>
<div class="bg-white/50 p-5 rounded-lg border border-dashed border-outline-variant">
<h5 class="text-sm font-bold text-slate-400 mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-xs text-slate-300" data-icon="circle">circle</span>
                            Semestre 3
                        </h5>
<p class="text-center text-xs text-slate-400 py-4 italic">Configuration en attente</p>
</div>
</div>
</section>
</div>
</main>
<!-- FAB Suppression Rule Applied (Not present as this is a focused management screen) -->
</body></html>
