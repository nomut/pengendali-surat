FROM php:8.4-fpm-alpine

ARG WWWGROUP=1000

ENV TZ=UTC

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

# Build tools for PECL (autoconf, gcc, make, etc.)
RUN apk add --no-cache $PHPIZE_DEPS

# System dependencies
RUN apk add --no-cache \
    bash curl git zip unzip nano \
    libpng-dev libjpeg-turbo-dev libwebp-dev freetype-dev \
    libzip-dev icu-dev libxml2-dev oniguruma-dev \
    postgresql-dev \
    imagemagick-dev imagemagick \
    libmemcached-dev cyrus-sasl-dev \
    openldap-dev \
    linux-headers \
    nodejs npm

# PHP extensions (core)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo pdo_pgsql pdo_mysql pdo_sqlite \
        gd zip bcmath soap intl xml mbstring ldap opcache

# PECL extensions (order matters: igbinary/msgpack first for redis serializer support)
RUN pecl channel-update pecl.php.net \
    && pecl install igbinary \
    && pecl install msgpack \
    && pecl install imagick \
    && pecl install --configureoptions 'enable-redis-igbinary="yes" enable-redis-msgpack="yes"' redis \
    && pecl install --configureoptions 'enable-memcached-igbinary="yes"' memcached \
    && pecl install pcov \
    && pecl install xdebug \
    && docker-php-ext-enable igbinary msgpack imagick redis memcached pcov xdebug

# Composer
RUN curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# pnpm
RUN npm install -g pnpm

# Adjust www-data to match host group
RUN delgroup www-data 2>/dev/null; \
    addgroup -g $WWWGROUP www-data && \
    adduser -D -u 1337 -G www-data www-data 2>/dev/null || true

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]
