<?php

use App\Http\Controllers\VehicleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/vehiculo/{id}/actualizar', [VehicleController::class, 'actualizarEstado']);
Route::get('/vehiculo/{id}/acciones', [VehicleController::class, 'obtenerAcciones']);
Route::post('/vehiculo/{id}/enviar-accion', [VehicleController::class, 'enviarAccion']);
Route::get('/vehiculo/{id}/ultimo-estado-manilla', [VehicleController::class, 'ultimoEstadoManilla']);
Route::get('/vehiculo/{id}/contactos', [VehicleController::class, 'obtenerContactosEmergencia']);
Route::post('/accion/{accionId}/confirmar', [VehicleController::class, 'confirmarAccion']);
