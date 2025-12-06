<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Mesa;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuario administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@tusabor.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Usuario cliente
        User::create([
            'name' => 'Cliente Prueba',
            'email' => 'cliente@tusabor.com',
            'password' => Hash::make('cliente123'),
            'role' => 'cliente',
        ]);

        // Categorías
        $entradas = Categoria::create(['nombre' => 'Entradas', 'descripcion' => 'Deliciosas entradas', 'activo' => true]);
        $platosFuertes = Categoria::create(['nombre' => 'Platos Fuertes', 'descripcion' => 'Platos principales', 'activo' => true]);
        $postres = Categoria::create(['nombre' => 'Postres', 'descripcion' => 'Dulces creaciones', 'activo' => true]);
        $bebidas = Categoria::create(['nombre' => 'Bebidas', 'descripcion' => 'Bebidas premium', 'activo' => true]);

        // Productos
        Producto::create(['categoria_id' => $entradas->id, 'nombre' => 'Carpaccio de Res', 'descripcion' => 'Finas láminas de res con rúcula', 'precio' => 18.50, 'disponible' => true, 'destacado' => true]);
        Producto::create(['categoria_id' => $platosFuertes->id, 'nombre' => 'Filete Mignon', 'descripcion' => 'Filete premium con papas', 'precio' => 35.00, 'disponible' => true, 'destacado' => true]);
        Producto::create(['categoria_id' => $platosFuertes->id, 'nombre' => 'Salmón a la Parrilla', 'descripcion' => 'Salmón fresco con vegetales', 'precio' => 28.00, 'disponible' => true, 'destacado' => true]);
        Producto::create(['categoria_id' => $postres->id, 'nombre' => 'Tiramisú Clásico', 'descripcion' => 'Postre italiano', 'precio' => 9.50, 'disponible' => true, 'destacado' => false]);
        Producto::create(['categoria_id' => $bebidas->id, 'nombre' => 'Vino Tinto Reserva', 'descripcion' => 'Copa de vino premium', 'precio' => 15.00, 'disponible' => true, 'destacado' => false]);

        // Mesas
        Mesa::create(['numero' => 'M-01', 'capacidad' => 2, 'ubicacion' => 'interior', 'disponible' => true]);
        Mesa::create(['numero' => 'M-02', 'capacidad' => 4, 'ubicacion' => 'interior', 'disponible' => true]);
        Mesa::create(['numero' => 'T-01', 'capacidad' => 6, 'ubicacion' => 'terraza', 'disponible' => true]);
        Mesa::create(['numero' => 'VIP-01', 'capacidad' => 8, 'ubicacion' => 'vip', 'disponible' => true]);
    }
}
