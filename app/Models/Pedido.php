<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pedido extends Model
{
    use HasFactory;

    protected $fillable = [
    'cliente_id', 
    'cantidad',
    'total',
    'estado',
    'comercial_id',
    'fecha',  
];

    // Relación con cliente 
    public function cliente()
    {
        return $this->belongsTo(Cliente::class); 
    }

    // Relación con productos (muchos a muchos)
    public function productos()  
    {
        return $this->belongsToMany(Producto::class)
                    ->withPivot('cantidad')
                    ->withTimestamps();
    }

    // Relación con el comercial 
    public function comercial()
    {
        return $this->belongsTo(User::class, 'comercial_id'); 
    }

}
