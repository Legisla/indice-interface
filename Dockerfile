FROM php:8.1-fpm

# Instalar extensões e composer
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git unzip && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



RUN apt-get update && \
     apt-get install -y \
         libzip-dev \
         && docker-php-ext-install zip

# Definir diretório de trabalho
WORKDIR /var/www/html

# Copiar aplicação
COPY . /var/www/html

ARG COMPOSER_ALLOW_SUPERUSER=1


# Instalar dependências do Composer
RUN composer install --no-scripts
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]