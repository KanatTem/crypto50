FROM php:8.2-fpm

#  зависимости
RUN apt-get update && apt-get install -y \
    build-essential \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    cron \
    && docker-php-ext-install pdo pdo_pgsql zip

#  Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh


# Копируем cron
COPY ./docker/php/laravel-cron /etc/cron.d/laravel-cron
RUN chmod 0644 /etc/cron.d/laravel-cron && \
    crontab /etc/cron.d/laravel-cron

ENTRYPOINT ["entrypoint.sh"]


