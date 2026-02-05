{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-activity-five/>.
* 
*/

--}}


<div class="widget widget-activity-five">
    
    <div class="widget-heading">
        <h5 class="">{{$title}}</h5>

        <div class="task-action">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" id="activitylog" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-horizontal"><circle cx="12" cy="12" r="1"></circle><circle cx="19" cy="12" r="1"></circle><circle cx="5" cy="12" r="1"></circle></svg>
                </a>
            </div>
        </div>
    </div>

    <div class="widget-content">

        <div class="w-shadow-top"></div>

        <div class="mt-container mx-auto">
            <div class="timeline-line">
                @foreach ($datos as $a)
                    @if ($a->tipo == 'motor')
                        <div class="item-timeline timeline-new">
                            <div class="t-dot">
                                <div class="t-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" role="img" aria-label="Motor" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2.5" y="7" width="15" height="9" rx="1.2"></rect><path d="M17.5 10h3.5v5h-3.5"></path><circle cx="7.5" cy="11.5" r="1.6"></circle><path d="M4 16v1.8a.7.7 0 0 0 .7.7H8"></path><path d="M10 8V6.3a1 1 0 0 1 1-1h2.5a1 1 0 0 1 1 1V8"></path></svg></div>
                            </div>
                            <div class="t-content">
                                <div class="t-uppercontent">
                                    <h5><strong>Motor</strong> {{ $a->estado ? 'Activado' : 'Desactivado' }}</h5>
                                </div>
                                <p>{{ $a->ejecutado_at}}</p>
                                <p>Placa: {{ $a->vehiculo->nro_placa}}</p>
                            </div>
                        </div> 
                    @endif
                    @if ($a->tipo == 'luces')
                        <div class="item-timeline timeline-new">
                            <div class="t-dot">
                                <div class="t-secondary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="32" height="32" role="img" aria-label="Luz" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <title>Luz</title>
                                <path d="M9 18h6"></path>
                                <path d="M12 2a5 5 0 0 0-5 5c0 2.6 2 4 2.5 5 .6 1.2-.5 3 2.5 5.5 3-2.5 1.9-4.2 2.5-5.5.5-1 .5-2.4.5-5A5 5 0 0 0 12 2z"></path>
                                <path d="M12 6v2"></path>
                                <path d="M5 8.5L3 6.5"></path>
                                <path d="M21 8.5L19 6.5"></path>
                                </svg>
                                </div>
                            </div>
                            <div class="t-content">
                                <div class="t-uppercontent">
                                    <h5><strong>Luces</strong> {{ $a->estado ? 'Activado' : 'Desactivado' }}</h5>
                                </div>
                                <p>{{ $a->ejecutado_at}}</p>
                                <p>Placa: {{ $a->vehiculo->nro_placa}}</p>
                            </div>
                        </div> 
                    @endif 
                    @if ($a->tipo == 'luces')
                        <div class="item-timeline timeline-new">
                            <div class="t-dot">
                                <div class="t-secondary"><svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                                    <!-- Cuerpo de la bocina -->
                                    <path d="M 60 70 L 90 70 L 130 40 L 130 160 L 90 130 L 60 130 Z" 
                                            fill="#2c3e50" 
                                            stroke="#1a252f" 
                                            stroke-width="2"/>
                                    <path d="M 145 70 Q 155 70 155 100 Q 155 130 145 130" 
                                            fill="none" 
                                            stroke="#3498db" 
                                            stroke-width="4" 
                                            stroke-linecap="round"/>           
                                    <path d="M 160 55 Q 175 55 175 100 Q 175 145 160 145" 
                                            fill="none" 
                                            stroke="#3498db" 
                                            stroke-width="4" 
                                            stroke-linecap="round"
                                            opacity="0.7"/>
                                    <path d="M 175 40 Q 195 40 195 100 Q 195 160 175 160" 
                                            fill="none" 
                                            stroke="#3498db" 
                                            stroke-width="4" 
                                            stroke-linecap="round"
                                            opacity="0.5"/>
                                    </svg>
                                </div>
                            </div>
                            <div class="t-content">
                                <div class="t-uppercontent">
                                    <h5><strong>Bocinas</strong> {{ $a->estado ? 'Activado' : 'Desactivado' }}</h5>
                                </div>
                                <p>{{ $a->ejecutado_at}}</p>
                                <p>Placa: {{ $a->vehiculo->nro_placa}}</p>
                            </div>
                        </div> 
                    @endif                    
                @endforeach                                     
            </div>                                      
        </div>

        <div class="w-shadow-bottom"></div>
    </div>
</div>