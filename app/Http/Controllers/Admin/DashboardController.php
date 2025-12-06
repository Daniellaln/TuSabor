<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Reserva;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $totalPedidos = Pedido::count();
        $totalReservas = Reserva::count();
        $totalProductos = Producto::count();
        $totalClientes = User::where('role', 'cliente')->count();
        
        // Ingresos totales
        $ingresosTotales = Pedido::where('estado', '!=', 'cancelado')->sum('total');
        
        // Ventas de hoy
        $ventasHoy = Pedido::whereDate('created_at', today())
            ->where('estado', '!=', 'cancelado')
            ->sum('total');
        
        // Pedidos por estado
        $pedidosPorEstado = Pedido::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();
        
        // Reservas por estado
        $reservasPorEstado = Reserva::select('estado', DB::raw('count(*) as total'))
            ->groupBy('estado')
            ->get();
        
        // Productos más vendidos (usando procedimiento almacenado)
        $productosMasVendidos = DB::select('CALL sp_productos_mas_vendidos(?)', [5]);
        
        // Ventas de los últimos 7 días
        $fechaInicio = now()->subDays(7)->format('Y-m-d');
        $fechaFin = now()->format('Y-m-d');
        $ventasRecientes = DB::select('CALL sp_estadisticas_ventas(?, ?)', [$fechaInicio, $fechaFin]);
        
        // Pedidos recientes
        $pedidosRecientes = Pedido::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Reservas de hoy
        $reservasHoy = DB::select('CALL sp_reservas_por_fecha(?)', [now()->format('Y-m-d')]);
        
        return view('admin.dashboard', compact(
            'totalPedidos',
            'totalReservas',
            'totalProductos',
            'totalClientes',
            'ingresosTotales',
            'ventasHoy',
            'pedidosPorEstado',
            'reservasPorEstado',
            'productosMasVendidos',
            'ventasRecientes',
            'pedidosRecientes',
            'reservasHoy'
        ));
    }
}
