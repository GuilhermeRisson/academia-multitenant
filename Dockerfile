FROM php:8.3-fpm

# Instala dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring exif pcntl bcmath

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Cria diretório da aplicação
WORKDIR /var/www/html

# Permite usar os arquivos locais no container
COPY . /var/www/html

# Dá permissão
RUN chown -R www-data:www-data /var/www/html

# Exposição da porta
EXPOSE 9000

CMD ["php-fpm"]
