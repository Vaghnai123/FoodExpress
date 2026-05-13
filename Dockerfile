FROM php:8.4-fpm

# 1. Install system dependencies AUR Node.js 
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libxml2-dev zip unzip nginx libzip-dev && \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

# 2. Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory
WORKDIR /var/www

# 5. Copy project files
COPY . .

# 6. Install PHP dependencies
ENV COMPOSER_MEMORY_LIMIT=-1
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs --no-scripts

# 7. Install Node modules & Build Frontend Assets (YE VITE KA ERROR SOLVE KAREGA)
RUN npm install
RUN npm run build

# 8. Copy nginx configuration
COPY nginx.conf /etc/nginx/sites-available/default

# 9. Initial Permissions
RUN mkdir -p /var/www/public/uploads
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads

EXPOSE 80

# 10. Start command (Permissions fix + DB Migrate + Start Server)
CMD php artisan optimize:clear && \
    chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache /var/www/public/uploads && \
    php artisan migrate --force && \
    nginx && php-fpm

