<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('contacto_emergencia', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculo')->onDelete('cascade');
            $table->string('nombre', 100);
            $table->string('celular', 20);
            $table->string('email', 255)->nullable();
            $table->string('parentezco', 50)->nullable();
            $table->integer('prioridad')->default(1);
            $table->string('notificacion_preferencia', 100);
            $table->boolean('estado')->nullable();
            $table->timestamps();
            $table->unsignedInteger('idUsuario')->nullable();

            $table->index(['vehiculo_id','prioridad'], 'idx_vehicle_priority');
        });
    }

    public function down(): void {
        Schema::dropIfExists('contacto_emergencia');
    }
};
