<!DOCTYPE html>
<?php
include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
include 'permiso.php';
$obj = new permiso();

if (isset($_POST['modificar'])) {
    $datosModificar = $_POST;
    //echo var_dump($datosModificar);
    $obj->modificarPermisoLargo($datosModificar);
    header('location: incapacidadConsulta.php');
}

if (isset($_POST['eliminar'])) {
    $obj->eliminarPermisoLargo($_POST['idPermiso']);
}
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Valentín Camacho Veloz, Daniel Flores Rodriguez, Brian Valentín Franco, Nancy García Mesillas">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="js/jquery.dataTables.js"></script><!-- Editado -->
        <!--Datatables responsive-->
        <link rel="stylesheet" type="text/css" href="css/responsive.dataTables.min.css"/>
        <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
        <!--Datatables Buttons-->
        <link rel="stylesheet" type="text/css" href="css/buttons.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="js/pdfmake.min.js"></script><!--Imprimir PDF-->
        <script type="text/javascript" src="js/vfs_fonts.js"></script><!-- Imprimir PDF-->
        <script type="text/javascript" src="js/jszip.min.js"></script><!--Imprimir Excel-->
        <script type="text/javascript" src="js/buttons.print.min.js"></script><!--Imprimir pantalla-->
        <!--Contiene las funciones para crear DataTable y filtros-->
        <!--<script type="text/javascript" src="function/material.js"></script>-->

        <script>
            var incapacidad = <?php echo json_encode($obj->tableIncapacidad()); ?>;
            var licencia = <?php echo json_encode($obj->tableLicencia()); ?>;
            var comision = <?php echo json_encode($obj->tableComision()); ?>;

            $(document).ready(function(){
                 var t = 'Incapacidades';
                $('#dtIncapacidad').DataTable( {
                    "data": incapacidad,
                    "order": [[ 0, "asc" ]],
                    responsive: true,
                    dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
            //                    dom: es el orden de las funciones de la tabla
            //                    l: es la lista de numero de registros que se muestran
            //                    B: son los botones para imprimir
            //                    f: es el filtro de busqueda
            //                    rt: son los registros de la tabla
            //                    i: es la información de registros
            //                    p: es la barra de paginación
                    buttons: [

                    ]
                });
            });

            $(document).ready(function(){
                 var t = 'Licencias';
                $('#dtLicencia').DataTable( {
                    "data": licencia,
                    "order": [[ 0, "asc" ]],
                    responsive: true,
                    dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
            //                    dom: es el orden de las funciones de la tabla
            //                    l: es la lista de numero de registros que se muestran
            //                    B: son los botones para imprimir
            //                    f: es el filtro de busqueda
            //                    rt: son los registros de la tabla
            //                    i: es la información de registros
            //                    p: es la barra de paginación
                    buttons: [

                    ]
                });
            });

            $(document).ready(function(){
                 var t = 'Comisiones';
                $('#dtComision').DataTable( {
                    "data": comision,
                    "order": [[ 0, "asc" ]],
                    responsive: true,
                    dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
            //                    dom: es el orden de las funciones de la tabla
            //                    l: es la lista de numero de registros que se muestran
            //                    B: son los botones para imprimir
            //                    f: es el filtro de busqueda
            //                    rt: son los registros de la tabla
            //                    i: es la información de registros
            //                    p: es la barra de paginación
                    buttons: [

                    ]
                });
            });

        </script>
        <style>
            #tablas{
                margin-top: 20pt;
            }
        </style>

    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        <div class="container-fluid">
            <div class="page-header">
                <h3 style="text-align: center">Listado de incapacidades, comisiones y licencias</h3>
          </div>

            <div id="tabs" class="container-fluid">
                <ul class="nav nav-pills">
                    <li class="active">
                        <a href="#1a" data-toggle="tab">Incapacidades</a>
                    </li>
                    <li>
                        <a href="#2a" data-toggle="tab">Licencias</a>
                    </li>
                    <li>
                        <a href="#3a" data-toggle="tab">Comisiones</a>
                    </li>
                </ul>

                <div class="tab-content clearfix" id="tablas">
                    <div class="tab-pane active" id="1a">
                        <div id="respuestaFiltro">
                            <table id="dtIncapacidad" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Empleado</th>
                                        <th>Jefe Inmediato</th>
                                        <th>Fecha de permiso</th>
                                        <th>Observaciones</th>
                                        <th>Estatus</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="2a">
                        <div id="respuestaFiltro">
                            <table id="dtLicencia" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Empleado</th>
                                        <th>Jefe Inmediato</th>
                                        <th>Fecha de permiso</th>
                                        <th>Observaciones</th>
                                        <th>Estatus</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="3a">
                        <div id="respuestaFiltro">
                            <table id="dtComision" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Folio</th>
                                        <th>Empleado</th>
                                        <th>Jefe Inmediato</th>
                                        <th>Fecha de permiso</th>
                                        <th>Observaciones</th>
                                        <th>Estatus</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>


            <a href="index.php" class="btn btn-default">Salir</a>
        </div>

        <br>
    </body>
</html>
