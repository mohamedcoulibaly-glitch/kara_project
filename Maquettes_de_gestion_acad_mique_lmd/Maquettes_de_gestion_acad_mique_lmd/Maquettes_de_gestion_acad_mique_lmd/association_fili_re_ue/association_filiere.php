<?php
// gestion_filieres_ue.php
// Ce fichier gère l'affichage et l'association des filières avec les unités d'enseignement

require_once __DIR__ . '/../../../../config/config.php';
require_once __DIR__ . '/../../../../backend/classes/DataManager.php';

$db = getDB();

// Initialisation des variables
$filiere_selectionnee = isset($_POST['id_filiere']) ? $_POST['id_filiere'] : (isset($_GET['id_filiere']) ? $_GET['id_filiere'] : null);
$semestre_selectionne = isset($_POST['semestre']) ? $_POST['semestre'] : (isset($_GET['semestre']) ? $_GET['semestre'] : 1);

// Traitement de l'enregistrement du programme
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'enregistrer_programme') {
    $id_filiere = $_POST['id_filiere'];
    $semestre = $_POST['semestre'];
    $ue_selectionnees = isset($_POST['ue_selectionnees']) ? $_POST['ue_selectionnees'] : [];
    
    // Utiliser une transaction
    $db->begin_transaction();
    try {
        // Supprimer les associations existantes pour cette filière et ce semestre
        $sql = "DELETE FROM programme WHERE id_filiere = ? AND semestre = ?";
        $stmt = $db->prepare($sql);
        $stmt->bind_param("ii", $id_filiere, $semestre);
        $stmt->execute();
        
        // Insérer les nouvelles associations
        $sql = "INSERT INTO programme (id_filiere, id_ue, semestre) VALUES (?, ?, ?)";
        $stmt = $db->prepare($sql);
        
        foreach ($ue_selectionnees as $id_ue) {
            $stmt->bind_param("iii", $id_filiere, $id_ue, $semestre);
            $stmt->execute();
        }
        
        $db->commit();
        $message_success = "Programme enregistré avec succès !";
    } catch(Exception $e) {
        $db->rollback();
        $message_error = "Erreur lors de l'enregistrement : " . $e->getMessage();
    }
}

// Récupération des filières avec leurs départements
$sql = "SELECT f.id_filiere, f.nom_filiere, d.nom_dept 
        FROM filiere f 
        LEFT JOIN departement d ON f.id_dept = d.id_dept 
        ORDER BY f.nom_filiere";
$res = $db->query($sql);
$filieres = $res->fetch_all(MYSQLI_ASSOC);

// Récupération des unités d'enseignement disponibles
$sql = "SELECT id_ue, code_ue, libelle_ue, credits_ects FROM ue ORDER BY code_ue";
$res = $db->query($sql);
$ues = $res->fetch_all(MYSQLI_ASSOC);

// Si une filière est sélectionnée, récupérer les UE déjà associées pour chaque semestre
$ue_associees_par_semestre = [];
if ($filiere_selectionnee) {
    $sql = "SELECT id_ue, semestre FROM programme WHERE id_filiere = ?";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $filiere_selectionnee);
    $stmt->execute();
    $programmes = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    
    foreach ($programmes as $programme) {
        $ue_associees_par_semestre[$programme['semestre']][] = $programme['id_ue'];
    }
}

// Récupération des UE associées au semestre sélectionné pour la visualisation
$programme_visualisation = [];
if ($filiere_selectionnee) {
    $sql = "SELECT ue.id_ue, ue.code_ue, ue.libelle_ue, ue.credits_ects, p.semestre 
            FROM programme p 
            JOIN ue ON p.id_ue = ue.id_ue 
            WHERE p.id_filiere = ? 
            ORDER BY p.semestre, ue.code_ue";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("i", $filiere_selectionnee);
    $stmt->execute();
    $programme_visualisation = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Regrouper par semestre pour la visualisation
$ue_par_semestre = [];
foreach ($programme_visualisation as $item) {
    $ue_par_semestre[$item['semestre']][] = $item;
}

$page_title = 'Association Filière & UE';
$current_page = 'ue_ec';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">ss="ml-64 pt-24 pb-12 px-8 min-h-screen">
<div class="max-w-7xl mx-auto space-y-8">
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
<div>
<span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">Programme de liaison</span>
<h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Association Filière &amp; Unités d'Enseignement</h3>
<p class="text-slate-500 mt-1 max-w-2xl">Configurez le cursus académique en associant les UE aux filières correspondantes par semestre.</p>
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
<!-- Left Column: Selection Focus (Filière & Semestre) -->
<div class="col-span-12 lg:col-span-4 space-y-6">
<!-- Filière Selection Card -->
<div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10">
<label class="block text-sm font-bold text-slate-800 mb-4">Sélectionner une Filière</label>
<div class="space-y-2 max-h-[400px] overflow-y-auto pr-2 hide-scrollbar">
<div class="p-3 bg-primary-fixed-dim/20 border-2 border-primary rounded-lg cursor-pointer transition-all">
<div class="flex items-center justify-between">
<span class="font-bold text-primary text-sm">Génie Logiciel (GL)</span>
<span class="material-symbols-outlined text-primary text-lg" data-icon="check_circle" style="font-variation-settings: 'FILL' 1;">check_circle</span>
</div>
<p class="text-xs text-on-primary-fixed-variant mt-1">Département d'Informatique</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">Réseaux &amp; Télécoms</span>
<span class="text-slate-300 text-xs">RT</span>
</div>
<p class="text-xs text-slate-400 mt-1">Département d'Informatique</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">Banque &amp; Finance</span>
<span class="text-slate-300 text-xs">BF</span>
</div>
<p class="text-xs text-slate-400 mt-1">Département de Gestion</p>
</div>
<div class="p-3 bg-surface hover:bg-surface-container-low rounded-lg cursor-pointer transition-all border border-transparent">
<div class="flex items-center justify-between">
<span class="font-semibold text-slate-700 text-sm">Comptabilité &amp; Audit</span>
<span class="text-slate-300 text-xs">CA</span>
</div>
<p class="text-xs text-slate-400 mt-1">Département de Gestion</p>
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
<h4 class="text-lg font-bold text-slate-900">Unités d'Enseignement Disponibles</h4>
<p class="text-sm text-slate-500">Cochez les UE ô  inclure pour le semestre S1 en Génie Logiciel.</p>
</div>
<div class="flex items-center gap-3">
<span class="text-xs font-bold text-slate-400 px-3 py-1 bg-surface-container rounded-full">12 UE Total</span>
<span class="text-xs font-bold text-primary px-3 py-1 bg-primary-container/20 rounded-full">4 UE Sélectionnées</span>
</div>
</div>
<!-- Search & Filter Bar for UE -->
<div class="flex gap-4 mb-6">
<div class="flex-1 relative">
<span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
<span class="material-symbols-outlined text-sm" data-icon="filter_list">filter_list</span>
</span>
<input class="w-full pl-9 pr-4 py-2 bg-surface border-transparent rounded-md text-sm focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all" placeholder="Filtrer par code ou intitulé..." type="text"/>
</div>
<select class="bg-surface border-transparent rounded-md text-sm px-4 py-2 text-slate-600 focus:ring-0">
<option>Toutes les catégories</option>
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
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF101 â€¢ 6 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Algorithmique et Structures de Données</h5>
<p class="text-xs text-slate-500 mt-1">Introduction aux structures linéaires et arbres.</p>
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
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF102 â€¢ 4 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Architecture des Ordinateurs</h5>
<p class="text-xs text-slate-500 mt-1">Logique booléenne et organisation CPU.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">MAT101 â€¢ 5 Crédits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Analyse Mathématique I</h5>
<p class="text-xs text-slate-400 mt-1">Fonctions réelles et calcul intégral.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">ANG101 â€¢ 2 Crédits</span>
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
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF103 â€¢ 6 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Systèmes d'Exploitation I</h5>
<p class="text-xs text-slate-500 mt-1">Gestion des processus et mémoire vive.</p>
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
<span class="text-[10px] font-black uppercase text-primary-container tracking-tighter">INF104 â€¢ 3 Crédits</span>
<span class="bg-secondary-container text-on-secondary-container text-[9px] px-2 py-0.5 rounded-full font-bold">VALIDE</span>
</div>
<h5 class="text-sm font-bold text-slate-800 mt-1">Outils Bureautiques Avancés</h5>
<p class="text-xs text-slate-500 mt-1">Maîtrise de LaTeX et scripts automatisés.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">DRO101 â€¢ 3 Crédits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Droit du Numérique</h5>
<p class="text-xs text-slate-400 mt-1">RGPD et propriété intellectuelle.</p>
</div>
</div>
<!-- UE Card Default -->
<div class="relative group cursor-pointer p-4 rounded-lg bg-surface border border-outline-variant/20 flex gap-4 hover:bg-surface-container-low transition-all">
<div class="mt-1">
<div class="w-5 h-5 rounded border-2 border-outline-variant bg-white group-hover:border-primary transition-colors"></div>
</div>
<div class="flex-1">
<div class="flex justify-between items-start">
<span class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">PHY101 â€¢ 4 Crédits</span>
</div>
<h5 class="text-sm font-bold text-slate-700 mt-1">Électronique Fondamentale</h5>
<p class="text-xs text-slate-400 mt-1">Circuits passifs et semi-conducteurs.</p>
</div>
</div>
</div>
<!-- Summary Floating Zone -->
<div class="mt-12 p-4 bg-surface-container-low rounded-lg flex items-center justify-between border-l-4 border-primary">
<div class="flex items-center gap-6">
<div>
<p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Crédits Totaux</p>
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
<h4 class="text-lg font-bold text-on-surface">Visualisation de la Maquette Académique</h4>
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
<li class="text-xs text-slate-600 flex justify-between"><span>INF103 Systèmes d'Exploitation</span> <span class="font-bold">6</span></li>
</ul>
</div>
<div class="bg-white/50 p-5 rounded-lg border border-dashed border-outline-variant">
<h5 class="text-sm font-bold text-slate-400 mb-3 flex items-center gap-2">
<span class="material-symbols-outlined text-xs text-slate-300" data-icon="circle">circle</span>
                            Semestre 2
                        </h5>
<p class="text-center text-xs text-slate-400 py-4 italic">Aucune UE associée</p>
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
