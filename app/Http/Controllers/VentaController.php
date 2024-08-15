<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        // Recuperar todas las ventas con los elementos asociados
        $ventas = Venta::with('items')->get();

        // Retornar la vista con las ventas
        return view('ventas.index', compact('ventas'));
    }

    public function show($id)
    {
        // Recuperar una venta específica con sus elementos
        $venta = Venta::with('items')->findOrFail($id);

        // Retornar la vista con la venta específica
        return view('ventas.show', compact('venta'));
    }
}
