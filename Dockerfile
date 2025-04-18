FROM php:8.2-apache

# Installer les extensions PDO nécessaires
RUN docker-php-ext-install pdo pdo_mysql

# Activer mod_rewrite pour Apache
RUN a2enmod rewrite

# Copier les fichiers dans le conteneur
COPY . /var/www/html/

# Configuration Apache personnalisée
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

# Permissions pour Apache
RUN chown -R www-data:www-data /var/www/html/

