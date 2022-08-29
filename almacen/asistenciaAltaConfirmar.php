<!DOCTYPE html>
<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
    header('location: index.php');
}
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
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        
        $str = $_POST['datos'];
        $fechaInicio = $_POST['fechaInicio'].' 00:00:00';
        $fechaFin = $_POST['fechaFin'].' 23:59:59';

        $arregloDatos = preg_split("/(\n|\t)/", $str);

        $i = 0;
        $j = 0;
        $arregloMultiDatos = array();
        while($j < count($arregloDatos)){
            $arregloMultiDatos[$i][0] = $arregloDatos[$j++];
            $arregloMultiDatos[$i][1] = $arregloDatos[$j++];
            $arregloMultiDatos[$i][2] =  $arregloDatos[$j++];
            $arregloMultiDatos[$i][3] =  $arregloDatos[$j++];
            $arregloMultiDatos[$i][4] =  $arregloDatos[$j++];
            $arregloMultiDatos[$i][5] =  $arregloDatos[$j++];
            $i++;
        }
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Confirmar Asistencias</h3>
            </div>
            <form action="aplicarMovimiento.php" method="post">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Núm.</th>
                                <th>Código UDG</th>
                                <th>Registro</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>
                        <tbody>

                        <?php
                        $cont = 1;
                        for ($i = 0; $i < count($arregloMultiDatos); $i++) 
                        {
                            $tipo = '';
                            if ($arregloMultiDatos[$i][1] >= $fechaInicio && $arregloMultiDatos[$i][1] <= $fechaFin)//Comprueba que la fecha este dentro de cada registro de periodo
                            {
                                if ($arregloMultiDatos[$i][3] == 0) 
                                {
                                    $tipo = 'Entrada';
                                }
                                else 
                                {
                                    $tipo = 'Salida';
                                }
                                ?>
                                <tr>
                                    <td><input class="form-control" type="text" name="cantidad" value="<?php echo $cont; ?>" readonly></td>
                                    <td><input class="form-control" type="text" name="codigo<?php echo $cont; ?>" value="<?php print_r($arregloMultiDatos[$i][0]); ?>" readonly></td>
                                    <td><input class="form-control" type="text" name="fecha<?php echo $cont; ?>" value="<?php print_r($arregloMultiDatos[$i][1]); ?>" readonly></td>
                                    <td><input class="form-control" type="text" name="tipo<?php echo $cont; ?>" value="<?php echo $tipo; ?>" readonly></td>
                                </tr>
                                <?php
                                $cont++;
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="form-group">        
                    <button type="submit" class="btn btn-primary" name="asistenciaAltaConfirmar">Guardar</button>
                    <a href="asistenciaAlta.php" class="btn btn-default">Regresar</a>
                </div>
            </form>
        </div>
        <br>
    </body>
</html>