FROM php:8.1-fpm

# Install dependencies and clean up to reduce image size
RUN apt-get update && apt-get install -y libzip-dev unzip \
    && docker-php-ext-install zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html
