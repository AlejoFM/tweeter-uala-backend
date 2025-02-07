# Proyecto de API para la evaluación técnica de UALA.

## Instalación

1. Clonar el repositorio.
2. Ejecutar el comando `php artisan install` para instalar las dependencias.
3. Ejecutar el comando `php artisan serve` para iniciar el servidor.

## Endpoints




## Desarrollo local con docker-compose

## Build y push de la imagen con el script

## Despliegue en Kubernetes
### Con HPA para escalar el número de pods en función de la carga de la CPU

# Para desarrollo
kubectl apply -k k8s/environments/dev

# Para producción
kubectl apply -k k8s/environments/prod

# O usando el script
./scripts/deploy.sh
# Y seleccionar 'dev' o 'prod'