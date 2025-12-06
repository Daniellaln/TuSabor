<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use App\Models\Mesa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::where('user_id', auth()->id())
            ->with('mesa')
            ->orderBy('fecha_hora', 'desc')
            ->paginate(10);
        
        return view('cliente.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $mesas = Mesa::where('disponible', true)
            ->orderBy('capacidad')
            ->get();
        
        return view('cliente.reservas.create', compact('mesas'));
    }

    public function verificarDisponibilidad(Request $request)
    {
        $validated = $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'fecha_hora' => 'required|date|after:now',
        ]);

        $resultado = DB::select('CALL sp_verificar_disponibilidad_mesa(?, ?)', [
            $validated['mesa_id'],
            $validated['fecha_hora'],
        ]);

        return response()->json([
            'disponible' => $resultado[0]->disponible == 1,
            'mensaje' => $resultado[0]->mensaje,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mesa_id' => 'required|exists:mesas,id',
            'fecha_hora' => 'required|date|after:now',
            'num_personas' => 'required|integer|min:1|max:20',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Verificar disponibilidad
        $disponibilidad = DB::select('CALL sp_verificar_disponibilidad_mesa(?, ?)', [
            $validated['mesa_id'],
            $validated['fecha_hora'],
        ]);

        if ($disponibilidad[0]->disponible != 1) {
            return back()->with('error', 'La mesa no está disponible en ese horario. Por favor elige otro horario.');
        }

        // Verificar capacidad de la mesa
        $mesa = Mesa::find($validated['mesa_id']);
        if ($validated['num_personas'] > $mesa->capacidad) {
            return back()->with('error', 'El número de personas excede la capacidad de la mesa seleccionada.');
        }

        // Crear reserva
        Reserva::create([
            'user_id' => auth()->id(),
            'mesa_id' => $validated['mesa_id'],
            'fecha_hora' => $validated['fecha_hora'],
            'num_personas' => $validated['num_personas'],
            'observaciones' => $validated['observaciones'],
            'estado' => 'pendiente',
        ]);

        return redirect()->route('cliente.reservas.index')
            ->with('success', 'Reserva creada exitosamente. Te confirmaremos pronto.');
    }

    public function show(Reserva $reserva)
    {
        if ($reserva->user_id !== auth()->id()) {
            abort(403);
        }

        $reserva->load('mesa');
        return view('cliente.reservas.show', compact('reserva'));
    }

    public function cancelar(Reserva $reserva)
    {
        if ($reserva->user_id !== auth()->id()) {
            abort(403);
        }

        if (!in_array($reserva->estado, ['pendiente', 'confirmada'])) {
            return back()->with('error', 'No puedes cancelar esta reserva.');
        }

        $reserva->update(['estado' => 'cancelada']);

        return back()->with('success', 'Reserva cancelada exitosamente.');
    }
}
