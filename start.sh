#!/bin/bash

# Start services
docker-compose up -d --force-recreate

# Initialize project
docker-compose exec phpfpm composer self-update --no-interaction
docker-compose exec phpfpm composer install --no-interaction
# TODO enable it just after the test
#docker-compose exec phpfpm composer dump-env prod
docker-compose exec phpfpm ./bin/console doctrine:migrations:migrate --allow-no-migration --no-interaction
docker-compose exec phpfpm rm -rf var/cache/
docker-compose exec phpfpm ./bin/console cache:warmup

echo 'Congratulations! The API is accessible at http://localhost:8080/.'
