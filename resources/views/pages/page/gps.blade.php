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
    <div class="row">
        <!-- MAPA -->
        <div class="col-md-8">
            <div id="map" style="height: 600px; border-radius: 10px;"></div>
        </div>

        <!-- PANEL DERECHO -->
        <div class="col-md-4">

            <div class="card mb-3">
                <div class="card-header bg-warning text-dark fw-bold">🟨 Zona Amarilla (Con Precaución)</div>
                <ul class="list-group list-group-flush" id="zona-amarilla"></ul>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-danger text-white fw-bold">🟥 Zona Roja (Peligrosa)</div>
                <ul class="list-group list-group-flush" id="zona-roja"></ul>
            </div>

            <!-- Vehículos en modo pánico -->
            <div class="card">
                <div class="card-header bg-dark text-white fw-bold">🚨 Vehículos en Modo Pánico</div>
                <ul class="list-group list-group-flush" id="modo-panico"></ul>
            </div>
        </div>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script src="{{asset('plugins/apex/apexcharts.min.js')}}"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Cochabamba -17.3895 -66.1568
            var map = L.map('map').setView([-17.3895, -66.1568], 13);

            // Capa base
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var vehiculos = @json($vehiculo);

            var zonas = {
                amarilla: {
                    center: [-17.395, -66.165],
                    radius: 800,
                    color: 'yellow'
                },
                roja: {
                    center: [-17.385, -66.17],
                    radius: 700,
                    color: 'red'
                }
            };

            // Dibujar las zonas en el mapa
            Object.values(zonas).forEach(z => {
                L.circle(z.center, {
                    radius: z.radius,
                    color: z.color,
                    fillColor: z.color,
                    fillOpacity: 0.2
                }).addTo(map);
            });

            // Función para calcular si un punto está dentro de una zona (distancia en metros)
            function dentroDeZona(lat1, lon1, zona) {
                const R = 6371000;
                const [lat2, lon2] = zona.center;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLon = (lon2 - lon1) * Math.PI / 180;
                const a = Math.sin(dLat / 2) ** 2 +
                        Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                        Math.sin(dLon / 2) ** 2;
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                const distancia = R * c;
                return distancia <= zona.radius;
            }

            // --- Clasificar vehículos según zona ---
            vehiculos.forEach(v => {
                if (!v.estado_actual) return;

                const lat = parseFloat(v.estado_actual.latitud_actual);
                const lon = parseFloat(v.estado_actual.longitud_actual);
                const modoPanico = v.estado_actual.modo_panico;
                let zonaAsignada = 'desconocida';

                // Determinar en qué zona está el vehículo
                if (dentroDeZona(lat, lon, zonas.roja)) {
                    zonaAsignada = 'roja';
                } else if (dentroDeZona(lat, lon, zonas.amarilla)) {
                    zonaAsignada = 'amarilla';
                }

                // Mostrar en el mapa con color de la zona
                let color = 'gray';
                if (zonaAsignada === 'amarilla') color = 'yellow';
                if (zonaAsignada === 'roja') color = 'red';

                const marker = L.circleMarker([lat, lon], {
                    radius: 10,
                    color: color,
                    fillColor: color,
                    fillOpacity: 0.8
                }).addTo(map);

                marker.bindPopup(`
                    <b>Vehículo:</b> ${v.nro_placa}<br>
                    <b>Zona:</b> ${zonaAsignada.toUpperCase()}<br>
                    <b>Modo Pánico:</b> ${modoPanico == 1 ? 'ACTIVO' : 'Inactivo'}
                `);

                // Mostrar en la lista correspondiente
                if (zonaAsignada === 'amarilla') {
                    document.querySelector('#zona-amarilla').innerHTML += `<li class="list-group-item">${v.nro_placa}</li>`;
                } else if (zonaAsignada === 'roja') {
                    document.querySelector('#zona-roja').innerHTML += `<li class="list-group-item">${v.nro_placa}</li>`;
                }

                // Si está en modo pánico, mostrar también en su lista
                if (modoPanico == 1) {
                    document.querySelector('#modo-panico').innerHTML += `
                        <li class="list-group-item bg-dark-subtle">
                            <strong>${v.nro_placa}</strong>
                            <button class="btn btn-sm btn-danger float-end" onclick="enviarNotificacion('${v.id}')">
                                Notificar
                            </button>
                        </li>`;
                }
            });
        });

        // Simulación de notificación
        function enviarNotificacion(idVehiculo) {
            alert('🔔 Notificación enviada para el vehículo ID: ' + idVehiculo);
        }
        </script>
        
        {{-- Analytics --}}
        @vite(['resources/assets/js/widgets/_wSix.js'])
        @vite(['resources/assets/js/widgets/_wChartThree.js'])
        @vite(['resources/assets/js/widgets/_wHybridOne.js'])
        @vite(['resources/assets/js/widgets/_wActivityFive.js'])
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>