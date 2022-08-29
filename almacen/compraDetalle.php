<!DOCTYPE html>
<?php
 include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
        
include 'compra.php';
$obj = new compra();

$obj->setIdCompra($_GET['id']);
$obj->setTipoCompra($_GET['t']);
$datosCompra = $obj->consultaDetalleCompra();
$arregloConEntr = $obj->entregaConsulta();
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
        <script>
            var arregloDT = <?php echo json_encode($obj->consultaCompraMaterial()); ?>;
        </script>
        <script type="text/javascript" src="function/compra.js"></script>
        <style>
            hr {
                display: block;
                margin-top: 0.5em;
                margin-bottom: 0.5em;
                margin-left: auto;
                margin-right: auto;
                border: 0.5px solid #eee;
            }
        </style>
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Detalle Compra</h3>
          </div>
            
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th style="text-align: center">Folio Compra</th>
                        <th style="text-align: center">Fecha</th>
                        <th style="text-align: center">Tipo</th>
                        <th style="text-align: center">Recibió</th>
                        <th style="text-align: center">Proveedor</th>
                      </tr>
                    </thead>
                    <tbody align="center">
                      <tr>
                          <td><?php print_r($datosCompra[0][0]); ?></td>
                          <td><?php print_r($datosCompra[0][1]); ?></td>
                          <td><?php print_r($datosCompra[0][2]); ?></td>
                          <td><?php print_r($datosCompra[0][3]); ?></td>
                          <td><?php print_r($datosCompra[0][4]); ?></td>
                      </tr>
                    </tbody>
                </table>
            </div>
            <hr>
            <br>
            <h4 style="text-align: center">Entregas Parciales</h4>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                      <tr>
                        <th style="text-align: center">Num.</th>
                        <th style="text-align: center">Folio Entrega</th>
                        <th style="text-align: center">Fecha</th>
                        <th style="text-align: center">Entregó del Proveedor</th>
                        <th style="text-align: center">Recibió</th>
                        <th style="text-align: center"></th>
                      </tr>
                    </thead>
                    <tbody align="center">
                    <?php 
                    if (is_array($arregloConEntr)) {
                        for ($i = 0; $i < count($arregloConEntr); $i++) {
                            ?>
                            <tr>
                                <td><?php print_r($arregloConEntr[$i][0]); ?></td>
                                <td><?php print_r($arregloConEntr[$i][1]); ?></td>
                                <td><?php print_r($arregloConEntr[$i][2]); ?></td>
                                <td><?php print_r($arregloConEntr[$i][3]); ?></td>
                                <td><?php print_r($arregloConEntr[$i][4]); ?></td>
                                <td><a href="entregaDetalle.php?id=<?php print_r($arregloConEntr[$i][1]); ?>&idC=<?php print_r($obj->getIdCompra()); ?>&t=<?php print_r($obj->getTipoCompra()); ?>"
                                     class="btn btn-primary" role="button">Ver Detalle</a></td>
                            </tr>    
                            <?php
                        }
                    } 
                    ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <br>
            <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id Material</th>
                            <th>Descripción</th>
                            <th>Cantidad en Factura</th>
                            <th>Cantidad Recibida</th>
                            <th>Estatus Final</th>   
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
             <!--tabla de consulta-->
             <a href="compraConsulta.php?tipo=<?php echo $obj->getTipoCompra(); ?>" class="btn btn-primary">Volver a Consulta</a>
             <a href="index.php" class="btn btn-default">Salir</a> 
        </div>
        
        <br>
    </body>
</html>
