#!/bin/bash

docker stop $(docker ps -qa)
docker exec -d hiring-api php artisan serve --host=0.0.0.0 --port=8001
docker-compose up
