FROM php:8.1-apache

# RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

RUN apt-get update && apt-get upgrade -y && apt-get install -y --no-install-recommends \
    apt-utils \
    unzip \
    libxml2-dev \
    libzip-dev \
    curl \
    libcurl4-openssl-dev \
    libvpx-dev \
    libjpeg-dev \
    libpng-dev \
    libpq-dev \
    acl \
    exiftool

RUN docker-php-ext-configure gd --with-jpeg
RUN docker-php-ext-install xml zip curl gd intl pdo pdo_pgsql opcache exif

RUN yes | pecl install xdebug-3.2.0 \
&& docker-php-ext-enable xdebug \
&& echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.xdebug.mode=develop" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
&& echo "xdebug.client_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN pecl install apcu \
  && docker-php-ext-enable apcu

COPY infra/php/php.ini /usr/local/etc/php/conf.d/php.ini

COPY infra/php/veglab.conf /etc/apache2/sites-available/veglab.conf
RUN rm /etc/apache2/sites-enabled/000-default.conf
RUN ln -s /etc/apache2/sites-available/veglab.conf /etc/apache2/sites-enabled/veglab.conf
RUN a2enmod rewrite

# Get composer
COPY --from=composer:2.4 /usr/bin/composer /usr/bin/composer

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

WORKDIR /var/www/html/
