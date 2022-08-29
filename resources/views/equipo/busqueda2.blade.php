@extends('layouts.app')

@section('content')
@if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'cta' || Auth::user()->role == 'auxiliar' || Auth::user()->role == 'redes'))

    <div class="container">
        <div class="row">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <h2>Listado de Equipos.</h2> <br>
            <h5>Su búsqueda fue: {{$busqueda}}</h5>
            <br>
                <p align="right">
                    <a href="{{ route('equipos.create') }}" class="btn btn-outline-success">Capturar Equipo</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">< Regresar</a>
                </p>
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
                    <div class="row g-3 align-items-center">
                        <div class="col-md-2">
                            <label>Búsqueda</label>
                        </div>
                        <div class="col-md-5">
                            <input type="text" class="form-control" id="busqueda" name="busqueda" >
                        </div>
                        <div class="col-md-1">

                            <button type="submit" class="btn btn-success">Buscar</button>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-secondary">Avanzada</button>
                        </div>
                    </div>
                    <br>
                </form>
                <hr>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Id SIGE</th>
                    <th>Id UdeG</th>
                    <th>Tipo Equipo</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Núm. Serie</th>
                    <th>Detalles</th>
                    <th>Área</th>
                    <th>Acciones</th>


                </tr>
                </thead>
                <tbody>

                @foreach($equipos as $equipo)
                    <tr>
                        <td>{{$equipo->id}}</td>
                        <td>{{$equipo->udg_id}}</td>
                        <td>{{$equipo->tipo_equipo}}</td>
                        <td>{{$equipo->marca}}</td>
                        <td>{{$equipo->modelo}}</td>
                        <td>{{$equipo->numero_serie}}</td>
                        <td>{{$equipo->detalles}}</td>
                        <td>{{$equipo->area}}</td>
                        <td><p><a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-success">Editar</a></p>
                        <p><a href="{{ route('cambiar-ubicacion', ['equipo_id'=>$equipo->id]) }}" class="btn btn-primary">Reubicar</a></p>
                        <p><a href="{{ route('movimientos.index', ['equipo_id'=>$equipo->id]) }}" class="btn btn-secondary">Historial</a></p></td>

                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
        <p>
            <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
        </p>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>


    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script>
    <script>

    </script>
    <script>


        $(document).ready(function() {
            $('#example').DataTable( {
                "pageLength": 100,
                "order": [[ 0, "asc" ]],
                "language": {
                    "sProcessing": "Procesando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "No se encontraron resultados",
                    "sEmptyTable": "Ningún dato disponible en esta tabla",
                    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Buscar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Cargando...",
                    "oPaginate": {
                        "sFirst": "Primero",
                        "sLast": "Último",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel',
                    {
                        extend:'pdfHtml5',
                        orientation: 'landscape',
                        pageSize:'LETTER',
                    }

                ]
            } );
        } );
    </script>
@else
    Acceso No válido
@endif
@endsection
