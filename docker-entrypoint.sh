#!/bin/bash
set -e

cd /var/www

# Copy .env if it doesn't exist
if [ ! -f .env ]; then
    echo "Copying .env from .env.example"
    cp .env.example .env
fi

# Ensure storage and cache directories are writable
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Generate key if not present
if ! grep -q "APP_KEY=base64" .env; then
    echo "Generating app key..."
    php artisan key:generate
fi

# Run database migration if needed (optional)
# echo "Running migrations..."
# php artisan migrate --force

exec "$@"
