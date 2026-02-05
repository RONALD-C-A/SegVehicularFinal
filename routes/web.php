<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmergencyContact;
use App\Http\Controllers\GpsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if (in_array($user->rol, ['USUARIO', 'PROPIETARIO'])) {
            return redirect()->route('duser');
        } elseif (in_array($user->rol, ['ADMIN', 'SOPORTE'])) {
            return redirect()->route('dadmin');
        }
    }
    return redirect()->route('login');
})->name('inicio');


Route::get('/login', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if (in_array($user->rol, ['USUARIO', 'PROPIETARIO'])) {
            return redirect()->route('duser');
        } elseif (in_array($user->rol, ['ADMIN', 'SOPORTE'])) {
            return redirect()->route('dadmin');
        }
    }
    return app(LoginController::class)->showLoginForm();
})->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Logout
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/forgot-password', [LoginController::class, 'reset'])->name('password-reset');
Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password-update');
Route::get('/activar-cuenta/{id}', [UserController::class, 'activarCuenta'])->name('activar-cuenta');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard-user', [DashboardController::class, 'user'])->name('duser');
    Route::get('/dashboard-admin', [DashboardController::class, 'admin'])->name('dadmin');

    //Opciones
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::post('/usuarios/store', [UserController::class, 'store'])->name('usuarios.store');
    Route::post('/usuarios/delete', [UserController::class, 'cambiarEstado'])->name('usuarios.cambiarEstado');
    Route::post('/usuarios/validar-email', [UserController::class, 'validarEmail'])->name('usuarios.validarEmail');

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
    Route::resource('vehicles', VehicleController::class);
    Route::put('vehicles/{id}/toggle', [VehicleController::class, 'toggle'])->name('vehicles.toggle');
    Route::post('/vehicles/asignar', [VehicleController::class, 'asignarUsuario'])->name('vehicles.asignar');


    Route::get('/gps/user', [GpsController::class, 'index'])->name('gps.index');
    Route::get('/vehiculos/estados/actualizados', [DashboardController::class, 'estadosActualizados'])->name('vehiculos.estados.actualizados');
    Route::get('/gps/admin', [GpsController::class, 'indexAdmin'])->name('gps.admin');

    Route::get('/ubicacion', [HistorialController::class, 'index'])->name('ubicacion.index');
    Route::get('/accion', [HistorialController::class, 'accion'])->name('accion.index');

    Route::get('/report/vehiculo', [ReporteController::class, 'indexVehiculo'])->name('reportVehiculo.index');
    Route::get('/report/historial', [ReporteController::class, 'indexHistorial'])->name('reportHistorial.index');
    Route::post('/reporte/vehiculo', [ReporteController::class, 'filtrarVehiculo'])->name('reporte.filtrar');
    Route::post('/reporte/historial', [ReporteController::class, 'filtrarHistorial'])->name('reporte.historial');
    Route::get('/reportes/vehiculos/pdf', [ReporteController::class, 'vehiculoPDF'])->name('vehiculo.pdf');
    Route::get('/reportes/historial/pdf', [ReporteController::class, 'historialPDF'])->name('historial.pdf');

    
    Route::get('/contacts', [EmergencyContact::class, 'index'])->name('contacts.index');
    Route::resource('contact', EmergencyContact::class);
    Route::put('contact/{id}/toggle', [EmergencyContact::class, 'toggle'])->name('contacts.toggle');
    // Configuración de usuario
    Route::get('/user/settings', function () {return view('pages.user.account-settings');})->name('settings');
    Route::post('/password/update', [UserController::class, 'updatePassword'])->name('password.update');
    Route::post('/subir-foto', [UserController::class, 'uploadFoto'])->name('user.uploadFoto');

    Route::post('/user/settings', [UserController::class, 'perfilUpdate'])->name('perfil.update');
});