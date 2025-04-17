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
    $PHPIZE_DEPS && \
    rm -rf /var/cache/apk/*

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

# Résolution du problème Git
RUN git config --global --add safe.directory /var/www/symfony

# Installation des dépendances
RUN if [ "$APP_ENV" = "prod" ]; then \
        composer install --prefer-dist --no-dev --no-scripts --no-progress --no-interaction \
        && composer dump-autoload --optimize --classmap-authoritative \
        && APP_ENV=prod composer run-script post-install-cmd; \
    else \
        composer install --prefer-dist --no-progress --no-interaction \
        && composer dump-autoload --optimize \
        && composer run-script post-install-cmd; \
    fi

# Rendre les scripts exécutables
RUN chmod +x bin/phpunit bin/console

# Permissions des dossiers d'écriture
RUN chown -R symfony:symfony var
RUN chmod -R 755 var

# Utilisateur par défaut
USER symfony

# Exposition du port PHP-FPM
EXPOSE 9000

# Ajout du healthcheck
HEALTHCHECK --interval=30s --timeout=3s --start-period=30s --retries=3 \
  CMD php-fpm -t || exit 1

CMD ["php-fpm"]
