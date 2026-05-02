# Setup Log — Dekoservice Kunz

Дата: 2026-05-01
OS: Fedora 44 (Linux)

## Порядок установки (подготовка к разработке)

### 1. Composer (глобально)

Установлен через официальный installer с getcomposer.org.  
**Не использовать** `dnf install composer` — при запросе "Install package?" отвечать N и ставить вручную:

```bash
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --quiet
sudo mv composer.phar /usr/local/bin/composer
rm composer-setup.php
composer --version
```

Результат: Composer 2.9.7

---

### 2. Проверка окружения

```bash
php --version   # PHP 8.5.5 (Fedora build) ✓
node --version  # v22.22.0 ✓
npm --version   # 10.9.4 ✓
psql --version  # не найден → установлен в следующем шаге
```

---

### 3. PostgreSQL 18.3

Установлен через dnf (Fedora 44):

```bash
sudo dnf install -y postgresql postgresql-server
sudo postgresql-setup --initdb
sudo systemctl enable --now postgresql
```

Результат: psql (PostgreSQL) 18.3, сервис включён и запущен.

**Важно:** после установки нужно сразу исправить аутентификацию — по умолчанию стоит `ident`, что блокирует подключение по паролю.  
Исправить в `/var/lib/pgsql/data/pg_hba.conf`:

```bash
# было:
host    all    all    127.0.0.1/32    ident
# стало:
sudo sed -i 's/host    all             all             127.0.0.1\/32            ident/host    all             all             127.0.0.1\/32            md5/' /var/lib/pgsql/data/pg_hba.conf
sudo systemctl reload postgresql
```

Без этого `php artisan migrate` падает с: `FATAL: Ident authentication failed for user`.

---

### 4. PHP расширения (все нужные сразу)

По умолчанию в Fedora не установлены — устанавливать все за один раз, иначе Filament/Laravel будут падать по одному:

```bash
sudo dnf install -y php-pgsql php-pdo php-intl php-zip php-bcmath php-gd
php -m | grep -E "^(intl|zip|pdo_pgsql|mbstring|xml|curl|bcmath|gd|fileinfo|tokenizer|ctype|dom)$"
```

Ожидаемый результат: все 11 расширений выведены без ошибок.

Что за что отвечает:
- `php-pgsql` — подключение к PostgreSQL (`pdo_pgsql`)
- `php-intl` — требуется Filament (интернационализация)
- `php-zip` — требуется Filament (архивация)
- `php-bcmath` — точная арифметика (Laravel, Filament)
- `php-gd` — работа с изображениями (галерея)

---

### 5. Laravel Installer

Установлен глобально через Composer:

```bash
composer global require laravel/installer
export PATH="$HOME/.config/composer/vendor/bin:$PATH"
laravel --version
```

Результат: Laravel Installer 5.26.1

> Добавить PATH постоянно:
> ```bash
> echo 'export PATH="$HOME/.config/composer/vendor/bin:$PATH"' >> ~/.bashrc
> ```

**Известный баг на PHP 8.5:** `laravel new` падает с `Fatal error: Call to undefined function posix_kill()` в конце (после "Application installed"). Проект при этом создаётся, но лучше использовать `composer create-project` — он работает без ошибок:

```bash
# Использовать вместо laravel new:
composer create-project laravel/laravel app --prefer-dist
```

---

### 6. База данных для проекта

Создан пользователь и база данных PostgreSQL:

```bash
sudo -u postgres psql -c "CREATE USER dekoservice WITH PASSWORD 'dekoservice_dev' CREATEDB;"
sudo -u postgres psql -c "CREATE DATABASE dekoservice OWNER dekoservice;"
```

Параметры подключения (dev):
- Host: `127.0.0.1`
- Port: `5432`
- Database: `dekoservice`
- User: `dekoservice`
- Password: `dekoservice_dev`

---

### 7. Создание Laravel проекта

Проект создан через `composer create-project` в `/mnt/data/WebDev/Dekoservice/app/`:

```bash
cd /mnt/data/WebDev/Dekoservice
composer create-project laravel/laravel app --prefer-dist
```

По умолчанию `.env` содержит `DB_CONNECTION=sqlite` — нужно переключить на pgsql:

```bash
sed -i 's/DB_CONNECTION=sqlite/DB_CONNECTION=pgsql/' .env
sed -i 's/# DB_HOST=127.0.0.1/DB_HOST=127.0.0.1/' .env
sed -i 's/# DB_PORT=3306/DB_PORT=5432/' .env
sed -i 's/# DB_DATABASE=laravel/DB_DATABASE=dekoservice/' .env
sed -i 's/# DB_USERNAME=root/DB_USERNAME=dekoservice/' .env
sed -i 's/# DB_PASSWORD=/DB_PASSWORD=dekoservice_dev/' .env
```

---

### 8. Миграции

```bash
cd /mnt/data/WebDev/Dekoservice/app
php artisan migrate:fresh
```

Результат: 3 стандартные таблицы (users, cache, jobs) на PostgreSQL.

---

### 9. Laravel Breeze (Inertia + Vue 3)

Устанавливать **с `--dev`** — нужен только для скаффолдинга, в продакшне не используется:

```bash
composer require laravel/breeze --dev
php artisan breeze:install vue --pest
```

---

## Что делать дальше

1. `npm install && npm run dev`
2. `composer require filament/filament:"^4.0" -W`  ← v3 не совместим с Laravel 13, нужен v4
3. `php artisan storage:link`
4. Начать строить компоненты по порядку из `design.md` раздел I

---

## Настройка APP_URL

`APP_URL` в `.env` должен **точно совпадать** с адресом, по которому открывается сайт в браузере.

### Локальная разработка

```env
APP_URL=http://127.0.0.1:8000
```

> **Важно:** `localhost` и `127.0.0.1` — разные origins с точки зрения браузера. Если `APP_URL=http://localhost:8000`, а страница открыта по адресу `http://127.0.0.1:8000`, браузер заблокирует запросы к хранилищу файлов из-за CORS-политики. Это ломает превью загруженных изображений в FilePond (Filament FileUpload).

### Продакшн

```env
APP_URL=https://your-domain.com
```

`.env` добавлен в `.gitignore` и **не попадает в репозиторий**. На сервере нужно создать `.env` вручную или через деплой-скрипт и установить там `APP_URL` на реальный домен.

После изменения `.env` обязательно очистить кеш конфига:

```bash
php artisan config:clear
# или на продакшне:
php artisan config:cache
```

---

## Известные проблемы и решения

| Проблема | Причина | Решение |
|---|---|---|
| `composer: command not found` с предложением dnf install | Системный пакет устарел | Ставить через official phar |
| `laravel new` → `Fatal error: posix_kill()` | Баг laravel/prompts на PHP 8.5 | Использовать `composer create-project` |
| `could not find driver` при migrate | Нет расширения pdo_pgsql | `sudo dnf install -y php-pgsql` |
| `Ident authentication failed` при migrate | pg_hba.conf использует ident | Заменить ident на md5, `reload postgresql` |
| `breeze:install` → `no commands defined` | `composer require --dev` не регистрирует artisan-команды в некоторых окружениях | Запустить `php artisan` из корня проекта, убедиться что cwd правильный |
| FilePond показывает бесконечный спиннер при редактировании | CORS: `APP_URL` не совпадает с реальным адресом браузера | Убедиться что `APP_URL` точно совпадает с адресом в браузере (см. раздел «Настройка APP_URL») |

---

## Следующие шаги

1. Создать Laravel-проект:
   ```bash
   cd /mnt/data/WebDev
   laravel new dekoservice --git --stack=inertia --frontend=vue --database=pgsql --auth
   ```
2. Настроить `.env` с параметрами БД выше.
3. `php artisan migrate`
4. `composer require filament/filament:"^3.0" -W`
5. `php artisan storage:link`
6. `npm install && npm run dev`
