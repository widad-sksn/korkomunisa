#!/bin/bash

# Ensure .env exists
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    php artisan key:generate --force
fi

# Ensure SQLite database exists
if [ ! -f /var/www/html/database/database.sqlite ]; then
    touch /var/www/html/database/database.sqlite
fi

# Sync migrations from image to volume
if [ -d /var/www/html/temp_migrations ]; then
    cp -r /var/www/html/temp_migrations/* /var/www/html/database/migrations/ 2>/dev/null || true
fi

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Verify critical environment variables
if ! grep -q "^TURNSTILE_SITE_KEY=.\+" /var/www/html/.env 2>/dev/null; then
    echo "WARNING: TURNSTILE_SITE_KEY is empty or missing in .env!"
    echo "Cloudflare Turnstile will NOT work until this is set."
fi

# Cache configuration (always re-cache to pick up .env changes)
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions again just to be safe
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Use Let's Encrypt certificate if present in volume, otherwise fallback to build certificate
if [ -f "/etc/letsencrypt/live/immkorkom.unisayogya.ac.id/fullchain.pem" ]; then
    echo "Using existing Let's Encrypt certificates..."
    cp -f /etc/letsencrypt/live/immkorkom.unisayogya.ac.id/fullchain.pem /etc/ssl/certs/app.crt
    cp -f /etc/letsencrypt/live/immkorkom.unisayogya.ac.id/privkey.pem /etc/ssl/private/app.key
fi

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
