# Configuration Docker - Kara Project

## 🐳 Démarrage rapide avec Docker

### Étape 1: Démarrer Docker Desktop

1. **Ouvrez Docker Desktop** manuellement :
   - Recherchez "Docker Desktop" dans le menu Démarrer
   - Cliquez sur l'icône Docker Desktop pour le lancer
   - Attendez que Docker Desktop soit complètement démarré (l'icône dans la barre des tâches devient verte)

2. **Vérifiez que Docker fonctionne** :
   ```powershell
   docker info
   ```
   Si vous voyez des informations sur le serveur Docker, c'est que Docker est prêt.

### Étape 2: Lancer l'application avec Docker Compose

Une fois Docker Desktop démarré, exécutez :

```powershell
# Se placer dans le répertoire du projet
cd C:\xampp\htdocs\kara_project

# Lancer les conteneurs
docker compose up -d --build
```

### Étape 3: Accéder à l'application

Après le démarrage des conteneurs, votre application sera accessible à :

- **Application principale** : http://localhost:8080
- **phpMyAdmin** (gestion de la base de données) : http://localhost:8081
  - Utilisateur : `root`
  - Mot de passe : `root_password_2024`

### Commandes utiles

```powershell
# Voir les conteneurs en cours d'exécution
docker compose ps

# Arrêter les conteneurs
docker compose down

# Redémarrer les conteneurs
docker compose restart

# Voir les logs
docker compose logs -f web
docker compose logs -f db

# Accéder au shell du conteneur web
docker compose exec web bash

# Importer la base de données manuellement (si nécessaire)
docker compose exec db bash -c "mysql -u kara_user -pkara_password_2024 kara_db < /var/www/html/gestion_notes_complete.sql"
```

## 🔧 Configuration

### Fichiers Docker inclus :
- `Dockerfile` - Configuration du conteneur PHP/Apache
- `docker-compose.yml` - Configuration des services (web, db, phpmyadmin)
- `.dockerignore` - Fichiers à exclure du build Docker

### Services Docker :
| Service | Port | Description |
|---------|------|-------------|
| web | 8080 | Application PHP/Apache |
| db | 3306 | Base de données MySQL |
| phpmyadmin | 8081 | Interface web pour MySQL |

### Identifiants de la base de données :
- **Hôte** : `db` (depuis le conteneur web) ou `localhost` (depuis l'extérieur)
- **Base de données** : `kara_db`
- **Utilisateur** : `kara_user`
- **Mot de passe** : `kara_password_2024`

## 🛠️ Dépannage

### Problème: Docker Desktop ne démarre pas
1. Redémarrez votre ordinateur
2. Vérifiez que la virtualisation est activée dans le BIOS
3. Réinstallez Docker Desktop si nécessaire

### Problème: Port déjà utilisé
Si le port 8080 ou 8081 est déjà utilisé, modifiez `docker-compose.yml` :
```yaml
ports:
  - "8080:80"  # Changez 8080 par un autre port libre
```

### Problème: Base de données non initialisée
Si la base de données n'est pas créée automatiquement :
```powershell
docker compose exec db bash -c "mysql -u root -proot_password_2024 < /docker-entrypoint-initdb.d/init.sql"
```

## 📝 Notes importantes

- Les données de la base de données sont persistées dans un volume Docker nommé `db_data`
- Les fichiers uploadés sont dans le dossier `uploads/` (monté en volume)
- Pour réinitialiser complètement, exécutez : `docker compose down -v`