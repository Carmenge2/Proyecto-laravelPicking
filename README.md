# Proyecto Laravel Picking

Sistema web de gestión comercial para catálogo de productos, clientes y pedidos con control de acceso por roles.

## Características principales

| Módulo              | Descripción                                                          |
| ---------------------| ----------------------------------------------------------------------|
| **Catálogo**        | Navegación por categorías y ficha de producto (requiere login)       |
| **Panel comercial** | CRUD de clientes y pedidos, cálculo automático de totales            |
| **Panel admin**     | Gestión de trabajadores, productos (con imágenes) y categorías       |
| **Autenticación**   | Login, registro, recuperación de contraseña y verificación de email  |
| **Roles**           | Control de acceso `admin` / `comercial` con middleware personalizado |

## Stack tecnológico

| Capa          | Tecnología                            |
| ---------------| ---------------------------------------|
| Backend       | PHP 8.2 · Laravel 12 · Laravel Breeze |
| Frontend      | Vite · TailwindCSS · Alpine.js        |
| Base de datos | MySQL / SQLite (configurable)         |
| Herramientas  | Composer · npm · Artisan              |

## Instalación rápida

```bash
# 1. Clonar el repositorio
git clone <url-del-repo> && cd ProyectoLaravel

# 2. Instalar dependencias
composer install
npm install

# 3. Configurar entorno
cp .env.example .env
php artisan key:generate

# 4. Migrar base de datos
php artisan migrate

# 5. Levantar entorno de desarrollo
composer run dev
```

> El script `composer run dev` levanta simultáneamente: servidor, cola, logs y Vite.

## Requisitos del sistema

- PHP `>= 8.2`
- Composer `>= 2.x`
- Node.js `>= 18.x` + npm
- Motor de BD compatible con Laravel (MySQL, PostgreSQL, SQLite)

## Scripts disponibles

| Comando | Descripción |
|---------|-------------|
| `composer run dev` | Levanta servidor + queue + pail + vite en paralelo |
| `npm run dev` | Vite en modo desarrollo |
| `npm run build` | Build de producción de assets |
| `php artisan migrate` | Ejecutar migraciones pendientes |
| `php artisan migrate:fresh --seed` | Recrear BD con datos de prueba |

## Documentación

La documentación completa del proyecto está disponible en la carpeta [`/docs`](./docs/README.md):

- **Arquitectura y diagramas** — visión técnica del sistema
- **Documentación técnica** — instalación, modelos, controladores, convenciones
- **Manuales de usuario** — guías para administradores y comerciales
- **Mantenimiento** — estrategia de actualización y plantillas

## Estructura del proyecto (resumen)

```
app/
├── Http/Controllers/       → Lógica de negocio (Admin, Auth, CRUD)
├── Http/Middleware/         → Control de acceso por roles
└── Models/                  → Eloquent: User, Cliente, Pedido, Producto, Categoría
database/migrations/         → Esquema de BD versionado
resources/views/             → Vistas Blade + layouts
routes/
├── web.php                  → Rutas principales
└── auth.php                 → Rutas de autenticación (Breeze)
```

## Licencia

Este proyecto es software propietario. Todos los derechos reservados.
