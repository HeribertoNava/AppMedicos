<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index()
    {
        // Recuperar todas las ventas con los elementos y los servicios asociados
        $ventas = Venta::with(['items', 'consulta.servicios'])->get();

        // Retornar la vista con las ventas
        return view('ventas.index', compact('ventas'));
    }

    public function show($id)
    {
        // Recuperar una venta específica con sus elementos y servicios asociados
        $venta = Venta::with(['items', 'consulta.servicios'])->findOrFail($id);

        // Retornar la vista con la venta específica
        return view('ventas.show', compact('venta'));
    }
}
