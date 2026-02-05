<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('accion_vehiculo', function (Blueprint $table) {
            $table->id();
            $table->string('tipo', 150);
            $table->boolean('estado')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedInteger('idUsuario')->nullable();
        });
    }

    public function down(): void {
        Schema::dropIfExists('accion_vehiculo');
    }
};
