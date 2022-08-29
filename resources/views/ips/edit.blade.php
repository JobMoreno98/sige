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
                    <h2>Actualizar Ip</h2>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('ips.update', $ip->id) }}" method="post" enctype="multipart/form-data">
                        @method('PUT')
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
                            <div class="row align-items-end">
                                <div class="col-md-12 pl-0">
                                    <label for="id_subred">Subred </label>
                                    <select class="form-control" id="id_subred" name="id_subred">
                                            <option value="{{ $ip->id_subred }}" selected>
                                                subred actual de la ip: {{$subred->subred}}
                                            </option>
                                            <option value="Elegir">Elegir otra subred</option>
                                        @foreach ($subredes as $subred)
                                            <option value="{{ $subred->id }}">
                                                
                                                Subred: {{ $subred->subred }} /
                                               
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="ip">Ip</label>
                                    <input type="text" class="form-control" id="ip" name="ip"
                                           value="{{ $ip->ip}}">
                                </div>
                            </div>
                            <br>
                            {{-- <div class="row align-items-center">
                                <div class="row align-items-center">
                                    <div class="col-md-20">
                                        <label class="font-weight-bold" for="disponible">Disponible </label>
                                        <select class="form-control" id="disponible" name="disponible" >
                                            <option >{{ $ip->disponible }}</option>
                                            <option value="si">Si</option>
                                            <option value="no">No</option>
                                        </select>
                                    </div>
                                </div>
                            </div> --}}
                            <br>
                            <div class="row align-items-center m-0">
                                <div class="col-md-6">
                                    <a href="{{ route('ips.index') }}" class="btn btn-danger">Cancelar</a>
                                    <button type="submit" class="btn btn-success">
                                        Guardar datos <i class="ml-1 fas fa-save"></i>
                                    </button>
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
