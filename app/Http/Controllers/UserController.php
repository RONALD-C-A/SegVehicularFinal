<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ActivarCuenta;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index()
    {
      $user =Auth::user();

      if (in_array($user->rol, ['USUARIO', 'PROPIETARIO'])) {
          $users = User::where('estado', 1)->where('idUsuario', $user->id)->get();
      } elseif (in_array($user->rol, ['SOPORTE'])) {
          $users = User::where('estado', 1)->get();
      } elseif (in_array($user->rol, ['ADMIN'])) {
          $users = User::all();
      } else {
          $users = collect();
      }

      return view('pages.user.users', compact('users'));
      }


    public function perfilUpdate(Request $request)
    {
      try {
        $usuario=Auth::user();

        \App\Models\User::where('id', $usuario->id)->update([
            'nombre' => $request->nombre,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'fecha_nacimiento' => $request->fecha_nacimiento,
        ]);
        return redirect()->back()->with('success', 'Perfil actualizado correctamente.');
      } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al actualizar: '. $e->getMessage());
      }
    }

    public function validarEmail(Request $request)
    {
        $existe = User::where('email', $request->email)->exists();
        return response()->json(['disponible' => !$existe]);
    }

    public function store(Request $request)
    {
        try {
            if ($request->id) {
                $user = User::findOrFail($request->id);
                $user->update([
                    'nombre' => $request->nombre,
                    'email' => $request->email,
                    'celular' => $request->celular,
                    'rol' => $request->rol,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'direccion' => $request->direccion ?? null,
                ]);

                return response()->json(['message' => 'Usuario actualizado correctamente']);
            } else {
                $password = $request->password ?? str()->random(12);

                $user = User::create([
                    'nombre' => $request->nombre,
                    'email' => $request->email,
                    'celular' => $request->celular,
                    'rol' => $request->rol,
                    'fecha_nacimiento' => $request->fecha_nacimiento,
                    'password' => Hash::make($password),
                    'direccion' => $request->direccion ?? null,
                    'estado' => 2,
                    'idUsuario' => Auth::user()->id,
                ]);
                
                Mail::to($user->email)->send(new ActivarCuenta($user, $password));

                return response()->json(['message' => 'Usuario creado y correo enviado']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar usuario', 'error' => $e->getMessage()], 500);
        }
    }

    public function cambiarEstado(Request $request)
    {
        try {
            $user = User::findOrFail($request->id);
            $user->estado = $user->estado == 1 ? 0 : 1;
            $user->save();

            return response()->json([
                'message' => $user->estado ? 'Usuario restaurado correctamente' : 'Usuario eliminado correctamente',
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al cambiar estado', 'error' => $e->getMessage()], 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $user = Auth::user();

        if (!Hash::check($request->oldPassword, $user->password)) {
            return response()->json(['success' => false, 'message' => 'La contraseña anterior no es correcta.']);
        }

        if ($request->newPassword !== $request->confirmPassword) {
            return response()->json(['success' => false, 'message' => 'Las contraseñas no coinciden.']);
        }

        $user->password = Hash::make($request->newPassword);
        $user->save();

        return response()->json(['success' => true]);
    }

    public function uploadFoto(Request $request)
    {
        if ($request->hasFile('filepond')) {

            $user = Auth::user();

            // 1️⃣ Eliminar la foto anterior si existe y no es la predeterminada
            if ($user->foto_perfil && file_exists(public_path($user->foto_perfil))) {
                @unlink(public_path($user->foto_perfil));
            }

            // 2️⃣ Guardar la nueva foto
            $file = $request->file('filepond');
            $nombre = time() . '_' . $file->getClientOriginalName();
            $ruta = $file->storeAs('uploads/perfil', $nombre, 'public');

            // 3️⃣ Actualizar el campo en la base de datos
            $user->foto_perfil = '/storage/' . $ruta;
            $user->save();

            Auth::user()->refresh();

            // 4️⃣ Retornar la ruta nueva
            return response()->json([
                'success' => true,
                'ruta' => $user->foto_perfil
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No se subió ningún archivo.'
        ]);
    }

    public function activarCuenta($id)
    {
        $user = \App\Models\User::find($id);

        if (!$user) {
            return redirect('/login')->with('error', 'Usuario no encontrado.');
        }

        if ($user->estado == 1) {
            return redirect('/login')->with('info', 'Tu cuenta ya está activada.');
        }

        $user->estado = 1;
        $user->save();

        return redirect('/login')->with('status', 'Tu cuenta ha sido activada correctamente. Ya puedes iniciar sesión.');
    }
}
