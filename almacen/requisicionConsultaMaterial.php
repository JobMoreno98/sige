<!DOCTYPE html>
<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'Ayudante Almacén' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Dirección') {
    header('location: index.php');
}
include 'barraMenu.php';
$menu = new menu();

date_default_timezone_set("America/Mexico_City");

include 'requisicion.php';
$obj = new requisicion();
$obj->setIdMaterial($_GET['id']);
$obj->setFechaRequisicion("0000-00-00");
$obj->setCantidad(date("Y-m-d"));
$mater = $obj->consultaDatosMaterial();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de Desarrollo BPEJ">
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
            var fechaActual = '<?php echo date("Y-m-d"); ?>';
            var t = 'Detalle de Entregas por Artículo';
            var arregloDT = <?php echo json_encode($obj->consultaSalidasPorMaterial()); ?>;
        </script>
        <script type="text/javascript" src="function/requisicionConsultaMaterial.js"></script>
    </head>
    <body>
        <?php
        $menu ->barraMenu();
        ?>
        
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Detalle de Entregas por Artículo <small><?php print_r($mater[1]); ?></small></h3>
          </div>
            
                <table class="table">
                    <thead>
                      <tr>
                        <th style="text-align: center">ID Mat.</th>
                        <th style="text-align: center">Descripción</th>
                        <th style="text-align: center">Stock Minimo</th>
                        <th style="text-align: center">Años Cad.</th>
                        <th style="text-align: center">Inventario Inicial</th>
                        <th style="text-align: center">Entradas</th>
                        <th style="text-align: center">Salidas</th>
                        <th style="text-align: center">Existencias</th>
                        <th style="text-align: center">Nivel Exist.</th>
                        <th style="text-align: center">Uso</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <tr>
                          <td><?php echo $obj->getIdMaterial(); ?></td>
                          <td><?php print_r($mater[0]); ?></td>
                          <td><?php print_r($mater[2]); ?></td>
                          <td><?php print_r($mater[3]); ?></td>
                          <td><?php echo $obj->consultaInventarioInicial(); ?></td>
                          <td><?php echo $obj->consultaEntradasMaterial(); ?></td>
                          <td><?php echo $obj->consultaSalidasMaterial(); ?></td>
                          <td><?php print_r($mater[4]); ?></td>
                          <td><?php print_r($mater[5]); ?></td>
                          <td><?php print_r($mater[6]); ?></td>
                      </tr>
                    </tbody>
                </table>
            <br>
            
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
                              <input type="hidden" name="id" value="<?php echo $obj ->getIdMaterial(); ?>">
                  <div class="form-group">
                       <label for="filtro1">Fecha inicial:</label>
                       <input type="date" class="form-control input-sm" name="filtro1" id="filtro1" value="0000-00-00" required="date">
                       </div>
                   <div class="form-group">
                        <label for="filtro2">Fecha final:</label>
                        <input type="date" class="form-control input-sm" name="filtro2" id="filtro2" value="<?php echo date("Y-m-d");?>" required="date">
                        </div>
                   <div class="form-group">
                        <label for="filtro3"><?php echo $obj ->getTitulo7(); ?>:</label>
                        <input type="text" class="form-control input-sm" name="filtro3" id="filtro3" placeholder="Buscar <?php echo $obj ->getTitulo7(); ?>">
                        </div>
                        
                 </form></center>
                       <br>   
                            <button type="button" class="btn btn-primary btn-sm" id="filtrar">
                        <span class="glyphicon glyphicon-search"></span> Buscar</button>
                        
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
                        <tr>   
                            <th>ID Req.</th>      
                            <th>Folio</th>      
                            <th>Fecha</th>      
                            <th>Área</th>      
                            <th>Piso</th>      
                            <th>Edificio</th>      
                            <th>Cantidad</th>         
                            <th>Mostrar</th>         
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right">Suma de registros:</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>
            </div>
             <!--tabla de consulta-->
             <a href="materialConsulta.php?t=<?php print_r($mater[1]) ?>" class="btn btn-default">Regresar</a>    
             <a href="index.php" class="btn btn-default">Salir</a>    
        </div>
        
        <br>
    </body>
</html>