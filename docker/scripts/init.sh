#!/bin/bash

# Esperar a que MySQL esté listo
echo "Waiting for MySQL to be ready..."
while ! nc -z mysql 3306; do
    sleep 1
done

cd /var/www

# Instalar dependencias si no están instaladas
if [ ! -d "vendor" ]; then
    composer install --no-interaction
fi

# Generar key si no existe
if [ ! -f ".env" ]; then
    cp .env.example .env
    php artisan key:generate
fi

# Ejecutar migraciones
php artisan migrate --force

# Iniciar PHP-FPM
php-fpm 