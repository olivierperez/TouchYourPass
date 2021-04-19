FROM php:5.6.26-fpm

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libmcrypt-dev \
        libpng12-dev \
        cron \
        zlib1g-dev libicu-dev g++ \
        php5-mysqlnd

RUN docker-php-ext-install -j$(nproc) iconv mcrypt
RUN docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install mysqli mysql pdo pdo_mysql

RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl

RUN chsh -s /bin/bash www-data

CMD ["php-fpm"]