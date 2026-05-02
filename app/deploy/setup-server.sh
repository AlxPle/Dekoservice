#!/bin/bash
# Server setup script for Hetzner CX22 Ubuntu 24.04
# Run as root: bash setup-server.sh

set -e

DOMAIN="dekoservice-kunz.de"
APP_DIR="/var/www/dekoservice"
DB_NAME="dekoservice"
DB_USER="dekoservice"
DB_PASS="$(openssl rand -base64 24)"
PHP_VER="8.4"

echo "=== Helena Kunz Dekoservice Server Setup ==="
echo "Domain: $DOMAIN"

# --- System update ---
apt-get update && apt-get upgrade -y

# --- Basic tools ---
apt-get install -y curl wget git unzip supervisor fail2ban ufw \
  jpegoptim optipng pngquant gifsicle

# --- PHP 8.4 ---
add-apt-repository ppa:ondrej/php -y
apt-get update
apt-get install -y php${PHP_VER}-fpm php${PHP_VER}-cli php${PHP_VER}-mbstring \
  php${PHP_VER}-xml php${PHP_VER}-bcmath php${PHP_VER}-curl php${PHP_VER}-pgsql \
  php${PHP_VER}-zip php${PHP_VER}-intl php${PHP_VER}-opcache php${PHP_VER}-redis

# Upload limits (match Filament form limits with a safety margin)
cat > /etc/php/${PHP_VER}/fpm/conf.d/99-dekoservice-upload.ini <<'PHPINI'
upload_max_filesize = 10M
post_max_size = 12M
memory_limit = 256M
PHPINI

cat > /etc/php/${PHP_VER}/cli/conf.d/99-dekoservice-upload.ini <<'PHPINI'
upload_max_filesize = 10M
post_max_size = 12M
memory_limit = 256M
PHPINI

# --- Composer ---
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# --- Node.js 22 (LTS) ---
curl -fsSL https://deb.nodesource.com/setup_22.x | bash -
apt-get install -y nodejs

# --- PostgreSQL 16 ---
apt-get install -y postgresql postgresql-contrib
systemctl enable --now postgresql

# Create DB and user
sudo -u postgres psql <<SQL
CREATE DATABASE ${DB_NAME};
CREATE USER ${DB_USER} WITH ENCRYPTED PASSWORD '${DB_PASS}';
GRANT ALL PRIVILEGES ON DATABASE ${DB_NAME} TO ${DB_USER};
ALTER DATABASE ${DB_NAME} OWNER TO ${DB_USER};
SQL

# --- Nginx ---
apt-get install -y nginx
systemctl enable --now nginx

# --- App directory structure ---
mkdir -p ${APP_DIR}/{releases,shared/storage/app/public,shared/storage/framework/{cache,sessions,views},shared/storage/logs}
chown -R www-data:www-data ${APP_DIR}

# --- Nginx config ---
cat > /etc/nginx/sites-available/${DOMAIN} <<NGINX
server {
    listen 80;
    server_name ${DOMAIN} www.${DOMAIN};
    return 301 https://\$host\$request_uri;
}

server {
    listen 443 ssl http2;
    server_name ${DOMAIN} www.${DOMAIN};

    root ${APP_DIR}/current/public;
    index index.php;
    client_max_body_size 12m;

    ssl_certificate /etc/letsencrypt/live/${DOMAIN}/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/${DOMAIN}/privkey.pem;
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-ECDSA-AES128-GCM-SHA256:ECDHE-RSA-AES128-GCM-SHA256:ECDHE-ECDSA-AES256-GCM-SHA384:ECDHE-RSA-AES256-GCM-SHA384;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";
    add_header Referrer-Policy "strict-origin-when-cross-origin";

    location / {
        try_files \$uri \$uri/ /index.php?\$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php${PHP_VER}-fpm.sock;
        fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~* \.(js|css|png|jpg|jpeg|gif|ico|svg|woff2?)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
NGINX

ln -sf /etc/nginx/sites-available/${DOMAIN} /etc/nginx/sites-enabled/
rm -f /etc/nginx/sites-enabled/default
nginx -t

# --- SSL with Certbot ---
apt-get install -y certbot python3-certbot-nginx
certbot --nginx -d ${DOMAIN} -d www.${DOMAIN} --non-interactive --agree-tos -m info@${DOMAIN}

# --- Supervisor for Queue Worker ---
cat > /etc/supervisor/conf.d/dekoservice-queue.conf <<SUP
[program:dekoservice-queue]
command=php ${APP_DIR}/current/artisan queue:work database --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=1
redirect_stderr=true
stdout_logfile=${APP_DIR}/shared/storage/logs/queue.log
stopwaitsecs=3600
SUP

# --- Scheduler in cron ---
echo "* * * * * www-data php ${APP_DIR}/current/artisan schedule:run >> /dev/null 2>&1" > /etc/cron.d/dekoservice

# --- UFW Firewall ---
ufw --force reset
ufw default deny incoming
ufw default allow outgoing
ufw allow ssh
ufw allow 80/tcp
ufw allow 443/tcp
ufw --force enable

# --- Fail2ban ---
systemctl enable --now fail2ban

supervisorctl reread
supervisorctl update

echo ""
echo "=== Setup complete! ==="
echo ""
echo "Database password (save this!): ${DB_PASS}"
echo ""
echo "Now create ${APP_DIR}/shared/.env with:"
echo "  APP_URL=https://${DOMAIN}"
echo "  DB_CONNECTION=pgsql"
echo "  DB_DATABASE=${DB_NAME}"
echo "  DB_USERNAME=${DB_USER}"
echo "  DB_PASSWORD=${DB_PASS}"
echo "  MAIL_MAILER=smtp"
echo "  MAIL_HOST=smtp.gmail.com"
echo "  MAIL_PORT=587"
echo "  MAIL_ENCRYPTION=tls"
echo "  MAIL_USERNAME=pletnev1990.a.a@gmail.com"
echo "  MAIL_PASSWORD=xxxx xxxx xxxx xxxx  # App Password из myaccount.google.com/apppasswords"
echo "  MAIL_FROM_ADDRESS=pletnev1990.a.a@gmail.com"
echo "  MAIL_ADMIN_EMAIL=pletnev1990.a.a@gmail.com"
echo "  QUEUE_CONNECTION=database"
echo ""
echo "Then run: vendor/bin/envoy run deploy"
