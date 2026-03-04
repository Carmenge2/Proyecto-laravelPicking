<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    /**
     * Define el estado por defecto para un modelo Cliente al crear datos de prueba.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'nombre_comercial' => $this->faker->company,
            'razon_social'     => $this->faker->companySuffix,// Sufijo de la empresa, tipo "S.A.", "Ltd.", etc.
            'email'            => $this->faker->unique()->safeEmail,// Correo electrónico seguro y único generado por Faker
            'telefono'         => $this->faker->phoneNumber,
            'direccion'        => $this->faker->address,
            'tipo_negocio'     => $this->faker->randomElement([
                'Fast_Food', 'Supermercado', 'Catering', 'Restaurante', 'Otro'
            ]),

            // ID de un usuario con rol 'comercial' seleccionado al azar.
            // Si no existe ninguno, crea uno nuevo con rol 'comercial' y toma su ID.
            'comercial_id'     => User::where('rol', 'comercial')
                ->inRandomOrder()
                ->first()?->id
                ?? User::factory()->create(['rol' => 'comercial'])->id,
        ];
    }
}
