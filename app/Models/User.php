<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo de usuario.
 * Representa a los administradores y comerciales del sistema.
 * Incluye soporte para autenticación, verificación de email y remember token.
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atributos permitidos para asignación masiva.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * Atributos ocultos en serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión de tipos para atributos del modelo.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
