@extends('layouts.app')
@section('content')
<div class="content">
    <div class="container-fluid">
    <h1 class="text-center">Inventario Detalle por Ciclo 2022A</h1>
        <div class="row">
            <h2 class="text-muted">Graficas</h2>
            <div class="col-6 col-lg-4">
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
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead>
                                        <tr>
                                            <th class="meta">Dispositivos</th>
                                            <th class="meta stat-cell">Total</th>
                                            <th class="meta stat-cell">Falta</th>
                                            <th class="meta stat-cell">%</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#">SICI</a></td>
                                            <td class="stat-cell">110</td>
                                            <td class="stat-cell">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                </svg>
                                                30%
                                            </td>
                                        </tr>
                                        <tr>
                                        <td><a href="#">Detalle inventario </a></td>
                                            <td class="stat-cell">67</td>
                                            <td class="stat-cell">
                                            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-arrow-down text-danger" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v11.793l3.146-3.147a.5.5 0 0 1 .708.708l-4 4a.5.5 0 0 1-.708 0l-4-4a.5.5 0 0 1 .708-.708L7.5 13.293V1.5A.5.5 0 0 1 8 1z"/>
                                </svg>
                                                10%
                                            </td>
                                        </tr>

                                    </tbody>
                                </table>
                            </div><!--//table-responsive-->
                        </div><!--//app-card-body-->
                    </div><!--//app-card-->
                    </div>

                    <div class="col-4 col-lg-2">
				        <div class="app-card app-card-chart h-100 shadow-sm">
					        <div class="app-card-header p-3 border-0">
						        <p class="app-card-title">Diagrama de pastel</p>
					        </div><!--//app-card-header-->
					        <div class="app-card-body p-4">
						        <div class="chart-container">
				                    <canvas id="chart-pie" width="150" height="150" ></canvas>
						        </div>
					        </div><!--//app-card-body-->
				        </div><!--//app-card-->
		            </div><!--//col-->


                    <div class="col-4 col-lg-2">
				        <div class="app-card app-card-chart h-100 shadow-sm">
					        <div class="app-card-header p-3 border-0">
						        <h5 class="app-card-title">Diagrama de Barra</h5>
					        </div><!--//app-card-header-->
					        <div class="app-card-body p-4">
						        <div class="chart-container">
				                    <canvas id="chart-bar" width="50" height="50" ></canvas>
						        </div>
					        </div>
				        </div>
		            </div><!--//col-->


		            <!--  -->
                    <hr class="mt-3 mb-3">
                    <!--  -->

                    <div class="row">
                        <div class="col-4">
                            <div class="title mb-1 ">Barra de progreso: SICI</div>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                        </div><!--//col-->
                    </div>

                    <hr class="mt-3 mb-3">


            <div class="row">
                <h2 class="text-muted">Dispositivos</h2>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">devices</i>
                        </div>
                        <p class="card-category">Equipos</p>
                        <h3 class="card-title">

                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">desktop_windows</i> &nbsp;

                            <i class="material-icons">computer</i> &nbsp;

                            <i class="material-icons">print</i> &nbsp;

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
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">desktop_windows</i> &nbsp;

                            <i class="material-icons">computer</i> &nbsp;

                            <i class="material-icons">print</i> &nbsp;

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
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">desktop_windows</i> &nbsp;

                            <i class="material-icons">computer</i> &nbsp;

                            <i class="material-icons">print</i> &nbsp;

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
                        <h3 class="card-title"></h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">tablet_android</i> &nbsp;

                            <i class="material-icons">tablet_mac</i> &nbsp;

                        </div>
                    </div>
                </div>
            </div>





    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.6.0/chart.js" integrity="sha512-CWVDkca3f3uAWgDNVzW+W4XJbiC3CH84P2aWZXj+DqI6PNbTzXbl1dIzEHeNJpYSn4B6U8miSZb/hCws7FnUZA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    const ctx = document.getElementById('chart-pie').getContext('2d');
    const ctx2 = document.getElementById('chart-bar').getContext('2d');

    const myChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: ['SICI SI', 'SICI NO'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19],
                backgroundColor: [
                    'rgb(0, 255, 0)',
                    'rgb(255, 0, 0)',
                    // 'rgba(255, 206, 86, 0.2)',
                    // 'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    // 'rgba(255, 206, 86, 1)',
                    // 'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        // options: {
        //     scales: {
        //         y: {
        //             beginAtZero: true
        //         }
        //     }
        // }
    });

    const myChart2 = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['SICI SI',],
            datasets: [{
                label: '# of Votes',
                data: [12, 19],
                backgroundColor: [
                    'rgb(0, 255, 0)',
                    // 'rgb(255, 0, 0)',
                    // 'rgba(255, 206, 86, 0.2)',
                    // 'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    // 'rgba(255, 99, 132, 1)',
                    // 'rgba(54, 162, 235, 1)',
                    // 'rgba(255, 206, 86, 1)',
                    // 'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        },
        // options: {
        //     scales: {
        //         y: {
        //             beginAtZero: true
        //         }
        //     }
        // }
    });

    </script>
@endsection
