<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('accion_vehiculo', function (Blueprint $table) {
            $table->unsignedBigInteger('vehiculo_id')->after('id');
            $table->enum('estado_ejecucion', ['pendiente', 'ejecutado', 'fallido'])
                  ->default('pendiente')
                  ->after('estado');
            $table->timestamp('ejecutado_at')->nullable()->after('estado_ejecucion');
            
            $table->foreign('vehiculo_id')->references('id')->on('vehiculo')->onDelete('cascade');
            $table->index(['vehiculo_id', 'estado_ejecucion']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('accion_vehiculo', function (Blueprint $table) {
            $table->dropForeign(['vehiculo_id']);
            $table->dropIndex(['vehiculo_id', 'estado_ejecucion']);
            $table->dropColumn(['vehiculo_id', 'estado_ejecucion', 'ejecutado_at']);
        });
    }
};
