<?php
session_start();
include 'loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas' and $_SESSION['privilegios'] != 'Encargado AVS') {
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

        include_once 'empleado.php';
        $empleado=new empleado();
        
        include_once 'area.php';
        $area=new area();
        
        include_once 'mueble.php';
        $mueble = new mueble();
        $mueble->setIdMobiliario($_GET['id']);
        $mueble->muebleModificar();
        $empleado->setIdEmpleado($mueble->getIdEmpleado());
        $area->setIdArea($mueble->getIdArea());
        
        
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Mueble</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdMobiliario">Id Mobiliario</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" value="<?php echo $mueble->getIdMobiliario(); ?>" id="IdMobiliario" name="IdMobiliario" readonly>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdUdG">Id UdeG:</label>
              <div class="col-sm-10">
                  <input type="text" value="<?php echo $mueble->getIdUdG(); ?>" class="form-control" id="IdUdG" name="IdUdG" required>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdEmpleado">Resguardante:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdEmpleado" name="IdEmpleado" required>
                  <?php $empleado->empleadoListaUnico(); ?>  
                  <option value="" disabled>Sin seleccionar</option>
                  <?php $empleado->listarEmpleados();  ?>
                  </select>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdArea">Área:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdArea" name="IdArea" required>
                    <?php $area->listarAreaUnica(); ?>
                    <option value="" disabled>Sin seleccionar</option>
                  <?php $area->listarAreas(); ?>
                  </select>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdCatalogoM">Catálogo:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="IdCatalogoM" name="IdCatalogoM" required>
                  <?php $mueble->listarCatalogoMUnico(); ?>
                    <option value="" disabled>Sin seleccionar</option>
                  <?php $mueble->listarCatalogoM(); ?>
                  </select>
              </div>
            </div>
         
            <div class="form-group">
              <label class="control-label col-sm-2" for="verificado">Verificado:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="verificado" name="verificado" required>
                    <option value="<?php echo $mueble->getVerificado(); ?>"><?php echo $mueble->getVerificado(); ?></option>  
                    <option value="" disabled>Sin seleccionar</option>
                    <option value="No Verificado">No Verificado</option>
                    <option value="Verificado">Verificado</option>
                    <option value="Validado">Validado</option>
                  </select>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="estatus">Estatus:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="estatus" name="estatus">
                      <option value="<?php echo $mueble->getEstatus(); ?>"><?php echo $mueble->getEstatus(); ?></option> 
                      <option value="" disabled >Sin seleccionar</option>
                  <option value="Activo">Activo</option>
                  <option value="Baja">Baja</option>
                  <option value="No Activo">Eliminar</option>
                  </select>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="detalles">Detalles:</label>
              <div class="col-sm-10">
                  <input type="text" value="<?php echo $mueble->getDetalles(); ?>" class="form-control" id="detalles" name="detalles" required>
              </div>
            </div>
                
  
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="muebleModificarGuardar">Guardar</button>
                <a href="muebleConsulta.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

