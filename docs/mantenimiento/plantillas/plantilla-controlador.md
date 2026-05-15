# [NombreController]

> Copiar esta plantilla y rellenar al crear un nuevo controlador.

**Archivo:** `app/Http/Controllers/[Nombre]Controller.php`

**Namespace:** `App\Http\Controllers`

**Responsabilidad:** [Describir en 1 frase qué gestiona este controller]

## Métodos

| Método | Ruta | Descripción |
|--------|------|-------------|
| `index(Request)` | GET `/recurso` | [Qué hace] |
| `create()` | GET `/recurso/create` | [Qué hace] |
| `store(Request)` | POST `/recurso` | [Qué hace] |
| `show(Modelo)` | GET `/recurso/{id}` | [Qué hace] |
| `edit(Modelo)` | GET `/recurso/{id}/edit` | [Qué hace] |
| `update(Request, Modelo)` | PUT `/recurso/{id}` | [Qué hace] |
| `destroy(Modelo)` | DELETE `/recurso/{id}` | [Qué hace] |

## Validación

| Campo | Reglas |
|-------|--------|
| `campo1` | [reglas] |
| `campo2` | [reglas] |

## Middleware aplicado

- `auth`
- `role:[rol]`

## Relaciones/modelos usados

- `Modelo1` — [para qué]
- `Modelo2` — [para qué]

## Notas

- [Cualquier particularidad, lógica de negocio especial, etc.]
