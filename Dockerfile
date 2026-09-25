FROM php:8.4-apache-bookworm
WORKDIR /var/www/html
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        git \
        unzip \
        zip \
        nano \
        libicu-dev \
        libpng-dev \
        libjpeg62-turbo-dev \
        libzip-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        bcmath \
        intl \
        zip \
        gd \
        pcntl \
        sockets \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*
ARG INSTALL_XDEBUG=false
RUN if [ "$INSTALL_XDEBUG" = "true" ]; then \
        pecl install xdebug \
        && docker-php-ext-enable xdebug; \
    fi
RUN a2enmod rewrite
COPY --from=composer:2.10.1 /usr/bin/composer /usr/bin/composer
COPY docker/apache2.conf /etc/apache2/apache2.conf
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
COPY . .
RUN mkdir -p \
        storage/framework/cache \
        storage/framework/sessions \
        storage/framework/views \
        storage/logs \
        bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache
