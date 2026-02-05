<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Historial;
use App\Models\Vehicle;
use App\Models\AccionVehiculo;

class HistorialController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->rol, ['ADMIN', 'SOPORTE'])) {
            $historial = Historial::with('vehiculo')->get();

            $vehiculo = Vehicle::where('dueno_id', $user->id)
                ->orWhereHas('usuarios', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with('estadoActual')
                ->get();
        } else {
            // Usuarios normales o propietarios
            // Si el usuario es propietario directo, usamos dueno_id
            $vehiculo = Vehicle::where('dueno_id', $user->id)
                ->orWhereHas('usuarios', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with('estadoActual')
                ->get();

            // Obtener historial solo de los vehículos que puede ver
            $vehiculoIds = $vehiculo->pluck('id')->toArray();
            $historial = Historial::whereIn('vehiculo_id', $vehiculoIds)->get();
        }

        return view('pages.page.ubicacion', compact('user', 'historial', 'vehiculo'));
    }

    public function accion()
    {
        $user = Auth::user();

        if (in_array($user->rol, ['ADMIN', 'SOPORTE'])) {
            // Admin y soporte ven todas las acciones
            $historial = AccionVehiculo::with(['vehiculo', 'usuario'])->get();

            // Todos los vehículos
            $vehiculo = Vehicle::with('estadoActual')->get();
        } else {
            // Solo los vehículos que el usuario posee o puede conducir
            $vehiculo = Vehicle::where('dueno_id', $user->id)
                ->orWhereHas('usuarios', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->with('estadoActual')
                ->get();

            // Obtener solo las acciones de esos vehículos
            $vehiculoIds = $vehiculo->pluck('id')->toArray();
            $historial = AccionVehiculo::with(['vehiculo', 'usuario'])
                ->whereIn('vehiculo_id', $vehiculoIds)
                ->get();
        }

        return view('pages.page.acciones', compact('user', 'historial', 'vehiculo'));
    }
}
