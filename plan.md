# Plan: Редизайн Dekoservice Kunz

## TL;DR
Переделать сайт-визитку dekoservice-kunz.de с устаревшего Strato CMS на современный стек Laravel 13 + Vue 3 + Inertia.js + Filament v4 + PostgreSQL. Хозяйка Helena получает удобную admin-панель для управления галереей и контентом. Всё open-source, хостинг на Hetzner VPS (~€4/мес).

## Статус на 2026-05-02

Общий прогресс: ядро проекта реализовано и работает в dev, основные бизнес-фичи готовы.

### Выполнено
- Фаза 1 (инициализация): Laravel 13 + Inertia/Vue + PostgreSQL + Filament v4 + Tailwind v4, storage link настроен.
- Фаза 2 (БД и модели): таблицы `pages`, `gallery_images`, `contact_requests` созданы, модели подключены.
- Фаза 3 (Filament): `GalleryImageResource`, `PageResource`, `ContactRequestResource` работают, сортировка галереи есть.
- Фаза 4 (backend): `PageController`, `GalleryController`, `ContactController`, `ContactFormRequest`, `ContactMail` реализованы.
- Фаза 5 (frontend, базовая часть): страницы `Home`, `Galerie`, `Kontakt`, `UeberUns`, `Impressum` готовы.
- Дополнительно сверх плана: отдельные страницы услуг (`/leistungen/*`) и кастомная Inertia-страница 404.

### Частично выполнено / изменено
- Публичная часть уже не только «одностраничная с якорями»: добавлены отдельные SEO-страницы услуг.
- Контактная форма сделана через Inertia form, а не через VeeValidate (функционально рабочая).
- Sitemap сейчас реализован динамическим роутом `/sitemap.xml`; пакет Spatie установлен, но генерация через него пока не используется.

### Осталось сделать
- Фаза 6: формально закрыть SEO/perf чеклист (Lighthouse-замеры, финальная оптимизация изображений в pipeline).
- Фаза 7: завершить production rollout и автоматизировать CI/CD деплой до состояния «под ключ».
- Добавить/расширить автотесты для новых страниц услуг и 404 fallback.

---

## Стек

| Слой | Инструмент |
|---|---|
| Backend | Laravel 13 |
| Frontend | Vue 3 + Inertia.js |
| Admin CMS | Filament v4 |
| БД | PostgreSQL |
| Стили | Tailwind CSS v4 |
| Аутентификация | Laravel Breeze |
| Сборщик | Vite |
| Хранилище фото | Laravel Storage (local / symlink) |
| Email | Laravel Mail + SMTP (Strato) |
| Хостинг | Hetzner VPS CX22 (~€4/мес) |

---

## Структура сайта

Актуальная структура (Inertia + Vue):
- `/` — Главная (Hero + Услуги + Галерея-превью + О нас + Контакт)
- `/galerie` — Полная галерея с лайтбоксом
- `/ueber-uns` — О Хелене
- `/kontakt` — Форма + карта
- `/impressum` — Юридическая информация
- `/leistungen/hochzeiten` — Отдельная страница услуги
- `/leistungen/geburtstage` — Отдельная страница услуги
- `/leistungen/firmenevents` — Отдельная страница услуги

Дополнительно:
- `Route::fallback` с кастомной страницей 404.

Публичная часть совмещает якоря на главной и отдельные контентные страницы для SEO и удобной навигации.

---

## Фазы реализации

### Фаза 1: Инициализация проекта
1. `laravel new dekoservice` — выбрать Inertia + Vue 3 + PostgreSQL + Breeze
2. Настроить `.env` — подключить PostgreSQL
3. Установить Filament v4: `composer require filament/filament:"^4.0" -W`
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
27. Использовать существующий Caddy на хосте как единую ingress-точку (80/443)
28. Развернуть Laravel-стек через Dockge (`app`, `web`, `queue`, `scheduler`, `db`, `redis`)
29. Проксировать `dekoservice.alxple.com` -> `127.0.0.1:18080` в системном Caddy
30. Настроить production `.env` + post-deploy команды (`migrate`, `cache`, `queue:restart`)

---

## Каноничный план деплоя (Dockge + Caddy)

### Цель
Получить простой и воспроизводимый прод-запуск для сервера с несколькими Docker-сервисами без конфликтов по портам.

### 1) Принцип инфраструктуры
1. Caddy на хосте остаётся единым ingress (слушает только он: 80/443).
2. Dockge управляет только приложениями.
3. Каждый проект публикует только localhost-порт (например `127.0.0.1:18080`).

### 2) Стек приложения
1. `app` (php-fpm)
2. `web` (nginx)
3. `queue` (`php artisan queue:work`)
4. `scheduler` (`php artisan schedule:run` циклом)
5. `db` (PostgreSQL)
6. `redis`

### 3) Маршрутизация домена
1. В системном Caddy добавить `dekoservice.alxple.com`.
2. Проксировать на `127.0.0.1:18080`.
3. TLS выдаёт и обновляет Caddy автоматически.

### 4) Деплой-процедура
1. `git pull`
2. `docker compose build app`
3. `docker compose up -d`
4. `docker compose exec app php artisan migrate --force`
5. `docker compose exec app php artisan optimize`
6. `docker compose exec app php artisan queue:restart`

### 5) Проверка после релиза
1. `curl -I https://dekoservice.alxple.com`
2. Проверка страниц (`/`, `/galerie`, `/kontakt`, `/admin`)
3. Проверка очереди и scheduler по логам контейнеров

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

- **Стек**: Laravel 13 + Vue 3 + Inertia.js + Filament v4 + PostgreSQL + Tailwind v4
- **CMS**: Filament v4 (open-source, MIT)
- **Email**: Laravel Mail + SMTP Strato (без сторонних сервисов)
- **Фото**: Laravel Storage local (без Cloudinary)
- **Хостинг**: Hetzner VPS Frankfurt (GDPR-compliant)
- **Язык**: только немецкий (DE)
- **Scope исключён**: бронирование/заказы, каталог с ценами, многоязычность
