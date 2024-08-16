<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Colaboracion extends Model
{
    protected $table = 'colaboraciones'; // Especifica el nombre correcto de la tabla

    protected $fillable = [
        'consulta_id',
        'medico_colaborador_id',
        'mensaje',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function medicoColaborador()
    {
        return $this->belongsTo(Usuario::class, 'medico_colaborador_id');
    }

}
