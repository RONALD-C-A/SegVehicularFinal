<x-base-layout :scrollspy="false">
    <x-slot:pageTitle>{{$title}}</x-slot>

    <x-slot:headerFiles>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <style>
            .map-container { position: relative; height: 400px; width: 100%; border-radius: 8px; border: 1px solid #ebedef; }
            #map { height: 100%; width: 100%; border-radius: 8px; z-index: 1; }
            .table-responsive-scroll { max-height: 250px; overflow-y: auto; border: 1px solid #ebedef; }
            /* Colores de texto automáticos del tema */
            .text-theme { color: var(--text-color); }
            .table-active-row td { background-color: rgba(67, 97, 238, 0.2) !important; font-weight: bold; }
        </style>
    </x-slot>

    <div class="row layout-top-spacing">
        <div class="col-12 mb-4">
            <div class="widget-content widget-content-area p-3 br-6">
                <form action="{{ route('ubicacion.index') }}" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-6">
                        <label class="fw-bold">Rango de Historial</label>
                        <input type="text" id="rangeCalendar" class="form-control">
                        <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="{{ $inicio }}">
                        <input type="hidden" name="fecha_fin" id="fecha_fin" value="{{ $fin }}">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Consultar</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="col-12">
            <div class="widget-content widget-content-area br-6 p-0 shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Vehículo</th>
                                <th>Día de Ruta</th>
                                <th class="text-center">Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                // Agrupamos por fecha para no repetir el mismo día mil veces
                                $agrupados = $historial->groupBy(function($item) {
                                    return \Carbon\Carbon::parse($item->grabado)->format('Y-m-d');
                                });
                            @endphp
                            @forelse ($agrupados as $fecha => $puntos)
                            <tr>
                                <td><span class="badge badge-dark">{{ $puntos->first()->vehiculo->nro_placa }}</span></td>
                                <td class="fw-bold">{{ \Carbon\Carbon::parse($fecha)->format('d/m/Y') }}</td>
                                <td class="text-center">
                                    <button class="btn btn-info btn-sm" onclick="openMapModal('{{ $fecha }}', {{ $puntos->first()->id }})">
                                        Explorar Ruta
                                    </button>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="3" class="text-center p-4">No hay rutas en este periodo</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content widget-content-area">
                <div class="modal-header border-bottom d-flex justify-content-between">
                    <button class="btn btn-dark btn-sm" onclick="changeDay(-1)" id="btnPrevDay">Anterior</button>
                    <h5 class="m-0 fw-bold" id="displayFechaModal">-- / -- / ----</h5>
                    <button class="btn btn-dark btn-sm" onclick="changeDay(1)" id="btnNextDay">Siguiente</button>
                </div>
                <div class="modal-body">
                    <div class="map-container mb-3">
                        <div id="map"></div>
                    </div>
                    
                    <div class="alert alert-arrow-right alert-light-primary mb-2 shadow-sm" role="alert">
                        <div class="row text-center fw-bold">
                            <div class="col-4">Hora: <span id="detHora" class="text-dark">--:--</span></div>
                            <div class="col-4">Velocidad: <span id="detVel" class="text-dark">0 km/h</span></div>
                            <div class="col-4">Motor: <span id="detMotor" class="text-dark">--</span></div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mb-2">
                        <div class="btn-group">
                            <button class="btn btn-sm btn-outline-dark" onclick="changePoint(-1)">« Anterior</button>
                            <button class="btn btn-sm btn-outline-dark" onclick="changePoint(1)">Siguiente »</button>
                        </div>
                    </div>

                    <div class="table-responsive-scroll br-6">
                        <table class="table table-sm table-hover mb-0">
                            <thead class="bg-light sticky-top">
                                <tr>
                                    <th>Hora</th>
                                    <th>Velocidad</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody id="tbodyDetalles"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-slot:footerFiles>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        <script>
            let map, marker, routeLine;
            const historialFull = @json($historial);
            const r_inicio = "{{ $inicio }}", r_fin = "{{ $fin }}";
            let f_actual = '', puntosDelDia = [], p_idx = 0;

            flatpickr("#rangeCalendar", {
                mode: "range", locale: "es", dateFormat: "Y-m-d", defaultDate: [r_inicio, r_fin],
                onClose: (selectedDates) => {
                    if (selectedDates.length === 2) {
                        document.getElementById('fecha_inicio').value = selectedDates[0].toISOString().split('T')[0];
                        document.getElementById('fecha_fin').value = selectedDates[1].toISOString().split('T')[0];
                    }
                }
            });

            function openMapModal(fecha, id) {
                f_actual = fecha;
                new bootstrap.Modal(document.getElementById('mapModal')).show();
                document.getElementById('mapModal').addEventListener('shown.bs.modal', function () {
                    if (!map) {
                        map = L.map('map');
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                    }
                    renderDay();
                }, { once: true });
            }

            async function renderDay() {
                puntosDelDia = historialFull.filter(h => h.grabado.startsWith(f_actual));
                document.getElementById('displayFechaModal').innerText = f_actual;
                
                // Validaciones de navegación de días
                document.getElementById('btnPrevDay').disabled = (f_actual <= r_inicio);
                document.getElementById('btnNextDay').disabled = (f_actual >= r_fin);

                if (puntosDelDia.length === 0) {
                    if(routeLine) map.removeLayer(routeLine);
                    if(marker) map.removeLayer(marker);
                    document.getElementById('tbodyDetalles').innerHTML = '<tr><td colspan="3" class="text-center">Sin registros</td></tr>';
                    return;
                }

                p_idx = 0; 
                if (routeLine) map.removeLayer(routeLine);

                // --- LÓGICA DE RUTEO REAL (NO ATRAVESAR CASAS) ---
                // OSRM limita a ciertos puntos por petición, tomamos los puntos del día
                const coordsString = puntosDelDia.map(h => `${h.longitud},${h.latitud}`).join(';');
                
                try {
                    // Consultamos al servidor de ruteo OpenSource
                    const response = await fetch(`https://router.project-osrm.org/route/v1/driving/${coordsString}?overview=full&geometries=geojson`);
                    const data = await response.json();

                    if (data.code === 'Ok') {
                        // Si OSRM encuentra el camino por calles
                        routeLine = L.geoJSON(data.routes[0].geometry, {
                            style: { color: '#4361ee', weight: 5, opacity: 0.7 }
                        }).addTo(map);
                    } else {
                        // Fallback: Si falla el ruteo, trazamos línea recta pero avisamos
                        throw new Error('Ruta por calles no disponible');
                    }
                } catch (e) {
                    console.warn("Usando trazado lineal: ", e.message);
                    const coordsSimples = puntosDelDia.map(h => [h.latitud, h.longitud]);
                    routeLine = L.polyline(coordsSimples, {color: '#e7515a', weight: 4, dashArray: '5, 10'}).addTo(map);
                }

                map.fitBounds(routeLine.getBounds(), { padding: [20, 20] });
                fillTable();
                updatePointUI();
            }

            function fillTable() {
                document.getElementById('tbodyDetalles').innerHTML = puntosDelDia.map((p, i) => `
                    <tr id="row-${i}" onclick="p_idx=${i}; updatePointUI();" style="cursor:pointer">
                        <td>${p.grabado.split(' ')[1]}</td>
                        <td>${p.velocidad} km/h</td>
                        <td><span class="badge ${p.motor_encendido ? 'badge-light-success' : 'badge-light-danger'}">${p.motor_encendido ? 'ON' : 'OFF'}</span></td>
                    </tr>
                `).join('');
            }

            function updatePointUI() {
                const p = puntosDelDia[p_idx];
                if (!p) return;

                if (marker) map.removeLayer(marker);
                marker = L.marker([p.latitud, p.longitud]).addTo(map);
                map.panTo([p.latitud, p.longitud]);

                // Actualización de los datos destacados
                document.getElementById('detHora').innerText = p.grabado.split(' ')[1];
                document.getElementById('detVel').innerText = p.velocidad + " km/h";
                document.getElementById('detMotor').innerText = p.motor_encendido ? 'ENCENDIDO' : 'APAGADO';
                
                document.querySelectorAll('#tbodyDetalles tr').forEach(r => r.classList.remove('table-active-row'));
                const row = document.getElementById(`row-${p_idx}`);
                if (row) {
                    row.classList.add('table-active-row');
                    row.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            }

            function changePoint(d) {
                if (p_idx + d >= 0 && p_idx + d < puntosDelDia.length) {
                    p_idx += d; updatePointUI();
                }
            }

            function changeDay(d) {
                let date = new Date(f_actual + "T00:00:00");
                date.setDate(date.getDate() + d);
                let nueva = date.toISOString().split('T')[0];
                if (nueva >= r_inicio && nueva <= r_fin) { f_actual = nueva; renderDay(); }
            }
        </script>
    </x-slot>
</x-base-layout>