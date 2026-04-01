<?php
/**
 * ====================================================
 * BACKEND: Saisie des Notes - Moyennes
 * ====================================================
 * Permet de saisir les notes moyennes par UE/EC
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$db = getDB();
$message = '';
$type_message = '';

// Récupérer les filières
$query = "SELECT id_filiere, nom_filiere FROM filiere ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$filieres = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $filieres = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Récupérer les UE/EC si filière sélectionnée
$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$id_ue = isset($_GET['ue']) ? (int)$_GET['ue'] : 0;
$unites = [];
$elements = [];

if ($id_filiere) {
    // Récupérer les UE pour la filière
    $query = "SELECT DISTINCT ue.id_ue, ue.code_ue, ue.libelle_ue 
              FROM ue ue
              JOIN programme p ON ue.id_ue = p.id_ue
              WHERE p.id_filiere = ?
              ORDER BY ue.code_ue";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $unites = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

if ($id_ue) {
    // Récupérer les EC pour l'UE
    $query = "SELECT id_ec, code_ec, nom_ec, coefficient FROM ec WHERE id_ue = ? ORDER BY code_ec";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_ue);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $elements = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

// Récupérer les notes à saisir
$notes_saisies = [];
$etudiants = [];

if ($id_ue) {
    $query = "SELECT DISTINCT e.id_etudiant, e.matricule, e.nom, e.prenom, f.nom_filiere
              FROM etudiant e
              LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
              WHERE e.id_filiere = ? AND e.statut = 'Actif'
              ORDER BY e.nom, e.prenom";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $etudiants = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
    
    // Récupérer les notes existantes
    $query = "SELECT n.id_note, n.id_etudiant, n.id_ec, n.valeur_note, n.session
              FROM note n
              WHERE n.id_ec IN (SELECT id_ec FROM ec WHERE id_ue = ?)
              AND n.session = 'Normale'";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_ue);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $notes_saisies = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

// Traiter l'enregistrement des notes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_notes') {
    $enregistrements = 0;
    $erreurs = 0;
    
    // Récupérer les notes POST
    if (isset($_POST['notes']) && is_array($_POST['notes'])) {
        foreach ($_POST['notes'] as $etudiant_id => $ecs) {
            foreach ($ecs as $ec_id => $valeur_note) {
                if ($valeur_note !== '' && $valeur_note >= 0 && $valeur_note <= 20) {
                    $etudiant_id = (int)$etudiant_id;
                    $ec_id = (int)$ec_id;
                    $valeur_note = (float)$valeur_note;
                    
                    // Vérifier si la note existe déjà
                    $check_query = "SELECT id_note FROM note WHERE id_etudiant = ? AND id_ec = ? AND session = 'Normale'";
                    $check_stmt = $db->prepare($check_query);
                    $check_stmt->bind_param("ii", $etudiant_id, $ec_id);
                    if ($check_stmt->execute()) {
                        $result = $check_stmt->get_result();
                        $existing = $result->fetch_assoc();
                        
                        if ($existing) {
                            // Mettre à jour
                            $update_query = "UPDATE note SET valeur_note = ?, date_modification = NOW() 
                                           WHERE id_etudiant = ? AND id_ec = ? AND session = 'Normale'";
                            $update_stmt = $db->prepare($update_query);
                            $update_stmt->bind_param("dii", $valeur_note, $etudiant_id, $ec_id);
                            if ($update_stmt->execute()) {
                                $enregistrements++;
                            } else {
                                $erreurs++;
                            }
                        } else {
                            // Insérer
                            $insert_query = "INSERT INTO note (id_etudiant, id_ec, valeur_note, session, date_examen)
                                           VALUES (?, ?, ?, 'Normale', NOW())";
                            $insert_stmt = $db->prepare($insert_query);
                            $insert_stmt->bind_param("iid", $etudiant_id, $ec_id, $valeur_note);
                            if ($insert_stmt->execute()) {
                                $enregistrements++;
                            } else {
                                $erreurs++;
                            }
                        }
                    }
                }
            }
        }
    }
    
    if ($enregistrements > 0) {
        $message = "$enregistrements note(s) enregistrée(s) avec succès";
        $type_message = 'success';
    } elseif ($erreurs > 0) {
        $message = "Erreur lors de l'enregistrement de " . $erreurs . " note(s)";
        $type_message = 'error';
    } else {
        $message = 'Aucune note à enregistrer';
        $type_message = 'info';
    }
}

?>
<!DOCTYPE html>
<html class="light" lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie des Notes - Gestion Académique LMD</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-surface text-on-surface min-h-screen">

<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-surface-container-lowest flex flex-col p-4 z-50">
    <div class="mb-8 px-2">
        <h1 class="text-lg font-bold text-primary">Portail Académique</h1>
        <p class="text-xs text-slate-500">Gestion LMD v2.0</p>
    </div>
    <nav class="flex-1 space-y-1">
        <a href="../../index.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>
        <a href="saisie_deprtement_backend.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">domain</span>
            <span class="text-sm">Départements</span>
        </a>
        <a href="saisie_notes_moyennes_backend.php" class="flex items-center gap-3 px-3 py-2 bg-white text-primary shadow-sm rounded-lg">
            <span class="material-symbols-outlined">edit_note</span>
            <span class="text-sm">Notes</span>
        </a>
    </nav>
</aside>

<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-md z-40 flex items-center px-8">
    <h2 class="text-xl font-bold text-primary">Saisie des Notes</h2>
</header>

<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
    <div class="max-w-6xl mx-auto">
        
        <!-- Message -->
        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?php echo $type_message === 'success' ? 'bg-green-50 text-green-800' : ($type_message === 'error' ? 'bg-red-50 text-red-800' : 'bg-blue-50 text-blue-800'); ?>">
            <div class="flex items-center gap-2">
                <span class="material-symbols-outlined"><?php echo $type_message === 'success' ? 'check_circle' : 'info'; ?></span>
                <span><?php echo htmlspecialchars($message); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold mb-2">Saisie des Notes</h1>
            <p class="text-slate-600">Évaluation continue et examen final</p>
        </div>

        <!-- Filters -->
        <div class="bg-surface-container-low p-6 rounded-xl mb-8 space-y-6">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2">Filière</label>
                    <select name="filiere" onchange="this.form.submit()" class="w-full bg-white border rounded-lg px-4 py-2">
                        <option value="">-- Sélectionner une filière --</option>
                        <?php foreach ($filieres as $fil): ?>
                        <option value="<?php echo $fil['id_filiere']; ?>" <?php echo $id_filiere == $fil['id_filiere'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($fil['nom_filiere']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2">Unité d'Enseignement</label>
                    <select name="ue" onchange="this.form.submit()" class="w-full bg-white border rounded-lg px-4 py-2" <?php echo empty($unites) ? 'disabled' : ''; ?>>
                        <option value="">-- Sélectionner une UE --</option>
                        <?php foreach ($unites as $u): ?>
                        <option value="<?php echo $u['id_ue']; ?>" <?php echo $id_ue == $u['id_ue'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($u['code_ue']) . ' - ' . htmlspecialchars($u['libelle_ue']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider mb-2">Session</label>
                    <select class="w-full bg-white border rounded-lg px-4 py-2">
                        <option>Normale</option>
                        <option>Rattrapage</option>
                    </select>
                </div>
            </form>
        </div>

        <!-- Notes Grid -->
        <?php if ($id_ue && count($etudiants) > 0): ?>
        <form method="POST" class="bg-white rounded-xl overflow-hidden shadow-sm">
            <input type="hidden" name="action" value="save_notes">
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-surface-container-low">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase">Matricule</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase">Nom & Prénom</th>
                            <?php foreach ($elements as $elem): ?>
                            <th class="px-6 py-4 text-center text-xs font-bold uppercase">
                                <?php echo htmlspecialchars($elem['code_ec']); ?><br>
                                <span class="text-[10px]">Coef: <?php echo $elem['coefficient']; ?></span>
                            </th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php foreach ($etudiants as $etudiant): ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-mono"><?php echo htmlspecialchars($etudiant['matricule']); ?></td>
                            <td class="px-6 py-4 text-sm">
                                <?php echo htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']); ?>
                            </td>
                            <?php foreach ($elements as $elem): ?>
                            <td class="px-6 py-4">
                                <input type="number" 
                                       name="notes[<?php echo $etudiant['id_etudiant']; ?>][<?php echo $elem['id_ec']; ?>]"
                                       min="0" max="20" step="0.5"
                                       class="w-20 border rounded px-2 py-1 text-center text-sm"
                                       placeholder="--">
                            </td>
                            <?php endforeach; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3">
                <button type="reset" class="px-4 py-2 border rounded-lg hover:bg-slate-100">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-container">
                    Enregistrer les notes
                </button>
            </div>
        </form>
        <?php elseif ($id_filiere && $id_ue): ?>
        <div class="bg-blue-50 p-6 rounded-lg text-center">
            <p class="text-slate-600">Aucun étudiant trouvé pour cette sélection</p>
        </div>
        <?php elseif ($id_filiere && !$id_ue): ?>
        <div class="bg-blue-50 p-6 rounded-lg text-center">
            <p class="text-slate-600">Veuillez sélectionner une UE</p>
        </div>
        <?php else: ?>
        <div class="bg-blue-50 p-6 rounded-lg text-center">
            <p class="text-slate-600">Veuillez sélectionner une filière et une UE</p>
        </div>
        <?php endif; ?>

    </div>
</main>

</body>
</html>
