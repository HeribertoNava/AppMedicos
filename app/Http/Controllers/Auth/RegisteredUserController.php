<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usuario;
use App\Models\Doctores;
use App\Models\Pacientes;
use App\Models\Secretarias;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'apellido' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'telefono' => ['required', 'string', 'max:15'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'rol' => ['required', 'string', 'in:Doctor,Paciente,Secretaria,Usuario'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => $request->rol,
        ]);

        // Crear el registro en la tabla de usuarios
        Usuario::create([
            'nombre' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'rol' => $request->rol,
        ]);

        // Crear el registro en la tabla correspondiente según el rol
        if ($request->rol == 'Doctor') {
            Doctores::create([
                'nombres' => $request->name,
                'apellidos' => $request->apellido,
                'correo' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
                'especialidad' => null,
                'consultorio' => null,
            ]);
        } elseif ($request->rol == 'Paciente') {
            Pacientes::create([
                'nombres' => $request->name,
                'apellidos' => $request->apellido,
                'correo' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
                'direccion' => null,
                'edad' => null,
            ]);
        } elseif ($request->rol == 'Secretaria') {
            Secretarias::create([
                'nombres' => $request->name,
                'apellidos' => $request->apellido,
                'correo' => $request->email,
                'password' => Hash::make($request->password),
                'telefono' => $request->telefono,
            ]);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard'));
    }
}
