# Sử dụng image PHP với Apache
FROM php:8.1-apache

# Cài đặt các extension cần thiết
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_pgsql

# Cài đặt Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Cài đặt thư viện và package cần thiết
WORKDIR /var/www/html
COPY . .

# Cài đặt các dependency của Laravel
RUN composer install

# Cấu hình Apache và mod_rewrite
RUN a2enmod rewrite

# Mở cổng 80
EXPOSE 80
