# Documentación del Proyecto Laravel Picking

Índice general de la documentación técnica y funcional del proyecto.

## Guía de lectura por perfil

| Perfil | Documentos recomendados |
|--------|------------------------|
| 🟢 **Desarrollador junior** | Todos los de arquitectura + técnica + mantenimiento |
| 🔵 **Administrador** | [Manual de administrador](./manuales/manual-administrador.md) |
| 🟠 **Comercial** | [Manual de comercial](./manuales/manual-comercial.md) |

## Índice completo

### Arquitectura

| Documento | Descripción |
|-----------|-------------|
| [Visión general](./arquitectura/vision-general.md) | Patrón MVC, stack, decisiones de diseño |
| [Diagramas](./arquitectura/diagramas.md) | ER, flujo auth, pedidos, roles, módulos (Mermaid) |
| [Middlewares y rutas](./arquitectura/middlewares-rutas.md) | Tabla de rutas, middleware de roles, registro |

### Documentación técnica

| Documento | Descripción |
|-----------|-------------|
| [Instalación](./tecnica/instalacion.md) | Manual paso a paso para levantar el proyecto |
| [Modelos y base de datos](./tecnica/modelos-y-bd.md) | Tablas, relaciones, migraciones |
| [Controladores](./tecnica/controladores.md) | Métodos, validaciones, patrones de respuesta |
| [Convenciones](./tecnica/convenciones.md) | Naming, estructura, estilo de código |
| [Escalabilidad](./tecnica/escalabilidad.md) | Roadmap técnico y mejoras futuras |

### Manuales de usuario

| Documento | Audiencia |
|-----------|-----------|
| [Manual de administrador](./manuales/manual-administrador.md) | Usuarios con rol `admin` |
| [Manual de comercial](./manuales/manual-comercial.md) | Usuarios con rol `comercial` |

### Mantenimiento

| Documento | Descripción |
|-----------|-------------|
| [Estrategia de documentación](./mantenimiento/estrategia-documentacion.md) | Cuándo y quién actualiza cada doc |
| [Plantilla: controlador](./mantenimiento/plantillas/plantilla-controlador.md) | Template para documentar controllers |
| [Plantilla: modelo](./mantenimiento/plantillas/plantilla-modelo.md) | Template para documentar modelos |

## Orden de lectura recomendado (desarrollador)

1. `arquitectura/vision-general.md` — entender el sistema
2. `arquitectura/diagramas.md` — visualizar relaciones y flujos
3. `tecnica/instalacion.md` — levantar el entorno
4. `tecnica/modelos-y-bd.md` — entender los datos
5. `arquitectura/middlewares-rutas.md` — entender las rutas
6. `tecnica/controladores.md` — entender la lógica
7. `tecnica/convenciones.md` — mantener el estilo
