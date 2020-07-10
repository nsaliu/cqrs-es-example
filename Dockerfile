FROM php:7.4.6-fpm-alpine

ENV PS1="\u@\h:\w\\$ "
ENV TIMEZONE Europe/Rome

RUN apk update \
 && apk add --no-cache $PHPIZE_DEPS \
    bash \
    git \
    zip \
    unzip

RUN docker-php-ext-install opcache pdo_mysql mysqli

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
	composer global require hirak/prestissimo

RUN rm -rf /var/cache/apk/*

CMD ["php-fpm", "--nodaemonize"]
