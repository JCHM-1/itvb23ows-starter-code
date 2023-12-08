# Use the official PHP image
FROM php:7.4-apache

# Copy your PHP application files to the container
COPY . /var/www/html

# Install any additional dependencies your application might need
# For example, if you use a database, you might need to install the corresponding PHP extension
# RUN docker-php-ext-install pdo pdo_mysql

# Expose the port on which Apache will run
EXPOSE 80

# Start Apache when the container starts
CMD ["apache2-foreground"]
