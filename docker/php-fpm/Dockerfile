FROM php:8.0-fpm-alpine3.12
ENV COMPOSER_ALLOW_SUPERUSER 1

RUN apk upgrade --update \
    && apk add --no-cache \
        cyrus-sasl-dev \
        freetype \
        freetype-dev \
        g++ \
        git \
        libmcrypt \
        libmcrypt-dev \
        libmemcached-dev \
        libxml2-dev \
        make \
        tzdata \
        zlib-dev \
        autoconf \
        curl \
        nginx \
        nodejs \
        npm \
        librdkafka-dev \
    && docker-php-ext-configure opcache --enable-opcache \
    && git clone https://github.com/arnaud-lb/php-rdkafka.git /usr/src/php/ext/rdkafka/ \
    && docker-php-ext-configure rdkafka \
    && docker-php-ext-install opcache pdo pdo_mysql rdkafka \
    # Set time zone to Asia/Tokyo
    && cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer \
    # Modify FPM parameter
    && sed -i 's/^\(pm.max_children = \).*/\140/g' /usr/local/etc/php-fpm.d/www.conf \
    && mkdir -p /usr/share/nginx/html \
    && echo "Not Found" > /usr/share/nginx/html/index.html \
    && rm -f /etc/nginx/conf.d/default.conf \
    && sed -i -e "s|listen.allowed_clients = 127.0.0.1|;listen.allowed_clients = 127.0.0.1|" /usr/local/etc/php-fpm.d/www.conf \
    && apk del \
        curl \
        git \
        tzdata \
    && rm -rf \
        /var/cache/apk/*

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/nginx/conf.d/ /etc/nginx/conf.d/
COPY ./docker/php-fpm/conf/opcache.ini $PHP_INI_DIR/conf.d/
COPY ./docker/php-fpm/php.ini /usr/local/etc/php/conf.d/zphp.ini

COPY ./docker/php-fpm/run.sh /usr/local/bin/run.sh
ENTRYPOINT [ "/usr/local/bin/run.sh" ]
