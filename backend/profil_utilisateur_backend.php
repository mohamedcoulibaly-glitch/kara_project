<?php
/**
 * ====================================================
 * PROFIL UTILISATEUR - Backend
 * ====================================================
 * Gestion du profil utilisateur connecté
 */

require_once __DIR__ . '/../config/config.php';

// Vérifier que l'utilisateur est connecté
checkAuth();

$user = getCurrentUser();
if (!$user) {
    header('Location: ' . BASE_URL . '/login.php?error=profil_indisponible');
    exit;
}

$user_id = (int)$user['id_user'];
$message = '';
$error = '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'update_profile') {
        $nom = trim($_POST['nom'] ?? '');
        $prenom = trim($_POST['prenom'] ?? '');
        $email = trim($_POST['email'] ?? '');

        if (empty($nom) || empty($prenom) || empty($email)) {
            $error = 'Tous les champs sont obligatoires.';
        } else {
            // Vérifier si l'email est déjà utilisé par un autre utilisateur
            $check = safeQuerySingle("SELECT id_user FROM utilisateur WHERE email = ? AND id_user != ?", [$email, $user_id]);
            if ($check) {
                $error = 'Cet email is déjà utilisé par un autre utilisateur.';
            } else {
                $result = safeExecute("UPDATE utilisateur SET nom = ?, prenom = ?, email = ? WHERE id_user = ?", [$nom, $prenom, $email, $user_id]);
                if ($result) {
                    logUserAction('UPDATE', 'utilisateur', $user_id, ['nom' => $user['nom'], 'prenom' => $user['prenom'], 'email' => $user['email']], ['nom' => $nom, 'prenom' => $prenom, 'email' => $email]);
                    $message = 'Profil mis à jour avec succès.';
                    $refreshed = getCurrentUser();
                    if ($refreshed) {
                        $user = $refreshed;
                        $user_id = (int)$user['id_user'];
                    } else {
                        $user['nom'] = $nom;
                        $user['prenom'] = $prenom;
                        $user['email'] = $email;
                    }
                } else {
                    $error = 'Erreur lors de la mise à jour.';
                }
            }
        }
    } elseif ($action === 'change_password') {
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
            $error = 'Tous les champs sont obligatoires.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'Les nouveaux mots de passe ne correspondent pas.';
        } elseif (strlen($new_password) < 6) {
            $error = 'Le mot de passe doit contenir au moins 6 caractères.';
        } else {
            // Vérifier le mot de passe actuel
            $check = safeQuerySingle("SELECT password FROM utilisateur WHERE id_user = ?", [$user_id]);
            if ($check && password_verify($current_password, $check['password'])) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);
                $result = safeExecute("UPDATE utilisateur SET password = ? WHERE id_user = ?", [$hashed, $user_id]);
                if ($result) {
                    logUserAction('UPDATE', 'utilisateur', $user_id, null, ['action' => 'change_password']);
                    $message = 'Mot de passe modifié avec succès.';
                } else {
                    $error = 'Erreur lors de la modification.';
                }
            } else {
                $error = 'Le mot de passe actuel est incorrect.';
            }
        }
    }
}

// Récupérer les dernières activités
$recent_activity = safeQuery("SELECT * FROM audit_log WHERE user_id = ? ORDER BY created_at DESC LIMIT 10", [$user_id]);
if (!is_array($recent_activity)) {
    $recent_activity = [];
}

$page_title = 'Mon Profil';
$current_page = 'profil';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Mon Profil</h1>
        <p class="text-slate-500 mt-2">Gérez vos informations personnelles et votre mot de passe.</p>
    </div>

    <?php if ($message): ?>
        <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
            <span class="material-symbols-outlined text-green-600 text-xl">check_circle</span>
            <p class="text-sm text-green-800 font-medium"><?= htmlspecialchars($message) ?></p>
        </div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="mb-6 p-4 bg-error-container/20 border border-error-container rounded-xl flex items-start gap-3">
            <span class="material-symbols-outlined text-error text-xl">error</span>
            <p class="text-sm text-error font-medium"><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="md:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6 text-center">
                <div class="w-24 h-24 rounded-full bg-primary/10 mx-auto flex items-center justify-center mb-4">
                    <span class="material-symbols-outlined text-5xl text-primary">person</span>
                </div>
                <h2 class="text-xl font-bold text-on-surface">
                    <?= htmlspecialchars(($user['nom'] ?? '') . ' ' . ($user['prenom'] ?? '')) ?></h2>
                <p class="text-sm text-slate-500 mt-1"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                <?php $role = $user['role'] ?? ''; ?>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold uppercase mt-3
                    <?= $role === 'Admin' ? 'bg-error/10 text-error' : '' ?>
                    <?= $role === 'Enseignant' ? 'bg-primary/10 text-primary' : '' ?>
                    <?= $role === 'Coordinateur' ? 'bg-secondary/10 text-secondary' : '' ?>
                ">
                    <?= htmlspecialchars($role) ?>
                </span>
                <div class="mt-6 pt-6 border-t border-outline-variant/20">
                    <div class="text-xs text-slate-500">
                        <p class="mb-1">Dernière connexion:</p>
                        <p class="font-medium text-slate-700">
                            <?php
                            $ll = $user['last_login'] ?? null;
                            if ($ll) {
                                echo htmlspecialchars(formatDate($ll) . ' à ' . date('H:i', strtotime($ll)));
                            } elseif (!empty($_SESSION['login_time'])) {
                                echo htmlspecialchars(date('d/m/Y à H:i', (int)$_SESSION['login_time']));
                            } else {
                                echo 'Jamais';
                            }
                            ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="md:col-span-2 space-y-6">
            <!-- Informations personnelles -->
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h3 class="text-lg font-bold text-on-surface mb-4">Informations personnelles</h3>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="update_profile">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nom</label>
                            <input type="text" name="nom" value="<?= htmlspecialchars($user['nom'] ?? '') ?>" required
                                class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Prénom</label>
                            <input type="text" name="prenom" value="<?= htmlspecialchars($user['prenom'] ?? '') ?>" required
                                class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email</label>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" required
                            class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="bg-primary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-primary-container transition-colors">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>

            <!-- Changer mot de passe -->
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h3 class="text-lg font-bold text-on-surface mb-4">Changer le mot de passe</h3>
                <form method="POST" class="space-y-4">
                    <input type="hidden" name="action" value="change_password">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Mot de passe actuel</label>
                        <input type="password" name="current_password" required
                            class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nouveau mot de
                                passe</label>
                            <input type="password" name="new_password" required minlength="6"
                                class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Confirmer</label>
                            <input type="password" name="confirm_password" required
                                class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
                        </div>
                    </div>
                    <div class="pt-2">
                        <button type="submit"
                            class="bg-secondary text-white px-6 py-2.5 rounded-lg font-bold text-sm hover:bg-secondary-container transition-colors">
                            Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>

            <!-- Activité récente -->
            <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
                <h3 class="text-lg font-bold text-on-surface mb-4">Activité récente</h3>
                <?php if (empty($recent_activity)): ?>
                    <p class="text-sm text-slate-500">Aucune activité récente.</p>
                <?php else: ?>
                    <div class="space-y-3">
                        <?php foreach ($recent_activity as $activity): ?>
                            <div class="flex items-center gap-3 p-3 bg-surface-container-low rounded-lg">
                                <span
                                    class="material-symbols-outlined text-sm
                                    <?= $activity['action'] === 'INSERT' ? 'text-green-600' : '' ?>
                                    <?= $activity['action'] === 'UPDATE' ? 'text-blue-600' : '' ?>
                                    <?= $activity['action'] === 'DELETE' ? 'text-error' : 'text-slate-500' ?>
                                "><?= $activity['action'] === 'INSERT' ? 'add_circle' : ($activity['action'] === 'UPDATE' ? 'edit' : ($activity['action'] === 'DELETE' ? 'delete' : 'info')) ?></span>
                                <div class="flex-1">
                                    <p class="text-sm font-medium text-slate-800">
                                        <?= htmlspecialchars($activity['action']) ?>
                                        <?php if ($activity['table_name']): ?>
                                            sur <span
                                                class="font-mono text-xs"><?= htmlspecialchars($activity['table_name']) ?></span>
                                        <?php endif; ?>
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        <?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/includes/footer.php';
?>