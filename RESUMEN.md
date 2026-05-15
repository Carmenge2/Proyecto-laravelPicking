# RESUMEN DEL PROYECTO

**Curso:** 2025 / 2026

**Alumno:** [Nombre del estudiante]

**Grupo:** 2º DAW

**Título del Proyecto:** Picking – Sistema de Gestión Comercial con Catálogo de Productos, Clientes y Pedidos

**Tiempo oficial dedicado, en horas:** [Completar]

---

## Breve descripción de los objetivos planteados

El objetivo principal del proyecto **Picking** es desarrollar una aplicación web completa para la gestión comercial de una empresa con equipo de ventas y administración, que permita gestionar clientes, pedidos, productos, categorías y trabajadores de forma centralizada y segura. Se ha buscado aplicar los conocimientos adquiridos en el ciclo formativo, integrando un backend robusto desarrollado con **Laravel 12 (PHP 8.2)** y **MySQL / SQLite**, y un frontend basado en **plantillas Blade**, **TailwindCSS** y **componentes UI reutilizables**, ofreciendo una experiencia moderna y responsive.

Además, se ha incorporado un **sistema de autenticación con Laravel Breeze** y **control de acceso por roles** (administrador y comercial) mediante middleware personalizado (`RedirectBasedOnRole`) y policies de autorización (`ClientePolicy`, `PedidoPolicy`). También se han implementado funcionalidades de **búsqueda**, **paginación**, **filtrado por estado** y un **service layer** (`PedidoService`) que centraliza la lógica de cálculo de totales y filtrado de productos.

---

## Breve descripción de los objetivos alcanzados

Se ha logrado construir un sistema de gestión comercial funcional que permite a los usuarios registrarse, iniciar sesión y ser redirigidos automáticamente a su panel según el rol asignado. Los **comerciales** pueden gestionar su cartera de clientes (CRUD completo), crear pedidos seleccionando productos organizados por categorías con cantidades, y visualizar su histórico personal. El **administrador** dispone de un panel completo para gestionar productos, categorías, trabajadores (comerciales), y acceso compartido a clientes y pedidos de toda la empresa.

La aplicación implementa **validación de formularios** en el lado del servidor, **paginación** y **filtros de búsqueda** en clientes y pedidos, así como **middleware** en las rutas para proteger las zonas restringidas según el rol del usuario. La lógica de negocio de pedidos se ha desacoplado en el `PedidoService`, que filtra productos con cantidad mayor a cero y calcula el total a partir de los precios reales almacenados en base de datos, evitando cualquier manipulación desde el frontend. La comunicación con la base de datos se realiza mediante **Eloquent ORM**, garantizando un acceso estructurado y seguro a la información.

---

## Breves indicaciones sobre la instalación y ejecución

Para ejecutar correctamente el proyecto **Picking**, es necesario disponer de **PHP 8.2+**, **Composer**, **Node.js** y un servidor de base de datos **MySQL** (o SQLite) instalados en el equipo. A continuación, se detallan los pasos de instalación y puesta en marcha:

- **Clonar el repositorio** desde GitHub (o copiar la carpeta del proyecto en el directorio del servidor web, por ejemplo `C:\xampp\htdocs\`):

```bash
git clone <url-del-repositorio> && cd ProyectoLaravel
```

- **Configurar el archivo `.env`** de Laravel con los datos de conexión a la base de datos (nombre de la base de datos, puerto, usuario y contraseña):

```env
APP_NAME=Picking
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=picking
DB_USERNAME=root
DB_PASSWORD=
```

> Para SQLite: `DB_CONNECTION=sqlite` y asegurar que existe el archivo `database/database.sqlite`.

- **Instalar dependencias del backend y generar tablas:**

```bash
composer install
php artisan key:generate
php artisan migrate
```

- **Instalar dependencias del frontend:**

```bash
npm install
```

- **Ejecutar el backend (Laravel):**

Desde la carpeta del proyecto, levantar el servidor de desarrollo con:

```bash
php artisan serve
```

Esto permite acceder a la aplicación desde el navegador a través de la URL indicada por Laravel (`http://127.0.0.1:8000`).

- **Ejecutar el frontend (Vite / TailwindCSS / JS):**

Desde la misma carpeta, en otra terminal, ejecutar:

```bash
npm run dev
```

Vite abre el servidor de assets en `http://localhost:5173` y recarga automáticamente los cambios durante el desarrollo.

- **Inicio de sesión y uso de la aplicación:** Al acceder a la aplicación, el usuario puede registrarse creando una cuenta nueva (obtiene rol **comercial** automáticamente) o iniciar sesión con un usuario ya existente. Una vez autenticado, el middleware `RedirectBasedOnRole` redirige automáticamente a cada usuario a su panel correspondiente:
  - **Comercial**: dashboard personal, clientes, pedidos y catálogo.
  - **Administrador**: dashboard global, clientes, pedidos, productos, categorías y trabajadores.

Todo el flujo de datos sensibles está protegido mediante el sistema de autenticación de Laravel, middleware de autorización y policies de recurso, lo que garantiza que solo los usuarios con permisos adecuados puedan acceder a las funciones principales y a las secciones restringidas. Un comercial, por ejemplo, no puede ver ni modificar clientes o pedidos de otro comercial, ni acceder a la gestión de productos o categorías reservada al administrador.

---

## Impresión personal

Este proyecto me ha permitido consolidar los conocimientos adquiridos en el ciclo de Desarrollo de Aplicaciones Web, especialmente en el uso de **Laravel 12**, **MySQL**, **TailwindCSS** y herramientas modernas del entorno PHP. A lo largo del desarrollo he tenido que diseñar la base de datos relacional con múltiples entidades y relaciones (clientes, pedidos, productos, categorías y tabla pivote), estructurar el backend con controladores, middleware personalizado, policies de autorización y un service layer, trabajar con plantillas Blade y componentes UI reutilizables, y aplicar conceptos como la autenticación, la validación de formularios, el control de acceso mediante middleware y la separación de responsabilidades en la lógica de negocio.

Además, he podido aplicar una **refactorización completa del frontend** utilizando tokens de color semánticos (`brand-50` a `brand-900`), tipografía Poppins y más de 15 componentes Blade reutilizables (`page-header`, `card`, `button`, `form-input`, `badge`, `alert`, `table`, etc.), garantizando una interfaz moderna, consistente y responsive. La implementación del `PedidoService` como capa de negocio desacoplada ha supuesto un aprendizaje clave sobre arquitectura limpia y testabilidad.

En conjunto, considero que **Picking** ha sido una experiencia muy enriquecedora tanto a nivel técnico como personal, que me ha preparado para afrontar proyectos reales de gestión empresarial en el ámbito del desarrollo web.
