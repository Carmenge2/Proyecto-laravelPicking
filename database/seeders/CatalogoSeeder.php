<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CategoriasProductos;
use App\Models\Producto;

class CatalogoSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'Frutas y Verduras' => [
                'Manzana Golden',
                'Plátano de Canarias',
                'Tomate Rama',
                'Lechuga Iceberg',
                'Zanahoria Bolsa 1kg',
            ],
            'Carnicería' => [
                'Pechuga de Pollo',
                'Ternera Filete Primera',
                'Hamburguesa Vacuno',
                'Salchichas Frescas',
            ],
            'Pescadería' => [
                'Salmón Fresco',
                'Merluza en Rodajas',
                'Gambas Cocidas',
                'Atún Fresco',
            ],
            'Quesos' => [
                'Leche Entera 1L',
                'Yogur Natural Pack 4',
                'Queso Curado',
                'Mantequilla 250g',
            ],
            'Bodega' => [
                'Vino tinto crianza «ELOY ESCUDERO» 750 CL',
                'Vino tinto «ELOY ESCUDERO» ROBLE -BOTELLA 720 CL',
            ],

        ];

        foreach ($data as $categoriaNombre => $productos) {

            $categoria = CategoriasProductos::create([
                'nombre' => $categoriaNombre,
                'imagen' => null,
            ]);

            foreach ($productos as $nombreProducto) {
                Producto::create([
                    'nombre' => $nombreProducto,
                    'categoria_id' => $categoria->id,
                    'imagen' => null,
                ]);
            }
        }
    }
}
