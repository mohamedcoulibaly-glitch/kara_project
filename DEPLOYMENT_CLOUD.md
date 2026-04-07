# Guide de Déploiement Cloud - Kara Project

## 🌐 Déploiement sur un serveur VPS en ligne

Ce guide vous explique comment déployer l'application Kara Project sur un serveur VPS distant pour une mise en production.

---

## 📋 Prérequis

### 1. Serveur VPS
- **Ubuntu 20.04/22.04 LTS** ou **Debian 11+**
- **1 Go RAM minimum** (2 Go recommandés)
- **20 Go d'espace disque** minimum
- **Accès SSH** avec utilisateur root ou sudo

### 2. Nom de domaine (optionnel mais recommandé)
- Un nom de domaine pointant vers l'IP de votre serveur
- Exemple: `kara.votre-domaine.com`

---

## 🚀 Fournisseurs VPS recommandés

| Fournisseur | Prix mensuel | Lien |
|-------------|--------------|------|
| **DigitalOcean** | ~5-10$ | digitalocean.com |
| **OVH Cloud** | ~4-8€ | ovh.com/cloud |
| **Hetzner** | ~5€ | hetzner.com/cloud |
| **AWS Lightsail** | ~3.5$ | aws.amazon.com/lightsail |
| **Scaleway** | ~4€ | scaleway.com |

---

## 📦 Étape 1: Préparation du serveur

### 1.1 Se connecter au serveur
```bash
ssh root@votre-ip-serveur
```

### 1.2 Mettre à jour le système
```bash
apt update && apt upgrade -y
```

### 1.3 Installer Docker et Docker Compose
```bash
# Installer Docker
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# Installer Docker Compose
curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
chmod +x /usr/local/bin/docker-compose

# Vérifier l'installation
docker --version
docker-compose --version
```

### 1.4 Installer Git
```bash
apt install -y git
```

---

## 📥 Étape 2: Récupérer le projet

```bash
# Se placer dans le répertoire web
cd /var/www

# Cloner le dépôt GitHub
git clone https://github.com/mohamedcoulibaly-glitch/kara_project.git

# Se placer dans le répertoire du projet
cd kara_project
```

---

## ⚙️ Étape 3: Configuration

### 3.1 Créer le fichier d'environnement de production
```bash
# Copier le fichier d'exemple
cp .env.prod.example .env.prod

# Éditer avec vos valeurs
nano .env.prod
```

### 3.2 Remplir les variables d'environnement
```env
# Configuration de la base de données
DB_NAME=kara_db
DB_USER=kara_user
DB_PASS=votre_mot_de_passe_tres_secure_ici
DB_ROOT_PASSWORD=mot_de_passe_root_encore_plus_secure

# Configuration de l'application
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com

# Fuseau horaire
APP_TIMEZONE=Africa/Abidjan
```

### 3.3 Créer les dossiers nécessaires
```bash
mkdir -p uploads config/logs backups
chmod -R 755 uploads config/logs backups
```

---

## 🐳 Étape 4: Démarrer les conteneurs

```bash
# Démarrer avec Docker Compose en production
docker-compose -f docker-compose.prod.yml up -d --build

# Vérifier que les conteneurs sont démarrés
docker-compose -f docker-compose.prod.yml ps

# Voir les logs
docker-compose -f docker-compose.prod.yml logs -f
```

---

## 🔒 Étape 5: Configurer HTTPS (SSL/TLS)

### Option A: Avec Nginx Reverse Proxy et Let's Encrypt

#### 5.1 Installer Nginx
```bash
apt install -y nginx
```

#### 5.2 Créer la configuration Nginx
```bash
nano /etc/nginx/sites-available/kara_project
```

```nginx
server {
    listen 80;
    server_name votre-domaine.com www.votre-domaine.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name votre-domaine.com www.votre-domaine.com;

    # Certificats SSL (à générer avec Certbot)
    ssl_certificate /etc/letsencrypt/live/votre-domaine.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/votre-domaine.com/privkey.pem;

    # Paramètres SSL
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_prefer_server_ciphers on;
    ssl_ciphers HIGH:!aNULL:!MD5;

    # Proxy vers le conteneur web
    location / {
        proxy_pass http://localhost:80;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }

    # Limiter la taille des uploads
    client_max_body_size 20M;
}
```

#### 5.3 Activer le site
```bash
ln -s /etc/nginx/sites-available/kara_project /etc/nginx/sites-enabled/
nginx -t
systemctl reload nginx
```

#### 5.4 Installer Let's Encrypt (Certbot)
```bash
apt install -y certbot python3-certbot-nginx
certbot --nginx -d votre-domaine.com -d www.votre-domaine.com
```

---

## 🔥 Étape 6: Configurer le pare-feu (UFW)

```bash
# Installer UFW
apt install -y ufw

# Autoriser SSH
ufw allow OpenSSH

# Autoriser HTTP et HTTPS
ufw allow 'Nginx Full'

# Activer le pare-feu
ufw enable

# Vérifier le statut
ufw status
```

---

## 💾 Étape 7: Configurer les sauvegardes automatiques

### 7.1 Créer un script de sauvegarde
```bash
nano /usr/local/bin/kara_backup.sh
```

```bash
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/www/kara_project/backups"

# Sauvegarder la base de données
docker exec kara_db_prod mysqldump -u root -p$DB_ROOT_PASSWORD kara_db > $BACKUP_DIR/db_backup_$DATE.sql

# Sauvegarder les fichiers uploadés
tar -czf $BACKUP_DIR/uploads_backup_$DATE.tar.gz /var/www/kara_project/uploads

# Garder seulement 7 jours de sauvegardes
find $BACKUP_DIR -name "*.sql" -mtime +7 -delete
find $BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete

echo "Sauvegarde terminée: $DATE"
```

### 7.2 Rendre le script exécutable
```bash
chmod +x /usr/local/bin/kara_backup.sh
```

### 7.3 Planifier la sauvegarde quotidienne (cron)
```bash
crontab -e
```

Ajouter cette ligne:
```
0 2 * * * /usr/local/bin/kara_backup.sh
```

---

## 📊 Étape 8: Surveillance et maintenance

### Vérifier les logs
```bash
# Logs de l'application
docker-compose -f docker-compose.prod.yml logs -f web

# Logs de la base de données
docker-compose -f docker-compose.prod.yml logs -f db
```

### Redémarrer les conteneurs
```bash
docker-compose -f docker-compose.prod.yml restart
```

### Mettre à jour l'application
```bash
cd /var/www/kara_project
git pull origin main
docker-compose -f docker-compose.prod.yml up -d --build
```

---

## 🛠️ Commandes utiles

```bash
# Voir les conteneurs en cours
docker-compose -f docker-compose.prod.yml ps

# Arrêter les conteneurs
docker-compose -f docker-compose.prod.yml down

# Redémarrer les conteneurs
docker-compose -f docker-compose.prod.yml restart

# Voir les logs en temps réel
docker-compose -f docker-compose.prod.yml logs -f

# Accéder au shell du conteneur web
docker exec -it kara_web_prod bash

# Accéder à la base de données
docker exec -it kara_db_prod mysql -u root -p

# Nettoyer les ressources Docker inutilisées
docker system prune -a
```

---

## 🆘 Dépannage

### Les conteneurs ne démarrent pas
```bash
# Vérifier les logs
docker-compose -f docker-compose.prod.yml logs

# Redémarrer Docker
systemctl restart docker
```

### Problème de connexion à la base de données
```bash
# Vérifier que MySQL est prêt
docker exec kara_db_prod mysqladmin ping -u root -p

# Vérifier les variables d'environnement
docker exec kara_web_prod env | grep DB_
```

### Erreur 500
```bash
# Activer le debug temporairement
# Modifier .env.prod: APP_DEBUG=true
docker-compose -f docker-compose.prod.yml restart web
```

---

## ✅ Checklist de déploiement

- [ ] Serveur VPS configuré
- [ ] Docker et Docker Compose installés
- [ ] Projet cloné depuis GitHub
- [ ] Fichier .env.prod configuré
- [ ] Conteneurs démarrés
- [ ] HTTPS configuré avec Let's Encrypt
- [ ] Pare-feu activé
- [ ] Sauvegardes automatiques configurées
- [ ] Tests de l'application effectués
- [ ] Monitoring configuré

---

**Support:** Pour toute assistance, consultez la documentation ou contactez l'équipe de développement.