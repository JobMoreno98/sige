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
        
        include 'area.php';
        $obj = new area();
        
        $obj ->setIdArea($_GET['id']);
        $arregloArea = $obj->areaSeleccionModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar &Aacute;rea</h3>
          </div>
          
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
          
              <div class="form-group">
              <label class="control-label col-sm-2" for="idArea">ID Area:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="idArea" name="idArea" maxlength="11" value="<?php print_r($arregloArea[0]) ?>" readonly>
              </div>
              </div>
                <div class="form-group">
              <label class="control-label col-sm-2" for="area">Nombre del &Aacute;rea:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="area" name="area" maxlength="100" value="<?php print_r($arregloArea[1]) ?>" required>
              </div>
              </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="piso">Piso:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="piso" name="piso" maxlenght="15" value="<?php print_r($arregloArea[2]) ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="edificio">Edificio:</label>
              <div class="col-sm-10">          
               <select class="form-control" id="edificio" name="edificio">
                    <option><?php print_r($arregloArea[3]) ?></option>
                    <option>Hist&oacute;rico</option>
                    <option>Contempor&aacute;neo</option>
                    <option>Agua Azul</option>
                    <option>Sin Localizar</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="tipo">Tipo:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="tipo" name="tipo" data-toggle="tooltip"
                       data-placement="right" title="'Operación' no puede pedir nada, 'Administrativo' solo papelería y 'Gestión' puede pedir limpieza y papelería" required>
                      <option><?php print_r($arregloArea[4]) ?></option>
                      <option>Administrativa</option>
                      <option>Operaciones</option>
                      <option>Gesti&oacute;n</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="estadoArea">Estatus:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="estadoArea" name="estadoArea">
                      <option><?php print_r($arregloArea[5]) ?></option>
                      <option>Activo</option>
                      <option>No Activo</option>
                  </select>
              </div>
            </div>
          <div class="form-group">        
           <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" name="areaModificar">Guardar</button>
               <a href="areaConsulta.php?m=M" class="btn btn-default">Regresar</a>
               <a href="index.php" class="btn btn-default">Salir</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>
