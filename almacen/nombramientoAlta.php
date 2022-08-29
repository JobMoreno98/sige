<!DOCTYPE html>
<?php
 include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
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
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Captura Nuevo Nombramiento</h3>
            </div>
            
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="nombramiento">Nombre:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="nombramiento" name="nombramiento" maxlength="100" required>
              </div>
            </div>
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="nombramientoAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Salir</a>
              </div>
            </div>
          </form>
        </div>
        <br>
    </body>
</html>