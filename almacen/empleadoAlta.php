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

        include 'empleado.php';
        $personal = new empleado();
        ?>
      <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nuevo Personal</h3>
          </div>

          <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">

            <div class="form-group">
              <label class="control-label col-sm-2" for="nombre">Nombre Completo:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" required>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-sm-2" for="codigoUDG">Codigo UDG:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="codigoUDG" name="codigoUDG" min="1" required="number">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="puesto">Puesto Desempeñado:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="puesto" name="puesto" maxlength="50" required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="idNombramiento">Nombramiento:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="idNombramiento" name="idNombramiento" data-toggle="tooltip" data-placement="right" title="Nombramiento" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $personal->consultaNombramiento(); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="cargaHoraria">Carga Horaria:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="cargaHoraria" min="0" max="200" name="cargaHoraria" data-toggle="tooltip" data-placement="right" title="Horas por semana" required="number">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="gradoEstudios">Escolaridad:</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="gradoEstudios" name="gradoEstudios" maxlength="50" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="observaciones" name="observaciones" maxlength="100" value="-" required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="extension">Extensi&oacute;n:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="extension" name="extension" min="0" max="100000" required>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="idArea">&Aacute;rea:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="idArea" name="idArea" required>
                   <option value="" disabled selected>Sin seleccionar</option>
                    <?php $personal->consultaAreaEmpleado(); ?>
                  </select>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="privilegios">Privilegios:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="privilegios" name="privilegios" data-toggle="tooltip" data-placement="right" title="Responsable puede pedir papelería y Administrador papelería y limpieza" required>
                   <option>Colaborador</option>
                   <option>Responsable</option>
                   <option>Administrador</option>

                  </select>
              </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="reportes0">Tipo de reporte:</label>
                <div class="col-sm-5" id="reportes0">
                    <select class="form-control" id="tipoReporte" name="tipoReporte" data-toggle="tooltip" data-placement="right" title="" required>
                        <option>Contemporáneo</option>
                        <option>Histórico</option>
                        <option>Servicios generales</option>
                        <option>Mixto</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-sm-2" for="reportes1">Generar Reportes:</label>
                <div class="col-sm-5" id="reportes1">
                    <select class="form-control" id="generarReporte" name="generarReporte" data-toggle="tooltip" data-placement="right" title="" required>
                        <option value="1">Si generar</option>
                        <option value="0">No generar</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="empleadoAlta">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>
    </body>
</html>
