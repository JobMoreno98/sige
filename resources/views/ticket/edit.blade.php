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
                <h2>Edición de Ticket Folio {{$ticket->id}}</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();

                    });
                    $(document).ready(function() {
                        $('#js-example-basic-single2').select2();

                    });
                    var dateControl = document.querySelector('input[type="date"]');
                    dateControl.value = '2017-06-01';
                </script>

            </div>
            <form action="{{route('tickets.update', $ticket->id)}}" method="post" enctype="multipart/form-data" class="col-12">
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
                            <div class="col-md-4">
                                <label for="prioridad">Prioridad </label>
                                <select class="form-control" id="prioridad" name="prioridad" required>
                                    <option selected value="{{$ticket->prioridad}}">{{$ticket->prioridad}}</option>
                                    <option disabled >Elegir</option>
                                    <option value="Alta" >Alta</option>
                                    <option value="Media">Media</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="estatus">Estatus </label>
                                <select class="form-control" id="estatus" name="estatus" required>
                                    <option selected value="{{$ticket->estatus}}">{{$ticket->estatus}}</option>
                                    <option disabled >Elegir</option>
                                    <option value="Abierto" selected>Abierto</option>
                                    <option value="Cerrado">Cerrado</option>
                                    <option value="En Espera">En Espera</option>
                                    <option value="Escalado">Escalado</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="categoria">Categoría </label>
                                <select class="form-control" id="categoria" name="categoria" required>
                                    <option selected value="{{$ticket->categoria}}">{{$ticket->categoria}}</option>
                                    <option disabled >Elegir</option>
                                    <option value="Incidente" selected>Incidente</option>
                                    <option value="Solicitudes de Servicio">Solicitudes de Servicio</option>
					<option value="Reporte de aula">Reporte de aula</option>

                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="area_id"><h5>Área: </h5></label>


                                <select class="form-control" class="form-control" id="js-example-basic-single" name="area_id" required>


                                    <option value="{{$ticket->area_id}}" selected>{{$ticket->area}}</option>
                                    <option value="No Aplica" >Cambiar...</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->sede}} - {{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                    @endforeach

                                </select>
                            </div>

                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-3">
                                <label for="tecnico_id">Técnico </label>
                                <select class="form-control" id="js-example-basic-single2" name="tecnico_id" required>
                                    <option value="{{$ticket->tecnico_id}}" selected>{{$ticket->tecnico}}</option>
                                    <option disabled >Elegir</option>
                                    @foreach($tecnicos as $tecnico)
                                        <option value="{{$tecnico->id}}">{{$tecnico->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="solicitante">Solicitante</label>
                                <input type="text" class="form-control" id="solicitante" name="solicitante" value="{{$ticket->solicitante}}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="contacto">Contacto</label>
                                <input type="text" class="form-control" id="contacto" name="contacto" value="{{$ticket->contacto}}" required>
                            </div>
                            <div class="col-md-3">
                                <label for="fecha_reporte">Fecha Reporte: </label>
                                <input type="text" class="form-control" id="dateControl" name="fecha_reporte" value="{{ \Carbon\Carbon::parse($ticket->fecha_reporte)->format('d/m/Y H:i')}}" readonly>
                        </div>
                        </div>
                        <br>
                        <div class="row g-3 align-items-center">
                        <div class="col-md-12">
                                <label for="datos_reporte">Reporte</label>
                                <textarea class="form-control" id="datos_reporte" name="datos_reporte">{{$ticket->datos_reporte}} </textarea>
                            </div>
                        </div>
                        <br>
                        <hr>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="datos_reporte"><h5>Solo llenar esta sección cuando el ticket se haya terminado</h5></label>

                            </div>
                        </div>

                        <div class="row g-3 align-items-center">
                            <div class="col-md-4">
                                <label for="fecha_inicio">Fecha Inicio </label>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="{{$ticket->fecha_inicio}}" >
                            </div>
                            <div class="col-md-4">
                                <label for="fecha_termino">Fecha Termino (Al poner la fecha de t&eacutermino, el ticket se cerrar&aacute)</label>
                                <input type="date" class="form-control" id="fecha_termino" name="fecha_termino" value="{{$ticket->fecha_termino}}" >
                            </div>
                            <div class="col-md-4">
                                <label for="problema">Categoría Problema </label>
                                <select class="form-control" id="problema" name="problema">
                                    <option selected value="{{$ticket->problema}}">{{$ticket->problema}}</option>
                                    <option disabled >Elegir</option>
                                    <option value="Falla en Hardware">Falla en Hardware</option>
                                    <option value="Software">Software</option>
                                    <option value="Capacitación">Capacitación</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
			</div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-12">
                                <label for="solucion">Solucion</label>
                                <textarea class="form-control" id="solucion" name="solucion">{{$ticket->solucion}}</textarea>
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
        El periodo de Registro de Proyectos a terminado
    @endif


@endsection
