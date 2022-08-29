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

                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="DepartamentoLabora">Departamento Laboral</label>
                                    <input class="form-control" id="DepartamentoLabora" name="DepartamentoLabora" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="Categoria">Categoria</label>
                                    <input class="form-control" id="Categoria" name="Categoria" type="text">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Sexo">Sexo </label>
                                    <select class="form-control" id="Sexo" name="Sexo">
                                        <option disabled selected>Elegir</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
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
