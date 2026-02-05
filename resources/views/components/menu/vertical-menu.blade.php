{{-- 

/**
*
* Created a new component <x-menu.vertical-menu/>.
* 
*/

--}}

    
        <div class="sidebar-wrapper sidebar-theme">

            <nav id="sidebar">

                <div class="navbar-nav theme-brand flex-row  text-center">
                    <div class="nav-logo">
                        <div class="nav-item theme-logo">
                            <a href="{{ route('inicio') }}">
                                <img src="{{Vite::asset('resources/images/logo.svg')}}" class="navbar-logo logo-dark" alt="logo">
                                <img src="{{Vite::asset('resources/images/logo2.svg')}}" class="navbar-logo logo-light" alt="logo">
                            </a>
                        </div>
                        <div class="nav-item theme-text">
                            <a href="{{ route('inicio') }}" class="nav-link"> SegCar </a>
                        </div>
                    </div>
                    <div class="nav-item sidebar-toggle">
                        <div class="btn-toggle sidebarCollapse">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevrons-left"><polyline points="11 17 6 12 11 7"></polyline><polyline points="18 17 13 12 18 7"></polyline></svg>
                        </div>
                    </div>
                </div>
                @if (!Request::is('collapsible-menu/*'))
                    <div class="profile-info">
                        <div class="user-info">
                        <div class="profile-img">
                            @php
                                $foto = Auth::user()->foto_perfil;
                                $rutaFoto = public_path($foto);
                            @endphp

                            @if ($foto && file_exists($rutaFoto))
                                <img src="{{ asset('storage/' . Auth::user()->foto_perfil) }}" alt="N/H" onerror="this.src='{{ asset('images/defaults.jpeg') }}'">
                            @else
                                <img src="{{ asset('images/defaults.jpeg') }}" alt="Foto">
                            @endif
                        </div>
                            <div class="profile-content">
                                <div class="">
                                    <h6>{{ Auth::user()->nombre }}</h6>
                                    <p>{{ Auth::user()->rol }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="shadow-bottom"></div>
                <ul class="list-unstyled menu-categories" id="accordionExample">
                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>INICIO</span></div>
                    </li>
                    <li class="menu {{ Request::routeIs('duser','dadmin') ? 'active' : '' }}">
                        <a href="{{ Auth::user()->rol == 'USUARIO' || Auth::user()->rol == 'PROPIETARIO' ? route('duser') : route('dadmin') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="feather feather-home">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                <span>Inicio</span>
                            </div>
                        </a>
                    </li>
                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>OPCIONES</span></div>
                    </li>

                    @if(Auth::user()->rol!="USUARIO")
                    <li class="menu {{ Request::routeIs('users.index') ? 'active' : '' }}">
                        <a href=" {{ route('users.index')}} " aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    width="24" height="24" viewBox="0 0 24 24" 
                                    fill="none" stroke="white" stroke-width="2" 
                                    stroke-linecap="round" stroke-linejoin="round" 
                                    class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                </svg>
                                <span>Usuarios</span>
                            </div>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->rol=="PROPIETARIO" || Auth::user()->rol=="USUARIO")
                    <li class="menu {{ Request::routeIs('gps.index') ? 'active' : '' }}">
                        <a href="{{ route('gps.index')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>GPS</span>
                            </div>
                        </a>
                    </li>
                    @endif
                    @if(Auth::user()->rol=="ADMIN" || Auth::user()->rol=="SOPORTE")
                    <li class="menu {{ Request::routeIs('gps.admin') ? 'active' : '' }}">
                        <a href="{{ route('gps.admin')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>GPS</span>
                            </div>
                        </a>
                    </li>
                    @endif
                    <li class="menu {{ Request::routeIs('vehicles.index') ? 'active' : '' }}">
                        <a href="{{ route('vehicles.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" 
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" 
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" 
                                    class="feather feather-truck">
                                    <rect x="1" y="3" width="15" height="13"></rect>
                                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                                    <circle cx="5.5" cy="18.5" r="2.5"></circle>
                                    <circle cx="18.5" cy="18.5" r="2.5"></circle>
                                </svg>
                                <span>Vehículos</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu {{ Request::routeIs('contacts.index') ? 'active' : '' }}">
                        <a href="{{ route('contacts.index') }}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                <span>C. Emergencia</span>
                            </div>
                        </a>
                    </li> 

                    <!-- <li class="menu {{ Request::routeIs('notes') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/app/notes" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                <span>Notes</span>
                            </div>
                        </a>
                    </li> -->

                    <!-- <li class="menu {{ Request::routeIs('scrumboard') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/app/scrumboard" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-plus"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><line x1="9" y1="15" x2="15" y2="15"></line></svg>
                                <span>Scrumboard</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu {{ Request::routeIs('contacts') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/app/contacts" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map-pin"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                <span>Contacts</span>
                            </div>
                        </a>
                    </li> -->

                    <!-- <li class="menu {{ Request::is('*/app/invoice/*') ? "active" : "" }}">
                        <a href="#invoice" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/app/invoice/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                <span>Invoice</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/app/invoice/*') ? "show" : "" }}" id="invoice" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('invoice-list') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/invoice/list"> List </a>
                            </li>
                            <li class="{{ Request::routeIs('invoice-preview') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/invoice/preview"> Preview </a>
                            </li>
                            <li class="{{ Request::routeIs('invoice-add') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/invoice/add"> Add </a>
                            </li>
                            <li class="{{ Request::routeIs('invoice-edit') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/invoice/edit"> Edit </a>
                            </li>                            
                        </ul>
                    </li> -->

                    <!-- <li class="menu {{ Request::is('*/app/ecommerce/*') ? "active" : "" }}">
                        <a href="#ecommerce" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/app/ecommerce/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                                <span>Ecommerce</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/app/ecommerce/*') ? "show" : "" }}" id="ecommerce" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('ecommerce-shop') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/shop"> Shop </a>
                            </li>
                            <li class="{{ Request::routeIs('ecommerce-detail') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/detail"> Product </a>
                            </li>
                            <li class="{{ Request::routeIs('ecommerce-list') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/list"> List </a>
                            </li>
                            <li class="{{ Request::routeIs('ecommerce-add') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/add"> Create </a>
                            </li>                            
                            <li class="{{ Request::routeIs('ecommerce-edit') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/ecommerce/edit"> Edit </a>
                            </li>                            
                        </ul>
                    </li>

                    <li class="menu {{ Request::is('*/app/blog/*') ? "active" : "" }}">
                        <a href="#blog" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/app/blog/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pen-tool"><path d="M12 19l7-7 3 3-7 7-3-3z"></path><path d="M18 13l-1.5-7.5L2 2l3.5 14.5L13 18l5-5z"></path><path d="M2 2l7.586 7.586"></path><circle cx="11" cy="11" r="2"></circle></svg>
                                <span>Blog</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/app/blog*') ? "show" : "" }}" id="blog" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('blog-grid') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/blog/grid"> Grid </a>
                            </li>
                            <li class="{{ Request::routeIs('blog-list') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/blog/list"> List </a>
                            </li>
                            <li class="{{ Request::routeIs('blog-post') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/blog/post"> Post </a>
                            </li>
                            <li class="{{ Request::routeIs('blog-create') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/blog/create"> Create </a>
                            </li>                            
                            <li class="{{ Request::routeIs('blog-edit') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/app/blog/edit"> Edit </a>
                            </li>
                        </ul>
                    </li> -->

                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>HISTORIAL</span></div>
                    </li>

                    <!-- <li class="menu {{ Request::is('*/component/*') ? "active" : "" }}">
                        <a href="#components" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/component/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                                <span>Components</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/component/*') ? "show" : "" }}" id="components" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('tabs') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/tabs"> Tabs </a>
                            </li>
                            <li class="{{ Request::routeIs('accordion') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/accordion"> Accordions  </a>
                            </li>
                            <li class="{{ Request::routeIs('modal') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/modal"> Modals </a>
                            </li>                            
                            <li class="{{ Request::routeIs('cards') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/cards"> Cards </a>
                            </li>
                            <li class="{{ Request::routeIs('bootstrap-carousel') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/bootstrap-carousel">Carousel</a>
                            </li>
                            <li class="{{ Request::routeIs('splide') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/splide">Splide</a>
                            </li>
                            <li class="{{ Request::routeIs('sweetalerts') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/sweetalerts"> Sweet Alerts </a>
                            </li>
                            <li class="{{ Request::routeIs('timeline') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/timeline"> Timeline </a>
                            </li>
                            <li class="{{ Request::routeIs('notification') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/notification"> Notifications </a>
                            </li>
                            <li class="{{ Request::routeIs('media-object') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/media-object"> Media Object </a>
                            </li>
                            <li class="{{ Request::routeIs('list-group') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/list-group"> List Group </a>
                            </li>
                            <li class="{{ Request::routeIs('pricing-table') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/pricing-table"> Pricing Tables </a>
                            </li>
                            <li class="{{ Request::routeIs('lightbox') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/lightbox"> Lightbox </a>
                            </li>
                            <li class="{{ Request::routeIs('drag-drop') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/drag-drop"> Drag and Drop </a>
                            </li>
                            <li class="{{ Request::routeIs('fonticons') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/fonticons"> Font Icons </a>
                            </li>
                            <li class="{{ Request::routeIs('flags') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/component/flags"> Flag Icons </a>
                            </li>
                        </ul>
                    </li>

                    <li class="menu {{ Request::is('*/element/*') ? "active" : "" }}">
                        <a href="#elements" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/element/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-zap"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
                                <span>Elements</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/element/*') ? "show" : "" }}" id="elements" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('alerts') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/alerts"> Alerts </a>
                            </li>
                            <li class="{{ Request::routeIs('avatar') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/avatar"> Avatar </a>
                            </li>
                            <li class="{{ Request::routeIs('badges') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/badges"> Badges </a>
                            </li>
                            <li class="{{ Request::routeIs('breadcrumbs') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/breadcrumbs"> Breadcrumbs </a>
                            </li>                            
                            <li class="{{ Request::routeIs('buttons') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/buttons"> Buttons </a>
                            </li>
                            <li class="{{ Request::routeIs('buttons-group') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/buttons-group"> Button Groups </a>
                            </li>
                            <li class="{{ Request::routeIs('color-library') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/color-library"> Color Library </a>
                            </li>
                            <li class="{{ Request::routeIs('dropdown') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/dropdown"> Dropdown </a>
                            </li>
                            <li class="{{ Request::routeIs('infobox') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/infobox"> Infobox </a>
                            </li>
                            <li class="{{ Request::routeIs('loader') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/loader"> Loader </a>
                            </li>
                            <li class="{{ Request::routeIs('pagination') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/pagination"> Pagination </a>
                            </li>
                            <li class="{{ Request::routeIs('popovers') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/popovers"> Popovers </a>
                            </li>
                            <li class="{{ Request::routeIs('progressbar') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/progressbar"> Progress Bar </a>
                            </li>
                            <li class="{{ Request::routeIs('search') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/search"> Search </a>
                            </li>
                            <li class="{{ Request::routeIs('tooltips') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/tooltips"> Tooltips </a>
                            </li>
                            <li class="{{ Request::routeIs('treeview') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/treeview"> Treeview </a>
                            </li>
                            <li class="{{ Request::routeIs('typography') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/element/typography"> Typography </a>
                            </li>
                        </ul>
                    </li> -->

                    <li class="menu {{ Request::routeIs('ubicacion.index') ? 'active' : '' }}">
                        <a href="{{route('ubicacion.index')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-map"><polygon points="1 6 1 22 8 18 16 22 23 18 23 2 16 6 8 2 1 6"></polygon><line x1="8" y1="2" x2="8" y2="18"></line><line x1="16" y1="6" x2="16" y2="22"></line></svg>
                                <span>Ubicación</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu {{ Request::routeIs('accion.index') ? 'active' : '' }}">
                        <a href="{{ route('accion.index')}}" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-pie-chart"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
                                <span>Acciones</span>
                            </div>
                        </a>
                    </li>

                    <!-- <li class="menu {{ Request::routeIs('widgets') ? 'active' : '' }}">
                        <a href="{{getRouterValue();}}/widgets" aria-expanded="false" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg>
                                <span>Widgets</span>
                            </div>
                        </a>
                    </li>

                    <li class="menu {{ Request::is('*/layout/*') ? "active" : "" }}">
                        <a href="#layouts" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/layout/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-terminal"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>
                                <span>Layouts</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/layout/*') ? "show" : "" }}" id="layouts" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('blank') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/layout/blank"> Blank Page </a>
                            </li>
                            <li class="{{ Request::routeIs('empty') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/layout/empty"> Empty Page </a>
                            </li>
                            <li class="{{ Request::routeIs('fullWidth') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/layout/full-width"> Full Width </a>
                            </li>
                            <li class="{{ Request::routeIs('collapsibleMenu') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/layout/collapsible-menu"> Collapsed Menu </a>
                            </li>
                        </ul>
                    </li> -->
                        @if(Auth::user()->rol=="ADMIN" || Auth::user()->rol=="SOPORTE")
                            <li class="menu menu-heading">
                                <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>REPORTES</span></div>
                            </li>

                            <li class="menu {{ Request::routeIs('reportVehiculo.index') ? 'active' : '' }}">
                                <a href="{{ route('reportVehiculo.index') }}" aria-expanded="false" class="dropdown-toggle">
                                    <div class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="3" y1="9" x2="21" y2="9"></line><line x1="9" y1="21" x2="9" y2="9"></line></svg>
                                        <span>Vehiculos</span>
                                    </div>
                                </a>
                            </li>

                            <li class="menu {{ Request::routeIs('reportHistorial.index') ? 'active' : '' }}">
                                <a href="{{ route('reportHistorial.index') }}" aria-expanded="false" class="dropdown-toggle">
                                    <div class="">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
                                        <span>Historial</span>
                                    </div>
                                </a>
                            </li>
                        @endif
                    <li class="menu menu-heading">
                        <div class="heading"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg><span>CONFIGURACIÓN</span></div>
                    </li>                    

                    <li class="menu {{ Request::is('*/user/*') ? "active" : "" }}">
                        <a href="#users" data-bs-toggle="collapse" aria-expanded="{{ Request::is('*/user/*') ? "true" : "false" }}" class="dropdown-toggle">
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                                <span>Cuenta</span>
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg>
                            </div>
                        </a>
                        <ul class="collapse submenu list-unstyled {{ Request::is('*/user/*') ? "show" : "" }}" id="users" data-bs-parent="#accordionExample">
                            <li class="{{ Request::routeIs('settings') ? 'active' : '' }}">
                                <a href="{{getRouterValue();}}/user/settings"> Configuración</a>
                            </li>
                        </ul>
                    </li>
                    
                </ul>
                
            </nav>

        </div>