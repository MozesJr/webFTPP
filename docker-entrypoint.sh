#!/bin/sh
set -e

cd /var/www/html

# --- Ensure runtime dirs & permissions ---
export COMPOSER_ALLOW_SUPERUSER=1
mkdir -p storage/logs storage/framework/{cache,sessions,views} bootstrap/cache /var/log/apache2
chown -R www-data:www-data storage bootstrap/cache public /var/log/apache2 || true
chmod -R ug+rwX storage bootstrap/cache || true

# --- Env & dependencies (dev only) ---
[ -f .env ] || cp .env.example .env || true
[ -f vendor/autoload.php ] || composer install --no-interaction --prefer-dist || true
[ -d node_modules ] && [ -n "$(ls -A node_modules 2>/dev/null)" ] || npm install

# --- Laravel artisan (no cache in dev) ---
php artisan route:clear  || true
php artisan config:clear || true
php artisan view:clear   || true
php artisan migrate --force || true

# --- Start Vite HMR as www-data (background) ---
su -s /bin/sh -c 'npm run dev -- --host 0.0.0.0 --port ${VITE_PORT:-5173}' www-data &

# --- Apache env & runtime dir ---
. /etc/apache2/envvars
mkdir -p ${APACHE_RUN_DIR} /var/lock/apache2
chown -R www-data:www-data ${APACHE_RUN_DIR} /var/lock/apache2

# --- Foreground apache ---
exec /usr/sbin/apache2 -DFOREGROUND
