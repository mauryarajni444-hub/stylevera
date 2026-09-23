#!/bin/bash
php artisan config:clear
php artisan config:cache
php artisan migrate --force
php-fpm -D
nginx -g "daemon off;"
