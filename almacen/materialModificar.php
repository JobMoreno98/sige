    <!DOCTYPE html>
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
        $obj = new material();
        
        $obj ->setIdMaterial($_GET['id']);
        $obj ->setTipo($_GET['t']);
        $arregloMatMod = $obj->materialSeleccionModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Material</h3>
          </div>
          
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
                
                <div class="form-group">
                    <label class="control-label col-sm-2" for="idMaterial">No. de Material:</label>
                    <div class="col-sm-10">
                        <input type="number" class="form-control" id="idMaterial" name="idMaterial" value="<?php print_r($arregloMatMod[0]) ?>" readonly>
                    </div>
                </div>     
                <div class="form-group">
                    <label class="control-label col-sm-2" for="descripcion">Descripci&oacute;n:</label>
                    <div class="col-sm-10">
                    <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="150" value="<?php print_r($arregloMatMod[1]) ?>" required>
                    </div>
                </div>
                <div class="form-group">
                <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                  <div class="col-sm-10">          
                      <select class="form-control" id="tipo" name="tipo">
                          <option><?php print_r($arregloMatMod[2]) ?></option>
                          <option>Limpieza</option>
                          <option>Papeleria</option>
                      </select>
                  </div>
                </div>
                 <div class="form-group">
                     <label class="control-label col-sm-2" for="stock">Stock M&iacute;nimo:</label>
                    <div class="col-sm-10">
                    <input type="number" class="form-control" id="stock" name="stock" value="<?php print_r($arregloMatMod[3]) ?>" min="0" max="1000000" required>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="control-label col-sm-2" for="caducidad">Tiempo de Caducidad:</label>
                    <div class="col-sm-10">
                    <input type="number" class="form-control" id="caducidad" name="caducidad" min="1" max="30" 
                    value="<?php print_r($arregloMatMod[4]) ?>" data-toggle="tooltip" data-placement="right" title="Duración en Años" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="nivelProyeccion">Nivel Proyección:</label>
                    <div class="col-sm-10">
                    <input type="number" class="form-control" id="nivelProyeccion" name="nivelProyeccion" min="0" 
                    value="<?php print_r($arregloMatMod[6]) ?>" data-toggle="tooltip" data-placement="right" title="Nivel Proyección" required>
                    </div>
                </div>
                 <div class="form-group">
                    <label class="control-label col-sm-2" for="uso">En Uso:</label>
                    <div class="col-sm-10">          
                    <select class="form-control" id="uso" name="uso">
                        <option><?php print_r($arregloMatMod[5]) ?></option>
                        <option>Activo</option>
                        <option>Inactivo</option>
                    </select>
                  </div>
                 </div>  

              <div class="form-group">        
               <div class="col-sm-offset-2 col-sm-10">
                 <button type="submit" class="btn btn-primary" name="materialModificar">Guardar</button>
                   <a href="materialConsulta.php?t=<?php echo $obj->getTipo(); ?>" class="btn btn-default">Regresar</a>
                   <a href="index.php" class="btn btn-default">Salir</a>
                  </div>
                </div>
          </form>
        </div>  
    </body>
</html>
