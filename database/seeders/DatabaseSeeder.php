<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Cliente;
use App\Models\Producto;
use App\Models\Pedido;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear un usuario admin fijo con datos definidos
        $admin = User::factory()->create([
            'name' => 'Carmen Gomez Estevez',            // Nombre admin
            'email' => 'carmen@admin.com',                // Email admin
            'rol' => 'admin',                             // Rol admin
            'password' => bcrypt('123'),                  // Contraseña cifrada
        ]);

        // Crear 3 usuarios comerciales con rol y contraseña definida
        $comerciales = User::factory(3)->state([
            'password' => bcrypt('123'),                  // Contraseña cifrada
            'rol' => 'comercial',                          // Rol comercial
        ])->create();

        // Combinar comerciales y admin en un solo array para usar después
        $users = $comerciales->push($admin);

        // Crear 10 productos aleatorios 
        $productos = Producto::factory(10)->create();

        // Crear 10 clientes, y por cada uno comerciales 
        Cliente::factory(10)->create()->each(function ($cliente) use ($comerciales, $productos) {

            // Crear 2 pedidos por cliente
            for ($i = 0; $i < 2; $i++) {
                $comercial = $comerciales->random();     // Asignar comercial aleatorio

                $pedido = Pedido::factory()->create([
                    'cliente_id'   => $cliente->id,       // Asociar al cliente
                    'comercial_id' => $comercial->id,     // Asociar al comercial
                    'estado'       => fake()->randomElement(['pendiente', 'enviado', 'cancelado']), // Estado 
                    'total'        => 0,                   // Inicializar total en 0, se calcula después
                ]);

                $total = 0;

                // Seleccionar entre 1 y 4 productos aleatorios
                $productosSeleccionados = $productos->random(rand(1, 4));

                foreach ($productosSeleccionados as $producto) {
                    $cantidad = rand(1, 5);               // Cantidad aleatoria entre 1 y 5
                    $subtotal = $producto->precio * $cantidad; // Calcular subtotal
                    $total += $subtotal;                   // Acumular total

                    // Asociar producto al pedido con cantidad (tabla pivote)
                    $pedido->productos()->attach($producto->id, ['cantidad' => $cantidad]);
                }

                // Actualizar total en el pedido
                $pedido->update(['total' => $total]);
            }

        });

        $this->call(CatalogoSeeder::class);

    }
}
