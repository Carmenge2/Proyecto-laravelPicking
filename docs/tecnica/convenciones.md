# Convenciones y estilo de código

Reglas de naming, estructura y estilo seguidas en este proyecto.

## Naming conventions

### Modelos

| Regla | Ejemplo |
|-------|---------|
| Nombre en **singular**, **PascalCase** | `Cliente`, `Pedido`, `Producto` |
| Si es compuesto, ambas palabras | `CategoriasProductos` |

> **Nota:** el modelo `CategoriasProductos` usa plural, lo cual no es estándar en Laravel (que espera singular). Se mantiene por compatibilidad con la tabla.

### Tablas de base de datos

| Regla | Ejemplo |
|-------|---------|
| Nombre en **plural**, **snake_case** | `clientes`, `pedidos`, `productos` |
| Tabla pivote: ambos modelos en singular, orden alfabético | `pedido_producto` |
| Tabla de categorías (excepción) | `categorias_productos` |

### Controladores

| Regla | Ejemplo |
|-------|---------|
| Nombre del modelo + `Controller`, **PascalCase** | `ClienteController` |
| Agrupados por rol en subcarpetas | `Admin/DashboardController` |

### Rutas

| Regla | Ejemplo |
|-------|---------|
| Nombres con **dot notation** | `clientes.index`, `admin.dashboard` |
| Prefijos por módulo | `comercial.*`, `admin.*`, `catalogo.*` |
| URIs en **plural**, **kebab-case** | `/clientes`, `/pedidos`, `/admin/trabajadores` |

### Vistas (Blade)

| Regla | Ejemplo |
|-------|---------|
| Carpeta = recurso (plural) | `views/clientes/`, `views/pedidos/` |
| Archivo = acción | `index.blade.php`, `create.blade.php`, `edit.blade.php` |
| Layouts en carpeta propia | `views/layouts/` |
| Componentes en carpeta propia | `views/components/` |

### Variables

| Contexto | Convención | Ejemplo |
|----------|-----------|---------|
| Variable de colección | plural | `$clientes`, `$pedidos` |
| Variable de instancia | singular | `$cliente`, `$pedido` |
| Campo de BD | snake_case | `nombre_comercial`, `comercial_id` |
| Método de relación | camelCase | `comercial()`, `productos()` |

## Estructura de carpetas del código

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/           → Controllers exclusivos del panel admin
│   │   ├── Auth/            → Controllers de autenticación (Breeze)
│   │   └── *.php            → Controllers generales (CRUD)
│   └── Middleware/          → Middlewares personalizados
├── Models/                  → Modelos Eloquent
└── Providers/               → Service Providers

database/
├── factories/               → Factories para testing
├── migrations/              → Migraciones (schema versionado)
└── seeders/                 → Datos iniciales/prueba

resources/
└── views/
    ├── admin/               → Vistas del panel admin
    ├── auth/                → Vistas de autenticación (Breeze)
    ├── clientes/            → CRUD de clientes
    ├── comercial/           → Vistas del panel comercial
    ├── components/          → Componentes Blade reutilizables
    ├── layouts/             → Layouts base
    ├── pedidos/             → CRUD de pedidos
    └── productos/           → CRUD de productos + catálogo

routes/
├── web.php                  → Rutas principales
├── auth.php                 → Rutas de autenticación
└── console.php              → Comandos Artisan personalizados
```

## Estilo de código PHP

El proyecto usa **Laravel Pint** (configuración por defecto = PSR-12).

Ejecutar el formateador:

```bash
./vendor/bin/pint
```

### Reglas principales

- Indentación: **4 espacios** (no tabs).
- Llaves de apertura: en la **misma línea** para métodos y control.
- `use` statements ordenados alfabéticamente.
- Una clase por archivo.
- Tipo de retorno declarado cuando es posible.

## Patrones comunes en el proyecto

### Validación inline

```php
$data = $request->validate([
    'campo' => 'required|string|max:255',
]);
```

> No se usan Form Request classes separadas. Para proyectos más grandes, considerar migrar a `php artisan make:request`.

### Respuesta tras mutación

```php
return redirect()
    ->route('recurso.index')
    ->with('success', 'Mensaje descriptivo.');
```

### Eager loading para evitar N+1

```php
$pedidos = Pedido::with(['cliente', 'productos', 'comercial'])->paginate(10);
```

### Subida de archivos

```php
if ($request->hasFile('imagen')) {
    $data['imagen'] = $request->file('imagen')->store('carpeta', 'public');
}
```

## Buenas prácticas Laravel 12 aplicadas

- **Configuración de middleware en `bootstrap/app.php`** (no en Kernel.php, eliminado en L12).
- **Typed properties y return types** donde es posible.
- **Route model binding implícito** (`function show(Cliente $cliente)`).
- **Soft-delete**: no implementado actualmente pero recomendado para producción.
- **Colas**: configuradas (`queue:listen`) aunque no se usan jobs personalizados aún.
