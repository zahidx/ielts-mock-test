#!/bin/sh

# Make sure permissions are correct
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Run composer install if vendor doesn't exist
if [ ! -d "vendor" ]; then
    composer install --no-dev --optimize-autoloader
fi

# Clear caches and run migrations
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan migrate --force

# Start PHP-FPM in background
php-fpm -D

# Start NGINX in foreground
nginx -g "daemon off;"
