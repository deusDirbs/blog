FROM php:7.3-fpm

WORKDIR /var/www

RUN apt-get update \
&& docker-php-ext-install pdo pdo_mysql

COPY php.ini /usr/local/etc/php/php.ini

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
USER www
