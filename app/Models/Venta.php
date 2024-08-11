<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'consulta_id',
        'total',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function items()
    {
        return $this->hasMany(VentaItem::class);
    }
}
