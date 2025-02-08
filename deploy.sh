#!/bin/bash

echo "Starting deployment process..."

# Optimize composer autoloader
echo "Optimizing Composer..."
composer install --optimize-autoloader --no-dev

# Clear all caches
echo "Clearing caches..."
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
echo "Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Build assets
echo "Building assets..."
npm ci
npm run build

# Remove development files
echo "Removing development files..."
rm -rf node_modules
rm -rf tests

# Set proper permissions
echo "Setting proper permissions..."
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
chmod 755 artisan

echo "Deployment process completed!"
