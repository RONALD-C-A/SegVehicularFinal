<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Historial;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function indexVehiculo()
    {
        $vehiculo=Vehicle::all();
        $dueno=User::where('rol','PROPIETARIO')->get();
        return view('pages.report.report-vehiculo', compact('vehiculo', 'dueno'));
    }

    public function indexHistorial()
    {
        $vehiculo=Vehicle::all();
        $dueno=User::where('rol','PROPIETARIO')->get();
        return view('pages.report.report-historial', compact('vehiculo', 'dueno'));
    }

    public function filtrarVehiculo(Request $request)
    {
        $vehiculo_id = $request->vehiculo_id;
        $dueno_id = $request->dueno_id;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin ?? Carbon::today()->toDateString();
        $query = Vehicle::query();

        if ($vehiculo_id) {
            $query->where('id', $vehiculo_id);
        }

        if ($dueno_id) {
            $query->where('dueno_id', $dueno_id);
        }

        if ($fecha_inicio) {
            $inicio = $fecha_inicio . ' 00:00:00';
            $fin = $fecha_fin . ' 23:59:59';
            $query->whereBetween('created_at', [$inicio, $fin]);
        }

        // Ejecutar la consulta
        $resultados = $query->with(['dueno', 'usuarios'])->get();

        return response()->json($resultados->map(function($r) {
            return [
                'vehiculo' => $r->nro_placa ?? 'N/A',
                'dueno' => $r->dueno->nombre ?? 'N/A',
                'dispositivo' => $r->dispositivo_id ?? 'N/A',
                'fecha' => $r->created_at,
                'usuarios' => $r->usuarios
            ];
        }));
    }

    public function filtrarHistorial(Request $request)
    {
        $vehiculo_id = $request->vehiculo_id;
        $dueno_id = $request->dueno_id;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin ?? Carbon::today()->toDateString();
        $query = Historial::query();

        if ($vehiculo_id) {
            $query->where('vehiculo_id', $vehiculo_id);
        }

        if ($dueno_id) {
            $query->whereHas('vehiculo', function($q) use ($dueno_id) {
                $q->where('dueno_id', $dueno_id);
            });
        }

        if ($fecha_inicio) {
            $inicio = $fecha_inicio . ' 00:00:00';
            $fin = $fecha_fin . ' 23:59:59';
            $query->whereBetween('grabado', [$inicio, $fin]);
        }

        // Ejecutar la consulta
        $resultados = $query->with(['vehiculo', 'vehiculo.dueno'])->get();

        return response()->json($resultados->map(function($r) {
            return [
                'vehiculo' => $r->vehiculo->nro_placa ?? 'N/A',
                'dueno' => $r->vehiculo->dueno->nombre ?? 'N/A',
                'motor' => $r->motor_encendido ? 'Encendido' : 'Apagado',
                'luces' => $r->luces_prendida ? 'Encendido' : 'Apagado',
                'bocinas' => $r->bocina_encendida ? 'Encendido' : 'Apagado',
                'fecha' => $r->grabado
            ];
        }));
    }

    public function vehiculoPDF(Request $request)
    {
        $vehiculo_id = $request->vehiculo_id;
        $dueno_id = $request->dueno_id;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin ?? Carbon::today()->toDateString();
        $query = Vehicle::query();

        if ($vehiculo_id) {
            $query->where('vehiculo_id', $vehiculo_id);
        }

        if ($dueno_id) {
            $query->where('dueno_id', $dueno_id);
        }

        if ($fecha_inicio) {
            $inicio = $fecha_inicio . ' 00:00:00';
            $fin = $fecha_fin . ' 23:59:59';
            $query->whereBetween('created_at', [$inicio, $fin]);
        }

        // Ejecutar la consulta
        $resultados = $query->with(['dueno', 'usuarios'])->get();

        $datos = $resultados->map(function($r) {
            return [
                'vehiculo' => $r->nro_placa ?? 'N/A',
                'dueno' => $r->dueno->nombre ?? 'N/A',
                'dispositivo' => $r->dispositivo_id ?? 'N/A',
                'fecha' => $r->created_at,
                'usuarios' => $r->usuarios ? collect($r->usuarios)->pluck('nombre')->toArray() : []
            ];
        });

        if ($datos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay datos para generar el PDF');
        }

        $pdf = Pdf::loadView('pages.report.vehiculoPDF', compact('datos'));
        $filename = 'reporte_vehiculo_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename); // abre PDF en el navegador
        // o return $pdf->download($filename); // fuerza descarga
    }

    public function historialPDF(Request $request)
    {
        $vehiculo_id = $request->vehiculo_id;
        $dueno_id = $request->dueno_id;
        $fecha_inicio = $request->fecha_inicio;
        $fecha_fin = $request->fecha_fin ?? Carbon::today()->toDateString();
        $query = Historial::query();

        if ($vehiculo_id) {
            $query->where('vehiculo_id', $vehiculo_id);
        }

        if ($dueno_id) {
            $query->whereHas('vehiculo', function($q) use ($dueno_id) {
                $q->where('dueno_id', $dueno_id);
            });
        }

        if ($fecha_inicio) {
            $inicio = $fecha_inicio . ' 00:00:00';
            $fin = $fecha_fin . ' 23:59:59';
            $query->whereBetween('grabado', [$inicio, $fin]);
        }

        // Ejecutar la consulta
        $resultados = $query->with(['vehiculo', 'vehiculo.dueno'])->get();

        $datos = $resultados->map(function($r) {
            return [
                'vehiculo' => $r->vehiculo->nro_placa ?? 'N/A',
                'dueno' => $r->vehiculo->dueno->nombre ?? 'N/A',
                'motor' => $r->motor_encendido ? 'Encendido' : 'Apagado',
                'luces' => $r->luces_prendida ? 'Encendido' : 'Apagado',
                'bocinas' => $r->bocina_encendida ? 'Encendido' : 'Apagado',
                'fecha' => $r->grabado
            ];
        });

        if ($datos->isEmpty()) {
            return redirect()->back()->with('error', 'No hay datos para generar el PDF');
        }

        $pdf = Pdf::loadView('pages.report.historialPDF', compact('datos'));
        $filename = 'reporte_historial_' . now()->format('Y-m-d') . '.pdf';

        return $pdf->download($filename); // abre PDF en el navegador
        // o return $pdf->download($filename); // fuerza descarga
    }
}
