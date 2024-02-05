FROM php:8.1-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo_mysql

COPY . .

RUN composer install --no-interaction

RUN php artisan key:generate

CMD ["php-fpm"]
