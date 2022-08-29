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
                <h2>Edición de Mantenimiento. Folio: {{$mantenimiento->id}}</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();
                        $('#js-example-basic-single2').select2();
                        $('#equipos').select2();
                    });

                </script>

            </div>
            <form action="{{route('mantenimiento.update', $mantenimiento->id)}}" method="post" enctype="multipart/form-data" class="col-12">
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
                                <label for="id_area">Área para mantenimiento</label>
                                <select class="form-control" class="form-control" id="js-example-basic-single" name="area_id">
                                    <option value="No Aplica" selected>No Aplica</option>
                                    @foreach($areas as $area)
                                        <option value="{{$area->id}}">{{$area->sede}} - {{$area->division}} - {{$area->coordinacion}} - {{$area->area}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 align-items-center">
                            <div class="col-md-8">
                                <label for="tecnico_id">Técnico para mantenimiento</label>
                                <select class="form-control" class="form-control" id="js-example-basic-single2" name="tecnico_id">
                                    <option value="No Aplica" selected>No Aplica</option>
                                    @foreach($tecnicos as $tecnicos)
                                        <option value="{{$tecnicos->id}}">{{$tecnicos->nombre}} - {{$tecnicos->telefono}} - {{$tecnicos->telefono_emergencia}} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <br>
                        
                            <div class="col-md-4">
                                <label for="fecha_mantenimiento">Fecha:</label>
                                <input type="date" class="form-control" id="fecha_mantenimiento" name="fecha_mantenimiento" value="{{old('fecha_mantenimiento')}}" required>
                            </div>
                        </div>
                        
                        
			<br>
			<div class="row g-3 align-items-center">
                        	<div class="col-md-6">
                            		<a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                            		<button type="submit" class="btn btn-success">Continuar</button>
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
