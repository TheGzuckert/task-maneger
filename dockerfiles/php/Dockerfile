FROM php:8.3-fpm-alpine3.19

RUN apk add --no-cache \
    bash \
    curl \
    libpng-dev \
    libzip-dev \
    zlib-dev \
    postgresql-dev

RUN docker-php-ext-install gd \
    && docker-php-ext-install zip \
    && docker-php-ext-install pdo_pgsql

RUN curl -sS https://raw.githubusercontent.com/vishnubob/wait-for-it/master/wait-for-it.sh -o /usr/local/bin/wait-for-it.sh && chmod +x /usr/local/bin/wait-for-it.sh

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN apk add --no-cache nodejs npm

WORKDIR /var/www

EXPOSE 8000
