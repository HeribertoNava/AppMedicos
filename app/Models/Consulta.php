<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'correo',
        'talla',
        'temperatura',
        'saturacion_oxigeno',
        'frecuencia_cardiaca',
        'peso',
        'tension_arterial',
        'motivo_consulta',
        'notas_padecimiento',
        'interrogatorio_aparatos_sistemas',
        'examen_fisico',
        'diagnostico',
        'plan',
        'total_a_pagar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function productos()
    {
        return $this->belongsToMany(Productos::class, 'consulta_producto');
    }

    public function servicios()
    {
        return $this->belongsToMany(Servicios::class, 'consulta_servicio');
    }

}
