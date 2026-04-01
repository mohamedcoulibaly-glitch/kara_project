<?php
/**
 * ====================================================
 * BACKEND: Saisie UE/EC
 * ====================================================
 * Gérer les Unités d'Enseignement et Éléments Constitutifs
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

// Récupérer les UE/EC
$id_filiere = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$unites = [];
$elements_constitutifs = [];

if ($id_filiere) {
    $query = "SELECT DISTINCT ue.id_ue, ue.code_ue, ue.libelle_ue, ue.credits_ects
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

    // Récupérer tous les EC pour cette filière
    $query = "SELECT ec.id_ec, ec.code_ec, ec.nom_ec, ec.coefficient, ue.code_ue
              FROM ec ec
              JOIN ue ON ec.id_ue = ue.id_ue
              JOIN programme p ON ue.id_ue = p.id_ue
              WHERE p.id_filiere = ?
              ORDER BY ue.code_ue, ec.code_ec";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $id_filiere);
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result) {
            $elements_constitutifs = $result->fetch_all(MYSQLI_ASSOC);
        }
    }
}

// Traiter l'ajout d'UE
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_ue') {
    $code_ue = trim($_POST['code_ue'] ?? '');
    $libelle_ue = trim($_POST['libelle_ue'] ?? '');
    $credits_ects = (float)($_POST['credits_ects'] ?? 0);

    if (!$code_ue || !$libelle_ue) {
        $message = 'Code et libellé UE obligatoires';
        $type_message = 'error';
    } else {
        // Vérifier si le code UE existe
        $check_query = "SELECT id_ue FROM ue WHERE code_ue = ?";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bind_param("s", $code_ue);
        if ($check_stmt->execute()) {
            $result = $check_stmt->get_result();
            if ($result->num_rows > 0) {
                $message = 'Ce code UE existe déjà';
                $type_message = 'error';
            } else {
                // Insérer l'UE
                $insert_query = "INSERT INTO ue (code_ue, libelle_ue, credits_ects) VALUES (?, ?, ?)";
                $insert_stmt = $db->prepare($insert_query);
                $insert_stmt->bind_param("ssd", $code_ue, $libelle_ue, $credits_ects);
                if ($insert_stmt->execute()) {
                    $id_ue = $insert_stmt->insert_id;
                    
                    // Associer à la filière
                    if ($id_filiere) {
                        $prog_query = "INSERT INTO programme (id_filiere, id_ue) VALUES (?, ?) ON DUPLICATE KEY UPDATE id_ue = id_ue";
                        $prog_stmt = $db->prepare($prog_query);
                        $prog_stmt->bind_param("ii", $id_filiere, $id_ue);
                        $prog_stmt->execute();
                    }
                    
                    $message = 'UE créée avec succès';
                    $type_message = 'success';
                } else {
                    $message = 'Erreur lors de la création';
                    $type_message = 'error';
                }
            }
        }
    }
}

// Traiter l'ajout d'EC
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_ec') {
    $code_ec = trim($_POST['code_ec'] ?? '');
    $nom_ec = trim($_POST['nom_ec'] ?? '');
    $coefficient = (float)($_POST['coefficient'] ?? 1);
    $id_ue = (int)($_POST['id_ue'] ?? 0);

    if (!$code_ec || !$nom_ec || !$id_ue) {
        $message = 'Tous les champs sont obligatoires';
        $type_message = 'error';
    } else {
        // Vérifier si le code EC existe
        $check_query = "SELECT id_ec FROM ec WHERE code_ec = ?";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bind_param("s", $code_ec);
        if ($check_stmt->execute()) {
            $result = $check_stmt->get_result();
            if ($result->num_rows > 0) {
                $message = 'Ce code EC existe déjà';
                $type_message = 'error';
            } else {
                // Insérer l'EC
                $insert_query = "INSERT INTO ec (code_ec, nom_ec, coefficient, id_ue) VALUES (?, ?, ?, ?)";
                $insert_stmt = $db->prepare($insert_query);
                $insert_stmt->bind_param("ssdi", $code_ec, $nom_ec, $coefficient, $id_ue);
                if ($insert_stmt->execute()) {
                    $message = 'EC créé avec succès';
                    $type_message = 'success';
                } else {
                    $message = 'Erreur lors de la création';
                    $type_message = 'error';
                }
            }
        }
    }
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion UE/EC - Gestion Académique</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
</head>
<body class="bg-surface text-on-surface">

<!-- SideNavBar -->
<aside class="h-screen w-64 fixed left-0 top-0 bg-slate-50 flex flex-col p-4 z-50">
    <div class="mb-8 px-2">
        <h1 class="text-lg font-bold text-primary">Portail Académique</h1>
        <p class="text-xs text-slate-500">Gestion LMD</p>
    </div>
    <nav class="flex-1 space-y-1">
        <a href="../../index.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm">Dashboard</span>
        </a>
        <a href="saisie_ue_ec_backend.php" class="flex items-center gap-3 px-3 py-2 bg-white text-primary shadow-sm rounded-lg">
            <span class="material-symbols-outlined">library_books</span>
            <span class="text-sm">UE/EC</span>
        </a>
    </nav>
</aside>

<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-md z-40 flex items-center px-8 shadow-sm">
    <h2 class="text-xl font-bold text-primary">Gestion UE/EC</h2>
</header>

<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?php echo $type_message === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <!-- Filière Selection -->
        <div class="mb-8">
            <form method="GET" class="flex gap-4">
                <div class="flex-1">
                    <label class="block text-xs font-bold uppercase mb-2">Sélectionner une filière</label>
                    <select name="filiere" onchange="this.form.submit()" class="w-full border rounded px-4 py-2">
                        <option value="">-- Toutes les filières --</option>
                        <?php foreach ($filieres as $fil): ?>
                        <option value="<?php echo $fil['id_filiere']; ?>" <?php echo $id_filiere == $fil['id_filiere'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($fil['nom_filiere']); ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulaires -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Ajouter UE -->
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-6">Nouvelle UE</h3>
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="save_ue">
                        
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Code UE *</label>
                            <input type="text" name="code_ue" required class="w-full border rounded px-3 py-2" placeholder="Ex: INF101">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Libellé *</label>
                            <input type="text" name="libelle_ue" required class="w-full border rounded px-3 py-2" placeholder="Libellé complet">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Crédits ECTS</label>
                            <input type="number" name="credits_ects" step="0.5" class="w-full border rounded px-3 py-2" placeholder="6">
                        </div>

                        <button type="submit" class="w-full bg-primary text-white py-2 rounded font-semibold hover:bg-primary-container">
                            Créer UE
                        </button>
                    </form>
                </div>

                <!-- Ajouter EC -->
                <?php if ($id_filiere): ?>
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-6">Nouvel EC</h3>
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="save_ec">
                        
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">UE *</label>
                            <select name="id_ue" required class="w-full border rounded px-3 py-2">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($unites as $u): ?>
                                <option value="<?php echo $u['id_ue']; ?>">
                                    <?php echo htmlspecialchars($u['code_ue']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Code EC *</label>
                            <input type="text" name="code_ec" required class="w-full border rounded px-3 py-2" placeholder="Ex: INF101.1">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Nom EC *</label>
                            <input type="text" name="nom_ec" required class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Coefficient</label>
                            <input type="number" name="coefficient" step="0.5" value="1" class="w-full border rounded px-3 py-2">
                        </div>

                        <button type="submit" class="w-full bg-primary text-white py-2 rounded font-semibold hover:bg-primary-container">
                            Créer EC
                        </button>
                    </form>
                </div>
                <?php endif; ?>
            </div>

            <!-- Liste des UE/EC -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-bold">Unités & Éléments</h3>
                    </div>

                    <?php if (!empty($unites)): ?>
                    <div class="p-6 space-y-6">
                        <?php foreach ($unites as $ue): 
                            $ec_of_ue = array_filter($elements_constitutifs, function($e) use ($ue) {
                                return $e['code_ue'] === $ue['code_ue'];
                            });
                        ?>
                        <div class="border rounded-lg p-4 bg-slate-50">
                            <div class="flex items-start justify-between mb-3">
                                <div>
                                    <h4 class="font-bold text-blue-700"><?php echo htmlspecialchars($ue['code_ue']); ?></h4>
                                    <p class="text-sm text-slate-600"><?php echo htmlspecialchars($ue['libelle_ue']); ?></p>
                                </div>
                                <span class="bg-primary text-white px-3 py-1 rounded text-xs font-bold">
                                    <?php echo $ue['credits_ects']; ?> ECTS
                                </span>
                            </div>

                            <?php if (!empty($ec_of_ue)): ?>
                            <div class="space-y-2 mt-4">
                                <p class="text-xs font-bold text-slate-500 uppercase">Éléments Constitutifs:</p>
                                <?php foreach ($ec_of_ue as $ec): ?>
                                <div class="bg-white p-2 rounded flex items-center justify-between text-sm">
                                    <div>
                                        <span class="font-mono"><?php echo htmlspecialchars($ec['code_ec']); ?></span> - 
                                        <?php echo htmlspecialchars($ec['nom_ec']); ?>
                                    </div>
                                    <span class="text-xs bg-gray-200 px-2 py-1 rounded">
                                        Coef: <?php echo $ec['coefficient']; ?>
                                    </span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php else: ?>
                            <p class="text-xs text-slate-500 italic mt-4">Aucun EC défini</p>
                            <?php endif; ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php else: ?>
                    <div class="p-6 text-center text-slate-600">
                        <?php echo $id_filiere ? 'Aucune UE pour cette filière' : 'Sélectionnez une filière'; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

    </div>
</main>

</body>
</html>
