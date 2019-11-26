FROM php:7.3-fpm

RUN apt-get update \
    && apt-get install -y \
    git \
    wget \
    python \
    zlib1g-dev \
    libzip-dev

RUN docker-php-ext-install zip pdo_mysql mbstring opcache

# Install xdebug
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug
ARG XDEBUG_INI=/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.default_enable = on" >> ${XDEBUG_INI} \
    && echo "xdebug.remote_enable = on" >> ${XDEBUG_INI} \
    && echo "xdebug.remote_autostart = off" >> ${XDEBUG_INI}

# Add configs
ENV TZ=Europe/Paris
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

COPY /config/php.ini /usr/local/etc/php/php.ini

# Install Composer
RUN php -r "readfile('https://getcomposer.org/installer');" | php -- --install-dir=/usr/local/bin --filename=composer \
    && chmod +x /usr/local/bin/composer

# Install Symfony command
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /bin/

# Define rights
RUN chown -R www-data:www-data /var/www \
 && chmod -R 777 /var/www

WORKDIR /var/www
