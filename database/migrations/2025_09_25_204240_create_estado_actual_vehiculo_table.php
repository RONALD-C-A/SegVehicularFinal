<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('estado_actual_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculo')->onDelete('cascade');

            // Ubicación
            $table->decimal('latitud_actual', 10, 8);
            $table->decimal('longitud_actual', 11, 8);
            $table->decimal('altitud_actual', 8, 2)->nullable();
            $table->decimal('velocidad_actual', 5, 2)->nullable();
            $table->integer('direccion_actual')->nullable();
            $table->decimal('precision_actual', 5, 2)->nullable();

            // Estado del dispositivo
            $table->decimal('nivel_bateria', 5, 2)->nullable();
            $table->integer('intensidad_senal')->nullable();

            // Estado del vehículo
            $table->boolean('motor_encendido')->nullable();
            $table->boolean('luces_prendida')->default(false);
            $table->boolean('bocina_encendida')->default(false);
            $table->boolean('modo_panico')->default(false);

            // Datos adicionales
            $table->integer('kilometraje')->nullable();
            $table->decimal('nivel_combustible', 5, 2)->nullable();
            $table->decimal('temperatura_motor', 5, 2)->nullable();

            // Control de comunicación
            $table->enum('data_source', ['gps','cellular','wifi'])->default('gps');
            $table->boolean('dispositivo_conectado')->default(true);
            $table->timestamp('ultima_comunicacion');
            $table->timestamp('location_updated_at');
            $table->timestamp('status_updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique('vehiculo_id', 'unique_vehicle');
            $table->index(['latitud_actual','longitud_actual'], 'idx_location');
            $table->index('ultima_comunicacion', 'idx_last_communication');
            $table->index('dispositivo_conectado', 'idx_device_online');
        });
    }

    public function down(): void {
        Schema::dropIfExists('estado_actual_vehiculo');
    }
};
