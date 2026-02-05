<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Panel'}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <link rel="stylesheet" href="{{asset('plugins/apex/apexcharts.css')}}">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

        @vite(['resources/scss/light/assets/components/list-group.scss'])
        @vite(['resources/scss/light/assets/widgets/modules-widgets.scss'])
        @vite(['resources/scss/dark/assets/components/list-group.scss'])
        @vite(['resources/scss/dark/assets/widgets/modules-widgets.scss'])

        <style>
            #map {
                height: 400px;
                width: 100%;
            }
            .card svg {
                width: 40px;
                height: 40px;
                margin-bottom: 8px;
            }
        </style>
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->

    <div class="row layout-top-spacing">

        {{-- Mapa --}}
        <div class="col-12 layout-spacing">
            <div class="widget widget-card-four">
                <div class="widget-content">
                    <h4>Ubicación GPS</h4>
                    <div id="map"></div>
                </div>
            </div>
        </div>

        {{-- Boxes en fila --}}
        <div class="d-flex justify-content-center gap-4 flex-wrap mt-4">

            {{-- Box Motor --}}
            <div class="card text-center shadow-sm" style="width: 180px;">
                <div class="card-header bg-dark text-white d-flex flex-column align-items-center">
                    {{-- SVG Motor --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2.5" y="7" width="15" height="9" rx="1.2"></rect>
                        <path d="M17.5 10h3.5v5h-3.5"></path>
                        <circle cx="7.5" cy="11.5" r="1.6"></circle>
                        <path d="M4 16v1.8a.7.7 0 0 0 .7.7H8"></path>
                        <path d="M10 8V6.3a1 1 0 0 1 1-1h2.5a1 1 0 0 1 1 1V8"></path>
                    </svg>
                    <h5 class="mb-0">Motor</h5>
                </div>
                <div class="card-body">
                    <button id="btnMotorEncender" onclick="enviarAccion('motor', true)" class="btn btn-success btn-sm mb-2 w-100">Encender</button>
                    <button id="btnMotorApagar" onclick="enviarAccion('motor', false)" class="btn btn-danger btn-sm w-100">Apagar</button>
                </div>
            </div>

            {{-- Box Luces --}}
            <div class="card text-center shadow-sm" style="width: 180px;">
                <div class="card-header bg-dark text-white d-flex flex-column align-items-center">
                    {{-- SVG Luz --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 18h6"></path>
                        <path d="M12 2a5 5 0 0 0-5 5c0 2.6 2 4 2.5 5 .6 1.2-.5 3 2.5 5.5 3-2.5 1.9-4.2 2.5-5.5.5-1 .5-2.4.5-5A5 5 0 0 0 12 2z"></path>
                        <path d="M12 6v2"></path>
                        <path d="M5 8.5L3 6.5"></path>
                        <path d="M21 8.5L19 6.5"></path>
                    </svg>
                    <h5 class="mb-0">Luces</h5>
                </div>
                <div class="card-body">
                    <button id="btnLucesEncender" onclick="enviarAccion('luces', true)" class="btn btn-warning btn-sm mb-2 w-100">Encender</button>
                    <button id="btnLucesApagar" onclick="enviarAccion('luces', false)" class="btn btn-secondary btn-sm w-100">Apagar</button>
                </div>
            </div>

            {{-- Box Bocina --}}
            <div class="card text-center shadow-sm" style="width: 180px;">
                <div class="card-header bg-dark text-white d-flex flex-column align-items-center">
                    {{-- SVG Bocina --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 11v2a1 1 0 0 0 1 1h3l6 4V6L7 10H4a1 1 0 0 0-1 1z"></path>
                        <path d="M21 8c0 1.3-.8 2.4-1.9 3.1"></path>
                        <path d="M21 16c0-1.3-.8-2.4-1.9-3.1"></path>
                    </svg>
                    <h5 class="mb-0">Bocina</h5>
                </div>
                <div class="card-body">
                    <button id="btnBocinaActivar" onclick="enviarAccion('bocina', true)" class="btn btn-info btn-sm mb-2 w-100">Activar</button>
                    <button id="btnBocinaDesactivar" onclick="enviarAccion('bocina', false)" class="btn btn-secondary btn-sm w-100">Desactivar</button>
                </div>
            </div>

            {{-- Box Historial --}}
            <div class="card text-center shadow-sm" style="width: 180px;">
                <div class="card-header bg-dark text-white d-flex flex-column align-items-center">
                    {{-- SVG Llamada de emergencia --}}
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="6" y="2.8" width="12" height="18.4" rx="2"></rect>
                        <circle cx="12" cy="17" r="0.9"></circle>
                        <path d="M8.5 6.5l-.9-1.6"></path>
                        <path d="M15.5 6.5l.9-1.6"></path>
                        <path d="M12 9v3"></path>
                    </svg>
                    <h5 class="mb-0">Historial</h5>
                </div>
                <div class="card-body">
                    <a href="{{ route('ubicacion.index') }}" class="btn btn-dark btn-sm w-100">Ver Historial</a>
                </div>
            </div>

        </div>

    </div>

    <!-- BEGIN CUSTOM SCRIPTS -->
    <x-slot:footerFiles>
<script src="{{ asset('plugins/apex/apexcharts.min.js') }}"></script>

<script>
    const vehiculoId = @json($vehiculo->id ?? null);
    const estadoActual = @json($estadoActual ?? null);

    document.addEventListener('DOMContentLoaded', () => {
        const mapContainer = document.getElementById('map');
        // 🔧 Asegurar tamaño visible antes de crear el mapa
        mapContainer.style.minHeight = '500px';
        mapContainer.style.width = '100%';

        let map;
        let marcador;

        function inicializarMapa(estadoActual) {
            // Coordenadas por defecto (Cochabamba)
            const latDefault = -17.3895;
            const lngDefault = -66.1568;

            // Si hay estadoActual y tiene lat/lng, los usamos. Caso contrario, usamos Cochabamba.
            const lat = estadoActual && estadoActual.latitud_actual ? estadoActual.latitud_actual : latDefault;
            const lng = estadoActual && estadoActual.longitud_actual ? estadoActual.longitud_actual : lngDefault;

            // Inicializar mapa
            const map = L.map('map').setView([lat, lng], 13);

            // Capa base
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);

            // Si hay coordenadas reales, mostrar marcador
            if (estadoActual && estadoActual.latitud_actual && estadoActual.longitud_actual) {
                L.marker([estadoActual.latitud_actual, estadoActual.longitud_actual]).addTo(map)
                    .bindPopup('Ubicación actual del vehículo').openPopup();
            } else {
                L.marker([latDefault, lngDefault]).addTo(map)
                    .bindPopup('Sin registros, mostrando Cochabamba').openPopup();
            }
        }
        function mostrarPopupYMensaje(lat, lng, texto, tipo = 'warning') {
            if (!map) return;
            L.popup()
                .setLatLng([lat, lng])
                .setContent(`<b>${texto}</b>`)
                .openOn(map);
            mostrarMensaje(texto, tipo);
        }

        function mostrarMensaje(msg, tipo) {
            const mensajesDiv = document.getElementById('mensajes') || document.body;
            const alerta = document.createElement('div');
            alerta.className = `alert alert-${tipo} alert-dismissible fade show mt-2`;
            alerta.role = 'alert';
            alerta.innerHTML = `
                ${msg}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            mensajesDiv.appendChild(alerta);
            setTimeout(() => alerta.remove(), 6000);
        }

        // --- CASOS POSIBLES ---
        if (vehiculoId && estadoActual) {
            // ✅ Caso 1: Hay vehículo con estado
            inicializarMapa(estadoActual);

            // Esperar a que el mapa esté listo para agregar marcador
            setTimeout(() => {
                if (map) {
                    marcador = L.marker([estadoActual.latitud_actual, estadoActual.longitud_actual])
                        .addTo(map)
                        .bindPopup('Ubicación actual del vehículo')
                        .openPopup();
                }
            }, 400);

            actualizarBotones();
        } 
        else if (vehiculoId && !estadoActual) {
            // ⚠️ Caso 2: Hay vehículo pero sin coordenadas
            inicializarMapa(-17.3895, -66.1568, 13);
            setTimeout(() => {
                mostrarPopupYMensaje(
                    -17.3895,
                    -66.1568,
                    'No se encontraron registros de ubicación asociados a su vehículo.'
                );
            }, 500);
            ocultarBotones();
        } 
        else {
            // 🚫 Caso 3: No hay vehículo
            inicializarMapa(-17.3895, -66.1568, 13);
            setTimeout(() => {
                mostrarPopupYMensaje(
                    -17.3895,
                    -66.1568,
                    'No se encontró un vehículo asociado a su usuario.'
                );
            }, 500);
            ocultarBotones();
        }

        // --- BOTONES ---
        function actualizarBotones() {
            document.getElementById('btnMotorEncender').style.display = estadoActual.motor == 0 ? 'block' : 'none';
            document.getElementById('btnMotorApagar').style.display = estadoActual.motor == 1 ? 'block' : 'none';
            document.getElementById('btnLucesEncender').style.display = estadoActual.luces == 0 ? 'block' : 'none';
            document.getElementById('btnLucesApagar').style.display = estadoActual.luces == 1 ? 'block' : 'none';
            document.getElementById('btnBocinaActivar').style.display = estadoActual.bocina == 0 ? 'block' : 'none';
            document.getElementById('btnBocinaDesactivar').style.display = estadoActual.bocina == 1 ? 'block' : 'none';
        }

        function ocultarBotones() {
            const botones = [
                'btnMotorEncender', 'btnMotorApagar',
                'btnLucesEncender', 'btnLucesApagar',
                'btnBocinaActivar', 'btnBocinaDesactivar'
            ];
            botones.forEach(id => {
                const btn = document.getElementById(id);
                if (btn) btn.style.display = 'none';
            });
        }

        // --- ENVIAR ACCIÓN ---
        window.enviarAccion = function (tipo, estado) {
            if (!vehiculoId || !estadoActual) {
                mostrarMensaje('No hay un vehículo o registro activo para enviar acciones.', 'danger');
                return;
            }

            fetch(`/api/vehiculo/${vehiculoId}/enviar-accion`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ tipo: tipo, estado: estado ? 1 : 0 })
            })
            .then(r => r.json())
            .then(data => {
                if (data.ok) {
                    estadoActual[tipo] = estado ? 1 : 0;
                    actualizarBotones();
                    mostrarMensaje(`✓ Acción ${tipo} enviada correctamente`, 'success');
                } else {
                    mostrarMensaje(`✗ Error: ${data.error || 'Desconocido'}`, 'danger');
                }
            })
            .catch(err => mostrarMensaje(`✗ Error: ${err.message}`, 'danger'));
        };
    });
</script>



    </x-slot>
    <!-- END CUSTOM SCRIPTS -->

</x-base-layout>
