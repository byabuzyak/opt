FROM php:8.2.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y git default-mysql-client sudo

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html