<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Resetear contraseña'}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!-- Estilos de autenticación -->
        @vite(['resources/scss/light/assets/authentication/auth-boxed.scss'])
        @vite(['resources/scss/dark/assets/authentication/auth-boxed.scss'])
    </x-slot>
<div class="container mt-5">
    <h3>Restablecer contraseña</h3>
    <form action="{{ route('password-update') }}" method="POST">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label>Correo electrónico</label>
            <input type="email" name="email" class="form-control" required>
            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
        </div>
        <div class="mb-3">
            <label>Nueva contraseña</label>
            <input type="password" name="password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirmar contraseña</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Cambiar contraseña</button>
    </form>
</div>
<x-slot name="footerFiles">
        <!-- Scripts opcionales -->
        @vite(['resources/js/app.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->

</x-base-layout>

