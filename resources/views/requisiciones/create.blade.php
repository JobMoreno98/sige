@extends('layouts.app')

@section('content')

<div class="container">
    @if(Auth::check() && (Auth::user()->role =='admin' || Auth::user()->role =='cta' || Auth::user()->role =='auxiliar' || Auth::user()->role =='redes'))

    <div class="row">
        <div class="row g-3 align-items-center">
            <div class="col-md-12">
                <h2>Crear nueva requisición</h2><br>
            </div>
        </div>
        <hr>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#js-example-basic-single').select2();
                $('#equipos').select2();
            });
        </script>

    </div>

    <form action="{{route('requisiciones.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-3 align-items-center">
            <div class="col-md-4">
                <label for="" class="form-label">Número de solicitud</label>
                <input type="text" name="num_sol" id="num_sol" class="form-control" tabindex="1" required>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" tabindex="2" required>
            </div>
            <div class="col-md-4">
                <label for="" class="form-label">Usuario</label>
                <input type="text" name="user" id="user" class="form-control" tabindex="3" required value="{{ Auth::user()->name }}" readonly>
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <label for="" class="form-label">Proyecto</label>
                <input type="text" name="proyecto" id="proyecto" class="form-control" tabindex="4" required>
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Fondo</label>
                <input type="text" name="fondo" id="fondo" class="form-control" tabindex="5" required>
            </div>
        </div>
        <div class="row g-3 align-items-center">
            <div class="col-md-6">
                <label for="" class="form-label">Fecha recibido</label>
                <input type="date" name="fecha_recibido" id="v" class="form-control" tabindex="6" required>
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Nombre quien recibe</label>
                <input type="text" name="quien_recibe" id="quien_recibe" class="form-control" tabindex="7" required>
            </div>
            <div class="col-md-6">
                <label for="" class="form-label">Adjuntar requisición</label>
                <input type="file" name="pdf" id="pdf" class="form-control" tabindex="8" >
            </div>
        </div><br><br>
        <a href="/requisiciones" class="btn btn-secondary" tabindex="8">Cancelar</a>
        <button type="submit" class="btn btn-primary" tabindex="9">Guardar </button>
    </form>

    <br>
    <div class="row g-3 align-items-center">
        <br>
        <h5>En caso de inconsistencias, favor de reportarlas.</h5>
        <hr>
    </div>
</div>



@endif
@endsection