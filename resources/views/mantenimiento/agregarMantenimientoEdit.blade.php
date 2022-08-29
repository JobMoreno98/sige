@extends('layouts.app')
@section('content')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>


    <div class="container">
        @if (Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h4>{{ session('message') }}</h4>

                </div>
            @endif

            <div class="row">
                <h2>Edición de Mantenimiento. Folio: {{ $infomantenimiento->id }}</h2>
                <hr>
                <script type="text/javascript">
                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });
                </script>

            </div>
            <div class="row">
                <div class="table-responsive">
                <table class="table table-success" style="width:100%">
                    <thead>
                        <tr>
                            <th>Folio</th>
                            <th>Solicitante</th>
                            <th>Contacto</th>
                            <th>&Aacuterea</th>
                            <th>Fecha de Mantenimiento</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>

                            <td>{{ $vsmantenimiento->id }}</td>
                            <td>{{ $vsmantenimiento->nombre }}</td>
                            <td>{{ $vsmantenimiento->telefono }}</td>
                            <td>{{ $vsmantenimiento->sede .' - ' .$vsmantenimiento->edificio .' - ' .$vsmantenimiento->piso .' - ' .$vsmantenimiento->division .' - ' .$vsmantenimiento->coordinacion .' - ' .$vsmantenimiento->area }}</td>
                            {{-- <td>{{ $infomantenimiento->fecha_mantenimiento }}</td> --}}
                            <td>{{ \Carbon\Carbon::parse($infomantenimiento->fecha_mantenimiento)->format('d/m/Y')}}</td>

                        </tr>
                    </tbody>
                </table>
            </div>


                <h5>
                    <p align="center">Mantenimiento ya Registrado</p>
                </h5>
                <p align="right">
                    <a href="{{ route('mantenimiento.create') }}" class="btn btn-outline-success">Capturar
                        Mantenimiento
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-primary"><i class="fa fa-arrow-left"></i> Regresar</a>
                </p>
                <h4>Haz tu búsqueda de Equipos:</h4>
    <form action="" id="form-busqueda">
        @csrf
        <input class="form-control" type="text" id="buscador" name="buscador">
    </form>
    <div id="contenedor"></div>
                @if (isset($equipos_en_este_mantenimiento))
                    <div class="row">
                        @foreach ($equipos_en_este_mantenimiento as $equipoactual)
                            <div class="col-sm-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5>ID UdeG: {{ $equipoactual->udg_id }} - Equipo: {{ $equipoactual->tipo_equipo }}</h5>
                                        <br><b>Núm de serie:</b> {{ $equipoactual->numero_serie }}
                                        <br><b>Modelo:</b> {{ $equipoactual->modelo }}
                                        <br>
                                        @if ($equipoactual->terminado)
                                            <a href="{{ route('estadoMantenimiento', [$infomantenimiento->id, $equipoactual->id_equipo]) }}"
                                                class="btn btn-outline-success">Terminado</a>
                                        @else
                                            <a href="{{ route('estadoMantenimiento', [$infomantenimiento->id, $equipoactual->id_equipo]) }}"
                                                class="btn btn-outline-danger">Sin terminar </a>
                                        @endif
                                        <a href="{{ route('eliminarequipomantenimiento', [$infomantenimiento->id, $equipoactual->id_equipo]) }}"
                                            class="btn btn-outline-danger">Quitar</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                @endif
            </div>

    </div>
    <div class=row>
        <form action="{{ route('busquedaEquiposMantenimiento') }}" method="POST" enctype="multipart/form-data"
            class="col-12">
            {!! csrf_field() !!}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        Debe de escribir un criterio de búsqueda
                    </ul>
                </div>
            @endif
            <br>
            {{-- <div class="row g-3 align-items-center">
                <div class="col-md-2">
                    <label>Búsqueda</label>
                </div>
                <div class="col-md-5">
                    <input type="text" class="form-control" id="busqueda" name="busqueda">
                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $infomantenimiento->id }}"
                        readonly>
                </div>
                <div class="col-md-1">
                    <button type="submit" class="btn btn-success">Buscar</button>
                </div>

            </div> --}}
            <br>
        </form>
    </div>
    <h4>Equipos Disponibles:</h4>
    @if (isset($equipos))
        <div class="row">
            @foreach ($equipos as $equipo)
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>ID UdeG: {{ $equipo->udg_id }} - Equipo: {{ $equipo->tipo_equipo }}</h5>
                            <br><b>Núm de serie:</b> {{ $equipo->numero_serie }}
                            <br><b>Modelo:</b> {{ $equipo->modelo }}
                            <br><b>Área:</b> {{ $equipo->area }}
                            <br><a href="{{ route('agregarequipomantenimiento', [$infomantenimiento->id, $equipo->id]) }}"
                                class="btn btn-outline-success">Agregar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    <div class="row">
        <br>
        <div class="row g-5 align-items-center">
            <div class="col-md-6">
                <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>

            </div>
        </div>
    </div>

    <br>
    <div class="row g-5 align-items-center">

        <br>
        <h5>En caso de inconsistencias, favor de reportarlas a victor.ramirez@academicos.udg.mx</h5>
        <hr>

    </div>
    </div>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>





    <script>
        $(document).ready(function() {
            const input = document.getElementById('buscador');
            input.addEventListener('keyup', logKey);
            console.log($('#buscador').val());
            $(document).on('click', '.pagination a', function(event) {
                event.preventDefault();
                var page = $(this).attr('href').split('page=')[1];
                console.log(page);
                fetch_data(page);
            });

            function fetch_data(page) {
                $.ajax({
                    method: 'POST',
                    data: $('#form-busqueda').serialize(),
                    url: "{{ route('buscador-mantenimiento',['infomantenimiento'=>$infomantenimiento]) }}" + "?page=" +
                        page,
                    success: function(data) {
                        $('#contenedor').html(data);
                    }
                });
            }
        });

        function logKey() {
            let search = $('#buscador').val();
            console.log(search);
            $.ajax({
                url: "{{ route('buscador-mantenimiento',['infomantenimiento'=>$infomantenimiento]) }}",
                method: 'POST',
                data: $('#form-busqueda').serialize()
            }).done(function(data) {
                $('#contenedor').html(data);
            });
        }
    </script>
@else
    El periodo de Registro de Proyectos a terminado
    @endif
@endsection
