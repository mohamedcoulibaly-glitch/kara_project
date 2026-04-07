#!/bin/bash

# Script de déploiement automatique - Kara Project
# Utilisation: ./deploy.sh [vps|shared|docker]

set -e

# Couleurs pour les messages
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Fonctions d'affichage
print_info() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCÈS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[ATTENTION]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERREUR]${NC} $1"
}

# Vérifier les privilèges root
check_root() {
    if [ "$EUID" -ne 0 ]; then
        print_error "Ce script doit être exécuté en tant que root (sudo)"
        exit 1
    fi
}

# Déploiement VPS (Ubuntu/Debian)
deploy_vps() {
    print_info "Début du déploiement VPS..."
    
    # 1. Installation des dépendances
    print_info "Installation du stack LAMP..."
    apt update
    apt install -y apache2 mysql-server php php-mysql libapache2-mod-php \
        php-gd php-mbstring php-zip php-json php-curl php-xml unzip git
    
    # 2. Configuration Apache
    print_info "Configuration d'Apache..."
    a2enmod rewrite
    a2enmod ssl
    systemctl restart apache2
    
    # 3. Sécurisation MySQL
    print_info "Sécurisation de MySQL..."
    mysql_secure_installation
    
    # 4. Clonage du projet
    print_info "Clonage du projet..."
    cd /var/www/html
    if [ -d "kara_project" ]; then
        print_warning "Le dossier kara_project existe déjà. Suppression..."
        rm -rf kara_project
    fi
    git clone https://github.com/mohamedcoulibaly-glitch/kara_project.git
    chown -R www-data:www-data kara_project
    chmod -R 755 kara_project
    
    # 5. Configuration de la base de données
    print_info "Configuration de la base de données..."
    read -p "Nom de la base de données (kara_db): " DB_NAME
    DB_NAME=${DB_NAME:-kara_db}
    read -p "Utilisateur MySQL (kara_user): " DB_USER
    DB_USER=${DB_USER:-kara_user}
    read -sp "Mot de passe MySQL: " DB_PASS
    echo
    
    mysql -u root -p <<EOF
CREATE DATABASE IF NOT EXISTS $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER IF NOT EXISTS '$DB_USER'@'localhost' IDENTIFIED BY '$DB_PASS';
GRANT ALL PRIVILEGES ON $DB_NAME.* TO '$DB_USER'@'localhost';
FLUSH PRIVILEGES;
EOF
    
    # Importation des données
    print_info "Importation de la base de données..."
    mysql -u $DB_USER -p$DB_PASS $DB_NAME < /var/www/html/kara_project/gestion_notes_complete.sql
    
    # 6. Configuration de l'application
    print_info "Configuration de l'application..."
    cd /var/www/html/kara_project
    cp .env.example .env
    sed -i "s/DB_NAME=kara_db/DB_NAME=$DB_NAME/" .env
    sed -i "s/DB_USER=kara_user/DB_USER=$DB_USER/" .env
    sed -i "s/DB_PASS=.*/DB_PASS=$DB_PASS/" .env
    
    # 7. Configuration Apache pour le projet
    print_info "Configuration du virtual host Apache..."
    read -p "Nom de domaine (ex: kara.example.com): " DOMAIN
    DOMAIN=${DOMAIN:-localhost}
    
    cat > /etc/apache2/sites-available/kara_project.conf <<EOF
<VirtualHost *:80>
    ServerName $DOMAIN
    DocumentRoot /var/www/html/kara_project
    
    <Directory /var/www/html/kara_project>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog \${APACHE_LOG_DIR}/kara_error.log
    CustomLog \${APACHE_LOG_DIR}/kara_access.log combined
</VirtualHost>
EOF
    
    a2ensite kara_project.conf
    a2dissite 000-default.conf
    systemctl reload apache2
    
    # 8. Configuration HTTPS avec Let's Encrypt
    print_info "Configuration de HTTPS..."
    read -p "Configurer Let's Encrypt (SSL gratuit) ? (o/n): " SSL_CHOICE
    if [ "$SSL_CHOICE" = "o" ]; then
        apt install -y certbot python3-certbot-apache
        certbot --apache -d $DOMAIN
    fi
    
    # 9. Permissions et sécurité
    print_info "Configuration des permissions..."
    chmod -R 755 /var/www/html/kara_project/uploads
    chmod -R 755 /var/www/html/kara_project/config/logs
    chown -R www-data:www-data /var/www/html/kara_project/uploads
    chown -R www-data:www-data /var/www/html/kara_project/config/logs
    
    # 10. Configuration des sauvegardes
    print_info "Configuration des sauvegardes automatiques..."
    mkdir -p /backups/kara_project
    cat > /usr/local/bin/kara_backup.sh <<EOF
#!/bin/bash
DATE=\$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/backups/kara_project"

# Sauvegarder la base de données
mysqldump -u $DB_USER -p'$DB_PASS' $DB_NAME > \$BACKUP_DIR/db_backup_\$DATE.sql

# Sauvegarder les fichiers
tar -czf \$BACKUP_DIR/files_backup_\$DATE.tar.gz /var/www/html/kara_project/

# Garder seulement 7 jours de sauvegardes
find \$BACKUP_DIR -name "*.sql" -mtime +7 -delete
find \$BACKUP_DIR -name "*.tar.gz" -mtime +7 -delete
EOF
    
    chmod +x /usr/local/bin/kara_backup.sh
    
    # Ajouter la tâche cron
    if ! crontab -l | grep -q "kara_backup.sh"; then
        (crontab -l 2>/dev/null; echo "0 2 * * * /usr/local/bin/kara_backup.sh") | crontab -
    fi
    
    print_success "Déploiement VPS terminé avec succès !"
    print_info "Votre application est accessible à l'adresse: http://$DOMAIN"
    print_warning "N'oubliez pas de changer les mots de passe administrateur par défaut !"
}

# Déploiement Docker
deploy_docker() {
    print_info "Début du déploiement Docker..."
    
    # Vérifier si Docker est installé
    if ! command -v docker &> /dev/null; then
        print_warning "Docker n'est pas installé. Installation..."
        apt update
        apt install -y docker.io docker-compose
        systemctl start docker
        systemctl enable docker
    fi
    
    # Cloner le projet
    cd /var/www/html
    if [ -d "kara_project" ]; then
        print_warning "Le dossier kara_project existe déjà."
    else
        git clone https://github.com/mohamedcoulibaly-glitch/kara_project.git
    fi
    
    cd kara_project
    
    # Créer le fichier .env pour Docker
    cp .env.example .env
    read -sp "Mot de passe pour la base de données: " DB_PASS
    echo
    sed -i "s/DB_PASS=.*/DB_PASS=$DB_PASS/" .env
    
    # Démarrer les conteneurs
    print_info "Démarrage des conteneurs Docker..."
    docker-compose up -d
    
    # Afficher les logs
    print_success "Déploiement Docker terminé !"
    print_info "Application accessible à: http://localhost"
    print_info "Base de données accessible sur le port 3306"
}

# Déploiement mutualisé (guidé)
deploy_shared() {
    print_info "Pour un hébergement mutualisé, suivez ces étapes:"
    echo
    echo "1. Transférez les fichiers via FTP (FileZilla) vers votre hébergement"
    echo "   - Dossier cible: public_html/ ou www/"
    echo
    echo "2. Créez une base de données via votre panneau de contrôle (cPanel/Plesk)"
    echo
    echo "3. Importez le fichier gestion_notes_complete.sql via phpMyAdmin"
    echo
    echo "4. Modifiez config/config.php avec vos identifiants:"
    echo "   - DB_HOST: localhost (généralement)"
    echo "   - DB_NAME: votre_base"
    echo "   - DB_USER: votre_utilisateur"
    echo "   - DB_PASS: votre_mot_de_passe"
    echo
    echo "5. Configurez HTTPS via votre hébergeur (Let's Encrypt souvent inclus)"
    echo
    echo "6. Testez l'application en accédant à votre domaine"
    echo
    print_warning "Pour plus de détails, consultez DEPLOYMENT_GUIDE.md"
}

# Menu principal
show_menu() {
    echo
    echo "=================================="
    echo "  Kara Project - Déploiement"
    echo "=================================="
    echo
    echo "Choisissez le type de déploiement:"
    echo "  1) VPS/Cloud (Ubuntu/Debian) - Automatique"
    echo "  2) Docker - Automatique"
    echo "  3) Hébergement mutualisé - Guide pas à pas"
    echo "  4) Quitter"
    echo
    read -p "Votre choix [1-4]: " choice
    
    case $choice in
        1)
            check_root
            deploy_vps
            ;;
        2)
            check_root
            deploy_docker
            ;;
        3)
            deploy_shared
            ;;
        4)
            print_info "Au revoir !"
            exit 0
            ;;
        *)
            print_error "Choix invalide"
            show_menu
            ;;
    esac
}

# Vérifier si le script est exécuté directement
if [ "${BASH_SOURCE[0]}" = "${0}" ]; then
    if [ $# -eq 0 ]; then
        show_menu
    else
        case $1 in
            vps)
                check_root
                deploy_vps
                ;;
            docker)
                check_root
                deploy_docker
                ;;
            shared)
                deploy_shared
                ;;
            *)
                print_error "Type de déploiement inconnu: $1"
                echo "Utilisation: $0 [vps|shared|docker]"
                exit 1
                ;;
        esac
    fi
fi