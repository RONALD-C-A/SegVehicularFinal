<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('historial_ubicacion_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculo')->onDelete('cascade');

            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->decimal('altitud', 8, 2)->nullable();
            $table->decimal('velocidad', 5, 2)->nullable();
            $table->integer('direccion')->nullable();
            $table->decimal('presicioon', 5, 2)->nullable();

            $table->decimal('nivel_bateria', 5, 2)->nullable();
            $table->integer('intensidad_senal')->nullable();

            $table->boolean('motor_encendido')->nullable();
            $table->boolean('luces_prendida')->default(false);
            $table->boolean('bocina_encendida')->default(false);
            $table->boolean('modo_panico')->default(false);

            $table->integer('kilometraje')->nullable();
            $table->decimal('nivel_combustible', 5, 2)->nullable();
            $table->decimal('temperatura_motor', 5, 2)->nullable();

            $table->enum('data_source', ['gps','celular','wifi'])->default('gps');
            $table->boolean('dispositivo_conectado')->default(true);
            $table->timestamp('grabado');
            $table->timestamp('recibido')->useCurrent();

            $table->index(['vehiculo_id','grabado'], 'idx_vehicle_time');
            $table->index(['latitud','longitud'], 'idx_location_area');
        });
    }

    public function down(): void {
        Schema::dropIfExists('historial_ubicacion_vehiculo');
    }
};