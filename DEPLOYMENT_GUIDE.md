# Guide de Déploiement - Kara Project

## 📋 Vue d'ensemble

Ce guide vous accompagnera dans le déploiement de l'application de gestion académique Kara Project sur un serveur de production.

## 🎯 Prérequis

### Serveur Web
- **Apache** ou **Nginx** avec support PHP
- **PHP 7.4** ou supérieur (8.1+ recommandé)
- **MySQL 5.7+** ou **MariaDB 10.3+**

### Extensions PHP requises
- `pdo_mysql`
- `gd` (pour les photos d'étudiants)
- `mbstring`
- `json`
- `zip` (pour les exports)

## 🚀 Options de Déploiement

### Option 1: Hébergement Mutualisé (Recommandé pour débuter)

#### 1. Choisir un hébergeur
- **Hostinger**, **OVH**, **o2switch**, **PlanetHoster**
- Vérifier que l'hébergement supporte PHP 7.4+ et MySQL

#### 2. Transférer les fichiers
```bash
# Via FTP (FileZilla) ou SSH
# Télécharger tous les fichiers du projet vers le répertoire public (www/ ou public_html/)
```

#### 3. Configurer la base de données
1. Créer une base de données via le panneau de contrôle (cPanel/Plesk)
2. Créer un utilisateur MySQL avec tous les privilèges
3. Importer le fichier SQL:
   - Utiliser `gestion_notes_complete.sql` (version complète)
   - Via phpMyAdmin ou ligne de commande

#### 4. Modifier la configuration
Éditer `config/config.php`:
```php
<?php
define('DB_HOST', 'localhost');
define('DB_NAME', 'votre_base_de_donnees');
define('DB_USER', 'votre_utilisateur');
define('DB_PASS', 'votre_mot_de_passe');
define('DB_CHARSET', 'utf8mb4');
?>
```

#### 5. Configurer .htaccess
Le fichier `.htaccess` est déjà inclus pour:
- Réécriture d'URL
- Sécurité de base
- Compression Gzip

### Option 2: VPS/Cloud (Plus de contrôle)

#### 1. Configuration du serveur (Ubuntu/Debian)

```bash
# Installer LAMP Stack
sudo apt update
sudo apt install apache2 mysql-server php php-mysql libapache2-mod-php php-gd php-mbstring php-zip php-json

# Sécuriser MySQL
sudo mysql_secure_installation

# Activer les modules Apache
sudo a2enmod rewrite
sudo a2enmod ssl
sudo systemctl restart apache2
```

#### 2. Déployer l'application

```bash
# Cloner le dépôt
cd /var/www/html
sudo git clone https://github.com/mohamedcoulibaly-glitch/kara_project.git
sudo chown -R www-data:www-data kara_project
sudo chmod -R 755 kara_project

# Configurer Apache
sudo nano /etc/apache2/sites-available/kara_project.conf
```

Configuration Apache:
```apache
<VirtualHost *:80>
    ServerName votre-domaine.com
    DocumentRoot /var/www/html/kara_project
    
    <Directory /var/www/html/kara_project>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/kara_error.log
    CustomLog ${APACHE_LOG_DIR}/kara_access.log combined
</VirtualHost>
```

```bash
# Activer le site
sudo a2ensite kara_project.conf
sudo systemctl reload apache2
```

#### 3. Configurer MySQL

```bash
# Se connecter à MySQL
sudo mysql -u root -p

# Dans MySQL
CREATE DATABASE kara_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'kara_user'@'localhost' IDENTIFIED BY 'mot_de_passe_fort';
GRANT ALL PRIVILEGES ON kara_db.* TO 'kara_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Importer la base de données
mysql -u kara_user -p kara_db < gestion_notes_complete.sql
```

#### 4. Configurer PHP

```bash
# Éditer php.ini
sudo nano /etc/php/8.1/apache2/php.ini

# Ajuster les paramètres
upload_max_filesize = 20M
post_max_size = 25M
max_execution_time = 300
memory_limit = 256M
date.timezone = Africa/Abidjan  # ou votre fuseau horaire
```

### Option 3: Docker (Conteneurisation)

#### 1. Créer Dockerfile

```dockerfile
FROM php:8.1-apache

RUN docker-php-ext-install pdo_mysql mysqli gd mbstring zip

RUN a2enmod rewrite

COPY . /var/www/html/

WORKDIR /var/www/html/

EXPOSE 80

CMD ["apache2-foreground"]
```

#### 2. docker-compose.yml

```yaml
version: '3.8'

services:
  web:
    build: .
    ports:
      - "80:80"
    volumes:
      - .:/var/www/html
      - ./uploads:/var/www/html/uploads
    depends_on:
      - db
    environment:
      - DB_HOST=db
      - DB_NAME=kara_db
      - DB_USER=kara_user
      - DB_PASS=kara_password

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: kara_db
      MYSQL_USER: kara_user
      MYSQL_PASSWORD: kara_password
    volumes:
      - db_data:/var/lib/mysql
      - ./gestion_notes_complete.sql:/docker-entrypoint-initdb.d/init.sql
    ports:
      - "3306:3306"

volumes:
  db_data:
```

#### 3. Démarrer

```bash
docker-compose up -d
```

## 🔧 Configuration Post-Déploiement

### 1. Vérifier les permissions
```bash
# S'assurer que le serveur web peut écrire dans ces dossiers
chmod -R 755 uploads/
chmod -R 755 config/logs/
chown -R www-data:www-data uploads/
chown -R www-data:www-data config/logs/
```

### 2. Configurer HTTPS (SSL/TLS)

#### Avec Let's Encrypt (Gratuit)
```bash
# Installer Certbot
sudo apt install certbot python3-certbot-apache

# Obtenir un certificat
sudo certbot --apache -d votre-domaine.com -d www.votre-domaine.com

# Renouvellement automatique
sudo certbot renew --dry-run
```

### 3. Sécurité

#### a. Modifier les identifiants par défaut
- Changer tous les mots de passe administrateur
- Mettre à jour `config/config.php` avec des identifiants forts

#### b. Protéger les dossiers sensibles
Ajouter dans `.htaccess`:
```apache
# Bloquer l'accès aux dossiers sensibles
RedirectMatch 403 /backend/
RedirectMatch 403 /config/
RedirectMatch 403 /\.git
```

#### c. Désactiver l'affichage des erreurs en production
Dans `php.ini`:
```ini
display_errors = Off
log_errors = On
error_log = /var/log/php_errors.log
```

### 4. Sauvegardes automatiques

#### Script de sauvegarde (`backup.sh`)
```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/kara_project"

# Sauvegarder la base de données
mysqldump -u kara_user -p'mot_de_passe' kara_db > $BACKUP_DIR/db_backup_$DATE.sql

# Sauvegarder les fichiers
tar -czf $BACKUP_DIR/files_backup_$DATE.tar.gz /var/www/html/kara_project/

# Garder seulement 7 jours de sauvegardes
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
```

#### Tâche cron (quotidienne à 2h du matin)
```bash
0 2 * * * /path/to/backup.sh
```

## 📊 Surveillance et Maintenance

### 1. Logs à surveiller
- `config/logs/` - Logs applicatives
- `/var/log/apache2/` - Logs Apache
- `/var/log/mysql/` - Logs MySQL

### 2. Monitoring
- Utiliser des outils comme **Uptime Robot** pour surveiller la disponibilité
- Configurer des alertes email en cas d'erreur

### 3. Mises à jour
- Maintenir PHP, MySQL et Apache à jour
- Tester les mises à jour en environnement de staging d'abord

## 🆘 Dépannage

### Problèmes courants

#### 1. Erreur 500
- Vérifier les logs Apache: `tail -f /var/log/apache2/error.log`
- Vérifier les permissions des fichiers
- Désactiver temporairement `.htaccess` pour tester

#### 2. Erreur de connexion à la base de données
- Vérifier les identifiants dans `config/config.php`
- S'assurer que MySQL est en cours d'exécution: `sudo systemctl status mysql`
- Vérifier que l'utilisateur a les bons privilèges

#### 3. Pages blanches
- Activer l'affichage des erreurs temporairement dans `index.php`:
```php
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

#### 4. Problèmes de session
- Vérifier les permissions du dossier de session PHP
- S'assurer que `session.save_path` est accessible en écriture

## 📧 Support

Pour toute assistance:
- Consulter la documentation dans `README.md`
- Vérifier les logs dans `config/logs/`
- Contacter l'équipe de développement

## ✅ Checklist de déploiement

- [ ] Code poussé sur GitHub ✓
- [ ] Hébergement configuré (LAMP/ mutualisé)
- [ ] Base de données créée et importée
- [ ] Fichier `config/config.php` mis à jour
- [ ] Permissions des dossiers définies
- [ ] HTTPS configuré (SSL/TLS)
- [ ] Sauvegardes automatiques mises en place
- [ ] Tests de fonctionnement effectués
- [ ] Monitoring configuré
- [ ] Documentation mise à jour

---

**Dernière mise à jour:** 4 juin 2026  
**Version:** 1.0.0