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

        include 'horarioCumplir.php';
        $obj = new horarioCumplir();
        $obj->setIdEmpleado($_GET['id']);
        $arregloHorarioMod=$obj->horarioModificar();

        ?>
        <div class="container-fluid">
            <div class="page-header">
                <h3 align="center">Modificar Horario de Personal</h3>
            </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                <table class="table table-bordered table-striped table-responsive">
                    <thead>
                        <tr>
                            <th style="text-align: center">Horario</th>
                            <?php
                                $dias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo", "Vacacional");
                                for ($i = 0; $i < 8; $i++){
                                    echo '<th style="text-align: center" id="dia" required>'.$dias[$i].'</th>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="container-fluid">
                                        <label class="control-label" for="entrada">Hora Entrada:</label>
                                    </div>
                                </div>
                            </td>
                            <?php
                                for ($i = 0; $i < 8; $i++){
                                    echo '
                                        <td>
                                            <div class="form-group">
                                                <div class="container-fluid">
                                                    <input class="form-control" id="entrada'.$i.'" type="time" name="entrada'.$i.'" value="'.$arregloHorarioMod[$i][0].'">
                                                </div>
                                            </div>
                                        </td>
                                    ';
                                }
                            ?>
                        </tr>
                        <tr>
                            <td>
                                <div class="form-group">
                                    <div class="container-fluid">
                                        <label class="control-label" for="salida">Hora Salida:</label>
                                    </div>
                                </div>
                            </td>
                            <?php
                                for ($i = 0; $i < 8; $i++){
                                    echo '
                                        <td>
                                            <div class="form-group">
                                                <div class="container-fluid">
                                                    <input class="form-control" id="salida'.$i.'" type="time" name="salida'.$i.'" value="'.$arregloHorarioMod[$i][1].'">
                                                </div>
                                            </div>
                                        </td>
                                    ';
                                }
                           ?>
                        </tr>
                    </tbody>
                </table>
                <div class="container">
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="comentarios">Comentarios:</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="comentarios" name="comentarios" value="<?php print_r($arregloHorarioMod[2][2]) ?>" maxlength="280" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-2" for="IdEmpleado">Personal:</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="IdEmpleado" name="IdEmpleado" required>
                                <option class="btn disabled" value="IdEmpleado"><?php echo $arregloHorarioMod[3][3]; ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" name="horarioModificarGuardar">Guardar</button>
                            <a href="index.php" class="btn btn-default">Salir</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
