# Use the official PHP 8.0 image
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    git \
    nano

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql mbstring exif pcntl bcmath opcache xml zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy the local Laravel code to the container
COPY . .

# Install Laravel dependencies and generate optimized autoload files
RUN composer install --optimize-autoloader --no-dev

RUN php artisan key:generate

CMD php -S 0.0.0.0:9000 -t public

# Expose port 9000 and start PHP-FPM servermysql
EXPOSE 9000
