FROM php:8.0-apache
RUN apt-get update --allow-unauthenticated && apt-get upgrade -y --allow-unauthenticated
RUN docker-php-ext-install mysqli
EXPOSE 80