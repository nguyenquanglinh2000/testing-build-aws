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

RUN composer install --no-interaction --no-dev --optimize-autoloader

RUN chmod -R 777 /var/www/html/storage

RUN php artisan key:generate

COPY docker/supervisor/supervisord.conf /etc/supervisord.conf

COPY docker/supervisor/*.conf /etc/supervisor/conf.d/

RUN mkdir -p /var/log/supervisor /work/storage/logs

RUN mkdir -p /var/log/supervisor /var/www/html/storage/logs

# RUN echo '[supervisord]\
# nodaemon=true\n\
# logfile=/var/log/supervisor/supervisord.log\n\
# pidfile=/var/run/supervisord.pid\n\
# \n\
# [unix_http_server]\n\
# file=/tmp/supervisor.sock\n\
# chmod=0700\n\
# \n\
# [supervisorctl]\n\
# serverurl=unix:///tmp/supervisor.sock\n\
# \n\
# [rpcinterface:supervisor]\n\
# supervisor.rpcinterface_factory=supervisor.rpcinterface:make_main_rpcinterface\n\
# \n\
# [program:php-fpm]\n\
# command=php-fpm\n\
# autostart=true\n\
# autorestart=true\n\
# priority=1\n\
# stdout_logfile=/var/log/supervisor/php-fpm.log\n\
# stderr_logfile=/var/log/supervisor/php-fpm-error.log\n\
# \n\
# [program:laravel-schedule]\n\
# command=php artisan schedule:work\n\
# autostart=true\n\
# autorestart=true\n\
# user=www-data\n\
# redirect_stderr=true\n\
# stdout_logfile=/var/www/html/storage/logs/schedule.log' > /etc/supervisord.conf

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
# CMD ["supervisord", "-c", "/etc/supervisord.conf"]