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
                    <h2>Editar Licencia</h2>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{route('licencias.update',$licencia->id)}}" method="post" enctype="multipart/form-data" class="col-12">
                        {!! csrf_field() !!}
                        {{ method_field('PUT') }}
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
                                <input type="date" name="fecha_compra" id="fecha_compra" value="{{$licencia->fecha_compra}}">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="proveedor">Proveedor </label>
                                <input type="text" name="proveedor" id="proveedor" value="{{$licencia->proveedor}}">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="producto">Producto </label>
                                <input type="text" name="producto" id="producto" value="{{$licencia->producto}}">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="numero_de_licencia">Numero de licencia </label>
                                <input type="text" name="numero_de_licencia" id="numero_de_licencia" value="{{$licencia->numero_de_licencia}}">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="solicitante">Solicitante </label>
                                <input type="text" name="solicitante" id="solicitante" value="{{$licencia->solicitante}}">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="fecha_de_instalacion">Fecha de instalacion </label>
                                <input type="date" name="fecha_de_instalacion" id="fecha_de_instalacion" value="{{$licencia->fecha_de_instalacion}}">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="correo_de_contacto">Correo de contacto </label>
                                <input type="email" name="correo_de_contacto" id="correo_de_contacto" value="{{$licencia->correo_de_contacto}}">                                
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="telefono_de_contacto">Telefono de contacto </label>
                                <input type="text" name="telefono_de_contacto" id="telefono_de_contacto" value="{{$licencia->telefono_de_contacto}}">
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-bold" for="observaciones"> Observaciones</label>
                                <input type="text" name="observaciones" id="observaciones" value="{{$licencia->observaciones}}">
                            </div>
                        </div>
                        <br>
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
    Acceso no autorizado
    @endif

@endsection