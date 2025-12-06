<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'categoria_id',
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'disponible',
        'destacado',
    ];

    protected $casts = [
        'precio' => 'decimal:2',
        'disponible' => 'boolean',
        'destacado' => 'boolean',
    ];

    /**
     * Relación: Un producto pertenece a una categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    /**
     * Relación: Un producto puede estar en muchos detalles de pedidos
     */
    public function detallePedidos()
    {
        return $this->hasMany(DetallePedido::class, 'producto_id');
    }

    /**
     * Relación: Un producto puede estar en muchos carritos
     */
    public function carritos()
    {
        return $this->hasMany(Carrito::class, 'producto_id');
    }
}
