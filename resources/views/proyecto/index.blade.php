@extends('layouts.app')

@section('content')
    @if (Auth::check() && (  Auth::user()->role =='admin' || Auth::user()->role =='cta' ||  Auth::user()->role =='redes'))
        <div class="container">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif

            <div class="row g-3 align-items-center">
                <div class="col">
                    <h2>Proyectos</h2>
                </div>
                <div class="col d-flex justify-content-end mb-3">
                    <a href="{{ route('proyectos.create') }}" class="btn btn-success mr-3">
                        Capturar Proyecto
                    </a>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        Regresar
                    </a>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <table id="tabla" class="table table-striped table-bordered table-responsive-lg w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Área interna</th>
                                <th>Responsable</th>
                                <th>Ubicación</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($proyectos as $proyecto)
                                <tr>
                                    <td>{{ $proyecto->id }}</td>
                                    <td>{{ $proyecto->titulo }}</td>
                                    <td>{{ $proyecto->area_interna }}</td>
                                    <td>{{ $proyecto->responsable }}</td>
                                    <td>{{ $proyecto->sede }} - {{ $proyecto->division }} - {{ $proyecto->coordinacion }} - {{ $proyecto->area }}</td>
                                    <td>{{ date('d/m/Y', strtotime($proyecto->fecha_inicio)) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($proyecto->fecha_fin)) }}</td>
                                    <td>
                                        <a href="{{ route('proyectos.show', $proyecto->id) }}" class="btn btn-outline-primary">Actividades</a></p>
                                        <a href="{{ route('proyectos.edit', $proyecto->id) }}" class="btn btn-outline-success">Editar</a></p>
                                        <button class="btn btn-outline-danger eliminar" data-toggle="modal" data-target="#eliminarModal" 
                                            data-idproyecto="{{ $proyecto->id }}" data-mensaje="{{ $proyecto->titulo }}" onclick="eliminarProyecto(this)">Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('home') }}" class="btn btn-primary">
                Regresar
            </a>
        </div>

        {{-- Modal eliminar --}}
        <div class="modal fade" id="eliminarModal" tabindex="-1" aria-labelledby="eliminarModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>¿Seguro de Eliminar este proyecto?</h5>
                        <p class="text-primary"><small></small></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <form method="post" enctype="multipart/form-data">
                            {!! csrf_field() !!}
                            {{ method_field('DELETE') }}
                            <input class="btn btn-danger" type="submit" value="Eliminar">
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

        <script>
            jQuery.extend( jQuery.fn.dataTableExt.oSort, {
                "portugues-pre": function (data) {
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
            });
            // Tabla proyectos
            $(document).ready(function() {
                $('#tabla').DataTable( {
                    "order": [[ 0, "desc" ]],
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
                });
            });

            function eliminarProyecto(button) {
                // Obtiene el id del proyecto 
                var idProyecto = $(button).data("idproyecto");

                // Obtiene el mensaje
                var mensaje = $(button).data("mensaje");

                // Genera la url para eliminar el proyecto
                var href = "{{ route('proyectos.index') }}/" + idProyecto;

                // Añade el mensaje al modal
                $("#eliminarModal .modal-body p small").text(mensaje);

                // Añade la url al formulario de eliminar
                $("#eliminarModal .modal-footer form").attr("action", href);
            }

        </script>

    @else
        Acceso No válido
    @endif
    
@endsection