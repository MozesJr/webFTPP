FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    nano \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    dom \
    xml \
    fileinfo

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Fix git ownership issue
RUN git config --global --add safe.directory /var/www/html || true

# Remove problematic providers
RUN rm -f app/Providers/TelescopeServiceProvider.php
RUN sed -i '/PailServiceProvider/d' config/app.php || true
RUN sed -i '/TelescopeServiceProvider/d' config/app.php || true

# Install composer dependencies with all platform requirements ignored
RUN composer install \
    --no-dev \
    --no-scripts \
    --ignore-platform-reqs \
    --optimize-autoloader

# Generate autoload without platform check
RUN composer dump-autoload --optimize --ignore-platform-reqs || \
    composer dump-autoload --ignore-platform-reqs

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage && \
    chmod -R 755 /var/www/html/bootstrap/cache

# Apache configuration for Laravel
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory "/var/www/html/public">\n\
        AllowOverride All\n\
        Require all granted\n\
        DirectoryIndex index.php\n\
    </Directory>\n\
    ErrorLog ${APACHE_LOG_DIR}/error.log\n\
    CustomLog ${APACHE_LOG_DIR}/access.log combined\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
