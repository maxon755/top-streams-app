#!/usr/bin/env bash

set -e

role=${CONTAINER_ROLE:-app}
env=${APP_ENV:-production}

if [ "$env" != "local" ] && [ "$env" != "test" ]; then
    echo "Caching configuration..."
    /bin/bash -c 'cd /var/www/html && php artisan config:cache && (php artisan route:cache || true)' www-data
fi

case "$role" in
    "queue")
        ;;
    "scheduler")
        ;;
    "websockets")
        ;;
    "app")
        exec php-fpm "$@"
        ;;
esac
