<?php

namespace App\Services;

use App\Models\Producto;
use Illuminate\Support\Collection;

class PedidoService
{
    /**
     * Filtra productos seleccionados (cantidad > 0) y los mapea con su cantidad.
     */
    public function filtrarProductos(array $productos): Collection
    {
        return collect($productos)
            ->filter(fn($p) => isset($p['cantidad']) && $p['cantidad'] > 0)
            ->mapWithKeys(fn($p, $id) => [
                (int)$id => ['cantidad' => $p['cantidad']]
            ]);
    }

    /**
     * Calcula el total de un pedido basándose en los precios de BD.
     */
    public function calcularTotal(Collection $productosSeleccionados): float
    {
        $productosDB = Producto::whereIn('id', $productosSeleccionados->keys())->get();

        $total = 0;

        foreach ($productosDB as $producto) {
            $cantidad = $productosSeleccionados[$producto->id]['cantidad'];
            $total += $producto->precio * $cantidad;
        }

        return $total;
    }
}
