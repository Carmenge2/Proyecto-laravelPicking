# Estrategia de mantenimiento de documentación

Guía para mantener la documentación actualizada y útil a lo largo del ciclo de vida del proyecto.

## Principios

1. **La documentación es código** — se versiona en Git junto al proyecto.
2. **Actualizar al mismo tiempo que el código** — no dejar para después.
3. **Menos es más** — mejor poca documentación actualizada que mucha obsoleta.
4. **Un responsable por tipo** — cada documento tiene un "owner".

## Responsables

| Tipo de documento | Responsable | Frecuencia de revisión |
|-------------------|-------------|----------------------|
| Arquitectura (vision-general, diagramas) | Tech Lead / Senior | Cada sprint o cambio arquitectónico |
| Middlewares y rutas | Desarrollador que modifica rutas | Con cada PR que toque rutas |
| Modelos y BD | Desarrollador que crea migraciones | Con cada nueva migración |
| Controladores | Desarrollador que modifica el controller | Con cada PR que toque controllers |
| Convenciones | Tech Lead | Trimestral |
| Escalabilidad | Tech Lead | Cada planning/sprint |
| Manual administrador | QA o Product Owner | Cada cambio en UI admin |
| Manual comercial | QA o Product Owner | Cada cambio en UI comercial |
| Instalación | DevOps / cualquier dev | Cada cambio en requisitos o .env |

## Cuándo actualizar cada documento

| Evento | Documentos a actualizar |
|--------|------------------------|
| Nueva migración creada | `modelos-y-bd.md`, `diagramas.md` (ER) |
| Nuevo controller/método | `controladores.md`, `middlewares-rutas.md` |
| Cambio en middleware o roles | `middlewares-rutas.md`, `diagramas.md` (roles) |
| Nueva dependencia añadida | `vision-general.md` (stack), `instalacion.md` |
| Cambio en UI del admin | `manual-administrador.md` |
| Cambio en UI del comercial | `manual-comercial.md` |
| Nuevo .env variable | `instalacion.md` |
| Refactoring arquitectónico | `vision-general.md`, `diagramas.md` |

## Checklist pre-release

Antes de cada release o merge a main, verificar:

- [ ] ¿Se han añadido nuevas tablas/campos? → Actualizar `modelos-y-bd.md`
- [ ] ¿Se han añadido nuevas rutas? → Actualizar `middlewares-rutas.md`
- [ ] ¿Ha cambiado la UI para admin/comercial? → Actualizar manuales
- [ ] ¿Se necesita nueva variable de entorno? → Actualizar `instalacion.md`
- [ ] ¿Los diagramas Mermaid siguen siendo correctos? → Verificar en preview

## Checklist para PR (Pull Request)

Incluir en la template de PR:

```markdown
## Documentación
- [ ] He actualizado la documentación afectada en `/docs`
- [ ] Los diagramas Mermaid están actualizados
- [ ] No se requieren cambios en documentación (justificar)
```

## Herramientas recomendadas

| Herramienta | Propósito |
|-------------|-----------|
| Mermaid Live Editor | Previsualizar diagramas: https://mermaid.live |
| Markdown preview (IDE) | Verificar formato antes de commit |
| Git diff en `/docs` | Revisar cambios de docs en cada PR |

## Versionado de documentación

- La documentación vive en la rama `main` junto al código.
- No se versionan números de versión en los docs (se usa Git history).
- Para cambios grandes, crear una rama `docs/nombre-cambio` y hacer PR.

## Formato obligatorio

- Todo en **Markdown** estándar (compatible GitHub).
- Diagramas en **Mermaid** embebidos (no imágenes externas).
- Tablas para datos tabulares (no listas largas).
- Encabezados jerárquicos: `#` → `##` → `###` (no saltar niveles).
- Código con indicador de lenguaje: ` ```php `, ` ```bash `, etc.
