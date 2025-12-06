<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    use HasFactory;

    protected $table = 'mesas';

    protected $fillable = [
        'numero',
        'capacidad',
        'ubicacion',
        'disponible',
    ];

    protected $casts = [
        'capacidad' => 'integer',
        'disponible' => 'boolean',
    ];

    /**
     * Relación: Una mesa puede tener muchas reservas
     */
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'mesa_id');
    }
}
