# Dockerfile
FROM php:8.2-fpm

# Instalar dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    netcat-openbsd

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar composer.json primero
COPY composer.json composer.lock ./

# Instalar dependencias
RUN composer install --no-scripts --no-autoloader

# Copiar el resto de los archivos
COPY . .

COPY .env.example /var/www/.env 

COPY .env.example /var/www/.env.testing 

# Configuración de Apache
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar script de inicialización
COPY docker/scripts/init.sh /usr/local/bin/init.sh
RUN chmod +x /usr/local/bin/init.sh

# Generar autoload y dar permisos
RUN composer dump-autoload \
    && chown -R www-data:www-data storage bootstrap/cache

RUN sed -i 's/DB_DATABASE=.*/DB_DATABASE=EventReservationApp_local/g' /var/www/.env.testing


EXPOSE 80

CMD ["/usr/local/bin/init.sh"]