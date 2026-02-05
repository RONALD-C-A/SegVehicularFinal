<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Vehicle;

class Historial extends Model
{
    use HasFactory;
    protected $table = 'historial_ubicacion_vehiculo';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'vehiculo_id',
        'latitud',
        'longitud',
        'velocidad',
        'direccion',
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
