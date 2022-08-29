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
        
        include 'factura.php';
        $factura = new factura();
        $factura ->setIdFactura($_GET['id']);
        $factura->facturaModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Factura</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdFactura">IdWeb Factura:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="IdFactura" name="IdFactura" value="<?php echo $factura ->getIdFactura(); ?>" readonly>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="folioFactura">Núm. Folio Factura:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="folioFactura" name="folioFactura" value="<?php echo $factura ->getFolioFactura(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdProveedor">Proveedor:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdProveedor" name="IdProveedor" required>
                    <?php $factura->proveedoresListado($factura ->getIdProveedor()); ?>
                     <option value="" disabled>Listado de Proveedores</option>
                    <?php $factura->proveedoresListado(0); ?>
                  
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="fechaFactura">Fecha Factura:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="fechaFactura"  name="fechaFactura" value="<?php echo $factura ->getFechaFactura(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="montoFactura">Monto Factura:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="montoFactura" name="montoFactura" value="<?php echo $factura ->getMontoFactura(); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdPago">Pago Relacionado: </label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdPago" name="IdPago" required>
                    <?php $factura->pagosListado($factura ->getIdPago()); ?>
                     <option value="" disabled>Listado de Pagos</option>
                    <?php $factura->pagosListado(0); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pdfFactura">PDF Factura</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="pdfFactura" name="pdfFactura" value="<?php echo $factura ->getPdfFactura(); ?>" required>
              </div>
            </div>

              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="facturaModificarGuardar">Guardar</button>
                <a href="aplicarMovimiento.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

