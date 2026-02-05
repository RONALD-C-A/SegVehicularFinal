<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table= 'user';

    protected $fillable = [
        'nombre',
        'email',
        'password',
        'celular',
        'rol',
        'direccion',
        'fecha_nacimiento',
        'tipo_usuario',
        'foto_perfil',
        'nombre_contacto_emergencia',
        'numero_contacto_emergencia',
        'estado',
        'email_verified',
        'ultimo_login',
        'idUsuario',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'estado' => 'integer',
        'email_verified' => 'boolean',
    ];

    public function vehiculos()
    {
        return $this->belongsToMany(Vehicle::class, 'vehiculo_user', 'user_id', 'vehiculo_id')
                    ->withPivot(['rol', 'anadido_por']);
    }
}
