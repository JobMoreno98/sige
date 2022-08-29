@extends('layouts.appdash', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
    <div class="container">
        @if(Auth::check())
            <div class="row">
 <div class="col-md-12">
        <div class="card card-chart">
            <div class="card-header card-header-success">
            Inventario Express
            </div>
            <div class="card-body">

                @if(session('message'))
                    <div class="alert alert-success">
                        {{session('message')}}
                    </div>
                @endif
                <hr>
                <h3><span class="text-success"><i class="fa fa-search"></span></i> Revisión Inventario</h3>

                <form action="{{ route('equipo-encontrado') }}" method="post" enctype="multipart/form-data" class="col-md-12">
                    {!! csrf_field() !!}
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                Debe de llenar todos los campos
                            </ul>
                        </div>
                    @endif
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8 col-xs-12">
                            <label for="id">IDUdeG, Serial o Núm. SIGE</label>
                            <input type="text" class="form-control" id="id" name="id" value="{{old('id')}}">
                        </div>
                        <div class="col-md-4 col-xs-12">
                            <button type="submit" class="btn btn-success">Siguiente ></button>
                        </div>

                    </div>
                    <br>




                </form>
		 </div>
            <div class="card-footer">
         
            </div>

                <br>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8 col-xs-12">
                           {{-- <p><a href="{{ route('inventario-por-area', $area_id) }}" class="btn btn-primary">Detalle</a></p>--}}
                        </div>
                    </div>
            </div>
        
        @endif
    </div>
@endsection
