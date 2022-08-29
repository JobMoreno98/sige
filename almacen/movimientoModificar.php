<?php
session_start();
include_once './loginSecurity.php';
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
        include_once 'movimiento.php';
        include_once 'pago.php';
        $movimiento=new movimiento();
        $movimiento->setIdMovimiento($_GET[id]);
        $movimiento->movimientoModificar();
        $pago=new pago();
        $pago->setAnio(2018);
        $pago->setIdCuenta($movimiento->getIdCuenta());
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Movimiento<small><br>Esta opción permite modificar un movimiento a la vez, si necesita revertir un cargo-abono, favor de modificar ambos movimientos y escribir CERO en ambos</small></h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdMovimiento">IdMovimiento:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="IdMovimiento" name="IdMovimiento" step="any" value="<?php echo $movimiento->getIdMovimiento();?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdCuenta">Cuenta: </label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdCuenta" name="IdCuenta" readonly>
                    <?php $pago->cuentaEspecifica(); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="tipoMovimiento">Tipo de Movimiento:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="tipoMovimiento" name="tipoMovimiento" value="<?php echo $movimiento->getTipoMovimiento();?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="monto">Monto (Sin signo ni comas):</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="monto" name="monto" step="any" value="<?php echo $movimiento->getMontoMovimiento();?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="observaciones" name="observaciones" value="<?php echo $movimiento->getObservaciones();?>" required>
              </div>
            </div>
  
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="movimientoModificacionGuardar">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

