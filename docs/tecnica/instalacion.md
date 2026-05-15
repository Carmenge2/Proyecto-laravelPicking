# Manual de instalación

Guía paso a paso para configurar el entorno de desarrollo del proyecto.

## Requisitos previos

| Software | Versión mínima | Comprobación |
|----------|---------------|--------------|
| PHP | 8.2 | `php -v` |
| Composer | 2.x | `composer --version` |
| Node.js | 18.x | `node -v` |
| npm | 9.x | `npm -v` |
| MySQL / PostgreSQL / SQLite | Cualquiera compatible | `mysql --version` |
| Git | 2.x | `git --version` |

### Extensiones PHP requeridas

- `php-mbstring`
- `php-xml`
- `php-curl`
- `php-zip`
- `php-pdo` + driver de tu BD (ej. `php-mysql`, `php-sqlite3`)

## Pasos de instalación

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd ProyectoLaravel
```

### 2. Instalar dependencias PHP

```bash
composer install
```

### 3. Instalar dependencias JavaScript

```bash
npm install
```

### 4. Configurar variables de entorno

```bash
cp .env.example .env
```

Editar `.env` y configurar al menos:

```dotenv
APP_NAME="Laravel Picking"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_picking
DB_USERNAME=root
DB_PASSWORD=tu_password
```

> **SQLite alternativo**: si prefieres SQLite para desarrollo rápido:
> ```dotenv
> DB_CONNECTION=sqlite
> # DB_DATABASE se auto-configura a database/database.sqlite
> ```
> Crear el archivo: `touch database/database.sqlite`

### 5. Generar clave de aplicación

```bash
php artisan key:generate
```

### 6. Ejecutar migraciones

```bash
php artisan migrate
```

Para recrear la BD desde cero con datos de prueba (si existen seeders):

```bash
php artisan migrate:fresh --seed
```

### 7. Enlace de storage (para imágenes)

```bash
php artisan storage:link
```

Esto crea un enlace simbólico `public/storage -> storage/app/public` para servir las imágenes subidas.

### 8. Levantar el entorno de desarrollo

**Opción A — Todo junto (recomendado):**

```bash
composer run dev
```

Esto levanta simultáneamente:

| Proceso | Puerto/función |
|---------|---------------|
| `php artisan serve` | Servidor web en `localhost:8000` |
| `php artisan queue:listen` | Procesador de colas |
| `php artisan pail` | Logs en tiempo real |
| `npm run dev` | Vite HMR en `localhost:5173` |

**Opción B — Manual (terminales separadas):**

```bash
# Terminal 1
php artisan serve

# Terminal 2
npm run dev
```

### 9. Acceder a la aplicación

- URL: `http://localhost:8000`
- Login: crear usuario vía `/register` o mediante seeder.

## Troubleshooting

| Problema | Solución |
|----------|----------|
| `SQLSTATE[HY000]: No such file or directory` | Verificar que `DB_HOST` usa `127.0.0.1` en vez de `localhost` |
| `Vite manifest not found` | Ejecutar `npm run build` o asegurarse de que `npm run dev` está corriendo |
| `Permission denied` en storage | `chmod -R 775 storage bootstrap/cache` (Linux/Mac) |
| `Class not found` tras pull | Ejecutar `composer dump-autoload` |
| Puerto 8000 ocupado | `php artisan serve --port=8080` |

## Build de producción

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```
