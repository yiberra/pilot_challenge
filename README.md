# Pilot Challenge - CMS Modular API

API RESTful desarrollada en Symfony para la gestión de artículos, categorías y usuarios dentro de un sistema CMS modular.

## Características

- Gestión completa de artículos (CRUD)
- Gestión completa de categorías (CRUD)
- Gestión completa de usuarios (CRUD)
- Autenticación basada en JWT
- Validaciones de negocio
- Relaciones entre entidades mediante Doctrine ORM
- Arquitectura desacoplada utilizando patrón Repository
- API RESTful con respuestas JSON
- Base de datos relacional mediante Doctrine

---

## Tecnologías utilizadas

- PHP 8.3+
- Symfony 7
- Doctrine ORM
- MySQL
- LexikJWTAuthenticationBundle

---

## Requisitos

- PHP 8.3 o superior
- Composer
- MySQL 8+ (o compatible)
- Symfony CLI (opcional)

---

## Instalación

### 1. Clonar el repositorio

```bash
git clone <repository-url>
cd api_rest
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar variables de entorno

Crear o modificar el archivo `.env`:

```env
DATABASE_URL="mysql://user:password@127.0.0.1:3306/api_rest?serverVersion=8.0"

JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=your_passphrase
```

### 4. Crear la base de datos

```bash
php bin/console doctrine:database:create
```

### 5. Ejecutar migraciones

```bash
php bin/console doctrine:migrations:migrate
```

### 6. Generar claves JWT

```bash
php bin/console lexik:jwt:generate-keypair
```

### 7. Iniciar el servidor

```bash
symfony server:start
```

o

```bash
php -S localhost:8000 -t public
```

La API estará disponible en:

```text
http://localhost:8000
```

---

# Modelo de Datos

## User

| Campo | Tipo |
|---------|---------|
| id | integer |
| name | string |
| email | string |
| role | admin / user |
| status | active / inactive |

---

## ArticleCategory

| Campo | Tipo |
|---------|---------|
| id | integer |
| name | string |
| description | text |
| status | active / inactive |

---

## Article

| Campo | Tipo |
|---------|---------|
| id | integer |
| title | string |
| content | text |
| slug | string |
| status | draft / published |
| published_date | date |
| author | User |
| categories | Collection<ArticleCategory> |

---

# Autenticación

## Obtener token

### Request

```http
POST /api/login
```

```json
{
  "email": "admin@example.com",
  "password": "password"
}
```

### Response

```json
{
  "token": "jwt_token"
}
```

### Uso del token

```http
Authorization: Bearer <jwt_token>
```

---

# Endpoints

## Users

| Método | Endpoint | Descripción |
|----------|----------|----------|
| GET | `/api/user` | Listar usuarios |
| GET | `/api/user/{id}` | Obtener usuario |
| POST | `/api/user/new` | Crear usuario |
| PUT | `/api/user/{id}/edit` | Actualizar usuario |
| DELETE | `/api/user/{id}` | Eliminar usuario |

---

## ArticleCategory

| Método | Endpoint | Descripción |
|----------|----------|----------|
| GET | `/api/article/category` | Listar categorías |
| GET | `/api/article/category/{id}` | Obtener categoría |
| POST | `/api/article/category/new` | Crear categoría |
| PUT | `/api/article/category/{id}/edit` | Actualizar categoría |
| DELETE | `/api/article/category/{id}` | Eliminar categoría |

---

## Articles

| Método | Endpoint | Descripción |
|----------|----------|----------|
| GET | `/api/article` | Listar artículos |
| GET | `/api/article/{id}` | Obtener artículo |
| POST | `/api/article/new` | Crear artículo |
| PUT | `/api/article/{id}/edit` | Actualizar artículo |
| DELETE | `/api/article/{id}` | Eliminar artículo |

### Ejemplo de creación de artículo

```json
{
  "title": "Primer artículo",
  "content": "Contenido del artículo",
  "status": "published",
  "authorId": 1,
  "categoryIds": [1, 2]
}
```

---

# Códigos HTTP

| Código | Descripción |
|----------|----------|
| 200 | OK |
| 201 | Created |
| 204 | No Content |
| 400 | Bad Request |
| 401 | Unauthorized |
| 403 | Forbidden |
| 404 | Not Found |
| 409 | Conflict |
| 500 | Internal Server Error |

---

# Patrones de Diseño

## Repository Pattern

Se implementó el patrón Repository mediante Doctrine para encapsular el acceso a datos y desacoplar la lógica de persistencia de la lógica de negocio.

Repositorios implementados:

- ArticleRepository
- CategoryRepository
- UserRepository
