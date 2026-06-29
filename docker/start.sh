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

# Run migrations
php artisan migrate --force

# Create storage symlink
php artisan storage:link

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions again just to be safe
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# Start Nginx temporarily for Certbot validation
nginx -g "daemon on;"
sleep 2

# Auto-configure SSL
certbot --nginx -d immkorkom.unisayogya.ac.id --non-interactive --agree-tos -m immkorkom@unisayogya.ac.id --redirect || echo "Certbot process finished."

# Stop temporary Nginx so Supervisor can take over
nginx -s stop
sleep 1

# Start supervisor
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
