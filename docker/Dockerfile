# Use the official PHP 8.2 FPM base image
FROM php:8.2-fpm

# Install required dependencies
RUN apt-get update && \
    apt-get install -y \
    ca-certificates \
    curl \
    gnupg \
    git \
    libzip-dev \
    libpng-dev \
    zip \
    unzip

RUN docker-php-ext-install zip gd pcntl mysqli pdo pdo_mysql
RUN pecl install xdebug && docker-php-ext-enable xdebug

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /app

# Expose port
# - 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
