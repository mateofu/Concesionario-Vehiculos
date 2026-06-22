# Concesionario Vehículos — Backend

API REST para el sistema de agendamiento de citas de un concesionario de vehículos, construida con **Laravel 13** siguiendo los principios de **Arquitectura Hexagonal (Ports & Adapters)** y **Domain-Driven Design (DDD)**.

---

## Características destacadas

- **Arquitectura Hexagonal real**: el dominio está aislado del framework. Laravel y Eloquent solo viven en la capa de Infraestructura.
- **Lógica de negocio no trivial**: validación de horarios operativos, periodos bloqueados y **detección de solapamiento de citas** sobre un mismo puesto de trabajo.
- **Modelo de dominio rico**: entidades, *Value Objects* (placa, centro de costo, estados de cita...) y eventos de dominio, en lugar de modelos anémicos.
- **Separación CQRS-ligera**: *Commands* + *Handlers* para escritura y *Queries* + *DTOs* para lectura.
- **Autenticación** con Laravel Sanctum (tokens Bearer) protegiendo todos los endpoints.
- **Paginación** uniforme en todos los listados.
- **Suite de pruebas** unitarias (dominio y casos de uso) y de integración (endpoints HTTP).
- **Entorno reproducible** con Docker (PHP-FPM + PostgreSQL + Nginx).

---

## Stack tecnológico

| Tecnología | Versión | Rol |
|---|---|---|
| PHP | 8.4 | Lenguaje |
| Laravel | 13 | Framework |
| PostgreSQL | 16 | Base de datos |
| Laravel Sanctum | 4.3 | Autenticación API |
| Docker + Docker Compose | — | Entorno de desarrollo |
| Nginx | — | Servidor web |
| PHPUnit | — | Pruebas unitarias e integración |

---

## Arquitectura

El proyecto sigue **Arquitectura Hexagonal** dividida en tres capas:

```
app/
├── Domain/              # Núcleo del negocio — sin dependencias externas
│   ├── Appointment/     # Entidades, Value Objects, interfaces de repositorio
│   ├── Workshop/
│   ├── Location/
│   ├── WorkStation/
│   ├── Technician/
│   ├── Vehicle/
│   ├── Owner/
│   ├── OperatingSchedule/
│   ├── BlockedPeriod/
│   └── Shared/ValueObjects/
│
├── Application/         # Casos de uso — orquesta el dominio
│   ├── Appointment/     # CreateAppointment, CancelAppointment, UpdateStatus...
│   ├── Workshop/        # CreateWorkshop, GetWorkshops...
│   └── Shared/          # PaginatedResult
│
└── Infrastructure/      # Adaptadores — implementaciones concretas
    ├── Http/
    │   ├── Controllers/ # Entrada HTTP
    │   ├── Requests/    # Validación de formularios
    │   └── Resources/   # Transformación de respuestas
    └── Persistence/
        └── Eloquent/
            ├── Models/       # Modelos Eloquent
            ├── Mappers/      # Domain ↔ Eloquent
            └── Repositories/ # Implementaciones de repositorios
```

**Principios aplicados:**
- Las interfaces de repositorio viven en el **Dominio**; las implementaciones Eloquent en **Infraestructura**
- Los handlers de la capa **Aplicación** nunca acceden directamente a la base de datos
- El dominio no tiene dependencias de Laravel ni de Eloquent

---

## Decisiones de diseño

Estas son las decisiones técnicas más relevantes y el razonamiento detrás de cada una:

- **Arquitectura Hexagonal en lugar del patrón MVC clásico de Laravel.** El objetivo es que la lógica de negocio sea independiente del framework: si mañana se cambia Eloquent por otro ORM, o Laravel por otro framework, el `Domain/` no se toca. El framework es un detalle de infraestructura, no el centro del sistema.

- **Modelo de dominio rico con *Value Objects*.** Conceptos como la placa de un vehículo, el centro de costo o el estado de una cita se modelan como objetos que validan sus propias invariantes al construirse. Esto evita estados inválidos y concentra las reglas en un solo lugar, en vez de dispersarlas en validaciones de controlador.

- **Mappers entre dominio y persistencia.** Las entidades de dominio no extienden de Eloquent. Un *Mapper* traduce entre la entidad pura y el modelo Eloquent, manteniendo el dominio limpio a costa de un poco más de código (un trade-off consciente a favor del desacoplamiento).

- **Commands/Handlers para escritura y Queries/DTOs para lectura.** Las operaciones de escritura expresan intención (`CreateAppointmentCommand`) y las de lectura devuelven DTOs planos en vez de entidades, optimizando cada camino por separado.

- **IDs autoincrementales en lugar de UUID.** Se priorizó la legibilidad y el control (IDs cortos `1, 2, 3...`) sobre la dispersión de UUID, dado que es un sistema interno de un concesionario y no requiere ofuscar identificadores ni generarlos en cliente.

- **Validación de solapamiento en el dominio, no en la base de datos.** La regla de "no dos citas activas en el mismo puesto a la misma hora" se resuelve consultando el repositorio y comparando rangos de tiempo, lo que permite devolver un error de negocio claro (`409 Conflict`) en vez de depender de una restricción de BD opaca.

- **Respuestas y códigos HTTP semánticos.** `409` para conflictos de solapamiento, `422` para validación/reglas de negocio, `404` para recursos inexistentes y `401` para autenticación, de forma que el frontend pueda reaccionar a cada caso sin parsear mensajes.

---

## Requisitos previos

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) instalado y corriendo
- Git

---

## Configuración y puesta en marcha

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd Concesionario-Vehiculos
```

### 2. Configurar variables de entorno

```bash
cp backend/.env.example backend/.env
```

Los valores por defecto ya están configurados para funcionar con Docker. No requieren cambios para desarrollo local.

### 3. Levantar los contenedores

```bash
docker compose up -d
```

Esto levanta tres contenedores:
- `app` — PHP-FPM 8.4 con Laravel
- `postgres` — PostgreSQL 16
- `nginx` — Servidor web en el puerto `8000`

### 4. Instalar dependencias

```bash
docker compose exec app composer install
```

### 5. Generar clave de aplicación

```bash
docker compose exec app php artisan key:generate
```

### 6. Ejecutar migraciones y seeders

```bash
docker compose exec app php artisan migrate:fresh --seed
```

Esto crea todas las tablas y carga datos de prueba incluyendo un usuario administrador.

### 7. Verificar que funciona

```bash
curl http://localhost:8000/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"admin@taller.co","password":"password"}'
```

---

## Autenticación

La API usa **Laravel Sanctum** con tokens Bearer.

### Login

```http
POST /api/v1/auth/login
Content-Type: application/json

{
  "email": "admin@taller.co",
  "password": "password"
}
```

Respuesta:
```json
{
  "message": "Sesión iniciada exitosamente.",
  "token": "1|abc123...",
  "user": { "id": 1, "name": "Admin", "email": "admin@taller.co" }
}
```

### Uso del token

Incluir en todos los requests protegidos:
```
Authorization: Bearer {token}
```

### Logout

```http
POST /api/v1/auth/logout
Authorization: Bearer {token}
```

---

## Endpoints de la API

Base URL: `http://localhost:8000/api/v1`

Todos los endpoints excepto `/auth/login` requieren el header `Authorization: Bearer {token}`.

> **Jerarquía:** Sede → Taller → Puesto de trabajo. Una sede tiene varios talleres, y cada taller tiene varios puestos.

### Sedes

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/locations` | Listar sedes (paginado) |
| POST | `/locations` | Crear sede |
| GET | `/locations/{id}` | Ver sede por ID |

### Talleres

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/workshops` | Listar talleres (paginado, filtro: `?location_id=1`) |
| POST | `/workshops` | Crear taller (requiere `location_id` de la sede) |
| GET | `/workshops/{id}` | Ver taller por ID |

### Horarios operativos

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/locations/{id}/schedules` | Listar horarios de una sede |
| POST | `/locations/{id}/schedules` | Crear/actualizar horario |

### Periodos bloqueados

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/locations/{id}/blocked-periods` | Listar periodos bloqueados |
| POST | `/locations/{id}/blocked-periods` | Crear periodo bloqueado |

### Puestos de trabajo

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/work-stations` | Listar puestos (paginado, filtro: `?workshop_id=1`) |
| POST | `/work-stations` | Crear puesto (requiere `workshop_id` del taller) |
| GET | `/work-stations/{id}` | Ver puesto por ID |
| POST | `/work-stations/{id}/technicians` | Asignar técnico a puesto |

### Técnicos

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/technicians` | Listar técnicos (paginado) |
| POST | `/technicians` | Crear técnico |
| GET | `/technicians/{id}` | Ver técnico por ID |

### Propietarios

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/owners` | Listar propietarios (paginado) |
| POST | `/owners` | Crear propietario |
| GET | `/owners/{id}` | Ver propietario por ID |

### Vehículos

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/vehicles` | Listar vehículos (paginado, filtro: `?owner_id=1`) |
| POST | `/vehicles` | Crear vehículo |
| GET | `/vehicles/{id}` | Ver vehículo por ID |

### Citas

| Método | Ruta | Descripción |
|---|---|---|
| GET | `/appointments` | Listar citas (paginado, filtros: `status`, `technician_id`, `vehicle_id`, `date`) |
| POST | `/appointments` | Crear cita |
| GET | `/appointments/{id}` | Ver cita por ID |
| PATCH | `/appointments/{id}/status` | Actualizar estado |
| DELETE | `/appointments/{id}` | Cancelar cita |

Ejemplo de creación de cita:

```http
POST /api/v1/appointments
Authorization: Bearer {token}
Content-Type: application/json

{
  "vehicle_id": 1,
  "technician_id": 1,
  "work_station_id": 1,
  "scheduled_at": "2026-07-01 09:00:00",
  "duration_minutes": 60,
  "notes": "Cambio de aceite y revisión general"
}
```

Si el puesto ya tiene una cita en ese rango horario, la API responde `409 Conflict`. Si la hora cae fuera del horario operativo de la sede o dentro de un periodo bloqueado, responde `422`.

### Paginación

Todos los listados soportan paginación mediante query params:

```
GET /api/v1/workshops?page=2&per_page=10
```

Respuesta:
```json
{
  "data": [...],
  "meta": {
    "total": 48,
    "per_page": 10,
    "current_page": 2,
    "last_page": 5
  }
}
```

Por defecto: `page=1`, `per_page=15`.

---

## Reglas de negocio

- Una cita solo puede agendarse dentro del horario operativo de la sede
- No se pueden agendar citas en periodos bloqueados (feriados, mantenimiento)
- No puede haber dos citas activas en el mismo puesto de trabajo al mismo tiempo (validación de solapamiento)
- Transiciones de estado permitidas: `programada → confirmada → atendida`, `programada/confirmada → cancelada`

### Códigos de respuesta de error

| Código | Causa |
|---|---|
| 401 | Token ausente o inválido |
| 404 | Recurso no encontrado |
| 409 | Conflicto — solapamiento de citas |
| 422 | Validación fallida o regla de negocio violada |

---

## Pruebas

```bash
docker compose exec app php artisan test
```

Para correr solo pruebas unitarias:
```bash
docker compose exec app php artisan test --testsuite=Unit
```

Para correr solo pruebas de integración:
```bash
docker compose exec app php artisan test --testsuite=Feature
```

Las pruebas de Feature usan SQLite en memoria — no afectan la base de datos de desarrollo.

### Estructura de pruebas

```
tests/
├── Unit/
│   ├── Domain/
│   │   ├── Shared/          # IntIdValueObject
│   │   ├── Workshop/        # WorkshopName, CostCenter
│   │   ├── Vehicle/         # LicensePlate
│   │   ├── Appointment/     # AppointmentStatus, Appointment
│   │   └── OperatingSchedule/  # containsSlot — lógica de horarios
│   └── Application/
│       ├── Workshop/        # CreateWorkshopHandler
│       └── Appointment/     # CreateAppointmentHandler (todos los caminos de error)
└── Feature/
    ├── AuthTest.php         # Login, logout, protección de rutas
    └── WorkshopsTest.php    # CRUD endpoints con autenticación
```

---

## Comandos útiles

```bash
# Ver logs de la aplicación
docker compose exec app tail -f storage/logs/laravel.log

# Limpiar caché
docker compose exec app php artisan optimize:clear

# Ver rutas registradas
docker compose exec app php artisan route:list

# Acceder al contenedor PHP
docker compose exec app bash

# Detener contenedores
docker compose down

# Detener y eliminar volúmenes (resetea la base de datos)
docker compose down -v
```
