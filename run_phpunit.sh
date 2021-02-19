#!/bin/bash

source .env

MRGS_APP_ID=${MRGS_APP_ID} MRGS_CLIENT_SECRET=${MRGS_CLIENT_SECRET} MRGS_SERVER_SECRET=${MRGS_SERVER_SECRET} php ./vendor/bin/phpunit -c ./phpunit.xml
