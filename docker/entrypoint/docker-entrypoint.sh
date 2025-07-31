cd /var/www/html

if [ ! -f .env ]; then
    cp .env.example .env
fi

if ! grep -q "^APP_KEY=" .env || [ -z "$(grep '^APP_KEY=' .env | cut -d '=' -f2)" ]; then
    php artisan key:generate
fi

if [ ! -d vendor ]; then
    composer install --no-interaction --optimize-autoloader
fi

chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

php artisan config:clear
php artisan route:clear
php artisan view:clear

exec "$@"
