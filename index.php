<?php
/**
 * ====================================================
 * INDEX PRINCIPAL - Dashboard
 * ====================================================
 * Point d'accès à l'application
 */

require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/backend/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$db = getDB();

// Récupérer les statistiques du tableau de bord
$query = "SELECT 
            COUNT(DISTINCT e.id_etudiant) as total_etudiants,
            COUNT(DISTINCT f.id_filiere) as total_filieres,
            COUNT(DISTINCT n.id_note) as total_notes,
            AVG(n.valeur_note) as moyenne_generale,
            SUM(CASE WHEN e.statut = 'Actif' THEN 1 ELSE 0 END) as etudiants_actifs,
            SUM(CASE WHEN e.statut = 'Diplômé' THEN 1 ELSE 0 END) as etudiants_diplomes
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          LEFT JOIN note n ON e.id_etudiant = n.id_etudiant";

$stats = safeQuerySingle($query);
if (!$stats) {
    $stats = [
        'total_etudiants' => 0,
        'total_filieres' => 0,
        'total_notes' => 0,
        'moyenne_generale' => 0,
        'etudiants_actifs' => 0,
        'etudiants_diplomes' => 0
    ];
}

// Récupérer les étudiants récemment inscrits
$query = "SELECT e.*, f.nom_filiere 
          FROM etudiant e
          LEFT JOIN filiere f ON e.id_filiere = f.id_filiere
          ORDER BY e.date_inscription DESC
          LIMIT 10";

$etudiants_recents = safeQuery($query);
if (!$etudiants_recents) {
    $etudiants_recents = [];
}

?>
<?php
$page_title = 'Tableau de Bord Académique';
$current_page = 'dashboard';
include __DIR__ . '/backend/includes/sidebar.php';
?>
<!-- Header Section -->
<div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">Aperçu Général</span>
        <h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Tableau de bord académique</h3>
        <p class="text-slate-500 mt-1 max-w-2xl">Visualisez les statistiques clés et les dernières activités de votre
            établissement.</p>
    </div>
    <div class="flex items-center gap-2">
        <button onclick="exportDashboard()"
            class="px-5 py-2.5 bg-white border border-outline-variant/30 text-slate-700 font-semibold text-sm rounded-md shadow-sm hover:bg-slate-50 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-lg">picture_as_pdf</span>
            Exporter les données
        </button>
        <button onclick="location.reload()"
            class="px-5 py-2.5 bg-primary text-white font-semibold text-sm rounded-md shadow-sm hover:bg-primary-container transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-sm">refresh</span>
            Actualiser
        </button>
    </div>
</div>

<!-- Statistics Cards Grid -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
        <div class="flex items-center justify-between mb-3">
            <span class="material-symbols-outlined text-3xl text-primary" data-icon="groups">groups</span>
            <span class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Total</span>
        </div>
        <div class="card-value text-3xl font-bold text-primary mb-1"><?php echo $stats['total_etudiants'] ?? 0; ?></div>
        <div class="card-label text-sm text-slate-500">Étudiants inscrits</div>
        <div class="mt-3 pt-3 border-t border-outline-variant/10 flex justify-between text-xs">
            <span class="text-green-600">Actifs: <?php echo $stats['etudiants_actifs'] ?? 0; ?></span>
            <span class="text-blue-600">Diplômés: <?php echo $stats['etudiants_diplomes'] ?? 0; ?></span>
        </div>
    </div>

    <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
        <div class="flex items-center justify-between mb-3">
            <span class="material-symbols-outlined text-3xl text-secondary" data-icon="account_tree">account_tree</span>
            <span class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Filières</span>
        </div>
        <div class="card-value text-3xl font-bold text-secondary mb-1">
            <?php echo $stats['total_filieres'] ?? 0; ?></div>
            <div class="card-label text-sm text-slate-500">Filières actives</div>
            <div class="mt-3 pt-3 border-t border-outline-variant/10 text-xs text-slate-400">
                Licences • Masters • Doctorat
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="material-symbols-outlined text-3xl text-tertiary" data-icon="school">school</span>
                <span
                    class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Moyenne</span>
            </div>
            <div class="card-value text-3xl font-bold text-tertiary mb-1">
                <?php echo round($stats['moyenne_generale'] ?? 0, 2); ?><span class="text-lg">/20</span></div>
            <div class="card-label text-sm text-slate-500">Moyenne générale</div>
            <div class="mt-3 pt-3 border-t border-outline-variant/10 text-xs text-slate-400">
                Toutes filières confondues
            </div>
        </div>

        <div class="bg-surface-container-lowest p-6 rounded-xl shadow-sm border border-outline-variant/10 stat-card">
            <div class="flex items-center justify-between mb-3">
                <span class="material-symbols-outlined text-3xl text-primary-container"
                    data-icon="receipt">receipt</span>
                <span
                    class="text-xs font-bold text-slate-400 bg-surface-container px-2 py-1 rounded-full">Évaluations</span>
            </div>
            <div class="card-value text-3xl font-bold text-primary-container mb-1">
                <?php echo $stats['total_notes'] ?? 0; ?></div>
                <div class="card-label text-sm text-slate-500">Notes enregistrées</div>
                <div class="mt-3 pt-3 border-t border-outline-variant/10 text-xs text-slate-400">
                    Sessions en cours
                </div>
            </div>
        </div>

        <!-- Modules Section -->
        <section class="bg-surface-container p-8 rounded-xl">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary" data-icon="apps">apps</span>
                <h4 class="text-lg font-bold text-on-surface">Modules d'application</h4>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3">
                <a href="backend/repertoire_etudiants_backend.php"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">group</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Répertoire
                        Étudiants</span>
                </a>
                <a href="backend/maquette_lmd_backend.php"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">library_books</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Maquettes LMD</span>
                </a>
                <a href="backend/gestion_filieres_ue_backend.php"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">account_tree</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Gestion UE/EC</span>
                </a>
                <a href="backend/configuration_coefficients_backend.php"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">settings</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Configuration</span>
                </a>
                <a href="backend/parcours_academique_backend.php?id=1"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">timeline</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Parcours Étudiant</span>
                </a>
                <a href="backend/carte_etudiant_backend.php?id=1"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">badge</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Carte Étudiant</span>
                </a>
                <a href="backend/attestation_backend.php?id=1"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">description</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Attestation</span>
                </a>
                <a href="backend/gestion_sessions_rattrapage_backend.php"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">autorenew</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Sessions Rattrapage</span>
                </a>
                <a href="backend/deliberation_backend.php"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">gavel</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Délibérations</span>
                </a>
                <a href="backend/proces_verbal_backend.php"
                    class="group flex items-center gap-3 p-3 bg-surface-container-lowest rounded-lg border border-outline-variant/10 hover:border-primary hover:shadow-md transition-all">
                    <span class="material-symbols-outlined text-primary text-2xl">receipt_long</span>
                    <span class="text-sm font-medium text-slate-700 group-hover:text-primary">Procès-Verbaux</span>
                </a>
            </div>
        </section>

        <!-- Recent Students Section -->
        <section class="bg-surface-container p-8 rounded-xl">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-primary" data-icon="recent_actors">recent_actors</span>
                <h4 class="text-lg font-bold text-on-surface">Étudiants récemment inscrits</h4>
                <span class="text-xs bg-primary-container/20 text-primary px-2 py-1 rounded-full ml-auto">Derniers 10
                    inscrits</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-outline-variant/30">
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Matricule</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Nom & Prénom</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Filière</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Statut</th>
                            <th class="text-left py-3 px-4 text-xs font-bold text-slate-500 uppercase tracking-wider">
                                Date Inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($etudiants_recents as $et): ?>
                            <tr class="border-b border-outline-variant/10 hover:bg-surface-container-low transition-colors">
                                <td class="py-3 px-4 text-sm font-mono text-slate-600">
                                    <?php echo htmlspecialchars($et['matricule']); ?></td>
                                <td class="py-3 px-4 text-sm font-medium text-slate-800">
                                    <?php echo htmlspecialchars($et['nom'] . ' ' . $et['prenom']); ?></td>
                                <td class="py-3 px-4 text-sm text-slate-600">
                                    <?php echo htmlspecialchars($et['nom_filiere'] ?? 'N/A'); ?></td>
                                <td class="py-3 px-4">
                                    <?php if ($et['statut'] == 'Actif'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-green-50 text-green-700 rounded-full text-xs font-semibold">
                                            <span class="material-symbols-outlined text-xs"
                                                data-icon="check_circle">check_circle</span>
                                            Actif
                                        </span>
                                    <?php elseif ($et['statut'] == 'Diplômé'): ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-semibold">
                                            <span class="material-symbols-outlined text-xs" data-icon="school">school</span>
                                            Diplômé
                                        </span>
                                    <?php else: ?>
                                        <span
                                            class="inline-flex items-center gap-1 px-2 py-1 bg-gray-50 text-gray-600 rounded-full text-xs font-semibold">
                                            <span class="material-symbols-outlined text-xs" data-icon="pending">pending</span>
                                            <?php echo htmlspecialchars($et['statut']); ?>
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 px-4 text-sm text-slate-500">
                                    <?php echo formatDate($et['date_inscription']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <?php if (empty($etudiants_recents)): ?>
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-5xl text-slate-300 mb-3">person_off</span>
                    <p class="text-slate-500">Aucun étudiant inscrit pour le moment</p>
                </div>
            <?php endif; ?>

            <div class="mt-6 text-right">
                <a href="backend/repertoire_etudiants_backend.php"
                    class="inline-flex items-center gap-2 text-primary text-sm font-semibold hover:underline">
                    Voir tous les étudiants
                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                </a>
            </div>
        </section>
        <?php include __DIR__ . '/backend/includes/footer.php'; ?>
</main>

<script>
function exportDashboard() {
    // Crée un lien temporaire pour télécharger l'export
    const link = document.createElement('a');
    link.href = '/kara_project/backend/export_etudiants.php?format=pdf';
    link.download = 'dashboard_' + new Date().toISOString().split('T')[0] + '.pdf';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function exportReport() {
    window.location.href = '/kara_project/backend/rapport_pdf_backend.php';
}
</script>