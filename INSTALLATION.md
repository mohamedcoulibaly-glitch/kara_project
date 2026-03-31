# 🚀 Guide d'Installation Rapide

## Prérequis
- XAMPP installé et en cours d'exécution
- MySQL/MariaDB actif
- PHP 8.0+

---

## Installation en 4 Étapes

### 1️⃣ Configuration
Modifiez `config/config.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');        // Votre utilisateur MySQL
define('DB_PASS', '');             // Votre mot de passe
define('DB_NAME', 'gestion_notes');
```

### 2️⃣ Création de la Base de Données
Ouvrez PhpMyAdmin: **http://localhost/phpmyadmin**
- Créez une nouvelle BD nommée `gestion_notes`
- (Optionnel) Importez `gestion_notes_complete.sql`

### 3️⃣ Installation Automatique
Accédez à: **http://localhost/kara_project/install.php**

Cliquez sur **"Procéder à l'Installation"** et attendez le message de succès.

### 4️⃣ Accès au Système
- **Dashboard:** http://localhost/kara_project/
- Tous les modules sont accessibles via le tableau de bord

---

## ✅ Vérification

### Tester la Connexion
```php
<?php
require_once 'config/config.php';
$db = getDB();
echo "✅ Connexion OK";
?>
```

### Vérifier les Données
- Accédez au Dashboard
- Les statistiques doivent s'afficher correctement
- Vous devez voir 3 étudiants de test

---

## 📍 Accès aux Modules

| Module | URL |
|--------|-----|
| Dashboard | `/` |
| Répertoire | `/backend/repertoire_etudiants_backend.php` |
| Maquettes | `/backend/maquette_lmd_backend.php` |
| Configuration | `/backend/configuration_coefficients_backend.php` |
| Attestation | `/backend/attestation_backend.php?id=1` |
| Carte Étudiant | `/backend/carte_etudiant_backend.php?id=1` |
| Délibérations | `/backend/deliberation_backend.php` |
| Parcours | `/backend/parcours_academique_backend.php?id=1` |
| Rattrapages | `/backend/gestion_sessions_rattrapage_backend.php` |
| Procès-Verbaux | `/backend/proces_verbal_backend.php` |

---

## 🆘 Dépannage

### "Erreur de connexion"
→ Vérifiez identifiants dans `config/config.php`

### "Table doesn't exist"
→ Exécutez `install.php`

### "Pas de données"
→ Les données de test sont insérées lors de l'install

### Les fichiers frontend s'affichent sans styles
→ Les backends génèrent les données, les frontends les affichent avec Tailwind CSS

---

## 📝 Données de Test

Après installation, vous avez:
- ✅ 3 étudiants (Mamadou, Fatima, Mohamed)
- ✅ 3 filières (GL, INFO, GE)
- ✅ 3 départements
- ✅ 4 UE avec leurs EC
- ✅ Notes de démonstration

---

## 🔄 Réinitialiser la BD

Pour recommencer depuis zéro:
1. Supprimez la BD `gestion_notes` dans PhpMyAdmin
2. Recréez-la (vide)
3. Exécutez `install.php` à nouveau

---

## 📚 Après l'Installation

1. Lisez le **GUIDE_COMPLET.md** pour les détails
2. Consultez **API_DOCUMENTATION.json** pour les endpoints
3. Testez chaque module via le dashboard
4. Explorez le code des backends pour comprendre

---

## ⚡ Démarrage Développement

```bash
# Accès au projet
cd C:\xampp\htdocs\kara_project

# Lancer un serveur PHP simple
php -S localhost:8000

# Puis accédez à: http://localhost:8000
```

---

✅ Vous êtes prêt! Commencez par visiter **http://localhost/kara_project**
