<?php
session_start();
include './loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas') {
    header('location: index.php');
}
date_default_timezone_set("America/Mexico_City");
$hoy=getdate();
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Tickets. BPEJ. Sistema Integral de Gestión</title>
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

        include_once 'ticket.php';
        $ticket = new ticket();
        $ticket->setIdTicket($_GET['id']);
        $ticket->ticketModificar();

        include_once 'equipo.php';
        $equipo = new equipo();
        $equipo->setIdEquipo($ticket->getIdEquipo());

        include_once 'area.php';
        $area = new area();
        $area->setIdArea($ticket->getIdArea());


        include_once 'empleado.php';
        $empleado=new empleado;
        $empleado->setIdEmpleado($ticket->getIdSolicitante());

        include_once 'tecnico.php';
        $tecnico=new tecnico;
        $tecnico->setIdTecnico($ticket->getIdTecnico());

        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Modificación Ticket</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
              <div class="form-group">
              <label class="control-label col-sm-2" for="IdTicket">IdTicket:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="IdTicket" name="IdTicket" value="<?php echo $ticket->getIdTicket();?>"required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="estatus">Estatus:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="estatus" name="estatus" required>
                    <option value="<?php echo $ticket->getStatus();?>" selected><?php echo $ticket->getStatus();?></option>
                    <option value="" disabled>Sin seleccionar</option>
                    <option value="Abierto">Abierto</option>
                    <option value="Cerrado">Cerrado</option>
                    <option value="Escalado">Escalado</option>
                    <option value="Pendiente respuesta del Usuario">Pendiente respuesta del Usuario</option>
                  </select>
              </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="statusAnterior">StatusAnterior:</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="statusAnterior" name="statusAnterior" value="<?php echo $ticket->getStatus(); ?>">
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-2" for="fechaActualizacion">Fecha Actualización:</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="fechaActualizacion" name="fechaActualizacion" value="<?php echo $ticket->getFechaActualizacion(); ?>" readonly>
                </div>
              </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdEquipo">Equipo:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="IdEquipo" name="IdEquipo" required>
                        <?php $equipo->listarEquipoUnico();?>
                      <option value="" disabled>Sin seleccionar</option>
                      <?php $equipo->listarEquipos();?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="prioridad">Prioridad:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="prioridad" name="prioridad" required>
                      <option value="<?php echo $ticket->getPrioridad();?>" selected><?php echo $ticket->getPrioridad();?></option>
                    <option value="" disabled>Sin seleccionar</option>
                    <option value="Alta">Alta</option>
                    <option value="Media" selected>Media</option>
                    <option value="Baja">Baja</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdArea">Área:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="IdArea" name="IdArea" required>

                    <?php $area->listarAreaUnica();?>
                    <option value="" disabled>Sin seleccionar</option>
                    <?php $area->listarAreas();?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdSolicitante">Solicitante:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="IdSolicitante" name="IdSolicitante" required>
                    <?php $empleado->empleadoListaUnico();?>
                    <option value="" disabled>Sin seleccionar</option>
                    <?php $empleado->listarEmpleados();?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="descripcion">Descripción:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="descripcion" name="descripcion" value="<?php echo str_replace("\"", "*",$ticket->getDatosDelReporte()); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="fechaReporte">Fecha de Reporte:</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" id="fechaReporte" value="<?php echo $ticket->getFechaReporte(); ?>" name="fechaReporte" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="fechaReporte">Fecha de Inicio:</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" id="fechaInicio" value="<?php echo $ticket->getFechaInicio(); ?>" name="fechaInicio">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="fechaTermino">Fecha de Termino:</label>
              <div class="col-sm-10">
                  <input type="date" class="form-control" id="fechaTermino" value="<?php echo $ticket->getFechaTermino(); ?>" name="fechaTermino">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="solucion">Solución:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="solucion" name="solucion" value="<?php echo $ticket->getSolucion(); ?>">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="IdTecnico">Técnico:</label>
              <div class="col-sm-10">
                  <select class="form-control" id="IdTecnico" name="IdTecnico" required>
                    <?php $tecnico->tecnicosListadoUnico();?>
                      <option value="" disabled>Sin seleccionar</option>
                    <?php $tecnico->tecnicosListado();?>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="tomoSolicitud">Tomo Solicitud:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="tomoSolicitud" name="tomoSolicitud" value="<?php echo $ticket->getTomoSolicitud(); ?>" required>
              </div>
            </div>

              <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="ticketModificacion">Guardar</button>
                <a href="index.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>
    </body>
</html>
