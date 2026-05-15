<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Modelo de categoría de productos.
 * Agrupa productos del catálogo y puede tener una imagen representativa.
 */
class CategoriasProductos extends Model
{
    /** @var string Nombre de la tabla asociada. */
    protected $table = 'categorias_productos';

    /**
     * Atributos permitidos para asignación masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'imagen'
    ];

    /**
     * Relación 1:N — una categoría tiene muchos productos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}

