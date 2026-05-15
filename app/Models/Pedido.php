<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Modelo de pedido.
 * Representa una orden de compra con cliente, productos, total, estado
 * y comercial asignado. La relación con productos es N:M a través
 * de la tabla pivote pedido_producto con atributo cantidad.
 */
class Pedido extends Model
{
    use HasFactory;

    /**
     * Atributos permitidos para asignación masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'cliente_id',
        'cantidad',
        'total',
        'estado',
        'comercial_id',
        'fecha',
    ];

    /**
     * Relación N:1 — un pedido pertenece a un cliente.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación N:M — un pedido incluye varios productos con cantidad.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function productos()
    {
        return $this->belongsToMany(Producto::class)
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    /**
     * Relación N:1 — un pedido fue creado por un comercial.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function comercial()
    {
        return $this->belongsTo(User::class, 'comercial_id');
    }
}
