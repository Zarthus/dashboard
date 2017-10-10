FROM php:7.1-fpm-alpine

MAINTAINER Jos Ahrens <zarthus@liefland.net>

RUN apk add --update \
    bash \
    ca-certificates \
    curl curl-dev libcurl \
    openssl \
    autoconf automake make gcc g++
RUN update-ca-certificates

RUN docker-php-ext-install \
    mbstring \
    curl \
    tokenizer \
    json \
    opcache

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

ADD install-composer.sh /tmp/install-composer.sh
RUN sh /tmp/install-composer.sh
RUN composer --version

RUN rm -rf /var/cache/apk/* && rm -rf /tmp/*

ADD dash.ini /usr/local/etc/php/conf.d/
ADD xdebug.ini /usr/local/etc/php/conf.d/
ADD dash.ini /etc/php7/cli/conf.d/
ADD dash.pool.conf /etc/php7/fpm.d/
ADD bashrc.sh /root/.bashrc

ARG XDEBUG_REMOTE_HOST
RUN echo "xdebug.remote_host=${XDEBUG_REMOTE_HOST}" >> /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www/dash

CMD ["php-fpm", "-F"]
