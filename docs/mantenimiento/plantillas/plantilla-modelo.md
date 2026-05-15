# Modelo: [NombreModelo]

> Copiar esta plantilla y rellenar al crear un nuevo modelo.

**Archivo:** `app/Models/[NombreModelo].php`

**Tabla:** `[nombre_tabla]`

## Campos

| Campo | Tipo | Nullable | Notas |
|-------|------|----------|-------|
| `id` | bigint (PK) | No | Auto-incremental |
| `campo1` | string | No | [Descripción] |
| `campo2` | string | Sí | [Descripción] |
| `created_at` | timestamp | No | — |
| `updated_at` | timestamp | No | — |

## Fillable

```php
protected $fillable = [
    'campo1',
    'campo2',
];
```

## Relaciones

| Método | Tipo | Modelo relacionado | FK | Notas |
|--------|------|-------------------|-----|-------|
| `relacion1()` | belongsTo | OtroModelo | `otro_id` | — |
| `relacion2()` | hasMany | OtroModelo2 | `este_modelo_id` | — |

## Migración asociada

**Archivo:** `database/migrations/YYYY_MM_DD_HHMMSS_create_[tabla]_table.php`

## Uso en controladores

- `[Nombre]Controller` — CRUD principal

## Notas

- [Particularidades, casts, accessors, mutators, scopes, etc.]
