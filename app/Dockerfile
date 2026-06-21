# Этап 1: Сборка PHP зависимостей (Composer)
FROM composer:latest AS composer-builder
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --ignore-platform-reqs --no-interaction --no-scripts

# Этап 2: Сборка фронтенда (Node.js)
FROM node:20-alpine AS node-builder
WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci || npm install
COPY . .
# Копируем vendor, чтобы Vite мог найти Ziggy
COPY --from=composer-builder /app/vendor ./vendor
RUN npm run build

# Этап 3: Финальный образ (PHP-FPM)
FROM php:8.4-fpm

RUN apt-get update && apt-get install -y \
    libicu-dev libzip-dev libpng-dev libjpeg62-turbo-dev libwebp-dev libonig-dev libxml2-dev libpq-dev \
    git unzip zip \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) intl pdo_pgsql zip gd bcmath

# Install image optimizer CLI tools (required by spatie/image-optimizer)
RUN apt-get install -y \
    jpegoptim optipng pngquant webp gifsicle

RUN echo "upload_max_filesize = 50M\npost_max_size = 50M\nmemory_limit = 256M" > /usr/local/etc/php/conf.d/uploads.ini

WORKDIR /var/www/dekoservice.alxple.com

COPY . .
COPY --from=composer-builder /app/vendor ./vendor
COPY --from=node-builder /app/public/build ./public/build

RUN chown -R www-data:www-data /var/www/dekoservice.alxple.com \
    && find /var/www/dekoservice.alxple.com -type d -exec chmod 755 {} \; \
    && find /var/www/dekoservice.alxple.com -type f -exec chmod 644 {} \;

EXPOSE 9000
CMD ["php-fpm"]