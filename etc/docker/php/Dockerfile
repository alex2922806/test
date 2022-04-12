FROM php:8.1.0-fpm-alpine

ARG UNAME=backend
ARG UID=1000

WORKDIR /app

RUN apk add --no-cache bash icu-dev

RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && apk del -f .build-deps \
    && mkdir -p /var/www/html/xdebug && { \
        echo "xdebug.mode=debug"; \
        echo "xdebug.start_with_request=yes"; \
        echo "xdebug.client_host=host.docker.internal"; \
        echo "xdebug.client_port=9003"; \
        echo "xdebug.log_level=0"; \
        echo "xdebug.log=/var/www/html/xdebug/xdebug.log"; \
    } > /usr/local/etc/php/conf.d/xdebug.ini;

RUN docker-php-ext-install intl bcmath

COPY ./etc/docker/php/php.ini /usr/local/etc/php/php.ini
COPY ./etc/docker/php/bin/enter /usr/local/bin/enter

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN curl https://get.symfony.com/cli/installer | bash
RUN mv ~/.symfony/bin/symfony /usr/local/bin/symfony
RUN addgroup -g $UID $UNAME && adduser -D -s /bin/bash $UNAME -u $UID -G $UNAME

USER backend

CMD ["/usr/local/bin/enter"]
