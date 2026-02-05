<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstadoActual extends Model
{
    use HasFactory;
    protected $table = 'estado_actual_vehiculo';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'vehiculo_id',
        'latitud_actual',
        'longitud_actual',
        'velocidad_actual',
        'direccion_actual',
        'precision_actual',
        'nivel_bateria',
        'intensidad_senal',
        'motor_encendido',
        'luces_prendida',
        'bocina_encendida',
        'modo_panico',
        'kilometraje',
        'nivel_combustible',
        'temperatura_motor',
        'data_source',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehicle::class, 'vehiculo_id');
    }
}
