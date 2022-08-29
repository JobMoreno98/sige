<!DOCTYPE html>
<?php
date_default_timezone_set("Mexico/General"); 

session_start();
include '../sige/loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Prestadores' ) {
    header('location: index.php');
}
include_once '../sige/asistenciasSS.php';
$asistenciasSS = new asistenciasSS();
$asistenciasSS->setCodigo($_GET['codigo']);
$asistenciasSS->setIdPrestacion($_GET['prestacion']);
if(isset($_POST['date1']) && $_POST['date1']!='' && isset($_POST['date2']) && $_POST['date2']!=''){
    $asistenciasSS->setCodigo($_POST['codigo']);
    $asistenciasSS->setIdPrestacion($_POST['IdPrestacion']);
    $asistenciasSS->setFechaInicioFiltro($_POST['date1']);
    $asistenciasSS->setFechaFinFiltro($_POST['date2']);
}


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
        <h3><center>Horas Realizadas </center></h3><!-- Título de módulo -->
          <?php $asistenciasSS->servicioSocialConsultaIndividual();
          ?><a href="prestadoresConsulta.php" class="btn btn-default">< Regresar </a> <a href="registroHoraManual.php?codigo=<?php echo $asistenciasSS->getCodigo(); ?>" class="btn btn-default">Registro Hora Manual</a> 
             <!--Filtro avanzado-->
            <div class="panel-group">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1"><center>Filtrar por Rango de Fechas 
                                <span class="glyphicon glyphicon-triangle-bottom"></span></center></a>
                    </h4>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                    <form class="form-inline"  name="formulario" id="frmNewReq" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                            <div class="form-group">  
                                <label for="codigo"> Código</label>
                                <input type="number" class="form-control" id="codigo" name="codigo" placeholder="Código" value="<?php echo $asistenciasSS->getCodigo();?>" readonly>
                            </div> 
                            <div class="form-group">  
                                <label for="IdPrestacion"> IdPrestación</label>
                                <input type="number" class="form-control" id="IdPrestacion" name="IdPrestacion" placeholder="IdPrestacion" value="<?php echo $asistenciasSS->getIdPrestacion();?>"  readonly>
                            </div> 
                        <div class="form-group">
                                <label for="date1"> Fecha Inicial </label>
                                <input type="date" class="form-control" id="date1" name="date1" placeholder="Fecha">
                            </div>
                        <div class="form-group">
                            <label for="date2"> Fecha Final </label>
                            <input type="date" class="form-control" id="date2" name="date2" placeholder="Fecha">
                        </div>
            <div class="form-group">
                 
                <input type="hidden" class="form-control" id="codigo" name="codigo" placeholder="Fecha" value="<?php echo $asistenciasSS->getCodigo();?>">
                        </div>
                        <button type="submit" class="btn btn-default">Filtrar</button>
                        <br>
                        <hr>
                    </form>
                       
                    </div>
                  </div>
                </div>
              </div>
             <!--Filtro avanzado-->
             
             <div class="row">
                 <div class="col-xs-12 ">
                      
                     <?php
                
                $asistenciasSS->cargarAsistencias();
             ?>
             </div>
        </div>
             <div class="row">
        <div class="col-md-11">
            <div class="alert alert-danger"><button class="close" data-dismiss="alert"><span>&times;</span></button>
                <strong>Esta informaci&oacute;n es de car&aacute;cter informativo. Bajo ninguna circunstancia se debe tomar como comprobante de Horas. El conteo final definitivo ser&aacute; dado por el &aacute;rea de Servicio Social.</strong>
            </div>
           
            </div>
        </div>
         <div class="row">
<div class="col-xs-12 ">
    
            <?php $asistenciasSS->mostrarRegistrosPorDia();

            ?>
</div>
        </div>
        <br>
        </div>
       
    </body>
</html>