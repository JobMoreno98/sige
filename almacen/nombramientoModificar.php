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
        
        include 'suplencia.php';
        $obj = new suplencia();
        
        $obj ->setIdNombramiento($_GET['id']);
        $arregloNomb = $obj->consultaNombramientoPorID();
        ?>
      <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Nombramiento</h3>
          </div>
          
          <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
              
            <div class="form-group">
              <label class="control-label col-sm-2" for="idNombramiento">ID:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="idNombramiento" name="idNombramiento" value="<?php print_r($arregloNomb[0]); ?>" readonly>
              </div>
            </div>  
            <div class="form-group">
              <label class="control-label col-sm-2" for="nombramiento">Nombre:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="nombramiento" name="nombramiento" maxlength="100" value="<?php print_r($arregloNomb[1]); ?>" required autofocus>
              </div>
            </div>  
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="estadoNombramiento">Estatus:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="estadoNombramiento" name="estadoNombramiento">
                      <option><?php print_r($arregloNomb[2]); ?></option>
                      <option>Activo</option>
                      <option>No Activo</option>
                  </select>
              </div>
            </div>
                    
            <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                  <button type="submit" class="btn btn-primary" name="nombramientoModificar">Guardar</button>
                  <a href="nombramientoConsulta.php" class="btn btn-default">Regresar</a>
                <a href="index.php" class="btn btn-default">Salir</a>
              </div>
            </div>
          </form>
        </div>
        <br>  
    </body>
</html>
