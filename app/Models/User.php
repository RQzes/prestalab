<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public const ENCARGADO = 'encargado';
    public const ESTUDIANTE = 'estudiante';

    protected $fillable = ['name', 'email', 'password', 'rol'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function esEncargado(): bool
    {
        return $this->rol === self::ENCARGADO;
    }

    public function etiquetaRol(): string
    {
        return $this->esEncargado() ? 'Encargado' : 'Estudiante';
    }

    public function equiposPrestados(): HasMany
    {
        return $this->hasMany(Equipo::class, 'prestado_a');
    }
}
