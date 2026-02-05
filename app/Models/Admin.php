<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admin_sistema';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'celular',
        'rol',
        'estado',
        'ultimo_login',
        'idUsuario',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'estado' => 'boolean',
    ];
}
