# =========================
# 1) Build Vite assets
# =========================
FROM node:18 AS frontend

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build


# =========================
# 2) PHP + Apache
# =========================
FROM php:8.3-apache AS backend

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd dom xml

# Enable rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy apache config from project into image (safer than heredoc)
COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Fix git safe.directory ownership issues
RUN git config --global --add safe.directory /var/www/html || true

# Copy composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Copy built Vite assets
COPY --from=frontend /app/public/build ./public/build

# Install PHP dependencies WITHOUT running artisan or scripts
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --no-scripts

# Generate optimized autoload
RUN composer dump-autoload --optimize --no-interaction || true

# Storage & cache permissions
RUN chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]
