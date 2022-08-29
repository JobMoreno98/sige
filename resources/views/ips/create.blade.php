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
                    <h2>Captura de IP</h2>
                </div>
                <hr>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('ips.store') }}" method="post" enctype="multipart/form-data">
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
                                <div class="col-md-6 pl-0">
                                    <label for=id_subred">Subred </label>
                                    <select class="form-control" id="id_subred" name="id_subred">
                                        @if (isset($subredElegida->id) && !is_null($subredElegida->id))
                                            <option value="{{ $subredElegida->id }}" selected>
                                                 {{ $subredElegida->subred }}
                                                 {{ $subredElegida->mascara }}
                                                 {{ $subredElegida->gateway }}
                                            </option>
                                            <option disabled>Elegir</option>
                                        @else
                                            <option disabled selected>Elegir</option>
                                        @endif
                                        @foreach ($subredes as $subred)
                                            <option value="{{ $subred->id }}">
                                                Subred: {{ $subred->subred }},
                                                Mascara: {{ $subred->mascara }},
                                                Gateway: {{ $subred->gateway }}
                                            </option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="row align-items-center">
                                <div class="col-md-6 pl-0">
                                    <label class="font-weight-bold" for="subred">IP </label>
                                    <input type="text" class="form-control" id="ip" name="ip" pattern="[0-9]{3}\.[0-9]{3}\.[0-9]{1,3}\.[0-9]{1,3}"
                                           title="El campo debe ser llenado en el formato correcto.&#013;Ejemplo: (255.255.255.255)"
                                           placeholder="255.255.255.255" max="19" maxlength=""
                                           value="{{ old('ip') }}">
                                </div>
                            </div>
                            <br>
                            
                            <br>
                        </div>
                        <br>
                        <div class="row align-items-center m-0">
                            <div class="col-md-6">
                                <a href="{{ route('ips.index') }}" class="btn btn-danger">Cancelar</a>
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
