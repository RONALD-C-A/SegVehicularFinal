<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    use HasFactory;
    protected $table = 'contacto_emergencia';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'vehiculo_id',
        'dispositivo_id',
        'nombre',
        'celular',
        'email',
        'parentezco',
        'prioridad',
        'notificacion_preferencia',
        'estado',
        'idUsuario',
    ];

    public function vehiculo()
    {
        return $this->belongsTo(Vehicle::class, 'vehiculo_id');
    }
}
