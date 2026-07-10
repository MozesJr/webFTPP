#!/bin/sh
set -e
cd /var/www/html
export COMPOSER_ALLOW_SUPERUSER=1

if [ ! -f .env ]; then
  echo "ERROR: .env tidak ditemukan di /var/www/html — buat dulu sebelum start."
  exit 1
fi

grep -q '^APP_KEY=base64' .env || php artisan key:generate --force

chown -R www-data:www-data storage bootstrap/cache || true

# Jalankan migrate dulu dengan cache driver file, hindari chicken-egg
# dengan tabel `cache` yang belum ada (dipakai oleh CACHE_DRIVER=database)
CACHE_STORE=file CACHE_DRIVER=file php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"