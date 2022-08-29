<!DOCTYPE html>
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
    header('location: index.php');
}
?>
<html lang='es'>
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
    
    include 'horarioCumplido.php';
    $obj = new horarioCumplido();
    date_default_timezone_set("America/Mexico_City");
    ?>
    <div class="container">
        <div class="page-header">
            <h3 style="text-align: center">Reporte Mensual de Personal</h3>
        </div>
        <form class="form-horizontal" action="asistenciaMesBusqueda.php" method="POST">
            <div class="form-group">
              <label class="control-label col-sm-2" for="mes">Mes:</label>
              <div class="col-sm-10">
                  <input id="mes" type="date" class="form-control" name="mes" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdEmpleado">Personal:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdEmpleado" name="IdEmpleado" required>
                    <option disabled selected>Sin seleccionar</option>
                    <?php $obj->consultaEmpleados(); ?>
                  </select>
              </div>
            </div>
        <div class="form-group">   
          <div class="col-sm-offset-2 col-sm-10">
            <button name="fromQuery" type="submit" class="btn btn-primary">Consultar</button>  
            <a href="index.php" class="btn btn-default">Salir</a>
          </div>
        </div>
        </form>
    </div>
</body>
</html>