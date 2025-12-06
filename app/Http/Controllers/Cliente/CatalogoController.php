<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CatalogoController extends Controller
{
    public function index(Request $request)
    {
        $categorias = Categoria::where('activo', true)
            ->withCount('productos')
            ->get();
        
        $query = Producto::where('disponible', true)
            ->with('categoria');
        
        // Filtrar por categoría si se especifica
        if ($request->has('categoria') && $request->categoria) {
            $query->where('categoria_id', $request->categoria);
        }
        
        // Filtrar por búsqueda
        if ($request->has('buscar') && $request->buscar) {
            $query->where(function($q) use ($request) {
                $q->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('descripcion', 'like', '%' . $request->buscar . '%');
            });
        }
        
        // Ordenar
        $orden = $request->get('orden', 'destacado');
        switch ($orden) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'nombre':
                $query->orderBy('nombre', 'asc');
                break;
            default:
                $query->orderBy('destacado', 'desc')->orderBy('nombre', 'asc');
        }
        
        $productos = $query->paginate(12);
        
        return view('cliente.catalogo.index', compact('categorias', 'productos'));
    }

    public function show(Producto $producto)
    {
        $producto->load('categoria');
        
        // Si es una petición AJAX, devolver JSON para el modal
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json($producto);
        }
        
        // Productos relacionados de la misma categoría
        $productosRelacionados = Producto::where('categoria_id', $producto->categoria_id)
            ->where('id', '!=', $producto->id)
            ->where('disponible', true)
            ->limit(4)
            ->get();
        
        return view('cliente.catalogo.show', compact('producto', 'productosRelacionados'));
    }
}
