<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $table = 'vehiculo';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'dueno_id',
        'dispositivo_id',
        'nombre',
        'marca',
        'modelo',
        'ano',
        'nro_placa',
        'color',
        'tipo_combustible',
        'capacidad_combustible',
        'compania_seguro',
        'poliza_seguro',
        'vencimiento_seguro',
        'kilometraje',
        'estado',
        'ultima_comunicacion',
    ];

    public function dueno()
    {
        return $this->belongsTo(User::class, 'dueno_id');
    }

    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'vehiculo_user', 'vehiculo_id', 'user_id')
                    ->withPivot(['rol', 'anadido_por']);
    }

    public function estadoActual()
    {
        return $this->hasOne(EstadoActual::class, 'vehiculo_id');
    }

    public function contacto()
    {
        return $this->belongsTo(Emergency::class, 'vehiculo_id');
    }
}
