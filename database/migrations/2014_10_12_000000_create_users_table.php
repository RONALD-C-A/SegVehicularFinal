<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('email', 255)->unique();
            $table->string('password', 255);
            $table->string('nombre', 100);
            $table->string('rol', 50)->default('USUARIO')->comment('Administrador, Soporte, Propietario, Usuario');
            $table->string('celular', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('foto_perfil', 500)->nullable();
            $table->string('nombre_contacto_emergencia', 100)->nullable();
            $table->string('numero_contacto_emergencia', 20)->nullable();
            $table->boolean('estado')->nullable();
            $table->boolean('email_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('ultimo_login')->nullable();
            $table->timestamps();
            $table->unsignedInteger('idUsuario')->nullable();

            $table->index(['email', 'estado'], 'idx_email_active');
        });
    }

    public function down(): void {
        Schema::dropIfExists('user');
    }
};
