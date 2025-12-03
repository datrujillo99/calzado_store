<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // <--- AGREGADO: Importante para poder asignar roles
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
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

    /* * ---------------------------------------------------------
     * RELACIONES Y MÉTODOS PERSONALIZADOS
     * ---------------------------------------------------------
     */

    /**
     * Relación: Un usuario puede tener muchas ventas (compras).
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    /**
     * Helper para saber si el usuario es administrador.
     * Uso: if ($user->isAdmin()) { ... }
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}