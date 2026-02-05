<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('vehiculo_user', function (Blueprint $table) {
            $table->foreignId('vehiculo_id')->constrained('vehiculo')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('user')->onDelete('cascade');
            $table->foreignId('anadido_por')->constrained('user')->onDelete('cascade');
            $table->enum('rol', ['PROPIETARIO','CONDUCTOR','FAMILIA','OTRO'])->default('CONDUCTOR');

            $table->unique(['vehiculo_id','user_id'], 'unique_vehicle_user');
        });
    }

    public function down(): void {
        Schema::dropIfExists('vehiculo_user');
    }
};
