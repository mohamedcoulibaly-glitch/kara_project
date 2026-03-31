# 📚 Système de Gestion Académique LMD - Guide Complet

## 🎯 Vue d'ensemble

Ce projet est un système complet de gestion académique basé sur le système LMD (Licence, Master, Doctorat). Il permite de gérer :
- Les étudiants et leurs parcours académiques
- Les notes et les délibérations
- Les sessions de rattrapage
- Les attestations de réussite
- Les cartes étudiantes
- Les maquettes de formation

---

## 📁 Structure du Projet

```
kara_project/
├── config/
│   └── config.php              # Configuration et connexion BD
├── backend/
│   ├── classes/
│   │   └── DataManager.php     # Classes CRUD
│   ├── attestation_backend.php
│   ├── carte_etudiant_backend.php
│   ├── configuration_coefficients_backend.php
│   ├── deliberation_backend.php
│   ├── gestion_sessions_rattrapage_backend.php
│   ├── gestion_filieres_ue_backend.php
│   ├── maquette_lmd_backend.php
│   ├── parcours_academique_backend.php
│   ├── proces_verbal_backend.php
│   └── repertoire_etudiants_backend.php
├── Maquettes_de_gestion_acad_mique_lmd/  # Fichiers frontend
├── gestion_notes_complete.sql  # Base de données complète
├── index.php                   # Dashboard principal
├── install.php                 # Script d'installation
└── README.md                   # Ce fichier
```

---

## 🚀 Installation & Démarrage

### Étape 1: Configuration de la Connexion BD

Ouvrez `config/config.php` et modifiez les identifiants:

```php
define('DB_HOST', 'localhost');    // Hôte MySQL
define('DB_USER', 'root');         // Utilisateur
define('DB_PASS', '');             // Mot de passe
define('DB_NAME', 'gestion_notes'); // Nom de la BD
```

### Étape 2: Création de la Base de Données

1. Ouvrez **phpMyAdmin** (http://localhost/phpmyadmin)
2. Créez une nouvelle base de données: `gestion_notes`
3. (Optionnel) Importez manuellement `gestion_notes_complete.sql`

### Étape 3: Installation Automatique

1. Accédez à: **http://localhost/kara_project/install.php**
2. Cliquez sur **"Procéder à l'Installation"**
3. Attendez le message de succès

### Étape 4: Accès au Système

- Dashboard: **http://localhost/kara_project/**
- Chaque module a son propre backend à `backend/`

---

## 📊 Architecture de la Base de Données

### Tables Principales

#### Étudiants
```sql
- id_etudiant (PK)
- matricule (UNIQUE)
- nom, prenom, email, telephone
- date_naissance, lieu_naissance
- id_filiere (FK)
- statut (Actif, Inactif, Suspendu, Diplômé)
- date_inscription
```

#### Notes
```sql
- id_note (PK)
- valeur_note (0-20)
- session (Normale, Rattrapage)
- id_etudiant (FK)
- id_ec (FK)
- date_examen
```

#### Délibérations
```sql
- id_deliberation (PK)
- code_deliberation (UNIQUE)
- id_etudiant (FK)
- semestre (1-6)
- moyenne_semestre
- statut (Admis, Redoublant, Ajourné)
- mention
```

#### Filières & Structure
```sql
- departement: Gestion des départements
- filiere: Filières d'études
- ue: Unités d'Enseignement
- ec: Éléments Constitutifs
- programme: Maquettes LMD
```

---

## 🔧 Utilisation des Modules

### 1️⃣ Répertoire des Étudiants
**URL:** `backend/repertoire_etudiants_backend.php`

**Fonctionnalités:**
- Liste complète des étudiants
- Filtrage par filière, statut
- Recherche par matricule/nom/email
- Export CSV
- Pagination (50 par page)

**Paramètres GET:**
```
?page=1                    # Page de pagination
?filiere=1                # Filtrer par filière
?statut=Actif             # Filtrer par statut
?recherche=koulibaly      # Recherche
?tri=nom                  # Tri (nom, prenom, matricule, date_inscription)
?format=json              # Retourner JSON au lieu de HTML
?export=csv               # Exporter en CSV
```

### 2️⃣ Maquettes LMD par Semestre
**URL:** `backend/maquette_lmd_backend.php`

**Fonctionnalités:**
- Visualisation des maquettes par semestre
- Affichage des UE et EC
- Crédits ECTS par semestre
- Volume horaire total

**Paramètres GET:**
```
?id=1          # ID de la filière (1=Génie Logiciel)
?format=json   # Retourner JSON
```

### 3️⃣ Configuration des Coefficients
**URL:** `backend/configuration_coefficients_backend.php`

**Fonctionnalités:**
- Configuration des coefficients par UE
- Gestion des crédits ECTS
- Volume horaire

**POST parameters:**
```
action=update_config
id_ue=1
coefficient=1.5
credits=6
volume=45
```

### 4️⃣ Gestion des Notes & Délibérations
**URL:** `backend/deliberation_backend.php`

**Fonctionnalités:**
- Liste des étudiants par filière
- Calcul automatique des moyennes
- Création de délibérations
- Statuts (Admis, Redoublant, Ajourné)

### 5️⃣ Sessions de Rattrapage
**URL:** `backend/gestion_sessions_rattrapage_backend.php`

**Fonctionnalités:**
- Création de sessions
- Inscription des étudiants
- Gestion des EC en rattrapage
- Statistiques

### 6️⃣ Parcours Académique Complet
**URL:** `backend/parcours_academique_backend.php?id=1`

**Affiche:**
- Notes par semestre (S1-S6)
- Moyennes semestrielles
- Crédits ECTS obtenus
- Progression globale

### 7️⃣ Carte Étudiant
**URL:** `backend/carte_etudiant_backend.php?id=1`

**Génère:**
- Numéro de carte unique
- QR code
- Informations étudiant
- Dates d'expiration

### 8️⃣ Attestation de Réussite
**URL:** `backend/attestation_backend.php?id=1`

**Informations:**
- Moyenne générale
- Mention (Très Bien, Bien, Passable, etc.)
- Crédits ECTS obtenus
- Code de vérification

### 9️⃣ Procès-Verbal de Délibération
**URL:** `backend/proces_verbal_backend.php`

**Contient:**
- Dates et lieu de réunion
- Président du jury
- Résumé des délibérations
- Décisions par étudiant

### 🔟 Gestion des Filières et UE
**URL:** `backend/gestion_filieres_ue_backend.php`

**Gère:**
- Structure des filières
- UE par filière
- EC par UE
- Maquettes complètes

---

## 💻 Code Backend - Exemple d'Utilisation

### Récupérer un étudiant
```php
require_once 'config/config.php';
require_once 'backend/classes/DataManager.php';

$etudiantManager = new EtudiantManager();
$etudiant = $etudiantManager->getById(1);
echo $etudiant['nom']; // Affiche le nom
```

### Récupérer les notes d'un étudiant
```php
$noteManager = new NoteManager();
$notes = $noteManager->getNotesByEtudiant(1, 'Normale');
$moyenne = $noteManager->getMoyenneGenerale(1);
```

### Créer une délibération
```php
$deliberationManager = new DeliberationManager();
$data = [
    'moyenne_semestre' => 14.5,
    'statut' => 'Admis',
    'mention' => 'Bien',
    'credits_obtenus' => 30,
    'responsable_deliberation' => 'Dr. Dupont',
    'observations' => 'Bon semestre'
];
$id_deliberation = $deliberationManager->create(1, 1, $data);
```

---

## 📝 Données de Test

La base de données inclut des données de démonstration:

**Département:**
- Sciences de l'Ingénieur
- Mathématiques & Informatique
- Économie & Gestion

**Filières:**
- Génie Logiciel (GL)
- Informatique (INFO)
- Gestion d'Entreprise (GE)

**Étudiants:**
- Mamadou Koulibaly (2023-FR-001)
- Fatima Touré (2023-FR-002)
- Mohamed Diallo (2023-FR-003)

**UE & EC:**
- Programmation I
- Mathématiques Discrètes
- Architecture des Ordinateurs

---

## 🔒 Points Importants

### Sécurité
- ✅ Requêtes préparées (Protection contre SQL injection)
- ✅ Nettoyage des entrées HTML
- ✅ Gestion des erreurs
- ✅ Logging automatique

### Performance
- ✅ Index sur les clés étrangères
- ✅ Singleton pour la connexion BD
- ✅ Requêtes optimisées avec GROUP_CONCAT

### Maintenance
- ✅ Code bien commenté
- ✅ Noms de fonctions clairs
- ✅ Structure logique et modulaire
- ✅ Logs dans `/logs/`

---

## 🐛 Troubleshooting

### Erreur: "Erreur de connexion"
- Vérifiez que MySQL est actif
- Vérifiez les identifiants dans `config/config.php`
- Vérifiez que la BD `gestion_notes` existe

### Erreur: "Table doesn't exist"
- Exécutez `install.php` pour créer les tables
- Ou importez `gestion_notes_complete.sql` manuellement

### Les données ne s'affichent pas
- Vérifiez que les tables contiennent des données
- Utilisez `?format=json` pour voir les données brutes
- Vérifiez les logs dans `/logs/`

---

## 📧 Support & Documentation

Pour plus d'informations:
1. Consultez les commentaires dans le code
2. Vérifiez les fichiers backend pour les exemples
3. Regardez la structure SQL dans `gestion_notes_complete.sql`

---

## ✅ Checklist de Déploiement

- [ ] Créer la base de données `gestion_notes`
- [ ] Configurer les identifiants dans `config/config.php`
- [ ] Exécuter `install.php`
- [ ] Tester accès à `index.php`
- [ ] Vérifier les modules
- [ ] Créer les dossiers `/logs` et `/uploads` si nécessaire
- [ ] Configurer les droits d'accès

---

**Version:** 2.0  
**Date:** 2024  
**Auteur:** Équipe de Développement  
**Licence:** MIT
