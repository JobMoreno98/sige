@extends('layouts.app')
@section('content')
    <div class="container">
        @if(Auth::check())

            <h3 class="text-center">Inventario por área 2022B </h3>
            <h5 class="text-center"> <span hidden> {{$area_actual->id}}</span> <strong> Area: </strong> {{$area_actual->Area}} </h5>
            <br>
            <hr>
            <div class="row g-3 align-items-center">
                <div class="col-xl-3 col-md-3">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body">
                           <p class="h5 d-inline">
                               Equipos del área: <strong> {{$total_equipos_del_area}}</strong>
                           </p>
                        </div>

                    </div>
                </div>

                <div class="col-xl-3 col-md-3">
                    <div class="card bg-secondary text-white mb-3">
                        <div class="card-body">
                           <p class="h5 d-inline">
                               Equipos en SICI: <strong> {{$equipos_en_sici->cuenta_equipos}} </strong>
                           </p>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-3">
                     <div class="card bg-secondary text-white mb-3">
                         <div class="card-body">
                            <p class="h5 d-inline">
                               Localizados SICI: <strong> {{$equipos_en_sici_localizados->cuenta_equipos}} </strong>
                            </p>
                         </div>
                     </div>
                 </div>

                 <div class="col-xl-3 col-md-3">
                       <div class="card bg-secondary text-white mb-3">
                           <div class="card-body">
                            <p class="h5 d-inline">
                               No localizados SICI: <strong> {{$equipos_en_sici_no_localizados->cuenta_equipos}} </strong>
                            </p>
                              </div>
                       </div>
                  </div>

            </div>
            {{-- /// --}}

            <div class="row g-3 align-items-center">
                <div class="col-xl-4 col-md-4">
                    <div class="card bg-success text-white mb-3">
                        <div class="card-body">Localizados: {{$total_equipos_localizados}} </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-4">
                    <div class="card bg-danger text-white mb-3">
                        <div class="card-body">No Localizados: {{$total_equipos_del_area - $total_equipos_localizados}}<b></b></div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-4">
                    <div class="card bg-warning text-white mb-3">
                        <div class="card-body">Equipos localizados de otras areas:  {{ $total_equipos_localizados_externos}} </div>
                    </div>
                </div>

            </div>



            <br>
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
                    @foreach($equipos as $equipo)
                        <tr>
                            <td>{{$equipo['id']}}</td>
                            <td>
                                {{$equipo['udg_id']}}
                            </td>

                            <td>

                            @if($equipo['estatus'] == 'Localizado' && $equipo['id_area'] == $area_actual->id)
                                <strong class="text-success">{{$equipo['estatus']}}</strong>
                            @elseif($equipo['estatus'] == 'Localizado' && $equipo['id_area'] != $area_actual->id)
                                <strong class="text-warning">{{$equipo['estatus']}}</strong>
                                @if($equipo['notas'] && $equipo['notas'] != '-')
                                    <spin class="text-info">con nota</spin>
                                @endif
                            @elseif($equipo['estatus'] == 'No Localizado' || is_null($equipo['estatus']) )
                                <strong style="color: #dc3545;">No Localizado</strong>
                            @elseif($equipo['estatus'] == 'Revision')
                                <strong style="color: #ffc107;">{{$equipo['estatus']}}</strong>
                            @endif

                            </td>

                            <td>{{$equipo['tipo_equipo']}}</td>
                            <td>{{$equipo['marca']}}</td>
                            <td>{{$equipo['modelo']}}</td>
                            <td>{{$equipo['numero_serie']}}</td>
                            <td>{{$equipo['detalles']}}.<br><br>
                                @if($equipo['resguardante']=='CTA')
                                    Equipo de CTA.<br>
                                    @if($equipo['localizado_sici']=='S')
                                        Localizado.
                             @elseif($equipo['localizado_sici']=='Si')
                                        Localizado.
                                    @else
                                        No localizado.
                                    @endif
                                @endif
                            </td>
                            <td>{{$equipo['area']}}</td>
                            <td>
                                @if(!$equipo['estatus'] == 'Localizado')
                                    <p><a class="btn btn-outline-success" href="{{ route('registro-inventario', ['equipo_id' => $equipo['id'], 'origen'=>$origen]) }}" >Localizado</a></p>
                                @endif
                                <p><a href="{{ route('cambiar-ubicacion', ['equipo_id' => $equipo['id'], 'tipo' => 'inventario']) }}" class="btn btn-outline-primary">Reubicar</a></p>
                                <p><a href="{{ route('equipos.edit', $equipo['id']) }}" class="btn btn-outline-secondary">Editar</a></p>
                                @if( $equipo['estatus'] == 'Localizado' )
                                    @if($equipo['notas'] && $equipo['notas'] != '-')
                                        <a href="#noteModal" role="button" onclick="launchModal( '{{$equipo['id']}}', '{{$equipo['id_area']}}', '{{$equipo['notas']}}' );" class="btn btn-outline-danger" data-toggle="modal"> <p class="d-inline">Ver o editar nota</p> </a>
                                    @else
                                        <a href="#noteModal" role="button" onclick="launchModal( '{{$equipo['id']}}', '{{$equipo['id_area']}}', '{{$equipo['notas']}}' );" class="btn btn-outline-danger" data-toggle="modal"> <p class="d-inline">Agregar nota</p> </a>
                                    @endif
                                @else
                                    <a href="#noteModal" role="button" onclick="launchModal( '{{$equipo['id']}}', '{{$equipo['id_area']}}', '{{$equipo['notas']}}' );" class="btn btn-outline-danger" data-toggle="modal"> <p class="d-inline">Localizar con nota</p> </a>
                                @endif
                                </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <div id="noteModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{route('inventario.store')}}" method="POST">
                            {!! csrf_field() !!}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Cerrar</button>
                            </div>
                            <div class="modal-body">

                                <h4>Agregar Nota al bien</h4>

                                <div class="row g-3 align-items-center">
                                    <div class="col-md-12">
                                        <h5>Nombre del responsable: {{Auth::user()->name}}</h5>
                                        <label for="equipo_id">ID del equipo: </label>
                                        <input type="text" class="form-control" id="equipo_id" name="equipo_id" value="#" >
                                        <label for="equipo_id">ID del area: </label>
                                        <input type="text" class="form-control" id="area_id" name="area_id" value="#" >
                                        <input type="text" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}" hidden >
                                        <label for="nota">Nota: </label>
                                        <textarea class="form-control" id="nota" name="nota"> - </textarea>
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

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    {{-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.4/js/buttons.print.min.js"></script> --}}

    <script>

    function launchModal(equipo_id, area_id, notas){
        document.getElementById('equipo_id').value = equipo_id;
        document.getElementById('area_id').value = area_id;
        document.getElementById('nota').value = notas;
        if(notas == '')
            document.getElementById('nota').value = '-';
    }


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
