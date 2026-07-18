# Local development image.
# Runs FPM as root and disables OPcache on purpose: Windows bind-mount mtimes are
# unreliable, so a cached opcode never invalidates and edits appear to do nothing.
# Production uses docker/app/Dockerfile.prod, which keeps OPcache on.
FROM php:8.3-fpm-alpine

RUN apk add --no-cache \
        icu-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        postgresql-dev \
        oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_pgsql \
        pdo_mysql \
        intl \
        gd \
        zip \
        opcache \
    && apk del --no-network icu-dev libzip-dev libpng-dev libjpeg-turbo-dev freetype-dev oniguruma-dev \
    && apk add --no-cache icu-libs libzip libpng libjpeg-turbo freetype postgresql-libs

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# OPcache off for dev (see header note).
RUN printf 'opcache.enable=0\nopcache.enable_cli=0\n' > /usr/local/etc/php/conf.d/zz-dev-opcache.ini \
    && printf 'upload_max_filesize=32M\npost_max_size=32M\nmemory_limit=512M\n' > /usr/local/etc/php/conf.d/zz-limits.ini

# FPM as root so bind-mounted files stay writable from the host.
RUN printf '[global]\ndaemonize = no\n\n[www]\nuser = root\ngroup = root\nlisten = 9000\n' \
    > /usr/local/etc/php-fpm.d/zz-dev.conf

WORKDIR /var/www/html

# -R allows the root pool configured above; FPM refuses to start without it.
CMD ["php-fpm", "-R"]
