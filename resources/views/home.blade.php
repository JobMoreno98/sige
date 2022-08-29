@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
<div class="content">
    <div class="container">
        <div class="row align-items-center">
            @can('BUSQUEDAR#buscar')
            <div class="col-md-12">
                <div class="card card-chart">
                    <div class="card-header card-header-success">B&uacute;squeda General.</div>
                    <div class="card-body">
                        @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                        @endif

                        @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                        @endif

                        <form action="{{route('busqueda')}}" method="POST" enctype="multipart/form-data" class="col-12">
                            {!! csrf_field() !!}

                            @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>Debe de escribir un criterio de búsqueda</ul>
                            </div>
                            @endif

                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-3 offset-md-1 text-end">
                                    <h3 class="card-title"><span class="text-success"><i class="fa fa-search"></span></i> Búsqueda</h3>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" id="busqueda" name="busqueda" />
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-success">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
            @endcan

            <div class="col-md-12 ">
                <div class="card card-chart">
                    <div class="card-header card-header-success">Sistema Integral de Gesti&oacute;n</div>
                    <div class="row m-1">

                        @can('EQUIPOS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats ">
                                <div class="card-header card-header-warning card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">devices</i>
                                    </div>
                                    <h3 class="card-title">Equipos <br></h3>
                                    <a href="{{ route('equipos.create') }}" class="btn btn-outline-success">Capturar Equipo</a>
                                    <a href="{{ route('prestamos.index') }}" class="btn btn-outline-danger">Consultar Préstamos</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons text-dark">important_devices</i>
                                        <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                        <a href="{{ route('nuevo-prestamo') }}">Crear Préstamo</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Tickets  -->
                        @can('TICKETS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-danger card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <h3 class="card-title">Tickets</h3>
                                    <a class="btn btn-outline-success" href="{{ route('tickets.create') }}">Capturar Tickets</a>
                                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-danger">Consultar Tickets</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">local_offer</i> La Normal: {{$ticketsNormal}}
                                        <i class="material-icons">local_offer</i> Belenes: {{$ticketsBelenes}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de LLaves   -->
                        @can('LLAVES#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-info card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">room_preferences</i>
                                    </div>
                                    <h3 class="card-title">Llaves</h3>
                                    <a class="btn btn-outline-success" href="{{ route('llaves.create') }}">Capturar Llave</a>
                                    <a href="{{ route('llaves.index') }}" class="btn btn-outline-danger">Consultar Llaves</a>
                                    <a href="{{route('agregarllaves')}}" class="btn btn-outline-info">Elegir Llaves</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">door_back</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Inventario   -->
                        @can('INVENTARIOS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">fact_check</i>
                                    </div>
                                    <h3 class="card-title">Inventario</h3>
                                    <a class="btn btn-outline-success" href="{{ route('revision-inventario') }}">Revisión Express</a>
                                    <a class="btn btn-outline-danger" href="{{ route('panel-inventario') }}">Panel de Revisión</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">inventory</i><a href="{{ route('inventario-cta') }}">Inventario General</a>
                                        <i class="material-icons">location_searching</i><a href="{{ route('inventario-localizado') }}">Inventario Localizado</a>
                                        <!-- <i class="material-icons">inventory</i><a href="{{ route('inventario-express-detalle2') }}" >Nuevo Inventario express2</a> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Aulas y áreas   -->
                        @can('AULAS_AREAS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-secondary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">fact_check</i>
                                    </div>
                                    <h3 class="card-title">Aulas y &Aacute;reas</h3>
                                    <a class="btn btn-outline-success" href="{{ route('areas.index') }}">Listado &Aacute;reas</a>
                                    <a class="btn btn-outline-danger" href="{{ route('area-ticket','Belenes') }}">Detalle Aulas</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">inventory</i><a href="{{ route('inventario-cta') }}">Inventario General</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Cursos   -->
                        @can('CURSOS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="card card-stats ">
                                <div class="card-header card-header-info card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">school</i>
                                    </div>
                                    <h3 class="card-title">Cursos</h3>
                                    <a class="btn btn-outline-success" href="{{ route('cursos-presenciales', '2022B') }}">Presenciales</a>
                                    <a class="btn btn-outline-danger" href="{{ route('cursos-laboratorios', '2022B') }}">Laboratorios</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        @can('CURSOS#crear')
                                        <i class="material-icons">spellcheck</i>
                                        <a href="{{ route('cursos.create') }}">Capturar</a>
                                        @endcan
                                        <i class="material-icons">update</i><a href="{{ url('cursos/2022B') }}">Todos</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Usuarios   -->
                        @can('USUARIOS#crear')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">people</i>
                                    </div>
                                    <h3 class="card-title">Usuarios</h3>
                                    <a class="btn btn-outline-danger" href="{{ route('usuarios.index') }}">Administrar Usuarios</a>
                                    <a class="btn btn-outline-success" href="{{ route('roles.index') }}">Adm Roles</a>
                                    <a class="btn btn-outline-success" href="{{ route('permisos.index') }}">Adm Permisos</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <div class="stats">
                                            <i class="material-icons">info</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Mobiliario -->
                        @can('MOBILIARIO#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12 ">
                            <div class="card card-stats ">
                                <div class="card-header card-header-danger card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">chair</i>
                                    </div>
                                    <h3 class="card-title">Mobiliario</h3>
                                    @can('MOBILIARIO#crear')
                                    <a class="btn btn-outline-success" href="{{ route('mobiliarios.create') }}">Captura Mobiliario</a>
                                    @endcan
                                    <a href="{{ route('mobiliarios.index') }}" class="btn btn-outline-danger">Consulta Mobiliarios</a>
                                </div>
                                <div class="card-footer ">
                                    <div class="stats">
                                        <i class="material-icons">info</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Proyectos -->
                        @can('PROYECTOS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-warning card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">build</i>
                                    </div>
                                    <h3 class="card-title">Proyectos</h3>
                                    <a class="btn btn-outline-success" href="{{ route('proyectos.create') }}">Capturar Proyecto</a>
                                    <a href="{{ route('proyectos.index') }}" class="btn btn-outline-danger">Consulta Proyectos</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">info</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Licencias -->
                        @can('LICENCIAS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-secundary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <h3 class="card-title">Licencias</h3>
                                    <a class="btn btn-outline-success" href="{{ route('licencias.create') }}">Capturar licencia</a>
                                    <a href="{{ route('licencias.index') }}" class="btn btn-outline-danger">Consultar licencia</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">info</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Redes e IPs -->
                        @can('SUBREDES_IP#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">network_ping</i>
                                    </div>
                                    <h3 class="card-title">Subredes e IP´s</h3>
                                    <a class="btn btn-outline-success" href="{{ route('subredes.index') }}">Consultar Subredes</a>
                                    <a class="btn btn-outline-danger" href="{{ route('ips.index') }}">Consultar IP's</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">info</i><a href="{{ route('subredes.create') }}">Capturar Subred</a>
                                        <i class="material-icons">info</i><a href="{{ route('ips.create') }}">Capturar Ip</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Estadisticas -->
                        @can('ESTADISTICAS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">dashboard</i>
                                    </div>
                                    <h3 class="card-title">Estadisticas</h3>
                                    <a class="btn btn-outline-success" href="{{ route('estadisticas') }}">Consultar Estadisticas</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">info</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Logs -->
                        @can('LOGS#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-primary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <h3 class="card-title">Logs</h3>
                                    <a class="btn btn-outline-danger" href="{{ route('logs.index') }}">Consultar Logs</a>
                                    <a class="btn btn-outline-success" href="{{ route('estadisticas') }}">Consultar Estadisticas</a>

                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">info</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Mantenimiento   -->
                        @can('MANTENIMIENTO#ver')
                        <div class="col-lg-4 col-md-6 col-sm-12">
                            <div class="card card-stats">
                                <div class="card-header card-header-success card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">handyman</i>
                                    </div>
                                    <h3 class="card-title">Mantenimiento</h3>
                                    <a class="btn btn-outline-success" href="{{ route('mantenimiento.index') }}">Consultar Mantenimientos</a>
                                    <a class="btn btn-outline-danger" href="{{ route('mantenimiento.create') }}">Capturar Mantenimientos</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">devices</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan

                        <!-- Apartado de Requisiciones -->
                        @can('REQUISICIONES#ver')
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-secundary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">info_outline</i>
                                    </div>
                                    <h3 class="card-title">Requisiciones</h3>
                                    <a class="btn btn-outline-success" href="{{route('requisicion.create')}}">Capturar Requisición</a>
                                    <a href="{{route('requisicion.index')}}" class="btn btn-outline-danger">Consultar Requisición</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">info</i>
                                    </div>
                                </div>


                            </div>
                        </div>
                        @endcan
                        @can('cNormal_PERSONAL#ver')
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="card card-stats">
                                <div class="card-header card-header-secundary card-header-icon">
                                    <div class="card-icon">
                                        <i class="material-icons">group</i>
                                    </div>
                                    <h3 class="card-title">Personal</h3>
                                    <a class="btn btn-outline-success" href="{{ route('personal.create') }}">Capturar Personal</a>
                                    <a href="{{ route('personal.index') }}" class="btn btn-outline-danger">Consultar Personal</a>
                                </div>
                                <div class="card-footer">
                                    <div class="stats">
                                        <i class="material-icons">group</i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection