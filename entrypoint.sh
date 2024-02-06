#! /bin/bash

set -e
echo "Sleeping"
sleep 5
echo "Running migrations..."
php artisan migrate
echo "Done"
echo "Ruuning queue work"
echo "Migrations completed, starting the Laravel application..."
php artisan serve --host=0.0.0.0 --port=8000 &
php artisan queue:work
