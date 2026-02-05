@component('mail::message')
# ¡Bienvenido, {{ $user->nombre }}!

Tu cuenta ha sido creada correctamente.  
Para acceder al sistema, utiliza la siguiente información:

**Correo:** {{ $user->email }}  
**Contraseña:** {{ $password }}

Haz clic en el siguiente botón para activar tu cuenta:

@component('mail::button', ['url' => route('activar-cuenta', $user->id)])
Activar Cuenta
@endcomponent

Gracias,  
{{ config('app.name') }}
@endcomponent