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
         
         include 'equipo.php';
         $equipo = new equipo();
        
        $equipo ->setIdEquipo($_GET['id']);
        $equipo->equipoModificar();
         ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Equipo</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
                 <label class="control-label col-sm-2" for="IdEquipo">IdEquipo:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="IdEquipo" name="IdEquipo"  value="<?php echo $equipo ->getIdEquipo(); ?>" readonly>
                </div>
            </div>  
            <div class="form-group">
                <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="descripcion" name="descripcion" required>
                   <option  value="<?php echo $equipo ->getDescripcion(); ?>"  selected><?php echo $equipo ->getDescripcion(); ?></option>
                    <option value="" disabled>Sin seleccionar</option>
                    <?php $equipo->listarTipoEquipo(); ?>
                </select>
              </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="marca">Marca:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $equipo ->getMarca(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="modelo">Modelo:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="modelo" name="modelo" value="<?php echo $equipo ->getModelo(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="numSerie">Núm. Serie:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="numSerie" name="numSerie" value="<?php echo $equipo ->getNumSerie(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="idUdg">Id UdeG:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="idUdg" name="idUdg" value="<?php echo $equipo ->getIdUdg(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="mac">MAC:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="mac" name="mac" value="<?php echo $equipo ->getMac(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="IP">IP:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="IP" name="IP" value="<?php echo $equipo ->getIP(); ?>" required>
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
                    <input type="text" class="form-control" id="detalles" name="detalles" value="<?php echo $equipo ->getDetalles(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="verificado">Verificado:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="verificado" name="verificado" required>
                    <option value="<?php echo $equipo ->getVerificado(); ?>" selected><?php echo $equipo ->getVerificado(); ?></option>
                    <option value="No Verificado">No Verificado</option>
                    <option value="Verificado">Verificado</option>
                    <option value="Validado">Validado</option>
                </select>
              </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="imgFrente">Img Frente:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="imgFrente" name="imgFrente" value="<?php echo $equipo ->getImgFrente(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="imgSerie">Img Serie:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="imgSerie" name="imgSerie" value="<?php echo $equipo ->getImgSerie(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                 <label class="control-label col-sm-2" for="pdfFactura">PDF Factura:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="pdfFactura" name="pdfFactura" value="<?php echo $equipo ->getPdfFactura(); ?>" required>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="estadoEquipo">Estado:</label>
                <div class="col-sm-10">          
                <select class="form-control" id="estadoEquipo" name="estadoEquipo" required>
                    <option value="<?php echo $equipo ->getEstadoEquipo(); ?>" selected><?php echo $equipo ->getEstadoEquipo(); ?></option>
                    <option value="Activo">Activo</option>
                    <option value="No Activo">No Activo</option>
                </select>
              </div>
            </div>
         <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="equipoModificar">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html> 
