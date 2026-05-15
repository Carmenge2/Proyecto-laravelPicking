# IES Punta del Verde — Página 1

## SOLICITUD PROYECTO

### DATOS DEL ALUMNO/A

- **Apellidos:** [Apellidos del estudiante]
- **Nombre:** [Nombre del estudiante]
- **DNI:** [DNI]
- **Curso:** 2º DAW
- **Teléfono:** [Teléfono]
- **Correo:** [Correo electrónico]

### DATOS DEL PROYECTO

- **Título del proyecto:** Picking – Sistema de Gestión Comercial con Catálogo de Productos, Clientes y Pedidos
- **Tipo de Proyecto:** Individual
- **Tutora:** [Nombre del tutor/a]
- **Fecha:** [Fecha]

---

## RESUMEN DEL PROYECTO

### Descripción y Objetivos

El proyecto **Picking** consiste en el desarrollo de una aplicación web completa destinada a la gestión comercial de empresas con equipos de ventas y administración.

Su objetivo es ofrecer una plataforma especializada en la gestión de clientes, pedidos y catálogos de productos, que conecta al equipo comercial con la oficina de administración mediante una herramienta centralizada, segura y fácil de utilizar, garantizando una experiencia de trabajo cómoda, controlada y personalizada para cada rol.

El sistema cuenta con un backend desarrollado en **Laravel 12 (PHP 8.2)**, conectado a una base de datos **MySQL / SQLite** diseñada y gestionada mediante migraciones de Laravel, lo que permite un manejo eficiente y seguro de la información. El frontend utiliza diseños y componentes reutilizables integrados con **Vite** y **npm**, ofreciendo una interfaz moderna, dinámica y fluida para el usuario. Además, el sistema incorpora un módulo de autenticación con **Laravel Breeze** y protección de contraseñas mediante **bcrypt**, garantizando la seguridad de los datos y el acceso restringido según el rol de cada usuario (**administrador** o **comercial**).

Por otro lado, incorpora un **service layer** (`PedidoService`) que centraliza la lógica de negocio de los pedidos, filtrando los productos seleccionados con cantidad mayor a cero y calculando automáticamente el total a partir de los precios reales almacenados en la base de datos. Este cálculo se realiza exclusivamente en el backend, evitando manipulaciones desde el frontend y facilitando la trazabilidad y el control interno de cada pedido.

---

## IES Punta del Verde — Página 2

El proyecto surge de la necesidad de contar con una herramienta de gestión comercial especializada, moderna y fácil de utilizar, que pueda servir como base para distintos negocios del sector. Muchas soluciones actuales se apoyan en hojas de cálculo o plataformas genéricas, con interfaces poco intuitivas y opciones limitadas de gestión del catálogo, la cartera de clientes y los pedidos. **Picking** se plantea como un proyecto genérico y ampliable, capaz de adaptarse a diferentes empresas con equipos comerciales, ofreciendo una solución web práctica y actual que facilita la creación de pedidos a los comerciales y simplifica la gestión de productos, categorías, clientes y personal para los administradores.

### Tecnologías utilizadas

- **Lenguajes de programación:** PHP 8.2+, JavaScript (ES6+), HTML5, CSS3.
- **Framework backend:** Laravel 12, siguiendo el patrón MVC y utilizando **Eloquent ORM** para el acceso y la manipulación de datos.
- **Base de datos:** MySQL / SQLite, diseñada y gestionada mediante migraciones de Laravel e índices de rendimiento sobre columnas de búsqueda.
- **Frontend:** Motor de plantillas Blade con diseños y componentes reutilizables, integrados con **Vite** para la compilación y recarga de recursos CSS y JavaScript.
- **Framework de estilos:** TailwindCSS para el diseño responsive, con tokens de color semánticos personalizados (paleta corporativa naranja `brand-50` a `brand-900`) y tipografía Poppins.
- **Gestión de dependencias frontend:** npm para la instalación de paquetes y la ejecución de scripts asociados a Vite y TailwindCSS.
- **Autenticación, seguridad y roles:** Sistema de autenticación de Laravel (Laravel Breeze), hash de contraseñas mediante bcrypt, **middleware personalizado** (`RedirectBasedOnRole`) que redirige a cada usuario a su panel según el rol, y **policies** (`ClientePolicy`, `PedidoPolicy`) que restringen el acceso a recursos ajenos.
- **Middleware en rutas:** Uso de middleware para restringir el acceso a determinadas secciones (panel de administración, gestión de productos y categorías) y aplicar lógica previa al procesamiento de cada petición.
- **Validación de formularios:** Se ha implementado la validación de formularios en el lado del servidor mediante las reglas de validación de Laravel, garantizando que los datos introducidos por el usuario cumplan los requisitos de formato e integridad antes de almacenarse en la base de datos.
- **Paginación, búsqueda y filtrado:** Uso de las funciones de paginación de Laravel junto con filtros y formularios de búsqueda para la consulta de clientes y pedidos por nombre, fecha y estado.
- **Service Layer:** Desacoplamiento de la lógica de negocio en `PedidoService`, que filtra productos y calcula totales, facilitando el testing y el mantenimiento.
- **Entorno de desarrollo:** Visual Studio Code.
- **Control de versiones:** Git y repositorio remoto en GitHub.
- **Configuración:** Archivo de variables de entorno (`.env`) para la conexión con la base de datos y otros parámetros de configuración de la aplicación.
- **Diseño y estructura:** Arquitectura cliente-servidor basada en controladores, modelos, services, policies y vistas Blade, con uso de más de 15 componentes reutilizables (`page-header`, `card`, `button`, `form-input`, `badge`, `alert`, `table`, etc.) para favorecer la mantenibilidad y ampliación del proyecto.
