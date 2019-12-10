# Santa Bucket API

Don't hesitate to ask him everything you want!

## Startup

1. Replace `MY_KEY` value of `GOOGLE_API_KEY=MY_KEY` in the file located at `workspace/.env` (Attention: no white space allowed)
2. Simply execute the script `bash ./start.sh` and wait for the services to be started (described bellow in the section `Docker services`)
3. Congratulations! :tada: The API is accessible at `http://localhost:8080/`.

## API Documentation

A documentation of the API is available at `http://localhost:8080/api/doc`.

## Docker services

| Image | Version | Port | Name  | Description |
| --- | --- | --- | --- | --- |
| **ubuntu** | 18.04 | N/A | webapp | Add your personal development env (libs, plugins, alias, etc.) |
| **mysql** | 5.7 | 3307 | mysql | *Root password: my_secret<br />DB name: santa<br />Username: santa_user<br />Password: santa_password* |
| **phpfpm** | 7.3-fpm | 9001 | phpfpm | Custom phpfpm configuration for the project |
| **nginx** | 1.15 | 8080 | nginx | Custom nginx configuration for the project |

## Unit tests

PHPUnit is not installed by default (because of prod env). You need to first install it before to run it.
In order to run unit tests, simply run these commands:

```
docker-compose exec phpfpm composer install --dev
docker-compose exec phpfpm ./bin/phpunit
```