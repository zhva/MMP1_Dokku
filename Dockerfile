FROM php:7.4-apache

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-configure pdo_pgsql && docker-php-ext-install pdo_pgsql

COPY apache.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

COPY src/ /var/www/html/
