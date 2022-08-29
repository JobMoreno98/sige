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
        
        include 'pago.php';
        $pago = new pago();
        $pago ->setIdRelPagoCuenta($_GET['id']);
        $pago->detalleCargoPorPagoModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Detalle Pago</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdRelPagoCuenta">IdWeb:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="IdRelPagoCuenta" name="IdRelPagoCuenta" value="<?php echo $pago ->getIdRelPagoCuenta(); ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdPago">IdPago:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="IdPago" name="IdPago" value="<?php echo $pago ->getIdPago(); ?>" readonly="">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="numDoctoAfin">Núm. AFIN:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="numDoctoAfin" name="numDoctoAfin" value="<?php echo $pago ->getNumDoctoAfin(); ?>" readonly>
              </div>
            </div>  
            <div class="form-group">
              <label class="control-label col-sm-2" for="tipoTramite">Trámite :</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="tipoTramite" name="tipoTramite" value="<?php echo $pago ->getTipoTramite(); ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="concepto">Concepto:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="concepto" name="concepto" value="<?php echo $pago ->getConcepto(); ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdCuenta">Cuenta:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdCuenta" name="IdCuenta" required>
                      <?php echo $pago ->muestraCuentaEspecifica()?>
                      <option value="Elegir Otra Cuenta"  disabled="">Elegir Otra Cuenta -------</option>
                      <option value="<?php echo $pago ->cuentasListado()?>"  selected><?php //echo $pago ->cuentasListado(); ?></option>

                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="monto">Monto:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="monto" name="monto" value="<?php echo $pago ->getMonto(); ?>" >
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="estatusDetalle">Eliminar:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="estatusDetalle" name="estatusDetalle" required>
                      <option value="<?php echo $pago ->getEstatusDetalle(); ?>"  selected><?php echo $pago ->getEstatusDetalle(); ?></option>
                      <option value="No Activo">No Activo</option>

                  </select>
              </div>
            </div>
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="cargoPorPagoModificarGuardar">Guardar</button>
                <a href="cuentaConsulta.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

