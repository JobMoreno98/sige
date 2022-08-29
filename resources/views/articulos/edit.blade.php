@extends('layouts.app')

@section('content')

<div class="container">
    @if(Auth::check() && (Auth::user()->role =='admin' || Auth::user()->role =='cta' || Auth::user()->role =='auxiliar' || Auth::user()->role =='redes'))

    <div class="row">
    <div class="row g-3 align-items-center">
        <div class="col-md-12">
        <h2>Editar artículo</h2><br>
        
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

            <form action="{{route('articulos.update',$articulo->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="row g-3 align-items-center">
        <div class="col-md-6">
            <label for="" class="form-label">Código</label>
            <input type="number" name="codigo" id="codigo" value="{{ $articulo->codigo }}" class="form-control" tabindex="1" required>
        </div>
        
        <div class="col-md-6">
            <label for="" class="form-label">Cantidad</label>
            <input type="number" name="cantidad" id="cantidad" value="{{ $articulo->cantidad }}" class="form-control" tabindex="3" required>
        </div>
        </div>
        <br>
        <div class="row g-3 align-items-center">
        <div class="col-md-12">
            <label for="" class="form-label">Descripción</label>
            <input type="text" name="descripcion" id="descripcion" value="{{ $articulo->descripcion }}" class="form-control" tabindex="2" required>
        </div>
        </div><br>
        <div class="row g-3 align-items-center">
        <div class="col-md-8">
            <label for="" class="form-label">Observación</label>
            <input type="text" name="observacion" id="observacion" value="{{ $articulo->observacion }}" class="form-control" tabindex="4" required>
        </div>
        <div class="col-md-4">
            <label for="" class="form-label">Id requisicion</label>
            <input type="text"  name="requisicion_id" id="requisicion_id" value="{{ $articulo->requisicion_id }}" class="form-control" tabindex="4" required>
        </div>
        <div class="col-md-4">
            <label for="" class="form-label">Observación</label>
            <select class="form-select" aria-label="Default select example" value="{{ $articulo->status }}"  name="status" id="status" tabindex="5">
                <option value="SOLICITADO">SOLICITADO</option>
                <option value="COMPRADO NO RECIBIDO EN ALMACEN">COMPRADO NO RECIBIDO EN ALMACEN</option>
                <option value="EN ALMACÉN">EN ALMACÉN</option>
                <option value="ENTREGADO A CTA">ENTREGADO A CTA</option>
                <option value="INSTALADO">INSTALADO</option>
            </select>
        </div>
        </div>
        <br>
        
        <a href="/articulos" class="btn btn-secondary" tabindex="8">Cancelar</a>
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