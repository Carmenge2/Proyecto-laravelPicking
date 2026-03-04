<?php

namespace Database\Factories;

use App\Models\Cliente;
use Illuminate\Database\Eloquent\Factories\Factory;

class ValoracionFactory extends Factory
{
    public function definition(): array
    {
        return [
            'cliente_id' => Cliente::inRandomOrder()->first()->id ?? Cliente::factory()->create()->id, //para tomar el ID de un cliente existente en la BD. Si no hay ninguno, con ?? Cliente::factory() crea uno.
            'valoracion' => $this->faker->numberBetween(4, 5),  // Valoración entre 4 y 5
            'comentario' => $this->faker->randomElement([  // Comentarios predefinidos
                'Excelente servicio, muy contento con el producto.',
                'La calidad es inmejorable, pero el envío tardó más de lo esperado.',
                'Producto acorde a lo esperado, aunque la atención al cliente podría mejorar.',
                'Me ha encantado el producto, superó mis expectativas.',
                'Buen servicio, aunque tuve problemas con la entrega.'
            ]),
        ];
    }
}
