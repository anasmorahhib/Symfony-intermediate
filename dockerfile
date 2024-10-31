FROM php:8.1-fpm

# Install dependencies and clean up to reduce image size
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libicu-dev \
	libpq-dev \
    unzip \
	wget \
    gnupg && \
	docker-php-ext-install zip intl pdo pdo_pgsql && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Symfony CLI
RUN wget https://get.symfony.com/cli/installer -O - | bash && \
    mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Set working directory
WORKDIR /var/www/html
