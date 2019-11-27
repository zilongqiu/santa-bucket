# Santa Bucket API

Don't hesitate to ask him everything you want!

## Docker services

| Image | Version | Port | Name  | Description |
| --- | --- | --- | --- | --- |
| **ubuntu** | 18.04 | N/A | webapp | My personal development env (libs, plugins, alias, etc.) |
| **mysql** | 5.7 | 3307 | mysql | *DB name: santa-bucket*<br />*Username: santa*<br />*Password: santa* |
| **phpfpm** | 7.3-fpm | 9001 | zstack-phpfpm | Custom phpfpm configuration for the project |
| **nginx** | 1.15 | 8080 | zstack-nginx | Custom nginx configuration for the project |
