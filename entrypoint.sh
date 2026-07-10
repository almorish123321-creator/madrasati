#!/bin/bash
set -e

# Copy .env.example to .env if .env doesn't exist
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Always ensure APP_DEBUG=true for now
sed -i 's/APP_DEBUG=.*/APP_DEBUG=true/' /var/www/html/.env

# Map Railway's auto-injected MYSQL_* variables to Laravel's DB_* variables
# Write them to .env so Laravel can read them
if [ -n "$MYSQLHOST" ]; then
    DB_HOST_VAL="$MYSQLHOST"
    DB_PORT_VAL="${MYSQLPORT:-3306}"
    DB_DATABASE_VAL="${MYSQLDATABASE:-railway}"
    DB_USERNAME_VAL="${MYSQLUSER:-root}"
    DB_PASSWORD_VAL="$MYSQLPASSWORD"
    
    # Write DB settings to .env
    sed -i "s|DB_HOST=.*|DB_HOST=$DB_HOST_VAL|" /var/www/html/.env
    sed -i "s|DB_PORT=.*|DB_PORT=$DB_PORT_VAL|" /var/www/html/.env
    sed -i "s|DB_DATABASE=.*|DB_DATABASE=$DB_DATABASE_VAL|" /var/www/html/.env
    sed -i "s|DB_USERNAME=.*|DB_USERNAME=$DB_USERNAME_VAL|" /var/www/html/.env
    sed -i "s|DB_PASSWORD=.*|DB_PASSWORD=$DB_PASSWORD_VAL|" /var/www/html/.env
    
    echo "DB configured: $DB_HOST_VAL:$DB_PORT_VAL/$DB_DATABASE_VAL"
fi

# Set APP_URL from Railway
if [ -n "$RAILWAY_PUBLIC_DOMAIN" ]; then
    sed -i "s|APP_URL=.*|APP_URL=https://$RAILWAY_PUBLIC_DOMAIN|" /var/www/html/.env
    echo "APP_URL set to https://$RAILWAY_PUBLIC_DOMAIN"
fi

# Generate APP_KEY if not in .env, and export it
if ! grep -q "APP_KEY=base64:" /var/www/html/.env; then
    php artisan key:generate --force
    echo "APP_KEY generated"
fi

# Export APP_KEY from .env so PHP can read it
APP_KEY_VAL=$(grep '^APP_KEY=' /var/www/html/.env | cut -d= -f2)
if [ -n "$APP_KEY_VAL" ]; then
    export APP_KEY="$APP_KEY_VAL"
    echo "APP_KEY exported (${#APP_KEY_VAL} chars)"
fi

# Wait for MySQL using TCP connection check
DB_HOST_VAL="${DB_HOST_VAL:-$(grep DB_HOST /var/www/html/.env | cut -d= -f2)}"
DB_PORT_VAL="${DB_PORT_VAL:-3306}"
if [ -n "$DB_HOST_VAL" ] && [ "$DB_HOST_VAL" != "127.0.0.1" ]; then
    MAX_RETRIES=30
    RETRY=0
    while [ $RETRY -lt $MAX_RETRIES ]; do
        if php -r "
            \$c = @fsockopen('$DB_HOST_VAL', $DB_PORT_VAL, \$e, \$s, 5);
            if (\$c) { fclose(\$c); exit(0); }
            exit(1);
        " 2>/dev/null; then
            echo "MySQL reachable at $DB_HOST_VAL:$DB_PORT_VAL"
            break
        fi
        echo "Waiting for MySQL... ($((RETRY+1))/$MAX_RETRIES)"
        sleep 3
        RETRY=$((RETRY+1))
    done
fi

# Run migrations (skip if tables exist)
echo "Running migrations..."
php artisan migrate --force 2>&1 || echo "Migration skipped or failed, continuing..."

# DO NOT cache config - it causes issues with .env values
# Just cache views for performance
echo "Caching views..."
php artisan view:cache

# Ensure writable permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/.env

echo "Starting Apache..."

# Fix MPM conflict at runtime
a2dismod mpm_event mpm_worker mpm_itk 2>/dev/null || true
rm -f /etc/apache2/mods-enabled/mpm_*.load /etc/apache2/mods-enabled/mpm_*.conf
a2enmod mpm_prefork rewrite 2>/dev/null || true

exec apache2-foreground