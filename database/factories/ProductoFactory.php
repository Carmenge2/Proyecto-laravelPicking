<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define el estado por defecto para un modelo Producto al crear datos de prueba.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            // Nombre del producto, elegido aleatoriamente de una lista fija
            'nombre' => $this->faker->randomElement([
                'Pan integral artesanal',
                'Leche de almendra orgánica',
                'Huevos de gallinas libres',
                'Queso manchego curado',
                'Yogur natural sin azúcar',
                'Manzanas golden frescas',
                'Zumo de naranja natural',
                'Aceite de oliva virgen extra',
                'Cereal de avena ecológico',
                'Pechuga de pollo sin antibióticos',
            ]),

            // Descripción del producto, también seleccionada aleatoriamente
            'descripcion' => $this->faker->randomElement([
                'Producto elaborado con ingredientes naturales y de alta calidad para tu bienestar diario.',
                'Ideal para quienes buscan una alimentación saludable y equilibrada.',
                'Producto fresco, empaquetado cuidadosamente para conservar su sabor y aroma.',
                'Perfecto para acompañar tus comidas o como snack saludable entre horas.',
                'Elaborado siguiendo métodos tradicionales que garantizan su sabor auténtico.',
                'Producto sin conservantes ni aditivos, apto para toda la familia.',
                'Alta concentración de nutrientes esenciales para una dieta completa.',
                'Producto ecológico certificado, respetuoso con el medio ambiente.',
                'Fácil de preparar, ideal para personas con poco tiempo.',
                'Producto recomendado por expertos en nutrición y salud.',
            ]),

            // Precio con dos decimales, entre 1 y 50
            'precio' => $this->faker->randomFloat(2, 1, 50),

            // Estado del producto (disponible, agotado o pre-venta)
            'estado' => $this->faker->randomElement(['disponible', 'agotado', 'pre-venta']),

            // Stock disponible entre 0 y 100 unidades
            'stock' => $this->faker->numberBetween(0, 100),

            // Notas adicionales seleccionadas aleatoriamente para cada producto
            'notas_adicionales' => $this->faker->randomElement([
                'Producto sin gluten.',
                'Apto para veganos.',
                'Elaborado de forma artesanal.',
                'Origen nacional.',
                'Conservación en frío.',
                'Recomendado para dietas bajas en carbohidratos.',
                'Envasado al vacío para mayor frescura.',
                'Producto sostenible con certificado ecológico.',
                'Sin azúcares añadidos.',
                'Sin lactosa, apto para intolerantes.',
            ]),
        ];
    }
}
