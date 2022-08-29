    <!DOCTYPE html>
<?php
 include './loginSecurity.php';
   if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Finanzas') {
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
        
        include 'proveedor.php';
        $obj = new proveedor();
        
        $obj ->setIdProveedor($_GET['id']);
        $arregloProv = $obj->proveedorSeleccionModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Proveedor</h3>
          </div>
          
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
          
              <div class="form-group">
              <label class="control-label col-sm-2" for="idProveedor">ID Proveedor:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="idProveedor" name="idProveedor" value="<?php print_r($arregloProv[0]); ?>" readonly>
              </div>
              </div>                
               <div class="form-group">
              <label class="control-label col-sm-2" for="RFC">RFC del Proveedor:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="RFC" name="RFC" maxlength="15" value="<?php print_r($arregloProv[1]); ?>" required>
              </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-sm-2" for="razon">Raz&oacute;n Social:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="razon" name="razon" maxlength="100" value="<?php print_r($arregloProv[2]); ?>"  required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="nombre">Nombre Comercial:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="nombre" name="nombre" maxlength="100" value="<?php print_r($arregloProv[3]); ?>"  required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contacto">Nombre Contacto:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="contacto" name="contacto" maxlength="100" value="<?php print_r($arregloProv[4]); ?>"  required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="telefono">Tel&eacute;fono:</label>
              <div class="col-sm-10">
                  <input type="tel" class="form-control" id="telefono" name="telefono" maxlength="30" value="<?php print_r($arregloProv[5]); ?>" required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email:</label>
              <div class="col-sm-10">
                  <input type="email" class="form-control" id="email" name="email" maxlength="30" value="<?php print_r($arregloProv[6]); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="estadoProveedor">Estatus:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="estadoProveedor" name="estadoProveedor">
                      <option><?php print_r($arregloProv[7]); ?></option>
                      <option>Activo</option>
                      <option>No Activo</option>
                  </select>
              </div>
            </div>  
          <div class="form-group">        
           <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" name="proveedorModificar">Guardar</button>
               <a href="proveedorConsulta.php" class="btn btn-default">Regresar</a>
               <a href="index.php" class="btn btn-default">Salir</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>
