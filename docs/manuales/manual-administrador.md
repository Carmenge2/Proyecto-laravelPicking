# Manual de usuario — Administrador

Guía de uso del sistema para usuarios con rol **admin**.

## Acceso al sistema

1. Abre el navegador y accede a la URL del sistema.
2. Introduce tu **email** y **contraseña**.
3. Pulsa **Iniciar sesión**.
4. Serás redirigido automáticamente a tu **panel de administración**.

## Panel de administración (Dashboard)

Desde el dashboard de admin puedes:

- Ver un **resumen general** del sistema.
- Acceder a la gestión de **trabajadores**, **productos** y **categorías**.
- Consultar **clientes** y **pedidos** de todos los comerciales.

## Gestión de trabajadores

Los "trabajadores" son los **usuarios del sistema** (tanto admin como comerciales).

### Ver listado de trabajadores

- Accede desde el menú a **Trabajadores** (ruta: `/admin/trabajadores`).
- Verás la lista de todos los usuarios registrados.

### Crear un nuevo trabajador

1. Pulsa **Crear trabajador**.
2. Rellena los campos:
   - **Nombre** (obligatorio)
   - **Email** (obligatorio, debe ser único)
   - **Contraseña** (obligatorio)
   - **Rol**: `admin` o `comercial`
3. Pulsa **Guardar**.

### Editar un trabajador

1. Pulsa **Editar** junto al trabajador.
2. Modifica los campos necesarios (nombre, email, rol).
3. Pulsa **Guardar cambios**.

### Eliminar un trabajador

1. Pulsa **Eliminar** junto al trabajador.
2. Confirma la acción.

> **Atención:** al eliminar un trabajador se eliminan sus clientes y pedidos asociados (cascada en BD).

## Gestión de productos

### Ver listado de productos

- Accede desde el menú a **Productos** (ruta: `/productos`).
- Los productos se muestran organizados por **categoría**.

### Crear un nuevo producto

1. Pulsa **Crear producto**.
2. Rellena los campos:
   - **Nombre** (obligatorio, debe ser único)
   - **Descripción** (opcional, máx. 1000 caracteres)
   - **Precio** (obligatorio, en euros)
   - **Stock** (obligatorio, unidades disponibles)
   - **Estado**: `disponible`, `agotado` o `pre-venta`
   - **Categoría** (obligatorio, selecciona del desplegable)
   - **Imagen** (opcional, formatos: jpg/png/gif, máx. 2 MB)
3. Pulsa **Guardar**.

### Editar un producto

1. Pulsa **Editar** junto al producto.
2. Modifica los campos necesarios.
3. Si subes una nueva imagen, la anterior se reemplaza automáticamente.
4. Pulsa **Guardar cambios**.

### Eliminar un producto

1. Pulsa **Eliminar** junto al producto.
2. Confirma la acción.
3. La imagen asociada se elimina automáticamente del servidor.

> **Nota:** si el producto está incluido en pedidos existentes, esos pedidos perderán la referencia.

## Gestión de categorías

### Ver listado de categorías

- Accede desde el menú a **Categorías** (ruta: `/categorias`).

### Crear una nueva categoría

1. Pulsa **Crear categoría**.
2. Rellena:
   - **Nombre** (obligatorio)
   - **Imagen** (opcional)
3. Pulsa **Guardar**.

### Editar una categoría

1. Pulsa **Editar** junto a la categoría.
2. Modifica nombre o imagen.
3. Pulsa **Guardar cambios**.

### Eliminar una categoría

1. Pulsa **Eliminar** junto a la categoría.
2. Confirma la acción.

> **Atención:** antes de eliminar una categoría, asegúrate de que no tiene productos asignados o reasígnalos primero.

## Gestión de clientes y pedidos

Como administrador también tienes acceso a:

- **Clientes** (`/clientes`): puedes ver, crear, editar y eliminar clientes de cualquier comercial.
- **Pedidos** (`/pedidos`): puedes ver, crear, editar y eliminar pedidos de cualquier comercial.

La funcionalidad es idéntica a la del comercial (consulta el [manual de comercial](./manual-comercial.md) para detalles).

## Catálogo público

El catálogo público (`/catalogo`) muestra los productos organizados por categorías. Es visible para cualquier usuario (con o sin login). Útil para:

- Verificar cómo se ve la información pública.
- Compartir el enlace con clientes externos.

## Preguntas frecuentes

**¿Puedo cambiar el rol de un trabajador existente?**
Sí, desde la edición del trabajador puedes cambiar entre `admin` y `comercial`.

**¿Puedo reasignar un cliente a otro comercial?**
Sí, editando el cliente y cambiando el campo "Comercial asignado".

**¿Los cambios en productos afectan a pedidos existentes?**
Los pedidos existentes conservan las cantidades en la tabla pivote. Sin embargo, si se elimina un producto, se pierde la referencia en pedidos futuros.

**¿Cómo creo el primer usuario admin?**
Mediante el seeder de la base de datos o directamente en el registro (mientras no se restrinja el campo de rol en el formulario).

**¿Dónde se guardan las imágenes?**
En `storage/app/public/productos/`. Se sirven públicamente a través del enlace simbólico `public/storage`.
