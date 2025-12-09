# Dockerfile (PHP / Laravel) — PHP 8.3 + gd + common extensions
FROM php:8.3-cli

ARG DEBIAN_FRONTEND=noninteractive

# System deps and libraries for gd
RUN apt-get update && apt-get install -y \
    git curl unzip zip libzip-dev libpng-dev libjpeg-dev libfreetype6-dev \
    libonig-dev libxml2-dev procps build-essential \
  && rm -rf /var/lib/apt/lists/*

# Configure and install PHP extensions
# gd needs configure flags for freetype and jpeg
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j$(nproc) \
     pdo_mysql mbstring zip exif bcmath pcntl sockets gd opcache

# Optional: install sodium if needed via PECL (if not built-in)
# RUN pecl install libsodium && docker-php-ext-enable sodium

# Install Composer (stable)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

# Copy composer files first to leverage cache
COPY composer.json composer.lock* /var/www/html/

# Run composer install (non-dev). If vendor is mounted from host, this may be skipped at runtime.
RUN composer install --no-dev --no-interaction --prefer-dist || true

# Copy app
COPY . /var/www/html

# Ensure directories and permissions
RUN mkdir -p storage/framework storage/logs bootstrap/cache \
  && chown -R www-data:www-data storage bootstrap/cache \
  && chmod -R 0775 storage bootstrap/cache

EXPOSE 8000

# Small entrypoint that prints errors and installs vendor if missing
COPY docker-entrypoint-app.sh /usr/local/bin/docker-entrypoint-app.sh
RUN chmod +x /usr/local/bin/docker-entrypoint-app.sh

ENTRYPOINT ["/usr/local/bin/docker-entrypoint-app.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
