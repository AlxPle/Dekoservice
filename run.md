# Терминал 1 — Laravel
cd app && npm run serve:upload

# Терминал 2 — Vite (для hot reload)
cd app && npm run dev

# Или одной командой (Laravel + Vite)
cd app && npm run dev:full

---

# Публичный показ через ngrok

# Терминал 1 — Laravel (БЕЗ npm run dev — используется prod-сборка)
cd app && php artisan serve

# Терминал 2 — ngrok
ngrok http 8000