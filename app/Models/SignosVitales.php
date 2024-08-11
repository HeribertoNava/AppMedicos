<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SignosVitales extends Model
{
    protected $table = 'signos_vitales';

    protected $fillable = [
        'consulta_id',
        'talla',
        'temperatura',
        'frecuencia_cardiaca',
        'saturacion_oxigeno',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
