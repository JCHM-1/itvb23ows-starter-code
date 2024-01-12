# Use the official PHP image
FROM php:8.2-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y
RUN useradd -m jenkins
USER jenkins

COPY . /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]
