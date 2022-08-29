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
            <div class="row">
<div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
						Total Encontrados: <b>{{$total_equipos->cuenta_equipos + $total_mobiliario->cuenta_mobiliario}}</b><br>

			
			
			</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

    		<div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
						

			Total Equipos: <b>{{$total_equipos->cuenta_equipos}}</b><br>
			
			</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
		<div class="col-xl-3 col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
			
			
			Total Mobiliario: <b>{{$total_mobiliario->cuenta_mobiliario}}</b><br>
			</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
<div class="col-xl-3 col-md-6">
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">Reportados a Contaduría: <b>{{$total_equipos_reportados->cuenta_equipos_reportados}}</b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
</div>
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
            <div class="row g-3 align-items-center">
                <form action="{{ route('panel-inventario') }}" method="POST">
                    {!! csrf_field() !!}
                    <div class="col-md-6">
                        <label for="area_id">Areas</label>
                        <select class="form-control" class="form-control" id="js-example-basic-single" name="id_area">
                            <option value="No Aplica" selected>No Aplica</option>
                            @foreach($areas as $area)
                                <option value="{{$area->id}}">{{$area->sede}} - {{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                            @endforeach
                        </select>
                        <input type="submit" value="Enviar">
                    </div>
                </form>
            </div>
            <br>
            <hr>
            <div class="row">
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
                        <th>Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($equipos as $equipo)
                        <tr>
                            <td>{{$equipo->id}}</td>
                            <td>
                                {{$equipo->udg_id}}
                            </td>
                            <td>{{$equipo->tipo_equipo}}</td>
                            <td>{{$equipo->marca}}</td>
                            <td>{{$equipo->modelo}}</td>
                            <td>{{$equipo->numero_serie}}</td>
                            <td>{{$equipo->detalles}}.<br><br>
                                @if($equipo->resguardante=='CTA')
                                    Equipo de CTA.<br>
                                    @if($equipo->localizado_sici=='S')
                                        Localizado.
                                    @else
                                        No localizado.
                                    @endif
                                @endif
                            </td>
                            <td><p><a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-outline-success">Editar</a></p>
                                <p><a href="{{ route('generar-prestamo', ['equipo_id'=>$equipo->id]) }}" class="btn btn-outline-primary">Préstamo</a></p>
                                <p><a href="{{ route('cambiar-ubicacion', ['equipo_id'=>$equipo->id, 'tipo'=>'reubicar']) }}" class="btn btn-outline-danger">Reubicar</a></p>
                                <p><a href="{{ route('historial', ['equipo_id'=>$equipo->id]) }}" class="btn btn-outline-secondary">Historial</a></p></td>

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
