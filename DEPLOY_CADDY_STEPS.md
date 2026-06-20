# Развёртывание Laravel с Caddy (шаг за шагом)

Ниже — пошаговая инструкция, чтобы самостоятельно отредактировать всё на хостинге, запустить через Docker + Caddy и быстро отлавливать ошибки.

Важно: замените `dekoservice.alxple.com` и пути при необходимости.

---

## 1. Резервная копия (прежде чем править)

На сервере перед изменениями сделайте бэкап текущей папки и конфигов:

```bash
sudo tar -czf ~/backup_dekoservice_$(date +%F).tar.gz /var/www/dekoservice.alxple.com || true
```

## 2. Создать хост-папку и дать базовые права

```bash
sudo mkdir -p /var/www/dekoservice.alxple.com
sudo chown -R $USER:www-data /var/www/dekoservice.alxple.com
sudo find /var/www/dekoservice.alxple.com -type d -exec chmod 750 {} \;
sudo find /var/www/dekoservice.alxple.com -type f -exec chmod 640 {} \;
sudo chmod -R g+rw /var/www/dekoservice.alxple.com/storage /var/www/dekoservice.alxple.com/bootstrap/cache
```

Если хотите дать ACL (более гибко):

```bash
sudo setfacl -R -m u:www-data:rx /var/www/dekoservice.alxple.com
sudo setfacl -R -m u:$USER:rwx /var/www/dekoservice.alxple.com
```

## 3. Пример `Dockerfile` для `app` (положите в `app/Dockerfile` в репо)

```dockerfile
FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
  libzip-dev libpng-dev libonig-dev libxml2-dev git unzip zip \
  && docker-php-ext-install pdo_mysql zip gd bcmath

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
```

## 4. Пример `docker-compose.yml` (в корне проекта)

```yaml
version: "3.8"
services:
  app:
    build:
      context: ./app
      dockerfile: Dockerfile
    volumes:
      - /var/www/dekoservice.alxple.com:/var/www/dekoservice.alxple.com
    environment:
      - APP_ENV=production
    expose:
      - "9000"

  caddy:
    image: caddy:2
    ports:
      - "80:80"
      - "443:443"
    depends_on:
      - app
    volumes:
      - caddy_data:/data
      - caddy_config:/config
      - /var/www/dekoservice.alxple.com:/var/www/dekoservice.alxple.com:ro
      - ./deploy/Caddyfile:/etc/caddy/Caddyfile:ro

volumes:
  caddy_data:
  caddy_config:
```

## 5. Пример `deploy/Caddyfile`
Если вы уже создали `deploy/Caddyfile`, пропустите этот раздел — убедитесь, что файл находится в `deploy/Caddyfile` и смонтирован в `docker-compose.yml`.

```caddyfile
dekoservice.alxple.com {
  root * /var/www/dekoservice.alxple.com/public
  encode zstd gzip
  file_server
  @notFile not file
  rewrite @notFile /index.php
  php_fastcgi app:9000

  header {
    Strict-Transport-Security "max-age=31536000; includeSubDomains; preload"
    X-Content-Type-Options "nosniff"
    X-Frame-Options "DENY"
    Referrer-Policy "same-origin"
  }

  log {
    output file /var/log/caddy/dekoservice.access.log
    level INFO
  }

  handle_errors {
    rewrite * /index.php
    php_fastcgi app:9000
  }
}
```

> Примечание: создайте на хосте папку `/var/log/caddy` и дайте права, если используете файл логов:

```bash
sudo mkdir -p /var/log/caddy
sudo chown -R $USER:www-data /var/log/caddy
sudo chmod 750 /var/log/caddy
```

## 6. Заливка кода в хост-папку

Вы можете закинуть код через `scp` или `git clone` прямо в `/var/www/dekoservice.alxple.com`.

Пример `git clone`:

```bash
sudo -u $USER git clone <репозиторий> /var/www/dekoservice.alxple.com
```

Или `rsync` с локальной машины:

```bash
rsync -av --exclude vendor --exclude node_modules ./ /tmp/deploy-src/
scp -r /tmp/deploy-src/* user@server:/var/www/dekoservice.alxple.com/
```

## 7. Установка Docker и Docker Compose (если нет)

```bash
curl -fsSL https://get.docker.com | sh
sudo usermod -aG docker $USER
sudo apt update && sudo apt install -y docker-compose
```

После установки выйдите и зайдите снова (или перезагрузите сессию), чтобы применился `usermod`.

## 8. Запуск и первоначальная проверка

В каталоге с `docker-compose.yml` выполните:

```bash
docker-compose up -d --build
```

Проверить статусы контейнеров:

```bash
docker-compose ps
```

## 9. Artisan команды (создать ключ, миграции, storage link)

```bash
docker-compose run --rm app php artisan key:generate --force
docker-compose run --rm app php artisan migrate --force
docker-compose run --rm app php artisan storage:link
```

## 10. Как видеть и отлавливать ошибки

- Логи Caddy (контейнер):

```bash
docker-compose logs -f caddy
```

- Логи Laravel (файловые):

```bash
# внутри хоста
sudo tail -n 200 /var/www/dekoservice.alxple.com/storage/logs/laravel.log
# если хотите смотреть в реальном времени
sudo tail -f /var/www/dekoservice.alxple.com/storage/logs/laravel.log
```

- Логи контейнера `app` (php-fpm и вывод artisan):

```bash
docker-compose logs -f app
```

- Используйте `docker-compose exec app bash` для запуска интерактивных команд внутри контейнера:

```bash
docker-compose exec app bash
# затем внутри контейнера можно посмотреть /var/www/dekoservice.alxple.com/storage/logs
```

## 11. Включение debug для временной отладки

В `.env` на хосте временно установите:

```
APP_DEBUG=true
APP_ENV=local
```

После отладки верните в `production`.

## 12. Частые проблемы и как их править

- Права доступа (403): проверьте владельца и права на `public`, `storage` и `bootstrap/cache`.
- Caddy не может получить сертификат: проверьте DNS (A-запись указывает на IP сервера) и порты 80/443 открыты.
- PHP ошибки 500: смотрите `storage/logs/laravel.log` и `docker-compose logs app`.
- Composer зависимости: если в контейнере не установлены, выполните:

```bash
docker-compose run --rm app composer install --no-dev --optimize-autoloader
```

## 13. Полезные команды для перезапуска и очистки

```bash
# пересобрать и перезапустить
docker-compose down && docker-compose up -d --build

# посмотреть только последние 200 строк логов всех сервисов
docker-compose logs --tail=200
```

---

Если хотите, я могу прямо сейчас создать эти файлы в репо (`app/Dockerfile`, `docker-compose.yml`, `deploy/Caddyfile`) и адаптировать их под ваш проект — подтвердите, и я применю изменения.
