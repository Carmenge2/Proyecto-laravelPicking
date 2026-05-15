# PICKING
Sistema de Gestión Comercial con Catálogo de Productos, Clientes y Pedidos

[Nombre del estudiante]
[Centro educativo] – 2º DAW (2025/2026)

---

## INTRODUCCIÓN

- El proyecto **Picking** consiste en una aplicación web de gestión comercial orientada a equipos de ventas y administración.

- 🎯 **Objetivo:** Facilitar la gestión de clientes, pedidos y catálogo de productos mediante una aplicación web moderna, segura y escalable.

- 💡 **Motivación:** Aplicar conocimientos avanzados de desarrollo web con Laravel en un entorno real de gestión empresarial, diferenciando roles de administrador y comercial.

---

## TECNOLOGÍAS UTILIZADAS

- ⚙ **Backend:** PHP 8.2, Laravel 12

- 🎨 **Frontend:** Blade, HTML5, JavaScript, Alpine.js

- 🗃 **Base de datos:** MySQL / SQLite

- 💻 **Servidor local:** XAMPP (Apache + MySQL)

- 🌿 **Control de versiones:** Git / GitHub

- 📱 **Diseño y estilo:** TailwindCSS con tokens de color semánticos (paleta corporativa naranja)

- 🛠 **Herramientas:** Composer, Artisan, Eloquent ORM, Vite, Laravel Breeze

---

## ESTRUCTURA DEL PROYECTO

- El proyecto sigue la arquitectura **MVC** de Laravel:

  - `/app/Http/Controllers` → Controladores de cada módulo
  - `/app/Models` → Modelos Eloquent con relaciones
  - `/app/Services` → Lógica de negocio desacoplada (PedidoService)
  - `/app/Policies` → Autorización a nivel de recurso
  - `/app/Http/Middleware` → Control de acceso por roles (RedirectBasedOnRole)
  - `/resources/views` → Vistas Blade con componentes UI reutilizables
  - `/routes/web.php` → Definición de rutas con restricciones por rol

- 🔁 **Flujo:** Usuario → Rutas → Middleware → Controlador → Modelo → Vista

---

## FUNCIONALIDADES PRINCIPALES

- 👤 **Registro e inicio de sesión** con Laravel Breeze

- 🔒 **Seguridad y roles de usuario:** control de permisos entre administrador y comercial mediante middleware personalizado y policies

- 📋 **Gestión de clientes:** CRUD completo con asignación automática al comercial logueado

- 📦 **Gestión de pedidos:** creación con selección de productos por categorías, cálculo automático de totales y estados (pendiente, enviado, cancelado)

- 🏷 **Catálogo de productos por categorías:** visualización pública para usuarios autenticados

- ⚙ **Panel de administración:** gestión de productos, categorías, trabajadores y acceso compartido a clientes y pedidos

- 📊 **Dashboards personalizados:** estadísticas globales para admin y personales para cada comercial

---

## BASE DE DATOS

- El sistema se basa en varias tablas relacionadas:

  - **users** — usuarios registrados (admin y comercial)
  - **clientes** — cartera de clientes con datos comerciales y de contacto
  - **pedidos** — pedidos realizados con fecha, total, estado y comercial asignado
  - **productos** — catálogo de productos con precio, stock, estado e imagen
  - **categorias_productos** — categorías del catálogo
  - **pedido_producto** — tabla pivote que relaciona pedidos con productos y sus cantidades

- **Relaciones principales:**

  - 👤 Un usuario (comercial) puede tener varios clientes (1:N)
  - 👤 Un usuario (comercial) puede crear varios pedidos (1:N)
  - 📋 Un cliente puede realizar varios pedidos (1:N)
  - 📦 Un producto pertenece a una categoría (N:1)
  - 📦 Un producto puede aparecer en varios pedidos (N:M mediante pedido_producto)
  - 📋 Un pedido incluye varios productos con cantidades (N:M mediante pedido_producto)

---

## DEMOSTRACIÓN VISUAL

- En esta sección se mostrarán las capturas principales del proyecto:

  - Página de inicio de sesión
  - Registro de usuario
  - Dashboard del administrador
  - Dashboard del comercial
  - Catálogo de categorías
  - Catálogo de productos por categoría
  - Listado de clientes
  - Crear / editar cliente
  - Detalle de cliente
  - Listado de pedidos
  - Crear pedido (selección de productos)
  - Detalle de pedido
  - Panel de productos (admin)
  - Crear / editar producto
  - Panel de categorías (admin)
  - Panel de trabajadores (admin)

---

## PÁGINA DE INICIO DE SESIÓN

*(Captura: formulario de login con email, contraseña, "Remember me" y enlace a registro)*

---

## REGISTRO DE USUARIO

*(Captura: formulario de registro con nombre, email, contraseña y confirmación)*

> Nota: los usuarios registrados públicamente obtienen el rol de **comercial** automáticamente.

---

## DASHBOARD DEL ADMINISTRADOR

*(Captura: panel admin con tarjetas de estadísticas — trabajadores, productos, categorías — y accesos rápidos)*

---

## DASHBOARD DEL COMERCIAL

*(Captura: panel comercial con tarjetas de estadísticas personales — clientes propios, pedidos propios — y accesos rápidos)*

---

## CATÁLOGO DE CATEGORÍAS

*(Captura: cuadrícula responsive de categorías con imagen circular o inicial del nombre)*

---

## CATÁLOGO DE PRODUCTOS POR CATEGORÍA

*(Captura: productos de una categoría con imagen, nombre, precio y badge de estado: disponible, agotado, pre-venta)*

---

## LISTADO DE CLIENTES

*(Captura: tabla paginada con búsqueda por nombre comercial, razón social o ID)*

---

## CREAR CLIENTE

*(Captura: formulario de creación de cliente con inputs unificados en tarjeta centrada)*

---

## DETALLE DE CLIENTE

*(Captura: vista de ficha completa del cliente con botones de editar y eliminar)*

---

## LISTADO DE PEDIDOS

*(Captura: tabla paginada con filtros por cliente, fecha y estado, con badges de estado)*

---

## CREAR PEDIDO

*(Captura: formulario de pedido con select de cliente, productos agrupados por categoría con inputs de cantidad, y total calculado automáticamente)*

> El total se calcula en el backend a partir de los precios reales de la base de datos, evitando manipulaciones desde el frontend.

---

## DETALLE DE PEDIDO

*(Captura: vista de detalle con cliente, productos con cantidades, total, comercial asignado, fecha de entrega y estado)*

---

## PANEL DE PRODUCTOS (ADMIN)

*(Captura: tabla de productos con imagen, nombre, precio, stock, estado y categoría)*

---

## CREAR PRODUCTO (ADMIN)

*(Captura: formulario con nombre, descripción, precio, stock, estado, categoría e imagen con vista previa)*

---

## PANEL DE CATEGORÍAS (ADMIN)

*(Captura: catálogo con botón "Nueva Categoría" y opciones de editar/eliminar sobre cada categoría)*

---

## PANEL DE TRABAJADORES (ADMIN)

*(Captura: tabla de comerciales con búsqueda, paginación, y botón "Nuevo Comercial")*

---

## RETOS Y SOLUCIONES

- Durante el desarrollo surgieron varios retos:

  - 🔐 **Autenticación con roles:** implementación de middleware personalizado (`RedirectBasedOnRole`) que redirige automáticamente a cada usuario a su panel según el rol, y policies (`ClientePolicy`, `PedidoPolicy`) que restringen el acceso a recursos ajenos.

  - 🧮 **Cálculo automático de totales:** desacoplamiento de la lógica de negocio en `PedidoService`, que filtra productos con cantidad > 0 y calcula el total a partir de los precios actuales de base de datos, evitando manipulaciones desde el frontend.

  - 🖼 **Subida y validación de imágenes:** gestión de imágenes para productos y categorías con almacenamiento en `storage/app/public` y enlace simbólico a `public/storage`.

  - 📱 **Diseño responsive y unificación visual:** refactorización completa del frontend con TailwindCSS, tokens de color semánticos (`brand-50` a `brand-900`) y más de 15 componentes Blade reutilizables para garantizar consistencia en toda la aplicación.

- Cada problema se resolvió aplicando documentación oficial, buenas prácticas de Laravel y pruebas iterativas.

---

## CONCLUSIONES Y MEJORAS FUTURAS

- ✨ **Conclusiones:**
  - Se ha desarrollado una aplicación web completa en Laravel 12 con arquitectura MVC sólida, separación de responsabilidades y control de acceso por roles.
  - Se ha integrado una base de datos relacional con relaciones Eloquent, índices de rendimiento y tabla pivote para pedido-producto.
  - Se ha aplicado un diseño moderno y responsive con TailwindCSS, componentes Blade reutilizables y retroalimentación visual consistente.
  - Se ha desacoplado la lógica de negocio mediante `PedidoService`, facilitando el mantenimiento y el testing futuro.

- 🚀 **Mejoras futuras:**
  - API REST para integración con aplicaciones móviles o ERPs externos
  - Exportación de pedidos a PDF y clientes a Excel
  - Notificaciones en tiempo real por email al cambiar el estado de un pedido
  - Estadísticas avanzadas con gráficos de ventas y rentabilidad por comercial
  - Tests automatizados (Feature Tests y Unit Tests para PedidoService)
  - Multitenancy para múltiples empresas con datos aislados
  - Alertas de stock bajo
  - Despliegue en servidor real (VPS o hosting)
