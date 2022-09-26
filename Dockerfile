FROM composer:1 as vendor

WORKDIR /var/www/

COPY composer.json composer.json
COPY composer.lock composer.lock
ARG PHP_VERSION=8

COPY --from=vendor /vendor/ ./vendor/
COPY . .
