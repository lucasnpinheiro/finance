# Default Dockerfile
#
# @link     https://www.hyperf.io
# @document https://hyperf.wiki
# @contact  group@hyperf.io
# @license  https://github.com/hyperf/hyperf/blob/master/LICENSE

FROM hyperf/hyperf:8.3-alpine-v3.19-swoole
LABEL maintainer="Hyperf Developers <group@hyperf.io>" version="1.0" license="MIT" app.name="Hyperf"

##
# ---------- env settings ----------
##
# --build-arg timezone=Asia/Shanghai
ARG timezone
ARG PHP=83
ENV PHP=$PHP

ENV TIMEZONE=${timezone:-"Asia/Shanghai"} \
    APP_ENV=prod \
    SCAN_CACHEABLE=(true)

# update
RUN set -ex \
    # show php version and extensions
    && php -v \
    && php -m \
    && php --ri swoole \
    #  ---------- some config ----------
    && cd /etc/php* \
    # - config PHP
    && { \
        echo "upload_max_filesize=128M"; \
        echo "post_max_size=128M"; \
        echo "memory_limit=1G"; \
        echo "date.timezone=${TIMEZONE}"; \
    } | tee conf.d/99_overrides.ini \
    # - config timezone
    && ln -sf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime \
    && echo "${TIMEZONE}" > /etc/timezone \
    # ---------- clear works ----------
    && rm -rf /var/cache/apk/* /tmp/* /usr/share/man \
    && echo -e "\033[42;37m Build Completed :).\033[0m\n"

RUN apk add --no-cache --upgrade \
    && apk add --no-cache gcc make libc-dev libtool autoconf automake build-base g++ php${PHP}-dev php${PHP}-pear mpdecimal-dev \
    && pecl${PHP} install decimal \
    && pecl${PHP} install pcov \
    && apk del g++ make php${PHP}-dev php${PHP}-pear mpdecimal-dev \
    && apk add --no-cache mpdecimal \
    && echo "extension=decimal.so" >> /etc/php${PHP}/conf.d/99_php.ini \
    && echo "extension=pcov.so" >> /etc/php${PHP}/conf.d/98_php.ini \
    && rm -rf /var/cache/apk/* /tmp/*

WORKDIR /opt/www

RUN apk add --no-cache curl \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

COPY . /opt/www
RUN composer install && composer update -W && php bin/hyperf.php

EXPOSE 9501

ENTRYPOINT ["php", "/opt/www/bin/hyperf.php", "start"]
