#!/bin/bash

composer install -o --working-dir="$WORKDIR"/

npm install

php-fpm
