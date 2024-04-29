#!/usr/bin/env sh

service=sum-machine

[[ ! -f .env ]] && echo "=== Creating .env file... ===" && cp .env.example .env

echo "=== Rebuilding images... ==="
docker-compose down && (docker images | grep "${service}-" | awk '{print $1}' | xargs docker rmi)
docker-compose up -d --remove-orphans

echo "=== Installing packages... ==="
docker-compose exec "${service}-php" composer install

echo "=== Applying migrations... ==="
docker-compose exec "${service}-php" php artisan migrate

echo "=== Setting file permissions... ==="
docker-compose exec "${service}-php" sh -c '[ -d storage ] && find storage -type d -exec chmod 777 {} +'

echo "=== artisan optimize:clear... ==="
docker-compose exec "${service}-php" php artisan optimize:clear

echo "=== Done! ==="
