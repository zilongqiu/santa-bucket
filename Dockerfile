FROM zilongqiu/zstack-env

RUN mkdir /var/www

RUN chown -R www-data:www-data /var/www \
 && chmod -R 777 /var/www

WORKDIR /var/www
