#!/bin/bash

docker-compose kill

echo ''
echo '----- Setup Laravel'
echo ''

docker-compose build

docker-compose up -d

echo ''
echo '----- copy .env '
echo ''

cp .env.local .env

echo ''
echo '----- composer install | permissions'
echo ''

docker exec hiring-api composer install
docker exec hiring-api chmod -R 775 storage
docker exec hiring-api chown -R 1000:www-data storage bootstrap/cache

echo ''
echo '----- Generate Key'
echo ''

docker exec hiring-api php artisan key:generate

echo ''
echo '----- Run Migrations'
echo ''

docker exec hiring-api php artisan migrate --seed

echo ''
echo '----- Starting Application'
echo ''

docker-compose kill
docker-compose up
