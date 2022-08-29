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
        include_once 'pago.php';
        $pago=new pago();

        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nuevo Movimiento Entre Cuentas</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdCuentaOrigen">Cuenta Origen (Cargo):</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdCuentaOrigen" name="IdCuentaOrigen" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                    <?php $pago->cuentasListado(); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdCuentaDestino">Cuenta Destino (Abono):</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdCuentaDestino" name="IdCuentaDestino" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                    <?php $pago->cuentasListado(); ?>
                  </select>
              </div>
            </div>
                <div class="form-group">
              <label class="control-label col-sm-2" for="monto">Monto (Sin signo ni comas):</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="monto" name="monto" step="any" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="observaciones" name="observaciones" value="-" required>
              </div>
            </div>
  
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="movimientoAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

