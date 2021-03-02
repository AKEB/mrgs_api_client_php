#!/bin/bash

# We need to install dependencies only for Docker
[[ ! -e /.dockerenv ]] && exit 0

set -xe

export https_proxy=http://m100.cache.pvt:3128 
export http_proxy=http://m100.cache.pvt:3128

# Install git (the php image doesn't have it) which is required by composer
apt-get update -yqq
# apt-get install wget git unzip -yqq
apt-get install wget git unzip -yqq && pecl install xdebug && docker-php-ext-enable xdebug

{ \
            echo "xdebug.mode=debug"; \
            echo "xdebug.start_with_request=yes"; \
            echo "xdebug.client_host=host.docker.internal"; \
            echo "xdebug.client_port=9000"; \
        } > /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \


# Install phpunit, the tool that we will use for testing
# curl --location --output /usr/local/bin/phpunit "https://phar.phpunit.de/phpunit.phar"
# chmod +x /usr/local/bin/phpunit

# Install mysql driver
# Here you can install any other extension that you need
# docker-php-ext-install pdo_mysql

php -i | grep xdebug
