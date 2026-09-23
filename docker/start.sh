#!/bin/bash
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache
php artisan config:clear
php artisan config:cache
php artisan migrate --force
php-fpm -D
nginx -g "daemon off;"