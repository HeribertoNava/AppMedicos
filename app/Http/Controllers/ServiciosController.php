<?php

namespace App\Http\Controllers;

use App\Models\Servicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 

class ServiciosController extends Controller
{
    //Mostrar vista register cuando se de clic en crear 
    public function index(): View
    {
        $servicios = Servicios::all();
        return view('servicios.servicios', ['servicios' => $servicios]);
    }

    // Método para mostrar el formulario de edición
    public function editar($id): View
    {
        $servicio = Servicios::findOrFail($id);
        return view('servicios.editar', compact('servicio'));
    }
    

    // formulario de crear servicio
    public function crear(): View
    {
        return view('servicios.crear');
    }

       public function store(Request $request): RedirectResponse
     {
         $request->validate([
             'nombre' => ['required', 'string', 'max:255'],
             'descripcion' => ['required', 'string', 'max:255'],
             'precio' => ['required', 'int'],
         ]);
     
         $servicio = servicios::create([
             'nombre' => $request->nombre,
             'descripcion' => $request->descripcion,
             'precio' => $request->precio,
         ]);
     
         return redirect()->route('servicios.index')->with('success', 'Nuevo servicio agregado.');
     }
     
     
    // Método para actualizar el servicio
    public function actualizar(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
             'descripcion' => ['required', 'string', 'max:255'],
             'precio' => ['required', 'int'],
        ]);

        $servicio = servicios::findOrFail($id);
        $servicio->update($request->all());

        return redirect()->route('servicios.index')->with('success', 'servicio actualizado.');
    }
}
