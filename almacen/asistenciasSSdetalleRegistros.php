<!DOCTYPE html>
<?php
date_default_timezone_set("Mexico/General"); 
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Prestadores') {
    header('location: index.php');
}
include_once 'servicioSocial.php';
$servicioSocial = new servicioSocial();
$servicioSocial->setCodigo($_GET['codigo']);

include_once 'asistenciasSS.php';
$asistenciasSS = new asistenciasSS();
$asistenciasSS->setCodigo($_GET['codigo']);
if(isset($_POST['date1']) && $_POST['date1']!='' && isset($_POST['date2']) && $_POST['date2']!=''){
    $asistenciasSS->setFechaInicioFiltro($_POST['date1']);
    $asistenciasSS->setFechaFinFiltro($_POST['date2']);
    $asistenciasSS->setCodigo($_POST['codigo']);
    $servicioSocial->setCodigo($_POST['codigo']);
}
$asistenciasSS->cargarAsistencias();

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Detalle de Registros de Prestadores de Servicio Social, Prácticas y Voluntarios. SIGE. BPEJ</title>
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
        
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
         <div class="container">
        <h3><center>Consultas</center></h3><!-- Título de módulo -->
           
   
             <!--Filtro avanzado-->
             <div class="row">
                 <div class="col-xs-12 ">
                      
                     <?php
                $servicioSocial->servicioSocialConsultaIndividual();
             ?>
             </div>
        </div>
         <div class="row">
<div class="col-xs-12 ">
    <center><a href="asistenciasSSdetalleRegistros.php?codigo=<?php echo $asistenciasSS->getCodigo();?>" class="btn btn-default">Ver detalle completo de Registros</a><a href="registroHoraManual.php?codigo=<?php echo $asistenciasSS->getCodigo();?>" class="btn btn-default">Agregar Registro</a>  </center>
            <?php $asistenciasSS->mostrarRegistrosPorDiaDetalle();

            ?>
</div>
        </div>
        <br>
        </div>
        <a href="prestadoresConsulta.php" class="btn btn-default">Salir</a>   
    </body>
</html>