FROM php:8.4-fpm-alpine

# Arguments définis dans docker-compose.yml
ARG APP_ENV=prod
ARG USER_ID=1000
ARG GROUP_ID=1000

# Installation des dépendances système
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    libzip-dev \
    icu-dev \
    oniguruma-dev \
    libxml2-dev \
    linux-headers \
    $PHPIZE_DEPS

# Installation des extensions PHP
RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    opcache \
    zip \
    bcmath \
    sockets \
    && docker-php-ext-enable opcache

# Installation de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Création d'un utilisateur non-root
RUN addgroup -g ${GROUP_ID} symfony && \
    adduser -u ${USER_ID} -G symfony -s /bin/sh -D symfony

# Configuration PHP pour la production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY docker/php/conf.d/app.ini $PHP_INI_DIR/conf.d/
COPY docker/php/conf.d/app.prod.ini $PHP_INI_DIR/conf.d/

# Configuration du dossier de travail
WORKDIR /var/www/symfony

# Copie des fichiers de l'application
COPY . .
COPY --chown=symfony:symfony . .

# Installation des dépendances
RUN if [ "$APP_ENV" = "prod" ]; then \
        composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction; \
    else \
        composer install --prefer-dist --no-scripts --no-progress --no-interaction; \
    fi \
    && composer dump-autoload --optimize --no-dev --classmap-authoritative \
    && composer run-script post-install-cmd

# Permissions des dossiers d'écriture
RUN chown -R symfony:symfony var
RUN chmod -R 777 var

# Utilisateur par défaut
USER symfony

# Exposition du port PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]