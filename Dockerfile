# Use the official PHP 7.4 FPM base image
FROM php:7.4-fpm

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the contents of the current directory to /var/www/html
COPY . .

# Install Nginx and required PHP extensions
RUN apt-get update \
    && apt-get install -y nginx libpq-dev \
    && docker-php-ext-install pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Copy Nginx configuration
COPY nginx.conf /etc/nginx/nginx.conf

# Expose port 80 for Nginx
EXPOSE 80

# Start Nginx and PHP-FPM
CMD service nginx start && php-fpm
