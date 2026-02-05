<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('historial_acciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained('vehiculo')->onDelete('cascade');
            $table->foreignId('user_id')->nullable()->constrained('user')->nullOnDelete();

            $table->enum('categoria_accion', ['comando','alerta','sistema','acción_usuario','evento_dispositivo']);
            $table->string('tipo_accion', 50);
            $table->text('descripcion_accion');

            $table->decimal('ubicacion_lat', 10, 8)->nullable();
            $table->decimal('ubicacion_lng', 11, 8)->nullable();

            $table->boolean('estado')->nullable();
            $table->timestamp('ejecutado_at')->useCurrent();
            $table->timestamp('completado_at')->nullable();

            $table->index(['vehiculo_id','ejecutado_at'], 'idx_vehicle_time');
            $table->index(['user_id','ejecutado_at'], 'idx_user_actions');
            $table->index(['tipo_accion','ejecutado_at'], 'idx_action_type');
            $table->index(['categoria_accion','ejecutado_at'], 'idx_action_category');
        });
    }

    public function down(): void {
        Schema::dropIfExists('historial_acciones');
    }
};
