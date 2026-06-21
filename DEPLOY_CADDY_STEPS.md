# Production Deploy: Dockge + Existing Caddy

Этот документ теперь описывает один каноничный вариант запуска для вашего сервера:

1. Caddy уже установлен на хосте и является единой точкой входа (80/443).
2. Стек приложения запускается через Docker Compose.
3. В проектном стеке наружу торчит только локальный порт для Nginx (18080).
4. Весь код (бэкенд и фронтенд) **встраивается в образ при сборке** (multi-stage build), а не монтируется с хоста. С хоста пробрасываются только `.env` и папка `storage`.

---

## 1. Что должно быть на сервере

Проверить базовые условия:

```bash
docker --version
docker compose version
sudo systemctl status caddy --no-pager
```

Проверить DNS:
1. `A` для `dekoservice.alxple.com` указывает на `46.225.68.147`.

---

## 2. Подготовка проекта на сервере

Разместить репозиторий на сервере, например:

```bash
sudo mkdir -p /opt/stacks/dekoservice
sudo chown -R $USER:$USER /opt/stacks/dekoservice
cd /opt/stacks/dekoservice
git clone <repo-url> .
mv /opt/stacks/dekoservice/Dekoservice/* /opt/stacks/dekoservice/
mv /opt/stacks/dekoservice/Dekoservice/.* /opt/stacks/dekoservice/ 2>/dev/null || true
rmdir /opt/stacks/dekoservice/Dekoservice
ls /opt/stacks/dekoservice
```

Создать production `.env`:

```bash
cp app/.env.example app/.env
```

Минимальные значения в `app/.env`:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://dekoservice.alxple.com

DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=dekoservice
DB_USERNAME=dekoservice
DB_PASSWORD=change_me

CACHE_STORE=redis
REDIS_HOST=redis
REDIS_PORT=6379

QUEUE_CONNECTION=database
SESSION_DRIVER=database
```

Дать права на папку `storage` (так как она пробрасывается в контейнер, где работает пользователь www-data):
```bash
sudo chmod -R 777 app/storage
```

---

## 3. Запуск стека

Поскольку код больше не монтируется с хоста, а встраивается внутрь, **перед каждым запуском необходимо собирать образ**.

```bash
cd /opt/stacks/dekoservice

# Сборка образа (загрузит пакеты Composer и соберет фронтенд через npm run build)
docker compose build app

# Запуск стека в фоне
docker compose up -d
```

После первого запуска выполнить первичную инициализацию (создание ключа, БД и симлинка):

```bash
# Генерируем ключ, если его нет
grep -q '^APP_KEY=' app/.env || echo 'APP_KEY=' >> app/.env
docker compose exec app php artisan key:generate --force

# Выполняем миграции
docker compose exec app php artisan migrate --force

# Создаем администратора для панели управления Filament
docker compose exec app php artisan make:filament-user --name="Admin" --email="admin@example.com" --password="changeme"

# Создаем симлинк для публичных файлов прямо на хосте (важно для Nginx)
cd app/public && ln -sfn ../storage/app/public ./storage && cd ../..

# Очищаем и кэшируем конфиги
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize
```

---

## 4. Конфиг Caddy на хосте

Добавьте в основной Caddyfile на хосте (`/etc/caddy/Caddyfile`):

```caddyfile
dekoservice.alxple.com {
    reverse_proxy 127.0.0.1:18080
    encode gzip zstd

    header {
        Strict-Transport-Security "max-age=31536000; includeSubDomains"
        X-Content-Type-Options "nosniff"
        X-Frame-Options "SAMEORIGIN"
        Referrer-Policy "strict-origin-when-cross-origin"
    }
}
```

Применить:

```bash
sudo caddy validate --config /etc/caddy/Caddyfile
sudo systemctl reload caddy
```

---

## 5. Проверка после запуска

```bash
curl -I http://127.0.0.1:18080
curl -I https://dekoservice.alxple.com
```

Должно отвечать `200 OK` или `302 Found`.

---

## 6. Логи и диагностика

```bash
cd /opt/stacks/dekoservice
docker compose logs --tail=100 -f app
docker compose logs --tail=100 -f web
```

Логи Laravel (хранятся на хосте благодаря volume):
```bash
tail -f app/storage/logs/laravel.log
```

---

## 7. Обновление приложения (Деплой новых фич)

При любом изменении кода (PHP, JS, CSS) нужно обновить репозиторий, пересобрать образ и перезапустить контейнеры:

```bash
cd /opt/stacks/dekoservice
git pull

# Пересобираем образ с новым кодом
docker compose build app

# Перезапускаем контейнеры (Docker сам заменит только те, чей образ изменился)
docker compose up -d

# Накатываем новые миграции БД (если есть)
docker compose exec app php artisan migrate --force

# Починить уже загруженные битые изображения
docker compose exec app php artisan gallery:optimize --sync

# Сбрасываем кэш
docker compose exec app php artisan optimize:clear
docker compose exec app php artisan optimize

# Перезапускаем воркеры очередей, чтобы они подхватили новый код
docker compose exec app php artisan queue:restart
```
