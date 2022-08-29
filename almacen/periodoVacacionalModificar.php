<!DOCTYPE html>
<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
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
        
        include 'periodoVacacional.php';
        $obj = new periodoVacacional();

        $obj ->setIdPeriodo($_GET['id']);
        $conPeriod = $obj->periodoSeleccionModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Periodo Vacacional</h3>
          </div>
          
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
                
                <div class="form-group">
                  <label class="control-label col-sm-2" for="idPeriodo">ID Periodo:</label>
                  <div class="col-sm-10">
                      <input type="number" class="form-control" id="idPeriodo" name="idPeriodo" value="<?php echo $obj ->getIdPeriodo(); ?>" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="descripcionPeriodo">Descripción:</label>
                  <div class="col-sm-10">
                      <input type="text" class="form-control" id="descripcionPeriodo" name="descripcionPeriodo" maxlength="50" value="<?php print_r($conPeriod[0]) ?>" autofocus required="text">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="inicioPeriodo">Fecha Inicio:</label>
                  <div class="col-sm-10">
                      <input type="date" class="form-control" id="inicioPeriodo" name="inicioPeriodo" value="<?php print_r($conPeriod[1]) ?>" required>
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-2" for="finPeriodo">Fecha Fin:</label>
                  <div class="col-sm-10">
                      <input type="date" class="form-control" id="finPeriodo" name="finPeriodo" value="<?php print_r($conPeriod[2]) ?>" required>
                  </div>
                </div>

                <div class="form-group">        
                  <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" class="btn btn-primary" name="periodoVacacionalModificar">Guardar</button>
                    <a href="periodoVacacionalConsulta.php" class="btn btn-default">Regresar</a>
                    <a href="index.php" class="btn btn-default">Salr</a>
                  </div>
                </div>
          </form>
        </div>  
    </body>
</html>
