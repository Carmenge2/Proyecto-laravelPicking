# Manual de usuario — Comercial

Guía de uso del sistema para usuarios con rol **comercial**.

## Acceso al sistema

1. Abre el navegador y accede a la URL del sistema (ej: `http://tu-dominio.com`).
2. Introduce tu **email** y **contraseña**.
3. Pulsa **Iniciar sesión**.
4. Serás redirigido automáticamente a tu **panel de comercial**.

> Si no recuerdas tu contraseña, pulsa "¿Olvidaste tu contraseña?" y sigue las instrucciones del correo.

## Panel de comercial (Dashboard)

Al iniciar sesión verás tu **dashboard**, que es el punto central desde el que puedes:

- Gestionar tus **clientes**.
- Crear y gestionar **pedidos**.

## Gestión de clientes

### Ver listado de clientes

- Accede desde el menú a **Clientes**.
- Verás una tabla con todos tus clientes: nombre comercial, razón social, etc.
- Usa el **buscador** para filtrar por nombre comercial, razón social o ID.
- La lista está paginada (10 clientes por página).

### Crear un nuevo cliente

1. Pulsa el botón **Crear cliente** (o **Nuevo**).
2. Rellena los campos:
   - **Nombre comercial** (obligatorio)
   - **Razón social** (obligatorio)
   - **Email** (opcional)
   - **Teléfono** (opcional)
   - **Dirección** (opcional)
   - **Tipo de negocio** (opcional)
3. El campo **Comercial asignado** se rellena automáticamente con tu nombre.
4. Pulsa **Guardar**.

### Editar un cliente

1. En la lista de clientes, pulsa el botón **Editar** del cliente deseado.
2. Modifica los campos necesarios.
3. Pulsa **Guardar cambios**.

### Eliminar un cliente

1. En la lista, pulsa **Eliminar** en el cliente deseado.
2. Confirma la acción.

> **Atención:** al eliminar un cliente se eliminan también sus pedidos asociados.

## Gestión de pedidos

### Ver listado de pedidos

- Accede desde el menú a **Pedidos**.
- Verás todos los pedidos ordenados por fecha (más recientes primero).
- Puedes **filtrar** por:
  - **Búsqueda**: nombre/razón social del cliente.
  - **Fecha**: fecha concreta del pedido.
  - **Estado**: pendiente, enviado o cancelado.

### Crear un nuevo pedido

1. Pulsa **Crear pedido** (o **Nuevo**).
2. Selecciona el **cliente** del desplegable.
3. Indica la **fecha** del pedido.
4. Selecciona el **estado** (normalmente "pendiente" al crear).
5. En la sección de **productos**:
   - Verás los productos organizados por categorías.
   - Indica la **cantidad** de cada producto que quieres incluir.
   - Deja en 0 o vacío los que no quieras.
6. Pulsa **Guardar**.

El **total** se calcula automáticamente según: `precio del producto × cantidad`.

### Editar un pedido

1. En la lista, pulsa **Editar** en el pedido deseado.
2. Puedes cambiar: cliente, fecha, estado y cantidades de productos.
3. Pulsa **Guardar cambios**.

### Ver detalle de un pedido

- Pulsa en el pedido (o botón **Ver**) para ver:
  - Datos del cliente.
  - Productos incluidos con cantidades.
  - Total del pedido.
  - Comercial que lo creó.

### Eliminar un pedido

1. Pulsa **Eliminar** en el pedido deseado.
2. Confirma la acción.

## Estados de un pedido

| Estado | Significado |
|--------|-------------|
| **Pendiente** | El pedido está creado pero no ha sido procesado/enviado |
| **Enviado** | El pedido ha sido enviado al cliente |
| **Cancelado** | El pedido ha sido anulado |

## Catálogo de productos

Puedes consultar el catálogo público de productos (sin necesidad de crear pedido):

- Accede a `/catalogo` para ver las categorías.
- Pulsa en una categoría para ver sus productos.
- Pulsa en un producto para ver su ficha completa (precio, stock, descripción).

## Preguntas frecuentes

**¿Puedo cambiar el comercial asignado a un cliente?**
No. Los clientes se asignan automáticamente al comercial que los crea. Solo un administrador puede reasignarlos.

**¿Puedo ver clientes de otros comerciales?**
Depende de la configuración. En la ruta compartida `/clientes` puedes ver todos los clientes del sistema.

**¿Puedo acceder al panel de administrador?**
No. Si intentas acceder a rutas de admin, serás redirigido a tu dashboard de comercial.

**¿Qué pasa si un producto está agotado?**
El producto puede seguir apareciendo en el catálogo con estado "agotado", pero deberías consultar con el administrador antes de incluirlo en un pedido.
