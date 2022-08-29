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
                <h2>Edición de Técnico {{$tecnico->id}}</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });
                    var dateControl = document.querySelector('input[type="date"]');
                    dateControl.value = '2017-06-01';
                </script>

            </div>
            <form action="{{route('tecnicos.update', $tecnico->id)}}" method="post" enctype="multipart/form-data" class="col-12">
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
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="nombre">Nombre del Técnico</label>
                                        <textarea class="form-control" id="nombre" name="nombre">{{$tecnico->nombre}} </textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="ciclo_inicio">Ciclo de Inicio</label>
                                        <textarea class="form-control" id="ciclo_inicio" name="ciclo_inicio">{{$tecnico->ciclo_inicio}} </textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="telefono">Teléfono de Contacto</label>
                                        <textarea class="form-control" id="telefono" name="telefono">{{$tecnico->telefono}} </textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="telefono_emergencia">Teléfono de Emergencia</label>
                                        <textarea class="form-control" id="telefono_emergencia" name="telefono_emergencia">{{$tecnico->telefono_emergencia}} </textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="asistencia">Asistencia</label>
                                        <textarea class="form-control" id="asistencia" name="asistencia">{{$tecnico->asistencia}} </textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="carrera">Carrera</label>
                                        <textarea class="form-control" id="carrera" name="carrera">{{$tecnico->carrera}} </textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="institucion">Institución</label>
                                        <textarea class="form-control" id="institucion" name="institucion">{{$tecnico->institucion}} </textarea>
                                </div>
                            </div>
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                        <label for="comentarios">Programa/Comentario</label>
                                        <textarea class="form-control" id="comentarios" name="comentarios">{{$tecnico->comentarios}}</textarea>
                                </div>
                            </div>


                        </div>

                        <br>
			<div class="row g-3 align-items-center">
                        	<div class="col-md-12">
                            		<a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                            		<button type="submit" class="btn btn-success">Guardar datos</button>
                        	</div>
                    	</div>
                    </div>
                    <br>

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
    Acceso No válido
@endif
@endsection
