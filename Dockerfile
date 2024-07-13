# Use the official PHP 7.4 Apache base image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the current directory to /var/www/html
COPY . .

# Install required PHP extensions
RUN docker-php-ext-install pdo pdo_mysql \
    && a2enmod rewrite

# Expose port 80 for Apache
EXPOSE 80

# Start Apache
CMD apache2-foreground
