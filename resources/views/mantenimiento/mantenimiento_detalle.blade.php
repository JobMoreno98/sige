@extends('layouts.app')
@section('content')
<h1>Detalle de Mantenimiento</h1>
<div class="container-fluid">
    <div class="row">
    <h2 class="text-muted">Gráficas</h2>
    <div class="col-6 col-lg-6">
            <div class="app-card app-card-stats-table h-10 shadow-sm">
                <div class="app-card-header p-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <h4 class="app-card-title">Lista de dispositivos</h4>
                        </div><!--//col-->
                        <div class="col-auto">
                            <div class="card-header-action">
                                <a href="#">...</a>
                            </div><!--//card-header-actions-->
                        </div><!--//col-->
                    </div><!--//row-->
                </div><!--//app-card-header-->
                <div class="app-card-body p-3 p-lg-4">
                    <div class="table{{---responsive--}}">
                        <table class="table table-borderless mb-0">
                            <thead>
                                <tr>
                                    <th class="meta">Dispositivos</th>
                                    <th class="meta stat-cell">Total</th>
                                    <th class="meta stat-cell">Falta</th>
                                    <th class="meta stat-cell">Porcentaje</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><a href="#">Total equipos</a></td>
                                    <td class="stat-cell">{{$total_area_equipos}}</td>
                                    <td class="stat-cell">
                                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                        </svg>
                            {{($total_area_equipos - $total_terminado)}}
                                    </td>

                                    <td>
                                        <?php echo $Percentage_SICI = round(100-((($total_area_equipos - $total_terminado) / ($total_area_equipos)) * 100),2);?>%
                                    </td>
                                </tr>







@endsection
