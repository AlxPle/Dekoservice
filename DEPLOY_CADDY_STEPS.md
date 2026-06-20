# Production Deploy: Dockge + Existing Caddy

Этот документ теперь описывает один каноничный вариант запуска для вашего сервера:

1. Caddy уже установлен на хосте и является единой точкой входа (80/443).
2. Dockge управляет только стеком приложения.
3. В проектном стеке не публикуются порты 80/443.

Старые варианты с отдельным Caddy внутри проекта считаются устаревшими и удалены.

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
2. `AAAA` указывает на конкретный IPv6 адрес сервера (не на префикс `/64`).

---

## 2. Подготовка проекта для Dockge

Разместить репозиторий на сервере, например:

```bash
sudo mkdir -p /opt/stacks/dekoservice
sudo chown -R $USER:$USER /opt/stacks/dekoservice
cd /opt/stacks/dekoservice
git clone <repo-url> .
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

---

## 3. Запуск стека через Dockge

В Dockge используйте `docker-compose.yml` из корня этого репозитория.

Важно:

1. Внешний порт публикует только сервис `web` и только в localhost (`127.0.0.1:18080`).
2. `app`, `queue`, `scheduler`, `db`, `redis` наружу не публикуются.

После `Deploy` выполнить первичную инициализацию:

```bash
cd /opt/stacks/dekoservice
docker compose exec app php artisan key:generate --force
docker compose exec app php artisan migrate --force
docker compose exec app php artisan storage:link
docker compose exec app php artisan config:cache
docker compose exec app php artisan route:cache
docker compose exec app php artisan view:cache
```

---

## 4. Конфиг Caddy на хосте

Добавьте в основной Caddyfile на хосте:

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

Должно быть:

1. Локальный порт отвечает `200`/`302`.
2. По домену есть валидный TLS и рабочая страница.

---

## 6. Логи и диагностика

```bash
cd /opt/stacks/dekoservice
docker compose logs -f app
docker compose logs -f web
docker compose logs -f queue
docker compose logs -f scheduler
docker compose logs -f db
```

Логи Laravel:

```bash
tail -f app/storage/logs/laravel.log
```

Логи Caddy:

```bash
sudo journalctl -u caddy -f
```

---

## 7. Обновление приложения

```bash
cd /opt/stacks/dekoservice
git pull
docker compose build app
docker compose up -d
docker compose exec app php artisan migrate --force
docker compose exec app php artisan optimize
docker compose exec app php artisan queue:restart
```

---

## 8. Что больше не используем

1. Отдельный Caddy контейнер в проектном `docker-compose.yml`.
2. Публикацию `80:80` и `443:443` из стека приложения.
3. Несколько альтернативных сценариев деплоя в этом проекте.
