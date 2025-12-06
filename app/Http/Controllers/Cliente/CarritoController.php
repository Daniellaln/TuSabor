<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Carrito;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CarritoController extends Controller
{
    public function index()
    {
        $items = Carrito::where('user_id', auth()->id())
            ->with('producto.categoria')
            ->get();
        
        // Calcular totales usando procedimiento almacenado
        $totales = DB::select('CALL sp_calcular_total_carrito(?)', [auth()->id()]);
        $totalCarrito = $totales[0]->total ?? 0;
        $totalItems = $totales[0]->total_items ?? 0;
        
        return view('cliente.carrito.index', compact('items', 'totalCarrito', 'totalItems'));
    }

    public function agregar(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1|max:99',
        ]);

        if (!$producto->disponible) {
            return back()->with('error', 'Este producto no está disponible.');
        }

        $item = Carrito::where('user_id', auth()->id())
            ->where('producto_id', $producto->id)
            ->first();

        if ($item) {
            $item->cantidad += $validated['cantidad'];
            $item->save();
        } else {
            Carrito::create([
                'user_id' => auth()->id(),
                'producto_id' => $producto->id,
                'cantidad' => $validated['cantidad'],
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function actualizar(Request $request, Carrito $carrito)
    {
        if ($carrito->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'cantidad' => 'required|integer|min:1|max:99',
        ]);

        $carrito->update($validated);

        return back()->with('success', 'Cantidad actualizada.');
    }

    public function eliminar(Carrito $carrito)
    {
        if ($carrito->user_id !== auth()->id()) {
            abort(403);
        }

        $carrito->delete();

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function vaciar()
    {
        Carrito::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Carrito vaciado.');
    }

    public function count()
    {
        $count = Carrito::where('user_id', auth()->id())->sum('cantidad');
        return response()->json(['count' => $count]);
    }
}
