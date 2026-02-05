<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Models\Admin;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Mostrar formulario de login
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = \App\Models\User::where('email', $credentials['email'])->first();

        if (!$user || $user->estado == 0) {
            return back()->withErrors([
                'email' => 'El usuario no existe o fue eliminado.'
            ]);
        }

        if ($user->estado == 2) {
            return back()->withErrors([
                'email' => 'La cuenta no está activada.'
            ]);
        }
        if ($user->estado == 1) {
            if (Auth::attempt($credentials, $request->filled('remember'))) {
                $request->session()->regenerate();
                if (in_array($user->rol, ['USUARIO', 'PROPIETARIO'])) {
                    return redirect()->route('duser')->with('title', 'Panel Usuario');
                } elseif (in_array($user->rol, ['ADMIN', 'SOPORTE'])) {
                    return redirect()->route('dadmin')->with('title', 'Panel Administrador');
                }
                Auth::logout();
                return back()->withErrors(['email' => 'Tu rol no tiene acceso al sistema.']);
            }

            // Credenciales incorrectas
            return back()->withErrors(['email' => 'Credenciales inválidas.']);
        }
    }

    public function reset()
    {
        return view('auth.password-reset');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
        ]);

        $token = Str::random(64);

        // Guardamos token temporalmente (sin migraciones)
        DB::table('password_resets')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        $resetLink = url('/reset-password/' . $token);

        Mail::raw("Haz clic en este enlace para restablecer tu contraseña: $resetLink", function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Restablecer contraseña');
        });

        return back()->with('status', 'Se ha enviado un enlace para restablecer tu contraseña a tu correo.');
    }

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => "required|email|exists:user,email",
            'password' => 'required|confirmed|min:6',
            'token'    => 'required'
        ]);

        // Buscar registro del token
        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Token inválido o expirado.']);
        }

        // (Opcional) comprobar expiración del token (ej. 60 minutos)
        if (isset($record->created_at) && \Carbon\Carbon::parse($record->created_at)->addMinutes(60)->isPast()) {
            DB::table('password_resets')->where('email', $request->email)->delete();
            return back()->withErrors(['email' => 'Token expirado. Solicita uno nuevo.']);
        }

        $user = \App\Models\User::where('email', $request->email)->firstOrFail();
        $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        $user->save();
        Log::debug('ResetPassword - después', ['user_id' => $user->id, 'new_hash' => $user->password]);

        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Contraseña restablecida correctamente.');
    }

}