FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    curl \
    git \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        gd \
        zip \
        bcmath \
        exif \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* \
    && mkdir -p /tmp/php \
    && chmod 1777 /tmp /tmp/php

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
COPY docker/php/custom.ini /usr/local/etc/php/conf.d/custom.ini

WORKDIR /var/www

COPY . .

CMD ["php-fpm"]
