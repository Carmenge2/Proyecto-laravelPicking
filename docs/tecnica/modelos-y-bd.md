# Modelos y base de datos

Documentación de las tablas, campos, relaciones Eloquent y migraciones del proyecto.

## Resumen de modelos

| Modelo | Tabla | Archivo |
|--------|-------|---------|
| `User` | `users` | `app/Models/User.php` |
| `Cliente` | `clientes` | `app/Models/Cliente.php` |
| `Pedido` | `pedidos` | `app/Models/Pedido.php` |
| `Producto` | `productos` | `app/Models/Producto.php` |
| `CategoriasProductos` | `categorias_productos` | `app/Models/CategoriasProductos.php` |

## Detalle de cada modelo

### User

| Campo | Tipo | Notas |
|-------|------|-------|
| `id` | bigint (PK) | Auto-incremental |
| `name` | string | Nombre completo |
| `email` | string (unique) | Correo electrónico |
| `email_verified_at` | timestamp (nullable) | Fecha de verificación |
| `password` | string | Hash bcrypt |
| `rol` | enum(`admin`, `comercial`) | Default: `comercial` |
| `remember_token` | string | Token "recuérdame" |
| `created_at` / `updated_at` | timestamps | — |

**Fillable:** `name`, `email`, `password`, `rol`

**Relaciones:** Ninguna definida explícitamente en el modelo (pero es referenciado como FK desde `clientes` y `pedidos`).

---

### Cliente

| Campo | Tipo | Notas |
|-------|------|-------|
| `id` | bigint (PK) | Auto-incremental |
| `comercial_id` | bigint (FK → users) | Comercial asignado |
| `nombre_comercial` | string | Nombre comercial del cliente |
| `razon_social` | string | Razón social |
| `email` | string (nullable) | Correo de contacto |
| `telefono` | string (nullable) | Teléfono |
| `direccion` | string (nullable) | Dirección postal |
| `tipo_negocio` | string (nullable) | Tipo de negocio |
| `created_at` / `updated_at` | timestamps | — |

**Fillable:** `nombre_comercial`, `razon_social`, `email`, `telefono`, `direccion`, `tipo_negocio`, `comercial_id`

**Relaciones:**

| Método | Tipo | Modelo relacionado | FK |
|--------|------|-------------------|-----|
| `pedidos()` | hasMany | Pedido | `cliente_id` |
| `comercial()` | belongsTo | User | `comercial_id` |

---

### Pedido

| Campo | Tipo | Notas |
|-------|------|-------|
| `id` | bigint (PK) | Auto-incremental |
| `cliente_id` | bigint (FK → clientes) | Cliente del pedido |
| `comercial_id` | bigint (FK → users) | Comercial que crea el pedido |
| `fecha` | date | Fecha del pedido |
| `cantidad` | integer | Default 1 |
| `total` | decimal(10,2) | Total calculado |
| `estado` | enum(`pendiente`, `enviado`, `cancelado`) | Default: `pendiente` |
| `created_at` / `updated_at` | timestamps | — |

**Fillable:** `cliente_id`, `cantidad`, `total`, `estado`, `comercial_id`, `fecha`

**Relaciones:**

| Método | Tipo | Modelo relacionado | Notas |
|--------|------|-------------------|-------|
| `cliente()` | belongsTo | Cliente | — |
| `comercial()` | belongsTo | User | FK: `comercial_id` |
| `productos()` | belongsToMany | Producto | Pivote: `pedido_producto` con `cantidad` |

---

### Producto

| Campo | Tipo | Notas |
|-------|------|-------|
| `id` | bigint (PK) | Auto-incremental |
| `categoria_id` | bigint (FK → categorias_productos) | Categoría del producto |
| `nombre` | string (unique) | Nombre del producto |
| `descripcion` | text (nullable) | Descripción |
| `precio` | decimal(8,2) | Precio unitario |
| `stock` | integer | Unidades disponibles |
| `estado` | enum(`disponible`, `agotado`, `pre-venta`) | Default: `disponible` |
| `imagen` | string (nullable) | Ruta en storage |
| `created_at` / `updated_at` | timestamps | — |

**Fillable:** `nombre`, `descripcion`, `precio`, `stock`, `estado`, `categoria_id`, `imagen`

**Relaciones:**

| Método | Tipo | Modelo relacionado | Notas |
|--------|------|-------------------|-------|
| `pedidos()` | belongsToMany | Pedido | Pivote con `cantidad` |
| `categoria()` | belongsTo | CategoriasProductos | FK: `categoria_id` |

---

### CategoriasProductos

| Campo | Tipo | Notas |
|-------|------|-------|
| `id` | bigint (PK) | Auto-incremental |
| `nombre` | string | Nombre de la categoría |
| `imagen` | string (nullable) | Imagen de la categoría |
| `created_at` / `updated_at` | timestamps | — |

**Fillable:** `nombre`, `imagen`

**Relaciones:**

| Método | Tipo | Modelo relacionado | Notas |
|--------|------|-------------------|-------|
| `productos()` | hasMany | Producto | FK: `categoria_id` |

## Tabla pivote: `pedido_producto`

| Campo | Tipo | Notas |
|-------|------|-------|
| `id` | bigint (PK) | Auto-incremental |
| `pedido_id` | bigint (FK → pedidos) | — |
| `producto_id` | bigint (FK → productos) | — |
| `cantidad` | integer | Unidades de ese producto en el pedido |
| `created_at` / `updated_at` | timestamps | — |

## Listado de migraciones

| Archivo | Qué hace |
|---------|----------|
| `0001_01_01_000000_create_users_table.php` | Crea `users`, `password_reset_tokens`, `sessions` |
| `0001_01_01_000001_create_cache_table.php` | Tabla de cache |
| `0001_01_01_000002_create_jobs_table.php` | Tablas de colas |
| `2025_04_18_133134_create_clientes_table.php` | Tabla `clientes` |
| `2025_04_18_133148_create_productos_table.php` | Tabla `productos` (versión inicial) |
| `2025_04_18_133158_create_pedidos_table.php` | Tabla `pedidos` |
| `2025_04_19_203722_modify_productos_table.php` | Modificaciones a productos |
| `2025_05_15_075836_create_pedido_producto_table.php` | Tabla pivote N:M |
| `2025_11_19_204422_add_imagen_to_productos_table.php` | Añade campo `imagen` |
| `2026_01_22_172947_create_categorias_productos_table.php` | Tabla `categorias_productos` |
| `2026_01_22_173325_add_categoria_id_to_productos_table.php` | Añade FK `categoria_id` |

## Cómo añadir un nuevo modelo

```bash
# 1. Crear modelo + migración + factory + seeder
php artisan make:model NuevoModelo -mfs

# 2. Definir campos en la migración
# 3. Definir $fillable y relaciones en el modelo
# 4. Ejecutar migración
php artisan migrate

# 5. Documentar en este archivo
```
