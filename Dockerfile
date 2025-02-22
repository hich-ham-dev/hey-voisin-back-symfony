FROM php:8.3-apache

# Installer les dépendances
RUN apt-get update && apt-get install -y \
    libicu-dev \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install \
    pdo_mysql \
    intl \
    opcache \
    zip

# Activer mod_rewrite
RUN a2enmod rewrite headers

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application
COPY . .

# Installer les dépendances PHP
RUN composer install --optimize-autoloader --no-dev

# Modifier les permissions
RUN chown -R www-data:www-data var

# Configuration d'Apache
COPY docker/apache.conf /etc/apache2/sites-available/000-default.conf

# Installer et activer SSL
RUN apt-get update && apt-get install -y ssl-cert && a2enmod ssl
RUN a2ensite default-ssl

# Copier la configuration Apache SSL
COPY docker/apache-ssl.conf /etc/apache2/sites-available/default-ssl.conf

# Ajouter la configuration PHP optimisée pour production
COPY docker/php.prod.ini $PHP_INI_DIR/conf.d/