<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Contactos'}} 
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
                                <input type="text" class="form-control product-search" id="input-search" placeholder="Buscar Contacto..">
                            </div>
                        </form>
                    </div>

                    <div class="col-xl-8 col-lg-7 col-md-7 col-sm-5 text-sm-right text-center layout-spacing align-self-center">
                        <div class="d-flex justify-content-sm-end justify-content-center">
                            <div class="switch align-self-center">
                                @if($user->rol=='PROPIETARIO' && $total < 3)
                                    <svg id="btn-add-contact" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                @elseif($user->rol=='ADMIN' || $user->rol=="SOPORTE")
                                    <svg id="btn-add-contact" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                                @endif
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list view-list active-view"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3" y2="6"></line><line x1="3" y1="12" x2="3" y2="12"></line><line x1="3" y1="18" x2="3" y2="18"></line></svg>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid view-grid"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                            </div>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title add-title" id="addContactModalTitleLabel1">Añadir contacto</h5>
                                        <h5 class="modal-title edit-title" id="addContactModalTitleLabel2" style="display: none;">Editar contacto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                          <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <div class="add-contact-box">
                                            <div class="add-contact-content">
                                                <form id="vehiculoForm" action="{{ route('contact.store') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" id="contact_id" name="contact_id">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <select id="vehiculo_id" name="vehiculo_id" class="form-control">
                                                                <option value="">Seleccione el vehículo</option>
                                                                @foreach($vehicles as $car)
                                                                    <option value="{{ $car->id }}">
                                                                        {{ $car->nro_placa }} | {{ $car->dueno->nombre }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre completo *">
                                                            <span id="errorNombre"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="celular" name="celular" class="form-control" placeholder="Nro. Celular *">
                                                            <span id="errorCelular"></span>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <input type="text" id="email" name="email" class="form-control" placeholder="Correo">
                                                            <span id="errorEmail"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-4 mb-3">
                                                            <select id="prioridad" name="prioridad" class="form-control" placeholder="Prioridad">
                                                                <option value="">Prioridad</option>
                                                                <option value="1">IMPORTANTE</option>
                                                                <option value="2">INTERMEDIO</option>
                                                                <option value="3">BÁSICO</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <select type="text" id="notificacion_preferencia" name="notificacion_preferencia" class="form-control" placeholder="Preferencia">
                                                                <option value="">Preferencia</option>
                                                                <option value="SMS">SMS</option>
                                                                <option value="LLAMADA">LLAMADA</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-3">
                                                            <input type="text" id="parentezco" name="parentezco" class="form-control" placeholder="Parentesco">
                                                            <span id="errorParentesco"></span>
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
                            @if($user->rol == "ADMIN" || $user->rol == "SOPORTE")
                                <div class="d-inline-flex">
                                    <h4>Vehiculo</h4>
                                </div>
                            @endif
                            <div class="d-inline-flex">
                                <h4>Nombre</h4>
                            </div>
                            <div class="user-location">
                                <h4 style="margin-left: 12;">Prioridad</h4>
                            </div>
                            <div class="user-email">
                                <h4>Parentezco</h4>
                            </div>
                            <div class="user-phone">
                                <h4 style="margin-left: 3px;">Estado</h4>
                            </div>
                            <div class="action-btn">
                                <h4 style="margin-left: 3px;">Acción</h4>
                            </div>
                        </div>
                    </div>
                    @foreach($contacts as $contact)
                    <div class="items">
                        <div class="item-content">
                            @if($user->rol == "ADMIN" || $user->rol == "SOPORTE")
                            <div class="user-profile">
                                <div class="user-meta-info">
                                    <p class="user-name">{{ $contact->vehiculo->nro_placa}}</p>
                                    <p class="user-work">{{ $contact->vehiculo->dispositivo_id}}</p>
                                </div>
                            </div>
                            @endif
                            <div class="user-email">
                                    <p class="user-name">{{ $contact->nombre}}</p>
                                    <p class="user-work">{{ $contact->email}}</p>
                            </div>
                            <div class="user-location">
                                <p class="info-title">Propietario: </p>
                                <p class="usr-location" data-location="Boston, USA">
                                    @if( $contact->prioridad == 1)
                                        IMPORTANTE
                                    @elseif( $contact->prioridad == 2)
                                        INTERMEDIO
                                    @else
                                        BÁSICO
                                    @endif
                                </p>
                            </div>
                            <div class="user-location">
                                <p class="info-title">Parentezco: </p>
                                <p class="usr-location" data-location="Boston, USA">{{ $contact->parentezco }}</p>
                            </div>
                            <div class="user-phone">
                                <p class="info-title">Estado: </p>
                                    @if($contact->estado == 1)
                                        <span class="badge bg-success">Activo</span>
                                    @elseif($contact->estado == 2)
                                        <span class="badge bg-info">Inactivo</span>
                                    @else
                                        <span class="badge bg-danger">Eliminado</span>
                                    @endif
                            </div>
                            <div class="action-btn">
                                <svg 
                                    data-contacts='@json($contact)'
                                    xmlns="http://www.w3.org/2000/svg" 
                                    width="24" height="24" viewBox="0 0 24 24" 
                                    fill="none" stroke="purple" stroke-width="2" 
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-edit-2 btn-edit"
                                    style="cursor:pointer">
                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    @if($contact->estado == 1)
                                        <svg data-id="{{ $contact->id }}" data-action="desactivar"
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
                                        <svg data-id="{{ $contact->id }}" data-action="activar"
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
            document.addEventListener("click", function (e) {
                // --- BOTÓN EDITAR ---
                if (e.target.closest(".btn-edit")) {
                    const button = e.target.closest(".btn-edit");
                    const contact = JSON.parse(button.dataset.contacts);
                    const form = document.getElementById('vehiculoForm');
                    const modal = new bootstrap.Modal(document.getElementById('addContactModal'));
                    const btnSave = document.getElementById('btn-save');

                    form.reset();
                    document.getElementById('contact_id').value = contact.id;
                    document.getElementById('vehiculo_id').value = contact.vehiculo_id;
                    document.getElementById('nombre').value = contact.nombre;
                    document.getElementById('email').value = contact.email;
                    document.getElementById('celular').value = contact.celular;
                    document.getElementById('prioridad').value = contact.prioridad;
                    document.getElementById('notificacion_preferencia').value = contact.notificacion_preferencia;
                    document.getElementById('parentezco').value = contact.parentezco;

                    btnSave.textContent = "Guardar cambios";
                    document.querySelector('.add-title').style.display = "none";
                    document.querySelector('.edit-title').style.display = "block";

                    form.action = `/contact/${contact.id}`;
                    form.method = "POST";

                    // Asegurar que no haya duplicados del campo _method
                    form.querySelectorAll('input[name="_method"]').forEach(el => el.remove());
                    let methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    form.appendChild(methodInput);

                    modal.show();
                }

                // --- BOTÓN ACTIVAR / DESACTIVAR ---
                if (e.target.closest(".btn-toggle")) {
                    const button = e.target.closest(".btn-toggle");
                    const id = button.dataset.id;
                    const action = button.dataset.action;

                    fetch(`/contact/${id}/toggle`, {
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
                }
            });
        </script>

        <script>
            document.getElementById('nombre').addEventListener('keypress', function (e){
                const pattern = /^[a-zA-Z\s]*$/;
                const errorNombre = document.getElementById('errorNombre');
                const errorEmail = document.getElementById('errorEmail');

                if(!pattern.test(e.key)){
                    e.preventDefault();
                    errorNombre.textContent='Solo se permiten letras';
                    errorNombre.style.color='red';
                }else{
                    errorNombre.textContent='';
                }
            });
            document.getElementById('celular').addEventListener('keypress', function (e){
                const pattern = /^[0-9]*$/;
                const errorCelular = document.getElementById('errorCelular');
                if(!pattern.test(e.key)){
                    e.preventDefault();
                    errorCelular.textContent='Solo se permite números';
                    errorCelular.style.color='red';
                }else{
                    errorCelular.textContent='';
                }
            });
            document.getElementById('parentezco').addEventListener('keypress', function (e){
                const pattern = /^[a-zA-Z\s]*$/;
                const errorParentesco = document.getElementById('errorParentesco');
                if(!pattern.test(e.key)){
                    e.preventDefault();
                    errorParentesco.textContent='Solo letras';
                    errorParentesco.style.color='red';
                }else{
                    errorParentesco.textContent='';
                }
            });
        </script>


    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>