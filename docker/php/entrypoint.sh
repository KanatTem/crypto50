#!/bin/bash

echo "Запускаем cron..."
service cron start

# Выполняем composer install, если нет vendor
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install
fi

# Копируем .env, если он отсутствует
if [ ! -f ".env" ]; then
    echo "Copying .env.example to .env..."
    cp .env.example .env
fi

# Генерация ключа приложения
echo "Generating app key..."
php artisan key:generate

# Запуск миграций
echo "Running migrations..."
php artisan migrate --force

# Запускаем PHP-FPM (важно — в foreground)
echo "Starting PHP-FPM..."
exec php-fpm
