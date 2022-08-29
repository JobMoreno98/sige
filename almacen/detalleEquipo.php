<!DOCTYPE html>
<?php
session_start();
$host= $_SERVER["HTTP_HOST"];
$url= $_SERVER["REQUEST_URI"];
$_SESSION['direccionURL']="http://" . $host . $url;

include 'loginSecurity.php';
    
include_once 'equipo.php';
$equipo = new equipo();
$equipo->setIdEquipo($_GET['id']);
$IdElemento=$_GET['id'];
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Equipos. SIGE. BPEJ</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Valentín Camacho Veloz, Daniel Flores Rodriguez, Brian Valentín Franco, Nancy García Mesillas">
        <!--bootstrap-->
        <link rel="stylesheet" href="../../sige/css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="../../sige/js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="../../sige/js/bootstrap.min.js"></script>
        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="../../sige/css/jquery.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="../../sige/js/jquery.dataTables.js"></script><!-- Editado -->
        <!--Datatables responsive-->
        <link rel="stylesheet" type="text/css" href="../../sige/css/responsive.dataTables.min.css"/>
        <script type="text/javascript" src="../../sige/js/dataTables.responsive.min.js"></script>
        <!--Datatables Buttons-->
        <link rel="stylesheet" type="text/css" href="../../sige/css/buttons.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="../../sige/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="../../sige/js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="../../sige/js/pdfmake.min.js"></script><!--Imprimir PDF-->
        <script type="text/javascript" src="../../sige/js/vfs_fonts.js"></script><!-- Imprimir PDF-->
        <script type="text/javascript" src="../../sige/js/jszip.min.js"></script><!--Imprimir Excel-->
        <script type="text/javascript" src="../../sige/js/buttons.print.min.js"></script><!--Imprimir pantalla-->
        <script>
            var arregloDT = <?php echo json_encode($equipo->consultaFiltroHistorial($IdElemento)); ?>;
            $(document).ready(function(){
                 var t = 'Listado de Equipos';
                $('#dtPlantilla').DataTable( {
                    "data": arregloDT,
                    "order": [[ 2, "desc" ]],
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
                        {
                            extend: 'print',
                            title: t
                        },
                        {
                            extend: 'pdf',
                            title: t
                        },

                        {
                            extend: 'excel',
                            title: t
                        }
                    ]
                });
            });
        </script>
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
         
        <div class="container-fluid">
            <div class="page-header">
                <h3 style="text-align: center">Información del Equipo</h3>
          </div>
            <?php $equipo->datosEquipo();
            if($_SESSION['privilegios'] == 'Sistemas' or $_SESSION['privilegios'] == 'Administrador'){
                echo '<div class="page-header">
                        <h3 style="text-align: center">Listado de Movimientos de Equipos</h3>
                      </div>
                      <!--tabla de consulta-->
                      <div id="respuestaFiltro">
                      <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                      <thead>
                        <tr>
                            <th>Info</th>
                            <th>Equipo</th>
                            <th>IdMovimiento</th>
                            <th>Descripción</th>
                            
                            <th>Área</th>
                            <th>Piso</th>
                            <th>Edificio</th>
                            <th>Usuario</th>
                           
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Núm. Serie</th>
                            <th>IdUDG</th>
                            <th>MAC</th>
                            <th>Tipo Conexión</th>
                            <th>Detalles</th>
                            <th>Img Frente</th>
                            <th>Img Serie</th>';
                             
                             if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {echo '<th>Factura</th>';} 
                             echo '<th>Resguardante</th>';
                            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Dirección') {echo '<th>Modificar</th>';} 
                echo '</tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!--tabla de consulta-->';}?>
             <a href="index.php" class="btn btn-default">Salir</a>    
        </div>
        
        <br>
    </body>
</html>