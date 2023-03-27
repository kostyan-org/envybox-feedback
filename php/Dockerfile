FROM php:7.4-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN a2enmod rewrite

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN apt update && \
    apt install -y git libzip-dev && \
    docker-php-ext-install pdo pdo_mysql mysqli zip
# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
