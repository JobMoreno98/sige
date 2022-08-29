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
        $pago ->setIdPago($_GET['id']);
        $pago ->pagoModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Pago</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdPago">IdPago:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="IdPago" name="IdPago" value="<?php echo $pago ->getIdPago(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="numDoctoAfin">Núm. Docto. AFIN:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="numDoctoAfin" name="numDoctoAfin" value="<?php echo $pago ->getNumDoctoAfin(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="tipo">Tipo de Trámite:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="tipoTramite" name="tipoTramite" required>
                    <option value="<?php echo $pago ->getTipoTramite(); ?>" selected><?php echo $pago ->getTipoTramite(); ?></option>
                    <option>Compra</option>
                    <option>Recibo</option>
                    <option>Reposición</option>
                    <option>Vale</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="beneficiario">Beneficiario:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="beneficiario"  name="beneficiario" value="<?php echo $pago ->getBeneficiario(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="concepto">Concepto:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="concepto" name="concepto" value="<?php echo $pago ->getConcepto(); ?>"  required>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="noCheque">Núm. Cheque:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="noCheque" name="noCheque" value="<?php echo $pago ->getNoCheque(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="estatus">Estatus:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="estatus" name="estatus" required>
                    <option value="<?php echo $pago ->getEstatus(); ?>" selected><?php echo $pago ->getEstatus(); ?></option>
                    <option>Pagado</option>
                    <option>Sin Pagar</option>
                    <option>CUCSH</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="observaciones" name="observaciones" value="<?php echo $pago ->getObservaciones(); ?>" required>
              </div>
            </div>
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="pagoModificarGuardar">Guardar</button>
                <a href="pagoConsulta.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

