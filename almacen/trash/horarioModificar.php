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
        
        include 'horario.php';
        $obj = new horario();

        $obj ->setIdHorario($_GET['id']);
        $conHora = $obj->horarioSeleccionModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Horario</h3>
          </div>
          
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
                
                <input type="hidden" name="idHorario" value="<?php echo $obj ->getIdHorario(); ?>">
                
                <div class="form-group">
                  <label class="control-label col-sm-2" for="codigo">Código:</label>
                  <div class="col-sm-10">
                      <input type="number" class="form-control" id="codigo" value="<?php print_r($conHora[0]) ?>" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="entradaLunVie">Hora Entrada Lun-Vie:</label>
                  <div class="col-sm-10">
                      <input type="time" class="form-control" id="entradaLunVie" name="entradaLunVie" value="<?php print_r($conHora[1]) ?>" autofocus required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="salidaLunVie">Hora Salida Lun-Vie:</label>
                  <div class="col-sm-10">
                      <input type="time" class="form-control" id="salidaLunVie" name="salidaLunVie" value="<?php print_r($conHora[2]) ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="entradaSabDom">Hora Entrada Sab-Dom:</label>
                  <div class="col-sm-10">          
                      <input type="time" class="form-control" id="entradaSabDom" name="entradaSabDom" value="<?php print_r($conHora[3]) ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="salidaSabDom">Hora Salida Sab-Dom:</label>
                  <div class="col-sm-10">          
                      <input type="time" class="form-control" id="salidaSabDom" name="salidaSabDom" value="<?php print_r($conHora[4]) ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="entradaVacaciones">Hora Entrada P. Vacacional:</label>
                  <div class="col-sm-10">          
                      <input type="time" class="form-control" id="entradaVacaciones" name="entradaVacaciones" value="<?php print_r($conHora[5]) ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="salidaVacaciones">Hora Salida P. Vacacional:</label>
                  <div class="col-sm-10">          
                      <input type="time" class="form-control" id="salidaVacaciones" name="salidaVacaciones" value="<?php print_r($conHora[6]) ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="comentarios">Comentarios:</label>
                  <div class="col-sm-10">          
                      <input type="text" class="form-control" id="comentarios" name="comentarios" value="<?php print_r($conHora[7]) ?>" maxlength="250" required>
                  </div>
                </div>
                <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" name="horarioModificar">Guardar</button>
                    <a href="periodoVacacionalConsulta.php" class="btn btn-default">Regresar</a>
                    <a href="index.php" class="btn btn-default">Salr</a>
                  </div>
                </div>
                
          </form>
        </div>  
    </body>
</html>
