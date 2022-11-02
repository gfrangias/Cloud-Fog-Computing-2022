FROM php:7.3.3-apache
RUN apt-get update --allow-unauthenticated && apt-get upgrade -y --allow-unauthenticated
RUN docker-php-ext-install mysqli
EXPOSE 80