<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'estado', // disponible, agotado, pre-venta
        'categoria_id',
        'imagen',
    ];

    /**
     * Relación con pedidos (un producto puede estar en muchos pedidos)
     */
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }
   // RELACIÓN: un producto pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(CategoriasProductos::class, 'categoria_id');
    }




}
