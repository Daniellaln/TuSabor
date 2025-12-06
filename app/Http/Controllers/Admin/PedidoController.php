<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    public function index()
    {
        $pedidos = Pedido::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        return view('admin.pedidos.index', compact('pedidos'));
    }

    public function show(Pedido $pedido)
    {
        $pedido->load(['user', 'detalles.producto']);
        return view('admin.pedidos.show', compact('pedido'));
    }

    public function updateEstado(Request $request, Pedido $pedido)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,preparando,en_camino,entregado,cancelado',
        ]);

        $pedido->update($validated);

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Estado de pedido actualizado exitosamente.');
    }

    public function destroy(Pedido $pedido)
    {
        $pedido->delete();

        return redirect()->route('admin.pedidos.index')
            ->with('success', 'Pedido eliminado exitosamente.');
    }
}
