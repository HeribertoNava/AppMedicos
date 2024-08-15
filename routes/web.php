<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ConsultaController;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\SecretariasController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', function () {
    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Rutas para Doctores
    Route::get('/doctores', [DoctoresController::class, 'index'])->name('doctores.index');
    Route::get('/doctores/crear', [DoctoresController::class, 'crear'])->name('doctores.crear');
    Route::post('/doctores', [DoctoresController::class, 'store'])->name('doctores.store');
    Route::get('/doctores/{doctor}/editar', [DoctoresController::class, 'editar'])->name('doctores.editar');
    Route::put('/doctores/{doctor}', [DoctoresController::class, 'actualizar'])->name('doctores.actualizar');
    Route::delete('/doctores/{doctor}', [DoctoresController::class, 'eliminar'])->name('doctores.eliminar');

    // Rutas para Pacientes
    Route::get('/pacientes', [PacientesController::class, 'index'])->name('pacientes.index');
    Route::get('/pacientes/crear', [PacientesController::class, 'crear'])->name('pacientes.crear');
    Route::post('/pacientes', [PacientesController::class, 'store'])->name('pacientes.store');
    Route::get('/pacientes/{id}/editar', [PacientesController::class, 'editar'])->name('pacientes.editar');
    Route::put('/pacientes/{id}', [PacientesController::class, 'actualizar'])->name('pacientes.actualizar');
    Route::delete('/pacientes/{id}', [PacientesController::class, 'eliminar'])->name('pacientes.eliminar');
    Route::get('/pacientes/{id}/historial', [PacientesController::class, 'historial'])->name('pacientes.historial');


    // Rutas para servicios
    Route::get('/servicios', [ServiciosController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServiciosController::class, 'crear'])->name('servicios.crear');
    Route::post('/servicios', [ServiciosController::class, 'store'])->name('servicios.store');
    Route::get('/servicios/{servicio}/editar', [ServiciosController::class, 'editar'])->name('servicios.editar');
    Route::put('/servicios/{servicio}', [ServiciosController::class, 'actualizar'])->name('servicios.actualizar');
    Route::delete('/servicios/{servicio}', [ServiciosController::class, 'eliminar'])->name('servicios.eliminar');

    // Rutas para productos
    Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
    Route::get('/productos/crear', [ProductosController::class, 'crear'])->name('productos.crear');
    Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
    Route::get('/productos/{producto}/editar', [ProductosController::class, 'editar'])->name('productos.editar');
    Route::put('/productos/{producto}', [ProductosController::class, 'actualizar'])->name('productos.actualizar');
    Route::delete('/productos/{producto}', [ProductosController::class, 'eliminar'])->name('productos.eliminar');


    // Rutas para secretarias
    Route::get('/secretarias', [SecretariasController::class, 'index'])->name('secretarias.index');
    Route::get('/secretarias/crear', [SecretariasController::class, 'crear'])->name('secretarias.crear');
    Route::post('/secretarias', [SecretariasController::class, 'store'])->name('secretarias.store');
    Route::get('/secretarias/{secretaria}/editar', [SecretariasController::class, 'editar'])->name('secretarias.editar');
    Route::put('/secretarias/{secretaria}', [SecretariasController::class, 'actualizar'])->name('secretarias.actualizar');
    Route::delete('/secretarias/{secretaria}', [SecretariasController::class, 'eliminar'])->name('secretarias.eliminar');

    //rutas para citas
    Route::get('/citas', [CitasController::class, 'index'])->name('citas.index');
    Route::get('/citas/crear', [CitasController::class, 'crear'])->name('citas.crear');
    Route::post('/citas', [CitasController::class, 'store'])->name('citas.store');
    Route::get('/citas/{secretaria}/editar', [CitasController::class, 'editar'])->name('citas.editar');
    Route::put('/citas/{secretaria}', [CitasController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/citas/{secretaria}', [CitasController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/citas/horas-ocupadas', [CitasController::class, 'getHorasOcupadas'])->name('citas.horas-ocupadas');
    Route::get('/citas/cambiar-estado/{id}/{estado}', [CitasController::class, 'cambiarEstado'])->name('citas.cambiarEstado');
    Route::get('/citas/lista', [CitasController::class, 'lista'])->name('citas.lista');


    //Rutas para Ventas
    Route::get('/ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::get('/ventas/{id}', [VentaController::class, 'show'])->name('ventas.show');


    //Ruta para usuarios

    Route::get('usuarios', [UsuarioController::class, 'index'])->name('usuarios.index');
    // Mostrar el formulario para crear un nuevo usuario
    Route::get('usuarios/create', [UsuarioController::class, 'create'])->name('usuarios.create');
    // Almacenar un nuevo usuario
    Route::post('usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    // Mostrar un usuario específico
    Route::get('usuarios/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
    // Mostrar el formulario para editar un usuario específico
    Route::get('usuarios/{usuario}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    // Actualizar un usuario específico
    Route::put('usuarios/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
    // Eliminar un usuario específico
    Route::delete('usuarios/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');


    // ruta de consulta




    Route::get('/consultas', [ConsultaController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/crear/{pacienteId}', [ConsultaController::class, 'create'])->name('consultas.create');
    Route::post('/consultas', [ConsultaController::class, 'store'])->name('consultas.store');
    Route::get('/consultas/{id}', [ConsultaController::class, 'show'])->name('consultas.show');





});

require __DIR__ . '/auth.php';
