# Santa Bucket API

Don't hesitate to ask him everything you want!

## Startup

1. Replace `MY_KEY` value of `GOOGLE_API_KEY=MY_KEY` in the file located at `workspace/.env` (Attention: no white space allowed)
2. Simply execute the script `bash ./start.sh` and wait for the services to be started (described bellow in the section `Docker services`)
3. Congratulations! :tada: The API is accessible at `http://localhost:8080/`.

## Documentation

A documentation of the API is available at `http://localhost:8080/api/doc`. <br />

## Docker services

| Image | Version | Port | Name  | Description |
| --- | --- | --- | --- | --- |
| **ubuntu** | 18.04 | N/A | webapp | My personal development env (libs, plugins, alias, etc.) |
| **mysql** | 5.7 | 3307 | zstack-mysql | *Root password: my_secret<br />DB name: santa<br />Username: santa_user<br />Password: santa_password* |
| **phpfpm** | 7.3-fpm | 9001 | zstack-phpfpm | Custom phpfpm configuration for the project |
| **nginx** | 1.15 | 8080 | zstack-nginx | Custom nginx configuration for the project |
