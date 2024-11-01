# dockers-files/php/Dockerfile
FROM php:8.3-fpm

# Instalar extensiones necesarias
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pgsql pdo pdo_pgsql

# Configurar el directorio de trabajo
WORKDIR /var/www/html

COPY . .