#!/bin/bash

composer install

docker-compose up -d

docker compose exec laravel php /var/www/html/artisan migrate
