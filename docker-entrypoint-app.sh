#!/bin/sh
set -e

echo "==== container start: $(date) ===="

# If vendor missing (volume override), try install
if [ ! -d "./vendor" ]; then
  echo "vendor/ not found — running composer install"
  composer install --no-interaction || echo "composer install failed (ignored)"
fi

# Ensure APP_KEY exists if .env present
if [ -f .env ] && ! grep -q '^APP_KEY=' .env; then
  echo "Generating APP_KEY"
  php artisan key:generate --force || echo "key generate failed"
fi

# fix permissions (best effort)
chown -R www-data:www-data storage bootstrap/cache || true
chmod -R 0775 storage bootstrap/cache || true

echo "Starting: $*"
exec "$@"
#test
