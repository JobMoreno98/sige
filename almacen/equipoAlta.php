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
        date_default_timezone_set("America/Mexico_City");
        $hoy=getdate();
        
         include 'barraMenu.php';
         $menu = new menu();
         $menu ->barraMenu();
         
         include 'equipo.php';
         $equipo = new equipo();
         
         include_once 'area.php';
         $area = new area();
         
         include_once 'empleado.php';
         $empleado = new empleado();
         
         ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Capturar Nuevo Equipo.</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
                <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="descripcion" name="descripcion" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $equipo->listarTipoEquipo(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="IdUsuario">Usuario:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="IdUsuario" name="IdUsuario" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $empleado->listarUsuarios(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="IdResguardante">Resguardante:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="IdResguardante" name="IdResguardante" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $empleado->listarEmpleados(); ?>
                </select>
              </div>
            </div>
                            <div class="form-group">
                <label class="control-label col-sm-2" for="IdArea">Área:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="IdArea" name="IdArea" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $area->listarAreas(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="fecha">Fecha Asignación:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="fecha" name="fecha" required>
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
                 <label class="control-label col-sm-2" for="numSerie">Núm. Serie:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="numSerie" name="numSerie" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="idUdg">Id UdeG:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="idUdg" name="idUdg" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="mac">MAC:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="mac" name="mac" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="IP">IP:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="IP" name="IP" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="tipoConexion">Tipo de Conexión:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="tipoConexion" name="tipoConexion" required>
                    <option value="Inalámbrico">Inalámbrico</option>
                    <option value="Red Cableada">Red Cableada</option>
                    <option value="Sin Red">Sin Red</option>
                    <option value="No Aplica" selected>No Aplica</option>
                </select>
              </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="detalles">Detalles:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="detalles" name="detalles" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="imgFrente">Img Frente:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="imgFrente" name="imgFrente" value="No Disponible" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="imgSerie">Img Serie:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="imgSerie" name="imgSerie" value="No Disponible" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="pdfFactura">PDF Factura:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="pdfFactura" name="pdfFactura" value="No Disponible" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="estadoEquipo">Estado:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="estadoEquipo" name="estadoEquipo" required>
                    <option value="Activo" selected>Activo</option>
                    <option value="No Activo">No Activo</option>
                </select>
              </div>
            </div>
         <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="equipoAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html> 
