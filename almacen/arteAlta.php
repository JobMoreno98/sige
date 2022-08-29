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
        
        include_once 'arte.php';
        $arte = new arte();

        /*include_once 'mueble.php';
        $mueble = new mueble();
        
        include_once 'empleado.php';
        $empleado=new empleado();
        
        include_once 'area.php';
        $area=new area();*/

        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nueva Obra de Arte</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="descripcion">Descripción</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="descripcion" name="descripcion" maxlength="100" required>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="origenMueble">Origen:</label>
              <div class="col-sm-10">          
               <select class="form-control" id="origenMueble" name="origenMueble" data-toggle="tooltip"
                       data-placement="right" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                    <option>Compra con Factura</option>
                    <option>Donación</option>
                    <option>No aplica para inventario real</option>
                    <option>No definido</option>
                    <option>Compra mediante CGADM</option>
                  </select>
              </div>
            </div>  
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="medidas">Medidas.</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="medidas" name="medidas" maxlength="100" required>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="imgFrente">Imagen Frente.</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="imgFrente" name="imgFrente" maxlength="100" required>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="imgLateral">Imagen Lateral:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="imgLateral" name="imgLateral" maxlength="100" required>
              </div>
            </div>
            
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="estadoCatalogoMueble">Estado:</label>
              <div class="col-sm-10">          
               <select class="form-control" id="estadoCatalogoMueble" name="estadoCatalogoMueble" data-toggle="tooltip"
                       data-placement="right"  required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <option>Activo</option>
                    <option>No Activo</option>
                  </select>
              </div>
            </div>
                
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="tipo">Tipo:</label>
              <div class="col-sm-10">          
               <select class="form-control" id="tipo" name="tipo" data-toggle="tooltip"
                       data-placement="right" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <option>Histórico</option>
                    <option>Contemporáneo 2da Generación</option>
                    <option>Contemporáneo Belenes</option>
                  </select>
              </div>
            </div>   
                
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="categoria">Categoría:</label>
              <div class="col-sm-10">          
               <select class="form-control" id="categoria" name="categoria" data-toggle="tooltip"
                       data-placement="right" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <option>Obra de Arte</option>
                    <option>Utilitario</option>
                    <option>Decorativo</option>
                   <option>Pintura</option>
                   <option>Escultura tallada en catera</option>
                   <option>Trabajo en cantera</option>
                  </select>
              </div>
            </div> 
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="informacion">Información:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="informacion" name="informacion" maxlength="50" required>
              </div>
            </div>
            
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="arteAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

