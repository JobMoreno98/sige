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
                <h2>Edición de Préstamo. Folio: {{$prestamo->id}}</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });

                </script>

            </div>
            <form action="{{route('prestamos.update', $prestamo->id)}}" method="post" enctype="multipart/form-data" class="col-12">
                @method('PUT')
                <div class="row">
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
                        <br>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <label for="id_area">Areas</label>
                                <select class="form-control" class="form-control" id="js-example-basic-single" name="id_area">
                                    <option value="{{$vsPrestamo->id_area}}" selected>{{$vsPrestamo->lugar}}</option>
                                    <option value="No Aplica" >Cambiar</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="prioridad">Estado </label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="{{$prestamo->estado}}" selected>{{$prestamo->estado}}</option>
                                    <option disabled >Elegir</option>
                                    <option value="En préstamo" >En préstamo</option>
                                    <option value="Por Entregar">Por Entregar</option>
                                    <option value="Devuelto">Devuelto</option>
                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-6">
                                <label for="solicitante">Solicitante</label>
                                <input type="text" class="form-control" id="solicitante" name="solicitante" value="{{$prestamo->solicitante}}" >
                            </div>
                            <div class="col-md-6">
                                <label for="cargo">Cargo</label>
                                <input type="text" class="form-control" id="cargo" name="cargo" value="{{$prestamo->cargo}}" >
                            </div>


                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="telefono">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" value="{{$prestamo->telefono}}" >
                            </div>
                            <div class="col-md-4">
                                <label for="correo">Correo</label>
                                <input type="text" class="form-control" id="correo" name="correo" value="{{$prestamo->correo}}" >
                            </div>

                            <div class="col-md-4">
                                <label for="fecha_inicio">Fecha:</label>
                                <input type="text" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{ \Carbon\Carbon::parse($prestamo->fecha_inicio)->format('d/m/Y H:i')}}" >
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                                <hr>
                                @foreach($equiposPrestados as $equiposPrestado)
                                <div class="col-md-2">
                                  
                                    <input type="text" class="form-control" id="equipo_id" name="fecha_inicio" value="{{$equiposPrestado->id_equipo}}" readonly> 
                                </div>
                              <br>
                                <div class="col-md-6">
                                    <label>{{$equiposPrestado->tipo_equipo}}. Marca: {{$equiposPrestado->marca}}. Modelo: {{$equiposPrestado->modelo}}. Núm. de Serie {{$equiposPrestado->numero_serie}}. <br><b>IdUdeG:</b> {{$equiposPrestado->udg_id}}</label>
                                </div>

                                <div class="col-md-3">
                                    <label>Accesorios: {{$equiposPrestado->accesorios}}</label>
                                </div>
                                <div class="col-md-1">
                                    <!-- Botón en HTML (lanza el modal en Bootstrap) -->
                                    <a href="#eliminar{{$equiposPrestado->id}}" role="button" class="btn btn-danger" data-toggle="modal">Quitar</a>

                                    <!-- Modal / Ventana / Overlay en HTML -->
                                    <div id="eliminar{{$equiposPrestado->id}}" class="modal fade">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><h5>X</h5></button>

                                                </div>
                                                <div class="modal-body">
                                                    <h5>¿Seguro de quitar este elemento de la lista de préstamos?</h5>
                                                    <h5 class="text-secondary"><small>{{$equiposPrestado->tipo_equipo}} Marca: {{$equiposPrestado->marca}}. Modelo: {{$equiposPrestado->modelo}}. Núm. de Serie {{$equiposPrestado->numero_serie}}</small></h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                                                    {{--{{ route('delete-alumno',['alumno_id' => $listaTutor->id]) }} --}}
                                                    <a href="{{route('quitar-equipo-prestado',['equipo_prestado'=>$equiposPrestado->id, 'prestamo_id'=>$prestamo->id])}}" type="button" class="btn btn-danger">Quitar</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <hr>
                                @endforeach



                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="observaciones">Observaciones</label>
                                <textarea class="form-control" id="observaciones" name="observaciones">{{$prestamo->observaciones}}</textarea>
                            </div>
                        </div>
			<div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="documento">Documento</label>
                                <input type="file" class="form-control" id="documento" name="documento" value="{{old('documento')}}">
                            </div>
                        </div>



                    </div>
                    <br>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                            <button type="submit" class="btn btn-success">Guardar datos</button>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div class="row g-3 align-items-center">

                <br>
                <h5>En caso de inconsistencias, favor de reportarlas.</h5>
                <hr>

            </div>
    </div>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif


@endsection
