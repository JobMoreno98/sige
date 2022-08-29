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
        ?>
      <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Horario de Personal</h3>
          </div>
          
          <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="entradaLunVie">Hora Entrada Lun-Vie:</label>
              <div class="col-sm-10">
                  <input type="time" class="form-control" id="entradaLunVie" name="entradaLunVie" autofocus required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="salidaLunVie">Hora Salida Lun-Vie:</label>
              <div class="col-sm-10">
                  <input type="time" class="form-control" id="salidaLunVie" name="salidaLunVie" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="entradaSabDom">Hora Entrada Sab-Dom:</label>
              <div class="col-sm-10">          
                  <input type="time" class="form-control" id="entradaSabDom" name="entradaSabDom" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="salidaSabDom">Hora Salida Sab-Dom:</label>
              <div class="col-sm-10">          
                  <input type="time" class="form-control" id="salidaSabDom" name="salidaSabDom" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="entradaVacaciones">Hora Entrada P. Vacacional:</label>
              <div class="col-sm-10">          
                  <input type="time" class="form-control" id="entradaVacaciones" name="entradaVacaciones" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="salidaVacaciones">Hora Salida P. Vacacional:</label>
              <div class="col-sm-10">          
                  <input type="time" class="form-control" id="salidaVacaciones" name="salidaVacaciones" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="comentarios">Comentarios:</label>
              <div class="col-sm-10">          
                  <input type="text" class="form-control" id="comentarios" name="comentarios" value="-" maxlength="250" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="codigo">Personal:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="codigo" name="codigo" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $obj->consultaPersonalSinHorario(); ?>
                  </select>
              </div>
            </div>  
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="horarioAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Salir</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>
