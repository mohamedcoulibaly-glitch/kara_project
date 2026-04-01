<?php
/**
 * ====================================================
 * BACKEND: Saisie des Étudiants
 * ====================================================
 * Permettre l'inscription et la gestion des étudiants
 */

require_once __DIR__ . '/../config/config.php';

$db = getDB();
$message = '';
$type_message = '';

// Récupérer les filières et départements
$query = "SELECT id_filiere, nom_filiere FROM filiere ORDER BY nom_filiere";
$stmt = $db->prepare($query);
$filieres = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $filieres = $result->fetch_all(MYSQLI_ASSOC);
    }
}

$query = "SELECT id_departement, nom_departement FROM departement ORDER BY nom_departement";
$stmt = $db->prepare($query);
$departements = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $departements = $result->fetch_all(MYSQLI_ASSOC);
    }
}

// Récupérer les étudiants
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$filiere_filter = isset($_GET['filiere']) ? (int)$_GET['filiere'] : 0;
$limit = 50;
$offset = ($page - 1) * $limit;

$where = "WHERE e.statut = 'Actif'";
$params = [];
$types = '';

if ($search) {
    $where .= " AND (e.matricule LIKE ? OR e.nom LIKE ? OR e.prenom LIKE ?)";
    $search_term = "%$search%";
    $params = [$search_term, $search_term, $search_term];
    $types = 'sss';
}

if ($filiere_filter) {
    $where .= " AND e.id_filiere = ?";
    $params[] = $filiere_filter;
    $types .= 'i';
}

// Récupérer le total
$query_total = "SELECT COUNT(*) as total FROM etudiant e $where";
$stmt_total = $db->prepare($query_total);
if (!empty($params)) {
    $stmt_total->bind_param($types, ...$params);
}
$total = 0;
if ($stmt_total->execute()) {
    $result = $stmt_total->get_result();
    if ($result) {
        $row = $result->fetch_assoc();
        $total = $row['total'];
    }
}

// Récupérer les étudiants
$query = "SELECT e.id_etudiant, e.matricule, e.nom, e.prenom, e.email, e.telephone, 
          f.nom_filiere, e.date_inscription
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          $where
          ORDER BY e.nom, e.prenom
          LIMIT ? OFFSET ?";
$stmt = $db->prepare($query);
$params[] = $limit;
$params[] = $offset;
$types .= 'ii';
$stmt->bind_param($types, ...$params);
$etudiants = [];
if ($stmt->execute()) {
    $result = $stmt->get_result();
    if ($result) {
        $etudiants = $result->fetch_all(MYSQLI_ASSOC);
    }
}

$total_pages = ceil($total / $limit);

// Traiter l'ajout d'étudiant
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_student') {
    $matricule = trim($_POST['matricule'] ?? '');
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $date_naissance = $_POST['date_naissance'] ?? '';
    $email = trim($_POST['email'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');
    $id_filiere = (int)($_POST['filiere'] ?? 0);
    $id_departement = (int)($_POST['departement'] ?? 0);

    if (!$matricule || !$nom || !$prenom) {
        $message = 'Les champs matricule, nom et prénom sont obligatoires';
        $type_message = 'error';
    } else {
        // Vérifier si le matricule existe
        $check_query = "SELECT id_etudiant FROM etudiant WHERE matricule = ?";
        $check_stmt = $db->prepare($check_query);
        $check_stmt->bind_param("s", $matricule);
        if ($check_stmt->execute()) {
            $result = $check_stmt->get_result();
            if ($result->num_rows > 0) {
                $message = 'Ce matricule existe déjà';
                $type_message = 'error';
            } else {
                // Insérer le nouvel étudiant
                $insert_query = "INSERT INTO etudiant (matricule, nom, prenom, date_naissance, email, telephone, id_filiere, id_departement, statut, date_inscription)
                               VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'Actif', NOW())";
                $insert_stmt = $db->prepare($insert_query);
                $insert_stmt->bind_param("sssssii", $matricule, $nom, $prenom, $date_naissance, $email, $telephone, $id_filiere, $id_departement);
                if ($insert_stmt->execute()) {
                    $message = 'Étudiant enregistré avec succès';
                    $type_message = 'success';
                } else {
                    $message = 'Erreur lors de l\'enregistrement';
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
    <title>Inscription Étudiants - Gestion Académique</title>
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
        <a href="repertoire_etudiants_backend.php" class="flex items-center gap-3 px-3 py-2 text-slate-600 hover:bg-slate-100 rounded-lg">
            <span class="material-symbols-outlined">group</span>
            <span class="text-sm">Répertoire</span>
        </a>
        <a href="saisie_etudiants_backend.php" class="flex items-center gap-3 px-3 py-2 bg-white text-primary shadow-sm rounded-lg">
            <span class="material-symbols-outlined">person_add</span>
            <span class="text-sm">Inscription</span>
        </a>
    </nav>
</aside>

<!-- TopAppBar -->
<header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-white/80 backdrop-blur-md z-40 flex items-center px-8 shadow-sm">
    <h2 class="text-xl font-bold text-primary">Inscription Étudiants</h2>
</header>

<!-- Main Content -->
<main class="ml-64 pt-24 pb-12 px-8 min-h-screen">
    <div class="max-w-7xl mx-auto">

        <?php if ($message): ?>
        <div class="mb-6 p-4 rounded-lg <?php echo $type_message === 'success' ? 'bg-green-50 text-green-800' : 'bg-red-50 text-red-800'; ?>">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            <!-- Formulaire -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6">
                    <h3 class="text-lg font-bold mb-6">Nouveau Étudiant</h3>
                    <form method="POST" class="space-y-4">
                        <input type="hidden" name="action" value="save_student">
                        
                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Matricule *</label>
                            <input type="text" name="matricule" required class="w-full border rounded px-3 py-2" placeholder="Ex: LMD-2024-001">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Nom *</label>
                            <input type="text" name="nom" required class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Prénom *</label>
                            <input type="text" name="prenom" required class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Date de Naissance</label>
                            <input type="date" name="date_naissance" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Email</label>
                            <input type="email" name="email" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Téléphone</label>
                            <input type="tel" name="telephone" class="w-full border rounded px-3 py-2">
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Filière</label>
                            <select name="filiere" class="w-full border rounded px-3 py-2">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($filieres as $fil): ?>
                                <option value="<?php echo $fil['id_filiere']; ?>">
                                    <?php echo htmlspecialchars($fil['nom_filiere']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-bold uppercase mb-1">Département</label>
                            <select name="departement" class="w-full border rounded px-3 py-2">
                                <option value="">-- Sélectionner --</option>
                                <?php foreach ($departements as $dept): ?>
                                <option value="<?php echo $dept['id_departement']; ?>">
                                    <?php echo htmlspecialchars($dept['nom_departement']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="w-full bg-primary text-white py-2 rounded font-semibold hover:bg-primary-container">
                            Enregistrer
                        </button>
                    </form>
                </div>
            </div>

            <!-- Liste des étudiants -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <div class="p-6 border-b">
                        <h3 class="text-lg font-bold mb-4">Étudiants inscrits</h3>
                        <form method="GET" class="flex gap-2">
                            <input type="text" name="search" class="flex-1 border rounded px-3 py-2" placeholder="Rechercher..." value="<?php echo htmlspecialchars($search); ?>">
                            <select name="filiere" onchange="this.form.submit()" class="border rounded px-3 py-2">
                                <option value="">-- Tous --</option>
                                <?php foreach ($filieres as $fil): ?>
                                <option value="<?php echo $fil['id_filiere']; ?>" <?php echo $filiere_filter == $fil['id_filiere'] ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($fil['nom_filiere']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="bg-primary text-white px-4 py-2 rounded">Chercher</button>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-slate-50 border-b">
                                <tr>
                                    <th class="px-4 py-3 text-left font-bold">Matricule</th>
                                    <th class="px-4 py-3 text-left font-bold">Nom & Prénom</th>
                                    <th class="px-4 py-3 text-left font-bold">Filière</th>
                                    <th class="px-4 py-3 text-left font-bold">Date Inscription</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                <?php foreach ($etudiants as $etudiant): ?>
                                <tr class="hover:bg-slate-50">
                                    <td class="px-4 py-3 font-mono"><?php echo htmlspecialchars($etudiant['matricule']); ?></td>
                                    <td class="px-4 py-3"><?php echo htmlspecialchars($etudiant['nom'] . ' ' . $etudiant['prenom']); ?></td>
                                    <td class="px-4 py-3"><?php echo htmlspecialchars($etudiant['nom_filiere'] ?? '-'); ?></td>
                                    <td class="px-4 py-3"><?php echo date('d/m/Y', strtotime($etudiant['date_inscription'])); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if ($total_pages > 1): ?>
                    <div class="px-6 py-4 border-t flex gap-2 justify-center">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>" 
                           class="px-3 py-1 border rounded <?php echo $i == $page ? 'bg-primary text-white' : ''; ?>">
                            <?php echo $i; ?>
                        </a>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>

                    <div class="px-6 py-2 bg-slate-50 text-sm text-slate-600">
                        Total: <?php echo $total; ?> étudiant(s)
                    </div>
                </div>
            </div>
        </div>

    </div>
</main>

</body>
</html>
