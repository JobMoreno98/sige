@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">devices</i>
                        </div>
                        <p class="card-category">Equipos</p>
                        <h3 class="card-title">
                            {{$total_equipos->localizados}}
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">desktop_windows</i> &nbsp;
                            {{$total_cpu->cpus}} CPU &nbsp; | &nbsp;
                            <i class="material-icons">computer</i> &nbsp;
                            {{$total_lap->laptop}} Lap &nbsp; | &nbsp;
                            <i class="material-icons">print</i> &nbsp;
                            {{$total_imp->impresora}} Imp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">desktop_windows</i>
                        </div>
                        <p class="card-category">Localizados SICI</p>
                        <h3 class="card-title">{{$total_equipos_localizados_sici->localizados_sici}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">desktop_windows</i> &nbsp;
                            {{$total_cpu_localizados_sici->cpu_localizados}} CPU &nbsp; | &nbsp;
                            <i class="material-icons">computer</i> &nbsp;
                            {{$total_lap_localizadas_sici->lap_localizadas}} Lap &nbsp; | &nbsp;
                            <i class="material-icons">print</i> &nbsp;
                            {{$total_imp_localizadas_sici->imp_localizadas}} Imp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">desktop_windows</i>
                        </div>
                        <p class="card-category">No Localizados SICI</p>
                        <h3 class="card-title">{{$total_equipos_no_localizados_sici->no_localizados_sici}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">desktop_windows</i> &nbsp;
                            {{$total_cpu_no_localizados_sici->cpu_localizados}} CPU &nbsp; | &nbsp;
                            <i class="material-icons">computer</i> &nbsp;
                            {{$total_lap_no_localizadas_sici->lap_localizadas}} Lap &nbsp; | &nbsp;
                            <i class="material-icons">print</i> &nbsp;
                            {{$total_imp_no_localizadas_sici->imp_localizadas}} Imp
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">tablet_mac</i>
                        </div>
                        <p class="card-category">Tablets</p>
                        <h3 class="card-title">{{$total_tablets_cta->total_tablet_cta}}</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">tablet_android</i> &nbsp;
                            {{$total_tablets_android->total_tablet_android}} &nbsp; Android &nbsp; | &nbsp;
                            <i class="material-icons">tablet_mac</i> &nbsp;
                            {{$total_tablets_apple->total_tablet_apple}} &nbsp; Apple
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">restart_alt</i>
                        </div>
                        <p class="card-category">Prestamos</p>
                        <h3 class="card-title">+245</h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">update</i> Just Updated
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-4">
                <div class="card card-chart">
                    <div class="card-header">
                        <canvas id="myChart" width="400" height="400"></canvas>
                        <div class="ct-chart" id="dailySalesChart"></div>
                    </div>
                    <div class="card-body">
                        <h4 class="card-title">Daily Sales</h4>
                        <p class="card-category">
                        <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">access_time</i> updated 4 minutes ago
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.js" integrity="sha512-CWVDkca3f3uAWgDNVzW+W4XJbiC3CH84P2aWZXj+DqI6PNbTzXbl1dIzEHeNJpYSn4B6U8miSZb/hCws7FnUZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const ctx = document.getElementById('myChart').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Purple'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>
@endsection
