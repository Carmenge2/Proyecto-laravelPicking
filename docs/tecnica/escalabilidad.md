# Escalabilidad y roadmap técnico

Mejoras recomendadas para evolucionar el proyecto hacia producción empresarial.

## Estado actual vs producción

| Aspecto | Estado actual | Recomendación |
|---------|--------------|---------------|
| Autorización | Middleware simple por rol | Añadir Policies para control granular |
| Validación | Inline en controller | Migrar a Form Requests |
| Tests | Estructura creada, sin tests | Añadir tests feature + unit |
| API | No existe | Crear API REST si se necesita app móvil |
| Notificaciones | No implementadas | Emails/notificaciones para pedidos |
| Soft deletes | No implementados | Activar para datos críticos |
| Auditoría | No existe | Log de cambios en registros |
| Cache | No configurada | Cache de catálogo público |
| CI/CD | No configurado | GitHub Actions / GitLab CI |

## Roadmap por prioridad

### Fase 1 — Seguridad y estabilidad (inmediato)

- [ ] **Restringir campo `rol` en registro** — actualmente cualquier usuario puede registrarse como admin.
- [ ] **Añadir Policies** para verificar que un comercial solo vea/edite sus propios clientes y pedidos.
- [ ] **Validar pertenencia** — un comercial no debería poder crear pedidos para clientes de otro comercial.
- [ ] **Rate limiting** en login para prevenir fuerza bruta.

### Fase 2 — Calidad de código (corto plazo)

- [ ] **Form Requests** — extraer validaciones a clases dedicadas (`StoreClienteRequest`, etc.).
- [ ] **Tests Feature** — tests para cada ruta protegida (verificar que comercial NO accede a admin).
- [ ] **Tests Unit** — tests para lógica de cálculo de totales en pedidos.
- [ ] **Soft Deletes** — en `clientes`, `pedidos`, `productos` para recuperar datos borrados.
- [ ] **Seeders completos** — datos de demostración para desarrollo y testing.

### Fase 3 — Funcionalidad (medio plazo)

- [ ] **Notificaciones por email** — al crear/enviar un pedido.
- [ ] **Exportación a PDF/Excel** — listados de pedidos y clientes.
- [ ] **Historial de pedidos** — log de cambios de estado.
- [ ] **Búsqueda avanzada** — filtros combinados en pedidos y productos.
- [ ] **Dashboard con métricas** — gráficos de ventas, top productos, etc.

### Fase 4 — Infraestructura (largo plazo)

- [ ] **API REST** — endpoints JSON para app móvil o integraciones.
- [ ] **API Tokens** — Sanctum para autenticación de API.
- [ ] **Cache** — Redis para catálogo público y contadores.
- [ ] **Queue Jobs** — envío de emails y generación de PDFs en background.
- [ ] **CI/CD** — pipeline de tests + deploy automático.
- [ ] **Monitoring** — Laravel Telescope en staging, Sentry en producción.

## Mejoras de arquitectura recomendadas

### 1. Policies (autorización granular)

```bash
php artisan make:policy ClientePolicy --model=Cliente
```

```php
// app/Policies/ClientePolicy.php
public function view(User $user, Cliente $cliente): bool
{
    return $user->rol === 'admin' || $cliente->comercial_id === $user->id;
}
```

### 2. Form Requests

```bash
php artisan make:request StoreClienteRequest
```

```php
// app/Http/Requests/StoreClienteRequest.php
public function rules(): array
{
    return [
        'nombre_comercial' => 'required|string|max:255',
        // ...
    ];
}
```

### 3. Service Layer (opcional para lógica compleja)

```
app/
└── Services/
    ├── PedidoService.php    → Lógica de cálculo de totales
    └── ProductoService.php  → Lógica de gestión de imágenes
```

### 4. Events + Listeners

```
PedidoCreado → EnviarNotificacionCliente
PedidoEnviado → ActualizarStock
```

## Consideraciones de rendimiento

| Problema potencial | Solución |
|-------------------|----------|
| N+1 en listados | Ya se usa eager loading (`with()`) |
| Catálogo público lento | Cachear categorías y productos (5 min TTL) |
| Imágenes pesadas | Implementar redimensionado al subir (intervention/image) |
| Listados grandes | Ya se usa paginación (10/pág) |
| Búsquedas complejas | Índices en BD en campos de búsqueda |

## Migración a permisos granulares (Spatie)

Si en el futuro se necesitan más de 2 roles o permisos por funcionalidad:

```bash
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan migrate
```

Esto permite:
- Roles ilimitados.
- Permisos individuales (`crear-producto`, `ver-pedidos-ajenos`, etc.).
- Asignación de permisos a roles o directamente a usuarios.
