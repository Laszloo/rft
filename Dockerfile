FROM php:8.1-fpm-alpine

RUN set -eux && \
    apk add --no-cache tzdata icu-dev libzip-dev oniguruma-dev git unzip bash && \
    docker-php-ext-configure intl && \
    docker-php-ext-install -j$(nproc) pdo_mysql intl zip && \
    docker-php-ext-enable opcache && \
    { echo ""; echo "clear_env = no"; } >> /usr/local/etc/php-fpm.d/www.conf && \
    cp /usr/share/zoneinfo/Europe/Budapest /etc/localtime && echo "Europe/Budapest" > /etc/timezone

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
