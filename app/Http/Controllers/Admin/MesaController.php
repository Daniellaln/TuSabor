<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    public function index()
    {
        $mesas = Mesa::withCount('reservas')->paginate(10);
        return view('admin.mesas.index', compact('mesas'));
    }

    public function create()
    {
        return view('admin.mesas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:255|unique:mesas',
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'required|in:interior,terraza,vip',
            'disponible' => 'boolean',
        ]);

        Mesa::create($validated);

        return redirect()->route('admin.mesas.index')
            ->with('success', 'Mesa creada exitosamente.');
    }

    public function edit(Mesa $mesa)
    {
        return view('admin.mesas.edit', compact('mesa'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $validated = $request->validate([
            'numero' => 'required|string|max:255|unique:mesas,numero,' . $mesa->id,
            'capacidad' => 'required|integer|min:1',
            'ubicacion' => 'required|in:interior,terraza,vip',
            'disponible' => 'boolean',
        ]);

        $mesa->update($validated);

        return redirect()->route('admin.mesas.index')
            ->with('success', 'Mesa actualizada exitosamente.');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();

        return redirect()->route('admin.mesas.index')
            ->with('success', 'Mesa eliminada exitosamente.');
    }
}
