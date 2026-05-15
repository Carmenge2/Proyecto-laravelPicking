<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cliente extends Model
{
    use HasFactory;

    // Especifica la tabla en la base de datos asociada a este modelo
    protected $table = 'clientes';

    // Campos que se pueden asignar masivamente 
    protected $fillable = [
        'nombre_comercial',
        'razon_social',
        'email',
        'telefono',
        'direccion',
        'tipo_negocio',
        'comercial_id', // referencia al comercial asignado
    ];

    /**
     * Relación uno a muchos: un cliente puede tener varios pedidos
     * Define la relación con el modelo Pedido
     */
    public function pedidos()
    {
        return $this->hasMany(Pedido::class);
    }

    /**
     * Relación inversa: un cliente pertenece a un comercial (usuario)
     * 'comercial_id' es la llave foránea en esta tabla
     */
    public function comercial()
    {
        return $this->belongsTo(User::class, 'comercial_id');
    }
}
