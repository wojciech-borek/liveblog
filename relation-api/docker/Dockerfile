FROM php:8.3-apache

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions amqp

RUN apt-get update && apt-get install -y \
    libssl-dev \
    pkg-config \
    supervisor \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

RUN apt-get update \
  && apt-get install -y libzip-dev wget unzip --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install zip;

RUN chown -R www-data:www-data /var/www/html

RUN a2enmod rewrite

COPY config/vhosts/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY config/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

WORKDIR /var/www/html/relation-api

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]