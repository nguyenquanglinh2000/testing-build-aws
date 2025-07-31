FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    unzip \
    zip \
    git \
    libonig-dev \
    libxml2-dev \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb \
    && docker-php-ext-install pdo mbstring xml \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY docker/php/php.ini /usr/local/etc/php/

WORKDIR /var/www/html

COPY . .

RUN composer install --no-interaction --no-dev --optimize-autoloader

RUN chown -R www-data:www-data storage bootstrap/cache

RUN chmod -R 775 storage bootstrap/cache

RUN apt-get update && apt-get install -y supervisor

RUN mkdir -p /var/log/supervisor
RUN chown -R www-data:www-data /var/log/supervisor
RUN chmod -R 775 /var/log/supervisor

COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

COPY docker/supervisor/*.conf /etc/supervisor/conf.d/

RUN mkdir -p /var/log/supervisor /var/www/html/storage/logs

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]