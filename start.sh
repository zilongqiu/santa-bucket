#!/bin/bash

# Fix folder right
sudo chown -R www-data:www-data $(pwd)
sudo chmod -R 777 $(pwd)

# Start services
docker-compose up -d --force-recreate

# Initialize project
docker-compose exec phpfpm composer self-update --no-interaction
docker-compose exec phpfpm composer install --no-interaction --no-dev --optimize-autoloader
docker-compose exec phpfpm composer dump-env prod
docker-compose exec phpfpm ./bin/console doctrine:migrations:migrate --allow-no-migration --no-interaction
docker-compose exec phpfpm ./bin/console cache:warmup
docker-compose exec phpfpm rm -rf var/cache/

echo 'Congratulations! The API is accessible at http://localhost:8080/.'
