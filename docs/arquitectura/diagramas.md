# Diagramas del sistema

Colección de diagramas Mermaid que describen la arquitectura, datos, flujos y permisos del proyecto.

## Diagrama de arquitectura general

```mermaid
flowchart TB
  browser["Navegador del usuario"]
  browser --> routes["routes/web.php + auth.php"]
  routes --> mwAuth["Middleware: auth"]
  mwAuth --> mwRole["Middleware: role"]
  mwRole --> controllers["Controllers"]
  controllers --> models["Eloquent Models"]
  models --> db[("Base de datos")]
  controllers --> views["Blade Views"]
  views --> vite["Vite (TailwindCSS + Alpine.js)"]
  vite --> browser

  subgraph backendBlock["Backend (Laravel 12)"]
    routes
    mwAuth
    mwRole
    controllers
    models
  end

  subgraph frontendBlock["Frontend"]
    views
    vite
  end
```

## Modelo entidad-relación (ER)

```mermaid
erDiagram
  USERS ||--o{ CLIENTES : "comercial asignado"
  USERS ||--o{ PEDIDOS : "comercial que crea"
  CLIENTES ||--o{ PEDIDOS : "realiza"
  CATEGORIAS_PRODUCTOS ||--o{ PRODUCTOS : "contiene"
  PEDIDOS ||--o{ PEDIDO_PRODUCTO : "incluye"
  PRODUCTOS ||--o{ PEDIDO_PRODUCTO : "aparece en"

  USERS {
    bigint id PK
    string name
    string email UK
    timestamp email_verified_at
    string password
    enum rol "admin | comercial"
    string remember_token
    timestamps created_at
  }

  CLIENTES {
    bigint id PK
    bigint comercial_id FK
    string nombre_comercial
    string razon_social
    string email
    string telefono
    string direccion
    string tipo_negocio
    timestamps created_at
  }

  PEDIDOS {
    bigint id PK
    bigint cliente_id FK
    bigint comercial_id FK
    date fecha
    integer cantidad
    decimal total
    enum estado "pendiente | enviado | cancelado"
    timestamps created_at
  }

  PRODUCTOS {
    bigint id PK
    bigint categoria_id FK
    string nombre UK
    text descripcion
    decimal precio
    integer stock
    enum estado "disponible | agotado | pre-venta"
    string imagen
    timestamps created_at
  }

  CATEGORIAS_PRODUCTOS {
    bigint id PK
    string nombre
    string imagen
    timestamps created_at
  }

  PEDIDO_PRODUCTO {
    bigint id PK
    bigint pedido_id FK
    bigint producto_id FK
    integer cantidad
    timestamps created_at
  }
```

## Flujo de autenticación y redirección por rol

```mermaid
sequenceDiagram
  participant U as Usuario
  participant B as Navegador
  participant R as Router
  participant MW as RedirectBasedOnRole
  participant C as Controller
  participant V as Vista

  U->>B: Accede a /dashboard
  B->>R: GET /dashboard
  R->>MW: Ejecuta middleware auth + role
  MW->>MW: Comprueba Auth::user()->rol

  alt rol es admin
    MW->>R: redirect /admin/dashboard
    R->>C: Admin/DashboardController@index
    C->>V: Render admin.dashboard
  else rol es comercial
    MW->>R: redirect /comercial/dashboard
    R->>V: Render comercial.dashboard
  end

  V->>B: Respuesta HTML
  B->>U: Muestra panel correspondiente
```

## Flujo de creación de pedido

```mermaid
flowchart TB
  start["Comercial accede a /pedidos/create"]
  start --> loadForm["Carga clientes + categorias con productos"]
  loadForm --> fillForm["Rellena formulario: cliente, fecha, estado, cantidades"]
  fillForm --> submit["Envia POST /pedidos"]
  submit --> validate["Valida request (cliente_id, productos, fecha, estado)"]
  validate --> filterProducts["Filtra productos con cantidad > 0"]
  filterProducts --> checkEmpty{"Hay productos seleccionados?"}
  checkEmpty -- "No" --> errorBack["Vuelve con error: selecciona al menos un producto"]
  checkEmpty -- "Si" --> loadPrices["Carga precios desde BD"]
  loadPrices --> calcTotal["Calcula total = SUM(precio * cantidad)"]
  calcTotal --> createPedido["Crea Pedido en BD"]
  createPedido --> attachProducts["Attach productos en tabla pivote con cantidades"]
  attachProducts --> redirectSuccess["Redirect a pedidos.index con mensaje exito"]
```

## Mapa de roles y permisos

```mermaid
flowchart LR
  subgraph publicRoutes["Rutas publicas (sin auth)"]
    catalogo["GET /catalogo"]
    catalogoCat["GET /catalogo/{categoria}"]
    catalogoProd["GET /catalogo/producto/{producto}"]
    login["GET /login"]
    register["GET /register"]
  end

  subgraph comercialRoutes["Rutas comercial (auth + role:comercial)"]
    comDash["GET /comercial/dashboard"]
    comClientes["CRUD /comercial/clientes"]
    comPedidos["CRUD /comercial/pedidos"]
  end

  subgraph sharedRoutes["Rutas compartidas (auth + role:comercial|admin)"]
    clientes["CRUD /clientes"]
    pedidos["CRUD /pedidos"]
  end

  subgraph adminRoutes["Rutas admin (auth + role:admin)"]
    admDash["GET /admin/dashboard"]
    admTrabajadores["CRUD /admin/trabajadores"]
    admProductos["CRUD /productos"]
    admCategorias["CRUD /categorias"]
  end

  userComercial["Usuario comercial"] --> publicRoutes
  userComercial --> comercialRoutes
  userComercial --> sharedRoutes

  userAdmin["Usuario admin"] --> publicRoutes
  userAdmin --> sharedRoutes
  userAdmin --> adminRoutes
```

## Diagrama de dependencias entre módulos

```mermaid
graph TD
  routesWeb["routes/web.php"] --> mwRedirect["Middleware: RedirectBasedOnRole"]
  routesWeb --> clienteCtrl["ClienteController"]
  routesWeb --> pedidoCtrl["PedidoController"]
  routesWeb --> productoCtrl["ProductoController"]
  routesWeb --> categoriaCtrl["CategoriaProductoController"]
  routesWeb --> adminDashCtrl["Admin/DashboardController"]
  routesWeb --> trabajadorCtrl["Admin/TrabajadorController"]

  clienteCtrl --> clienteModel["Cliente"]
  clienteCtrl --> userModel["User"]
  pedidoCtrl --> pedidoModel["Pedido"]
  pedidoCtrl --> clienteModel
  pedidoCtrl --> productoModel["Producto"]
  pedidoCtrl --> categoriaModel["CategoriasProductos"]
  productoCtrl --> productoModel
  productoCtrl --> categoriaModel
  categoriaCtrl --> categoriaModel

  clienteModel --> userModel
  pedidoModel --> clienteModel
  pedidoModel --> userModel
  pedidoModel --> productoModel
  productoModel --> categoriaModel
```
