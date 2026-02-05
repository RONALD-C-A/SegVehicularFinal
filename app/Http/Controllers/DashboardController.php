<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\EstadoActual;
use App\Models\Historial;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\AccionVehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function admin()
    {
        $user = Auth::user();

        // Contar usuarios por rol
        $roles = User::select('rol', DB::raw('count(*) as total'))
            ->groupBy('rol')
            ->pluck('total', 'rol'); // ['ADMIN' => 2, 'SOPORTE' => 3, 'USUARIO' => 10, 'PROPIETARIO' => 5]

        // Preparar datos para gráfico de torta
        $datosRolesChart = [
            'labels' => $roles->keys(), // los nombres de los roles
            'series' => $roles->values(), // las cantidades
        ];

        // Datos históricos de eventos para chart-one (opcional)
        $historial = Historial::select(
            DB::raw("MONTH(grabado) as mes"),
            DB::raw("SUM(CASE WHEN modo_panico = 1 THEN 1 ELSE 0 END) as panico"),
            DB::raw("SUM(CASE WHEN dispositivo_conectado = 0 THEN 1 ELSE 0 END) as manilla_desconectada")
        )
        ->whereYear('grabado', date('Y'))
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr', 5 => 'May', 6 => 'Jun',
            7 => 'Jul', 8 => 'Ago', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];

        $labels = [];
        $panicoData = [];
        $manillaData = [];
        foreach ($historial as $h) {
            $labels[] = $meses[$h->mes];
            $panicoData[] = (int)$h->panico;
            $manillaData[] = (int)$h->manilla_desconectada;
        }

        $datosEventosChart = [
            'labels' => $labels,
            'series' => [
                ['name' => 'Botón de pánico', 'data' => $panicoData],
                ['name' => 'Manillas desconectadas', 'data' => $manillaData],
            ]
        ];

        return view('pages.dashboard.admin', compact(
            'user',
            'datosRolesChart',
            'datosEventosChart'
        ));
    }

    public function user()
    {
        $user = Auth::user();
        $userId = $user->id;
        $vehiculos = Vehicle::where('dueno_id', $userId)
                            ->orWhereHas('usuarios', function($q) use ($userId) {
                                $q->where('user_id', $userId);
                            })
                            ->with(['estadoActual', 'usuarios'])
                            ->get();
        $vehiculoIds = $vehiculos->pluck('id');
        $historial = Historial::whereIn('vehiculo_id', $vehiculoIds)
                            ->orderBy('grabado', 'desc')
                            ->get();
        $accion = AccionVehiculo::whereIn('vehiculo_id', $vehiculoIds)
                                ->with('vehiculo')
                                ->orderBy('ejecutado_at', 'DESC')
                                ->get();

        return view('pages.dashboard.user', compact('user', 'vehiculos', 'historial', 'accion'));
    }

    public function estadosActualizados()
    {
        $vehiculos = Vehicle::with('estadoActual')->get();
        return response()->json($vehiculos);
    }
}
