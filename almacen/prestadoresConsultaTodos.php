<?php
session_start();
include '../sige/loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Prestadores' ) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
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
        <script type="text/javascript" src="function/area.js"></script>
    </head>
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
       
      
        include 'prestadores.php';
        $con = new prestadores();
        
//        Guarda en cada consulta el valor % para anular los filtros y así mostrar la tabla completa
        $con ->setFiltro1("%");
        $con ->setFiltro2("%");
        $con ->setFiltro3("%");
        $con ->setFiltro4("%");
        ?>
        <div class="container-fluid">
           
            <h3><center>Consultas</center></h3><!-- Título de módulo -->
            <h3><center><a href="altaPrestador.php">Agregar Prestador</a></center></h3><!-- Título de módulo -->
             <!--Filtro avanzado
            <div class="panel-group">
                <div class="panel panel-primary">
                  <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" href="#collapse1"><center>B&uacute;squeda avanzada 
                                <span class="glyphicon glyphicon-triangle-bottom"></span></center></a>
                    </h4>
                  </div>
                  <div id="collapse1" class="panel-collapse collapse">
                    <div class="panel-body">
                        <form class="form-inline" id="filtroComboBox" method="POST">
                            <div id="respuestaComboFiltro">
                                <?php //$con ->comboBoxFiltro(); ?>
                            </div>
                        </form>
                        <br>
                        <button type="button" class="btn btn-default btn-sm" id="limpiar">
                            <span class="glyphicon glyphicon-erase"></span> Borrar B&uacute;squeda</button>
                    </div>
                  </div>
                </div>
              </div>
             <!--Filtro avanzado-->
            
            <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <?php $con ->tituloConsultaTodos(); ?>
                    </thead>
                    <tfoot>
                        <?php $con ->tituloConsultaTodos(); ?>
                    </tfoot>
                    <tbody>
                            <?php $con ->consultaFiltro(); ?>
                    </tbody>
                </table>
            </div>
             <!--tabla de consulta-->
             
        </div>
        <br>
        <!--Desarrollado por: Carlos Valentín Camacho Veloz-->
    </body>
</html>
