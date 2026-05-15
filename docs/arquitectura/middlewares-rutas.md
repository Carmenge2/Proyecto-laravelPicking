# Middlewares y rutas

Documentación detallada del sistema de routing, middlewares personalizados y su registro.

## Middleware personalizado: `RedirectBasedOnRole`

**Archivo:** `app/Http/Middleware/RedirectBasedOnRole.php`

**Alias:** `role`

**Registro:** `bootstrap/app.php`

### Comportamiento

El middleware tiene dos funciones según cómo se invoque:

| Uso | Ejemplo | Qué hace |
|-----|---------|----------|
| Sin parámetros (stack web) | Se aplica a todas las rutas web | Si la ruta es `dashboard` y está autenticado, redirige al panel de su rol |
| Con parámetros | `middleware('role:admin')` | Verifica que el rol del usuario está en la lista permitida; si no, redirige a su panel |

### Lógica interna (pseudocódigo)

```
SI la ruta es "dashboard" Y usuario autenticado:
    SI rol == admin → redirect admin.dashboard
    SINO → redirect comercial.dashboard

SI se pasaron roles como parámetro Y usuario autenticado:
    roles_permitidos = split(parametro, "|" o ",")
    SI usuario.rol NO está en roles_permitidos:
        SI rol == admin → redirect admin.dashboard
        SINO → redirect comercial.dashboard

Continuar con la petición normal
```

### Registro en `bootstrap/app.php`

```php
->withMiddleware(function (Middleware $middleware) {
    // Se añade al stack web (se ejecuta en TODAS las rutas web)
    $middleware->web(append: [
        App\Http\Middleware\RedirectBasedOnRole::class,
    ]);

    // Se registra como alias para uso explícito en rutas
    $middleware->alias([
        'role' => \App\Http\Middleware\RedirectBasedOnRole::class,
    ]);
})
```

## Tabla de rutas completa

### Rutas públicas (sin autenticación)

| Método | URI | Controller@Método | Nombre | Middleware |
|--------|-----|-------------------|--------|-----------|
| GET | `/` | — (closure → login) | — | web |
| GET | `/catalogo` | CategoriaProductoController@index | `catalogo.index` | web |
| GET | `/catalogo/{categoria}` | CategoriaProductoController@productos | `catalogo.productos` | web |
| GET | `/catalogo/producto/{producto}` | ProductoController@showPublico | `catalogo.producto` | web |

### Rutas de autenticación (Breeze — `routes/auth.php`)

| Método | URI | Controller@Método | Nombre | Middleware |
|--------|-----|-------------------|--------|-----------|
| GET | `/register` | RegisteredUserController@create | `register` | guest |
| POST | `/register` | RegisteredUserController@store | — | guest |
| GET | `/login` | AuthenticatedSessionController@create | `login` | guest |
| POST | `/login` | AuthenticatedSessionController@store | — | guest |
| GET | `/forgot-password` | PasswordResetLinkController@create | `password.request` | guest |
| POST | `/forgot-password` | PasswordResetLinkController@store | `password.email` | guest |
| GET | `/reset-password/{token}` | NewPasswordController@create | `password.reset` | guest |
| POST | `/reset-password` | NewPasswordController@store | `password.store` | guest |
| GET | `/verify-email` | EmailVerificationPromptController | `verification.notice` | auth |
| GET | `/verify-email/{id}/{hash}` | VerifyEmailController | `verification.verify` | auth, signed |
| POST | `/email/verification-notification` | EmailVerificationNotificationController@store | `verification.send` | auth |
| GET | `/confirm-password` | ConfirmablePasswordController@show | `password.confirm` | auth |
| POST | `/confirm-password` | ConfirmablePasswordController@store | — | auth |
| PUT | `/password` | PasswordController@update | `password.update` | auth |
| POST | `/logout` | AuthenticatedSessionController@destroy | `logout` | auth |

### Ruta dashboard (redirección)

| Método | URI | Controller@Método | Nombre | Middleware |
|--------|-----|-------------------|--------|-----------|
| GET | `/dashboard` | — (closure → view) | `dashboard` | auth |

### Panel comercial (`/comercial/*`)

| Método | URI | Controller@Método | Nombre | Middleware |
|--------|-----|-------------------|--------|-----------|
| GET | `/comercial/dashboard` | — (closure → view) | `comercial.dashboard` | auth, role:comercial |
| GET | `/comercial/clientes` | ClienteController@index | `comercial.clientes.index` | auth, role:comercial |
| GET | `/comercial/clientes/create` | ClienteController@create | `comercial.clientes.create` | auth, role:comercial |
| POST | `/comercial/clientes` | ClienteController@store | `comercial.clientes.store` | auth, role:comercial |
| GET | `/comercial/clientes/{cliente}` | ClienteController@show | `comercial.clientes.show` | auth, role:comercial |
| GET | `/comercial/clientes/{cliente}/edit` | ClienteController@edit | `comercial.clientes.edit` | auth, role:comercial |
| PUT | `/comercial/clientes/{cliente}` | ClienteController@update | `comercial.clientes.update` | auth, role:comercial |
| DELETE | `/comercial/clientes/{cliente}` | ClienteController@destroy | `comercial.clientes.destroy` | auth, role:comercial |
| — | `/comercial/pedidos/*` | PedidoController (resource) | `comercial.pedidos.*` | auth, role:comercial |

### Rutas compartidas (admin + comercial)

| Método | URI | Controller@Método | Nombre | Middleware |
|--------|-----|-------------------|--------|-----------|
| — | `/clientes/*` | ClienteController (resource) | `clientes.*` | auth, role:comercial\|admin |
| — | `/pedidos/*` | PedidoController (resource) | `pedidos.*` | auth, role:comercial\|admin |

### Panel admin (`/admin/*`)

| Método | URI | Controller@Método | Nombre | Middleware |
|--------|-----|-------------------|--------|-----------|
| GET | `/admin/dashboard` | Admin\DashboardController@index | `admin.dashboard` | auth, role:admin |
| — | `/admin/trabajadores/*` | Admin\TrabajadorController (resource) | `admin.trabajadores.*` | auth, role:admin |

### Gestión de productos y categorías (solo admin)

| Método | URI | Controller@Método | Nombre | Middleware |
|--------|-----|-------------------|--------|-----------|
| — | `/productos/*` (excepto show) | ProductoController (resource) | `productos.*` | auth, role:admin |
| — | `/categorias/*` (excepto show) | CategoriaProductoController (resource) | `categorias.*` | auth, role:admin |

## Cómo añadir un nuevo middleware

```bash
# 1. Crear el middleware
php artisan make:middleware NombreMiddleware

# 2. Implementar lógica en handle()

# 3. Registrar en bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'nuevo' => \App\Http\Middleware\NombreMiddleware::class,
    ]);
})

# 4. Usar en rutas
Route::middleware(['auth', 'nuevo:parametro'])->group(function () { ... });
```

## Cómo añadir un nuevo rol

1. Añadir el valor al enum en una nueva migración:

```php
DB::statement("ALTER TABLE users MODIFY rol ENUM('admin', 'comercial', 'nuevo_rol') DEFAULT 'comercial'");
```

2. Actualizar `RedirectBasedOnRole` para manejar el nuevo rol.
3. Crear el grupo de rutas con el middleware `role:nuevo_rol`.
4. Crear el dashboard y controllers correspondientes.
