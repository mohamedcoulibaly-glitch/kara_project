<?php
/**
 * ====================================================
 * BACKEND: Saisie des Notes par EC
 * ====================================================
 * Permet de saisir les notes détaillées par Élément Constitutif
 */

require_once __DIR__ . '/../config/config.php';

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
$id_ec = isset($_GET['ec']) ? (int)$_GET['ec'] : 0;
$session = isset($_GET['session']) ? $_GET['session'] : 'Normale';
$date_examen = isset($_GET['date_examen']) ? $_GET['date_examen'] : date('Y-m-d');

$unites = [];
$elements = [];
$etudiants = [];
$notes_saisies = [];

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

if ($id_ec) {
    // Récupérer les étudiants
    $query = "SELECT e.id_etudiant, e.matricule, e.nom, e.prenom, f.nom_filiere
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

    // Récupérer les notes existantes pour cet EC
    $query = "SELECT id_note, id_etudiant, valeur_note FROM note 
              WHERE id_ec = ? AND session = ?
              ORDER BY id_etudiant";
    $stmt = $db->prepare($query);
    $stmt->bind_param("is", $id_ec, $session);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $notes_array = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($notes_array as $note) {
                $notes_saisies[$note['id_etudiant']] = $note;
            }
        }
    }
}

// Traiter l'enregistrement des notes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_notes') {
    $enregistrements = 0;
    $erreurs = 0;
    
    if (isset($_POST['notes']) && is_array($_POST['notes'])) {
        foreach ($_POST['notes'] as $etudiant_id => $valeur_note) {
            if ($valeur_note !== '' && $valeur_note >= 0 && $valeur_note <= 20) {
                $etudiant_id = (int)$etudiant_id;
                $valeur_note = (float)$valeur_note;
                $id_ec = (int)$id_ec;
                
                // Vérifier si la note existe
                $check_query = "SELECT id_note FROM note WHERE id_etudiant = ? AND id_ec = ? AND session = ?";
                $check_stmt = $db->prepare($check_query);
                $check_stmt->bind_param("iis", $etudiant_id, $id_ec, $session);
                if ($check_stmt->execute()) {
                    $result = $check_stmt->get_result();
                    $existing = $result->fetch_assoc();
                    
                    if ($existing) {
                        // Mettre à jour
                        $update_query = "UPDATE note SET valeur_note = ?, date_modification = NOW() 
                                       WHERE id_etudiant = ? AND id_ec = ? AND session = ?";
                        $update_stmt = $db->prepare($update_query);
                        $update_stmt->bind_param("diis", $valeur_note, $etudiant_id, $id_ec, $session);
                        if ($update_stmt->execute()) {
                            $enregistrements++;
                        } else {
                            $erreurs++;
                        }
                    } else {
                        // Insérer
                        $insert_query = "INSERT INTO note (id_etudiant, id_ec, valeur_note, session, date_examen)
                                       VALUES (?, ?, ?, ?, ?)";
                        $insert_stmt = $db->prepare($insert_query);
                        $insert_stmt->bind_param("iidss", $etudiant_id, $id_ec, $valeur_note, $session, $date_examen);
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
    
    if ($enregistrements > 0) {
        $message = "$enregistrements note(s) enregistrée(s) avec succès";
        $type_message = 'success';
    } elseif ($erreurs > 0) {
        $message = "Erreur lors de l'enregistrement de " . $erreurs . " note(s)";
        $type_message = 'error';
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saisie des Notes par EC - Gestion Académique</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-surface text-on-surface">

<!-- SideNavBar -->
<aside class="flex flex-col fixed left-0 top-0 h-full py-6 bg-slate-50 w-64 z-50">
    <div class="px-6 mb-8">
        <h1 class="text-lg font-bold text-primary">Portail Académique</h1>
        <p class="text-xs text-slate-500">Gestion LMD</p>
    </div>
    <nav class="flex-1 space-y-1 px-4">
        <a href="../../index.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>
        <a href="saisie_notes_par_ec_backend.php" class="flex items-center gap-3 px-3 py-2 bg-white text-primary shadow-sm rounded-lg">
            <span class="material-symbols-outlined">grading</span>
            <span class="text-sm">Notes par EC</span>
        </a>
    </nav>
</aside>

<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-md z-40 flex items-center px-8 shadow-sm">
    <h2 class="text-xl font-bold text-primary">Saisie des Notes par EC</h2>
</header>

<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
    <div class="max-w-7xl mx-auto">
        
        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?php echo $type_message === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <h1 class="text-3xl font-bold mb-8">Saisie des Notes par EC</h1>

        <!-- Filters -->
        <div class="bg-surface-container-low p-6 rounded-xl shadow-sm mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-xs font-bold uppercase mb-2">Filière</label>
                    <select name="filiere" onchange="this.form.submit()" class="w-full border rounded px-3 py-2">
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($filieres as $fil): ?>
                        <option value="<?php echo $fil['id_filiere']; ?>" <?php echo $id_filiere == $fil['id_filiere'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($fil['nom_filiere']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase mb-2">Unité (UE)</label>
                    <select name="ue" onchange="this.form.submit()" class="w-full border rounded px-3 py-2" <?php echo empty($unites) ? 'disabled' : ''; ?>>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($unites as $u): ?>
                        <option value="<?php echo $u['id_ue']; ?>" <?php echo $id_ue == $u['id_ue'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($u['code_ue']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase mb-2">Élément (EC)</label>
                    <select name="ec" onchange="this.form.submit()" class="w-full border rounded px-3 py-2" <?php echo empty($elements) ? 'disabled' : ''; ?>>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($elements as $elem): ?>
                        <option value="<?php echo $elem['id_ec']; ?>" <?php echo $id_ec == $elem['id_ec'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($elem['code_ec']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>

        <!-- Notes Table -->
        <?php if ($id_ec && count($etudiants) > 0): ?>
        <form method="POST" class="bg-white rounded-xl overflow-hidden shadow-sm">
            <input type="hidden" name="action" value="save_notes">
            
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 border-b">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold">Matricule</th>
                            <th class="px-6 py-4 text-left text-xs font-bold">Nom & Prénom</th>
                            <th class="px-6 py-4 text-center text-xs font-bold">Note (/20)</th>
                            <th class="px-6 py-4 text-center text-xs font-bold">Statut</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        <?php foreach ($etudiants as $etudiant): 
                            $note = $notes_saisies[$etudiant['id_etudiant']] ?? null;
                            $valeur = $note ? $note['valeur_note'] : '';
                        ?>
                        <tr class="hover:bg-slate-50">
                            <td class="px-6 py-4 text-sm font-mono"><?php echo htmlspecialchars($etudiant['matricule']); ?></td>
                            <td class="px-6 py-4 text-sm"><?php echo htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']); ?></td>
                            <td class="px-6 py-4">
                                <input type="number" 
                                       name="notes[<?php echo $etudiant['id_etudiant']; ?>]"
                                       value="<?php echo $valeur; ?>"
                                       min="0" max="20" step="0.5"
                                       class="w-24 border rounded px-2 py-1 text-center">
                            </td>
                            <td class="px-6 py-4 text-center text-sm">
                                <?php 
                                    if ($valeur) {
                                        echo $valeur >= 10 ? '<span class="text-green-600">Réussi</span>' : '<span class="text-red-600">Échoué</span>';
                                    } else {
                                        echo '<span class="text-slate-400">-</span>';
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-50 px-6 py-4 flex justify-end gap-3">
                <button type="reset" class="px-4 py-2 border rounded hover:bg-slate-100">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded hover:bg-primary-container">
                    Enregistrer
                </button>
            </div>
        </form>
        <?php endif; ?>

    </div>
</main>

</body>
</html>
