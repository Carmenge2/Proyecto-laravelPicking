<?php

namespace App\Policies;

use App\Models\Cliente;
use App\Models\User;

/**
 * Policy de autorización para el recurso Cliente.
 * Un comercial solo puede modificar o eliminar los clientes que él creó.
 * El administrador tiene acceso total.
 */
class ClientePolicy
{
    /**
     * Determina si el usuario puede ver el listado de clientes.
     *
     * @param User $user
     * @return bool
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede ver un cliente específico.
     *
     * @param User $user
     * @param Cliente $cliente
     * @return bool
     */
    public function view(User $user, Cliente $cliente): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede crear clientes.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determina si el usuario puede actualizar un cliente.
     * Solo el admin o el comercial asignado pueden editar.
     *
     * @param User $user
     * @param Cliente $cliente
     * @return bool
     */
    public function update(User $user, Cliente $cliente): bool
    {
        return $user->rol === 'admin' || $cliente->comercial_id === $user->id;
    }

    /**
     * Determina si el usuario puede eliminar un cliente.
     * Solo el admin o el comercial asignado pueden eliminar.
     *
     * @param User $user
     * @param Cliente $cliente
     * @return bool
     */
    public function delete(User $user, Cliente $cliente): bool
    {
        return $user->rol === 'admin' || $cliente->comercial_id === $user->id;
    }
}
