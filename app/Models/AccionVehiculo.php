<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccionVehiculo extends Model
{
    use HasFactory;
    protected $table = 'accion_vehiculo';
    
    public $timestamps = false; // Porque solo tienes created_at
    
    protected $fillable = [
        'vehiculo_id',
        'tipo',
        'estado',
        'estado_ejecucion',
        'ejecutado_at',
        'idUsuario'
    ];

    protected $casts = [
        'estado' => 'boolean',
        'ejecutado_at' => 'datetime',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehicle::class, 'vehiculo_id');
    }

    public function usuario()
    {
        return $this->belongsTo(User::class, 'idUsuario');
    }
}
