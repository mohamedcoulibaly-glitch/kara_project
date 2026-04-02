# 📋 AUDIT COMPLET - FONCTIONNALITÉS ET PAGES MANQUANTES

---

## 🔴 **BOUTONS/LIENS NON-FONCTIONNELS TROUVÉS (21 liens cassés)**

### **Problème 1 : tab_de_bord.php** 
Fichier : `Maquettes_de_gestion_acad_mique_lmd/.../tableau_de_bord_acad_mique/tab_de_bord.php`

**7 liens cassés :**
- Ligne 95 : `<a href="#">Dashboard</a>` → Devrait aller à `index.php`
- Ligne 99 : `<a href="#">Étudiants</a>` → Devrait aller à `repertoire_etudiants_backend.php`
- Ligne 103 : `<a href="#">Notes</a>` → Devrait aller à `saisie_notes_par_ec_backend.php`
- Ligne 107 : `<a href="#">Délibérations</a>` → Devrait aller à `deliberation_backend.php`
- Ligne 111 : `<a href="#">Statistiques</a>` → Devrait aller à `statistiques_reussites_backend.php`
- Ligne 117 : `<a href="#">Déconnexion</a>` → Devrait aller à `logout.php`
- Ligne 273 : `<a href="#">Voir tout</a>` → Devrait aller à `statistiques_reussites_backend.php`

### **Problème 2 : code.php**  
Fichier : `Maquettes_de_gestion_acad_mique_lmd/.../tableau_de_bord_acad_mique/code.php`

**7 liens cassés (même problème) :**
- Ligne 95, 99, 103, 107, 111, 117, 273

### **Problème 3 : saisie_notes.php**
Fichier : `Maquettes_de_gestion_acad_mique_lmd/.../saisie_des_notes_moyennes/saisie_notes.php`

**6 liens cassés :**
- Lignes 122, 126, 130, 134, 138, 144 : Navigation complètement cassée

### **Problème 4 : configuration_des_coefficients_ue_ec.php** ⚠️ CRITIQUE
Fichier : `Maquettes_de_gestion_acad_mique_lmd/.../configuration_des_coefficients_ue_ec/configuration_des_coefficients_ue_ec.php`

**Ligne 22 :** `<form method="POST" action="" id="config-filter-form"...>`

**Issue :** Formulaire POST avec action vide = ne sauvegarde rien

**Fix :** Doit être `action="<?= $base_url . $backend_url ?>configuration_coefficients_backend.php"`

### **Problème 5 : gestion_filiere_res_ue.php**
Fichier : `Maquettes_de_gestion_acad_mique_lmd/.../gestion_fili_res_ue/gestion_filiere_res_ue.php`

**Ligne 59 :** Formulaire GET sans action spécifiée

**Fix :** Doit être `action="<?= $base_url . $backend_url ?>gestion_filieres_ue_backend.php"`

---

## 📱 **PAGES FRONTEND À CRÉER - PAR ORDRE DE PRIORITÉ**

### 🔴 **PRIORITÉ CRITIQUE**

---

#### **1️⃣ LOGIN PAGE** (`login.php`)

**État actuel :**
- ❌ Aucun formulaire de login
- ❌ Sessions créées sans authentification réelle
- ❌ Pas de validation de mot de passe

**Frontend à créer :**
```
login.php doit contenir:
- Formulaire avec champs:
  * Email ou Username
  * Password
  * Checkbox "Rester connecté"
- Messages d'erreur (Email invalide, Password incorrect, Compte inactif)
- Responsive theme accordé avec le reste du site
- Link vers "Mot de passe oublié" (future feature)
```

**Backend à implémenter :**

**Fichier : `backend/login_backend.php`**

Doit gérer :
```php
01. Recevoir POST avec email + password
02. Vérifier que email existe dans table "utilisateur"
03. Vérifier que password match avec password_verify()
04. Vérifier que utilisateur.status = 'actif'
05. Si tout OK:
    - Créer $_SESSION['user_id'] = utilisateur.id
    - Créer $_SESSION['user_role'] = utilisateur.role
    - Créer $_SESSION['user_email'] = utilisateur.email
    - Créer $_SESSION['user_name'] = utilisateur.nom
    - Logger tentative LOGIN dans audit_log
    - UPDATE utilisateur SET last_login = NOW()
    - Rediriger vers index.php
06. Si erreur:
    - Logger tentative FAILED_LOGIN dans audit_log
    - Retourner erreur JSON ou rediriger avec message
    - Incrémenter failed_login_attempts
    - Si failed_login_attempts >= 5: bloquer compte temporairement
```

**Queries SQL nécessaires :**
```sql
SELECT id, email, password, role, status, last_login 
FROM utilisateur 
WHERE email = ? AND status = 'actif'

UPDATE utilisateur 
SET last_login = NOW(), failed_login_attempts = 0 
WHERE id = ?

UPDATE utilisateur 
SET failed_login_attempts = failed_login_attempts + 1 
WHERE email = ?
```

**Table utilisateur doit avoir :**
```sql
- id (int, PK)
- email (varchar, UNIQUE)
- password (varchar, hashed)
- nom (varchar)
- prenom (varchar)
- role (enum: 'admin', 'coordinateur', 'enseignant', 'viewer')
- status (enum: 'actif', 'inactif', 'suspendu')
- created_at (datetime)
- updated_at (datetime)
- last_login (datetime)
- failed_login_attempts (int, default 0)
```

---

#### **2️⃣ USER MANAGEMENT PANEL** (`gestion_utilisateurs_backend.php`)

**État actuel :**
- ❌ Pas d'interface d'administration des utilisateurs
- ❌ Hardcodé "Admin_Kara" partout
- ❌ Impossible de créer/modifier/supprimer utilisateurs

**Frontend à créer :**
```
Page avec:
- TABLE d'utilisateurs (paginée, 50 par page):
  * Colonnes: Email, Nom, Rôle, Status, Créé le, Dernier login, Actions
  * Tri par: Email, Rôle, Status, Date
  
- FILTRES en haut de table:
  * Recherche par email/nom (live search)
  * Filtre par Rôle (dropdown)
  * Filtre par Status (dropdown)
  * Date range (created_at)
  
- BOUTONS:
  * "Ajouter utilisateur" → Ouvre modal
  * "Éditer" (par ligne) → Ouvre modal
  * "Supprimer" (par ligne) → Demande confirmation
  * "Réinitialiser password" (par ligne) → Génère password temporaire + envoie email
  
- MODAL Ajouter/Éditer:
  * Email (required, unique)
  * Nom complet (required)
  * Rôle (dropdown: admin, coordinateur, enseignant, viewer)
  * Status (dropdown: actif, inactif, suspendu)
  * Password (required pour nouveau, optional pour édition)
  * Confirm password
  * Bouton Sauvegarder / Annuler
  
- TABLEAU extra pour actions de masse:
  * Checkbox "Sélectionner tout"
  * Bouton "Désactiver sélection"
  * Bouton "Activer sélection"
  * Bouton "Réinitialiser passwords sélection"
```

**Backend à implémenter :**

**Fichier : `backend/gestion_utilisateurs_backend.php`**

Doit gérer :
```php
01. ACTION: list
    - Récupère utilisateurs avec pagination
    - Applique filtres (recherche, rôle, status, date)
    - Retourne JSON ou HTML table
    - Vérifie permission: ADMIN only
    - Query: SELECT * FROM utilisateur WHERE ... LIMIT offset, 50
    
02. ACTION: add
    - Reçoit: email, nom, prenom, role, status, password
    - Vérifie email n'existe pas (UNIQUE)
    - Hash password avec password_hash($password, PASSWORD_DEFAULT)
    - INSERT dans utilisateur
    - Logger action dans audit_log (user=current, action=INSERT, table=utilisateur)
    - Retourne success + envoie email bienvenu (future feature)
    - Vérifie permission: ADMIN only
    - Valide email format + password strength
    
03. ACTION: edit
    - Reçoit: user_id, email, nom, prenom, role, status
    - Vérifie user_id existe (sauf si modifiant soi-même pour certains champs)
    - UPDATE utilisateur SET ... WHERE id = user_id
    - Logger action dans audit_log avec old_values vs new_values
    - Retourne success
    - Vérifie permission: ADMIN ou user edit their own profile
    
04. ACTION: delete
    - Reçoit: user_id
    - Soft delete: UPDATE utilisateur SET status='suspendu', deleted_at=NOW()
    - Ou Hard delete: DELETE FROM utilisateur WHERE id = user_id
    - Logger action dans audit_log
    - Vérifie: user_id ≠ current user (cannot delete yourself)
    - Vérifie permission: ADMIN only
    
05. ACTION: reset_password
    - Reçoit: user_id
    - Génère password temporaire (12 caractères random)
    - Hash et UPDATE utilisateur SET password = hashed_temp_password
    - Logger action dans audit_log
    - Retourne le temp password (user doit le changer au prochain login)
    - Envoie email avec temp password (future feature)
    - Next login doit forcer change password
    
06. ACTION: change_password
    - Reçoit: old_password, new_password, confirm_password
    - Vérifie old_password match (password_verify)
    - Valide new_password != old_password + strength
    - UPDATE utilisateur SET password = hash(new_password)
    - Logger action
    - Retourne success
    - Accessible pour user self + admin
```

**Queries SQL :**
```sql
SELECT COUNT(*) FROM utilisateur WHERE 1=1 [filters]

SELECT id, email, nom, prenom, role, status, created_at, last_login 
FROM utilisateur 
WHERE 1=1 [filters]
ORDER BY email ASC
LIMIT ?, 50

INSERT INTO utilisateur (email, nom, prenom, password, role, status, created_at)
VALUES (?, ?, ?, ?, ?, ?, NOW())

UPDATE utilisateur 
SET email=?, nom=?, prenom=?, role=?, status=?, updated_at=NOW()
WHERE id=?

UPDATE utilisateur 
SET status='suspendu', deleted_at=NOW()
WHERE id=?

UPDATE utilisateur 
SET password=?, must_change_password=1, updated_at=NOW()
WHERE id=?
```

---

#### **3️⃣ USER PROFILE PAGE** (`profil_utilisateur_backend.php`)

**État actuel :**
- ❌ Pas de page profil utilisateur
- ❌ Utilisateur ne peut pas modifier ses infos
- ❌ Pas de changement de password interface

**Frontend à créer :**
```
Page avec 2 sections:

SECTION 1: Profil Personnel
- Affiche: Email (read-only), Nom, Prénom, Rôle (read-only)
- Bouton "Modifier" → Actif champs Nom et Prénom
- Champs editables: Nom complet, Prénom
- Bouton Sauvegarder / Annuler
- Message success/error après save

SECTION 2: Sécurité
- Formulaire "Changer le mot de passe":
  * Ancien mot de passe (required)
  * Nouveau mot de passe (required)
  * Confirmer mot de passe (required)
  * Validations visibles en temps réel
  * Bouton "Changer mot de passe"
- Info: "Dernier changement: XX jours"
- Info: "Dernier login: YYYY-MM-DD HH:MM"
- Bouton "Logout de toutes les sessions"

SECTION 3: Activité (optional)
- Liste des 10 dernières activités de l'utilisateur
- Colonnes: Date/Heure, Action, Détails
```

**Backend à implémenter :**

**Fichier : `backend/profil_utilisateur_backend.php`**

Doit gérer :
```php
01. ACTION: view (default)
    - Récupère données utilisateur actuel: $_SESSION['user_id']
    - Query: SELECT * FROM utilisateur WHERE id = ?
    - Affiche profil en HTML
    
02. ACTION: update_profile
    - Reçoit: nom, prenom
    - Valide: nom et prenom pas vides
    - UPDATE utilisateur SET nom=?, prenom=?, updated_at=NOW() WHERE id=?
    - Logger action dans audit_log
    - Retourne success JSON
    
03. ACTION: change_password
    - Reçoit: old_password, new_password, confirm_password
    - Vérifie old_password avec password_verify (query user current)
    - Valide new_password != old_password
    - Valide new_password strength (min 8 chars, 1 uppercase, 1 number)
    - Valide new_password == confirm_password
    - UPDATE utilisateur SET password=hash(new_password), updated_at=NOW()
    - Logger action dans audit_log (type=CHANGE_PASSWORD)
    - Retourne success
    - Erreur si old_password incorrect
    
04. ACTION: logout_all_sessions
    - Supprime toutes les sessions de cet utilisateur
    - UPDATE utilisateur SET last_session_date=NOW()
    - DELETE FROM sessions WHERE user_id=?
    - Logout utilisateur actuel aussi
    - Rediriger vers login.php avec message "Tous les sessions fermées"
```

**Queries SQL :**
```sql
SELECT id, email, nom, prenom, role, status, last_login, created_at
FROM utilisateur
WHERE id = ?

UPDATE utilisateur
SET nom=?, prenom=?, updated_at=NOW()
WHERE id=?

UPDATE utilisateur
SET password=?, updated_at=NOW()
WHERE id=?

DELETE FROM sessions WHERE user_id=?
```

---

### 🟡 **PRIORITÉ HAUTE**

---

#### **4️⃣ AUDIT LOG VIEWER** (`audit_logs_backend.php`)

**État actuel :**
- ❌ Actions ne sont pas loggées
- ❌ Aucune traçabilité des changements
- ❌ Aucune accountability

**Frontend à créer :**
```
Page avec:

FILTRES en haut:
- Date de début / Date de fin (date range picker)
- Utilisateur (dropdown autocomplete)
- Action (dropdown: INSERT, UPDATE, DELETE, LOGIN, LOGOUT, EXPORT)
- Table affectée (dropdown: utilisateur, etudiant, filiere, note, etc.)
- Recherche libre dans "Détails"

TABLEAU paginé (100 par ligne):
Colonnes:
- Date/Heure (format: YYYY-MM-DD HH:MM:SS)
- Utilisateur (email)
- Action (INSERT/UPDATE/DELETE/LOGIN/LOGOUT)
- Table modifiée (utilisateur, etudiant, etc.)
- Enregistrement ID (le record_id affecté)
- Détails (bouton "Voir" → Ouvre modal avec anciennes vs nouvelles valeurs)
- Adresse IP

ACTIONS:
- Bouton "Exporter en CSV" (applique filtres)
- Bouton "Nettoyer anciens logs" (> 90 jours)
- Auto-refresh option (5 min, 15 min, 30 min, manual)

MODAL Voir Détails:
- Affiche en 2 colonnes: Ancienne valeur | Nouvelle valeur
- Pour DELETE: affiche les données supprimées
- Read-only, copiable
```

**Backend à implémenter :**

**Fichier : `backend/audit_logs_backend.php`**

Doit gérer :
```php
01. ACTION: list (default)
    - Récupère audit_log avec filtres et pagination
    - Filtres: date_from, date_to, user_id, action, table_name
    - ORDER BY timestamp DESC
    - Paginé: 100 par page
    - Retourne JSON ou HTML table
    - Vérifie permission: ADMIN ou COORDINATEUR
    
02. ACTION: view_detail
    - Reçoit: audit_log_id
    - SELECT FROM audit_log WHERE id = ?
    - Affiche old_values vs new_values en JSON pretty-print ou table
    - Retourne JSON
    
03. ACTION: export_csv
    - Applique filtres (date_from, date_to, user_id, action, table_name)
    - Génère CSV avec toutes les colonnes
    - Download file: audit_logs_YYYY-MM-DD_HHMMSS.csv
    - Vérifie permission: ADMIN
    
04. ACTION: cleanup_old
    - Reçoit: days (default 90)
    - DELETE FROM audit_log WHERE timestamp < DATE_SUB(NOW(), INTERVAL ? DAY)
    - Logger cette action même (meta-logging)
    - Retourne nombre de records supprimés
    - Vérifie permission: ADMIN only
    - Demander confirmation avant delete
```

**Table audit_log à créer :**
```sql
CREATE TABLE audit_log (
  id INT PRIMARY KEY AUTO_INCREMENT,
  user_id INT NOT NULL,
  action VARCHAR(50) NOT NULL,  -- INSERT, UPDATE, DELETE, LOGIN, LOGOUT
  table_name VARCHAR(100),
  record_id INT,
  old_values JSON,
  new_values JSON,
  ip_address VARCHAR(45),
  user_agent VARCHAR(255),
  timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES utilisateur(id)
);

CREATE INDEX idx_audit_timestamp ON audit_log(timestamp);
CREATE INDEX idx_audit_user_id ON audit_log(user_id);
CREATE INDEX idx_audit_action ON audit_log(action);
```

**Intégration dans tous les backends existants :**

Dans chaque `backend/[nom]_backend.php`, avant chaque INSERT/UPDATE/DELETE, ajouter:

```php
// AVANT INSERT
if ($action === 'add') {
  // ... sanitize input ...
  logAudit($_SESSION['user_id'], 'INSERT', 'table_name', null, null, $new_data);
  // INSERT query
}

// AVANT UPDATE
if ($action === 'edit') {
  // Récupérer ancienne data
  $old_data = getRecord('table_name', $id);
  $new_data = ['col1' => $val1, 'col2' => $val2];
  logAudit($_SESSION['user_id'], 'UPDATE', 'table_name', $id, $old_data, $new_data);
  // UPDATE query
}

// AVANT DELETE
if ($action === 'delete') {
  $old_data = getRecord('table_name', $id);
  logAudit($_SESSION['user_id'], 'DELETE', 'table_name', $id, $old_data, null);
  // DELETE query
}
```

**Fonction helper dans config/config.php :**
```php
function logAudit($user_id, $action, $table_name, $record_id, $old_values, $new_values) {
  global $pdo;
  $ip = $_SERVER['REMOTE_ADDR'] ?? 'N/A';
  $user_agent = $_SERVER['HTTP_USER_AGENT'] ?? 'N/A';
  
  $stmt = $pdo->prepare("
    INSERT INTO audit_log (user_id, action, table_name, record_id, old_values, new_values, ip_address, user_agent)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
  ");
  
  return $stmt->execute([
    $user_id,
    $action,
    $table_name,
    $record_id,
    json_encode($old_values),
    json_encode($new_values),
    $ip,
    $user_agent
  ]);
}
```

---

#### **5️⃣ SYSTEM SETTINGS PAGE** (`parametres_systeme_backend.php`)

**État actuel :**
- ❌ Aucune configuration système
- ❌ Paramètres hardcodés dans le code
- ❌ Impossible de changer filtre/année academique sans code

**Frontend à créer :**
```
Page avec ONGLETS (tabs):

ONGLET 1: Paramètres Généraux
- Nom de l'institution (text field)
- Année académique (dropdown: 2024-2025, 2025-2026, etc.)
- Semestres par année (select: 2 ou 4)
- Crédits ECTS par semestre (number)
- Email principal (email field)
- Logo de l'institution (file upload, affiche preview)
- Timezone (dropdown: Africa/Algiers, etc.)
- Langue par défaut (dropdown: fr, en, ar)
- Bouton Sauvegarder

ONGLET 2: Paramètres Académiques
- Seuil de validation (nombre): taper 10.00
- Note minimale pour réussite UE (number)
- Note minimale pour validation EC (number)
- Compensation de notes autorisée? (checkbox)
- Session de rattrapage autorisée? (checkbox)
- Nombre max tentatives par examen (number)
- Crédits ECTS minimum pour progression (number)
- Durée maximum études (nombre années)
- Bouton Sauvegarder

ONGLET 3: Paramètres Email (SMTP)
- Serveur SMTP (text field): smtp.gmail.com
- Port SMTP (number): 587
- Email d'envoi (email field): noreply@institution.edu.dz
- Authentification requise? (checkbox)
- Username SMTP (text field)
- Password SMTP (password field, chiffré)
- Bouton "Tester l'email" → envoie test email
- Type sécurité (dropdown: TLS, SSL, None)
- Activer notifications email? (checkbox)
- Bouton Sauvegarder

ONGLET 4: Paramètres Sécurité
- Durée session (minutes): 60
- Nombre tentatives login avant blocage: 5
- Durée blocage après tentatives (minutes): 30
- Forcer changement password tous les (jours): 90
- Longueur minimum password (number): 8
- Exiger majuscule + chiffre dans password? (checkbox)
- HTTPS obligatoire? (checkbox)
- IP whitelist autorisées (textarea, une par ligne)
- Activer 2FA? (checkbox, future feature)
- Bouton Sauvegarder

ONGLET 5: Gestion PDF/Export
- Dossier de stockage documents (readonly)
- Taille max upload fichier (MB): 50
- Formats d'export autorisés (checkboxes): PDF, CSV, Excel
- Activer watermark sur PDF? (checkbox)
- Texte watermark (text field)
- Bouton Sauvegarder

Tous les onglets: Affiche message "Dernière modification par [nom] le [date]"
Tous les onglets: Affiche toast success/error après save
```

**Backend à implémenter :**

**Fichier : `backend/parametres_systeme_backend.php`**

Doit gérer :
```php
01. ACTION: list (default)
    - Récupère tous les settings de app_settings
    - Retourne en JSON ou array associatif pour template
    - Grouper par catégorie (general, academic, email, security, export)
    
02. ACTION: update
    - Reçoit: setting_key, setting_value, setting_category
    - Valide le setting_key existe dans défault settings list
    - Valide type de valeur selon setting_type (int, string, bool, json)
    - UPDATE app_settings SET setting_value=?, updated_at=NOW(), updated_by=?
    - OU INSERT si n'existe pas
    - Logger action dans audit_log
    - Retourne success JSON
    - Vérifie permission: ADMIN only
    - Cache les settings en memory (opcache ou redis si available)
    
03. ACTION: test_email
    - Reçoit rien, utilise settings existants
    - Récupère SMTP settings
    - Essaie d'envoyer email test à current user email
    - Retourne success/error
    - Vérifie permission: ADMIN
    
04. ACTION: get_defaults
    - Retourne liste de tous les settings possibles avec default values
    - Format: [{key, value, type, category, description}, ...]
```

**Table app_settings à créer :**
```sql
CREATE TABLE app_settings (
  id INT PRIMARY KEY AUTO_INCREMENT,
  setting_key VARCHAR(100) UNIQUE NOT NULL,
  setting_value LONGTEXT,
  setting_type ENUM('string', 'int', 'bool', 'json') DEFAULT 'string',
  setting_category VARCHAR(50),  -- general, academic, email, security, export
  description TEXT,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  updated_by INT,
  FOREIGN KEY (updated_by) REFERENCES utilisateur(id)
);
```

**Default values à insérer :**
```sql
INSERT INTO app_settings VALUES
(NULL, 'app_name', 'KARA Project', 'string', 'general', 'Nom institution'),
(NULL, 'academic_year', '2025-2026', 'string', 'academic', 'Année académique'),
(NULL, 'semesters_per_year', '2', 'int', 'academic', 'Nombre semestres'),
(NULL, 'ects_per_semester', '30', 'int', 'academic', 'Crédits ECTS par semestre'),
(NULL, 'validation_threshold', '10.00', 'string', 'academic', 'Seuil validation'),
(NULL, 'smtp_server', 'smtp.gmail.com', 'string', 'email', 'Serveur SMTP'),
(NULL, 'smtp_port', '587', 'int', 'email', 'Port SMTP'),
(NULL, 'smtp_from_email', 'noreply@institution.edu.dz', 'string', 'email', 'Email expéditeur'),
(NULL, 'session_timeout', '60', 'int', 'security', 'Durée session minutes'),
(NULL, 'max_login_attempts', '5', 'int', 'security', 'Max tentatives login');
```

---

#### **6️⃣ RAPPORTS PDF** (`rapports_pdf_backend.php`)

**État actuel :**
- ⚠️ `backend/rapport_pdf_backend.php` existe mais orphelin (aucun lien)
- ❌ Aucune interface pour générer rapports
- ❌ Impossible d'exporter rapports complexes

**Frontend à créer :**
```
Page avec 2 sections:

SECTION 1: Générateur de Rapports
- Formulaire:
  * Département (dropdown, required)
  * Filière (dropdown optionnel, populate après dept selection)
  * Année académique (dropdown)
  * Type rapport (dropdown):
    - Synthèse par département
    - Synthèse par filière
    - Détail résultats (tous les étudiants)
    - Statistiques réussite/échec
    - Moyennes comparatives
  * Inclure statistiques? (checkbox)
  * Inclure graphiques? (checkbox)
  
- Boutons:
  * "Générer PDF" (lance generation)
  * "Prévisualiser HTML" (affiche dans page)
  * "Envoyer par email" (récupère email du coordinateur)
  * "Annuler"

- Info: "Génération en cours..." (avec progress bar si long)

SECTION 2: Historique Rapports Générés
- TABLE:
  Colonnes: Date génération, Type rapport, Département, Générateur, Actions
  
- ACTIONS par rapport:
  * "Télécharger PDF"
  * "Afficher HTML"
  * "Renvoyer par email"
  * "Supprimer"
  
- FILTRES:
  * Recherche par: Département, Type rapport
  * Date range
  * Généré par (dropdown utilisateur)
  
- Info: "X rapports sont conservés pendant 30 jours"
```

**Backend à implémenter :**

**Fichier : `backend/rapports_pdf_backend.php` (modifier existant)**

Doit gérer :
```php
01. ACTION: list
    - Récupère rapports générés précédemment
    - Query: SELECT * FROM generated_reports ORDER BY created_at DESC LIMIT 100
    - Filtre: date_from, date_to, rapport_type, department_id
    - Retourne JSON ou HTML table
    - Vérifie permission: COORDINATEUR+ 
    
02. ACTION: generate
    - Reçoit: department_id, filiere_id, academic_year, rapport_type
    - Valide paramètres
    - Récupère données depuis DB:
      * Étudiants et notes du département/filière
      * Calcule moyennes, statistiques
      * Générer PDF avec mPDF ou TCPDF
    - Sauvegarde PDF dans /reports/rapport_YYYYMMDD_HHMMSS.pdf
    - INSERT dans generated_reports:
      * department_id, rapport_type, file_path, created_by, file_size
    - Logger action
    - Retourne file_path pour download/preview
    - Vérifie permission: COORDINATEUR+
    
03. ACTION: preview
    - Reçoit: rapport_id OU paramètres de generation
    - Si rapport_id: fetch depuis generated_reports
    - Si paramètres: génère HTML (without PDF save)
    - Retourne HTML formatted
    
04. ACTION: download
    - Reçoit: rapport_id
    - Récupère file_path de generated_reports
    - Vérifie fichier existe
    - Force download avec correct headers
    - Update: last_downloaded = NOW()
    
05. ACTION: send_email
    - Reçoit: rapport_id, email_to (optional)
    - Si email_to vide: envoie à coordinateur du département
    - Récupère PDF path
    - Envoie email avec attachment
    - Logger action
    - Retourne success
    
06. ACTION: delete
    - Reçoit: rapport_id
    - Récupère file_path
    - DELETE file physiquement
    - SET deleted_at = NOW() dans generated_reports (soft delete)
    - Logger action
    - Retourne success
    
07. ACTION: cleanup_old
    - Automatique ou manual: DELETE rapports > 30 jours
    - Supprime aussi fichiers physiques
```

**Table generated_reports à créer :**
```sql
CREATE TABLE generated_reports (
  id INT PRIMARY KEY AUTO_INCREMENT,
  department_id INT NOT NULL,
  filiere_id INT,
  rapport_type VARCHAR(50) NOT NULL,
  academic_year VARCHAR(20),
  file_path VARCHAR(255) NOT NULL,
  file_size INT,
  created_by INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_downloaded DATETIME,
  deleted_at DATETIME,
  FOREIGN KEY (department_id) REFERENCES departement(id),
  FOREIGN KEY (filiere_id) REFERENCES filiere(id),
  FOREIGN KEY (created_by) REFERENCES utilisateur(id)
);
```

---

#### **7️⃣ EXPORT MANAGEMENT PAGE** (`exports_management_backend.php`)

**État actuel :**
- ❌ `backend/export_etudiants.php` existe mais orphelin
- ❌ `backend/export_etudiants_pdf.php` existe mais orphelin
- ❌ Aucune interface d'export contrôlée

**Frontend à créer :**
```
Page avec 2 sections:

SECTION 1: Créer Export
- Formulaire:
  * Type export (radio buttons):
    - Tous les étudiants
    - Étudiants par filière
    - Étudiants par statut (actif/inactif)
    - Résultats avec notes
    - Étudiants validés
  
  * Colonnes à exporter (checkboxes, default all):
    - ID, Email, Nom, Prénom, Filière, Semestre, Statut, Date inscription
    - Cases à cocher pour: Notes, Moyennes, Délibérations
  
  * Format export (radio buttons):
    - CSV (Excel compatible)
    - PDF (formatted)
    - XLSX (Excel native)
  
  * Filtres avancés:
    - Date inscription: depuis / jusqu'à
    - Département (dropdown)
    - Filière (dropdown)
    - Statut (dropdown: actif, graduée, abandon, etc)
    - Année académique (dropdown)
  
  * Options:
    - Inclure formules? (checkbox, pour CSV)
    - Entête de rapport? (checkbox, PDF)
    - Signature automatique? (checkbox, PDF - coordinateur)
  
  - Boutons:
    * "Générer Export" (lance download ou enqueue)
    * "Prévisualiser" (affiche HTML preview)
    * "Planifier export" (envoyer email à date précise - future)
    * "Annuler"

SECTION 2: Historique Exports
- TABLE paginée:
  Colonnes: Date export, Type, Nombre lignes, Format, Générateur, Actions
  
- ACTIONS:
  * "Re-télécharger"
  * "Supprimer"
  * "Envoyer par email"
  * "Cloner (même paramètres)"
  
- FILTRES:
  * Type export (dropdown)
  * Date range
  * Format (dropdown: CSV, PDF, XLSX)
  * Généré par (dropdown user)
  
- STATS:
  * XXX exports ce mois
  * XXX GB stockage utilisé
  * Exports conservés pendant 30 jours
```

**Backend à implémenter :**

**Fichier : `backend/exports_management_backend.php`**

Doit gérer :
```php
01. ACTION: list
    - Récupère exports historique paginé (50 par page)
    - Filtres: export_type, format, date_from, date_to, created_by
    - ORDER BY created_at DESC
    - Retourne JSON ou HTML table
    - Vérifie permission: USER+ (can see own exports), COORDINATEUR+ (see all)
    
02. ACTION: generate
    - Reçoit: export_type, format, filters, columns_list
    - Valide paramètres
    - Récupère data depuis DB selon filters
    - Switch sur format:
      * CSV: Utiliser export_etudiants.php existant
      * PDF: Utiliser export_etudiants_pdf.php existant
      * XLSX: Utiliser PHPExcel library
    - Sauvegarde dans /exports/export_YYYYMMDD_HHMMSS.[csv|pdf|xlsx]
    - INSERT dans exports_history table
    - Logger action
    - Return file path pour download
    - Vérifie permission: USER+
    
03. ACTION: preview
    - Reçoit: export_type, format, filters
    - Génère HTML table preview (max 100 lignes) sans sauvegarder
    - Affiche nombre total lignes "Affichage 100 sur 5432 lignes"
    - Bouton "Générer complet"
    
04. ACTION: download
    - Reçoit: export_id
    - Récupère file_path de exports_history
    - Vérifie fichier existe
    - Vérifie permission (user peut download own ou coordinateur any)
    - Force download avec correct headers
    - Update: last_downloaded = NOW(), download_count++
    
05. ACTION: send_email
    - Reçoit: export_id, email_to (optional)
    - Si email_to empty: envoie à current user
    - Récupère file path
    - Envoie email avec attachment (ou lien drive/shared si trop gros)
    - Logger action
    
06. ACTION: delete
    - Reçoit: export_id
    - Supprime fichier physique /exports/
    - SET deleted_at = NOW() (soft delete)
    - Vérifie permission: created_by = current user OU ADMIN
    - Logger action
    
07. ACTION: re_export (clone)
    - Reçoit: export_id
    - Récupère parametres de exports_history
    - Appel ACTION: generate avec mêmes parametres
    - Crée nouvel export
```

**Table exports_history à créer :**
```sql
CREATE TABLE exports_history (
  id INT PRIMARY KEY AUTO_INCREMENT,
  export_type VARCHAR(50) NOT NULL,
  format VARCHAR(10) NOT NULL,
  filters JSON,
  columns_list JSON,
  row_count INT,
  file_path VARCHAR(255) NOT NULL,
  file_size INT,
  created_by INT NOT NULL,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  last_downloaded DATETIME,
  download_count INT DEFAULT 0,
  deleted_at DATETIME,
  FOREIGN KEY (created_by) REFERENCES utilisateur(id)
);
```

---

#### **8️⃣ STUDENT TRANSCRIPT PAGE** (`relev_etudiants_backend.php`)

**État actuel :**
- ⚠️ `backend/relev_backend.php` existe mais orphelin
- ❌ Aucun lien pour accéder au relevé d'étudiant
- ❌ Pas d'interface pour visualiser/imprimer

**Frontend à créer :**
```
Page accessible depuis:
- Lien "Voir relevé" dans repertoire_etudiants_backend.php (colonne Actions)
- Menu: Profil → Mes relevés (pour students si they can access)
- URL: ./relev_etudiants_backend.php?id=123

Affiche relevé complet:

ENTÊTE: 
- Logo institution + Nom
- Titre: "RELEVÉ DE NOTES DE [NOM ÉTUDIANT]"
- Info étudiant: Matricule, Nom, Prénom, Email, Filière, Département
- Période: Début - Fin études

CORPS:
- Par SEMESTRE (S1, S2, S3, etc):
  * Tableau:
    - Colonnes: Code UE, Libellé UE, Code EC, Libellé EC, Crédit, Note, Statut
    - Lignes: Chaque EC avec sa note
    - Sous-total UE: Moyenne UE, Crédit UE, Validée OUI/NON
  * Total Semestre:
    - Nombre UE, Nombre crédits, Moyenne semestre, Crédits obtenus
  
- RÉSUMÉ GÉNÉRAL (bottom):
  * Total crédits obtenus / crédits requis
  * Moyenne générale
  * Statut: Admis progression / Redoublement / Graduée
  * Date génération

BOUTONS:
- Imprimer (onclick=window.print())
- Télécharger PDF
- Envoyer par email
- Retour

OPTIONS AFFICHAGE:
- Filtrer par semestre (checkbox)
- Afficher notes détaillées ou moyennes UE seulement (radio)
- Masquer étudiants inactifs/graduées (checkbox)
```

**Backend à implémenter :**

**Fichier : `backend/relev_etudiants_backend.php`**

Doit gérer :
```php
01. ACTION: view (default)
    - Reçoit: id_etudiant (GET param)
    - Vérifie permission: 
      * Utilisateur peut voir relev s'il est:
        - Admin/Coordinateur/Enseignant
        - Ou si c'est student lui-même (future feature)
    - Récupère étudiant info: SELECT * FROM etudiant WHERE id = ?
    - Récupère tous les SEMESTRES et leurs UE/EC/notes pour cet étudiant
    - Récupère DELIBERATIONS pour déterminer ADMISIBILITÉ à progression
    - Calcule MOYENNES et CRÉDITS
    - Pass data to template relev.php
    - Retourne HTML formatted
    
02. ACTION: pdf
    - Reçoit: id_etudiant
    - Calcula mêmes données que view
    - Génère PDF avec mPDF ou TCPDF
    - Sauvegarde dans /pdf/relev_[id_etudiant]_[YYYYMMDD].pdf
    - Force download ou preview selon format param
    - Vérifie permission: même que view
    
03. ACTION: send_email
    - Reçoit: id_etudiant, email_to (optional)
    - Génère PDF
    - Si email_to empty: utilise email_etudiant ou email coordinateur
    - Envoie email avec PDF attached
    - Logger action
    
04. ACTION: email_via_pdf
    - Combo de pdf + send_email
    - Crée PDF + envoie dans 1 action
```

**Query Pattern:**
```sql
SELECT 
  e.id, e.nom, e.prenom, e.email, e.matricule, e.filiere_id, e.date_inscription,
  f.code_filiere, f.nom_filiere, d.nom_departement,
  s.numero_semestre,
  ue.id_ue, ue.code_ue, ue.nom_ue, ue.credite_ue,
  ec.id_ec, ec.code_ec, ec.nom_ec, ec.credite_ec,
  n.note,
  del.statut_deliberation
FROM etudiant e
JOIN filiere f ON e.filiere_id = f.id_filiere
JOIN departement d ON f.id_departement = d.id_departement
JOIN ue ON f.id_filiere = ue.filiere_id
JOIN ec ON ue.id_ue = ec.id_ue
LEFT JOIN note n ON e.id = n.id_etudiant AND ec.id_ec = n.id_ec
LEFT JOIN deliberation del ON e.id = del.id_etudiant
WHERE e.id = ?
ORDER BY s.numero_semestre, ue.id_ue, ec.id_ec
```

---

### 🟢 **PRIORITÉ MOYENNE**

---

#### **🔟 ACTIVITY LOG VIEWER** (`activite_utilisateur_backend.php`)

**État actuel :**
- ❌ Pas de visualisation d'activité pour l'utilisateur
- ❌ Pas de feed d'activités récentes

**Frontend à créer :**
```
Page avec:

SECTION pour Admin/Coordinateur: Global Recent Activity
- Timeline affichant last 50 activités tous utilisateurs
- Affichage: "[NOM] a [ACTION] [TABLE] le [DATE]"
- Exemple: "Mamada Diallo a modifié 3 coefficients le 2025-04-02 14:30"
- Filtres: Type action, Utilisateur, Date range
- Auto-refresh option (5 min, manual)

SECTION pour chaque utilisateur: Personal Activity (Mon Profil)
- Timeline personelle des 30 dernières activités
- Affichage de ce que MOI j'ai fait
- Exemple: "Vous avez créé l'étudiant "Ali Mohamed" le 2025-04-02 10:15"
- Filtres: Type action
- Export timeline en PDF
```

**Backend à implémenter :**

**Fichier : `backend/activite_utilisateur_backend.php`**

Doit gérer :
```php
01. ACTION: my_activity
    - Récupère dernière 30 activités de current user
    - Query: SELECT * FROM audit_log WHERE user_id = ? ORDER BY timestamp DESC LIMIT 30
    - Retourne JSON ou HTML timeline
    - Accessible pour TOUS les users (voir sa propre activité)
    
02. ACTION: recent_global
    - Récupère dernières 50 activités globales (tous users)
    - Filtres optionnels: action, user_id, table_name
    - ORDER BY timestamp DESC LIMIT 50
    - Retourne JSON
    - Vérifie permission: ADMIN ou COORDINATEUR
```

---

#### **1️⃣1️⃣ ERROR LOG VIEWER** (`logs_erreurs_backend.php`)

**État actuel :**
- ❌ Les erreurs sont loggées dans `/config/logs/` mais aucune UI
- ❌ Impossible de visualiser/rechercher les erreurs sans CLI

**Frontend à créer :**
```
Page Admin seulement:

FILTRES en haut:
- Date range (date picker)
- Sévérité (dropdown: ERROR, WARNING, INFO)
- Fichier affecté (dropdown/search)
- Message libre search

TABLEAU paginé (50 lines):
Colonnes:
- Date/Heure
- Sévérité (couleur coded: red=ERROR, orange=WARNING, blue=INFO)
- Fichier:Ligne
- Message (truncated, expandable)
- Stack trace (modal "Voir détails")

ACTIONS:
- Bouton "Réinitialiser logs" (delete all)
- Bouton "Télécharger log du jour" (download CSV)
- Bouton "Nettoyer anciens" (delete > 30 jours)
- Auto-refresh (5 min, manual)
```

**Backend à implémenter :**

**Fichier : `backend/logs_erreurs_backend.php`**

Doit gérer :
```php
01. ACTION: list
    - Lit tous les fichiers dans /config/logs/
    - Parse format: [DATE] [SÉVÉRITÉ] [MESSAGE]
    - Filtre: date_from, date_to, severity, file_name
    - Retourne JSON array
    - Vérifie permission: ADMIN only
    
02. ACTION: download
    - Génère CSV avec tous les logs
    - Force download: error_logs_YYYYMMDD.csv
    - Vérifie permission: ADMIN only
    
03. ACTION: cleanup
    - Supprime logs > 30 jours (configurable)
    - Retourne nombre files supprimés
    - Vérifie permission: ADMIN only
```

---

## 📊 **RÉSUMÉ DES TÂCHES BACKEND PAR PAGE**

| # | Page | Backend File | Priorité | Queries SQL | Fonctions PHP | Tables | Logs |
|---|------|---|---|---|---|---|---|
| 1 | LOGIN | login_backend.php | 🔴 CRIT | 3 | 2 | utilisateur | Yes |
| 2 | USER MGT | gestion_utilisateurs_backend.php | 🔴 CRIT | 6 | 5 | utilisateur | Yes |
| 3 | PROFILE | profil_utilisateur_backend.php | 🔴 CRIT | 3 | 3 | utilisateur | Yes |
| 4 | AUDIT | audit_logs_backend.php | 🟡 HIGH | 5 | 4 | audit_log | Yes |
| 5 | SETTINGS | parametres_systeme_backend.php | 🟡 HIGH | 4 | 3 | app_settings | Yes |
| 6 | RAPPORTS | rapports_pdf_backend.php | 🟡 HIGH | 6 | 7 | generated_reports | Yes |
| 7 | EXPORTS | exports_management_backend.php | 🟡 HIGH | 7 | 6 | exports_history | Yes |
| 8 | RELEV | relev_etudiants_backend.php | 🟡 HIGH | 4 | 4 | (existing) | Yes |
| 9 | ACTIVITÉ | activite_utilisateur_backend.php | 🟢 MED | 2 | 2 | (audit_log) | No |
| 10 | ERROR LOG | logs_erreurs_backend.php | 🟢 MED | 0 | 3 | (filesystem) | No |

---

## ⚡ **FIX IMMÉDIAT POUR LIENS CASSÉS**

Avant de coder les nouvelles pages, corriger les 21 liens cassés:

**Fichier 1: tab_de_bord.php** (Lignes 95, 99, 103, 107, 111, 117, 273)
```
Ligne 95:  href="#"  →  href="<?= $base_url ?>index.php"
Ligne 99:  href="#"  →  href="<?= $base_url ?>backend/repertoire_etudiants_backend.php"
Ligne 103: href="#"  →  href="<?= $base_url ?>backend/saisie_notes_par_ec_backend.php"
Ligne 107: href="#"  →  href="<?= $base_url ?>backend/deliberation_backend.php"
Ligne 111: href="#"  →  href="<?= $base_url ?>backend/statistiques_reussites_backend.php"
Ligne 117: href="#"  →  href="<?= $base_url ?>backend/logout.php"
Ligne 273: href="#"  →  href="<?= $base_url ?>backend/statistiques_reussites_backend.php"
```

**Fichier 2: code.php** (mêmes lignes)

**Fichier 3: saisie_notes.php** (Lignes 122, 126, 130, 134, 138, 144)

**Fichier 4: configuration_des_coefficients_ue_ec.php** (Ligne 22)
```
Avant: <form method="POST" action="" id="config-filter-form"...>
Après: <form method="POST" action="<?= $base_url . $backend_url ?>configuration_coefficients_backend.php" id="config-filter-form"...>
```

**Fichier 5: gestion_filiere_res_ue.php** (Ligne 59)
```
Avant: <form method="GET" ... (pas d'action)
Après: <form method="GET" action="<?= $base_url . $backend_url ?>gestion_filieres_ue_backend.php" ...>
```

---

**Document analyse complet de toutes les pages manquantes et leurs spécifications techniques détaillées.**
