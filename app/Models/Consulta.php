<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consulta extends Model
{
    use HasFactory;

    protected $fillable = [
        'paciente_id',
        'doctor_id',
        'fecha',
        'correo',
        'nombre',
        'motivo_consulta',
        'notas_padecimiento',
        'interrogatorio_aparatos_sistemas',
        'examen_fisico',
        'diagnostico',
        'plan',
        'total_a_pagar',
        'cita_id'
    ];

    public function recetas()
    {
        return $this->hasMany(Receta::class);
    }

    public function paciente()
    {
        return $this->belongsTo(Pacientes::class, 'paciente_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctores::class, 'doctor_id');
    }
    public function servicios()
    {
        return $this->belongsToMany(Servicios::class, 'consulta_servicio', 'consulta_id', 'servicio_id')
                    ->withPivot('cantidad', 'precio', 'notas_servicio');
    }
    public function signosVitales()
    {
        return $this->hasOne(SignosVitales::class, 'consulta_id');
    }
    public function venta()
    {
        return $this->hasOne(Venta::class);
    }
    public function cita()
    {
        return $this->belongsTo(Citas::class, 'cita_id');
    }
    public function colaboraciones()
    {
        return $this->hasMany(Colaboracion::class);
    }
    // En el modelo Consulta



    public function ventaItems()
    {
        return $this->hasManyThrough(VentaItem::class, Venta::class, 'consulta_id', 'venta_id');
    }




}