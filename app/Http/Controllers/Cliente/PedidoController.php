<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use App\Models\Carrito;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::where('user_id', auth()->id())
            ->with('detalles.producto')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('cliente.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        if ($pedido->user_id !== auth()->id()) {
            abort(403);
        }

        $pedido->load('detalles.producto');
        return view('cliente.pedidos.show', compact('pedido'));
    }

    public function checkout()
    {
        $items = Carrito::where('user_id', auth()->id())
            ->with('producto')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('cliente.carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        // Calcular totales
        $totales = DB::select('CALL sp_calcular_total_carrito(?)', [auth()->id()]);
        $subtotal = $totales[0]->total ?? 0;
        $costoEnvio = 5.00; // Costo fijo de envío
        $total = $subtotal + $costoEnvio;

        return view('cliente.pedidos.checkout', compact('items', 'subtotal', 'costoEnvio', 'total'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'direccion_entrega' => 'required|string|max:255',
            'telefono' => 'required|numeric|digits_between:9,15',
            'observaciones' => 'nullable|string|max:500',
        ], [
            'telefono.numeric' => 'El teléfono debe contener solo números.',
            'telefono.digits_between' => 'El teléfono debe tener entre 9 y 15 dígitos.',
        ]);

        // Verificar que el carrito no esté vacío
        $items = Carrito::where('user_id', auth()->id())->count();
        if ($items === 0) {
            return redirect()->route('cliente.carrito.index')
                ->with('error', 'Tu carrito está vacío.');
        }

        // Crear pedido usando procedimiento almacenado
        $costoEnvio = 5.00;
        $resultado = DB::select('CALL sp_crear_pedido_desde_carrito(?, ?, ?, ?, ?)', [
            auth()->id(),
            $validated['direccion_entrega'],
            $validated['telefono'],
            $costoEnvio,
            $validated['observaciones'] ?? null,
        ]);

        $pedidoId = $resultado[0]->pedido_id;

        return redirect()->route('cliente.pedidos.show', $pedidoId)
            ->with('success', 'Pedido realizado exitosamente. ¡Gracias por tu compra!');
    }

    public function cancelar(Pedido $pedido)
    {
        if ($pedido->user_id !== auth()->id()) {
            abort(403);
        }

        if ($pedido->estado !== 'pendiente') {
            return back()->with('error', 'Solo puedes cancelar pedidos pendientes.');
        }

        $pedido->update(['estado' => 'cancelado']);

        return back()->with('success', 'Pedido cancelado exitosamente.');
    }
}
