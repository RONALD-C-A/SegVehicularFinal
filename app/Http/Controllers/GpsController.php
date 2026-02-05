<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoActual;
use App\Models\Vehicle;
use App\Models\AccionVehiculo;
use Illuminate\Http\Request;

class GpsController extends Controller
{
    public function index()
    {
        $vehiculo = Vehicle::where('dueno_id', auth()->id())
            ->orWhereHas('usuarios', function($query) {
                $query->where('user_id', auth()->id());
            })
            ->with('estadoActual')
            ->first();

        // Caso 1: No hay vehículo asociado
        if (!$vehiculo) {
            $vehiculo = null;
            $estadoActual = null;
        } 
        else {
            // Caso 2: Hay vehículo (con o sin estado actual)
            $acciones = AccionVehiculo::where('vehiculo_id', $vehiculo->id)
                ->orderBy('created_at', 'desc')
                ->get()
                ->groupBy('tipo');

            $estadoActual = [
                'motor'  => $acciones['motor'][0]->estado ?? 0,
                'luces'  => $acciones['luces'][0]->estado ?? 0,
                'bocina' => $acciones['bocina'][0]->estado ?? 0,
                'latitud_actual'  => $vehiculo->estadoActual->latitud_actual ?? null,
                'longitud_actual' => $vehiculo->estadoActual->longitud_actual ?? null,
            ];
        }

        return view('pages.page.mgps', compact('vehiculo', 'estadoActual'));
    }

    public function indexAdmin()
    {
        $vehiculo = Vehicle::with('estadoActual')->get();
        
        if (!$vehiculo) {
            return redirect()->back()->with('error', 'No tienes vehículos registrados');
        }
        
        return view('pages.page.gps', compact('vehiculo'));
    }
}
