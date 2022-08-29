<!DOCTYPE html>
<?php

session_start();
include '../sige/loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Finanzas' and $_SESSION['privilegios'] != 'Dirección') {
    header('location: index.php');
}

include 'pago.php';
$pago = new pago();
if (isset($_GET['id']) && $_GET['id']!='') { 
    $pago ->setIdCuenta($_GET['id']);
  
    //$titulo="Pagos por Cuenta";
    //$montoTotal=$obj ->pagoSumaConsulta($_GET['id']);
}/*else{
    $obj ->setAnio($_GET['anio']);
    $titulo="Listado de todos los pagos";
    $montoTotal=$obj ->pagoSumaConsulta(0);
}
 */   
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Finanzas. SIGE. BPEJ</title>
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
        <script>
            var arregloDT = <?php echo json_encode($pago->pagoConsulta()); ?>;
            $(document).ready(function(){
                 var t = 'Listado de Pagos';
                $('#dtPlantilla').DataTable( {
                    "data": arregloDT,
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
        include '../sige/barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h3 style="text-align: center"><?php echo $titulo; 
                    echo "<br><br>";
                    echo "Listado General de Pagos";
                    //echo "Total de Pagos ".'$ '.number_format($montoTotal,2,'.',','); ?></h3>
          </div>
             <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>IdPago</th>
                            <th>Núm. Docto. Afin</th>
                            <th>Tipo Trámite</th>
                            <th>Beneficiario</th>
                            <th>Concepto</th>
                            <th>Monto</th>  
                            <th>Núm. Cheque</th>
                            <th>Estatus</th>
                            <th>Observaciones</th>   
                            <th></th> 
                            
                            
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
             <!--tabla de consulta-->
             <a href="index.php" class="btn btn-default">Salir</a>    
        </div>
        
        <br>
    </body>
</html>