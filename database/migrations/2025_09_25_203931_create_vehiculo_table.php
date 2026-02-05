<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dueno_id')->constrained('user')->onDelete('cascade');
            $table->string('dispositivo_id', 100)->unique()->comment('ID único del dispositivo IoT');
            $table->string('nombre', 100)->nullable();
            $table->string('marca', 50)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->integer('ano')->nullable();
            $table->string('nro_placa', 20)->nullable();
            $table->string('color', 30)->nullable();
            $table->enum('tipo_combustible', ['gasolina','diesel','electrico','hibrido'])->nullable();
            $table->decimal('capacidad_combustible', 5, 2)->nullable();
            $table->string('compania_seguro', 100)->nullable();
            $table->string('poliza_seguro', 100)->nullable();
            $table->date('vencimiento_seguro')->nullable();
            $table->integer('kilometraje')->default(0);
            $table->boolean('estado')->nullable();
            $table->timestamp('ultima_comunicacion')->nullable();
            $table->timestamps();
            $table->unsignedInteger('idUsuario')->nullable();

            $table->index(['dueno_id','estado'], 'idx_owner_active');
            $table->index('dispositivo_id', 'idx_device_id');
            $table->index('ultima_comunicacion', 'idx_last_communication');
        });
    }

    public function down(): void {
        Schema::dropIfExists('vehiculo');
    }
};
