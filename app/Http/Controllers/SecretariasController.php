<?php

namespace App\Http\Controllers;

use App\Models\Secretarias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; 
class SecretariasController extends Controller
{
    //Mostrar vista register cuando se de clic en crear, se obtienen todos los registros de la tabla secretarias para mostrarlos en la vista
    public function index(): View
    {
        $secretarias = Secretarias::all();
        return view('secretarias.secretarias', ['secretarias' => $secretarias]);
    }

    // Método para mostrar el formulario para editarar a los secretarias
    public function editar(Secretarias $secretaria): View
    {
        return view('secretarias.editar', ['secretaria' => $secretaria]); //en la vista se pasan los datos del secretaria que se va a editar
    }
    

    // formulario de crear un secretaria
     public function crear(): View
     {
         return view('secretarias.crear');
     }

     //Metodo para validar y crear el secretaria
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:secretarias'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'telefono' => ['required', 'int'],
        ]);


        $secretaria = Secretarias::create([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono, 
        ]);

        event(new Registered($secretaria));

        return redirect()->route('secretarias.index')->with('success', 'Nuevo secretaria agregada.');
    }

    // Método para actualizar los datos del secretaria
    public function actualizar(Request $request, Secretarias $secretaria): RedirectResponse
    {
        $request->validate([
            'nombres' => ['required', 'string', 'max:255'],
            'apellidos' => ['required', 'string', 'max:255'],
            'correo' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:secretarias,correo,' . $secretaria->id],
            'telefono' => ['required', 'int'],
        ]);


        //actualiza unicamente los datos validados
        $secretaria->update([
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'correo' => $request->correo,
            'telefono' => $request->telefono,
        ]);

        return redirect()->route('secretarias.index')->with('success', 'Datos de la secretaria actualizados.');
    }

    //metodo eliminar un secretaria, lo busca por su id 
    public function eliminar($id): RedirectResponse
    {
        $secretaria = Secretarias::findOrFail($id);
        $secretaria->delete();
        return redirect()->route('secretarias.index')->with('success', 'Secretaria eliminada.');
    }
}
