<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('restriccion_horaria', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculo')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->json('dia_semana');
            $table->time('tiempo_inicio');
            $table->time('tiempo_fin');
            $table->enum('tipo_restriccion', ['aceptada','olvidada'])->default('aceptada');
            $table->boolean('estado')->nullable();
            $table->string('notes', 150)->nullable();
            $table->timestamps();
            $table->unsignedInteger('idUsuario')->nullable();

            $table->index(['vehiculo_id','user_id','estado'], 'idx_vehicle_user_active');
        });
    }

    public function down(): void {
        Schema::dropIfExists('restriccion_horaria');
    }
};
