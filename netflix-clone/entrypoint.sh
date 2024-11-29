#!/bin/sh

set -e

composer install
php artisan key:generate
php artisan config:clear
php artisan config:cache
php artisan migrate
php artisan db:seed
npm install
npm run build
php artisan serve --host=0.0.0.0 --port=8000