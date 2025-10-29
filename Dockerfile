# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy composer files first (to leverage cache)
COPY composer.json composer.lock ./

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy the rest of the application
COPY . .

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Environment variables (Render can override)
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_KEY=base64:QyuVEgQtiuP8jU7/7hmT2ovX/VXuH8MNWgEFIcA3SJE=

# Run Apache in foreground
CMD ["apache2-foreground"]
