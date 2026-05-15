# Controladores

Documentación de cada controlador, sus métodos, validaciones y patrones de respuesta.

## Resumen de controladores

| Controlador | Namespace | Responsabilidad |
|-------------|-----------|----------------|
| `ClienteController` | `App\Http\Controllers` | CRUD de clientes |
| `PedidoController` | `App\Http\Controllers` | CRUD de pedidos |
| `ProductoController` | `App\Http\Controllers` | CRUD de productos + ficha pública |
| `CategoriaProductoController` | `App\Http\Controllers` | CRUD categorías + catálogo público |
| `Admin\DashboardController` | `App\Http\Controllers\Admin` | Dashboard del admin |
| `Admin\TrabajadorController` | `App\Http\Controllers\Admin` | CRUD de trabajadores |
| `ProfileController` | `App\Http\Controllers` | Perfil del usuario (Breeze) |

## ClienteController

**Archivo:** `app/Http/Controllers/ClienteController.php`

| Método | Ruta | Descripción |
|--------|------|-------------|
| `index(Request)` | GET `/clientes` | Lista clientes con búsqueda y paginación (10/pág) |
| `create()` | GET `/clientes/create` | Formulario de creación. Si es comercial, pre-selecciona su ID |
| `store(Request)` | POST `/clientes` | Valida y crea cliente. Si el usuario es comercial, fuerza `comercial_id` |
| `show(Cliente)` | GET `/clientes/{cliente}` | Vista de detalle |
| `edit(Cliente)` | GET `/clientes/{cliente}/edit` | Formulario de edición |
| `update(Request, Cliente)` | PUT `/clientes/{cliente}` | Valida y actualiza |
| `destroy(Cliente)` | DELETE `/clientes/{cliente}` | Elimina el cliente |

**Validación (store/update):**

| Campo | Reglas |
|-------|--------|
| `nombre_comercial` | required, string, max:255 |
| `razon_social` | required, string, max:255 |
| `email` | nullable, email, max:255 |
| `direccion` | nullable, string, max:255 |
| `telefono` | nullable, string, max:50 |
| `tipo_negocio` | nullable, string |
| `comercial_id` | exists:users,id |

**Patrón de respuesta:** `redirect()->route('clientes.index')->with('success', '...')`

---

## PedidoController

**Archivo:** `app/Http/Controllers/PedidoController.php`

| Método | Ruta | Descripción |
|--------|------|-------------|
| `index(Request)` | GET `/pedidos` | Lista pedidos con filtros (búsqueda, fecha, estado). Paginación 10/pág |
| `create()` | GET `/pedidos/create` | Carga clientes y categorías con productos para el formulario |
| `store(Request)` | POST `/pedidos` | Valida, calcula total, crea pedido y attach productos |
| `show(Pedido)` | GET `/pedidos/{pedido}` | Detalle con cliente, productos y comercial |
| `edit(Pedido)` | GET `/pedidos/{pedido}/edit` | Formulario de edición con datos precargados |
| `update(Request, Pedido)` | PUT `/pedidos/{pedido}` | Actualiza pedido y sync productos |
| `destroy(Pedido)` | DELETE `/pedidos/{pedido}` | Elimina el pedido |

**Validación (store/update):**

| Campo | Reglas |
|-------|--------|
| `cliente_id` | required, exists:clientes,id |
| `productos` | required, array |
| `productos.*.cantidad` | nullable, integer, min:0 |
| `fecha` | required, date |
| `estado` | required, in:pendiente,enviado,cancelado |

**Lógica de negocio en store/update:**
1. Filtra productos con `cantidad > 0`.
2. Si no hay productos seleccionados → error.
3. Carga precios desde BD.
4. Calcula `total = sum(precio * cantidad)`.
5. Asigna `comercial_id = Auth::id()`.

---

## ProductoController

**Archivo:** `app/Http/Controllers/ProductoController.php`

| Método | Ruta | Descripción |
|--------|------|-------------|
| `index()` | GET `/productos` | Lista categorías (admin) |
| `create()` | GET `/productos/create` | Formulario con categorías |
| `store(Request)` | POST `/productos` | Valida, sube imagen y crea producto |
| `showPublico(Producto)` | GET `/catalogo/producto/{producto}` | Ficha pública del producto |
| `edit(Producto)` | GET `/productos/{producto}/edit` | Formulario de edición |
| `update(Request, Producto)` | PUT `/productos/{producto}` | Actualiza, reemplaza imagen si procede |
| `destroy(Producto)` | DELETE `/productos/{producto}` | Elimina producto e imagen de storage |

**Validación (store/update):**

| Campo | Reglas |
|-------|--------|
| `nombre` | required, string, max:255, unique:productos,nombre(,{id}) |
| `descripcion` | nullable, string, max:1000 |
| `precio` | required, numeric, min:0 |
| `estado` | required, in:disponible,agotado,pre-venta |
| `stock` | required, integer, min:0, max:9999 |
| `categoria_id` | required, exists:categorias_productos,id |
| `imagen` | nullable, image, max:2048 |

**Gestión de imágenes:**
- Subida a disco `public`, carpeta `productos/`.
- En update: elimina la imagen anterior si se sube una nueva.
- En destroy: elimina la imagen del storage.

---

## CategoriaProductoController

**Archivo:** `app/Http/Controllers/CategoriaProductoController.php`

| Método | Ruta | Descripción |
|--------|------|-------------|
| `index()` | GET `/catalogo` o `/categorias` | Lista categorías (público o admin) |
| `productos(categoria)` | GET `/catalogo/{categoria}` | Lista productos de una categoría |
| + métodos resource | CRUD admin | create, store, edit, update, destroy |

---

## Admin\DashboardController

**Archivo:** `app/Http/Controllers/Admin/DashboardController.php`

| Método | Ruta | Descripción |
|--------|------|-------------|
| `index()` | GET `/admin/dashboard` | Dashboard de administración |

---

## Admin\TrabajadorController

**Archivo:** `app/Http/Controllers/Admin/TrabajadorController.php`

| Método | Ruta | Descripción |
|--------|------|-------------|
| Resource completo | `/admin/trabajadores` | CRUD de trabajadores (usuarios del sistema) |

Parámetro renombrado: `{trabajadores}` → `{trabajador}`.

## Convenciones en controladores

- **Validación inline** con `$request->validate([...])` (sin Form Requests separados).
- **Respuesta tras mutación:** siempre `redirect()->route(...)->with('success', '...')`.
- **Eager loading:** se usa `with()` en queries para evitar N+1 (ej: `Pedido::with(['cliente', 'productos', 'comercial'])`).
- **Paginación:** 10 registros por página como estándar.
