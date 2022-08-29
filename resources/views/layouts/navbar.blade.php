<nav>
    <div class="navbar">
        <i class='bx bx-menu'></i>
        <div class="logo"><a href="{{url('/')}}">SIGE CTA CUCSH</a></div>
        <div class="nav-links">
            <div class="sidebar-logo">
                <span class="logo-name">SIGE CTA CUCSH</span>
                <i class='bx bx-x'></i>
            </div>
            <ul class="links">
                @can('AULAS_AREAS#ver')
                <li>
                    <a href="#">Áreas</a>
                    <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
                    <ul class="htmlCss-sub-menu sub-menu">
                        <li><a href="{{ route('areas.create') }}">Captura Área</a></li>
                        <li><a href="{{ route('areas.index') }}">Consulta Áreas</a></li>
                    </ul>
                </li>
                @endcan

                @can('MOBILIARIO#ver')
                <li>
                    <a href="#">Mobiliario</a>
                    <i class='bx bxs-chevron-down htmlcss-arrow arrow'></i>
                    <ul class="htmlCss-sub-menu sub-menu">
                        @can('MOBILIARIO#crear')
                        <li><a href="{{ route('mobiliarios.create') }}">Captura Mobiliario</a></li>
                        @endcan
                        <li><a href="{{ route('mobiliarios.index') }}">Consulta Mobiliarios</a></li>
                    </ul>
                </li>
                @endcan

                @can('EQUIPOS#ver')
                <li>
                    <a href="#">Equipos y Préstamos</a>
                    <i class='bx bxs-chevron-down js-arrow arrow '></i>
                    <ul class="js-sub-menu sub-menu">
                        <li><a href="{{ route('equipos.create') }}">Captura Equipo</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a href="{{ route('nuevo-prestamo') }}">Crear Préstamo</a></li>
                        <li><a href="{{ route('prestamos.index') }}">Consultar Préstamos</a></li>
                        <li><a href="{{ route('prestamos-all') }}">Historial Préstamos</a></li>
                    </ul>
                </li>
                @endcan

                @can('ESTADISTICAS#ver')
                {{--
          <li>
            <a href="#">Estadisticas</a>
          <i class='bx bxs-chevron-down htmlcss-arrow arrow  '></i>
            <ul class="htmlCss-sub-menu sub-menu">
              <li><a href="{{ route('estadisticas') }}">Generales</a></li>
            </ul>
            </li>
            --}}
            @endcan

            @can('TICKETS#ver')
            <li>
                <a href="#">Tickets</a>
                <i class='bx bxs-chevron-down tickets-arrow arrow '></i>
                    <ul class="tickets-sub-menu sub-menu">
                    <li><a href="{{ route('tickets.create') }}">Captura Tickets</a></li>
                    <li><a href="{{ route('tickets.index') }}">Consultar Tickets Abiertos</a></li>
                    <li><a href="{{ route('revisionTickets') }}">Consultar Tickets Completos</a></li>
                </ul>
            </li>
            @endcan

            @can('CURSOS#ver')
            <li>
                <a href="#">Cursos</a>
                <i class='bx bxs-chevron-down cur-arrow arrow  '></i>
                <ul class="cur-sub-menu sub-menu">
                    @can('CURSOS#crear')
                    <li><a href="{{ route('cursos.create') }}">Capturar</a></li>
                    @endcan
                    <li><a href="{{ url('cursos/2022A') }}">Todos</a></li>
                    <li><a href="{{ route('cursos-laboratorios', '2022A') }}">Laboratorios</a></li>
                    <li><a href="{{ route('cursos-presenciales', '2022A') }}">Presenciales</a></li>
                </ul>
            </li>
            @endcan

            @can('USUARIOS#ver')
            <li>
                <a href="#">Usuarios</a>
                <i class='bx bxs-chevron-down user-arrow arrow  '></i>
                <ul class="user-sub-menu sub-menu">
                    <li><a href="{{ route('usuarios.index') }}">Administrar Usuarios</a></li>
                    <li><a href="{{ route('usuarios.index') }}">Roles y Permisos</a></li>
                </ul>
            </li>
            @endcan

            @can('LOGS#crear')
            {{--
          <li>
            <a href="#">Logs</a>
          <i class='bx bxs-chevron-down logs-arrow arrow  '></i>
            <ul class="logs-sub-menu sub-menu">
                <li><a href="{{ route('logs.index') }}">Consultar Logs</a></li>
            </ul>
            </li>
            --}}
            @endcan

            @can('PROYECTOS#ver')
            <li>
                <a href="#">Proyectos</a>
                <i class='bx bxs-chevron-down proj-arrow arrow  '></i>
                <ul class="proj-sub-menu sub-menu">
                    <li><a href="{{ route('proyectos.create') }}">Capturar Proyecto</a></li>
                    <li><a href="{{ route('proyectos.index') }}">Consultar Proyectos</a></li>
                </ul>
            </li>
            @endcan

            @can('SERVICIOS#ver')
            <li>
                <a href="#">Servicios</a>
                <i class='bx bxs-chevron-down serv-arrow arrow  '></i>
                <ul class="serv-sub-menu sub-menu">
                    <li><a href="{{ route('servicios.create') }}">Capturar servicio</a></li>
                    <li><a href="{{ route('servicios.index') }}">Consultar servicios</a></li>
                </ul>
            </li>
            @endcan

            

            <li>
            @guest
            @if (Route::currentRouteName() == 'register')
            <li><a href="href={{ route('login') }}">{{ __('Acceder') }}</a></li>
            @endif

            @if (Route::currentRouteName() == 'login')
            <li><a href="{{ route('register') }}">{{ __('Registrarse') }}</a></li>
            @endif
            @endguest

            @auth
            <li>
                <a href="#">{{ Auth::user()->name }}</a>
                <i class='bx bxs-chevron-down usuario-arrow arrow  '></i>
                <ul class="usuario-sub-menu sub-menu">
                    <li><a href="{{ route('logout') }}" onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">{{ __('Salir') }}</a></li>
                </ul>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            @endauth
            </li>
        </div>

        <div class="nav-links">
            
        </div>

    </div>
</nav><br><br><br><br>