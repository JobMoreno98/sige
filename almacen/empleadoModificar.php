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

        include 'empleado.php';
        $obj = new empleado();

        $obj ->setIdEmpleado($_GET['id']);

        $arregloEmp = $obj->empleadoSeleccionModificar();
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificar Personal</h3>
          </div>

            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar los cambios?');">
              <div class="form-group">
              <label class="control-label col-sm-2" for="idEmpleado">ID Empleado:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="idEmpleado" name="idEmpleado" value="<?php print_r($arregloEmp[0]); ?>" readonly>
              </div>
              </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="nombre">Nombre Completo:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" value="<?php print_r($arregloEmp[1]); ?>" autofocus required>
              </div>
            </div>
              <div class="form-group">
              <label class="control-label col-sm-2" for="codigoUDG">Codigo UDG:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="codigoUDG" name="codigoUDG" min="1" value="<?php print_r($arregloEmp[2]); ?>" required="number">
             </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="puesto">Puesto Desempeñado:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="puesto" name="puesto" maxlength="50" value="<?php print_r($arregloEmp[3]); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="idNombramiento">Nombramiento:</label>
              <div class="col-sm-10">
                <select class="form-control" id="idNombramiento" name="idNombramiento" required>
                    <option value="<?php print_r($arregloEmp[4]); ?>"><?php print_r($arregloEmp[4]); ?> - <?php print_r($arregloEmp[5]); ?></option>
                    <?php $obj->consultaNombramiento(); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="cargaHoraria">Carga Horaria:</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="cargaHoraria" min="0" max="200" name="cargaHoraria" value="<?php print_r($arregloEmp[6]); ?>" data-toggle="tooltip" data-placement="right" title="Horas por semana" required="number">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="gradoEstudios">Escolaridad:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="gradoEstudios" name="gradoEstudios" maxlength="50" value="<?php print_r($arregloEmp[7]); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="observaciones" name="observaciones" maxlength="100" value="<?php print_r($arregloEmp[8]); ?>" required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="extension">Extensi&oacute;n:</label>
              <div class="col-sm-10">
                <input type="number" class="form-control" id="extension" name="extension" min="0" max="100000" value="<?php print_r($arregloEmp[9]); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="idArea">&Aacute;rea:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="idArea" name="idArea" required>
                    <option value="<?php print_r($arregloEmp[10]); ?>"><?php print_r($arregloEmp[10]); ?> - <?php print_r($arregloEmp[11]); ?></option>';
                    <?php $obj->consultaAreaEmpleado(); ?>
                 </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="privilegios">Privilegios:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="privilegios" name="privilegios" required>
                    <option><?php print_r($arregloEmp[12]); ?></option>
                    <option>Colaborador</option>
                    <option>Responsable</option>
                    <option>Administrador</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="estado">Estatus:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="estado" name="estado" required>
                    <option><?php print_r($arregloEmp[13]); ?></option>
                    <option>Activo</option>
                    <option>Baja</option>
                  </select>
              </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="reportes0">Tipo de reporte:</label>
                <div class="col-sm-5" id="reportes0">
                    <select class="form-control" id="tipoReporte" name="tipoReporte" data-toggle="tooltip" data-placement="right" title="" required>
                        <option <?php if($arregloEmp[14] == "Contemporaneo"){echo 'selected';}?> value="Contemporaneo">Contemporáneo</option>
                        <option <?php if($arregloEmp[14] == "Historico"){echo 'selected';}?> value="Historico">Histórico</option>
                        <option <?php if($arregloEmp[14] == "Servicios generales"){echo 'selected';}?> value="Servicios generales">Servicios generales</option>
                        <option <?php if($arregloEmp[14] == "Mixto"){echo 'selected';}?> value="Mixto">Mixto</option>
                        <option <?php if($arregloEmp[14] == "Agua Azul"){echo 'selected';}?> value="Agua Azul">Agua Azul</option>
                        <option <?php if($arregloEmp[14] == "Otro"){echo 'selected';}?> value="Otro">Otro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="reportes1">Generar Reportes:</label>
                <div class="col-sm-5" id="reportes1">
                    <select class="form-control" id="generarReporte" name="generarReporte" data-toggle="tooltip" data-placement="right" title="" required>
                        <option <?php if($arregloEmp[15] == "1"){echo 'selected';}?> value="1">Si generar</option>
                        <option <?php if($arregloEmp[15] == "0"){echo 'selected';}?> value="0">No generar</option>
                    </select>
                </div>
            </div>


          <div class="form-group">
           <div class="col-sm-offset-2 col-sm-10">
             <button type="submit" class="btn btn-primary" name="empleadoModificar">Guardar</button>
               <a href="empleadoConsulta.php" class="btn btn-default">Regresar</a>
               <a href="index.php" class="btn btn-default">Salir</a>
              </div>
            </div>
          </form>
        </div>
        <br>
    </body>
</html>
