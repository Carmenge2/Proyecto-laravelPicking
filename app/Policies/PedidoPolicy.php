<?php

namespace App\Policies;

use App\Models\Pedido;
use App\Models\User;

/**
 * Policy de autorización para el recurso Pedido.
 * Un comercial solo puede modificar o eliminar los pedidos que él creó.
 * El administrador tiene acceso total.
 */
class PedidoPolicy
{
    /**
     * Determina si el usuario puede ver el listado de pedidos.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede ver un pedido específico.
     *
     * @param User $user
     * @param Pedido $pedido
     * @return bool
     */
    public function view(User $user, Pedido $pedido): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede crear pedidos.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede actualizar un pedido.
     * Solo el admin o el comercial creador pueden editar.
     *
     * @param User $user
     * @param Pedido $pedido
     * @return bool
     */
    public function update(User $user, Pedido $pedido): bool
    {
        return $user->rol === 'admin' || $pedido->comercial_id === $user->id;
    }

    /**
     * Determina si el usuario puede eliminar un pedido.
     * Solo el admin o el comercial creador pueden eliminar.
     *
     * @param User $user
     * @param Pedido $pedido
     * @return bool
     */
    public function delete(User $user, Pedido $pedido): bool
    {
        return $user->rol === 'admin' || $pedido->comercial_id === $user->id;
    }
}
