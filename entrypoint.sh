#!/bin/bash
set -e

# Map Railway's auto-injected MYSQL_* variables to Laravel's DB_* variables
if [ -n "$MYSQLHOST" ]; then
    export DB_HOST="$MYSQLHOST"
    export DB_PORT="${MYSQLPORT:-3306}"
    export DB_DATABASE="${MYSQLDATABASE:-railway}"
    export DB_USERNAME="${MYSQLUSER:-root}"
    export DB_PASSWORD="$MYSQLPASSWORD"
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Wait for MySQL to be ready
MAX_RETRIES=30
RETRY=0
while [ $RETRY -lt $MAX_RETRIES ]; do
    if php artisan migrate:status > /dev/null 2>&1; then
        break
    fi
    echo "Waiting for MySQL... (attempt $((RETRY+1))/$MAX_RETRIES)"
    sleep 3
    RETRY=$((RETRY+1))
done

if [ $RETRY -ge $MAX_RETRIES ]; then
    echo "ERROR: MySQL not available after $MAX_RETRIES attempts"
    exit 1
fi

# Run migrations
echo "Running migrations..."
php artisan migrate --force

# Cache config and views (NOT route:cache - it breaks localization)
echo "Caching config and views..."
php artisan config:cache
php artisan view:cache

echo "Starting Apache..."
exec apache2-foreground