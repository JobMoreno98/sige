<!DOCTYPE html>
<?php
include './loginSecurity.php';

include 'equipo.php';
$obj = new equipo();

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Equipos. SIGE. BPEJ</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de Desarrollo BPEJ">
        <!--bootstrap-->
        <link rel="stylesheet" href="../../sige/css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="../../sige/js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="../../sige/js/bootstrap.min.js"></script>
        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="../../sige/css/jquery.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="../../sige/js/jquery.dataTables.js"></script><!-- Editado -->
        <!--Datatables responsive-->
        <link rel="stylesheet" type="text/css" href="../../sige/css/responsive.dataTables.min.css"/>
        <script type="text/javascript" src="../../sige/js/dataTables.responsive.min.js"></script>
        <!--Datatables Buttons-->
        <link rel="stylesheet" type="text/css" href="../../sige/css/buttons.dataTables.css"/><!-- Editado y menu -->

    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        
       <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura o Actualización de la Tabla</h3>
          </div>
          
            <form  action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
          
              <div class="form-group">
              <label class="control-label col-sm-2" for="idProveedor">ID Proveedor:</label>
              <div class="col-sm-10">
                   <textarea class="form-control" rows="10" id="comment"></textarea>
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

