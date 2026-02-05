<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Ubicacion'}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/table/datatable/datatables.css')}}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        @vite(['resources/scss/light/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/light/plugins/table/datatable/custom_dt_miscellaneous.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/dt-global_style.scss'])
        @vite(['resources/scss/dark/plugins/table/datatable/custom_dt_miscellaneous.scss'])
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- Modal -->
    <div class="modal fade" id="mapModal" tabindex="-1" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="mapModalLabel">Ubicación del Vehículo</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <div id="map" style="height: 400px; width: 100%;"></div>
        </div>
        </div>
    </div>
    </div>

    <div class="page-meta">
        <nav class="breadcrumb-style-one" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Historial</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ubicación</li>
            </ol>
        </nav>
    </div>
    <!-- /BREADCRUMB -->
    <div class="row">
    
        <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-content widget-content-area">
                    <table id="html5-extension" class="table dt-table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Vehiculo</th>
                                <th>Longitud</th>
                                <th>Latitud</th>
                                <th>Bocina</th>
                                <th>Luces</th>
                                <th>Motor</th>
                                <th>Fecha</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            @foreach ($historial as $h)
                            <tr>
                                <td>{{ $h->vehiculo->nro_placa}}</td>
                                <td>{{ $h->longitud }}</td>
                                <td>{{ $h->latitud }}</td>
                                <td>
                                    <span class="d-inline-block rounded-circle {{ $h->motor_encendido ? 'bg-success' : 'bg-danger' }}" 
                                        style="width: 15px; height: 15px;">
                                    </span>
                                </td>
                                <td>
                                    <span class="d-inline-block rounded-circle {{ $h->luces_prendida ? 'bg-success' : 'bg-danger' }}" 
                                        style="width: 15px; height: 15px;">
                                    </span>
                                </td>
                                <td>
                                    <span class="d-inline-block rounded-circle {{ $h->bocina_encendida ? 'bg-success' : 'bg-danger' }}" 
                                        style="width: 15px; height: 15px;">
                                    </span>
                                </td>
                                <td>{{ $h->grabado }}</td>
                                <td class="text-center">
                                    <button class="btn btn-primary ver-ubicacion" 
                                        data-lat="{{ $h->latitud }}" 
                                        data-lng="{{ $h->longitud }}"
                                        data-placa="{{ $h->vehiculo->nro_placa }}">
                                        Ver
                                    </button>
                                </td>
                            </tr>  
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/global/vendors.min.js')}}"></script>
        @vite(['resources/assets/js/custom.js'])
        <script src="{{asset('plugins/table/datatable/datatables.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/button-ext/jszip.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
        <script src="{{asset('plugins/table/datatable/custom_miscellaneous.js')}}"></script>
        <!-- Librerías necesarias para exportar PDF -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script>
            let map; // Variable global para el mapa
            let marker; // Marcador

            $(document).ready(function() {

                $('.ver-ubicacion').on('click', function() {
                    let lat = $(this).data('lat');
                    let lng = $(this).data('lng');
                    let placa = $(this).data('placa');

                    // Abrir el modal
                    $('#mapModal').modal('show');

                    // Inicializar mapa solo la primera vez
                    setTimeout(function() { // Espera que el modal esté visible
                        if (!map) {
                            map = L.map('map').setView([lat, lng], 15);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                attribution: '&copy; OpenStreetMap contributors'
                            }).addTo(map);
                        } else {
                            map.setView([lat, lng], 15);
                            if (marker) {
                                marker.setLatLng([lat, lng]);
                            }
                        }

                        // Colocar marcador
                        if (!marker) {
                            marker = L.marker([lat, lng]).addTo(map)
                                .bindPopup(`Vehículo: ${placa}`).openPopup();
                        } else {
                            marker.bindPopup(`Vehículo: ${placa}`).openPopup();
                        }
                    }, 300);
                });

            });

        </script>

 </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>