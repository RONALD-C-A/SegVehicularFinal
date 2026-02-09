<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Usuarios'}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        @vite(['resources/scss/light/assets/components/modal.scss'])
        @vite(['resources/scss/light/assets/apps/contacts.scss'])

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        @vite(['resources/scss/dark/assets/components/modal.scss'])
        @vite(['resources/scss/dark/assets/apps/contacts.scss'])
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="row layout-spacing layout-top-spacing" id="cancel-row">
        <div class="col-lg-12">
            <div class="widget-content searchable-container list">

                <div class="row">
                    <div class="col-xl-4 col-lg-5 col-md-5 col-sm-7 filtered-list-search layout-spacing align-self-center">
                        <form class="form-inline my-2 my-lg-0">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                                <input type="text" class="form-control product-search" id="input-search" placeholder="Buscar Vehículos..">
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                        <div class="d-flex justify-content-sm-end justify-content-center">
                            
                            <div class="switch align-self-center">
                                @if ($user->rol!='USUARIO')
                                    <button class="btn btn-warning me-4" data-bs-toggle="modal" data-bs-target="#asignarModal">Asignar usuarios</button>
                                    <svg id="btn-add-contact" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M3 13l2-5h10l2 5h2a2 2 0 0 1 2 2v3h-2a2 2 0 0 1-2 2h-1a2 2 0 0 1-2-2H8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2H1v-3a2 2 0 0 1 2-2z" /><circle cx="6.5" cy="18" r="1.5" /><circle cx="15.5" cy="18" r="1.5" /><line x1="12" y1="2" x2="12" y2="6" /><line x1="10" y1="4" x2="14" y2="4" /></svg>
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list view-list active-view"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid view-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="asignarModal" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content p-3">
                                    <form action="{{ route('vehicles.asignar') }}" method="POST">
                                        @csrf
                                        <h5 class="mb-3">Asignar usuario a vehículo</h5>
                                        @php
                                            $usuario = Auth::user();
                                            $isAdminOrSoporte = in_array($usuario->rol, ['ADMIN', 'SOPORTE']);
                                        @endphp
                                        <div class="mb-3">
                                            <label>Seleccionar usuario</label>
                                            <select name="user_id" class="form-select" required>
                                                <option value="">-- Seleccionar usuario --</option>
                                                @if($isAdminOrSoporte)
                                                    @foreach($duenos as $user)
                                                        <option value="{{ $user->id }}">{{ $user->nombre }} ({{ $user->rol }})</option>
                                                    @endforeach
                                                @else
                                                    @foreach($duenos as $user)
                                                        <option value="{{ $user->id }}">{{ $user->nombre }} ({{ $user->rol }})</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <!-- Select de vehículos -->
                                        <div class="mb-3">
                                            <label>Seleccionar vehículo</label>
                                            <select name="vehiculo_id" class="form-select" required>
                                                <option value="">-- Seleccionar vehículo --</option>
                                                @if($isAdminOrSoporte)
                                                    @foreach(\App\Models\Vehicle::all() as $v)
                                                        <option value="{{ $v->id }}">{{ $v->nro_placa ?? 'Sin placa' }} - {{ $v->modelo ?? 'Sin modelo' }}</option>
                                                    @endforeach
                                                @else
                                                    @foreach($vehicles as $v)
                                                        <option value="{{ $v->id }}">{{ $v->nro_placa ?? 'Sin placa' }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <!-- Rol -->
                                        <div class="mb-3">
                                            <label>Rol dentro del vehículo</label>
                                            <select name="rol" class="form-select" required>
                                                <option value="CONDUCTOR">Conductor</option>
                                                <option value="FAMILIA">Miembro familiar</option>
                                                <option value="OTRO">Otro</option>
                                            </select>
                                        </div>

                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary">Asignar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title add-title" id="addContactModalTitleLabel1">Añadir vehículo</h5>
                                        <h5 class="modal-title edit-title" id="addContactModalTitleLabel2" style="display: none;">Editar vehiculo</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="add-contact-box">
                                            <div class="add-contact-content">
                                                <form id="vehiculoForm" action="{{ route('vehicles.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" id="vehiculo_id" name="vehiculo_id">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="nro_placa" name="nro_placa" class="form-control" placeholder="Nro. Placa">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="dispositivo_id" name="dispositivo_id" class="form-control" placeholder="Id Dispositivo">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <select type="text" id="dueno_id" name="dueno_id" class="form-control" placeholder="Detalle">
                                                                <option value="">Seleccione un dueño</option>
                                                                @foreach($usuarios as $dueno)
                                                                    <option value="{{ $dueno->id }}">{{ $dueno->nombre }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="ano" name="ano" class="form-control" placeholder="Año" maxlength="4">
                                                            <span id="anoError"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="marca" name="marca" class="form-control" placeholder="Marca">
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="modelo" name="modelo" class="form-control" placeholder="Modelo">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" form="vehiculoForm" id="btn-save" class="btn btn-success">Guardar</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Descartar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="searchable-items list">
                    <div class="items items-header-section">
                        <div class="item-content">
                            <div class="d-inline-flex">
                                <h4>Vehiculo</h4>
                            </div>
                            <div class="user-email">
                                <h4>Detalles</h4>
                            </div>
                            <div class="user-location">
                                <h4 style="margin-left: 0;">Dueño</h4>
                            </div>
                            <div class="user-phone">
                                <h4 style="margin-left: 3px;">Estado</h4>
                            </div>
                            <div class="action-btn">
                                <h4 style="margin-left: 3px;">Acción</h4>
                            </div>
                        </div>
                    </div>
                    @foreach($vehicles as $car)
                    <div class="items">
                        <div class="item-content">
                            <div class="user-profile">
                                <div class="user-meta-info">
                                    <p class="user-name">{{ $car->nro_placa}}</p>
                                    <p class="user-work">{{ $car->dispositivo_id}}</p>
                                </div>
                            </div>
                            <div class="user-email">
                                    <p class="user-name">Marca: {{ $car->marca}}</p>
                                    <p class="user-work">{{ $car->modelo}} - {{ $car->ano}}</p>
                            </div>
                            <div class="user-location">
                                <p class="info-title">Propietario: </p> 
                                <p class="usr-location" data-location="Boston, USA">{{ $car->dueno->nombre }}</p>
                            </div>
                            <div class="user-phone">
                                <p class="info-title">Estado: </p>
                                    @if($car->estado == 1)
                                        <span class="badge bg-success">Activo</span>
                                    @elseif($car->estado == 2)
                                        <span class="badge bg-info">Inactivo</span>
                                    @else
                                        <span class="badge bg-danger">Eliminado</span>
                                    @endif
                            </div>
                            <div class="action-btn">
                                <svg 
                                    data-vehiculo='@json($car)'
                                    xmlns="http://www.w3.org/2000/svg" 
                                    width="24" height="24" viewBox="0 0 24 24" 
                                    fill="none" stroke="purple" stroke-width="2" 
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-edit-2 btn-edit"
                                    style="cursor:pointer">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    @if($car->estado == 1)
                                        <svg data-id="{{ $car->id }}" data-action="desactivar"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-trash-2 btn-toggle"
                                            style="cursor:pointer; color: red;">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4
                                            a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                            <line x1="10" y1="11" x2="10" y2="17"></line>
                                            <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                    @else
                                        <svg data-id="{{ $car->id }}" data-action="activar"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                            class="feather feather-refresh-ccw btn-toggle"
                                            style="cursor:pointer; color: green;">
                                            <polyline points="1 4 1 10 7 10"></polyline>
                                            <polyline points="23 20 23 14 17 14"></polyline>
                                            <path d="M20.49 9A9 9 0 0 0 5.64 5.64L1 10m22 4-4.64 4.36A9 9 0 0 1 3.51 15"></path>
                                        </svg>
                                    @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
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
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const modal = new bootstrap.Modal(document.getElementById('addContactModal'));
                const form = document.getElementById('vehiculoForm');
                const btnSave = document.getElementById('btn-save');
                const placaInput = document.getElementById('nro_placa');
                placaInput.addEventListener('input', function () {
                    this.value = this.value.toUpperCase();
                });
                document.getElementById('btn-add-contact').addEventListener('click', function () {
                    form.reset();
                    document.getElementById('vehiculo_id').value = "";
                    btnSave.textContent = "Añadir";
                    document.querySelector('.add-title').style.display = "block";
                    document.querySelector('.edit-title').style.display = "none";
                    modal.show();
                });
                document.querySelectorAll('.btn-edit').forEach(button => {
                    button.addEventListener('click', function () {
                        const vehiculo = JSON.parse(this.dataset.vehiculo);
                        document.getElementById('vehiculo_id').value = vehiculo.id;
                        document.getElementById('nro_placa').value = vehiculo.nro_placa;
                        document.getElementById('dispositivo_id').value = vehiculo.dispositivo_id;
                        document.getElementById('dueno_id').value = vehiculo.dueno_id;
                        document.getElementById('marca').value = vehiculo.marca;
                        document.getElementById('modelo').value = vehiculo.modelo;
                        document.getElementById('ano').value = vehiculo.ano;

                        btnSave.textContent = "Guardar cambios";
                        document.querySelector('.add-title').style.display = "none";
                        document.querySelector('.edit-title').style.display = "block";

                        form.action = `/vehicles/${vehiculo.id}`;
                        form.method = "POST";

                        let methodInput = document.createElement('input');
                        methodInput.type = 'hidden';
                        methodInput.name = '_method';
                        methodInput.value = 'PUT';
                        form.appendChild(methodInput);

                        modal.show();
                    });
                });

                form.addEventListener('submit', function(e) {
                    const nroPlaca = document.getElementById('nro_placa').value.trim();
                    const dispositivo = document.getElementById('dispositivo_id').value.trim();
                    const dueno = document.getElementById('dueno_id').value;
                    const ano = document.getElementById('ano').value.trim();
                    const marca = document.getElementById('marca').value.trim();
                    const modelo = document.getElementById('modelo').value.trim();

                    if (!nroPlaca || !dispositivo || !dueno || !ano || !marca || !modelo) {
                        e.preventDefault();
                        toastr.warning('Por favor completa todos los campos obligatorios.');
                    }
                });

                document.querySelectorAll('.btn-toggle').forEach(button => {
                    button.addEventListener('click', function () {
                        const id = this.dataset.id;
                        const action = this.dataset.action;

                        fetch(`/vehicles/${id}/toggle`, {
                            method: 'PUT',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ action })
                        })
                        .then(res => res.json())
                        .then(data => {
                            toastr.success(data.message || 'Operación realizada con éxito');
                            setTimeout(() => location.reload(), 1500);
                        })
                        .catch(err => {
                            console.error(err);
                            toastr.error('Ocurrió un error al procesar la solicitud');
                        });
                    });
                });
            });

        </script>

        <script>
            document.getElementById('ano').addEventListener('keypress', function (e){
                const anioError = document.getElementById('anoError');
                const pattern = /^[0-9]*$/;
                if(!pattern.test(e.key)){
                    e.preventDefault();
                    anioError.textContent="No se permiten letras";
                    anioError.style.color="red";
                }
            });
        </script>


    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>