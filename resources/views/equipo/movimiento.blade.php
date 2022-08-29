@extends('layouts.app')
@section('content')
    <div class="container">
    @if(Auth::check())
        @if (session('message'))
            <div class="alert alert-success">
                <h2>{{ session('message') }}</h2>

            </div>
        @endif
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
        <div class="row">
            <h2>Registro de Movimiento de Equipo. 1</h2>
            <hr>

            <script type="text/javascript">

                $(document).ready(function() {
                    $('#js-example-basic-single').select2();
	          $('#js-usuarios').select2();
                });

            </script>
        </div>
        <form action="{{route('movimientos.store')}}" method="post" enctype="multipart/form-data" class="col-12">
            <div class="row">
                <div class="col">
                    {!! csrf_field() !!}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                Debe de llenar todos los campos.
                            </ul>
                        </div>
                    @endif
                    <br>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-2">
                            <label for="id_equipo">Id Equipo</label>
                            <input type="text" class="form-control" id="id_equipo" name="id_equipo" value="{{$equipo->id}}" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="udg_id">Id UdeG</label>
                            <input type="text" class="form-control" id="udg_id" name="udg_id" value="{{$equipo->udg_id}}" readonly>
                        </div>
                        <div class="col-md-2">
                            <label for="marca">Marca</label>
                            <input type="text" class="form-control" id="marca" name="marca" value="{{$equipo->marca}}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="modelo">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" value="{{$equipo->modelo}}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label for="numero_serie">Número de Serie</label>
                            <input type="text" class="form-control" id="numero_serie" name="numero_serie" value="{{$equipo->numero_serie}}" readonly>
                        </div>

                    </div>
                    <br>

                    <div class="row g-3 align-items-center">
                        <div class="col-md-6">
                            <label for="area_id">Areas</label>
                            <select class="form-control" class="form-control" id="js-example-basic-single" name="id_area">
                                <option value="No Aplica" selected>No Aplica</option>
                                @foreach($areas as $area)
                                    <option value="{{$area->id}}">{{$area->sede}} - {{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{--<div class="col-md-6">
                            <label for="id_area">Areas</label>
                            <select class="form-control" id="id_area" name="id_area">
                                <option disabled selected>Elegir Area para Reasignar</option>

                                @foreach($areas as $area)
                                    <option value="{{$area->id}}">{{$area->sede}} - {{$area->edificio}} - {{$area->piso}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                @endforeach
                            </select>
                        </div>--}}
			<div class="col-md-6">
                            <label for="id_usuario">Usuarios</label>
                            <select class="form-control" class="form-control" id="js-usuarios" name="id_usuario">
                                <option disabled selected>Elegir usuario para Reasignar</option>
                                <option value="39">Usuario General</option>
                                 @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->nombre}} - {{$usuario->codigo}}</option>
                                @endforeach
                            </select>
                        </div>

                       {{-- <div class="col-md-6">
                            <label for="id_usuario">Usuario</label>
                            <select class="form-control" id="id_usuario" name="id_usuario">
                                <option disabled selected>Elegir usuario para Reasignar</option>
                                <option value="0">Usuario General falta poner id</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{$usuario->id}}">{{$usuario->nombre}} - {{$usuario->codigo}}</option>
                                @endforeach
                            </select>
                        </div>--}}
                    </div>
                    <br>
                    <div class="row g-3 align-items-center">
                        <div class="col-md-4">
                            <label for="registro">Movimiento</label>
                            <select class="form-control" id="registro" name="registro">
                                <option value="Alta de Equipo" selected>Alta de Equipo</option>
                                <option value="Cambio de ubicación">Cambio de ubicación</option>
                                <option value="Traslado">Traslado</option>
                                <option value="Préstamo">Préstamo</option>
                                <option value="Baja<">Baja</option>
                                <option value="Enviado a ajuste">Enviado a ajuste</option>
				<option value="Uso para exposiciones y eventos">Uso para exposiciones y eventos</option>

                                <option value="Robo">Robo</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="fecha">Fecha </label>
                            <input type="date" class="form-control" id="fecha" name="fecha">
                        </div>
                        <div class="col-md-4">
                            <label for="comentarios">Comentarios </label>
                            <input type="text" class="form-control" id="comentarios" name="comentarios" value="-" >
                            <input type="hidden" class="form-control" id="tipo" name="tipo" value="{{$tipo}}" >
                        </div>

                    </div>
		    <div class="row g-3 align-items-center">
                    	<div class="col-md-6">
                        	<a href="{{ route('equipos.index') }}" class="btn btn-danger">Cancelar</a>
                        	<button type="submit" class="btn btn-success">Guardar datos</button>
                    	</div>
                    </div>
                    <br>
                </div>
                <br>
                

            </div>
        </form>
        <br>
        <div class="row g-3 align-items-center">

            <br>
            <h5>En caso de inconsistencias enviar un correo a victor.ramirez@academicos.udg.mx</h5>
            <hr>

        </div>
        </div>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif
</div>
@endsection
