#!/bin/sh
set -e

cd /app

if [ ! -f common/config/main-local.php ]; then
    echo "Initializing Yii application..."
    ENV=${YII_ENV:-dev}
    php init --env=Development --overwrite=n
fi

if [ ! -d vendor ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist
fi

echo "Running migrations..."
php yii migrate --interactive=0

exec php-fpm
