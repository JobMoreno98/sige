<!DOCTYPE html>
<?php
 include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
include 'compra.php';
$obj = new compra();
$obj->setTipoCompra($_GET['tipo']);
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
            var arregloDT = <?php echo json_encode($obj->consultaCompra()); ?>;
        </script>
        <script type="text/javascript" src="function/compra.js"></script>
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Listado de Compras <small><?php echo $obj->getTipoCompra(); ?></small></h3>
          </div>
            
            <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <?php $obj->titulosCompra(); ?>
                    </thead>
                    <tfoot>
                        <?php $obj->titulosCompra(); ?>
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
