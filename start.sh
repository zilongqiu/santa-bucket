#!/bin/bash

docker-compose up -d --force-recreate
docker-compose exec phpfpm composer self-update --no-interaction
docker-compose exec phpfpm composer install --no-interaction
docker-compose exec phpfpm ./bin/console doctrine:migrations:migrate --allow-no-migration --no-interaction
docker-compose exec phpfpm rm -rf var/cache/
docker-compose exec phpfpm ./bin/console cache:warmup
