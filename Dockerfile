FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev

RUN docker-php-ext-install curl

WORKDIR /app