FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev git unzip zip \
    && docker-php-ext-install pdo_pgsql zip gd bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/dekoservice.alxple.com

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

RUN chown -R www-data:www-data /var/www/dekoservice.alxple.com \
    && find /var/www/dekoservice.alxple.com -type d -exec chmod 750 {} \; \
    && find /var/www/dekoservice.alxple.com -type f -exec chmod 640 {} \;

EXPOSE 9000
CMD ["php-fpm"]