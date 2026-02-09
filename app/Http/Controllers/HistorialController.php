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
    public function index(Request $request)
    {
        $user = Auth::user();
        $title = 'Historial de Rutas';

        // Validar y asignar fechas (Hoy por defecto)
        $inicio = $request->get('fecha_inicio', now()->format('Y-m-d'));
        $fin = $request->get('fecha_fin', now()->format('Y-m-d'));

        // Lógica de vehículos (ADMIN o Propios)
        $vehiculosQuery = Vehicle::where('dueno_id', $user->id)
            ->orWhereHas('usuarios', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });

        $vehiculo = $vehiculosQuery->get();
        $vehiculoIds = (in_array($user->rol, ['ADMIN', 'SOPORTE'])) 
            ? Historial::distinct()->pluck('vehiculo_id') 
            : $vehiculo->pluck('id');

        // Filtro por rango de fechas
        $historial = Historial::with('vehiculo')
            ->whereIn('vehiculo_id', $vehiculoIds)
            ->whereBetween('grabado', [$inicio . ' 00:00:00', $fin . ' 23:59:59'])
            ->orderBy('grabado', 'asc')
            ->get();

        return view('pages.page.ubicacion', compact('user', 'historial', 'vehiculo', 'inicio', 'fin', 'title'));
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
