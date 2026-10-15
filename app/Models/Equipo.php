<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Equipo extends Model
{
    public const DISPONIBLE = 'Disponible';
    public const PRESTADO = 'Prestado';

    protected $fillable = ['codigo', 'nombre', 'categoria', 'estado', 'prestado_a'];

    public function prestatario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'prestado_a');
    }

    public function scopeDisponibles(Builder $query): Builder
    {
        return $query->where('estado', self::DISPONIBLE);
    }

    public function estaPrestado(): bool
    {
        return $this->estado === self::PRESTADO;
    }
}
