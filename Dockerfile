FROM php:8.1-apache

# Installer les extensions PHP requises
RUN docker-php-ext-install pdo pdo_mysql mysqli gd mbstring zip

# Activer le module Apache rewrite
RUN a2enmod rewrite

# Copier les fichiers de l'application
COPY . /var/www/html/

# Définir le répertoire de travail
WORKDIR /var/www/html/

# Définir les permissions
RUN chown -R www-data:www-data /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html/config/logs \
    && chmod -R 755 /var/www/html/uploads \
    && chmod -R 755 /var/www/html/config/logs

# Exposer le port 80
EXPOSE 80

# Démarrer Apache
CMD ["apache2-foreground"]