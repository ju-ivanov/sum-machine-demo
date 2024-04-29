FROM php:8.2-fpm-alpine

ARG UID
ARG GID

ENV UID=${UID}
ENV GID=${GID}

RUN mkdir -p /var/www/html
RUN mkdir -p /tmp/storage/bootstrap/cache

WORKDIR /var/www/html

RUN apk --update add \
    nginx \
    supervisor \
    mc  \
    git \
    wget \
    curl \
    build-base \
    libmcrypt-dev \
    libxml2-dev \
    pcre-dev \
    zlib-dev \
    autoconf \
    oniguruma-dev \
    openssl \
    openssl-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    jpeg-dev \
    libpng-dev \
    imagemagick-dev \
    imagemagick \
    libzip-dev \
    gettext-dev \
    libxslt-dev \
    libxslt-dev \
    libgcrypt-dev \
    && rm  -rf /tmp/* /var/cache/apk/*

COPY ./docker/sh/docker-php-ext-disable /usr/local/bin/docker-php-ext-disable
RUN chmod +x /usr/local/bin/docker-php-ext-disable

RUN cp "/etc/ssl/cert.pem" /opt/cert.pem

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions \
    bcmath \
    intl \
    gettext \
    pcntl \
    soap \
    xsl \
    zip \
    # mysqli \
    # pdo_mysql \
    # redis \
    sockets \
    xdebug

RUN docker-php-ext-configure gd --with-freetype=/usr/lib/ --with-jpeg=/usr/lib/ && \
    docker-php-ext-install gd

RUN set -ex \
  && apk --no-cache add \
    postgresql-dev

RUN docker-php-ext-install pdo pdo_pgsql pgsql

RUN docker-php-ext-disable opcache
RUN docker-php-ext-enable xdebug

RUN mv /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

COPY ./docker/php.conf.d/php-fpm.conf /usr/local/etc/php-fpm.conf
COPY ./docker/php.conf.d/www.conf /usr/local/etc/php-fpm.d/www.conf
COPY ./docker/php.conf.d/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf
COPY ./docker/php.conf.d/00-php.ini /usr/local/etc/php/conf.d/00-php.ini
COPY ./docker/php.conf.d/02-xdebug.ini /usr/local/etc/php/conf.d/02-xdebug.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY ./docker/nginx.conf.d/default.conf /etc/nginx/http.d/default.conf

COPY ./docker/supervisor.conf.d/supervisor.ini /etc/supervisor.d/php-supervisor.ini

ADD ./ /var/www/html

RUN delgroup dialout

EXPOSE 80

ENTRYPOINT ["supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]
