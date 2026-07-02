#!/bin/bash
set -e

# Check if vendor exists (should be installed during build)
if [ ! -d "/app/vendor" ]; then
    echo "ERROR: /app/vendor directory not found. Composer install failed during build."
    echo "Starting Apache anyway for debugging..."
    exec apache2-foreground
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "SomeRandomString" ] || [ "$APP_KEY" = "" ]; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force --ansi || echo "WARNING: Could not generate APP_KEY"
fi

# Run migrations if MySQL is configured
if [ "$DB_CONNECTION" = "mysql" ] && [ -n "$DB_HOST" ]; then
    echo "Waiting for MySQL to be ready..."
    MAX_RETRIES=15
    RETRY=0
    while [ $RETRY -lt $MAX_RETRIES ]; do
        if php artisan migrate:status > /dev/null 2>&1; then
            echo "MySQL is ready!"
            break
        fi
        RETRY=$((RETRY+1))
        echo "Waiting for MySQL... ($RETRY/$MAX_RETRIES)"
        sleep 2
    done

    if [ $RETRY -lt $MAX_RETRIES ]; then
        echo "Running database migrations..."
        php artisan migrate --force || echo "WARNING: Migrations failed"
    else
        echo "WARNING: MySQL not available, skipping migrations"
    fi
fi

# Cache configs for production
echo "Caching configuration..."
php artisan config:cache 2>/dev/null || true
php artisan route:cache 2>/dev/null || true
php artisan view:cache 2>/dev/null || true

echo "Starting Apache on port 8080..."
exec apache2-foreground