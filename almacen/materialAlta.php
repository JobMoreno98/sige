<?php
include './loginSecurity.php';
   if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
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
         
         include 'material.php';
         $material = new material();
         ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Capturar Nuevo Material</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
                <label class="control-label col-sm-2" for="descripcion">Descripci&oacute;n:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="150" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="tipo">Tipo de Material:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="tipo" name="tipo" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <option>Limpieza</option>
                    <option>Papeler&iacute;a</option>
                </select>
              </div>
            </div>
             <div class="form-group">
                 <label class="control-label col-sm-2" for="stock">Stock M&iacute;nimo:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="stock" name="stock" min="0" max="1000000" required>
                </div>
            </div>
             <div class="form-group">
                <label class="control-label col-sm-2" for="caducidad">Tiempo de Caducidad:</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" id="caducidad" name="caducidad" min="1" max="30" data-toggle="tooltip" data-placement="right" title="Duración en Años" required>
                </div>
            </div>
             <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="materialAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html> 
