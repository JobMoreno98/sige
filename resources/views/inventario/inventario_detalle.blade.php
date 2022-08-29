@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::check())

            <div class="row g-3 align-items-center">
                <div class="col-md-4">
                    <h5>Inventario 2021</h5>
                </div>
            </div>
            <div class="row g-3 align-items-center">
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">Localizados: {{$total_equipos_localizados->localizados}}<b></b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-warning text-white mb-3">
                        <div class="card-body">Con Incidente: {{ $total_equipos_revision->revisiones}}<b></b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6">
                    <div class="card bg-danger text-white mb-3">
                        <div class="card-body">No Localizados: {{$total_equipos-$total_equipos_localizados->localizados - $total_equipos_revision->revisiones}}<b></b></div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <a class="small text-white stretched-link" href="#">Ver detalles</a>
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>

            </div>
            <br>
            <div class="row g-3 align-items-center">
                <div class="col-md-12 col-xs-12">
                    @if (session('message'))
                        <div class="alert alert-success">
                            {{ session('message') }}
                        </div>
                    @endif
                    <hr>

                    {!! csrf_field() !!}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                Debe de llenar todos los campos
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row g-3 align-items-center">

                <div class="col-md-12 col-xs-12">
                    <form action="{{ route('equipo-encontrado') }}" method="post" enctype="multipart/form-data" class="col-md-12">
                        {!! csrf_field() !!}
                        <label for="id">IDUdeG, Serial o Núm. SIGE</label>
                        <input type="hidden" class="form-control" id="origen" name="origen" value="inventario-area"><br>
                        <input type="text" class="form-control" id="id" name="id" value="{{old('id')}}"><br>
                        <a href="{{ route('panel-inventario') }}" class="btn btn-danger">Regresar</a>
                        <button type="submit" class="btn btn-success">Siguiente -></button>
                    </form>
                </div>


            </div>
            <br>
            <hr>
            <div class="row">
                <table id="example" class="table table-striped table-bordered" style="width:100%">
                    <thead>
                    <tr>
                        <th>Id SIGE</th>
                        <th>Id UdeG</th>
                        <th>Estatus</th>
                        <th>Tipo Equipo</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Núm. Serie</th>
                        <th>Detalles</th>
                        <th>Área</th>
                        <th>Inventario</th>

                    </tr>
                    </thead>
                    <tbody>

                    @foreach($equipos_detalle as $equipo)
                        <tr>
                            <td>{{$equipo->id}}</td>
                            <td>
                                {{$equipo->udg_id}}
                            </td>
                            @if($equipo->estatus == 'Localizado')
                                <td style="color: #198754;">{{$equipo->estatus}}</td>
                            @elseif($equipo->estatus == 'No Localizado')
                                <td style="color: #dc3545;">{{$equipo->estatus}}</td>
                            @elseif($equipo->estatus == 'Revision')
                                <td style="color: #ffc107;">{{$equipo->estatus}}</td>
                            @endif
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
                            <td>{{$equipo->area}}</td>
                            <td>
                                <p><a class="btn btn-outline-success" href="{{ route('registro-inventario', ['equipo_id' => $equipo->id, 'revisor_id' => Auth::user()->id, 'inventario' => '2021A', 'origen'=>$origen]) }}" >Localizado</a></p>
                                <p><a href="{{ route('cambiar-ubicacion', ['equipo_id' => $equipo->id, 'tipo' => 'inventario']) }}" class="btn btn-outline-primary">Reubicar</a></p>
                                <p><a href="{{ route('equipos.edit', $equipo->id) }}" class="btn btn-outline-secondary">Editar</a></p>




                                <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                <a href="#eliminar{{$equipo->id}}" role="button" class="btn btn-outline-danger" data-toggle="modal">Nota</a>

                                <!-- Modal / Ventana / Overlay en HTML -->
                                <div id="eliminar{{$equipo->id}}" class="modal fade">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{route('inventario.store')}}" method="POST">
                                                {!! csrf_field() !!}
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Cerrar</button>

                                                </div>
                                                <div class="modal-body">

                                                    <h4>Agregar Nota al Bien</h4>

                                                    <div class="row g-3 align-items-center">
                                                        <div class="col-md-12">

                                                            <input type="text" class="form-control" id="equipo_id" name="equipo_id" value="{{$equipo->id}}" >
                                                            <input type="text" class="form-control" id="area_id" name="area_id" value="{{$equipo->id_area}}" >
                                                            <input type="text" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}" >
                                                            <textarea class="form-control" id="nota" name="nota">{{old('nota')}}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    {{--{{ route('delete-alumno',['alumno_id' => $listaTutor->id]) }} --}}
                                                    <button type="submit" class="btn btn-danger">Guardar Nota</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div></td>

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
