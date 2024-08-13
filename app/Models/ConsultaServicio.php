<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaServicio extends Model
{
    protected $table = 'consulta_servicio';

    protected $fillable = [
        'consulta_id',
        'servicio_id',
        'cantidad',
        'precio',
        'notas_servicio',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function servicio()
    {
        return $this->belongsTo(Servicios::class);
    }
}
