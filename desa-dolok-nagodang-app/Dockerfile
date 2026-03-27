FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    zip unzip curl git libonig-dev libxml2-dev

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www

COPY . .

CMD ["php-fpm"]