FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx libzip-dev

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies (Yahan --no-scripts laga diya hai taaki build ke time DB na dhoondhe)
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# Copy nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Start command (Script ko ab runtime par chalayenge jab DB connect ho chuka hoga)
CMD php artisan migrate --force; php artisan db:seed --force; php artisan optimize:clear; service nginx start && php-fpm
