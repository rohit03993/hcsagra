#!/bin/bash
# Run on Hostinger server after: git pull origin main
set -e

echo "==> Installing PHP dependencies..."
composer install --no-dev --optimize-autoloader

if command -v npm >/dev/null 2>&1; then
    echo "==> Building frontend assets..."
    npm ci
    npm run build
else
    echo "==> npm not found — skip build (upload public/build from your PC if needed)"
fi

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Linking storage (safe to re-run)..."
php artisan storage:link 2>/dev/null || true

echo "==> Caching config..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Done. Site updated."
