<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas';

    protected $fillable = [
        'user_id',
        'mesa_id',
        'fecha_hora',
        'num_personas',
        'observaciones',
        'estado',
    ];

    protected $casts = [
        'fecha_hora' => 'datetime',
        'num_personas' => 'integer',
    ];

    /**
     * Relación: Una reserva pertenece a un usuario
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación: Una reserva pertenece a una mesa
     */
    public function mesa()
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }
}
