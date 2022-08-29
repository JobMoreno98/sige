@extends('layouts.app')
@section('content')

    <div class="container">
        @if (Auth::check() && Auth::user()->role == 'admin')
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <div class="col-md-auto ml-3">
                    <h2>Captura de Subred</h2>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('subredes.store') }}" method="post" enctype="multipart/form-data">
                        <div class="col">
                            {!! csrf_field() !!}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <label class="font-weight-bold" for="subred">Numero de subred </label>
                                    <input type="text" class="form-control" id="subred" name="subred"
                                           
                                           title="El campo debe ser llenado en el formato correcto."
                                           
                                           value="{{ old('subred') }}">
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <label class="font-weight-bold" for="mascara">Mascara </label>
                                    <input type="text" class="form-control" id="mascara" name="mascara"
                                           pattern="[0-5]{3}\.[0-5]{3}\.[0-5]{3}\.[0-9]{1,3}"
                                           title="El campo debe ser llenado en el formato correcto.
                                            &#013; Ejemplo: (255.255.255.255)"
                                           placeholder="255.255.255.255"
                                           value="{{ old('mascara') }}">
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-12">
                                    <label class="font-weight-bold" for="gateway">Gateway </label>
                                    <input type="text" class="form-control" id="gateway" name="gateway"
                                           pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{1,3}\.[0-9]{1,3}"
                                           title="El campo debe ser llenado en el formato correcto.
                                            &#013; Ejemplo: (192.168.1.1)"
                                           placeholder="192.168.1.1"
                                           value="{{ old('gateway') }}">
                                </div>
                            </div>
<br>
                            
                        <br>
                        <div class="row align-items-center m-0">
                            <div class="col-md-6">
                                <a href="{{ route('subredes.index') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">Guardar datos <i
                                        class="ml-1 fas fa-save"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <br>
            <div class="row align-items-center">
                <br>
                <div class="col-12 ml-3">
                    <h5>En caso de inconsistencias, favor de reportarlas.</h5>
                </div>
                <hr>
            </div>
    </div>

    @else
        El periodo de Registro de Proyectos a terminado
    @endif


@endsection
