<?php
session_start();
include 'loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas') {
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
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        
        include_once 'mueble.php';
        $mueble = new mueble();
        
        include_once 'empleado.php';
        $empleado=new empleado();
        
        include_once 'area.php';
        $area=new area();
        
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nueva Mueble</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdUdG">Id UdeG:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="IdUdG" name="IdUdG" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdEmpleado">Resguardante:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdEmpleado" name="IdEmpleado" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                  <?php $empleado->listarEmpleados();  ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdArea">Área:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdArea" name="IdArea" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                  <?php $area->listarAreas(); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdCatalogoM">Catálogo:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdCatalogoM" name="IdCatalogoM" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                  <?php $mueble->listarCatalogoM(); ?>
                  </select>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="detalles">Detalles:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="detalles" name="detalles" required>
              </div>
            </div>
           
  
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="muebleAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

