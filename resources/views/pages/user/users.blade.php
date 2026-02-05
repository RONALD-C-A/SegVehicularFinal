<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Usuarios'}} 
    </x-slot>
 
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/light/assets/apps/contacts.scss'])
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/apps/contacts.scss'])
        @vite(['resources/scss/light/plugins/sweetalerts2/custom-sweetalert.scss'])

        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <style>
            .swal2-dark {
            background-color: #1e1e1e !important;
            color: #fff !important;
            border: 1px solid #444;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Añadir Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formUsuario">
                @csrf
                <input type="hidden" id="user_id">
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label>Nombre completo <span style="color: red;">*</span></label>
                        <input type="text" id="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Celular <span style="color: red;">*</span></label>
                        <input type="number" id="celular" class="form-control" required>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-7">
                        <label>Correo <span style="color: red;">*</span></label>
                        <input type="email" id="email" class="form-control" required>
                    </div>

                    <div class="mb-3 col-md-5">
                        <label>Rol <span style="color: red;">*</span></label>
                        <select id="rol" class="form-select" required></select>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 col-md-6">
                        <label>Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="form-control" required>
                    </div>

                    <div class="mb-3 col-md-6">
                        <label>Fecha de nacimiento</span></label>
                        <input type="text" class="form-control bg-current text-white" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha nacimiento" required>
                    </div>
                </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button id="guardarUsuario" class="btn btn-success">Guardar</button>
            </div>
            </div>
        </div>
    </div>

    
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="widget-content searchable-container list">

                <div class="row layout-spacing">
                    <div class="col-lg-12">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-content widget-content-area">
                                <div class="d-flex justify-content-between align-items-center m-3">
                                    <h4 class="m-2">Usuarios</h4>
                                    <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#modalUsuario">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus me-1">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="8.5" cy="7" r="4"></circle>
                                            <line x1="20" y1="8" x2="20" y2="14"></line>
                                            <line x1="23" y1="11" x2="17" y2="11"></line>
                                        </svg>
                                        Nuevo Usuario
                                    </button>
                                </div>
                                <table id="style-3" class="table style-3 dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th class="checkbox-column text-center"> # </th>
                                            <th class="text-center">Nombre</th>
                                            <th>Email</th>
                                            <th>Celular</th>
                                            <th>Rol</th>
                                            <th>Dirección</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center dt-no-sorting">Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $index => $user)
                                        <tr>
                                            <td class="checkbox-column text-center"> {{$index + 1}} </td>
                                            <td> {{$user->nombre}} </td>
                                            <td> {{$user->email}} </td>
                                            <td> {{$user->celular}} </td>
                                            <td> {{$user->rol}} </td>
                                            <td> {{$user->direccion}} </td>
                                            <td class="text-center">
                                                @if($user->estado == 1)
                                                    <span class="badge bg-success">Activo</span>
                                                @elseif($user->estado == 2)
                                                    <span class="badge bg-info">Inactivo</span>
                                                @else
                                                    <span class="badge bg-danger">Eliminado</span>
                                                @endif
                                            </td>
                                            @if ($user->rol!='ADMIN')
                                            <td class="text-center">
                                                <ul class="table-controls d-flex justify-content-center list-unstyled mb-0">
                                                    <li>
                                                        <a href="javascript:void(0);" 
                                                        class="btn-editar bs-tooltip me-2"
                                                        data-bs-toggle="tooltip"
                                                        data-bs-placement="top"
                                                        title="Editar"
                                                        data-id="{{ $user->id }}"
                                                        data-nombre="{{ $user->nombre }}"
                                                        data-email="{{ $user->email }}"
                                                        data-celular="{{ $user->celular }}"
                                                        data-fecha_nacimiento="{{ $user->fecha_nacimiento }}"
                                                        data-direccion="{{ $user->direccion }}"
                                                        data-rol="{{ $user->rol }}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-edit-2 p-1 rounded-circle">
                                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                            </svg>
                                                        </a>
                                                    </li>
                                                    @if ($user->estado!=2)
                                                        <li>
                                                            <a href="javascript:void(0);"
                                                            class="btn-estado bs-tooltip"
                                                            data-bs-toggle="tooltip"
                                                            data-bs-placement="top"
                                                            title="{{ $user->estado==1 ? 'Eliminar' : 'Restaurar' }}"
                                                            data-accion="{{ $user->estado == 1 ? 'eliminar' : 'restaurar' }}"
                                                            data-id="{{ $user->id }}">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                                    viewBox="0 0 24 24" fill="none"
                                                                    stroke="{{ $user->estado ? '#dc3545' : '#28a745' }}"
                                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                    class="feather feather-trash p-1 rounded-circle">
                                                                    <polyline points="3 6 5 6 21 6"></polyline>
                                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                                                            a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                                </svg>
                                                            </a>
                                                        </li>
                                                    @endif
                                                </ul>
                                            </td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        @vite(['resources/assets/js/custom.js'])
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="{{asset('plugins/jquery-ui/jquery-ui.min.js')}}"></script>
        @vite(['resources/assets/js/apps/contact.js'])
        <script type="module" src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @vite(['resources/assets/js/custom.js'])
        <script type="module" src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
        <script src="{{asset('plugins/sweetalerts2/sweetalerts2.min.js')}}"></script>
        <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
        <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script>

        <script type="module">
            const c3 = $('#style-3').DataTable({
                dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start'l><'col-12 col-sm-6 d-flex justify-content-sm-end'f>>>" +
             "<'table-responsive'tr>" +
             "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0'i><'dt--pagination'p>>",
                oLanguage: {
                    oPaginate: {
                        sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
                        sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>'
                    },
                    sInfo: "Mostrando página _PAGE_ de _PAGES_",
                    sSearch:`
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" class="me-1 align-middle">
                            <circle cx="8" cy="8" r="7"/>
                            <line x1="15" y1="15" x2="20" y2="20"/>
                        </svg>
                    `,
                    sSearchPlaceholder: "Buscar...",
                    sLengthMenu: "Resultados: _MENU_"
                },
                stripeClasses: [],
                lengthMenu: [5, 10, 20, 50],
                pageLength: 10
            });

            multiCheck(c3);
        </script>

        <script>
        $(document).ready(function () {
            const userRole = "{{ Auth::user()->rol }}"; 

            function cargarRoles() {
                const select = $('#rol');
                select.empty();

                if (userRole === 'ADMIN') {
                    select.append('<option value="ADMIN">ADMIN</option><option value="SOPORTE">SOPORTE</option><option value="PROPIETARIO">PROPIETARIO</option><option value="USUARIO">USUARIO</option>');
                } else if (userRole === 'SOPORTE') {
                    select.append('<option value="PROPIETARIO">PROPIETARIO</option><option value="USUARIO">USUARIO</option>');
                } else if (userRole === 'PROPIETARIO') {
                    select.append('<option value="USUARIO">USUARIO</option>');
                }
            }

            cargarRoles();

            const hoy = new Date();
            const fechaMaxima = new Date(
                hoy.getFullYear() - 16,
                hoy.getMonth(),
                hoy.getDate()
            );

            // --- Generar contraseña aleatoria ---
            function generarPassword() {
                const length = Math.floor(Math.random() * (15 - 10 + 1)) + 10;
                const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*';
                let pass = '';
                for (let i = 0; i < length; i++) pass += chars.charAt(Math.floor(Math.random() * chars.length));
                return pass;
            }

            $('#email').on('blur', function () {
            const email = $(this).val().trim();
            if (email === '') return;

            $.post('{{ route("usuarios.validarEmail") }}', {
                _token: '{{ csrf_token() }}',
                email
            }, function (res) {
                if (!res.disponible) {
                    toastr.error('El correo ya está registrado.', 'Correo duplicado');
                    $('#email').addClass('is-invalid');
                } else {
                    $('#email').removeClass('is-invalid');
                }
            }).fail(() => {
                toastr.error('Error al validar el correo.');
            });
        });

            const fechaNacimientoPicker = flatpickr('#fecha_nacimiento', {
                dateFormat: "Y-m-d",
                maxDate: fechaMaxima,
                allowInput: true,
                appendTo: document.querySelector('#modalUsuario')
            });

            // --- Botón Guardar Usuario ---
            $('#guardarUsuario').click(function () {
                const form = document.getElementById('formUsuario');
                const id = $('#user_id').val();
                const password = generarPassword();

                if (!form.checkValidity()) {
                    form.reportValidity();
                    return;
                }

                const data = {
                    _token: $('input[name="_token"]').val(),
                    id,
                    nombre: $('#nombre').val(),
                    email: $('#email').val(),
                    celular: $('#celular').val(),
                    direccion: $('#direccion').val(),
                    fecha_nacimiento: $('#fecha_nacimiento').val(),
                    rol: $('#rol').val(),
                    password
                };

                const btn = $(this);
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Guardando...');


                

                $.post('{{ route("usuarios.store") }}', data, function (res) {
                    if (id) {
                        toastr.success(res.message || 'Usuario actualizado correctamente');
                    } else {
                        toastr.success(res.message || 'Usuario creado y correo enviado');
                    }
                    $('#modalUsuario').modal('hide');
                    setTimeout(() => location.reload(), 1500);
                }).fail((xhr) => {
                    console.error(xhr.responseJSON);
                    toastr.error(xhr.responseJSON?.error || 'No se pudo guardar el usuario');
                }).always(function () {
                    btn.prop('disabled', false).html('Guardar');
                });
            });

            // --- Botón Editar ---
            $(document).on('click', '.btn-editar', function () {
                const btn = $(this);
                $('#user_id').val(btn.data('id'));
                $('#nombre').val(btn.data('nombre'));
                $('#email').val(btn.data('email'));
                $('#celular').val(btn.data('celular'));
                $('#direccion').val(btn.data('direccion'));
                $('#fecha_nacimiento').val(btn.data('fecha_nacimiento'));
                $('#rol').val(btn.data('rol'));

                $('#modalUsuario').modal('show');
            });

            // --- Botón Cambiar Estado ---
            $(document).on('click', '.btn-estado', function () {
                const id = $(this).data('id');
                const accion = $(this).data('accion');

                Swal.fire({
                    title: `¿Deseas ${accion} este usuario?`,
                    icon: 'warning',
                    showCancelButton: true,
                    theme: 'dark',
                    confirmButtonText: 'Sí, continuar',
                    cancelButtonText: 'Cancelar',
                    confirmButtonColor: accion === 'eliminar' ? '#d33' : '#28a745',
                    customClass: {
                        popup: 'swal2-dark'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.post('{{ route("usuarios.cambiarEstado") }}', { id, _token: '{{ csrf_token() }}' }, function (res) {
                            Swal.fire('Hecho', res.message, 'success').then(() => location.reload());
                        }).fail(() => Swal.fire('Error', 'No se pudo cambiar el estado', 'error'));
                    }
                });
            });
        });
        </script>

    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>