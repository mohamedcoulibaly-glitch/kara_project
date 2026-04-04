# Rapport d’audit global — Portail LMD (`kara_project`)

**Date de l’audit :** 4 avril 2026  
**Méthode :** revue statique du code PHP + comparaison avec `gestion_notes_complete.sql` et les journaux `config/logs/*.log`. Aucune exécution automatisée de la suite PHP n’a pu être lancée depuis l’environnement (binaire `php` absent du PATH).

---

## 1. Ne fonctionne pas ou casse avec le schéma actuel

### 1.1 Gestion des utilisateurs (`backend/gestion_utilisateurs_backend.php`)

| Problème | Détail |
|----------|--------|
| Colonne PK / filtres | Le code utilise `id_utilisateur` partout ; le schéma officiel du projet utilise **`id_user`**. Les requêtes SQL échouent ou ne retournent rien. |
| Colonne de tri / affichage | `ORDER BY created_at` et affichage `created_at` : la table `utilisateur` du script SQL fourni a **`date_creation`**, pas `created_at`. |
| Dernière connexion | Affichage `last_login` alors que cette colonne **n’existe pas** dans le schéma de base (même cause que les anciens bugs profil / `getCurrentUser`). |
| Rôles proposés | Filtres / formulaires incluent **« Coordinateur »** ; l’enum SQL est `('Admin', 'Enseignant', 'Scolarite', 'Directeur')` — risque d’erreur SQL à l’insertion / mise à jour. |
| Bind des requêtes | `safeQuerySingle` / `safeQuery` sont appelés avec `[$types, ...$params]` (types mysqli mélangés aux valeurs). Les helpers attendent **uniquement la liste des valeurs** ; avec filtres actifs, le binding est incorrect. |

**Conséquence :** module admin « Utilisateurs » très probablement **inutilisable** sur une base alignée sur `gestion_notes_complete.sql`.

---

### 1.2 Journal d’audit (`backend/audit_logs_backend.php`)

| Problème | Détail |
|----------|--------|
| Jointure utilisateur | `LEFT JOIN utilisateur u ON al.user_id = u.id_utilisateur` — **`id_utilisateur` n’existe pas** ; il faut `id_user`. |
| Liste des utilisateurs (filtre) | `SELECT id_utilisateur, ...` — même incohérence. |

**Conséquence :** page **Audit logs** (admin) : erreurs SQL ou liste utilisateurs vide / incorrecte.

---

### 1.3 Connexion AJAX (`backend/login_backend.php`)

| Problème | Détail |
|----------|--------|
| `last_login` | `UPDATE utilisateur SET last_login = NOW()` **sans vérifier** que la colonne existe → échec silencieux ou erreur selon MySQL. |

*(La page principale `login.php` a été corrigée pour ne mettre à jour `last_login` que si la colonne existe ; ce fichier backend parallèle ne suit pas la même logique.)*

---

## 2. Fonctionne partiellement ou UX dégradée

### 2.1 Maquette LMD par semestre (`maquette_lmd_backend.php` + vue)

- Le tableau affiche les **UE** mais la vue attend des lignes **EC** imbriquées (`$ue['ecs']`).
- Le backend agrège les EC en `GROUP_CONCAT` ; **aucun tableau `ecs` n’est construit** → sous-lignes EC **vides ou absentes** (seules les UE sont fiables).

### 2.2 Délibérations (`deliberation_final_academique.php` + table `deliberation`)

- L’enum SQL : `Admis`, `Redoublant`, `Ajourné`, `En attente`.
- Le formulaire propose encore des libellés du type **« Admis avec dettes », « Non Admis », « Exclu »** : une partie est normalisée côté sauvegarde unitaire, pas forcément pour **tous** les scénarios / validations en masse.
- **À valider en base** : cohérence des valeurs `statut` insérées partout.

### 2.3 « Rapport PDF » (`rapport_pdf_backend.php`)

- `?download=1` envoie un **fichier HTML** joint (impression « Enregistrer en PDF » depuis le navigateur).
- **Il n’y a pas** mPDF/TCPDF dans le dépôt → **pas de PDF binaire** généré côté serveur.

### 2.4 Carte étudiant / attestation / parcours

- Si l’ID étudiant est invalide : **`die("Étudiant non trouvé")`** (texte brut) au lieu d’une page d’erreur dans le layout du portail.

### 2.5 `accueil.php`

- Ne contient **pas** les blocs « Migration BD » / « Documentation » mentionnés dans d’anciens prompts de nettoyage ; **aucune action requise** sauf si une autre branche du fichier est utilisée ailleurs.

---

## 3. Données factices / non branchées sur la BDD

| Zone | Observation |
|------|-------------|
| `Maquettes/.../tableau_de_bord_acad_mique/tab_de_bord.php` | KPI type « 540 », « 78 % », graphiques SVG **en dur** (hors requêtes réelles si la page est utilisée telle quelle). |
| `Maquettes/.../tableau_de_bord_acad_mique/code.php` | Idem : maquette statique. |
| `backend/tableau_de_bord_backend.php` | Partie « +12 % », etc. peut rester **décorative** selon les blocs HTML. |

À distinguer de **`index.php`** (racine), qui charge des stats depuis la base.

---

## 4. Sécurité (à traiter en priorité si exposition réseau)

| Point | Fichier / zone |
|-------|----------------|
| Export CSV **sans** `checkAuth()` | `backend/export_etudiants.php` — téléchargement possible **sans session** si l’URL est connue. |
| Couverture `checkAuth` | Seuls quelques backends appellent explicitement `checkAuth()` ; le reste repasse surtout par **`sidebar.php`** (session). Toute route **sans** inclusion sidebar = **à auditer**. |

---

## 5. Cohérence schéma SQL ↔ code (résumé)

| Concept | Souvent dans le code | Souvent dans `gestion_notes_complete.sql` |
|---------|----------------------|---------------------------------------------|
| Identifiant utilisateur | `id_utilisateur` (faux ici) | `id_user` |
| Date création compte | `created_at` | `date_creation` |
| Dernière connexion | `last_login` | **Absent** (à ajouter par `ALTER TABLE` si besoin) |
| Rôles | + `Coordinateur` | `Admin`, `Enseignant`, `Scolarite`, `Directeur` |

---

## 6. Tests manuels recommandés (check-list rapide)

À faire dans le navigateur, connecté :

1. **Profil** (`backend/profil_utilisateur_backend.php`) — infos + changement mot de passe.  
2. **Utilisateurs** (`backend/gestion_utilisateurs_backend.php`) — liste, création, édition (attendu : **échecs** tant que `id_user` / colonnes ne sont pas alignés).  
3. **Audit logs** (`backend/audit_logs_backend.php`) — chargement et filtre par utilisateur.  
4. **Maquette par semestre** — vérifier affichage des **EC** sous chaque UE.  
5. **Export CSV** depuis le dashboard — puis tester l’URL d’export **sans être connecté** (fuite de données ?).  
6. **Délibération** — enregistrement avec chaque option du `<select>` et contrôle des lignes en base.  
7. **Login** via formulaire classique vs tout client utilisant `login_backend.php` (si encore utilisé).

---

## 7. Pistes de correction (ordre suggéré)

1. Unifier **`id_user`** partout (remplacer `id_utilisateur`, y compris dans `gestion_utilisateurs_backend.php` et `audit_logs_backend.php`).  
2. Remplacer **`created_at`** par **`date_creation`** (ou ajouter la colonne manquante en SQL).  
3. Corriger les appels **`safeQuery` / `safeQuerySingle`** : passer **seulement** le tableau de valeurs `[ $p1, $p2, ... ]`, pas `[$types, ...]`.  
4. Aligner les **rôles** (enum SQL ↔ listes dans les formulaires).  
5. Optionnel : `ALTER TABLE utilisateur ADD COLUMN last_login DATETIME NULL` puis réintroduire `last_login` dans `getCurrentUser()` si souhaité.  
6. Protéger **`export_etudiants.php`** avec `checkAuth()` (ou équivalent).  
7. Compléter le backend maquette avec un **jeu `ecs` par UE** pour la vue actuelle.

---

## 8. Corrections appliquées (suite au §7)

| # | Piste | Statut |
|---|--------|--------|
| 1 | `id_user` dans `gestion_utilisateurs_backend.php` et `audit_logs_backend.php` | Fait |
| 2 | `date_creation` à la place de `created_at` (liste utilisateurs) | Fait |
| 3 | `safeQuery` / `safeQuerySingle` / `safeExecute` : tableaux de valeurs uniquement | Fait (liste + filtres audit + édition utilisateur) |
| 4 | Rôles alignés sur l’enum SQL (Scolarité, Directeur ; plus de Coordinateur) | Fait |
| 5 | `ALTER` `last_login` | Non fait (optionnel) — `login_backend.php` et `login.php` n’écrivent `last_login` que si la colonne existe |
| 6 | `checkAuth()` sur `export_etudiants.php` | Fait |
| 7 | Tableau `ecs` par UE dans `maquette_lmd_backend.php` | Fait |
| — | `login_backend.php` : même garde `SHOW COLUMNS` pour `last_login` | Fait |
| — | Délibérations en masse : `normalizeDeliberationStatut()` | Fait |

---

## 9. Vérification (4 avril 2026) et données de simulation

- **Syntaxe PHP** : contrôle `php -l` sur tous les fichiers `backend/**/*.php`, `index.php`, `login.php`, `accueil.php` — aucune erreur.
- **Schéma** : la table **`audit_log`** manquait du script principal ; elle est ajoutée dans `gestion_notes_complete.sql` (§16). Les bases déjà importées peuvent exécuter le même `CREATE TABLE IF NOT EXISTS` ou lancer `tools/seed_simulation.php` (création automatique si besoin).
- **Journal d’audit (UI)** : compteurs INSERT/UPDATE/DELETE sur la page corrigés (`audit_logs_backend.php`).
- **Peuplement** : script CLI `tools/seed_simulation.php` — 72 étudiants `SIM-2026-xxxx`, notes, délibérations, session de rattrapage, logs d’audit, comptes `*.sim@univ.local`, mot de passe admin réinitialisé (voir sortie du script). Commande :  
  `C:\newXampp\php\php.exe tools/seed_simulation.php`
- **Non couvert par cette passe** : tests navigateur complets, génération PDF serveur, KPI des maquettes statiques du dossier `Maquettes/.../tab_de_bord`.

*Fin du rapport — à mettre à jour après corrections ou après une campagne de tests HTTP automatisés.*
