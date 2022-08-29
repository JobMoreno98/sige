<?php
session_start();
include '../sige/loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Finanzas' and $_SESSION['privilegios'] != 'Dirección') {
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
        
        include 'cuenta.php';
        $cuenta = new cuenta();
        $cuenta ->setIdCuenta($_GET['id']);
        $cuenta->cuentaModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Cuenta</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdCuenta">IdWeb:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="IdCuenta" name="IdCuenta" value="<?php echo $cuenta ->getIdCuenta(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="COG">COG:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="COG" name="COG" value="<?php echo $cuenta ->getCOG(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="anio">Año:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="anio" value="2018" name="anio" value="<?php echo $cuenta ->getAnio(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo $cuenta ->getDescripcion(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="tipo">Tipo:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="tipo" name="tipo" required>
                    <option value="<?php echo $cuenta ->getTipo(); ?>"  selected><?php echo $cuenta ->getTipo(); ?></option>
                    <option>Servicios Fijos</option>
                    <option>Servicios Variables</option>
                  </select>
              </div>
            </div>
  
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="cuentaModificarGuardar">Guardar</button>
                <a href="cuentaConsulta.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

