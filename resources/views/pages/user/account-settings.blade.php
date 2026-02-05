<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Settings'}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        {{-- @vite(['resources/scss/light/assets/components/timeline.scss']) --}}
        <link rel="stylesheet" href="{{asset('plugins/filepond/filepond.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/filepond/FilePondPluginImagePreview.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/notification/snackbar/snackbar.min.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">

        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/light/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/light/assets/components/tabs.scss'])
        @vite(['resources/scss/light/assets/elements/alert.scss'])        
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/light/plugins/notification/snackbar/custom-snackbar.scss'])
        @vite(['resources/scss/light/assets/forms/switches.scss'])
        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/users/account-setting.scss'])

        @vite(['resources/scss/dark/plugins/filepond/custom-filepond.scss'])
        @vite(['resources/scss/dark/assets/components/tabs.scss'])
        @vite(['resources/scss/dark/assets/elements/alert.scss'])        
        @vite(['resources/scss/dark/plugins/sweetalerts2/custom-sweetalert.scss'])
        @vite(['resources/scss/dark/plugins/notification/snackbar/custom-snackbar.scss'])
        @vite(['resources/scss/dark/assets/forms/switches.scss'])
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/users/account-setting.scss'])
        
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <!-- BREADCRUMB -->
    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Usuario</a></li>
                <li class="breadcrumb-item active" aria-current="page">Configuración de cuenta</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->
        
    <div class="account-settings-container layout-top-spacing">

        <div class="account-content">
            <div class="row mb-3">
                <div class="col-md-12">
                    <h2>Configuración</h2>

                    <ul class="nav nav-pills" id="animateLine" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="animated-underline-home-tab" data-bs-toggle="tab" href="#animated-underline-home" role="tab" aria-controls="animated-underline-home" aria-selected="true"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg> Inicio</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="animated-underline-profile-tab" data-bs-toggle="tab" href="#animated-underline-profile" role="tab" aria-controls="animated-underline-profile" aria-selected="false" tabindex="-1"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-lock"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg> Avanzado</button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="tab-content" id="animateLineContent-4">
                <div class="tab-pane fade show active" id="animated-underline-home" role="tabpanel" aria-labelledby="animated-underline-home-tab">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                                <div class="info">
                                    <h6 class="">Información general</h6>
                                    <div class="row">
                                        <div class="col-lg-11 mx-auto">
                                            <div class="row">
                                                <div class="col-xl-2 col-lg-12 col-md-4">
                                                    <div class="profile-image  mt-4 pe-md-4">

                                                        <!-- // The classic file input element we'll enhance
                                                        // to a file pond, we moved the configuration
                                                        // properties to JavaScript -->
                                    
                                                        <div class="img-uploader-content">
                                                            <input type="file" class="filepond"
                                                                name="filepond" accept="image/png, image/jpeg, image/gif"/>
                                                        </div>
                                    
                                                    </div>
                                                </div>
                                                <div class="col-xl-10 col-lg-12 col-md-8 mt-md-0 mt-4">
                                                    <form class="form" action="{{ route('perfil.update') }}" method="POST">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="fullName">Nombre completo</label>
                                                                    <input name="nombre" type="text" class="form-control mb-3" id="fullName" placeholder="Full Name" value="{{Auth::user()->nombre}}">
                                                                </div>
                                                            </div>

                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="profession">Celular</label>
                                                                    <input name="celular" type="text" class="form-control mb-3" id="profession" placeholder="Designer" value="{{Auth::user()->celular}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="location">Correo</label>
                                                                    <input type="text" class="form-control mb-3" id="location" value="{{Auth::user()->email}}" disabled>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="address">Dirección</label>
                                                                    <input name="direccion" type="text" class="form-control mb-3" id="address" placeholder="Address" value="{{Auth::user()->direccion}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="phone">Fecha de nacimiento</label>
                                                                    <input name="fecha_nacimiento" id="basicFlatpickr" value="{{ \Carbon\Carbon::parse(Auth::user()->fecha_nacimiento)->format('Y-m-d') }}"  class="form-control mb-3 flatpickr flatpickr-input" type="text">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12 mt-1">
                                                                <div class="form-group text-end">
                                                                    <button type="submit" class="btn btn-secondary">Guardar</button>
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
                    </div>
                </div>
                <div class="tab-pane fade" id="animated-underline-profile" role="tabpanel" aria-labelledby="animated-underline-profile-tab">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing">
                            <div class="section general-info payment-info">
                                <div class="info">
                                    <h6 class="">Opciones avanzadas</h6>
                                    <p>Cambia tu <span class="text-success">Contraseña</span>.</p>
                                    <form id="passwordForm">
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Contraseña anterior</label>
                                                    <input id="oldPassword" name="oldPassword" type="password" class="form-control add-billing-address-input">
                                                    <small class="text-danger" id="oldPasswordError"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Nueva contraseña</label>
                                                    <input type="password" id="newPassword" name="newPassword" class="form-control">
                                                    <small id="passwordStrength" class="text-muted"></small>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="mb-3">
                                                    <label class="form-label">Repetir contraseña</label>
                                                    <input type="password" id="confirmPassword" name="confirmPassword" class="form-control">
                                                    <small id="passwordMatch" class="text-muted"></small>
                                                </div>
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary mt-4">Guardar cambios</button>
                                    </form>                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>

    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/filepond/filepond.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginFileValidateType.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageExifOrientation.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImagePreview.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageCrop.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageResize.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/FilePondPluginImageTransform.min.js')}}"></script>
        <script src="{{asset('plugins/filepond/filepondPluginFileValidateSize.min.js')}}"></script>
        <script src="{{asset('plugins/notification/snackbar/snackbar.min.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
        <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                let fechaGuardada = "{{ Auth::user()->fecha_nacimiento }}";

                flatpickr("#basicFlatpickr", {
                    dateFormat: "Y-m-d",
                    defaultDate: fechaGuardada
                });
            });
        </script>

        @vite(['resources/assets/js/users/account-settings.js'])

        <script type="module">
            userProfile.addFiles("{{Vite::asset('resources/images/user-profile.jpeg')}}");
        </script>

        <script>
        document.addEventListener("DOMContentLoaded", () => {
            const newPass = document.getElementById("newPassword");
            const confirmPass = document.getElementById("confirmPassword");
            const strengthText = document.getElementById("passwordStrength");
            const matchText = document.getElementById("passwordMatch");
            const form = document.getElementById("passwordForm");

            // Evaluar fortaleza
            newPass.addEventListener("input", () => {
                const val = newPass.value;
                let strength = 0;
                if (val.match(/[a-z]+/)) strength++;
                if (val.match(/[A-Z]+/)) strength++;
                if (val.match(/[0-9]+/)) strength++;
                if (val.match(/[$@#&!]+/)) strength++;
                if (val.length >= 8) strength++;

                let message = "";
                let color = "";

                switch (strength) {
                    case 0:
                    case 1: message = "Muy débil"; color = "text-danger"; break;
                    case 2: message = "Débil"; color = "text-warning"; break;
                    case 3: message = "Aceptable"; color = "text-primary"; break;
                    case 4: message = "Fuerte"; color = "text-success"; break;
                    case 5: message = "Muy fuerte"; color = "text-success fw-bold"; break;
                }

                strengthText.className = color;
                strengthText.textContent = message;
            });

            // Verificar coincidencia
            confirmPass.addEventListener("input", () => {
                if (confirmPass.value === newPass.value && confirmPass.value !== "") {
                    confirmPass.classList.remove("is-invalid");
                    confirmPass.classList.add("is-valid");
                    matchText.className = "text-success";
                    matchText.textContent = "Las contraseñas coinciden.";
                } else {
                    confirmPass.classList.remove("is-valid");
                    confirmPass.classList.add("is-invalid");
                    matchText.className = "text-danger";
                    matchText.textContent = "Las contraseñas no coinciden.";
                }
            });

            // Envío AJAX
            form.addEventListener("submit", (e) => {
                e.preventDefault();

                const data = {
                    oldPassword: document.getElementById("oldPassword").value,
                    newPassword: newPass.value,
                    confirmPassword: confirmPass.value,
                    _token: "{{ csrf_token() }}"
                };

                fetch("{{ route('password.update') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "Accept": "application/json"
                    },
                    body: JSON.stringify(data)
                })
                .then(res => res.json())
                .then(response => {
                    if (response.success) {
                        Swal.fire({
                            icon: "success",
                            title: "Contraseña actualizada correctamente",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        form.reset();
                        newPass.classList.remove("is-valid");
                        confirmPass.classList.remove("is-valid");
                        strengthText.textContent = "";
                        matchText.textContent = "";
                    } else {
                        document.getElementById("oldPasswordError").textContent = response.message || "Contraseña anterior incorrecta.";
                    }
                })
                .catch(err => console.error(err));
            });
        });
        </script>

        <script>
            FilePond.setOptions({
                server: {
                    process: {
                        url: "{{ route('user.uploadFoto') }}",
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }
                }
            });

            FilePond.create(document.querySelector('.filepond'));
        </script>
        
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>