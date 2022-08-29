@extends('layouts.app')

@section('content')
    @if(Auth::check() && (Auth::user()->role =='admin' || Auth::user()->role =='cta' || Auth::user()->role =='auxiliar' || Auth::user()->role =='redes'))

    <div class="container-fluid">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
                <h2>Tickets MKI</h2>
                    <p align="right">

                        

                        <a href="{{ route('tickets.create') }}" class="btn btn-success">Capturar Ticket</a>

                        <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
                    </p>
            </div>
        </div>
        <br>
        <form action="{{route('filtroTickets')}}" method="post" enctype="multipart/form-data" class="col-12">
            <div class="row g-3 align-items-center">
                <div class="col">
                    {!! csrf_field() !!}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{$error}}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <br>
            </div>
            <div class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="tecnico_id">Técnico </label>
                    <select class="form-control" id="tecnico_id" name="tecnico_id">
                        @if(isset($tecnicoElegido->id) && !is_null($tecnicoElegido->id))
                            <option value="{{$tecnicoElegido->id}}" selected>{{$tecnicoElegido->nombre}}</option>
                            <option disabled >Elegir</option>
                        @else
                            <option disabled selected>Elegir</option>
                        @endif

                        @foreach($tecnicos as $tecnico)
                            <option value="{{$tecnico->id}}">{{$tecnico->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="estatus">Estatus </label>
                    <select class="form-control" id="estatus" name="estatus">
                        @if(isset($estatus) && !is_null($estatus))
                            <option value="{{$estatus}}">{{$estatus}}</option>
                            <option disabled >Elegir</option>
                        @else
                            <option disabled selected>Elegir</option>
                        @endif
                        <option value="Abierto">Abierto</option>
                        <option value="Cerrado">Cerrado</option>
                        <option value="Escalado">Escalado</option>
                    </select>

                </div>
                <div class="col-md-2 " >
                    <button type="submit" class="btn btn-outline-primary">Filtrar</button>
                    <a href="{{ route('tickets.index') }}" class="btn btn-outline-success">Quitar Filtro</a>
                </div>
            </div>
            <br>

    </form>
        <div class="row g-3 align-items-center">
            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Folio</th>

                    <th>Fecha Reporte</th>
                    <th>Área</th>
                    <th>Solicitante</th>
                    <th>Contacto</th>
                    <th>Técnico</th>
                    <th>Categoría y Prioridad</th>
                    <th>Reporte</th>
                    <th>Solución y cierre</th>

                </tr>
                </thead>
                <tbody>


                </tbody>

            </table>

        </div>
        <p>
            <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
        </p>
    </div>

    @extends('layouts.loader')

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.js"></script>

        <script type="text/javascript">
            var data = @json($tickets);

            $(document).ready(function() {
                $('#example').DataTable({
                    "data": data,
                    "pageLength": 100,
                    "order": [
                        [0, "desc"]
                    ],
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
                    responsive: true,
                    // dom: 'Bfrtip',
                    dom: '<"col-xs-3"l><"col-xs-5"B><"col-xs-4"f>rtip',
                    buttons: [
                        'copy', 'excel',
                        {
                            extend: 'pdfHtml5',
                            orientation: 'landscape',
                            pageSize: 'LETTER',
                        }

                    ]
                })
               loader(false);
            });


            jQuery.extend( jQuery.fn.dataTableExt.oSort, {
            "portugues-pre": function ( data ) {
                var a = 'a';
                    var e = 'e';
                    var i = 'i';
                    var o = 'o';
                    var u = 'u';
                    var c = 'c';
                    var special_letters = {
                        "Á": a, "á": a, "Ã": a, "ã": a, "À": a, "à": a,
                        "É": e, "é": e, "Ê": e, "ê": e,
                        "Í": i, "í": i, "Î": i, "î": i,
                        "Ó": o, "ó": o, "Õ": o, "õ": o, "Ô": o, "ô": o,
                        "Ú": u, "ú": u, "Ü": u, "ü": u,
                        "ç": c, "Ç": c
                    };
                    for (var val in special_letters)
                        data = data.split(val).join(special_letters[val]).toLowerCase();
                    return data;
                },
                "portugues-asc": function ( a, b ) {
                    return ((a < b) ? -1 : ((a > b) ? 1 : 0));
                },
                "portugues-desc": function ( a, b ) {
                    return ((a < b) ? 1 : ((a > b) ? -1 : 0));
                }
            } );
            //"columnDefs": [{ type: 'portugues', targets: "_all" }],            

        </script>

@else
    Acceso No válido
@endif
@endsection
