#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}

case "$role" in
    "scheduler")
       exec php artisan schedule:work
    ;;
    "app")
        exec php-fpm "$@"
    ;;
esac
