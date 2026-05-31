FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    libssl-dev \
    libxml2-dev \
    libsqlite3-dev \
    libonig-dev \
    zip unzip git curl

RUN docker-php-ext-install pdo pdo_mysql mbstring xml dom curl

RUN pecl install redis && docker-php-ext-enable redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8000}