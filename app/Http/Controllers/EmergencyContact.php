<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Emergency;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmergencyContact extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if (in_array($user->rol, ['ADMIN', 'SOPORTE'])) {
            $vehicles = Vehicle::all();
            $contacts = Emergency::with('vehiculo')->get();
            return view('pages.page.emergency', compact('contacts','vehicles', 'user'));
        }

        $asDueno = Vehicle::where('dueno_id', $user->id)->pluck('id');
        $asUsuario = Vehicle::whereHas('usuarios', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->pluck('id');
        $idVehicles = $asDueno->merge($asUsuario)->unique();
        $contacts = Emergency::with('vehiculo')
                            ->whereIn('vehiculo_id', $idVehicles)
                            ->where('estado', 1)
                            ->get();
        $vehicles = Vehicle::whereIn('id', $idVehicles)
                            ->with(['dueno', 'usuarios'])
                            ->get();

        $total = $contacts->count();
        return view('pages.page.emergency', compact('contacts', 'total', 'vehicles', 'user'));
        
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        Emergency::create([
            'vehiculo_id' => $request->vehiculo_id,
            'nombre' => $request->nombre,
            'celular' => $request->celular,
            'email' => $request->email,
            'parentezco' => $request->parentezco,
            'prioridad' => $request->prioridad,
            'notificacion_preferencia' => $request->notificacion_preferencia,
            'estado' => 1,
            'idUsuario' => Auth::user()->id,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contacto añadido correctamente');
    }

    public function update(Request $request, $id)
    {
        $contact = Emergency::findOrFail($id);
        $contact->update([
            'vehiculo_id' => $request->vehiculo_id,
            'nombre' => $request->nombre,
            'celular' => $request->celular,
            'email' => $request->email,
            'parentezco' => $request->parentezco,
            'prioridad' => $request->prioridad,
            'notificacion_preferencia' => $request->notificacion_preferencia,
        ]);

        return redirect()->route('contacts.index')->with('success', 'Contacto actualizado correctamente');
    }

    public function toggle($id, Request $request)
    {
        $contact = Emergency::findOrFail($id);

        if ($request->action === 'desactivar') {
            $contact->estado = 0;
            $contact->save();
            return response()->json(['message' => 'Contacto desactivado correctamente.']);
        } else {
            $contact->estado = 1;
            $contact->save();
            return response()->json(['message' => 'Contacto reactivado correctamente.']);
        }
    }
}
