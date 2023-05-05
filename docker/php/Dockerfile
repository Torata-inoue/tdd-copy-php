FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    zip \
    unzip

COPY --from=composer:2.3.9 /usr/bin/composer /usr/bin/composer

WORKDIR /app
