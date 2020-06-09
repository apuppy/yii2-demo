FROM php:7.2-fpm
RUN docker-php-ext-install pdo_mysql sockets \
    && pecl install redis \
    && docker-php-ext-enable redis
# install composer and change it's cache directory
#RUN curl -o /usr/bin/composer https://mirrors.aliyun.com/composer/composer.phar \
RUN curl -o /usr/bin/composer https://getcomposer.org/composer-stable.phar \
    && chmod +x /usr/bin/composer
ENV COMPOSER_HOME=/tmp/composer