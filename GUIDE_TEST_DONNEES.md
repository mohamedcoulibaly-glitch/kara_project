# 🎯 Guide de Test - Application avec Données Sénégalaises

## ✅ Problème Résolu

**Cause:** Les données étaient dans `kara_project` mais l'app utilise `gestion_notes`  
**Solution:** Données maintenant dans **`gestion_notes`** (la bonne base)

---

## 📊 Données Disponibles

```
Base de données: gestion_notes
✓ 70 Étudiants (noms sénégalais)
✓ 35 Notes académiques
✓ 10 Utilisateurs (Admin, Enseignants, Scolarité)
✓ 33 Programmes LMD
✓ 50+ Éléments constitutifs (EC)
✓ 33 Unités d'enseignement (UE)
```

---

## 🚀 Comment Accéder à l'Application

### 1. **Démarrer XAMPP**
```bash
# Localement
http://localhost/phpmyadmin
# Vérifier: Base "gestion_notes" remplie ✓
```

### 2. **Accéder à l'Application**
```
http://localhost/kara_project/
```

### 3. **Identifiants de Connexion**

| Rôle | Email | Mot de Passe |
|------|-------|-------------|
| Admin | admin@kara.sn | (hash bcrypt) |
| Enseignant | ousmane.ken@kara.sn | (hash bcrypt) |
| Scolarité | samba.fall@kara.sn | (hash bcrypt) |

**Note:** Les mots de passe sont hashés. Vous pouvez modifier directement en BD si besoin.

---

## 📋 Où Voir les Données

### Étudiants
```
/repertoire_etudiants.php
Vérifier: 70 étudiants avec noms sénégalais
```

### Notes
```
/saisie_notes.php
Vérifier: 35 notes saisies
```

### Rapports
```
/backend/rapport_pdf_backend.php
Générer un rapport avec les données
```

### Maquettes LMD
```
/Maquettes_de_gestion_acad_mique_lmd/
Voir les filières et programmes
```

---

## 🔍 Vérification Rapide (SQL)

### Voir les étudiants
```sql
SELECT COUNT(*) FROM gestion_notes.etudiant;
-- Résultat: 70
```

### Voir les notes
```sql
SELECT * FROM gestion_notes.note LIMIT 5;
```

### Voir les utilisateurs
```sql
SELECT nom, prenom, role, email FROM gestion_notes.utilisateur;
```

---

## 🎓 Noms Sénégalais Exemple

```
Mamadou Diallo (KARA-GL-2025-001) - Génie Logiciel
Fatima Touré (KARA-GL-2025-002) - Génie Logiciel
Mohamed Sall (KARA-GL-2025-003) - Génie Logiciel
Aïssatou Ken (KARA-GL-2025-004) - Génie Logiciel
Moussa Cissé (KARA-GL-2025-005) - Génie Logiciel
... et 65 autres étudiants
```

---

## ⚙️ Configuration Vérifiée

**config/config.php:**
```php
DB_HOST: localhost
DB_USER: root
DB_PASS: (vide)
DB_NAME: gestion_notes  ✓
DB_CHARSET: utf8mb4
```

---

## 🐛 Si Ça N'Affiche Pas Encore

### 1. Vérifier la connexion PHP
```bash
# Créer test.php dans le dossier racine
<?php
$conn = new mysqli("localhost", "root", "", "gestion_notes");
if ($conn->connect_error) {
    echo "Erreur: " . $conn->connect_error;
} else {
    echo "Connecté!";
    $result = $conn->query("SELECT COUNT(*) FROM etudiant");
    $row = $result->fetch_row();
    echo " Étudiants: " . $row[0];
}
?>
```

### 2. Vérifier les logs PHP
```
C:\xampp\apache\logs\error.log
```

### 3. Vérifier les permissions
```bash
GRANT ALL PRIVILEGES ON gestion_notes.* TO 'root'@'localhost';
FLUSH PRIVILEGES;
```

---

## 📝 Notes Importantes

- Les données sont **prêtes à tester**
- Toutes les contraintes de clés étrangères sont respectées
- Les dates sont configurées pour 2025-2026
- Les notes varient de 10 à 19/20 (réalistes)
- Les utilisateurs ont un statut **ACTIF**

---

**Mise à jour:** 7 avril 2026  
**Status:** ✅ DONNÉES SYNCHRONISÉES AVEC L'APPLICATION
