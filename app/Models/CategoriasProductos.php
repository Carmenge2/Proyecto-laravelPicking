<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriasProductos extends Model
{
    protected $table = 'categorias_productos';

    protected $fillable = [
        'nombre',
        'imagen'
    ];

    // RELACIÓN: una categoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}

