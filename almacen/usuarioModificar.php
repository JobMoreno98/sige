<!DOCTYPE html>
<?php
 include './loginSecurity.php';
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
        
        include 'usuario.php';
        $obj = new usuario();

        $obj ->setIdUsuario($_GET['id']);
        $arregloUsMod = $obj->usuarioSeleccionModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar usuario</h3>
          </div>
          
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
            <?php // $obj->usuarioSeleccionModificar() ?>
                
                
                <div class="form-group">
              <label class="control-label col-sm-2" for="idUsuario">ID usuario:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="idUsuario" name="idUsuario" value="<?php print_r($arregloUsMod[0]) ?>" readonly>
              </div>
            </div>
                <div class="form-group">
              <label class="control-label col-sm-2" for="nombreUsuario">Nombre de usuario:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" maxlength="100" value="<?php print_r($arregloUsMod[1]) ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="usuario">Nombre de cuenta:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="usuario" name="usuario" maxlength="50" value="<?php print_r($arregloUsMod[2]) ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="password">Contraseña:</label>
              <div class="col-sm-10">          
                <input type="password" class="form-control" id="password" name="password" maxlength="50" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="privilegios">Privilegios:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="privilegios" name="privilegios">
                      <option><?php print_r($arregloUsMod[3]) ?></option>
                      <option>Administrador</option>
                      <option>Auxiliar</option>
                      <option>Sistemas</option>
                      <option>Prestadores</option>
                      <option>Dirección</option>
                      <option>RH-Almacen</option>
                      <option>Encargado Almacén</option>
                      <option>Ayudante Almacén</option>
                      <option>Coordinador</option>
                      <option>Recursos Humanos</option>
                      <option>General</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="idEmpleado">Empleado:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="idEmpleado" name="idEmpleado">
                      <option value="<?php print_r($arregloUsMod[4]) ?>"><?php print_r($arregloUsMod[4]) ?> - <?php print_r($arregloUsMod[5]) ?></option>
        
        <?php $obj->consultanombreEmpleado(); ?>
        </select>
              </div>
            </div>
                
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="usuarioModificar">Guardar</button>
                <a href="usuarioConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salr</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>
