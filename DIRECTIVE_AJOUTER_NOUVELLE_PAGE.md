# 📘 DIRECTIVE: Comment Ajouter une Nouvelle Page Frontend + Backend + Table BD

## ✅ Résumé Rapide

Pour ajouter une nouvelle fonctionnalité (ex: Gestion des Examens), suivez ces 4 étapes:

1. **Créer la table SQL** dans la BD
2. **Créer la classe Manager** dans DataManager.php
3. **Créer le fichier Backend** PHP
4. **Créer le fichier Frontend** PHP
5. **Ajouter le lien au Sidebar** (optionnel)

---

## 🗄️ ÉTAPE 1: CRÉER LA TABLE SQL

### Exemple: Table pour Gestion des Examens

```sql
-- 1. Créer la table
CREATE TABLE IF NOT EXISTS `examen` (
  `id_examen` INT(11) NOT NULL AUTO_INCREMENT,
  `code_examen` VARCHAR(20) NOT NULL UNIQUE,
  `nom_examen` VARCHAR(150) NOT NULL,
  `date_examen` DATE NOT NULL,
  `duree_minutes` INT(3) DEFAULT 120,
  `id_ue` INT(11) NOT NULL,
  `lieu` VARCHAR(100),
  `superviseur` VARCHAR(100),
  `statut` ENUM('Programmé','En cours','Terminé','Annulé') DEFAULT 'Programmé',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_examen`),
  KEY `id_ue` (`id_ue`),
  FOREIGN KEY (`id_ue`) REFERENCES `ue`(`id_ue`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- 2. Ajouter des données de test
INSERT INTO `examen` (code_examen, nom_examen, date_examen, id_ue) VALUES
('EX001', 'Examen Math Semestre 1', '2026-06-01', 1),
('EX002', 'Examen Physique Semestre 1', '2026-06-02', 2);
```

### Fichier à modifier:
**[gestion_notes_complete.sql](gestion_notes_complete.sql)** - Ajouter les CREATE TABLE

---

## 👨‍💼 ÉTAPE 2: CRÉER LE MANAGER DANS DataManager.php

### Location:
**[backend/classes/DataManager.php](backend/classes/DataManager.php)**

### Ajouter cette classe:

```php
/**
 * ====================================================
 * MANAGER: ExamenManager
 * ====================================================
 * Gère les opérations CRUD sur les examens
 */
class ExamenManager {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Récupérer tous les examens
     */
    public function getAll($limite = 100, $offset = 0) {
        $query = "SELECT e.*, u.libelle_ue 
                  FROM examen e
                  LEFT JOIN ue u ON e.id_ue = u.id_ue
                  ORDER BY e.date_examen ASC
                  LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("ii", $limite, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Récupérer un examen par ID
     */
    public function getById($id_examen) {
        $query = "SELECT e.*, u.libelle_ue, u.credits_ects
                  FROM examen e
                  LEFT JOIN ue u ON e.id_ue = u.id_ue
                  WHERE e.id_examen = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_examen);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    /**
     * Récupérer les examens d'une UE
     */
    public function getByUE($id_ue) {
        $query = "SELECT * FROM examen WHERE id_ue = ? ORDER BY date_examen ASC";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_ue);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Créer un nouvel examen
     */
    public function create($data) {
        $query = "INSERT INTO examen 
                  (code_examen, nom_examen, date_examen, duree_minutes, id_ue, lieu, superviseur, statut)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param(
            "sssiisss",
            $data['code_examen'],
            $data['nom_examen'],
            $data['date_examen'],
            $data['duree_minutes'],
            $data['id_ue'],
            $data['lieu'],
            $data['superviseur'],
            $data['statut'] ?? 'Programmé'
        );
        
        return $stmt->execute();
    }

    /**
     * Mettre à jour un examen
     */
    public function update($id_examen, $data) {
        $fields = [];
        $params = [];
        $types = "";

        foreach ($data as $key => $value) {
            if (in_array($key, ['code_examen', 'nom_examen', 'date_examen', 'duree_minutes', 'id_ue', 'lieu', 'superviseur', 'statut'])) {
                $fields[] = "$key = ?";
                $params[] = $value;
                $types .= is_int($value) ? "i" : "s";
            }
        }

        if (empty($fields)) return false;

        $params[] = $id_examen;
        $types .= "i";

        $query = "UPDATE examen SET " . implode(", ", $fields) . " WHERE id_examen = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param($types, ...$params);
        return $stmt->execute();
    }

    /**
     * Supprimer un examen
     */
    public function delete($id_examen) {
        $query = "DELETE FROM examen WHERE id_examen = ?";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("i", $id_examen);
        return $stmt->execute();
    }

    /**
     * Compter les examens par statut
     */
    public function countByStatut() {
        $query = "SELECT statut, COUNT(*) as count FROM examen GROUP BY statut";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
```

### Important:
- Ajouter le Manager à la fin du fichier DataManager.php
- Initialiser le manager dans les fichiers backend: `$examenManager = new ExamenManager($db);`

---

## 🖤 ÉTAPE 3: CRÉER LE FICHIER BACKEND

### Location:
**[backend/gestion_examens_backend.php](backend/gestion_examens_backend.php)** (nouveau fichier)

### Template:

```php
<?php
/**
 * ====================================================
 * BACKEND: Gestion des Examens
 * ====================================================
 * Gère la logique métier pour les examens (CRUD, filtrage)
 */

require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/classes/DataManager.php';

$examenManager = new ExamenManager($db);
$ueManager = new UEManager($db);
$db = getDB();

$message = '';
$type_message = '';

// ====================================
// 1. TRAITER LES SOUMISSIONS POST
// ====================================

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];

    // 1.1 - Créer un examen
    if ($action === 'create_examen') {
        $code_examen = trim($_POST['code_examen'] ?? '');
        $nom_examen = trim($_POST['nom_examen'] ?? '');
        $date_examen = $_POST['date_examen'] ?? date('Y-m-d');
        $duree_minutes = (int)($_POST['duree_minutes'] ?? 120);
        $id_ue = (int)($_POST['id_ue'] ?? 0);
        $lieu = trim($_POST['lieu'] ?? '');
        $superviseur = trim($_POST['superviseur'] ?? '');

        // Validation
        if (!$code_examen || !$nom_examen || !$id_ue) {
            $message = "Erreur : Code, nom et UE sont obligatoires.";
            $type_message = "error";
        } else {
            $data = [
                'code_examen' => $code_examen,
                'nom_examen' => $nom_examen,
                'date_examen' => $date_examen,
                'duree_minutes' => $duree_minutes,
                'id_ue' => $id_ue,
                'lieu' => $lieu,
                'superviseur' => $superviseur,
                'statut' => 'Programmé'
            ];

            if ($examenManager->create($data)) {
                $message = "Examen créé avec succès !";
                $type_message = "success";
            } else {
                $message = "Erreur lors de la création de l'examen.";
                $type_message = "error";
            }
        }
    }

    // 1.2 - Mettre à jour un examen
    elseif ($action === 'update_examen') {
        $id_examen = (int)($_POST['id_examen'] ?? 0);
        $data = [
            'statut' => $_POST['statut'] ?? 'Programmé',
            'nom_examen' => $_POST['nom_examen'] ?? '',
            'date_examen' => $_POST['date_examen'] ?? ''
        ];

        if ($examenManager->update($id_examen, $data)) {
            $message = "Examen mis à jour avec succès !";
            $type_message = "success";
        } else {
            $message = "Erreur lors de la mise à jour.";
            $type_message = "error";
        }
    }

    // 1.3 - Supprimer un examen
    elseif ($action === 'delete_examen') {
        $id_examen = (int)($_POST['id_examen'] ?? 0);

        if ($examenManager->delete($id_examen)) {
            $message = "Examen supprimé avec succès !";
            $type_message = "success";
        } else {
            $message = "Erreur lors de la suppression.";
            $type_message = "error";
        }
    }
}

// ====================================
// 2. RÉCUPÉRER LES DONNÉES DE LISTE
// ====================================

// Paramètres de pagination et filtrage
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limite = 50;
$offset = ($page - 1) * $limite;

$id_ue = isset($_GET['id_ue']) ? (int)$_GET['id_ue'] : 0;
$statut = isset($_GET['statut']) ? clean($_GET['statut']) : 'Programmé';

// Récupérer les UEs pour le filtre
$query = "SELECT id_ue, libelle_ue FROM ue ORDER BY libelle_ue";
$stmt = $db->prepare($query);
$stmt->execute();
$ues = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer la liste des examens
if ($id_ue) {
    $examens = $examenManager->getByUE($id_ue);
} else {
    $examens = $examenManager->getAll($limite, $offset);
}

// Compter les statistiques
$stats_examen = $examenManager->countByStatut();

?>
<!-- Le reste du code PHP s'affiche dans le frontend -->
```

---

## 🎨 ÉTAPE 4: CRÉER LE FICHIER FRONTEND

### Location:
**[Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/gestion_examens/gestion_examens.php](Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/Maquettes_de_gestion_acad_mique_lmd/gestion_examens/gestion_examens.php)** (nouveau dossier + fichier)

### Template:

```php
<?php
$page_title = 'Gestion des Examens';
$current_page = 'examens';
include __DIR__ . '/../../../../backend/includes/sidebar.php';
?>

<!-- Message Flash (si existe) -->
<?php if ($message): ?>
    <div class="mb-6 p-4 rounded-lg <?= $type_message === 'success' ? 'bg-green-50 text-green-800 border-l-4 border-green-500' : 'bg-red-50 text-red-800 border-l-4 border-red-500' ?> shadow-sm">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<!-- Header -->
<div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
    <div>
        <span class="text-xs font-bold text-primary tracking-widest uppercase mb-1 block">Calendrier</span>
        <h3 class="text-3xl font-extrabold text-on-surface tracking-tight">Gestion des Examens</h3>
        <p class="text-slate-500 mt-1 max-w-2xl">Programmez et suivez les examens par UE.</p>
    </div>
</div>

<!-- Grid Layout: Form + List -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Formulaire Création -->
    <div class="lg:col-span-1 bg-surface-container-lowest rounded-xl p-6 shadow-sm border border-slate-100/50 h-fit">
        <h4 class="text-lg font-bold mb-6 flex items-center gap-2">
            <span class="material-symbols-outlined bg-primary/10 p-1.5 rounded">calendar_add</span>
            Nouvel Examen
        </h4>
        
        <form method="POST" action="<?= $base_url . $backend_url ?>gestion_examens_backend.php" class="space-y-4">
            <input type="hidden" name="action" value="create_examen">
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Code</label>
                <input name="code_examen" required class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary" placeholder="EX001" />
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Nom</label>
                <input name="nom_examen" required class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary" placeholder="Examen Math" />
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Date</label>
                <input name="date_examen" type="date" required class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary" />
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">Durée (minutes)</label>
                <input name="duree_minutes" type="number" value="120" class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary" />
            </div>
            
            <div>
                <label class="text-xs font-bold text-slate-500 uppercase mb-1 block">UE</label>
                <select name="id_ue" required class="w-full bg-slate-50 border-none rounded-lg px-4 py-2 text-sm focus:ring-2 focus:ring-primary">
                    <option value="">-- Sélectionner --</option>
                    <?php foreach ($ues as $ue): ?>
                        <option value="<?= $ue['id_ue'] ?>"><?= htmlspecialchars($ue['libelle_ue']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <button type="submit" class="w-full bg-primary text-white py-2.5 rounded-lg font-bold text-sm hover:opacity-90 transition-all">
                CRÉER EXAMEN
            </button>
        </form>
    </div>

    <!-- Liste des Examens -->
    <div class="lg:col-span-2">
        <!-- Filtres -->
        <div class="mb-6 flex gap-3">
            <select onchange="window.location.href='?id_ue='+this.value" class="px-4 py-2 bg-white border border-slate-200 rounded-lg text-sm">
                <option value="">Toutes les UEs</option>
                <?php foreach ($ues as $ue): ?>
                    <option value="<?= $ue['id_ue'] ?>" <?= $id_ue == $ue['id_ue'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($ue['libelle_ue']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Tableau des Examens -->
        <div class="bg-surface-container-lowest rounded-xl shadow-sm border border-slate-100/50 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-surface-container border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3 text-left font-bold text-slate-600">Code</th>
                        <th class="px-6 py-3 text-left font-bold text-slate-600">Nom</th>
                        <th class="px-6 py-3 text-left font-bold text-slate-600">Date</th>
                        <th class="px-6 py-3 text-left font-bold text-slate-600">Statut</th>
                        <th class="px-6 py-3 text-center font-bold text-slate-600">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($examens)): ?>
                        <?php foreach ($examens as $examen): ?>
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-6 py-3 font-bold text-primary"><?= htmlspecialchars($examen['code_examen']) ?></td>
                                <td class="px-6 py-3"><?= htmlspecialchars($examen['nom_examen']) ?></td>
                                <td class="px-6 py-3"><?= formatDate($examen['date_examen']) ?></td>
                                <td class="px-6 py-3">
                                    <span class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold">
                                        <?= $examen['statut'] ?>
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-center">
                                    <button onclick="if(confirm('Supprimer ?')) {
                                        fetch('<?= $base_url . $backend_url ?>gestion_examens_backend.php', {
                                            method: 'POST',
                                            body: new FormData(Object.assign(document.createElement('form'), {
                                                elements: {
                                                    action: {value: 'delete_examen'},
                                                    id_examen: {value: <?= $examen['id_examen'] ?>}
                                                }
                                            }))
                                        }).then(() => location.reload());
                                    }" class="text-error hover:text-error/80 transition">
                                        <span class="material-symbols-outlined text-sm">delete</span>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="px-6 py-8 text-center text-slate-400">Aucun examen trouvé</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../../../../backend/includes/footer.php'; ?>
```

---

## 🧭 ÉTAPE 5: AJOUTER AU SIDEBAR (OPTIONNEL)

### Location:
**[backend/includes/sidebar.php](backend/includes/sidebar.php)** - Ligne ~25

### Ajouter cet élément au tableau $nav_items:

```php
$nav_items = [
    // ... éléments existants ...
    ['id' => 'examens', 'label' => 'Examens', 'icon' => 'calendar_today', 'href' => $backend_url . 'gestion_examens_backend.php'],
    // ... autres éléments ...
];
```

---

## 🔗 LIENS IMPORTANTS DES PAGES

Après créer une nouvelle page, assurez-vous que:

1. ✅ **Frontend appelle le bon Backend:**
   ```php
   <!-- Dans votre formulaire frontend: -->
   <form method="POST" action="<?= $base_url . $backend_url ?>gestion_examens_backend.php">
   ```

2. ✅ **Backend traite les POST:**
   ```php
   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']))
   ```

3. ✅ **Chemins des includes:**
   ```php
   <!-- Frontend: -->
   include __DIR__ . '/../../../../backend/includes/sidebar.php';
   
   <!-- Backend: -->
   require_once __DIR__ . '/../config/config.php';
   require_once __DIR__ . '/classes/DataManager.php';
   ```

4. ✅ **Lien au Sidebar (optionnel mais recommandé):**
   - Ajouter dans `$nav_items` array dans sidebar.php

---

## 📋 CHECKLIST - NOUVELLES FONCTIONNALITÉS

| Étape | Description | Fichier | ✅ |
|-------|-------------|---------|-----|
| 1 | Créer Table SQL | gestion_notes_complete.sql | ☐ |
| 2 | Créer Manager | backend/classes/DataManager.php | ☐ |
| 3 | Créer Backend | backend/gestion_examens_backend.php | ☐ |
| 4 | Créer Frontend | Maquettes/.../gestion_examens.php | ☐ |
| 5 | Ajouter au Sidebar | backend/includes/sidebar.php | ☐ |
| 6 | Tester les formulaires POST | - | ☐ |
| 7 | Vérifier les redirections | - | ☐ |

---

## 🚀 DÉMARRAGE RAPIDE

Pour une nouvelle fonctionnalité complete en 15 minutes:

1. **Copier-coller** le code Manager ci-dessus et l'adapter
2. **Copier-coller** le code Backend et remplacer `examen` par votre nom
3. **Copier-coller** le code Frontend et adapter le formulaire
4. **Ajouter** lors du sidebar
5. **Tester**!

---

## ⚠️ ERREURS COMMUNES À ÉVITER

❌ **NE PAS:**
- Oublier `require_once` du config et DataManager
- Laisser des `href="#"` dans les pages
- Laisser `action=""` dans les forms
- Oublier d'inclure le footer

✅ **TOUJOURS:**
- Valider les données POST côté serveur
- Utiliser `htmlspecialchars()` pour l'affichage
- Utiliser des `?` dans les requêtes SQL (prepared statements)
- Inclure sidebar.php et footer.php

---

**Bonne chance pour l'ajout de nouvelles fonctionnalités!** 🎉
