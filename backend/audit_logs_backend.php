<?php
/**
 * ====================================================
 * AUDIT LOGS - Backend
 * ====================================================
 * Visualisation des logs d'audit
 */

require_once __DIR__ . '/../config/config.php';

// Vérifier que l'utilisateur est admin
checkAuth(['Admin']);

$page = max(1, intval($_GET['page'] ?? 1));
$per_page = 50;
$offset = ($page - 1) * $per_page;
$date_start = $_GET['date_start'] ?? date('Y-m-01');
$date_end = $_GET['date_end'] ?? date('Y-m-d');
$user_filter = $_GET['user_id'] ?? '';
$action_filter = $_GET['action'] ?? '';
$table_filter = $_GET['table'] ?? '';

// Construire la clause WHERE
$where = [];
$params = [];
$types = '';

if ($date_start) {
    $where[] = "DATE(al.created_at) >= ?";
    $params[] = $date_start;
    $types .= 's';
}

if ($date_end) {
    $where[] = "DATE(al.created_at) <= ?";
    $params[] = $date_end;
    $types .= 's';
}

if ($user_filter) {
    $where[] = "al.user_id = ?";
    $params[] = $user_filter;
    $types .= 'i';
}

if ($action_filter) {
    $where[] = "al.action = ?";
    $params[] = $action_filter;
    $types .= 's';
}

if ($table_filter) {
    $where[] = "al.table_name = ?";
    $params[] = $table_filter;
    $types .= 's';
}

$where_clause = empty($where) ? '' : 'WHERE ' . implode(' AND ', $where);

// Compter le total
$count_query = "SELECT COUNT(*) as total FROM audit_log al $where_clause";
$total = safeQuerySingle($count_query, !empty($params) ? [$types, ...$params] : []);
$total_pages = ceil($total['total'] / $per_page);

// Récupérer les logs
$query = "SELECT al.*, u.nom, u.prenom, u.email 
          FROM audit_log al 
          LEFT JOIN utilisateur u ON al.user_id = u.id_utilisateur 
          $where_clause 
          ORDER BY al.created_at DESC 
          LIMIT $per_page OFFSET $offset";
$logs = safeQuery($query, !empty($params) ? [$types, ...$params] : []);

// Récupérer la liste des utilisateurs pour le filtre
$users = safeQuery("SELECT id_utilisateur, nom, prenom FROM utilisateur ORDER BY nom, prenom");

// Récupérer les tables uniques
$tables = safeQuery("SELECT DISTINCT table_name FROM audit_log WHERE table_name IS NOT NULL ORDER BY table_name");

// Récupérer les actions uniques
$actions = safeQuery("SELECT DISTINCT action FROM audit_log ORDER BY action");

$page_title = 'Audit Logs';
$current_page = 'audit';
include __DIR__ . '/includes/sidebar.php';
?>

<div class="mb-8">
    <h1 class="text-3xl font-extrabold text-on-surface tracking-tighter">Journal d'Audit</h1>
    <p class="text-slate-500 mt-2">Trace de toutes les actions effectuées sur le système.</p>
</div>

<!-- Filtres -->
<div class="bg-white p-6 rounded-xl border border-outline-variant/20 mb-6 shadow-sm">
    <form method="GET" class="flex flex-wrap gap-4">
        <div class="w-40">
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Date début</label>
            <input type="date" name="date_start" value="<?= htmlspecialchars($date_start) ?>"
                class="w-full bg-surface-container-low border-none rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-primary">
        </div>
        <div class="w-40">
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Date fin</label>
            <input type="date" name="date_end" value="<?= htmlspecialchars($date_end) ?>"
                class="w-full bg-surface-container-low border-none rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-primary">
        </div>
        <div class="w-40">
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Utilisateur</label>
            <select name="user_id"
                class="w-full bg-surface-container-low border-none rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-primary">
                <option value="">Tous</option>
                <?php foreach ($users as $u): ?>
                    <option value="<?= $u['id_utilisateur'] ?>" <?= $user_filter == $u['id_utilisateur'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u['nom'] . ' ' . $u['prenom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-32">
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Action</label>
            <select name="action"
                class="w-full bg-surface-container-low border-none rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-primary">
                <option value="">Toutes</option>
                <?php foreach ($actions as $a): ?>
                    <option value="<?= $a['action'] ?>" <?= $action_filter === $a['action'] ? 'selected' : '' ?>>
                        <?= $a['action'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-32">
            <label class="block text-[10px] font-bold text-slate-500 uppercase mb-1">Table</label>
            <select name="table"
                class="w-full bg-surface-container-low border-none rounded-lg py-2 px-3 text-sm focus:ring-2 focus:ring-primary">
                <option value="">Toutes</option>
                <?php foreach ($tables as $t): ?>
                    <option value="<?= $t['table_name'] ?>" <?= $table_filter === $t['table_name'] ? 'selected' : '' ?>>
                        <?= $t['table_name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit"
                class="bg-primary text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-primary-container transition-colors">
                Filtrer
            </button>
            <a href="audit_logs_backend.php"
                class="bg-surface-container-low text-slate-700 px-6 py-2 rounded-lg font-bold text-sm hover:bg-surface-container-high transition-colors">
                Reset
            </a>
            <a href="?action=export<?= !empty($_SERVER['QUERY_STRING']) ? '&' . $_SERVER['QUERY_STRING'] : '' ?>"
                class="bg-secondary text-white px-6 py-2 rounded-lg font-bold text-sm hover:bg-secondary-container transition-colors">
                Export CSV
            </a>
        </div>
    </form>
</div>

<!-- Stats -->
<div class="grid grid-cols-4 gap-4 mb-6">
    <div class="bg-white p-4 rounded-xl border border-outline-variant/20">
        <p class="text-xs font-bold text-slate-500 uppercase">Total Actions</p>
        <p class="text-2xl font-bold text-primary"><?= $total['total'] ?></p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-outline-variant/20">
        <p class="text-xs font-bold text-slate-500 uppercase">INSERT</p>
        <p class="text-2xl font-bold text-green-600"><?= array_sum(array_column($logs, 'action') == 'INSERT') ?></p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-outline-variant/20">
        <p class="text-xs font-bold text-slate-500 uppercase">UPDATE</p>
        <p class="text-2xl font-bold text-blue-600"><?= array_sum(array_column($logs, 'action') == 'UPDATE') ?></p>
    </div>
    <div class="bg-white p-4 rounded-xl border border-outline-variant/20">
        <p class="text-xs font-bold text-slate-500 uppercase">DELETE</p>
        <p class="text-2xl font-bold text-error"><?= array_sum(array_column($logs, 'action') == 'DELETE') ?></p>
    </div>
</div>

<!-- Tableau des logs -->
<div class="bg-white rounded-xl shadow-sm border border-outline-variant/20 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-slate-50 border-b border-outline-variant/20">
                <tr>
                    <th class="px-4 py-3 font-bold text-slate-600">Date/Heure</th>
                    <th class="px-4 py-3 font-bold text-slate-600">Utilisateur</th>
                    <th class="px-4 py-3 font-bold text-slate-600">Action</th>
                    <th class="px-4 py-3 font-bold text-slate-600">Table</th>
                    <th class="px-4 py-3 font-bold text-slate-600">ID Record</th>
                    <th class="px-4 py-3 font-bold text-slate-600">IP</th>
                    <th class="px-4 py-3 font-bold text-slate-600">Détails</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                <?php if (empty($logs)): ?>
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-slate-400">Aucun log trouvé pour cette période.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($logs as $log): ?>
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-4 py-3 text-slate-600">
                                <?= date('d/m/Y H:i:s', strtotime($log['created_at'])) ?>
                            </td>
                            <td class="px-4 py-3">
                                <div class="font-medium text-slate-800">
                                    <?= htmlspecialchars($log['nom'] . ' ' . $log['prenom']) ?></div>
                                <div class="text-xs text-slate-500"><?= htmlspecialchars($log['email'] ?? '') ?></div>
                            </td>
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-bold uppercase
                                    <?= $log['action'] === 'INSERT' ? 'bg-green-100 text-green-700' : '' ?>
                                    <?= $log['action'] === 'UPDATE' ? 'bg-blue-100 text-blue-700' : '' ?>
                                    <?= $log['action'] === 'DELETE' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-600' ?>
                                ">
                                    <?= htmlspecialchars($log['action']) ?>
                                </span>
                            </td>
                            <td class="px-4 py-3 text-slate-600 font-mono text-xs">
                                <?= htmlspecialchars($log['table_name'] ?? '-') ?>
                            </td>
                            <td class="px-4 py-3 text-slate-600 font-mono text-xs">
                                <?= $log['record_id'] ?? '-' ?>
                            </td>
                            <td class="px-4 py-3 text-slate-600 font-mono text-xs">
                                <?= htmlspecialchars($log['ip_address'] ?? '-') ?>
                            </td>
                            <td class="px-4 py-3">
                                <button onclick="viewLogDetails(<?= $log['id_audit'] ?>)"
                                    class="text-primary hover:underline text-xs font-medium">
                                    Voir détails
                                </button>
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
                    <a href="?page=<?= $page - 1 ?><?= !empty($_SERVER['QUERY_STRING']) ? '&' . preg_replace('/page=\d+/', '', $_SERVER['QUERY_STRING']) : '' ?>"
                        class="px-4 py-2 bg-surface-container-low rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">
                        Précédent
                    </a>
                <?php endif; ?>
                <?php if ($page < $total_pages): ?>
                    <a href="?page=<?= $page + 1 ?><?= !empty($_SERVER['QUERY_STRING']) ? '&' . preg_replace('/page=\d+/', '', $_SERVER['QUERY_STRING']) : '' ?>"
                        class="px-4 py-2 bg-surface-container-low rounded-lg text-sm font-medium hover:bg-surface-container-high transition-colors">
                        Suivant
                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Modal Détails Log -->
<div id="log-modal"
    class="modal-container fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/40 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-in zoom-in duration-300">
        <div class="p-6 bg-primary text-white flex justify-between items-center">
            <h4 class="text-sm font-black tracking-tight uppercase">Détails du Log</h4>
            <button type="button" onclick="closeLogModal()" class="hover:bg-white/10 p-1 rounded-full">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-8">
            <div id="log-details" class="space-y-4">
                <!-- Rempli par JS -->
            </div>
        </div>
    </div>
</div>

<script>
    function viewLogDetails(logId) {
        fetch(`?action=view_details&id=${logId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const details = data.log;
                    let html = `
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Date</p>
                            <p class="text-sm font-medium">${details.created_at}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">IP</p>
                            <p class="text-sm font-medium">${details.ip_address || '-'}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Action</p>
                            <p class="text-sm font-medium">${details.action}</p>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase">Table</p>
                            <p class="text-sm font-medium">${details.table_name || '-'}</p>
                        </div>
                    </div>
                `;

                    if (details.old_values) {
                        html += `
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-2">Anciennes valeurs</p>
                            <pre class="bg-slate-100 p-3 rounded-lg text-xs overflow-auto max-h-40">${JSON.stringify(JSON.parse(details.old_values), null, 2)}</pre>
                        </div>
                    `;
                    }

                    if (details.new_values) {
                        html += `
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase mb-2">Nouvelles valeurs</p>
                            <pre class="bg-slate-100 p-3 rounded-lg text-xs overflow-auto max-h-40">${JSON.stringify(JSON.parse(details.new_values), null, 2)}</pre>
                        </div>
                    `;
                    }

                    document.getElementById('log-details').innerHTML = html;
                    document.getElementById('log-modal').classList.remove('hidden');
                    document.getElementById('log-modal').classList.add('flex');
                }
            });
    }

    function closeLogModal() {
        document.getElementById('log-modal').classList.add('hidden');
        document.getElementById('log-modal').classList.remove('flex');
    }

    document.getElementById('log-modal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeLogModal();
        }
    });
</script>

<?php
include __DIR__ . '/includes/footer.php';

// Handle export
if (isset($_GET['action']) && $_GET['action'] === 'export') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename="audit_logs_' . date('Y-m-d') . '.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['ID', 'Date', 'User', 'Action', 'Table', 'Record ID', 'IP', 'Old Values', 'New Values']);

    foreach ($logs as $log) {
        fputcsv($output, [
            $log['id_audit'],
            $log['created_at'],
            ($log['nom'] ?? '') . ' ' . ($log['prenom'] ?? ''),
            $log['action'],
            $log['table_name'] ?? '',
            $log['record_id'] ?? '',
            $log['ip_address'] ?? '',
            $log['old_values'] ?? '',
            $log['new_values'] ?? ''
        ]);
    }

    fclose($output);
    exit;
}

// Handle view details
if (isset($_GET['action']) && $_GET['action'] === 'view_details') {
    $id = intval($_GET['id'] ?? 0);
    $log = safeQuerySingle("SELECT * FROM audit_log WHERE id_audit = ?", [$id]);

    if ($log) {
        echo json_encode(['success' => true, 'log' => $log]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Log non trouvé.']);
    }
    exit;
}
?>