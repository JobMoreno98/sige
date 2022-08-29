<!DOCTYPE html>
<?php
 include './loginSecurity.php';
   if ($_SESSION['privilegios'] != 'Administrador') {
    header('location: index.php');
}
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de Desarrollo BPEJ">
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
        ?>
      <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nuevo Usuario</h3>
          </div>

          <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="nombreUsuario">Nombre de Usuario:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" maxlength="100" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="usuario">Nombre de Cuenta:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="usuario" name="usuario" maxlength="50" required>
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
                  <select class="form-control" id="privilegios" name="privilegios" required>
                   <option value="" disabled selected>Sin seleccionar</option>
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
                      <option>Encargado Piso 1</option>
                      <option>Encargado Piso 2</option>
                      <option>Encargado Piso 3</option>
                      <option>Encargado Piso 4</option>
                      <option>Encargado Piso 6</option>
                      <option>Encargado AVS</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="idEmpleado">Empleado:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="idEmpleado" name="idEmpleado" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                   <option value="161">Prestador de Tecnologías</option>
                    <?php $obj->consultaTodosEmpleado(); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="usuarioAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Salir</a>
              </div>
            </div>
          </form>
        </div>
    </body>
</html>
