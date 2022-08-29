@extends('layouts.app')
@section('content')
    <div class="container">

        <div class="row">
            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
            <h2>Listado de Equipo Encontrado</h2>

        </div>
        <div class="row">
            <div class="table-responsive-sm">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th scope="col">IdEquipo</th>
                        <th scope="col">IDUdeG</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Núm. Serie</th>
                        <th scope="col">Detalles</th>
                        <th scope="col">Ubicación</th>
                        <th scope="col">Acciones</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($listadoEquipos as $listadoEquipo)
                        <tr>
                            <th scope="row">{{$listadoEquipo->id }}</th>
                            <td>{{ $listadoEquipo->udg_id }}</td>
                            <td>{{ $listadoEquipo->tipo_equipo}} - {{ $listadoEquipo->marca }} - {{ $listadoEquipo->modelo }}</td>
                            <td>
                                @if($listadoEquipo->estatus == 'Localizado')
                                    <strong class="text-success">{{$listadoEquipo->estatus}}</strong>
                                    @if($listadoEquipo->notas && $listadoEquipo->notas != '-')
                                        <spin class="text-info">con nota</spin>
                                    @endif
                                @elseif( $listadoEquipo->estatus || $listadoEquipo->estatus == 'No Localizado' || is_null($listadoEquipo->estatus) )
                                    <strong style="color: #dc3545;"> No Localizado </strong>
                                @elseif($listadoEquipo->estatus == 'Revision')
                                    <strong style="color: #ffc107;"> {{$listadoEquipo->estatus}} </strong>
                                @endif
                            </td>

                            <td>{{ $listadoEquipo->numero_serie }}</td>
                            <td>{{ $listadoEquipo->detalles }}<br> {{ $listadoEquipo->resguardante }} <br> {{ $listadoEquipo->localizado_sici }}</td>
                            <td>{{ $listadoEquipo->area }}</td>
                            <td>

                                @if( $listadoEquipo->estatus == 'Localizado' )
                                    @if($listadoEquipo->notas && $listadoEquipo->notas != '-')
                                        <a href="#AggNota" onclick="launchModal( '{{$listadoEquipo->id}}' , '{{$listadoEquipo->id_area}}' , '{{$listadoEquipo->notas}}') " role="button" class="btn btn-danger" data-toggle="modal">Ver o editar nota</a>
                                    @else
                                        <a href="#AggNota" onclick="launchModal( '{{$listadoEquipo->id}}' , '{{$listadoEquipo->id_area}}' , '{{$listadoEquipo->notas}}') " role="button" class="btn btn-danger" data-toggle="modal">Agregar Nota</a>
                                    @endif
                                    <p><a href="{{ route('cambiar-ubicacion', ['equipo_id' => $listadoEquipo->id, 'tipo' => 'inventario']) }}" class="btn btn-primary">Cambiar Ubicación</a></p>
                                @else
                                    <a class="btn btn-success" href="{{ route('registro-inventario', ['equipo_id' => $listadoEquipo->id, 'origen'=>'express']) }}" >Registrar Equipo</a>
                                     <a href="#AggNota" onclick="launchModal( '{{$listadoEquipo->id}}' , '{{$listadoEquipo->id_area}}' , '{{$listadoEquipo->notas}}') " role="button" class="btn btn-danger" data-toggle="modal">Registrar con nota</a>
                                @endif


                            </td>
                   </tr>
               @endforeach

                    </tbody>
                </table>

                <div id="AggNota" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{route('inventario.store')}}" method="POST">
                                {!! csrf_field() !!}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Cerrar</button>

                            </div>
                            <div class="modal-body">

                                <h4>Agregar nota al bien</h4>

                                <div class="row g-3 align-items-center">
                                    <div class="col-md-12">

                                        <input type="hidden" class="form-control" id="equipo_id" name="equipo_id" value="#" >
                                        <input type="hidden" class="form-control" id="area_id" name="area_id" value="#" >
                                        <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{Auth::user()->id}}" >
                                        <textarea class="form-control" id="nota" name="nota" value="{{old('nota')}}"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                <button type="submit" class="btn btn-danger">Guardar Nota</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>

        function launchModal(equipo_id, area_id, notas){

            document.getElementById('equipo_id').value = equipo_id;
            document.getElementById('area_id').value = area_id;
            document.getElementById('nota').value = notas;

            if(notas == '')
                document.getElementById('nota').value = '-';

        }

    </script>

@endsection
