FROM php:8.3-cli

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libzip-dev \
    && docker-php-ext-install pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

COPY . .

EXPOSE 8000

CMD ["sh", "-lc", "until php -r 'try { new PDO(\"mysql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}\", \"${DB_USERNAME}\", \"${DB_PASSWORD}\"); echo \"Database is ready\\n\"; } catch (Exception $e) { fwrite(STDERR, \"Waiting for DB...\\n\"); exit(1); }'; do sleep 2; done; php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]
