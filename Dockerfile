# Use a newer PHP version with better performance and security support
FROM php:7.4-apache

# Install required PHP extensions and system packages
RUN apt-get update && \
    apt-get install -y \
        libzip-dev \
        unzip && \
    docker-php-ext-install zip pdo pdo_mysql

# Set the working directory
WORKDIR /var/www/html

# Copy application files to the default web directory
COPY . /var/www/html/

# Install dependencies if composer.json exists (best practice)
COPY composer.json ./  
RUN if [ -f composer.json ]; then \
        curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
        composer install --no-dev --optimize-autoloader; \
    fi
# (Optional) If you want to generate composer.lock and ensure consistent builds, uncomment the following line:
#        composer install --no-dev --optimize-autoloader; 

# Set permissions for proper file ownership (optional, depends on your app)
RUN chown -R www-data:www-data /var/www/html

# Ensure the /tmp directory is writable for sessions
RUN mkdir -p /tmp/sessions && chmod -R 755 /tmp/sessions

# Enable Apache mod_rewrite for clean URLs
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start the Apache server
CMD ["apache2-foreground"]
