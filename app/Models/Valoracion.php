<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Valoracion extends Model
{
    use HasFactory;

    protected $table = 'valoraciones';

    protected $fillable = [
        'cliente_id',     // Cliente que hace la valoración
        'valoracion',     // Puntuación (del 1 al 5, por ejemplo)
        'comentario',     // Comentarios adicionales del cliente
    ];

    /**
     * Relación: una valoración pertenece a un cliente.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /**
     * Relación: una valoración pertenece a un producto.
     */
    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }

    /**
     * Relación con el comercial 
     */
    public function comercial()
    {
        return $this->belongsTo(User::class, 'user_id');  
    }
}
