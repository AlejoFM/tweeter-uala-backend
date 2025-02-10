#!/bin/bash

# Esperar a que MySQL esté disponible
while ! nc -z db 3306; do
    echo "🚀 Esperando a que MySQL esté disponible..."
    sleep 1
done

# Esperar a que Redis esté disponible
while ! nc -z redis 6379; do
    echo "🚀 Esperando a que Redis esté disponible..."
    sleep 1
done

# Limpiar cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Migraciones y seeders
php artisan migrate:fresh --seed --force

# Generar documentación
php artisan l5-swagger:generate

# Optimizar
php artisan optimize
php artisan config:cache
php artisan route:cache

# Iniciar PHP-FPM
php-fpm 

# Iniciar Apache
apache2-foreground