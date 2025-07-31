FROM php:8.3-fpm
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

ENV COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_HOME=/composer

RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    libcurl4-openssl-dev \
    unzip \
    zip \
    git \
    supervisor \
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

RUN [ -f .env ] || cp .env.example .env

RUN composer install --no-interaction --no-dev --optimize-autoloader

RUN chmod -R 777 /var/www/html/storage

RUN php artisan key:generate

COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

COPY docker/supervisor/*.conf /etc/supervisor/conf.d/

RUN mkdir -p /var/log/supervisor /var/www/html/storage/logs

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]