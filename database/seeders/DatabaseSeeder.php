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
        // Admin
        $admin = User::updateOrCreate(
            ['email' => 'carmen@admin.com'],
            [
                'name' => 'Carmen Gomez Estevez',
                'rol' => 'admin',
                'password' => bcrypt('123'),
                'email_verified_at' => now(),
            ]
        );

        // Comercial fijo
        $raul = User::updateOrCreate(
            ['email' => 'raul@comercial.com'],
            [
                'name' => 'Raul Romero',
                'rol' => 'comercial',
                'password' => bcrypt('123'),
                'email_verified_at' => now(),
            ]
        );

        // Comerciales aleatorios
        $comerciales = User::factory(3)->state([
            'password' => bcrypt('123'),
            'rol' => 'comercial',
        ])->create();

        // Añadir Raul a comerciales
        $comerciales->push($raul);

        // Productos
        if (Producto::count() == 0) {
            $productos = Producto::factory(10)->create();
        } else {
            $productos = Producto::all();
        }

        // Clientes y pedidos
        if (Cliente::count() == 0) {

            Cliente::factory(10)->create()->each(function ($cliente) use ($comerciales, $productos) {

                for ($i = 0; $i < 2; $i++) {

                    $comercial = $comerciales->random();

                    $pedido = Pedido::factory()->create([
                        'cliente_id'   => $cliente->id,
                        'comercial_id' => $comercial->id,
                        'estado'       => fake()->randomElement([
                            'pendiente',
                            'enviado',
                            'cancelado'
                        ]),
                        'total'        => 0,
                    ]);

                    $total = 0;

                    $productosSeleccionados = $productos->random(rand(1, 4));

                    foreach ($productosSeleccionados as $producto) {

                        $cantidad = rand(1, 5);

                        $subtotal = $producto->precio * $cantidad;

                        $total += $subtotal;

                        $pedido->productos()->attach(
                            $producto->id,
                            ['cantidad' => $cantidad]
                        );
                    }

                    $pedido->update([
                        'total' => $total
                    ]);
                }
            });
        }

        $this->call(CatalogoSeeder::class);
    }
}