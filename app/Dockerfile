FROM composer:latest AS composer
FROM php:8.0-fpm

#Update!
RUN apt-get update

#Install zip+icu dev libs + pgsql dev support
RUN apt-get install libzip-dev zip libicu-dev libpq-dev -y

#Install PHP extensions zip and intl (intl requires to be configured)
RUN docker-php-ext-install zip && docker-php-ext-configure intl && docker-php-ext-install intl

# Add MySQL and Postgres/pgsql support
RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql && docker-php-ext-install pdo_pgsql pgsql

# Install composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /var/www/arch.homework
WORKDIR /var/www/arch.homework

RUN chown -R www-data:www-data /var/www/arch.homework
USER www-data

RUN composer install --no-scripts

WORKDIR /var/www/arch.homework/public
