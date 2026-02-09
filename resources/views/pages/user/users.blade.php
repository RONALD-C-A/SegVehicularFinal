<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Usuarios'}} 
    </x-slot>

    <x-slot:headerFiles>
        @vite(['resources/scss/light/assets/components/modal.scss', 'resources/scss/dark/assets/components/modal.scss'])
        @vite(['resources/scss/light/assets/apps/contacts.scss', 'resources/scss/dark/assets/apps/contacts.scss'])
        
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss', 'resources/scss/light/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss', 'resources/scss/dark/plugins/table/datatable/custom_dt_custom.scss'])
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss', 'resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
        
        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/sweetalerts2/sweetalerts2.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

        <style>
            /* FIX: Evita que el Navbar se comprima y oculte el nombre */
            .header-container .navbar .nav-item.user-profile-dropdown .dropdown-toggle .media-body {
                display: block !important;
            }
            
            /* FIX: Forzar scroll interno de tabla y evitar scroll horizontal de página */
            .table-responsive {
                overflow-x: auto !important;
                width: 100% !important;
            }

            .swal2-dark {
                background-color: #1e1e1e !important;
                color: #fff !important;
                border: 1px solid #444;
            }
        </style>
    </x-slot>

    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Añadir Usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formUsuario">
                        @csrf
                        <input type="hidden" id="user_id">
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>Nombre completo <span class="text-danger">*</span></label>
                                <input pattern="[a-zA-Z\s]+" type="text" id="nombre" class="form-control" required>
                                <span id="nombreError"></span>

                            </div>
                            <div class="mb-3 col-md-6">
                                <label>Celular <span class="text-danger">*</span></label>
                                <input type="text" id="celular" class="form-control" required>
                                <span id="celularError"></span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-7">
                                <label>Correo <span class="text-danger">*</span></label>
                                <input type="email" id="email" class="form-control" required>
                                <span id="emailError"></span>
                            </div>
                            <div class="mb-3 col-md-5">
                                <label>Rol <span class="text-danger">*</span></label>
                                <select id="rol" class="form-select" required></select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label>Dirección</label>
                                <input type="text" id="direccion" class="form-control">
                            </div>
                            <div class="mb-3 col-md-6">
                                <label>Fecha de nacimiento</label>
                                <input type="text" class="form-control bg-current" id="fecha_nacimiento" placeholder="Seleccionar fecha">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-dark" data-bs-dismiss="modal">Cancelar</button>
                    <button id="guardarUsuario" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="layout-px-spacing">
        <div class="middle-content container-xxl p-0">
            
            <div class="row layout-top-spacing">
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area">
                            
                            <div class="d-flex justify-content-between align-items-center px-3 py-3">
                                <h4 class="m-0">Gestión de Usuarios</h4>
                                <button class="btn btn-primary" onclick="$('#formUsuario')[0].reset(); $('#user_id').val(''); $('#modalTitulo').text('Añadir Usuario'); $('#modalUsuario').modal('show');">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus me-1"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                    Nuevo Usuario
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table id="style-3" class="table style-3 dt-table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Nombre</th>
                                            <th>Email</th>
                                            <th>Celular</th>
                                            <th>Rol</th>
                                            <th>Dirección</th>
                                            <th class="text-center">Estado</th>
                                            <th class="text-center dt-no-sorting">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $index => $user)
                                        <tr>
                                            <td class="text-center">{{$index + 1}}</td>
                                            <td class="text-truncate" style="max-width: 150px;">{{$user->nombre}}</td>
                                            <td>{{$user->email}}</td>
                                            <td>{{$user->celular}}</td>
                                            <td><span class="badge badge-light-primary">{{$user->rol}}</span></td>
                                            <td class="text-truncate" style="max-width: 150px;">{{$user->direccion}}</td>
                                            <td class="text-center">
                                                @php
                                                    $statusClasses = [1 => 'bg-success', 2 => 'bg-info'];
                                                    $statusTexts = [1 => 'Activo', 2 => 'Inactivo'];
                                                @endphp
                                                <span class="badge {{ $statusClasses[$user->estado] ?? 'bg-danger' }}">
                                                    {{ $statusTexts[$user->estado] ?? 'Eliminado' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-btns">
                                                    <a href="javascript:void(0);" class="btn-editar bs-tooltip" 
                                                       data-id="{{$user->id}}" data-nombre="{{$user->nombre}}" data-email="{{$user->email}}"
                                                       data-celular="{{$user->celular}}" data-direccion="{{$user->direccion}}"
                                                       data-fecha_nacimiento="{{$user->fecha_nacimiento}}" data-rol="{{$user->rol}}"
                                                       title="Editar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="feather feather-edit-2 text-primary"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                    </a>
                                                    @if($user->rol != 'ADMIN' && $user->estado != 0)
                                                    <a href="javascript:void(0);" class="btn-estado bs-tooltip" data-id="{{$user->id}}" data-accion="eliminar" title="Eliminar">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#dc3545" stroke-width="2" class="feather feather-trash"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                                    </a>
                                                    @endif
                                                </div>
                                            </td>
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

    <x-slot:footerFiles>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        
        <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
        <script src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>

        <script type="module">
            $(document).ready(function() {
                // Inicializar DataTable
                const table = $('#style-3').DataTable({
                    dom: "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start'l><'col-12 col-sm-6 d-flex justify-content-sm-end'f>>>" +
                         "<'table-responsive'tr>" +
                         "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count mb-sm-0'i><'dt--pagination'p>>",
                    oLanguage: {
                        oPaginate: {
                            sPrevious: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>',
                            sNext: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>'
                        },
                        sSearch: '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" class="me-1"><circle cx="8" cy="8" r="7"/><line x1="15" y1="15" x2="20" y2="20"/></svg>',
                        sSearchPlaceholder: "Buscar...",
                        sLengthMenu: "Resultados: _MENU_",
                        sInfo: "Página _PAGE_ de _PAGES_"
                    },
                    stripeClasses: [],
                    lengthMenu: [5, 10, 20],
                    pageLength: 10
                });

                flatpickr('#fecha_nacimiento', {
                    dateFormat: "Y-m-d",
                    maxDate: new Date().setFullYear(new Date().getFullYear() - 16),
                    static: true
                });

                // Lógica de Roles según Usuario Autenticado
                const userRole = "{{ Auth::user()->rol }}";
                const $rolSelect = $('#rol');
                
                const rolesMap = {
                    'ADMIN': ['ADMIN', 'SOPORTE', 'PROPIETARIO', 'USUARIO'],
                    'SOPORTE': ['PROPIETARIO', 'USUARIO'],
                    'PROPIETARIO': ['USUARIO']
                };

                (rolesMap[userRole] || []).forEach(r => $rolSelect.append(new Option(r, r)));

                // Evento Guardar
                $('#guardarUsuario').click(function() {
                    const $btn = $(this);
                    const form = document.getElementById('formUsuario');
                    
                    if (!form.checkValidity()) return form.reportValidity();

                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');

                    const payload = {
                        _token: '{{ csrf_token() }}',
                        id: $('#user_id').val(),
                        nombre: $('#nombre').val(),
                        email: $('#email').val(),
                        celular: $('#celular').val(),
                        direccion: $('#direccion').val(),
                        fecha_nacimiento: $('#fecha_nacimiento').val(),
                        rol: $rolSelect.val(),
                        password: Math.random().toString(36).slice(-10) // Password temporal
                    };

                    $.post('{{ route("usuarios.store") }}', payload)
                        .done(res => {
                            toastr.success(res.message || 'Operación exitosa');
                            $('#modalUsuario').modal('hide');
                            setTimeout(() => location.reload(), 1000);
                        })
                        .fail(err => toastr.error(err.responseJSON?.error || 'Error al procesar'))
                        .always(() => $btn.prop('disabled', false).text('Guardar'));
                });

                $(document).on('click', '.btn-editar', function() {
                    const d = $(this).data();
                    $('#user_id').val(d.id);
                    $('#nombre').val(d.nombre);
                    $('#email').val(d.email);
                    $('#celular').val(d.celular);
                    $('#direccion').val(d.direccion);
                    $('#fecha_nacimiento').val(d.fecha_nacimiento);
                    $('#rol').val(d.rol);
                    $('#modalTitulo').text('Editar Usuario');
                    $('#modalUsuario').modal('show');
                });
            });
        </script>
        <script>
            document.getElementById('nombre').addEventListener('keypress', function (e){
                const pattern = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ ]*$/;
                const errorNombre = document.getElementById('nombreError');
                if(!pattern.test(e.key)){
                    e.preventDefault();
                    errorNombre.textContent = "Solo se aceptan letras";
                    errorNombre.style.color = "red";
                } else {
                    errorNombre.textContent = "";
                }
            });
            document.getElementById('celular').addEventListener('keypress', function (e){
                const pattern = /^[0-9]*$/;
                const errorCel = document.getElementById('celularError');
                if(!pattern.test(e.key)){
                    e.preventDefault();
                    errorCel.textContent = "Solo se aceptan números";
                    errorCel.style.color = "red";
                } else {
                    errorCel.textContent = "";
                }
            });            
            document.getElementById('email').addEventListener('input', function (e) {
                const pattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                const errorDiv = document.getElementById('emailError');
                const valor = e.target.value;

                if (valor === "") {
                    errorDiv.textContent = "";
                } else if (!pattern.test(valor)) {
                    errorDiv.textContent = "Formato de correo inválido (ejemplo: usuario@dominio.com)";
                    errorDiv.style.color = "red";
                } else {
                    errorDiv.textContent = "Correo válido";
                    errorDiv.style.color = "green";
                }
            });
        </script>
    </x-slot>

</x-base-layout>