<x-base-layout :scrollspy="false">

    <x-slot name="pageTitle">
        {{-- {{$title}}  --}}
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot name="headerFiles">
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite('resources/scss/light/assets/authentication/auth-boxed.scss')
        @vite('resources/scss/dark/assets/authentication/auth-boxed.scss')

        <style>
            #load_screen {
                display: none;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="auth-container d-flex">

        <div class="container mx-auto align-self-center">
    
            <div class="row">
    
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-8 col-12 d-flex flex-column align-self-center mx-auto">
                    <div class="card mt-3 mb-3">
                        <div class="card-body">
    
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    
                                    <h2>Iniciar Sesión</h2>
                                    <p>Inserta tu correo y contraseña para iniciar sesión</p>
                                    
                                </div>
                                <form method="POST" action="{{ route('login.post') }}">
                                    @csrf
                                    <div class="col-md-12">
                                        <div class="mb-3">
                                            <label class="form-label">Correo</label>
                                            <input name="email" value="{{ old('email') }}" type="email" class="form-control" required autofocus>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="mb-4 position-relative">
                                            <label class="form-label">Contraseña</label>
                                            <input type="password" id="password" name="password" class="form-control" style="padding-right: 50px;" required>
                                            <span id="togglePassword" style="
                                                position: absolute;
                                                top: 70%;
                                                right: 20px;
                                                transform: translateY(-50%);
                                                cursor: pointer;
                                                display: flex;
                                                align-items: center;
                                            ">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8z"/>
                                                    <path d="M8 5a3 3 0 1 0 0 6 3 3 0 0 0 0-6z"/>
                                                </svg>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-12">
                                        <div class="mb-4">
                                            <button type="submit" class="btn btn-secondary w-100">INICIAR SESIÓN</button>
                                        </div>
                                    </div>
                                </form>

                                @if($errors->any())
                                    <div style="color: red;">
                                        {{ $errors->first() }}
                                    </div>
                                @endif

                                @if (session('status'))
                                    <div class="alert alert-success">{{ session('status') }}</div>
                                @endif

                                @if (session('info'))
                                    <div class="alert alert-info">{{ session('info') }}</div>
                                @endif

                                @if (session('error'))
                                    <div class="alert alert-danger">{{ session('error') }}</div>
                                @endif

                                <div class="col-12">
                                    <div class="text-center">
                                        <p class="mb-0"><a href="{{ route('password-reset') }}" class="text-warning">Olvide mi contraseña</a></p>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>
            
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot name="footerFiles">
            <!-- Footer Files -->

        <script>
            const passwordInput = document.getElementById('password');
            const togglePassword = document.getElementById('togglePassword');

            togglePassword.addEventListener('mousedown', () => {
                passwordInput.type = 'text';
            });

            togglePassword.addEventListener('mouseup', () => {
                passwordInput.type = 'password';
            });

            togglePassword.addEventListener('mouseleave', () => {
                passwordInput.type = 'password';
            });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>