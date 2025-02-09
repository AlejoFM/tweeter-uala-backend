## 🏗️ Arquitectura

Este proyecto implementa una arquitectura limpia (Clean Architecture) junto con Domain-Driven Design (DDD), siguiendo los principios SOLID. La estructura del proyecto está organizada en capas:

### Alto nivel de las Capas de la Arquitectura
```mermaid
graph TD
A[Presentation Layer] --> B[Application Layer]
B --> C[Domain Layer]
B --> D[Infrastructure Layer]
D --> C
```

#### 1. Presentation Layer (`src/*/Presentation/`)
- Controllers: Manejan las peticiones HTTP
- Resources: Transforman los datos para la respuesta
- Middleware: Validación y autenticación

#### 2. Application Layer (`src/*/App/`)
- FormRequest: Validación de datos
- Rules: Validaciones personalizadas para los FormRequest

#### 3. Domain Layer (`src/*/Domain/`)
- Entities: Modelos de dominio
- Value Objects: Objetos inmutables
- Repository Interfaces: Contratos para persistencia

#### 4. Infrastructure Layer (`src/*/Infrastructure/`)
- Repositories: Implementaciones de persistencia
- Persistence: Modelos Eloquent y Factories

### Patrones de Diseño Implementados
- Repository Pattern: Abstracción de la persistencia
- Decorator Pattern: Para el caching de repositorios
- Factory Pattern: Creación de objetos
- Resource Pattern: Transformación de datos

### Diagrama del flujo de los Timeline
```mermaid
graph TD
    A[HTTP Request] --> B[TimelineController]
    B --> C[GetForYouTimeline UseCase]
    C --> D[CachedForYouTimelineRepository]
    D --> |Cache Miss| E[EloquentForYouTimelineRepository]
    D --> |Cache Hit| F[(Redis)]
    E --> G[(MySQL)]
    E --> H[Tweet Domain Model]
    F --> I[TimelineResource]
    H --> I
    I --> J[HTTP Response]
```
### Capas y Responsabilidades

#### 1. Presentation Layer (`src/Timeline/Presentation/`)
- `TimelineController`: Recibe la petición HTTP y la delega al caso de uso
- `TimelineResource`: Transforma el modelo de dominio en JSON
- `TimelineCollection`: Maneja la paginación y metadata

#### 2. Application Layer (`src/Timeline/App/`)
- `GetForYouTimeline`: Orquesta la obtención del timeline
- `GetFollowingTimeline`: Orquesta la obtención del timeline de seguidos

#### 3. Domain Layer (`src/Timeline/Domain/`)
- `Tweet`: Modelo de dominio con reglas de negocio
- `ForYouTimelineRepositoryInterface`: Contrato para obtener el timeline
- `FollowingTimelineRepositoryInterface`: Contrato para timeline de seguidos

#### 4. Infrastructure Layer (`src/Timeline/Infrastructure/`)
- `CachedForYouTimelineRepository`: Implementa cache con Redis
- `EloquentForYouTimelineRepository`: Implementa persistencia con MySQL
- `TweetEloquentModel`: Modelo Eloquent para interacción con DB

## 🚀 Características

- Timeline "For You"
- Timeline "Following"
- Caché con Redis
- Paginación por cursor
- Tests automatizados
- Docker y Kubernetes para despliegue

## 🛠️ Tecnologías

- PHP 8.2
- Laravel 10
- Redis
- Docker
- Kubernetes
- MySQL

## 📦 Instalación

1. Clonar el repositorio
```bash
git clone https://github.com/AlejoFM/tweeter-uala-backend.git
```
2. Instalar dependencias
```bash
composer install
```
3. Configurar variables de entorno
```bash
cp .env.example .env
```
4. Generar key de aplicación
```bash
php artisan key:generate
```
5. Ejecutar migraciones
```bash
php artisan migrate
```
[ Opcional ] : Ejecutar seeders

```bash
php artisan db:seed
```
6. Ejecutar servidor

```bash
php artisan serve
```

## 🐳 Docker

### Desarrollo local
```bash
docker-compose up -d
```

### Despliegue en Kubernetes
```bash
./scripts/deploy.sh
```

### Entornos de despliegue 
- `kubectl apply -k k8s/environments/dev` : Desarrollo
- `kubectl apply -k k8s/environments/prod` : Producción

### Script de despliegue
```bash
./scripts/deploy.sh
```

## 🧪 Testing

### Execute all the tests
```bash
php artisan test
```

### Execute a specific module of tests
```bash
php artisan test tests/Tweet.php
php artisan test tests/User.php
php artisan test tests/Timeline.php
```

## 📚 Documentation

### Swagger
```bash
php artisan l5-swagger:generate
```
- The documentation is available at `/docs/swagger`

## 📈 Escalabilidad

- HPA (Horizontal Pod Autoscaling) configurado
- Caché distribuida con Redis
- Índices optimizados en MySQL
- Paginación eficiente por cursor

## Turn off the project
Kubernetes
```bash
kubectl delete deployments --all --all-namespaces
kubectl delete services --all --all-namespaces --field-selector metadata.name!=kubernetes
kubectl delete pods --all --all-namespaces
```
Docker
```bash
docker-compose down --volumes --remove-orphans
```

## Validate if the project turned off correctly
```bash
kubectl get pods --all-namespaces
docker ps
```

