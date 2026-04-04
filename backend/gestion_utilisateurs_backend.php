<?php
/**
 * ====================================================
 * GESTION DES UTILISATEURS - Backend
 * ====================================================
 * CRUD complet pour la gestion des utilisateurs
 */

require_once __DIR__ . '/../config/config.php';

// Vérifier que l'utilisateur est admin
checkAuth(['Admin']);

$action = $_GET['action'] ?? $_POST['action'] ?? 'list';

// Traitement des actions
switch ($action) {
    case 'list':
        handleListUsers();
        break;
    case 'get_user':
        handleGetUser();
        break;
    case 'save':
        handleSaveUser();
        break;
    case 'delete':
        handleDeleteUser();
        break;
    case 'reset_password':
        handleResetPassword();
        break;
    default:
        handleListUsers();
}

/**
 * Liste des utilisateurs avec pagination et filtres
 */
function handleListUsers()
{
    global $action;

    $page = max(1, intval($_GET['page'] ?? 1));
    $per_page = 20;
    $offset = ($page - 1) * $per_page;
    $search = $_GET['search'] ?? '';
    $role_filter = $_GET['role'] ?? '';
    $statut_filter = $_GET['statut'] ?? '';

    // Requête de base
    $where = [];
    $params = [];

    if ($search) {
        $where[] = "(nom LIKE ? OR prenom LIKE ? OR email LIKE ?)";
        $search_term = "%$search%";
        $params[] = $search_term;
        $params[] = $search_term;
        $params[] = $search_term;
    }

    if ($role_filter) {
        $where[] = "role = ?";
        $params[] = $role_filter;
    }

    if ($statut_filter) {
        $where[] = "statut = ?";
        $params[] = $statut_filter;
    }

    $where_clause = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);

    // Compter le total
    $count_query = "SELECT COUNT(*) as total FROM utilisateur $where_clause";
    $total = safeQuerySingle($count_query, $params);
    $total_pages = ceil($total['total'] / $per_page);

    // Récupérer les utilisateurs
    $query = "SELECT * FROM utilisateur $where_clause ORDER BY date_creation DESC LIMIT $per_page OFFSET $offset";
    $users = safeQuery($query, $params);

    $page_title = 'Gestion des Utilisateurs';
    $current_page = 'utilisateurs';
    include __DIR__ . '/includes/sidebar.php';
    ?>

    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Gestion des Utilisateurs</h1>
        <p class="text-slate-500 mt-2">Gérez les comptes utilisateurs, les rôles et les permissions.</p>
    </div>

    <!-- Filtres -->
    <div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-6 shadow-sm">
        <form method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="<?= htmlspecialchars($search) ?>"
                    placeholder="Rechercher un utilisateur..."
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div class="w-40">
                <select name="role"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                    <option value="">Tous les rôles</option>
                    <option value="Admin" <?= $role_filter === 'Admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="Enseignant" <?= $role_filter === 'Enseignant' ? 'selected' : '' ?>>Enseignant</option>
                    <option value="Scolarite" <?= $role_filter === 'Scolarite' ? 'selected' : '' ?>>Scolarité</option>
                    <option value="Directeur" <?= $role_filter === 'Directeur' ? 'selected' : '' ?>>Directeur</option>
                </select>
            </div>
            <div class="w-40">
                <select name="statut"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                    <option value="">Tous les statuts</option>
                    <option value="Actif" <?= $statut_filter === 'Actif' ? 'selected' : '' ?>>Actif</option>
                    <option value="Inactif" <?= $statut_filter === 'Inactif' ? 'selected' : '' ?>>Inactif</option>
                </select>
            </div>
            <button type="submit"
                class="bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-primary-container transition-colors">
                Filtrer
            </button>
            <a href="gestion_utilisateurs_backend.php"
                class="bg-surface-container-low text-slate-700 px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-surface-container-high transition-colors">
                Réinitialiser
            </a>
        </form>
    </div>

    <!-- Tableau des utilisateurs -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 overflow-hidden">
        <div class="flex items-center justify-between p-6 border-b border-outline-variant/20">
            <h3 class="font-bold text-slate-800">Utilisateurs (<?= $total['total'] ?>)</h3>
            <button onclick="openAddUserModal()"
                class="bg-primary text-white px-4 py-2 rounded-lg font-bold text-sm hover:bg-primary-container transition-colors flex items-center gap-2">
                <span class="material-symbols-outlined text-lg">add</span>
                Nouvel utilisateur
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50 border-b border-outline-variant/20">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Utilisateur</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Email</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Rôle</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Statut</th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500">Dernière connexion
                        </th>
                        <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-slate-500 text-right">Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($users)): ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-slate-400">Aucun utilisateur trouvé.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                                            <span class="material-symbols-outlined text-primary text-sm">person</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-slate-800">
                                                <?= htmlspecialchars($user['nom'] . ' ' . $user['prenom']) ?>
                                            </p>
                                            <p class="text-xs text-slate-500">Créé le <?= !empty($user['date_creation']) ? formatDate($user['date_creation']) : '—' ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600"><?= htmlspecialchars($user['email']) ?></td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold uppercase 
                                        <?= $user['role'] === 'Admin' ? 'bg-error/10 text-error' : '' ?>
                                        <?= $user['role'] === 'Enseignant' ? 'bg-primary/10 text-primary' : '' ?>
                                        <?= $user['role'] === 'Scolarite' ? 'bg-secondary/10 text-secondary' : '' ?>
                                        <?= $user['role'] === 'Directeur' ? 'bg-amber-100 text-amber-800' : '' ?>
                                    ">
                                        <?= htmlspecialchars($user['role']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-bold 
                                        <?= $user['statut'] === 'Actif' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-600' ?>
                                    ">
                                        <span
                                            class="w-1.5 h-1.5 rounded-full <?= $user['statut'] === 'Actif' ? 'bg-green-500' : 'bg-slate-400' ?>"></span>
                                        <?= htmlspecialchars($user['statut']) ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    <?php
                                    $ll = $user['last_login'] ?? null;
                                    echo ($ll && $ll !== '0000-00-00 00:00:00') ? formatDate($ll) . ' à ' . date('H:i', strtotime($ll)) : '—';
                                    ?>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openEditUserModal(<?= (int)($user['id_user'] ?? 0) ?>)"
                                            class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-primary hover:text-white transition-colors"
                                            title="Modifier">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </button>
                                        <button onclick="resetPassword(<?= (int)($user['id_user'] ?? 0) ?>)"
                                            class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-secondary hover:text-white transition-colors"
                                            title="Réinitialiser mot de passe">
                                            <span class="material-symbols-outlined text-[18px]">lock_reset</span>
                                        </button>
                                        <?php if (($user['id_user'] ?? 0) != $_SESSION['user_id']): ?>
                                            <button onclick="deleteUser(<?= (int)($user['id_user'] ?? 0) ?>)"
                                                class="p-2 bg-slate-100 text-slate-600 rounded-lg hover:bg-error hover:text-white transition-colors"
                                                title="Supprimer">
                                                <span class="material-symbols-outlined text-[18px]">delete</span>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if ($total_pages > 1): ?>
            <div class="px-6 py-4 border-t border-outline-variant/20 flex items-center justify-between">
                <p class="text-sm text-slate-500">Page <?= $page ?> sur <?= $total_pages ?></p>
                <div class="flex gap-2">
                    <?php if ($page > 1): ?>
                        <a href="?page=<?= $page - 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?><?= $role_filter ? '&role=' . urlencode($role_filter) : '' ?><?= $statut_filter ? '&statut=' . urlencode($statut_filter) : '' ?>"
                            class="px-4 py-2 bg-surface-container-low rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">
                            Précédent
                        </a>
                    <?php endif; ?>
                    <?php if ($page < $total_pages): ?>
                        <a href="?page=<?= $page + 1 ?><?= $search ? '&search=' . urlencode($search) : '' ?><?= $role_filter ? '&role=' . urlencode($role_filter) : '' ?><?= $statut_filter ? '&statut=' . urlencode($statut_filter) : '' ?>"
                            class="px-4 py-2 bg-surface-container-low rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">
                            Suivant
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Ajouter/Modifier Utilisateur -->
    <div id="user-modal"
        class="modal-container fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
        <div class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in duration-300">
            <div class="p-6 bg-primary text-white flex justify-between items-center">
                <h4 id="modal-title" class="text-sm font-black tracking-tight uppercase">Nouvel utilisateur</h4>
                <button type="button" onclick="closeModal()" class="hover:bg-white/10 p-1 rounded-full">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <form id="user-form" method="POST" action="gestion_utilisateurs_backend.php" class="p-8 space-y-6">
                <input type="hidden" name="action" value="save">
                <input type="hidden" name="id_user" id="user_id">

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Nom</label>
                        <input name="nom" id="user_nom" required
                            class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary"
                            type="text" />
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Prénom</label>
                        <input name="prenom" id="user_prenom" required
                            class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary"
                            type="text" />
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Email</label>
                    <input name="email" id="user_email" required
                        class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary"
                        type="email" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Rôle</label>
                        <select name="role" id="user_role" required
                            class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            <option value="Enseignant">Enseignant</option>
                            <option value="Scolarite">Scolarité</option>
                            <option value="Directeur">Directeur</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Statut</label>
                        <select name="statut" id="user_statut" required
                            class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary">
                            <option value="Actif">Actif</option>
                            <option value="Inactif">Inactif</option>
                        </select>
                    </div>
                </div>

                <div id="password-field">
                    <label class="block text-[10px] font-black text-slate-400 uppercase mb-2">Mot de passe</label>
                    <input name="password" id="user_password"
                        class="w-full bg-slate-50 border-none rounded-xl px-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary"
                        type="password" />
                    <p class="text-[10px] text-slate-400 mt-1">Laisser vide pour ne pas modifier (modification seulement)
                    </p>
                </div>

                <div class="pt-4 flex justify-end gap-3">
                    <button type="button" onclick="closeModal()"
                        class="bg-slate-100 text-slate-700 px-6 py-3 rounded-xl font-bold text-sm hover:bg-slate-200 transition-colors">
                        Annuler
                    </button>
                    <button type="submit"
                        class="bg-primary text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg hover:opacity-90 active:scale-95 transition-all">
                        Enregistrer
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openAddUserModal() {
            document.getElementById('modal-title').textContent = 'Nouvel utilisateur';
            document.getElementById('user-form').reset();
            document.getElementById('user_id').value = '';
            document.getElementById('password-field').style.display = 'block';
            document.getElementById('user-modal').classList.remove('hidden');
            document.getElementById('user-modal').classList.add('flex');
        }

        function openEditUserModal(userId) {
            // Fetch user data and populate form
            fetch(`?action=get_user&id=${userId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('modal-title').textContent = 'Modifier l\'utilisateur';
                        document.getElementById('user_id').value = data.user.id_user;
                        document.getElementById('user_nom').value = data.user.nom;
                        document.getElementById('user_prenom').value = data.user.prenom;
                        document.getElementById('user_email').value = data.user.email;
                        document.getElementById('user_role').value = data.user.role;
                        document.getElementById('user_statut').value = data.user.statut;
                        document.getElementById('password-field').style.display = 'block';
                        document.getElementById('user-modal').classList.remove('hidden');
                        document.getElementById('user-modal').classList.add('flex');
                    }
                });
        }

        function closeModal() {
            document.getElementById('user-modal').classList.add('hidden');
            document.getElementById('user-modal').classList.remove('flex');
        }

        function resetPassword(userId) {
            if (confirm('Êtes-vous sûr de vouloir réinitialiser le mot de passe de cet utilisateur ?')) {
                fetch('gestion_utilisateurs_backend.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=reset_password&id_user=${userId}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Mot de passe réinitialisé. Nouveau mot de passe: ' + data.password);
                        } else {
                            alert('Erreur: ' + data.error);
                        }
                    });
            }
        }

        function deleteUser(userId) {
            if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                fetch('gestion_utilisateurs_backend.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: `action=delete&id_user=${userId}`
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Erreur: ' + data.error);
                        }
                    });
            }
        }

        // Handle form submission
        document.getElementById('user-form').addEventListener('submit', function (e) {
            e.preventDefault();
            const formData = new FormData(this);

            fetch('gestion_utilisateurs_backend.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erreur: ' + data.error);
                    }
                });
        });

        // Close modal on outside click
        document.getElementById('user-modal').addEventListener('click', function (e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>

    <?php
    include __DIR__ . '/includes/footer.php';
}

/**
 * Obtenir les détails d'un utilisateur
 */
function handleGetUser()
{
    $id = intval($_GET['id'] ?? 0);
    $user = safeQuerySingle("SELECT * FROM utilisateur WHERE id_user = ?", [$id]);

    if ($user) {
        echo json_encode(['success' => true, 'user' => $user]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non trouvé.']);
    }
    exit;
}

/**
 * Enregistrer un utilisateur (ajout ou modification)
 */
function handleSaveUser()
{
    $id = intval($_POST['id_user'] ?? $_POST['id_utilisateur'] ?? 0);
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'Enseignant';
    $statut = $_POST['statut'] ?? 'Actif';
    $password = $_POST['password'] ?? '';

    $allowed_roles = ['Admin', 'Enseignant', 'Scolarite', 'Directeur'];
    if (!in_array($role, $allowed_roles, true)) {
        $role = 'Enseignant';
    }

    if (empty($nom) || empty($prenom) || empty($email)) {
        echo json_encode(['success' => false, 'error' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    if ($id > 0) {
        // Modification
        handleEditUser();
    } else {
        // Ajout
        if (empty($password)) {
            echo json_encode(['success' => false, 'error' => 'Le mot de passe est obligatoire pour un nouvel utilisateur.']);
            exit;
        }
        handleAddUser();
    }
}

/**
 * Ajouter un utilisateur
 */
function handleAddUser()
{
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'Enseignant';
    $statut = $_POST['statut'] ?? 'Actif';
    $password = $_POST['password'] ?? '';

    $allowed_roles = ['Admin', 'Enseignant', 'Scolarite', 'Directeur'];
    if (!in_array($role, $allowed_roles, true)) {
        $role = 'Enseignant';
    }

    if (empty($nom) || empty($prenom) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'error' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    // Vérifier si l'email existe déjà
    $check = safeQuerySingle("SELECT id_user FROM utilisateur WHERE email = ?", [$email]);
    if ($check) {
        echo json_encode(['success' => false, 'error' => 'Cet email est déjà utilisé.']);
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO utilisateur (nom, prenom, email, password, role, statut) VALUES (?, ?, ?, ?, ?, ?)";
    $result = safeExecute($query, [$nom, $prenom, $email, $hashed_password, $role, $statut]);

    if ($result) {
        logUserAction('INSERT', 'utilisateur', getDB()->insert_id, null, ['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'role' => $role]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la création.']);
    }
    exit;
}

/**
 * Modifier un utilisateur
 */
function handleEditUser()
{
    $id = intval($_POST['id_user'] ?? $_POST['id_utilisateur'] ?? 0);
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $role = $_POST['role'] ?? 'Enseignant';
    $statut = $_POST['statut'] ?? 'Actif';
    $password = $_POST['password'] ?? '';

    $allowed_roles = ['Admin', 'Enseignant', 'Scolarite', 'Directeur'];
    if (!in_array($role, $allowed_roles, true)) {
        $role = 'Enseignant';
    }

    if (empty($nom) || empty($prenom) || empty($email)) {
        echo json_encode(['success' => false, 'error' => 'Tous les champs sont obligatoires.']);
        exit;
    }

    // Récupérer les anciennes valeurs
    $old_user = safeQuerySingle("SELECT * FROM utilisateur WHERE id_user = ?", [$id]);
    if (!$old_user) {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non trouvé.']);
        exit;
    }

    $query = "UPDATE utilisateur SET nom = ?, prenom = ?, email = ?, role = ?, statut = ?";
    $params = [$nom, $prenom, $email, $role, $statut];

    if (!empty($password)) {
        $query .= ", password = ?";
        $params[] = password_hash($password, PASSWORD_DEFAULT);
    }

    $query .= " WHERE id_user = ?";
    $params[] = $id;

    $result = safeExecute($query, $params);

    if ($result) {
        logUserAction('UPDATE', 'utilisateur', $id, $old_user, ['nom' => $nom, 'prenom' => $prenom, 'email' => $email, 'role' => $role, 'statut' => $statut]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la modification.']);
    }
    exit;
}

/**
 * Supprimer un utilisateur
 */
function handleDeleteUser()
{
    $id = intval($_POST['id_user'] ?? $_POST['id_utilisateur'] ?? 0);

    if ($id == $_SESSION['user_id']) {
        echo json_encode(['success' => false, 'error' => 'Vous ne pouvez pas vous supprimer vous-même.']);
        exit;
    }

    $old_user = safeQuerySingle("SELECT * FROM utilisateur WHERE id_user = ?", [$id]);
    if (!$old_user) {
        echo json_encode(['success' => false, 'error' => 'Utilisateur non trouvé.']);
        exit;
    }

    $result = safeExecute("DELETE FROM utilisateur WHERE id_user = ?", [$id]);

    if ($result) {
        logUserAction('DELETE', 'utilisateur', $id, $old_user, null);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la suppression.']);
    }
    exit;
}

/**
 * Réinitialiser le mot de passe
 */
function handleResetPassword()
{
    $id = intval($_POST['id_user'] ?? $_POST['id_utilisateur'] ?? $_GET['id'] ?? 0);

    // Générer un mot de passe aléatoire
    $new_password = bin2hex(random_bytes(4)); // 8 caractères
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    $result = safeExecute("UPDATE utilisateur SET password = ? WHERE id_user = ?", [$hashed_password, $id]);

    if ($result) {
        logUserAction('UPDATE', 'utilisateur', $id, null, ['action' => 'reset_password']);
        echo json_encode(['success' => true, 'password' => $new_password]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la réinitialisation.']);
    }
    exit;
}