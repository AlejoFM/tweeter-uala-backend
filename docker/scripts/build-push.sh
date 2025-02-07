#!/bin/bash

# Variables de entorno
REGISTRY="your-registry.com"  # Ejemplo: gcr.io/your-project
VERSION=$(git rev-parse --short HEAD)  # Usa el hash del commit como versión
ENV="prod"  # o staging

# Construir la imagen
docker build -t twitter-clone-app:${VERSION} .

# Tagear para el registro
docker tag twitter-clone-app:${VERSION} ${REGISTRY}/twitter-clone-app:${VERSION}
docker tag twitter-clone-app:${VERSION} ${REGISTRY}/twitter-clone-app:latest

# Pushear al registro
docker push ${REGISTRY}/twitter-clone-app:${VERSION}
docker push ${REGISTRY}/twitter-clone-app:latest

echo "Imagen pusheada: ${REGISTRY}/twitter-clone-app:${VERSION}"