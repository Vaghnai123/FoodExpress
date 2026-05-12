FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip nginx libzip-dev

# Install Node.js & NPM (NAYI LINE)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy project files
COPY . .

# Install dependencies
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# Install Node modules and Build Frontend Assets (NAYI LINE)
RUN npm install
RUN npm run build

# Copy nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# Permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

EXPOSE 80

# Start command - Permissions fix ke saath
CMD php artisan optimize:clear && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache && \
    php artisan migrate --force && \
    nginx && php-fpm
