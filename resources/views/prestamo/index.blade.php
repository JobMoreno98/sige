@extends('layouts.app')

@section('content')
    @if(Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'cta' || Auth::user()->role == 'auxiliar' || Auth::user()->role == 'redes'))
<div class="container-fluid">

{{--dd($prestamos)--}}

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <h2>Pr&eacute;stamos / Traslados de Equipos</h2>
            <br>
                <p align="right">
                    {{--<a href="{{ route('prestamos.create') }}" class="btn btn-success">Capturar Pr�stamo</a>--}}
                    <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
                </p>


            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Folio</th>
                    <th>Solicitante</th>
                    <th>Cargo</th>
                    <th>&Aacuterea</th>
                    <th>Contacto</th>
                    <th>Estatus</th>
                    <th>Equipos</th>
                    <th>Fecha</th>
                    <th>Observaciones</th>
		            <th>Documento</th>

                </tr>
                </thead>
                <tbody>

                </tbody>

            </table>
            <p>
                <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
            </p>
</div>
@extends('layouts.loader')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jszip-2.5.0/dt-1.10.24/b-1.7.0/b-html5-1.7.0/b-print-1.7.0/r-2.2.7/datatables.min.js"></script>

<script type="text/javascript">
    var data = @json($prestamos);

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
                "sEmptyTable": "Ning�n dato disponible en esta tabla",
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
                    "sLast": "�ltimo",
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
                "�": a, "�": a, "�": a, "�": a, "�": a, "�": a,
                "�": e, "�": e, "�": e, "�": e,
                "�": i, "�": i, "�": i, "�": i,
                "�": o, "�": o, "�": o, "�": o, "�": o, "�": o,
                "�": u, "�": u, "�": u, "�": u,
                "�": c, "�": c
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



    Acceso No v�lido
@endif
@endsection
