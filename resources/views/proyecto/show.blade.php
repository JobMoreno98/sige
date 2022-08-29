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
                    <h2>Actividades del proyecto</h2>
                </div>
                <div class="col d-flex justify-content-end mb-3">
                    <a href="{{ route('proyecto-actividad', $proyecto->id, 'create') }}" class="btn btn-success mr-3">
                        Agregar Actividad
                    </a>
                    <a href="{{ route('proyectos.index') }}" class="btn btn-primary">
                        Regresar
                    </a>
                </div>
            </div>

            <div id="grafica" class="d-none">
                <div class="d-flex justify-content-end">
                    <span class="bg-success mr-2"></span> Completado
                    <span class="bg-warning mr-2 ml-4"></span> En Proceso
                    <span class="bg-danger mr-2 ml-4"></span> No iniciado
                </div>
                <template>
                    <tr>
                        <th class="nombre"></th>
                        <td class="numDias"></td>
                        <td class="rectangulo"><div></div></td>
                    </tr>
                </template>
                <table class="table table-responsive-lg table-hover my-3">
                    <thead class="border">
                        <tr>
                            <th colspan="3" class="text-center">
                                Gráfica de Actividades de {{ $proyecto->titulo }}
                            </th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            <div class="row">
                <div class="col-12">
                    <table id="tabla" class="table table-striped table-bordered table-responsive-lg w-100">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Tiempo</th>
                                <th>Fecha inicio</th>
                                <th>Fecha fin</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($actividades as $actividad)
                                <tr>
                                    <td>{{ $actividad->nombre }}</td>
                                    <td>{{ $actividad->descripcion }}</td>
                                    <td>{{ $actividad->tiempo }} hrs.</td>
                                    <td>{{ date('d/m/Y', strtotime($actividad->fecha_inicio)) }}</td>
                                    <td>{{ date('d/m/Y', strtotime($actividad->fecha_fin)) }}</td>
                                    <td>
                                        <a href="{{ route('proyecto-actividad.edit', $actividad->id) }}" class="btn btn-outline-success">Editar</a></p>
                                        <button class="btn btn-outline-danger eliminar" data-toggle="modal" data-target="#eliminarModal" 
                                            data-idactividad="{{ $actividad->id }}" data-mensaje="{{ $actividad->nombre }}" onclick="eliminarActividad(this)">
                                            Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <a href="{{ route('proyectos.index') }}" class="btn btn-primary">
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
                        <h5>¿Seguro de Eliminar esta Actividad?</h5>
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

        <style>
            #grafica table th,
            #grafica table td {
                padding: 0.4rem;
            }

            #grafica table td div {
                border-radius: 6px;
                height: 25px;
            }
            
            #grafica > div span {
                border-radius: 6px;
                height: 24px;
                width: 24px;
            }

            #grafica table thead {
                background-color: #F2F2F2;
            }

            #grafica .rectangulo {
                min-width: 500px;
            }
        </style>

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


            $(document).ready(function() {
                grafica();

                $('#tabla').DataTable( {
                    "order": [[ 3, "asc" ]],
                    "language": {
                        "sProcessing": "Procesando...",
                        "sLengthMenu": "Mostrar _MENU_ registros",
                        "sZeroRecords": "No se encontraron resultados",
                        "sEmptyTable": "Ningún dato disponible en esta tabla, agrega una actividad.",
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

            function eliminarActividad(button) {
                // Obtiene el id de la actividad 
                var idActividad = $(button).data("idactividad");

                // Obtiene el mensaje
                var mensaje = $(button).data("mensaje");

                // Genera la url para eliminar la actividad
                var href = "{{ route('proyecto-actividad.index') }}/" + idActividad;

                // Añade el mensaje al modal
                $("#eliminarModal .modal-body p small").text(mensaje);

                // Añade la url al formulario de eliminar
                $("#eliminarModal .modal-footer form").attr("action", href);
            }

            function grafica() {
                // Array de las actividades
                var actividades = @json($actividades);

                if (actividades.length > 0) {
                    // Obtiene la fecha de hoy sin la hora actual
                    var hoy = new Date();
                    hoy.setHours(0, 0, 0, 0);

                    // Obbtiene la fecha inicio
                    var fechaInicio = actividades[0]['fecha_inicio'];

                    // Obtiene la fecha fin
                    var fechaFin = actividades[actividades.length - 1]['fecha_fin'];

                    // Obtiene la cantidad de días entre fecha inicio y fecha fin
                    var cantidadDias = cantidadDeDias(fechaInicio, fechaFin);

                    // La gráfica se vuelve visible
                    $("#grafica").removeClass("d-none");

                    // Bucle de las actividades
                    for (var i = 0; i < actividades.length; i++) {
                        var actividad = actividades[i];

                        // Clonar template
                        var tr = $($("#grafica template").html() + '');

                        // Agregar nombre de la actividad
                        $(tr).find(".nombre").text(actividad['nombre']);

                        // Cantidad de días de la actividad
                        var dias = cantidadDeDias(actividad['fecha_inicio'], actividad['fecha_fin']);
                        $(tr).find(".numDias").text(dias + " Día" + (dias > 1 ? "s" : ""));

                        // Ancho del rectangulo de la actividad
                        var width = (dias * 100) / cantidadDias;
                        $(tr).find(".rectangulo div").css("width", width + "%");

                        // Tamaño de margen en la izquierda de la actividad
                        var marginLeft = ((cantidadDeDias(fechaInicio, actividad['fecha_inicio']) - 1) * 100) / cantidadDias;
                        $(tr).find(".rectangulo div").css("margin-left", marginLeft + "%");

                        // Fechas sin hora
                        var actFechaInicio = new Date(actividad['fecha_inicio'] + "T00:00");
                        var actFechaFin = new Date(actividad['fecha_fin'] + "T00:00");

                        // Clases de colores de bootstrap
                        var verde = "bg-success";
                        var amarillo = "bg-warning";
                        var rojo = "bg-danger";

                        // Validación de fechas para agregar color a los rectangulos
                        if (actFechaFin < hoy) {
                            $(tr).find(".rectangulo div").addClass(verde);
                        } else if (actFechaInicio <= hoy && actFechaFin >= hoy) {
                            $(tr).find(".rectangulo div").addClass(amarillo);
                        } else {
                            $(tr).find(".rectangulo div").addClass(rojo);
                        }
                        
                        // Agrega fila a la tabla
                        $("#grafica table tbody").append(tr);
                    }
                }

                // Obtine la cantidad de días entre 2 fechas
                function cantidadDeDias(first, second) {
                    first = new Date(first);
                    second = new Date(second);
                    return Math.round((second - first) / (1000 * 60 * 60 * 24)) + 1;
                }
            }

        </script>

    @else
        Acceso No válido
    @endif

@endsection