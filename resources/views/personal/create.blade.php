@extends('layouts.app')
@section('content')

@can('cNormal_PERSONAL#editar')
    <div class="container">
        @if(Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <h2>Captura de Personal</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();
                        $('#js-example-basic-single2').select2();
                        $('#equipos').select2();
                    });

                </script>

            </div>
            <form action="{{route('personal.store')}}" method="post" enctype="multipart/form-data" class="col-12">
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
                                <div class="col-md-6">
                                        <label class="font-weight-bold" for="NombreYApellidos">Nombre del Personal</label>
                                        <input class="form-control" id="NombreYApellidos" name="NombreYApellidos" type="text">
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Sexo">Sexo </label>
                                    <select class="form-control" id="Sexo" name="Sexo">
                                        <option disabled selected>Elegir</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="Domicilio">Domicilio</label>
                                    <input class="form-control" id="Domicilio" name="Domicilio" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="CodigoPostal">Código Postal</label>
                                    <input class="form-control" id="CodigoPostal" name="CodigoPostal" type="CodigoPostal">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="Nacionalidad">Nacionalidad</label>
                                    <input class="form-control" id="Nacionalidad" name="Nacionalidad" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="Telefono">Teléfono</label>
                                    <input class="form-control" id="Telefono" name="Telefono" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="TelefonoCelular">Teléfono Celular</label>
                                    <input class="form-control" id="TelefonoCelular" name="TelefonoCelular" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="CorreoE">Correo Electrónico</label>
                                    <input class="form-control" id="CorreoE" name="CorreoE" type="text">
                                </div>
                                <div class="col-md-4">
                                        <label class="font-weight-bold" for="RFC">RFC</label>
                                        <input class="form-control" id="RFC" name="RFC" type="text">
                                </div>
                                <div class="col-md-4">
                                        <label class="font-weight-bold" for="CURP">CURP</label>
                                        <input class="form-control" id="CURP" name="CURP" type="text">
                                </div>

                                <div class="col-md-4">
                                        <label class="font-weight-bold" for="Division">División</label>
                                        <input class="form-control" id="Division" name="Division" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="DepartamentoAdscripcion">Departamento Adscrito</label>
                                    <input class="form-control" id="DepartamentoAdscripcion" name="DepartamentoAdscripcion" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="DepartamentoLabora">Departamento Laboral</label>
                                    <input class="form-control" id="DepartamentoLabora" name="DepartamentoLabora" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="Categoria">Categoria</label>
                                    <input class="form-control" id="Categoria" name="Categoria" type="text">
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
    @endcan

@else
    Acceso No válido
@endif
@endsection
