#!/usr/bin/env bash
set -e

cd /var/www/html

# Pastikan dependency ada (bind mount bisa menimpa layer build)
echo ">> Ensuring PHP dependencies..."
composer install --no-interaction --prefer-dist || true

echo ">> Ensuring Node dependencies..."
if [ ! -d node_modules ] || [ ! -f node_modules/.package-lock-exists ]; then
  # tandai supaya next start bisa cepat
  npm ci || npm install
  mkdir -p node_modules
  touch node_modules/.package-lock-exists || true
fi

# Laravel caches (aman untuk dev)
php artisan key:generate --force || true
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true
php artisan migrate --force || true

# Jalankan Vite dev server (HMR) di background
: "${VITE_HMR_HOST:=0.0.0.0}"
: "${VITE_HMR_PORT:=5173}"
: "${VITE_HMR_PROTOCOL:=ws}"
: "${CHOKIDAR_USEPOLLING:=true}"
: "${WATCHPACK_POLLING:=true}"

export CHOKIDAR_USEPOLLING WATCHPACK_POLLING VITE_HMR_HOST VITE_HMR_PORT VITE_HMR_PROTOCOL

echo ">> Starting Vite (HMR at ${VITE_HMR_HOST}:${VITE_HMR_PORT}, protocol=${VITE_HMR_PROTOCOL}) ..."
# --host 0.0.0.0 wajib agar bisa diakses dari luar container
npm run dev -- --host 0.0.0.0 --port "${VITE_HMR_PORT}" &

# Jalankan Apache di foreground
echo ">> Starting Apache..."
exec apache2-foreground
