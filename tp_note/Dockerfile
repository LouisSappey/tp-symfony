FROM php:8.2-cli
RUN apt-get update -y && apt-get install -y \
    libmcrypt-dev \
    libzip-dev \
    unzip \
    git \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip intl mbstring xml
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
WORKDIR /app
COPY . /app
RUN composer install --no-interaction --optimize-autoloader
RUN composer require symfony/debug-bundle --dev
RUN composer require debug
EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000", "-t", "public"]