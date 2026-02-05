<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AccionVehiculo;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->rol, ['ADMIN', 'SOPORTE'])) {
            $vehicles = Vehicle::with('dueno')->get();
            $duenos = User::where('rol', 'USUARIO')->orWhere('rol','PROPIETARIO')->get();
            $usuarios = User::where('rol', 'USUARIO')->orWhere('rol','PROPIETARIO')->get();
        } else {
            $asDueno = Vehicle::where('dueno_id', $user->id)->where('estado',1);
            $asUsuario = Vehicle::whereHas('usuarios', function($q) use ($user) {
                $q->where('user_id', $user->id);
            });
            $vehicles = $asDueno->union($asUsuario)->with(['dueno','usuarios'])->get();
            $duenos = User::where('idUsuario', $user->id)->where('estado', 1)->get();
            $usuarios = User::where('id', $user->id)->get();
        }

        return view('pages.page.vehicles', compact('vehicles', 'duenos', 'user', 'usuarios'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        Vehicle::create([
            'dueno_id' => $request->dueno_id,
            'dispositivo_id' => $request->dispositivo_id,
            'nro_placa' => $request->nro_placa,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'ano' => $request->ano,
            'color' => $request->detalle,
            'estado' => 1,
            'idUsuario' => $user->id,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehículo añadido correctamente');
    }

    public function update(Request $request, $id)
    {
        $vehicles = Vehicle::findOrFail($id);
        $vehicles->update([
            'dispositivo_id' => $request->dispositivo_id,
            'dueno_id' => $request->dueno_id,
            'nro_placa' => $request->nro_placa,
            'marca' => $request->marca,
            'modelo' => $request->modelo,
            'ano' => $request->ano,
            'nombre' => $request->detalle,
        ]);

        return redirect()->route('vehicles.index')->with('success', 'Vehículo actualizado.');
    }

    public function toggle($id, Request $request)
    {
        $vehiculo = Vehicle::findOrFail($id);

        if ($request->action === 'desactivar') {
            $vehiculo->estado = 0;
            $vehiculo->save();
            return response()->json(['message' => 'Vehículo desactivado correctamente.']);
        } else {
            $vehiculo->estado = 1;
            $vehiculo->save();
            return response()->json(['message' => 'Vehículo reactivado correctamente.']);
        }
    }

    public function obtenerEstado($id)
    {
        return DB::table('estado_actual_vehiculo')->where('vehiculo_id', $id)->first();

    }

    public function obtenerContactosEmergencia($id)
    {
        try {
            $contactos = DB::table('contacto_emergencia')
                ->where('vehiculo_id', $id)
                ->where('estado', 1)
                ->get(['id', 'nombre', 'celular', 'notificacion_preferencia']);
            
            return response()->json([
                'ok' => true,
                'contactos' => $contactos
            ]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }
    
    public function actualizarEstado(Request $request, $id)
    {
        DB::table('estado_actual_vehiculo')
            ->updateOrInsert(['vehiculo_id' => $id], [
                'latitud_actual' => $request->latitud,
                'longitud_actual' => $request->longitud,
                'velocidad_actual' => 40,
                'motor_encendido' => $request->motor_encendido,
                'luces_prendida' => $request->luces_prendida,
                'bocina_encendida' => $request->bocinas_prendida,
                'modo_panico' => $request->modo_panico,
                'dispositivo_conectado' => $request->dispositivo_conectado ?? 1,
                'precision_actual' => $request->distancia_lora ?? null,
                'ultima_comunicacion' => now(),
                'location_updated_at' => now(),
                'status_updated_at' => now(),
            ]);
        return response()->json(['ok' => 1]);
    }

    public function obtenerAcciones($id)
    {
        try {
            $acciones = AccionVehiculo::where('vehiculo_id', $id)
                ->where('estado_ejecucion', 'pendiente')
                ->orderBy('created_at', 'asc')
                ->get(['id', 'tipo', 'estado']);

            return response()->json([
                'ok' => true,
                'acciones' => $acciones
            ]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function confirmarAccion(Request $request, $accionId)
    {
        try {
            $accion = AccionVehiculo::findOrFail($accionId);
            $accion->update([
                'estado_ejecucion' => $request->input('estado_ejecucion', 'ejecutado'),
                'ejecutado_at' => now()
            ]);

            return response()->json(['ok' => true]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function enviarAccion(Request $request, $id)
    {
        $request->validate([
            'tipo' => 'required|string|in:motor,luces,bocina,panico,bloqueo,desbloqueo',
            'estado' => 'required|boolean'
        ]);

        try {
            $accion = AccionVehiculo::create([
                'vehiculo_id' => $id,
                'tipo' => $request->tipo,
                'estado' => $request->estado,
                'estado_ejecucion' => 'pendiente',
                'idUsuario' => auth()->id() ?? 1
            ]);

            return response()->json([
                'ok' => true,
                'mensaje' => 'Acción enviada',
                'accion_id' => $accion->id
            ]);
        } catch (\Exception $e) {
            return response()->json(['ok' => false, 'error' => $e->getMessage()], 500);
        }
    }

    public function asignarUsuario(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,id',
            'vehiculo_id' => 'required|exists:vehiculo,id',
            'rol' => 'required|in:CONDUCTOR,FAMILIA,OTRO',
        ]);

        $usuarioActual = Auth::user();

        DB::table('vehiculo_user')->updateOrInsert(
            [
                'user_id' => $request->user_id,
                'vehiculo_id' => $request->vehiculo_id,
            ],
            [
                'rol' => $request->rol,
                'anadido_por' => $usuarioActual->id,
            ]
        );

        return back()->with('success', 'Usuario asignado correctamente al vehículo.');
    }

    public function ultimoEstadoManilla($id)
    {
        $ultimo = \App\Models\AccionVehiculo::where('vehiculo_id', $id)
            ->where('tipo', 'bloqueo') // 'bloqueo' es el tipo de manilla
            ->orderByDesc('id')
            ->first();

        return response()->json([
            'estado' => $ultimo->estado ?? 0, // 1=activado, 0=desactivado
            'estado_ejecucion' => $ultimo->estado_ejecucion ?? 'pendiente',
            'ejecutado_at' => $ultimo->ejecutado_at,
        ]);
    }
}
