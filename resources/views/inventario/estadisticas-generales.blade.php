@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <h2>Estadísticas Generales Inventario CTA</h2>
                <hr>
            </div>
            <br>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">Tipo</th>
                        <th scope="col">Conteo General</th>
                        <th scope="col">Localizados SICI</th>
                        <th scope="col">No Localizados SICI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">Equipos</th>
                        <td>{{$total_equipos->cuenta_equipos}}</td>
                        <td>{{$total_equipos_localizados_sici->cuenta_equipos_localizados_sici}}</td>
                        <td>{{$total_equipos_no_localizados_sici->cuenta_equipos_no_localizados_sici}}</td>
                        </tr>
                        <tr>
                        <th scope="row">Mobiliario</th>
                        <td>{{$total_mobiliario->cuenta_mobiliario}}</td>
                        <td>{{$total_mobiliario_localizado_sici->cuenta_mobiliario_localizado_sici}}</td>
                        <td>{{$total_mobiliario_no_localizado_sici->cuenta_mobiliario_no_localizado_sici}}</td>
                        </tr>
                        <tr>
                        <th scope="row">Totales</th>
                        <td>{{$total_equipos->cuenta_equipos+$total_mobiliario->cuenta_mobiliario}}</td>
                        <td>{{$total_equipos_localizados_sici->cuenta_equipos_localizados_sici+$total_mobiliario_localizado_sici->cuenta_mobiliario_localizado_sici}}</td>
                        <td>{{$total_equipos_no_localizados_sici->cuenta_equipos_no_localizados_sici+$total_mobiliario_no_localizado_sici->cuenta_mobiliario_no_localizado_sici}}</td>
                        </tr>
                    </tbody>
                    </table>
                    
                </div>

    		
               
</div>

 <div class="row">
     <div class="col">
                <h2>Inventario 2021A</h2>
                <hr>
                <h7>* La cuenta es sobre los equipos marcados como localizados en SICI </h7>
</div>
            </div>
<br>
<div class="row">

                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-4">
                        <div class="card-body">Localizados: <b>{{$total_localizados->cuenta_localizados}}</b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Con Incidente: <b>{{$total_incidentes->cuenta_incidentes}}</b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-4">
                        <div class="card-body">No Localizados: <b>{{$total_no_localizados}}</b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

            </div>

            <br>
            <hr>
            <div class="row">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Núm.</th>
                        <th>Conteo</th>
                        
                        <th>Area</th>
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $cont=1; $acum=0; ?>
                    @foreach($conteo_por_area as $conteo_fila)
                        <tr>
                            <td>{{$cont++}}</td>
                            <td>
                                {{$conteo_fila->conteo_por_area}}
                            </td>
                            
                            <td>{{$conteo_fila->area}}</td>
                      
                        

                            <td>
                                @if(!is_null($conteo_fila->id_area))
                                    <p><a href="{{ route('inventario-por-area', $conteo_fila->id_area) }}" class="btn btn-primary">Detalle</a></p>

                                    <p><a href="{{ route('actualizacion-inventario', $conteo_fila->id_area) }}" class="btn btn-success">Revisado</a></p>
                                @endif
                                </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <p>
                <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
            </p>

            <br>
            <div class="row g-3 align-items-center">

                <br>
                <hr>
                <h5>Coordinación de Tecnologías para el Aprendizaje. CUCSH</h5>


            </div>
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

    <script type="text/javascript">

        $(document).ready(function() {
            $('#js-example-basic-single').select2();

        });

    </script>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif

@endsection
