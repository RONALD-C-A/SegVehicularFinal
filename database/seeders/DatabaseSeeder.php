<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    public function run()
    {

        DB::table('user')->insert([
            'email' => 'usuario@segvehicular.com',
            'password' => Hash::make('usuario123'),
            'nombre' => 'Usuario Prueba',
            'celular' => '123456789',
            'direccion' => 'Calle Falsa 123',
            'rol' => 'USUARIO',
            'fecha_nacimiento' => '1990-01-01',
            'foto_perfil' => null,
            'nombre_contacto_emergencia' => 'Contacto Prueba',
            'numero_contacto_emergencia' => '987654321',
            'estado' => true,
            'email_verified' => true,
            'email_verified_at' => Carbon::now(),
            'ultimo_login' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'idUsuario' => null,
        ]);

        DB::table('user')->insert([
            'email' => 'admin@segvehicular.com',
            'password' => Hash::make('admin123'),
            'nombre' => 'Administrador',
            'celular' => '123456789',
            'direccion' => 'Calle Falsa 123',
            'rol' => 'ADMIN',
            'fecha_nacimiento' => '1990-01-01',
            'foto_perfil' => null,
            'nombre_contacto_emergencia' => 'Contacto Prueba',
            'numero_contacto_emergencia' => '987654321',
            'estado' => true,
            'email_verified' => true,
            'email_verified_at' => Carbon::now(),
            'ultimo_login' => null,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'idUsuario' => null,
        ]);
    }
}
