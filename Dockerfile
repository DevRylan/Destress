FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_sqlite

COPY . /var/www/html/

CMD cp /var/www/html/destress.db /tmp/destress.db \
    && chmod 666 /tmp/destress.db \
    && apache2-foreground
