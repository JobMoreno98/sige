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


        <form class="" id="form" method="POST">
          @csrf
          <div class="row align-items-center">
              <div class="col-md-3 offset-md-1 text-end">
                  <h3 class="card-title"><span class="text-success"><i class="fa fa-search"></span></i> Búsqueda</h3>
              </div>
              <div class="col-md-5">
                  <input type="text" class="form-control" id="filter" name="filter" placeholder="Buscar" />
              </div>

              <div class="col-md-2">
                <select class="form-select" name="filterBy" aria-label="Default select example">
                  <option value="nombre" selected>Buscar por nombre</option>
                  <option value="codigo">Buscar por codigo</option>
                </select>
              </div>

          </div>
        </form>

        <ul class="list-group" id="result">
        </ul>

            <h2>Listado de Personal </h2>
            <br>
                <p align="right">
                    <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
                    @can('cNormal_PERSONAL#editar')
                        <a href="{{ route('personal.create') }}" class="btn btn-success"> Capturar Personal</a>
                    @endcan
                    <a href="{{ route('personal.exportExcel') }}" class="btn btn-info" >Reportes en Excel</a>
                    {{-- <a  href="{{ route('personal.exportPDF') }}" class="btn btn-danger">Reportes en PDF</a> --}}
                </p>

            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>RFC</th>
                    <th>CURP</th>
                    <th>Adscribción</th>
                    <th>Contacto</th>
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


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"> </script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"> </script>

<script type="text/javascript">

  $(document).ready(function(){

    $('#filter').on('keyup', function(){
      var query = $(this).val();
      $.ajax({
        url:"{{ route('personal.search') }}",
        type:"POST",
        data: $( '#form').serialize(),
        success:function(data){
          $('#tbody1').html(data);
        }
      });
    });
  });



</script>

@else
    Acceso No válido
@endif
@endsection
