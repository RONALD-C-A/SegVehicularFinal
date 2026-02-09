<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Panel'}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])

        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])

        <style>
            #map {
                height: 400px;  /* Ajusta la altura */
                width: 100%;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <!-- Analytics -->

    <div class="row layout-top-spacing">

        <div class="col-12">
            <div class="row widget-statistic">
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 layout-spacing">
                    <div class="widget widget-one_hybrid widget-followers">
                        <div class="widget-heading">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="feather feather-alert-triangle"></i>
                                </div>
                                <div>
                                    <p class="w-value" id="modo_panico">-</p>
                                    <h5>Modo pánico</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 layout-spacing">
                    <div class="widget widget-one_hybrid widget-referral">
                        <div class="widget-heading">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="feather feather-speedometer"></i>
                                </div>
                                <div>
                                    <p class="w-value" id="dist_manilla">-</p>
                                    <h5>Distancia manilla</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 layout-spacing">
                    <div class="widget widget-one_hybrid widget-engagement">
                        <div class="widget-heading">
                            <div class="w-title d-flex align-items-center justify-content-between w-100">
                                <div class="d-flex align-items-center" style="min-width: 0;"> <div class="w-icon">
                                        <i class="feather feather-thermometer"></i>
                                    </div>
                                    <div class="ms-2 text-truncate"> <p class="w-value mb-0" id="manilla">-</p>
                                        <h5 class="mb-0">Manilla</h5>
                                    </div>
                                </div>
                                <div id="manilla-buttons" class="ms-2 flex-shrink-0">
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-12 layout-spacing">
                    <div class="widget widget-one_hybrid widget-engagement">
                        <div class="widget-heading">
                            <div class="w-title">
                                <div class="w-icon">
                                    <i class="feather feather-clock"></i>
                                </div>
                                <div>
                                    <p class="w-value">Últ. conexión</p>
                                    <h5 id="ultima_conexion">-</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <h4>Ubicación actual</h4>
                    @if($vehiculos->count() > 1)
                        <div style="position: absolute; top: 10px; right: 10px; z-index: 1000;">
                            <select id="vehiculoSelect" class="form-select form-select-sm">
                                @foreach($vehiculos as $v)
                                    <option value="{{ $v->id }}">
                                        {{ $v->nro_placa ?? 'Vehículo '.$v->id }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif
                    <div id="map"></div>
                </div>
            </div>
        </div>
    
        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 layout-spacing">
            <x-widgets._w-activity-five title="Historial" :datos="$accion"/>
        </div>

    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {

                const vehiculos = @json($vehiculos);

                // Inicializar mapa
                const map = L.map('map').setView([-17.38, -66.16], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 18,
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);

                let marcador;
                const marcadorIcon = L.icon({
                    iconUrl: 'https://cdn-icons-png.flaticon.com/512/252/252025.png',
                    iconSize: [40, 40],
                    iconAnchor: [20, 20]
                });

                function moverMarcador(marcador, nuevaLat, nuevaLng, duracion = 1000) {
                    const inicio = marcador.getLatLng();
                    const deltaLat = nuevaLat - inicio.lat;
                    const deltaLng = nuevaLng - inicio.lng;
                    const pasos = 30;
                    let pasoActual = 0;
                    const animacion = setInterval(() => {
                        pasoActual++;
                        const t = pasoActual / pasos;
                        marcador.setLatLng([inicio.lat + deltaLat * t, inicio.lng + deltaLng * t]);
                        if (pasoActual >= pasos) clearInterval(animacion);
                    }, duracion / pasos);
                }

                async function actualizarDatos(v) {
                    if (!v || !v.estado_actual) return;
                    const e = v.estado_actual;

                    document.getElementById('modo_panico').textContent = e.modo_panico == 1 ? 'ACTIVADO' : 'Normal';
                    document.getElementById('dist_manilla').textContent = (e.presicioon ?? 0) + ' m';
                    document.getElementById('manilla').textContent = (e.dispositivo_conectado ? 'Conectado' : 'Desconectado');
                    document.getElementById('ultima_conexion').textContent = e.ultima_comunicacion 
                        ? new Date(e.ultima_comunicacion).toLocaleString() 
                        : '-';

                    const lat = parseFloat(e.latitud_actual);
                    const lng = parseFloat(e.longitud_actual);
                    if (!isNaN(lat) && !isNaN(lng)) {
                        if (!marcador) {
                            marcador = L.marker([lat, lng], { icon: marcadorIcon }).addTo(map)
                                .bindPopup(`<b>${v.nro_placa ?? 'Vehículo ' + v.id}</b><br>
                                            Velocidad: ${e.velocidad_actual ?? 0} km/h<br>
                                            Manilla: ${e.dispositivo_conectado ? 'Conectada' : 'Desconectado'}`)
                                .openPopup();
                        } else {
                            moverMarcador(marcador, lat, lng);
                        }
                        map.setView([lat, lng], 16);
                    }

                    // Actualizar botón de manilla
                    await actualizarBotonManillaVehiculo(v.id);
                }

                function enviarAccion(dispositivo, valor, vehiculo_id) {
                    fetch(`/api/vehiculo/${vehiculo_id}/enviar-accion`, {
                        method: 'POST',
                        headers: { 
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                        },
                        body: JSON.stringify({ tipo: dispositivo, estado: valor })
                    })
                    .then(res => res.json())
                    .then(data => {
                        console.log('Acción enviada:', data);
                        actualizarBotonManillaVehiculo(vehiculo_id);
                    })
                    .catch(err => console.error(err));
                }

                async function actualizarBotonManillaVehiculo(vehiculo_id) {
                    const contenedor = document.getElementById('manilla-buttons');
                    if (!contenedor) {
                        console.error("No se encontró el contenedor #manilla-buttons");
                        return;
                    }

                    try {
                        const res = await fetch(`/api/vehiculo/${vehiculo_id}/ultimo-estado-manilla`);
                        const data = await res.json();
                        const estado = data?.estado ?? 0;

                        contenedor.innerHTML = '';
                        const boton = document.createElement('button');
                        
                        // Asignar clases y texto según estado
                        if (estado == 1) {
                            boton.className = 'btn btn-danger btn-sm';
                            boton.textContent = 'Desactivar';
                            boton.onclick = () => enviarAccion('bloqueo', 0, vehiculo_id);
                        } else {
                            boton.className = 'btn btn-success btn-sm';
                            boton.textContent = 'Activar';
                            boton.onclick = () => enviarAccion('bloqueo', 1, vehiculo_id);
                        }

                        contenedor.appendChild(boton);
                    } catch (err) {
                        console.error('Error en fetch:', err);
                        contenedor.innerHTML = '<span class="badge badge-warning">Sin red</span>';
                    }
                }
                if (vehiculos.length > 0) actualizarDatos(vehiculos[0]);
                const select = document.getElementById('vehiculoSelect');
                if (select) {
                    select.addEventListener('change', e => {
                        const v = vehiculos.find(x => x.id == e.target.value);
                        actualizarDatos(v);
                    });
                }

                setInterval(async () => {
                    try {
                        const res = await fetch("{{ route('vehiculos.estados.actualizados') }}");
                        const data = await res.json();
                        if (Array.isArray(data) && data.length > 0) {
                            const select = document.getElementById('vehiculoSelect');
                            const seleccionado = select ? select.value : data[0].id;
                            const vehiculo = data.find(v => v.id == seleccionado);
                            actualizarDatos(vehiculo);
                        }
                    } catch (err) {
                        console.error('Error actualizando ubicación:', err);
                    }
                }, 10000);

            });
        </script>

        {{-- Analytics --}}
        @vite(['resources/assets/js/widgets/_wSix.js'])
        @vite(['resources/assets/js/widgets/_wChartThree.js'])
        @vite(['resources/assets/js/widgets/_wHybridOne.js'])
        @vite(['resources/assets/js/widgets/_wActivityFive.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>