@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif

            <div class="row">
                <div class="col-md-auto ml-3">
                    <h2>Captura de licencia</h2>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('licencias.store') }}" method="post" enctype="multipart/form-data" class="col-12">
                        {!! csrf_field() !!}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    Debe de llenar los campos marcados con un asterisco (*).
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <br>
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_compra">Fecha de compra </label>
                                <input type="date" name="fecha_compra" id="fecha_compra">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="proveedor">Proveedor </label>
                                <input type="text" name="proveedor" id="proveedor">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="producto">Producto </label>
                                <input type="text" name="producto" id="producto">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="numero_de_licencia">Numero de licencia </label>
                                <input type="text" name="numero_de_licencia" id="numero_de_licencia">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="solicitante">Solicitante </label>
                                <input type="text" name="solicitante" id="solicitante">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_de_instalacion">Fecha de instalacion </label>
                                <input type="date" name="fecha_de_instalacion" id="fecha_de_instalacion">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="correo_de_contacto">Correo de contacto </label>
                                <input type="email" name="correo_de_contacto" id="correo_de_contacto">                                
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="telefono_de_contacto">Telefono de contacto </label>
                                <input type="text" name="telefono_de_contacto" id="telefono_de_contacto">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="observaciones"> Observaciones</label>
                                <input type="text" name="observaciones" id="observaciones">
                            </div>
                        </div>
                        
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                                <button type="submit" class="btn btn-success">
                                    Guardar datos
                                    <i class="ml-1 fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                        <br>
                    </form>
                </div>
            </div>
            <br>
            <div class="row align-items-center">

                <br>
                <hr>
                <h5>Coordinación de Tecnologías para el Aprendizaje. CUCSH</h5>


            </div>
    </div>

@else
    Accceso no autorizado
    @endif

@endsection
