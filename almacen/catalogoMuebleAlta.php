<?php
session_start();
include 'loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas') {
    header('location: index.php');
}
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de GestiÃ³n</title>
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
        
        include_once 'mueble.php';
        $mueble = new mueble();
        
        include_once 'empleado.php';
        $empleado=new empleado();
        
        include_once 'area.php';
        $area=new area();
        
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nuevo Mueble</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('Â¿Seguro que quieres guardar este formulario?');">
            <!--<div class="form-group">
              <label class="control-label col-sm-2" for="idCatalogoM">Id Catálogo Mueble:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="idCatalogoM" name="idCatalogoM " required>
              </div>
            </div>-->
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="descripcion" name="descripcion" required>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="marca">Marca:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="marca" name="marca" required>
              </div>
            </div>
            
            <div class="form-group">
              <label class="control-label col-sm-2" for="modelo">Modelo:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="modelo" name="modelo" required>
              </div>
            </div>
              
            <div class="form-group">
              <label class="control-label col-sm-2" for="medidas">Medidas:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="medidas" name="medidas" required>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="imgFrente">Imagen de Frente:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="imgFrente" name="imgFrente" required>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="imgLateral">Imagen Lateral:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="imgLateral" name="imgLateral" required>
              </div>
            </div>
                
            <div class="form-group">
                <label class="control-label col-sm-2" for="estadoCatalogoMueble">Estado:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="estadoCatalogoMueble" name="estadoCatalogoMueble" required>
                    <option value="Activo">Activo</option>
                    <option value="No Activo">No Activo</option>
                </select>
              </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-2" for="tipo">Tipo:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="tipo" name="tipo" required>
                    <option value="Histórico">Histórico</option>
                    <option value="Contemporáneo 2da Generación">Contemporáneo 2da Generación</option>
                    <option value="Contemporáneo Belenes">Contemporáneo Belenes</option>
                </select>
              </div>
            </div>
           
            <div class="form-group">
              <label class="control-label col-sm-2" for="fichaTecnica">Ficha Técnica</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="fichaTecnica" name="fichaTecnica" required>
              </div>
            </div>
                
            <div class="form-group">
                <label class="control-label col-sm-2" for="categoria">Categoría:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="categoria" name="categoria" required>
                    <option value="Obra de Arte">Obra de Arte</option>
                    <option value="Utilitario">Utilitario</option>
                    <option value="Decorativo">Decorativo</option>
                </select>
              </div>
            </div>
                
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdTipoSIIAU">Id de SIIAU</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="IdTipoSIIAU" name="IdTipoSIIAU" required>
              </div>
            </div>
                
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="catalogoMuebleAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

