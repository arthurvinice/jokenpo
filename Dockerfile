# -------------------------------
# Laravel + Livewire 4 Dockerfile
# -------------------------------

# Use the official PHP 8.2 image with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install PHP extensions and system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    zip \
    curl \
    && docker-php-ext-install zip pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Configure Apache to use Laravel's public folder as DocumentRoot
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Copy all application files
COPY . .

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Run Laravel post-install scripts
RUN php artisan package:discover --ansi

# Set permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80
EXPOSE 80

# Environment variables (can override in Render)
ENV APP_ENV=production
ENV APP_DEBUG=false
ENV APP_KEY=base64:QyuVEgQtiuP8jU7/7hmT2ovX/VXuH8MNWgEFIcA3SJE=

# Run Apache in the foreground
CMD ["apache2-foreground"]
