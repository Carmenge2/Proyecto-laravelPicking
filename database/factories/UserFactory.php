<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    // Variable estática para almacenar la contraseña hasheada y reutilizarla
    protected static ?string $password;

    /**
     * Define el estado por defecto para un modelo User al crear datos de prueba.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),//la actual
            'password' => static::$password ??= Hash::make('password'), // Contraseña encriptada. Se almacena en la variable estática para no repetir el hash.
            // Si no está seteada, se genera con 'password'
            'rol' => 'comercial',// Rol del usuario, por defecto 'comercial'
            'remember_token' => Str::random(10),// Token para recordar sesión, generado aleatoriamente
        ];
    }

    /**
     * Estado que indica que el email no ha sido verificado.
     * Esto puede usarse para crear usuarios con email sin verificar.
     *
     * @return static
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
