<!DOCTYPE html>
<?php
include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
include 'suplencia.php';
$obj = new suplencia();
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
        <script>
            var arregloDT = <?php echo json_encode($obj->consultaSuplencia()); ?>;
        </script>
        <script type="text/javascript" src="function/suplencia.js"></script>
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
    
        ?>
        
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Listado de Suplencias</h3>
          </div>
            <!--Filtro avanzado-->
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
                      <center><form class="form-inline" id="filtros" method="POST">
                  <div class="form-group">
                       <label for="filtro1"><?php echo $obj ->getTitulo2(); ?>:</label>
                       <input type="number" class="form-control input-sm" name="filtro1" id="filtro1" placeholder="Buscar <?php echo $obj ->getTitulo2(); ?>">
                       </div>
                   <div class="form-group">
                        <label for="filtro2"><?php echo $obj ->getTitulo3(); ?>:</label>
                        <input type="text" class="form-control input-sm" name="filtro2" id="filtro2" placeholder="Buscar <?php echo $obj ->getTitulo3(); ?>">
                        </div>
                   <div class="form-group">
                        <label for="filtro3"><?php echo $obj ->getTitulo4(); ?>:</label>
                        <input type="text" class="form-control input-sm" name="filtro3" id="filtro3" placeholder="Buscar <?php echo $obj ->getTitulo4(); ?>">
                        </div>
                   <div class="form-group">
                       <label for="filtro4"><?php echo $obj ->getTitulo5(); ?>:</label>
                       <input type="number" class="form-control input-sm" name="filtro4" id="filtro4" placeholder="Buscar <?php echo $obj ->getTitulo5(); ?>">
                        </div> 
                    <div class="form-group">
                        <label for="filtro5"><?php echo $obj ->getTitulo8(); ?>:</label>
                        <input type="number" class="form-control input-sm" name="filtro5" id="filtro5" placeholder="Buscar <?php echo $obj ->getTitulo8(); ?>">
                    </div>
                 </form></center>
                       <br>
                <button type="button" class="btn btn-default btn-sm" id="limpiar">
                <span class="glyphicon glyphicon-erase"></span> Limpiar B&uacute;squeda</button>
                    </div>
                  </div>
                </div>
              </div>
             <!--Filtro avanzado-->
             <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <?php $obj->titulosSuplencia(); ?>
                    </thead>
                    <tfoot>
                        <?php $obj->titulosSuplencia(); ?>
                    </tfoot>
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