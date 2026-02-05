<x-base-layout :scrollspy="false">

    <x-slot:pageTitle>
        {{$title ?? 'Historial'}} 
    </x-slot>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <x-slot:headerFiles>
        <!--  BEGIN CUSTOM STYLE FILE  -->
        <link rel="stylesheet" href="{{asset('plugins/flatpickr/flatpickr.css')}}">
        <link rel="stylesheet" href="{{asset('plugins/noUiSlider/nouislider.min.css')}}">
        @vite(['resources/scss/light/plugins/flatpickr/custom-flatpickr.scss'])
        @vite(['resources/scss/dark/plugins/flatpickr/custom-flatpickr.scss'])
        <style>
            /* === Estilos adicionales === */
            #btnPdf {
                position: fixed;
                bottom: 80px;
                right: 20px;
                width: 55px;
                height: 55px;
                border-radius: 50%;
                background-color: #dc3545;
                display: flex;
                align-items: center;
                justify-content: center;
                color: white;
                cursor: pointer;
                box-shadow: 0 4px 6px rgba(0,0,0,0.2);
                transition: transform 0.2s;
            }
            #btnPdf:hover { transform: scale(1.1); }

            #btnTop {
                position: fixed;
                bottom: 20px;
                right: 20px;
                width: 55px;
                height: 55px;
                border-radius: 50%;
                background-color: #198754;
                display: none;
                align-items: center;
                justify-content: center;
                color: white;
                cursor: pointer;
                box-shadow: 0 4px 6px rgba(0,0,0,0.2);
                transition: transform 0.2s;
            }
            #btnTop:hover { transform: scale(1.1); }

            #mensajeSinDatos {
                text-align: center;
                color: #dc3545;
                font-weight: bold;
                margin-top: 20px;
                display: none;
            }
        </style>
        <!--  END CUSTOM STYLE FILE  -->
    </x-slot>
    <!-- END GLOBAL MANDATORY STYLES -->
    
    <div class="row layout-top-spacing">

        <div id="basic" class="col-lg-12 col-12 layout-spacing">
            <div class="statbox widget box box-shadow">
                <div class="widget-header row">                                 
                    <div class="row">
                        <div class="col-xl-12 col-md-12 col-sm-12 col-12">
                            <h4>Reporte de historial</h4> 
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area row">
                    <div class="col-3">
                        <div class="form-group mb-4">
                            <label for="exampleFormControlSelect1">Vehiculo</label>
                            <select class="form-select" id="vehiculo_id">
                                <option value="">Todos</option>
                                @foreach ($vehiculo as $car)
                                    <option value="{{ $car->id }}">{{ $car->nro_placa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="form-group mb-4">
                            <label for="exampleFormControlSelect1">Propietario</label>
                            <select class="form-select" id="dueno_id">
                                <option value="">Todos</option>
                                @foreach ($dueno as $d)
                                    <option value='{{ $d->id }}'> {{ $d->nombre }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <p>Fecha inicio</p>
                        <div class="form-group mb-0">
                            <input id="fecha_inicio" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Fecha Inicio..">
                        </div>
                    </div>
                    <div class="col-3">
                        <p>Fecha fin</p>
                        <div class="form-group mb-0">
                            <input id="fecha_fin" class="form-control flatpickr flatpickr-input active" type="text" placeholder="Fecha Fin..">
                        </div>
                    </div>
                    <div class="col-4"></div>
                    <div class="col-4"></div>
                    <div class="col-12 d-flex justify-content-end gap-2 mt-3">
                        <a href="#" id="btnLimpiar" class="btn btn-gray">Limpiar</a>
                        <a href="#" id="btnGenerar" class="btn btn-success">Generar</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 mt-4" id="contenedorTabla">
            <div id="mensajeSinDatos">No se encontraron resultados.</div>
            <table class="table table-bordered" id="tablaResultados" style="display:none;">
                <thead>
                    <tr>
                        <th>Vehículo</th>
                        <th>Propietario</th>
                        <th>Motor</th>
                        <th>Luces</th>
                        <th>Bocinas</th>
                        <th>Fecha</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <div id="btnPdf" title="Exportar PDF">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" viewBox="0 0 16 16">
            <path d="M4.5 0A1.5 1.5 0 0 0 3 1.5V14a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4.5L9.5 0zM4 1.5A.5.5 0 0 1 4.5 1H9v4a1 1 0 0 0 1 1h4v8a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V1.5z"/>
            <path d="M8.5 1v3h3l-3-3z"/>
        </svg>
    </div>
    <div id="btnTop" title="Ir al inicio">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="white" viewBox="0 0 16 16">
            <path d="M8 3.293l6.354 6.353-.708.708L8 4.707l-5.646 5.647-.708-.708L8 3.293z"/>
        </svg>
    </div>
    
    <!--  BEGIN CUSTOM SCRIPTS FILE  -->
    <x-slot:footerFiles>
        <script type="module" src="{{asset('plugins/flatpickr/flatpickr.js')}}"></script>
        <script type="module" src="{{asset('plugins/flatpickr/custom-flatpickr.js')}}"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {

            // === ELEMENTOS ===
            const vehiculoSelect = document.getElementById("vehiculo_id");
            const duenoSelect = document.getElementById("dueno_id");
            const fechaInicioInput = document.getElementById("fecha_inicio");
            const fechaFinInput = document.getElementById("fecha_fin");
            const btnLimpiar = document.getElementById("btnLimpiar");
            const btnGenerar = document.getElementById("btnGenerar");
            const tabla = document.getElementById("tablaResultados");
            const tbody = tabla.querySelector("tbody");
            const mensajeSinDatos = document.getElementById("mensajeSinDatos");
            const btnTop = document.getElementById("btnTop");

            const hoy = new Date().toISOString().split('T')[0];

            const fechaInicioPicker = flatpickr('#fecha_inicio', {
                dateFormat: "Y-m-d"
            });

            const fechaFinPicker = flatpickr('#fecha_fin', {
                dateFormat: "Y-m-d",
                defaultDate: hoy
            });

            // === BOTÓN LIMPIAR ===
            btnLimpiar.addEventListener("click", (e) => {
                e.preventDefault();
                vehiculoSelect.value = "";
                duenoSelect.value = "";
                fechaFinPicker.setDate(hoy);
                fechaInicioPicker.clear();
                tbody.innerHTML = "";
                tabla.style.display = "none";
                mensajeSinDatos.style.display = "none";
            });

            btnGenerar.addEventListener("click", async (e) => {
                e.preventDefault();

                const filtros = {
                    vehiculo_id: vehiculoSelect.value,
                    dueno_id: duenoSelect.value,
                    fecha_inicio: fechaInicioInput.value || null,
                    fecha_fin: fechaFinInput.value || hoy
                };

                try {
                    const response = await fetch("{{ route('reporte.historial') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": "{{ csrf_token() }}" // 🔒 Importante para Laravel
                        },
                        body: JSON.stringify(filtros)
                    });

                    const data = await response.json();

                    console.log("Respuesta del servidor:", data);

                    if (data.length > 0) {
                        mensajeSinDatos.style.display = "none";
                        tabla.style.display = "table";
                        tbody.innerHTML = data.map(f => `
                            <tr>
                                <td>${f.vehiculo}</td>
                                <td>${f.dueno}</td>
                                <td>${f.motor}</td>
                                <td>${f.luces}</td>
                                <td>${f.bocinas}</td>
                                <td>${new Date(f.fecha).toISOString().split('T')[0]}</td>
                            </tr>`).join("");
                    } else {
                        tabla.style.display = "none";
                        mensajeSinDatos.style.display = "block";
                    }
                } catch (error) {
                    console.error("Error al obtener datos:", error);
                    alert("Ocurrió un error al conectar con el servidor.");
                }
            });

            btnPdf.addEventListener("click", () => {
                const params = new URLSearchParams({
                    vehiculo_id: vehiculoSelect.value,
                    dueno_id: duenoSelect.value,
                    fecha_inicio: fechaInicioInput.value || '',
                    fecha_fin: fechaFinInput.value || ''
                });

                window.open("{{ route('historial.pdf') }}?" + params.toString(), "_blank");
            });


            // === BOTÓN IR ARRIBA ===
            window.addEventListener("scroll", () => {
                if (window.scrollY > 300) {
                    btnTop.style.display = "flex";
                } else {
                    btnTop.style.display = "none";
                }
            });

            btnTop.addEventListener("click", () => {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        });
        </script>
    </x-slot>
    <!--  END CUSTOM SCRIPTS FILE  -->
</x-base-layout>