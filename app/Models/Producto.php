<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo de producto.
 * Representa un artículo del catálogo con nombre, precio, stock, estado
 * e imagen. Pertenece a una categoría y puede aparecer en múltiples pedidos.
 */
class Producto extends Model
{
    use HasFactory;

    /** @var string Nombre de la tabla asociada. */
    protected $table = 'productos';

    /**
     * Atributos permitidos para asignación masiva.
     *
     * @var array<int, string>
     */
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
     * Relación N:M — un producto puede estar en varios pedidos.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pedidos()
    {
        return $this->belongsToMany(Pedido::class)
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    /**
     * Relación N:1 — un producto pertenece a una categoría.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categoria()
    {
        return $this->belongsTo(CategoriasProductos::class, 'categoria_id');
    }




}
