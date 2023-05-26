#!/bin/bash

docker stop $(docker ps -qa)
docker-compose up
docker exec -d hiring-api php artisan serve --host=0.0.0.0 --port=8000
