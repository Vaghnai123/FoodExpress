FROM php:8.4-fpm

# Install system dependencies (yahan libzip-dev add kiya hai)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx libzip-dev

# Install PHP extensions (yahan aakhiri mein zip add kiya hai)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies (RAM limit hata di hai aur strict check band kar diya hai)
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Copy nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

CMD service nginx start && php-fpm
