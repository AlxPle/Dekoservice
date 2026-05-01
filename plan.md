# Plan: Редизайн Dekoservice Kunz

## TL;DR
Переделать сайт-визитку dekoservice-kunz.de с устаревшего Strato CMS на современный стек Laravel 13 + Vue 3 + Inertia.js + Filament v3 + PostgreSQL. Хозяйка Helena получает удобную admin-панель для управления галереей и контентом. Всё open-source, хостинг на Hetzner VPS (~€4/мес).

---

## Стек

| Слой | Инструмент |
|---|---|
| Backend | Laravel 13 |
| Frontend | Vue 3 + Inertia.js |
| Admin CMS | Filament v3 |
| БД | PostgreSQL |
| Стили | Tailwind CSS v4 |
| Аутентификация | Laravel Breeze |
| Сборщик | Vite |
| Хранилище фото | Laravel Storage (local / symlink) |
| Email | Laravel Mail + SMTP (Strato) |
| Хостинг | Hetzner VPS CX22 (~€4/мес) |

---

## Структура сайта

Новая структура (SPA через Inertia):
- `/` — Главная (Hero + Услуги + Галерея-превью + О нас + Контакт)
- `/galerie` — Полная галерея с лайтбоксом
- `/ueber-uns` — О Хелене
- `/kontakt` — Форма + карта
- `/impressum` — Юридическая информация

Публичная часть — одностраничная с якорями (#leistungen, #galerie, #kontakt) для плавной навигации.

---

## Фазы реализации

### Фаза 1: Инициализация проекта
1. `laravel new dekoservice` — выбрать Inertia + Vue 3 + PostgreSQL + Breeze
2. Настроить `.env` — подключить PostgreSQL
3. Установить Filament v3: `composer require filament/filament`
4. Установить Tailwind CSS v4 (уже включён через Vite/Breeze)
5. Настроить Laravel Storage: `php artisan storage:link`

### Фаза 2: БД и модели
*Зависит от Фазы 1*

6. Миграции:
   - `pages` (id, slug, title, content JSON, meta_title, meta_description, updated_at)
   - `gallery_images` (id, filename, alt_text, category ENUM[wedding,birthday,corporate,other], sort_order, is_active, created_at)
   - `contact_requests` (id, name, email, phone, message, event_type, event_date, created_at)
7. Модели: `Page`, `GalleryImage`, `ContactRequest`
8. Seeders: начальный контент страниц из оригинального сайта

### Фаза 3: Filament Admin Panel
*Зависит от Фазы 2*

9. `FilamentUser` — авторизация только для Helena (один пользователь)
10. `GalleryImageResource` — таблица с загрузкой фото, drag & drop сортировка, категории
11. `PageResource` — редактирование текстов страниц через RichEditor
12. `ContactRequestResource` — просмотр входящих заявок, отметка "обработано"

### Фаза 4: Backend — API и логика
*Зависит от Фазы 2, параллельно с Фазой 3*

13. `PageController` — отдаёт данные страниц в Inertia props
14. `GalleryController` — список с фильтрацией по категории
15. `ContactController` — валидация формы (FormRequest), сохранение в БД, отправка письма
16. `ContactMail` (Mailable) — красивое письмо Helena на SMTP Strato
17. Routes: web.php с именованными маршрутами

### Фаза 5: Vue 3 Frontend — компоненты
*Зависит от Фазы 4*

18. Layouts: `AppLayout.vue` (nav + footer), `AdminLayout.vue`
19. Pages:
    - `Home.vue` — Hero + LeistungenSection + GaleriePreview + UeberUns + KontaktSection
    - `Galerie.vue` — masonry grid + lightbox
    - `Kontakt.vue` — форма + карта (Leaflet.js)
    - `Impressum.vue`
20. Компоненты:
    - `HeroSection.vue` — полноэкранное фото, заголовок, CTA кнопка
    - `LeistungenSection.vue` — 4 карточки услуг (Hochzeit / Geburtstag / Firmenevent / Leihservice)
    - `GalleryGrid.vue` — masonry, lazy loading, фильтр по категории
    - `LightboxModal.vue` — просмотр фото на весь экран
    - `ContactForm.vue` — VeeValidate
    - `WhatsAppButton.vue` — плавающая кнопка (+49 170 58 65 783)
    - `TestimonialsSection.vue` — отзывы (статичные на старте)

### Фаза 6: SEO и производительность
*Параллельно с Фазой 5*

21. `<Head>` через Inertia — уникальные title/description на каждой странице
22. Schema.org `LocalBusiness` JSON-LD в `app.blade.php`
23. Sitemap: `spatie/laravel-sitemap`
24. Оптимизация изображений: `spatie/laravel-image-optimizer` при загрузке в Filament
25. Lazy loading изображений через `loading="lazy"` + Intersection Observer

### Фаза 7: Деплой на Hetzner
*Зависит от всех предыдущих фаз*

26. Создать VPS CX22 на Hetzner (Ubuntu 24.04, Frankfurt)
27. Установить: PHP 8.4, PostgreSQL 16, Nginx, Supervisor, Certbot
28. `laravel/envoy` или GitHub Actions для автодеплоя из `main` ветки
29. SSL через Let's Encrypt (Certbot)
30. Настроить SMTP в `.env` — данные от Strato-почты Helena

---

## План деплоя без Docker (рекомендуемый)

### Цель
Получить стабильный zero-downtime деплой Laravel-приложения на VPS без контейнеров, с откатами и базовым мониторингом.

### 1) Подготовка сервера
1. Создать пользователя `deploy`, отключить root-login по паролю, включить SSH-ключи.
2. Настроить firewall (`ufw`): открыть `22`, `80`, `443`.
3. Установить пакеты:
    - `nginx`
    - `php8.4-fpm` + расширения (`mbstring`, `xml`, `curl`, `zip`, `pgsql`, `bcmath`, `intl`, `gd`, `redis` при необходимости)
    - `composer`
    - `postgresql`
    - `supervisor`
    - `certbot` + `python3-certbot-nginx`
    - `nodejs` + `npm` (если билд фронта на сервере)

### 2) Структура релизов на сервере
Принять структуру Capistrano-style:
- `/var/www/dekoservice/releases/<timestamp>`
- `/var/www/dekoservice/shared/.env`
- `/var/www/dekoservice/shared/storage`
- `/var/www/dekoservice/current` (symlink на актуальный релиз)

Это дает атомарное переключение релизов и быстрый rollback.

### 3) Первый релиз
1. Клонировать репозиторий в новый каталог релиза.
2. Подключить shared-файлы:
    - симлинк `.env`
    - симлинк `storage`
3. Выполнить:
    - `composer install --no-dev --prefer-dist --optimize-autoloader`
    - `php artisan key:generate --force` (только при первом запуске)
    - `php artisan migrate --force`
    - `php artisan storage:link`
    - `php artisan optimize` (кеш конфигов/роутов/видов)
    - `npm ci && npm run build` (или собирать в CI и выкладывать артефакт)
4. Переключить symlink `current` на новый релиз.
5. Перезапустить `php8.4-fpm` и сделать `php artisan queue:restart`.

### 4) Nginx и PHP-FPM
1. `root` указывать на `/var/www/dekoservice/current/public`.
2. Добавить `try_files $uri $uri/ /index.php?$query_string;`.
3. Ограничить доступ к скрытым файлам (`.env`, `.git`).
4. Включить gzip/brotli и базовые security headers.
5. Выставить корректные `client_max_body_size` под загрузку фото.

### 5) Очереди и планировщик
1. Supervisor program для `php artisan queue:work --sleep=3 --tries=3 --max-time=3600`.
2. Cron (раз в минуту):
    - `* * * * * cd /var/www/dekoservice/current && php artisan schedule:run >> /dev/null 2>&1`

### 6) SSL и домен
1. Прописать A/AAAA записи домена на IP VPS.
2. Выпустить сертификат: `certbot --nginx -d dekoservice-kunz.de -d www.dekoservice-kunz.de`.
3. Проверить автообновление сертификата (`systemctl status certbot.timer`).

### 7) CI/CD без Docker (GitHub Actions)
Pipeline:
1. На push в `main`: запустить тесты (`php artisan test`).
2. Собирать production assets (`npm run build`).
3. По SSH выполнить deploy-скрипт на сервере: новый релиз, install, migrate, cache, symlink switch.
4. Хранить 5-10 последних релизов, старые удалять.

### 8) Откат
1. Сменить symlink `current` на предыдущий релиз.
2. Перезапустить PHP-FPM и очередь.
3. Если была несовместимая миграция, откатывать только заранее подготовленным down-скриптом.

---

## Минимальный продакшн-чеклист Laravel

### Конфигурация
1. `APP_ENV=production`
2. `APP_DEBUG=false`
3. Сильные `APP_KEY`, пароли БД и SMTP
4. `LOG_CHANNEL=stack`, настроить ротацию логов

### Производительность
1. `composer install --no-dev --optimize-autoloader`
2. `php artisan config:cache`
3. `php artisan route:cache`
4. `php artisan view:cache`
5. `php artisan event:cache` (если используете event discovery)

### База и миграции
1. Бэкап БД перед деплоем
2. `php artisan migrate --force`
3. Не использовать destructive-миграции без плана отката

### Фоновые процессы
1. Supervisor для `queue:work`
2. `schedule:run` через cron каждую минуту
3. `php artisan queue:restart` после каждого релиза

### Безопасность
1. Только HTTPS, HTTP -> HTTPS redirect
2. Закрытые порты, рабочий firewall
3. Запрет доступа к `.env` и служебным каталогам
4. Регулярные security updates ОС и PHP-пакетов

### Наблюдаемость
1. Проверка `storage/logs/laravel.log`
2. Ошибки 500/502 в Nginx/PHP-FPM логах
3. Аптайм-мониторинг (`/health` endpoint или внешний ping)

### Проверка после деплоя
1. Открывается главная, галерея, контакт
2. Контактная форма сохраняет заявку и отправляет email
3. Админ-панель Filament доступна только авторизованным
4. Очередь обрабатывает jobs, scheduler запускается

---

## Ключевые файлы проекта

```
dekoservice/
├── app/
│   ├── Filament/Resources/
│   │   ├── GalleryImageResource.php
│   │   ├── PageResource.php
│   │   └── ContactRequestResource.php
│   ├── Http/Controllers/
│   │   ├── PageController.php
│   │   ├── GalleryController.php
│   │   └── ContactController.php
│   ├── Mail/ContactMail.php
│   └── Models/ (Page, GalleryImage, ContactRequest)
├── database/migrations/
├── resources/
│   ├── js/
│   │   ├── Pages/ (Home.vue, Galerie.vue, Kontakt.vue, Impressum.vue)
│   │   └── Components/ (HeroSection, GalleryGrid, ContactForm, ...)
│   └── views/app.blade.php
├── routes/web.php
└── storage/app/public/gallery/
```

---

## Улучшения относительно оригинала

| Было | Стало |
|---|---|
| Strato CMS iframe-виджеты | Чистый Laravel + Vue SPA |
| Нет мобильной версии | Полностью responsive (Tailwind) |
| Слабое SEO | Schema.org, meta tags, sitemap |
| Нет CTA | Hero с кнопкой "Kostenloses Beratungsgespräch" |
| Форма через iframe | Реальная форма → email → БД |
| Галерея без лайтбокса | Masonry + lightbox + фильтры |
| Нет отзывов | Секция Testimonials |
| Нет WhatsApp | Плавающая кнопка WhatsApp |
| © 2020, устаревший дизайн | Современный дизайн 2026 |

---

## Верификация

1. `php artisan test` — все базовые тесты зелёные
2. Filament: войти под Helena, загрузить фото, проверить отображение на сайте
3. Контактная форма: отправить тестовую заявку → письмо приходит на email
4. Lighthouse score: Performance > 90, SEO > 95, Accessibility > 90
5. Мобильная версия: проверить на 375px (iPhone SE)
6. Schema.org: проверить через Google Rich Results Test

---

## Решения

- **Стек**: Laravel 13 + Vue 3 + Inertia.js + Filament v3 + PostgreSQL + Tailwind v4
- **CMS**: Filament v3 (open-source, MIT)
- **Email**: Laravel Mail + SMTP Strato (без сторонних сервисов)
- **Фото**: Laravel Storage local (без Cloudinary)
- **Хостинг**: Hetzner VPS Frankfurt (GDPR-compliant)
- **Язык**: только немецкий (DE)
- **Scope исключён**: бронирование/заказы, каталог с ценами, многоязычность
