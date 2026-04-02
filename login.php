<?php
/**
 * ====================================================
 * LOGIN PAGE - Page de Connexion
 * ====================================================
 * Système d'authentification sécurisé
 */

require_once __DIR__ . '/config/config.php';

// Si déjà connecté, rediriger vers le dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$error = '';
$success = '';

// Traitement du formulaire de connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']);

    if (empty($email) || empty($password)) {
        $error = 'Veuillez remplir tous les champs.';
    } else {
        // Vérifier les identifiants dans la base de données
        $query = "SELECT id_user, email, nom, prenom, role, password, statut 
                  FROM utilisateur 
                  WHERE email = ?";

        $stmt = getDB()->prepare($query);
        if ($stmt) {
            $stmt->bind_param("s", $email);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($user = $result->fetch_assoc()) {
                    // Vérifier le mot de passe
                    if (password_verify($password, $user['password'])) {
                        // Vérifier que l'utilisateur est actif
                        if ($user['statut'] === 'Actif') {
                            // Créer la session
                            $_SESSION['user_id'] = $user['id_user'];
                            $_SESSION['user_email'] = $user['email'];
                            $_SESSION['user_name'] = $user['nom'] . ' ' . $user['prenom'];
                            $_SESSION['user_role'] = $user['role'];
                            $_SESSION['login_time'] = time();

                            // Mettre à jour last_login
                            $updateQuery = "UPDATE utilisateur SET last_login = NOW() WHERE id_user = ?";
                            $updateStmt = getDB()->prepare($updateQuery);
                            if ($updateStmt) {
                                $updateStmt->bind_param("i", $user['id_user']);
                                $updateStmt->execute();
                            }

                            // Si "Rester connecté" est coché, créer un cookie
                            if ($remember) {
                                $token = bin2hex(random_bytes(32));
                                setcookie('remember_token', $token, time() + (86400 * 30), '/'); // 30 jours

                                // Stocker le token dans la base (nécessite une table remember_tokens)
                                // Pour l'instant, on utilise juste le cookie
                            }

                            // Rediriger vers le dashboard
                            header("Location: index.php");
                            exit;
                        } else {
                            $error = 'Votre compte est désactivé. Contactez l\'administrateur.';
                        }
                    } else {
                        $error = 'Email ou mot de passe incorrect.';
                    }
                } else {
                    $error = 'Email ou mot de passe incorrect.';
                }
            } else {
                $error = 'Erreur de connexion. Veuillez réessayer.';
            }
        } else {
            $error = 'Erreur de configuration. Contactez l\'administrateur.';
        }
    }
}
?>
<!DOCTYPE html>
<html class="light" lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - <?php echo APP_NAME; ?></title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet">
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#003fb1",
                        "primary-container": "#1a56db",
                        "secondary": "#4b5c92",
                        "secondary-container": "#b1c2ff",
                        "tertiary": "#852b00",
                        "tertiary-container": "#ad3b00",
                        "on-primary": "#ffffff",
                        "on-secondary": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-primary-container": "#d4dcff",
                        "on-secondary-container": "#3d4e84",
                        "on-tertiary-container": "#ffd4c5",
                        "surface": "#f7f9fb",
                        "surface-dim": "#d8dadc",
                        "surface-bright": "#f7f9fb",
                        "surface-container-low": "#f2f4f6",
                        "surface-container": "#eceef0",
                        "surface-container-high": "#e6e8ea",
                        "surface-container-highest": "#e0e3e5",
                        "surface-container-lowest": "#ffffff",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#434654",
                        "outline": "#737686",
                        "outline-variant": "#c3c5d7",
                        "background": "#f7f9fb",
                        "on-background": "#191c1e",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-error": "#ffffff",
                        "on-error-container": "#93000a",
                        "inverse-surface": "#2d3133",
                        "inverse-on-surface": "#eff1f3",
                        "inverse-primary": "#b5c4ff",
                        "primary-fixed": "#dbe1ff",
                        "primary-fixed-dim": "#b5c4ff",
                        "secondary-fixed": "#dbe1ff",
                        "tertiary-fixed": "#ffdbcf",
                        "surface-tint": "#1353d8",
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
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .login-card {
            backdrop-filter: blur(10px);
        }
    </style>
</head>

<body class="bg-surface min-h-screen flex items-center justify-center p-4">
    <!-- Background decoration -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary/5 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-secondary/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Login Card -->
    <div class="login-card bg-white/90 rounded-2xl shadow-2xl w-full max-w-md p-8 relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-primary/10 rounded-2xl mb-4">
                <span class="material-symbols-outlined text-4xl text-primary">account_balance</span>
            </div>
            <h1 class="text-2xl font-bold text-on-surface tracking-tight">Portail Académique</h1>
            <p class="text-sm text-slate-500 mt-1">Gestion LMD - Connexion sécurisée</p>
        </div>

        <!-- Error Message -->
        <?php if ($error): ?>
            <div class="mb-6 p-4 bg-error-container/20 border border-error-container rounded-xl flex items-start gap-3">
                <span class="material-symbols-outlined text-error text-xl">error</span>
                <div>
                    <p class="text-sm font-semibold text-error">Erreur de connexion</p>
                    <p class="text-xs text-error mt-0.5"><?php echo htmlspecialchars($error); ?></p>
                </div>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" action="" class="space-y-5">
            <!-- Email Field -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">
                    Email ou identifiant
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">person</span>
                    <input type="text" name="email"
                        value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                        class="w-full pl-10 pr-4 py-3 bg-surface-container-low border-none rounded-xl text-sm font-medium text-on-surface placeholder-slate-400 focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none"
                        placeholder="votre.email@universite.com" required autofocus>
                </div>
            </div>

            <!-- Password Field -->
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">
                    Mot de passe
                </label>
                <div class="relative">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">lock</span>
                    <input type="password" name="password"
                        class="w-full pl-10 pr-12 py-3 bg-surface-container-low border-none rounded-xl text-sm font-medium text-on-surface placeholder-slate-400 focus:ring-2 focus:ring-primary focus:bg-white transition-all outline-none"
                        placeholder="••••••••" required>
                    <button type="button"
                        class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 transition-colors"
                        onclick="togglePassword()">
                        <span class="material-symbols-outlined" id="password-toggle">visibility_off</span>
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember"
                        class="w-4 h-4 rounded border-slate-300 text-primary focus:ring-primary">
                    <span class="text-sm text-slate-600">Rester connecté</span>
                </label>
                <a href="#" class="text-sm font-semibold text-primary hover:underline">Mot de passe oublié ?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="w-full bg-primary text-white py-3.5 rounded-xl font-bold text-sm shadow-lg shadow-primary/20 hover:bg-primary-container hover:shadow-xl hover:shadow-primary/30 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined">login</span>
                Se connecter
            </button>
        </form>

        <!-- Footer -->
        <div class="mt-8 pt-6 border-t border-slate-100 text-center">
            <p class="text-xs text-slate-400">
                © <?php echo date('Y'); ?> <?php echo APP_NAME; ?> - v<?php echo APP_VERSION; ?>
            </p>
            <p class="text-[10px] text-slate-300 mt-1">
                Système de gestion académique LMD
            </p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.querySelector('input[name="password"]');
            const toggle = document.getElementById('password-toggle');

            if (input.type === 'password') {
                input.type = 'text';
                toggle.textContent = 'visibility';
            } else {
                input.type = 'password';
                toggle.textContent = 'visibility_off';
            }
        }
    </script>
</body>

</html>