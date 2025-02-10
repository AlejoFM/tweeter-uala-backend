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
    netcat-openbsd \
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd
RUN pecl install redis && docker-php-ext-enable redis

# Configurar directorio de trabajo
WORKDIR /var/www

# Copiar composer.lock y composer.json
COPY composer.json composer.lock ./

# Instalar dependencias
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-scripts --no-autoloader

# Copiar el código de la aplicación
COPY . .

# Generar autoloader y optimizar
RUN composer dump-autoload --optimize

# Permisos para Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

COPY .env.example /var/www/.env 

COPY .env.example /var/www/.env.testing 

# Configuración de Apache
COPY ./docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Copiar script de inicialización
COPY docker/scripts/init.sh /usr/local/bin/init.sh
RUN chmod +x /usr/local/bin/init.sh

RUN sed -i 's/DB_DATABASE=.*/DB_DATABASE=tweeter-uala-db/g' /var/www/.env.testing

# Generar key de aplicación
RUN php artisan key:generate

# Generar documentación Swagger
RUN php artisan l5-swagger:generate

# Limpiar cache
RUN php artisan cache:clear
RUN php artisan config:clear
RUN php artisan route:clear

# Optimizar
RUN php artisan optimize
RUN php artisan config:cache
RUN php artisan route:cache

EXPOSE 80

CMD ["/usr/local/bin/init.sh"]