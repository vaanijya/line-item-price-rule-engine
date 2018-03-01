#!/bin/bash

[[ ! -e /.dockerenv ]] && exit 0

set -xe

# copy php-ci.ini to PHP_INI_SCAN_DIR
cp ${CI_PROJECT_DIR}/ci/php-ci.ini /usr/local/etc/php/conf.d/php-ci.ini

# composer update
composer update
