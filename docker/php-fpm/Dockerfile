FROM php:7.4-fpm-alpine

ARG DOCKER_USER_UID
ARG DOCKER_USER_GID
RUN addgroup -g ${DOCKER_USER_GID} -S docker-group && adduser -u ${DOCKER_USER_UID} -S docker-user

RUN apk update \
    && apk add  --no-cache git postgresql-dev curl libmcrypt libmcrypt-dev openssh-client icu-dev \
    libxml2-dev freetype-dev libpng-dev libjpeg-turbo-dev g++ make autoconf oniguruma-dev \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN docker-php-source extract \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && docker-php-source delete \
    && docker-php-ext-install pdo pdo_pgsql soap intl \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.extended_info=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_execution_time=1000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.max_input_time=1000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && echo "xdebug.remote_port=9000" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini \
    && rm -rf /tmp/*

CMD ["php-fpm", "-F"]

WORKDIR /var/www/app

EXPOSE 9000

USER ${DOCKER_USER_UID}
