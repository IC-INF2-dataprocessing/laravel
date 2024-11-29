FROM php:8.2-fpm
RUN apt-get update -y && apt-get install -y openssl zip unzip git zlib1g-dev libpng-dev libfreetype6-dev npm
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql gd
WORKDIR /var/www/html
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 8000