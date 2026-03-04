<?php

namespace Database\Factories;

use App\Models\Cliente;
use App\Models\Producto;
use App\Models\User;
//use App\Models\Comercial; // Si tienes este modelo para comerciales
use Illuminate\Database\Eloquent\Factories\Factory;


class PedidoFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id'   => Cliente::factory(),     // Asignamos un cliente aleatorio
            'cantidad'     => $this->faker->numberBetween(1, 10),  // Cantidad de productos en el pedido
            'total'        => $this->faker->randomFloat(2, 10, 500), // Precio total aleatorio (con 2 decimales)
            'estado'       => $this->faker->randomElement(['pendiente', 'enviado', 'cancelado']),
            'comercial_id' => User::where('rol', 'comercial')->inRandomOrder()->first()->id,
        ];
    }
}
