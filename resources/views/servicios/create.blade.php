@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Auth::check() && (Auth::user()->role =="admin" || Auth::user()->role =="auxiliar" || Auth::user()->role =="cta"))
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif

            <div class="row">
                <div class="col-md-auto ml-3">
                    <h2>Captura de servicio</h2>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('servicios.store') }}" method="post" enctype="multipart/form-data" class="col-12">
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

                            <div class="col-md-12">
                                <label class="font-weight-bold form-label" for="nombre">Nombre del servicio </label>
                                <input name="nombre" id="nombre"  class="form-control">
                                
                            </div>
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="categoria" class="form-label">Categoria </label>
                                <input type="text" name="categoria" id="categoria" class="form-control">
                            </div>
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="contacto" class="form-label">Contacto </label>
                                <textarea name="contacto" id="contacto" rows="5" cols="50" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="descripcion">Descripcion </label>
                                <textarea class="form-control" name="descripcion" id="descripcion" rows="5" cols="50"></textarea>
                            </div>

                            <div class="col-md-12">
                                <label class="font-weight-bold" for="requisitos" class="form-label">Requisitos </label>
                                <textarea name="requisitos" id="requisitos" rows="5" cols="50" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="font-weight-bold" for="procedimiento" class="form-label">Procedimiento </label>
                                <textarea name="procedimiento" id="procedimiento" rows="5" cols="50" class="form-control"></textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="font-weight-bold form-label" for="tiempo_de_respuesta">Tiempo de respuesta </label>
                                <input type="text" name="tiempo_de_respuesta" id="tiempo_de_respuesta" class="form-control">
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
