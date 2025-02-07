#!/bin/bash
set -e

# Función para manejar errores
handle_error() {
    echo "Error en la línea $1"
    read -p "Presiona Enter para continuar..."
}

trap 'handle_error $LINENO' ERR

# Construir la imagen Docker
echo "Construyendo imagen Docker..."
docker build -t twitter-clone-app:latest .

# Seleccionar ambiente
echo "Selecciona el ambiente (dev/prod):"
read ENV

# Aplicar configuración con Kustomize
echo "Aplicando configuración de $ENV..."
kubectl apply -k k8s/environments/$ENV

# Verificar el estado
echo "Verificando estado..."
kubectl get pods -n twitter-app-$ENV
kubectl get services -n twitter-app-$ENV

echo "Despliegue completado en ambiente $ENV"
read -p "Presiona Enter para cerrar..."