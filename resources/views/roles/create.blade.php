@extends('layouts.app')
@section('content')
    <div class="container">
        @if (Auth::check() && (Auth::user()->role =='admin' ||  Auth::user()->role =='cta' || Auth::user()->role =='aulas' || Auth::user()->role =='redes' || Auth::user()->role =='auxiliar'))
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>
                </div>
            @endif
            <div class="row">
                <div class="col-md-auto ml-3">
                    <h2>Nuevo Rol</h2>
                </div>
                <hr>
            </div>

            <form action="{{ route('roles.store') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        @csrf
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
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <label class="font-weight-bold" for="name">Nuevo Rol</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <label class="font-weight-bold" for="description">descripción</label>
                        <input type="text" class="form-control" id="description" name="description" value="{{ old('description') }}">
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
                                <a href="{{ route('roles.index') }}" class="btn btn-danger">Regresar</a>
                                <button type="submit" class="btn btn-success">
                                    Guardar datos
                                    <i class="ml-1 fas fa-save"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <br>
            <div class="row align-items-center">
                <br>
                <div class="col-12 ml-3">
                    <h6>En caso de inconsistencias, favor de reportarlas.</h6>
                </div>
                <hr>
            </div>
        @endif
    </div>
@endsection
