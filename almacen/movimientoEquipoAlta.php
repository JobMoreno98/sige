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
        <script>
            $(document).ready(function() {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>
    <body>
         <?php 
        date_default_timezone_set("America/Mexico_City");
        $hoy=getdate();
        
         include 'barraMenu.php';
         $menu = new menu();
         $menu ->barraMenu();
         
         include 'equipo.php';
         $equipo = new equipo();
         ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Capturar Nuevo Movimiento de Equipo</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
                 <label class="control-label col-sm-2" for="fecha">Fecha:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="fecha" name="fecha" value="<?php echo $hoy['year']."/".$hoy['mon']."/".$hoy['mday']; ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="solicitante">Solicitante:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="solicitante" name="solicitante" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $equipo->listarEmpleado(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="equipo">Listado de Equipos y Ubicación Actual:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="equipo" name="equipo" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $equipo->listarEquipos(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="area">Área a trasladar:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="area" name="area" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $equipo->listarAreas(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="resguardante">Resguardante:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="resguardante" name="resguardante" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $equipo->listarEmpleado(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="usuario">Usuario:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="usuario" name="usuario" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $equipo->listarUsuario(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="comentarios">Comentarios:</label>
                <div class="col-sm-10">
                <input type="text" class="form-control" id="comentarios" name="comentarios" maxlength="250" required>
                </div>
            </div>
             
             <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="movimientoEquipoAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html> 
