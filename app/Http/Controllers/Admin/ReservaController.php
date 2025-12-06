<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;

class ReservaController extends Controller
{
    public function index()
    {
        $reservas = Reserva::with(['user', 'mesa'])
            ->orderBy('fecha_hora', 'desc')
            ->paginate(15);
        
        return view('admin.reservas.index', compact('reservas'));
    }

    public function show(Reserva $reserva)
    {
        $reserva->load(['user', 'mesa']);
        return view('admin.reservas.show', compact('reserva'));
    }

    public function updateEstado(Request $request, Reserva $reserva)
    {
        $validated = $request->validate([
            'estado' => 'required|in:pendiente,confirmada,cancelada,completada',
        ]);

        $reserva->update($validated);

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Estado de reserva actualizado exitosamente.');
    }

    public function destroy(Reserva $reserva)
    {
        $reserva->delete();

        return redirect()->route('admin.reservas.index')
            ->with('success', 'Reserva eliminada exitosamente.');
    }
}
