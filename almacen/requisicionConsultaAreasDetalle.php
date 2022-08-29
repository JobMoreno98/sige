<!DOCTYPE html>
<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Dirección') {
    header('location: index.php');
}
include 'barraMenu.php';
$menu = new menu();


include 'requisicion.php';
$obj = new requisicion();
$obj->setIdArea($_GET['id']);
$obj->setTipo($_GET['tipo']);
$areaDat = $obj->consultaDatosArea();
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
            var t = 'Detalle de Entregas por Coordinación';
            var arregloDT = <?php echo json_encode($obj->consultaEntregasPorArea()); ?>;
        </script>
        <script type="text/javascript" src="function/materialPorCaducar.js"></script>
    </head>
    <body>
        <?php
        $menu ->barraMenu();
        ?>
        
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Detalle de Entregas por Coordinación <small><?php echo $obj->getTipo(); ?></small></h3>
          </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th style="text-align: center">ID Área</th>
                        <th style="text-align: center">Área</th>
                        <th style="text-align: center">Piso</th>
                        <th style="text-align: center">Edificio</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <tr>
                          <td><?php echo $obj->getIdArea(); ?></td>
                          <td><?php print_r($areaDat[0]); ?></td>
                          <td><?php print_r($areaDat[1]); ?></td>
                          <td><?php print_r($areaDat[2]); ?></td>
                      </tr>
                    </tbody>
                </table>
            </div>
            <br>
            
             <!--tabla de consulta-->
            
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>   
                            <th>ID Req.</th>      
                            <th>Folio Req.</th>      
                            <th>Fecha</th>      
                            <th>ID Material</th>        
                            <th>Descripción</th>         
                            <th>Cantidad</th>         
                            <th>Mostrar</th>         
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>   
                            <th>ID Req.</th>      
                            <th>Folio Req.</th>      
                            <th>Fecha</th>      
                            <th>ID Material</th>        
                            <th>Descripción</th>         
                            <th>Cantidad</th>         
                            <th>Mostrar</th> 
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
             <!--tabla de consulta-->  
             <a href="requisicionConsultaAreas.php?tipo=<?php echo $obj->getTipo(); ?>" class="btn btn-default">Regresar</a>    
             <a href="index.php" class="btn btn-default">Salir</a>    
        </div>
        
        <br>
    </body>
</html>