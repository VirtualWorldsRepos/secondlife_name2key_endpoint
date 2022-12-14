FROM php:7.4-apache

LABEL MAINTAINER="Madpeter"

COPY . /srv/website
COPY .docker/vhost.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /srv/app

RUN apt-get update
RUN apt-get install -y libzip-dev

RUN docker-php-ext-install zip
RUN docker-php-ext-install mysqli

RUN chown -R www-data:www-data /srv/website \
    && a2enmod rewrite
