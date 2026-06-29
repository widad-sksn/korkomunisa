FROM ubuntu:24.04

ENV DEBIAN_FRONTEND=noninteractive
ENV TZ=Asia/Jakarta

RUN apt-get update && apt-get install -y \
    software-properties-common \
    curl \
    zip \
    unzip \
    git \
    nginx \
    supervisor \
    sqlite3 \
    php8.3-fpm \
    php8.3-cli \
    php8.3-sqlite3 \
    php8.3-mbstring \
    php8.3-xml \
    php8.3-curl \
    php8.3-zip \
    php8.3-bcmath \
    php8.3-intl \
    certbot \
    python3-certbot-nginx \
    && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

# Copy application files
COPY . .

# Ensure storage directories exist
RUN mkdir -p storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

# Install PHP dependencies with retry logic for network stability
RUN composer install --no-interaction --no-dev --optimize-autoloader || \
    (sleep 5 && composer install --no-interaction --no-dev --optimize-autoloader) || \
    (sleep 5 && composer install --no-interaction --no-dev --optimize-autoloader --prefer-source)

# Install Node dependencies and build assets
RUN npm install && npm run build

# Copy configuration files
COPY docker/nginx.conf /etc/nginx/sites-available/default
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf
COPY docker/start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# Create run directory for PHP-FPM
RUN mkdir -p /run/php

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/start.sh"]
