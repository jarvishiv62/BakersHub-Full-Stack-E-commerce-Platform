#!/bin/bash

# Deployment script for BakersHub on Render

echo "Starting deployment process..."

# Install dependencies without dev packages
composer install --no-dev --optimize-autoloader

# Clear and cache Laravel configurations
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Seed the database if needed
# php artisan db:seed --force

# Clear application cache
php artisan cache:clear

# Optimize for production
php artisan optimize

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo "Deployment completed successfully!"
