<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CategoriaController;
use App\Http\Controllers\Admin\ProductoController as AdminProductoController;
use App\Http\Controllers\Admin\MesaController;
use App\Http\Controllers\Admin\ReservaController as AdminReservaController;
use App\Http\Controllers\Admin\PedidoController as AdminPedidoController;
use App\Http\Controllers\Cliente\CatalogoController;
use App\Http\Controllers\Cliente\CarritoController;
use App\Http\Controllers\Cliente\PedidoController as ClientePedidoController;
use App\Http\Controllers\Cliente\ReservaController as ClienteReservaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Ruta principal - Redirige según el rol del usuario
Route::get('/', function () {
    if (auth()->check()) {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('cliente.catalogo.index');
        }
    }
    return view('welcome');
})->name('home');

// Rutas públicas
Route::get('/nosotros', function () {
    return view('about');
})->name('about');

Route::get('/equipo', function () {
    return view('equipo');
})->name('equipo');

// Rutas de autenticación (Breeze)
require __DIR__.'/auth.php';

// Rutas del chatbot (accesible para todos los usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::post('/chatbot/send', [ChatbotController::class, 'send'])->name('chatbot.send');
});

// Rutas de perfil (accesible para todos los usuarios autenticados)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ============================================
// RUTAS DE ADMINISTRADOR
// ============================================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Categorías
    Route::resource('categorias', CategoriaController::class);
    
    // CRUD Productos
    Route::resource('productos', AdminProductoController::class);
    
    // CRUD Mesas
    Route::resource('mesas', MesaController::class);
    
    // Gestión de Reservas
    Route::get('/reservas', [AdminReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/{reserva}', [AdminReservaController::class, 'show'])->name('reservas.show');
    Route::patch('/reservas/{reserva}/estado', [AdminReservaController::class, 'updateEstado'])->name('reservas.updateEstado');
    Route::delete('/reservas/{reserva}', [AdminReservaController::class, 'destroy'])->name('reservas.destroy');
    
    // Gestión de Pedidos
    Route::get('/pedidos', [AdminPedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/{pedido}', [AdminPedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{pedido}/estado', [AdminPedidoController::class, 'updateEstado'])->name('pedidos.updateEstado');
    Route::delete('/pedidos/{pedido}', [AdminPedidoController::class, 'destroy'])->name('pedidos.destroy');
});

// ============================================
// RUTAS DE CLIENTE
// ============================================
Route::middleware(['auth', 'cliente'])->prefix('cliente')->name('cliente.')->group(function () {
    
    // Catálogo de productos
    Route::get('/catalogo', [CatalogoController::class, 'index'])->name('catalogo.index');
    Route::get('/catalogo/{producto}', [CatalogoController::class, 'show'])->name('catalogo.show');
    
    // Carrito de compras
    Route::get('/carrito', [CarritoController::class, 'index'])->name('carrito.index');
    Route::get('/carrito/count', [CarritoController::class, 'count'])->name('carrito.count');
    Route::post('/carrito/{producto}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
    Route::patch('/carrito/{carrito}', [CarritoController::class, 'actualizar'])->name('carrito.actualizar');
    Route::delete('/carrito/{carrito}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
    Route::delete('/carrito', [CarritoController::class, 'vaciar'])->name('carrito.vaciar');
    
    // Pedidos
    Route::get('/pedidos', [ClientePedidoController::class, 'index'])->name('pedidos.index');
    Route::get('/pedidos/checkout', [ClientePedidoController::class, 'checkout'])->name('pedidos.checkout');
    Route::post('/pedidos', [ClientePedidoController::class, 'store'])->name('pedidos.store');
    Route::get('/pedidos/{pedido}', [ClientePedidoController::class, 'show'])->name('pedidos.show');
    Route::patch('/pedidos/{pedido}/cancelar', [ClientePedidoController::class, 'cancelar'])->name('pedidos.cancelar');
    
    // Reservas
    Route::get('/reservas', [ClienteReservaController::class, 'index'])->name('reservas.index');
    Route::get('/reservas/crear', [ClienteReservaController::class, 'create'])->name('reservas.create');
    Route::post('/reservas/verificar-disponibilidad', [ClienteReservaController::class, 'verificarDisponibilidad'])->name('reservas.verificarDisponibilidad');
    Route::post('/reservas', [ClienteReservaController::class, 'store'])->name('reservas.store');
    Route::get('/reservas/{reserva}', [ClienteReservaController::class, 'show'])->name('reservas.show');
    Route::patch('/reservas/{reserva}/cancelar', [ClienteReservaController::class, 'cancelar'])->name('reservas.cancelar');
});
