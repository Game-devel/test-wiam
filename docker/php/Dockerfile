FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    libpq-dev \
    icu-dev \
    libzip-dev \
    zip \
    unzip \
    netcat-openbsd \
    $PHPIZE_DEPS

RUN docker-php-ext-install \
    pdo_pgsql \
    intl \
    opcache \
    zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/php/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

WORKDIR /app

ENTRYPOINT ["/entrypoint.sh"]
