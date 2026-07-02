#!/bin/bash
set -e

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "SomeRandomString" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Wait for MySQL to be ready
if [ "$DB_CONNECTION" = "mysql" ]; then
    echo "Waiting for MySQL to be ready..."
    MAX_RETRIES=30
    RETRY=0
    while ! php artisan migrate:status > /dev/null 2>&1; do
        RETRY=$((RETRY+1))
        if [ $RETRY -ge $MAX_RETRIES ]; then
            echo "MySQL not ready after $MAX_RETRIES retries, skipping migrations..."
            break
        fi
        echo "MySQL not ready yet, retrying ($RETRY/$MAX_RETRIES)..."
        sleep 3
    done

    # Run migrations
    echo "Running database migrations..."
    php artisan migrate --force
fi

# Cache configs for production
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Apache
echo "Starting Apache..."
exec apache2-foreground