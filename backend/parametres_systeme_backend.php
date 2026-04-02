<?php
/**
 * ====================================================
 * PARAMÈTRES SYSTÈME - Backend
 * ====================================================
 * Gestion des paramètres de l'application
 */

require_once __DIR__ . '/../config/config.php';

// Vérifier que l'utilisateur est admin
checkAuth(['Admin']);

$message = '';
$error = '';

// Récupérer les paramètres actuels
$settings = [];
$result = safeQuery("SELECT * FROM app_settings");
if ($result) {
    foreach ($result as $row) {
        $settings[$row['setting_key']] = $row;
    }
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'setting_') === 0) {
            $setting_key = str_replace('setting_', '', $key);
            if (isset($settings[$setting_key])) {
                safeExecute("UPDATE app_settings SET setting_value = ?, updated_by = ? WHERE setting_key = ?", [$value, $_SESSION['user_id'], $setting_key]);
            }
        }
    }
    $message = 'Paramètres enregistrés avec succès.';
    // Refresh settings
    $settings = [];
    $result = safeQuery("SELECT * FROM app_settings");
    if ($result) {
        foreach ($result as $row) {
            $settings[$row['setting_key']] = $row;
        }
    }
}

$page_title = 'Paramètres Système';
$current_page = 'parametres';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Paramètres Système</h1>
    <p class="text-slate-500 mt-2">Configurez les paramètres globaux de l'application.</p>
</div>

<?php if ($message): ?>
    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-xl flex items-start gap-3">
        <span class="material-symbols-outlined text-green-600 text-xl">check_circle</span>
        <p class="text-sm text-green-800 font-medium"><?= htmlspecialchars($message) ?></p>
    </div>
<?php endif; ?>

<form method="POST" class="space-y-6">
    <!-- Général -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-primary text-2xl">info</span>
            <h3 class="text-lg font-bold text-on-surface">Paramètres Généraux</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nom de l'application</label>
                <input type="text" name="setting_app_name"
                    value="<?= htmlspecialchars($settings['app_name']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Année académique</label>
                <input type="text" name="setting_academic_year"
                    value="<?= htmlspecialchars($settings['academic_year']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nom de l'université</label>
                <input type="text" name="setting_university_name"
                    value="<?= htmlspecialchars($settings['university_name']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
        </div>
    </div>

    <!-- Email -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-primary text-2xl">email</span>
            <h3 class="text-lg font-bold text-on-surface">Configuration Email</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Serveur SMTP</label>
                <input type="text" name="setting_smtp_host"
                    value="<?= htmlspecialchars($settings['smtp_host']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700"
                    placeholder="smtp.gmail.com">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Port SMTP</label>
                <input type="number" name="setting_smtp_port"
                    value="<?= htmlspecialchars($settings['smtp_port']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700"
                    placeholder="587">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Nom d'utilisateur SMTP</label>
                <input type="text" name="setting_smtp_username"
                    value="<?= htmlspecialchars($settings['smtp_username']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Mot de passe SMTP</label>
                <input type="password" name="setting_smtp_password"
                    value="<?= htmlspecialchars($settings['smtp_password']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email d'expédition</label>
                <input type="email" name="setting_email_from"
                    value="<?= htmlspecialchars($settings['email_from']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Email de réponse</label>
                <input type="email" name="setting_email_reply_to"
                    value="<?= htmlspecialchars($settings['email_reply_to']['setting_value'] ?? '') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
        </div>
    </div>

    <!-- Académique -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-primary text-2xl">school</span>
            <h3 class="text-lg font-bold text-on-surface">Paramètres Académiques</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Semestres par an</label>
                <input type="number" name="setting_semesters_per_year"
                    value="<?= htmlspecialchars($settings['semesters_per_year']['setting_value'] ?? '2') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Crédits ECTS par semestre</label>
                <input type="number" name="setting_credits_per_semester"
                    value="<?= htmlspecialchars($settings['credits_per_semester']['setting_value'] ?? '30') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Seuil de validation (/20)</label>
                <input type="number" step="0.5" name="setting_passing_grade"
                    value="<?= htmlspecialchars($settings['passing_grade']['setting_value'] ?? '10') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
        </div>
    </div>

    <!-- Sécurité -->
    <div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 p-6">
        <div class="flex items-center gap-3 mb-6">
            <span class="material-symbols-outlined text-primary text-2xl">security</span>
            <h3 class="text-lg font-bold text-on-surface">Paramètres de Sécurité</h3>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Durée de session (secondes)</label>
                <input type="number" name="setting_session_timeout"
                    value="<?= htmlspecialchars($settings['session_timeout']['setting_value'] ?? '3600') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Max tentatives de connexion</label>
                <input type="number" name="setting_max_login_attempts"
                    value="<?= htmlspecialchars($settings['max_login_attempts']['setting_value'] ?? '5') ?>"
                    class="w-full bg-surface-container-low border-none rounded-lg py-2.5 px-4 focus:ring-2 focus:ring-primary font-medium text-slate-700">
            </div>
            <div class="md:col-span-2">
                <label class="flex items-center gap-3">
                    <input type="checkbox" name="setting_maintenance_mode" value="true"
                        <?= ($settings['maintenance_mode']['setting_value'] ?? 'false') === 'true' ? 'checked' : '' ?>
                        class="w-5 h-5 rounded border-slate-300 text-primary focus:ring-primary">
                    <span class="text-sm font-medium text-slate-700">Mode maintenance activé</span>
                </label>
            </div>
        </div>
    </div>

    <div class="flex justify-end">
        <button type="submit"
            class="bg-primary text-white px-8 py-3 rounded-xl font-bold text-sm shadow-lg hover:opacity-90 active:scale-95 transition-all">
            Enregistrer les paramètres
        </button>
    </div>
</form>

<?php
include __DIR__ . '/includes/footer.php';
?>