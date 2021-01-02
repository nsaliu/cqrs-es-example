FROM php:7.4.13-fpm-alpine

ENV PS1="\u@\h:\w\\$ "
ENV TIMEZONE Europe/Rome

RUN apk update \
 && apk add --no-cache $PHPIZE_DEPS \
    bash \
    git \
    zip \
    unzip \
    rabbitmq-c-dev

RUN docker-php-ext-install opcache pdo_mysql mysqli
RUN pecl install amqp-1.10.0
RUN docker-php-ext-enable amqp

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /var/cache/apk/*

CMD ["php-fpm", "--nodaemonize"]
