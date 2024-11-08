# Use PHP 8.1 FPM as the base image
FROM php:8.1-fpm

# Install dependencies and PHP extensions
RUN apt-get update && \
    apt-get install -y --no-install-recommends \
    git unzip wget locales libzip-dev libicu-dev libpq-dev libpng-dev libxml2-dev libxslt-dev gnupg && \
    docker-php-ext-configure intl && \
    docker-php-ext-install zip intl pdo pdo_pgsql opcache && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony


# Set the working directory
WORKDIR /var/www/html
