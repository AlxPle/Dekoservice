# Этап 1: Сборка фронтенда (Node.js)
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci || npm install
COPY . .
RUN npm run build

# Этап 2: Сборка бэкенда (PHP)
FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libpng-dev libonig-dev libxml2-dev libpq-dev git unzip zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-install intl pdo_pgsql zip gd bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo "upload_max_filesize = 50M\npost_max_size = 50M\nmemory_limit = 256M" > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/dekoservice.alxple.com

COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

COPY . .
# Копируем собранный фронтенд из первого этапа
COPY --from=node-builder /app/public/build ./public/build

RUN chown -R www-data:www-data /var/www/dekoservice.alxple.com \
    && find /var/www/dekoservice.alxple.com -type d -exec chmod 755 {} \; \
    && find /var/www/dekoservice.alxple.com -type f -exec chmod 644 {} \;

EXPOSE 9000
CMD ["php-fpm"]