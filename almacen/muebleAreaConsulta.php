<!DOCTYPE html>
<?php
 include './loginSecurity.php';

include 'mueble.php';
$obj = new mueble();

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Mobiliario. SIGE. BPEJ</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de Desarrollo BPEJ">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
         </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h3 style="text-align: center">Listado de Muebles por Resguardante</h3>
          </div>
             <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>IdMobiliario</th>
                            <th>IdUdeG</th>
                            
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Medidas</th>
                            <th>Área</th>
                            <th>Piso</th>
                            <th>Edificio</th>
                            <th>Código Resg.</th>
                            <th>Resguardante</th>
                            <th>Frente</th>
                            <th>Lateral</th>
                            <th>Ficha Técnica</th>
                             <?php
                            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas'){
                                echo "<th>IdTipo SIIAU</th>";
                                echo "<th>Acción</th>";
                            }
                            ?>
                            
                            
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