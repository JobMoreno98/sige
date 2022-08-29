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
      
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nueva Factura</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" enctype="multipart/form-data" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="folioFactura">Núm. Folio Factura:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="folioFactura" name="folioFactura" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdProveedor">Proveedor:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdProveedor" name="IdProveedor" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                   <?php $factura->proveedoresListado(0); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="fechaFactura">Fecha Factura:</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" id="fechaFactura"  name="fechaFactura" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="montoFactura">Monto Factura:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="montoFactura" name="montoFactura" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdPago">Pago Relacionado: </label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdPago" name="IdPago" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                    <?php 
                      if(isset($_GET['anio']) && $_GET['anio']!=''){
                        $factura->pagosListado(0, $_GET['anio']);     
                      }else {
                          $factura->pagosListado(0, 2018);     
                      }
                      
                      ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="pdfFactura">PDF Factura</label>
              <div class="col-sm-10">
                  <input class="form-control" type="file" id="pdfFactura" name="pdfFactura" required>
              </div>
            </div>

              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="facturaAlta">Guardar</button>
                <a href="facturaConsulta.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

