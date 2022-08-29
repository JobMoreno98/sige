<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- <link rel="shortcut icon" href="images/favicon.ico"> -->
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" ></script>

    <!-- Fonts -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>

    <!-- CSS Files -->
    <link href="{{ asset('material') }}/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />
    <link rel="icon" href="{{asset('images/favicon.ico')}}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous"> 

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- <link href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css" rel="stylesheet"> -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.css"/>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/btnDT.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/loader.css') }} "/>

    <script type="text/javascript" src="{{ asset('js/loader.js') }}"></script>
    <script type="text/javascript">
        loader(true);
    </script>
    <style>
        .a.btn.btn-success {
        color: #fff;
        background-color: #blue;
        border-color: #28a745;
    }
    </style>
</head>
<body>
    
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
		
                        <li class="nav-item">
                            <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="" aria-haspopup="true" aria-expanded="false" v-pre>
                                Taller
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="navbarDropdown" class="nav-link e" href="#" role="button" data-toggle="" aria-haspopup="true" aria-expanded="false" v-pre>
                                Redes
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="" aria-haspopup="true" aria-expanded="false" v-pre>
                                Asesoría
                            </a>
                        </li>
                        <li class="nav-item">
                            <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="" aria-haspopup="true" aria-expanded="false" v-pre>
                                Servidores
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link " href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Administración
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Acceder') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Registrarse') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Salir') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <div class="content">
        <div class="container">
        <div class="row align-items-center">
    {{--
     <div class="col-md-12">
            <div class="card card-chart">
                <div class="card-header card-header-success">
                B&uacute;squeda General
                </div>
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
                                        <ul>
                                            Debe de escribir un criterio de búsqueda
                                        </ul>
                                    </div>
                                @endif
                                <br>
                                <div class="row align-items-center">
                                    <div class="col-md-2 offset-md-1">
                                        <h3 class="card-title"> <span class="text-success"><i class="fa fa-search"></span></i> Búsqueda</3>
                                    </div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="busqueda" name="busqueda" >
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-success">Buscar</button>
                                    </div>
                                   
                                </div>
                </form>
                
                
                </div>
                <div class="card-footer">
             
                </div>
            </div>
            </div>
    
    </div>
   --}}
            <h2>Cátalogo de servicio</h2>
            @foreach ( $servicios as $servicio )
            <p>
                <a class="btn btn-primary" data-bs-toggle="collapse" href={{"#multiCollapseExample".$servicio->id ."1"}} role="button" aria-expanded="false" aria-controls={{"#multiCollapseExample".$servicio->id ."1"}}>Servicio: {{$servicio->nombre}} </a>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target={{"#multiCollapseExample".$servicio->id."2"}} aria-expanded="false" aria-controls={{"#multiCollapseExample".$servicio->id ."2"}}>Procedimiento</button>
                <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target={{"#multiCollapseExample".$servicio->id."3"}} aria-expanded="false" aria-controls={{"#multiCollapseExample".$servicio->id ."3"}}>Contacto</button>
              </p>
              <div class="row">
                <div class="col-12">
                  <div class="multi-collapse" id={{"multiCollapseExample".$servicio->id ."1"}}>
                    <div class="card card-body">
                        Servicio: {{$servicio->nombre}}
                        <b> Descripción:</b> {{$servicio->descripcion}}
                    </div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="collapse multi-collapse" id={{"multiCollapseExample".$servicio->id ."2"}}>
                    <div class="card card-body">
                        <b> ¿Qué se necesita?:</b> {{$servicio->requisitos}}
                    </div>
                  </div>
                </div>
                <div class="col-12">
                    <div class="collapse multi-collapse" id={{"multiCollapseExample".$servicio->id ."3"}}>
                      <div class="card card-body">
                            <b>Contacto: </b>{{$servicio->contacto}}
                      </div>
                    </div>
                  </div>
              </div>
            @endforeach 
            
            

</body>
</html>
