<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class ProductosController extends Controller
{
    //Mostrar vista register cuando se de clic en crear 
    public function index(): View
    {
        $productos = Productos::all();
        return view('productos.productos', ['productos' => $productos]);
    }

    // Método para mostrar el formulario de edición, con el id del usuario
    public function editar($id): View
    {
        $producto = productos::findOrFail($id);
        return view('productos.editar', compact('producto'));
    }

    // formulario de crear producto
    public function crear(): View
    {
        return view('productos.crear');
    }
    //metodo para validar y crear el producto
    public function store(Request $request): RedirectResponse
    {
         $request->validate([
             'nombre' => ['required', 'string', 'max:255'],
             'descripcion' => ['required', 'string', 'max:255'],
             'cantidad' => ['required', 'int'],
             'precio' => ['required', 'int'],
         ]);
     
         $producto = productos::create([
             'nombre' => $request->nombre,
             'descripcion' => $request->descripcion,
             'cantidad' => $request->cantidad,
             'precio' => $request->precio,
         ]);
     
         return redirect()->route('productos.index')->with('success', 'Nuevo producto agregado.');
    }
     
     
    // Método para actualizar el producto
    public function actualizar(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'descripcion' => ['required', 'string', 'max:255'],
            'cantidad' => ['required', 'int'],
            'precio' => ['required', 'int'],
        ]);

        $producto = productos::findOrFail($id);
        $producto->update($request->all());

        return redirect()->route('productos.index')->with('success', 'producto actualizado.');
    }

    //metodo para eliminar, utilizando el id
    public function eliminar($id): RedirectResponse
    {
        $producto = Productos::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado.');
    }
    
}
