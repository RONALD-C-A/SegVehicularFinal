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
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="auth-container d-flex h-100">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                            @if (session('status'))
                                <div class="alert alert-success">{{ session('status') }}</div>
                            @endif
                        <div class="card-body">
                            <form action="{{ route('password.email') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        
                                        <h2>Olvidaste tu contraseña</h2>
                                        <p>Ingresa tu correo para recuperar tu contraseña.</p>
                                        
                                    </div>
                                    <div class="col-md-12">
                                        <div class="mb-4">
                                            <label class="form-label">Correo</label>
                                            <input name="email" type="email" class="form-control" required>
                                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-secondary w-100">Enviar enlace</button>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-center">
                                            <p class="mb-0"><a href="{{ route('login') }}" class="text-warning">Iniciar sesión</a></p>
                                        </div>
                                    </div>
                                </div>
                            </form> 
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>

    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot name="footerFiles">
        <!-- Scripts opcionales -->
        @vite(['resources/js/app.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->

</x-base-layout>
