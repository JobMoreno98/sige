@extends('layouts.app')

@section('content')

@if(Auth::check())

    <div class="container-fluid">
        <div class="row">
		<div class="col-12">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
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
	</div>
    </div>
<div class="row">
		<div class="col-12">

        <ul class="list-group" id="result">

        </ul>

            <h2>Listado de permisos del personal </h2>
            <br>
                <p align="right">
                    {{-- <a href="{{ route('') }}" class="btn btn-success">Capturar servicio</a> --}}
                    {{--<a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>--}}
                    {{--<a href="{{ route('personal.create') }}" class="btn btn-success"> Capturar Personal</a>--}}
                    {{--<a href="{{ route('personal.managestaff') }}" class="btn btn-info"> Gestionar Personal</a>--}}

                </p>

            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Usuario ID</th>
                    <th>Email</th>
                    <th>Permiso</th>
                </tr>
                </thead>
                <tbody id="tbody1">


                </tbody>

            </table>
 </div>
        </div>
        <p>
            <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
        </p>
    </div>

@else
    Acceso No válido
@endif

@endsection
