#!/bin/bash

docker-compose kill

echo '----- Setup Laravel'

docker-compose build
docker-compose up -d

echo '----- copy .env '

cp .env.example .env

echo '----- composer install | permissions'

docker exec hiring-api composer install
docker exec hiring-api chmod -R 775 storage
docker exec hiring-api chown -R 1000:www-data storage bootstrap/cache

echo '----- Generate Key'

docker exec hiring-api php artisan key:generate

echo '----- Generate secret'

yes | docker exec -i hiring-api php artisan jwt:secret

echo '----- Run Migrations'

docker exec hiring-api php artisan migrate --seed

echo '----- Starting Application'

docker-compose kill
docker exec -d hiring-api php artisan serve --host=0.0.0.0 --port=8001
docker-compose up -d
