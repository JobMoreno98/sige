<!DOCTYPE html>
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Recursos Humanos') {
    header('location: index.php');
}
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de desarrollo BPEJ">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>

        <style>
            #formulario{
                margin-bottom: 20pt;
            }
        </style>

        <script>
            window.onload = function(){
                document.getElementById("guardar").onclick = function() {validarEnviar()};
            }
            function validarEnviar(){
                var fechaInicio = new Date(document.getElementById("rangoInicio").value);
                var fechaFin = new Date(document.getElementById("rangoFin").value);

                if (fechaFin.getTime() > fechaInicio.getTime()) {
                    var empleado = document.getElementById("empleado").value;
                    var jefe = document.getElementById("jefe").value;
                    if (empleado != "Empleado" && jefe != "Jefe inmediato") {
                        var motivo = document.getElementById("motivo").value;
                        if (motivo != "Motivo") {
                            document.getElementById("formIncapacidad").submit();
                        }else {
                            alert("El campo de motivo es obligatorio.")
                        }
                    }else{
                        alert("Los campos de empleado y jefe inmediato son obligatorios.")
                    }
                }else{
                    alert("Las fechas son obligatorias. La fecha de inicio debe de ser menor que la fecha de finalización.")
                }
            }
        </script>

    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();

        include 'permiso.php';
        $obj = new permiso();
        ?>
        <div class="container" id="formulario">
            <div class="page-header">
                <h3 align="center">Captura Incapacidad, Licencia o Comisión</h3>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
                    <small>Datos del empleado</small>
                    <form id="formIncapacidad" action="aplicarMovimiento.php" method="post">
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <select name="empleado" id="empleado" class="form-control input-lg custom-select" placeholder="First Name" tabindex="1" required>
                                        <option hidden>Empleado</option>
                                        <?php $obj->consultaEmpleados(); ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6">
                                <div class="form-group">
                                    <select name="jefe" id="jefe" class="form-control input-lg custom-select" placeholder="First Name" tabindex="2">
                                        <option hidden>Jefe inmediato</option>
                                        <?php $obj->consultaJefeInmediato(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <small>Rango de fecha (Inicio y fin)</small>
                        <div class="row">
                            <div class="form-group col-xs-12 col-sm-6 col-md-6">
                                <input type="date" name="rangoInicio" id="rangoInicio" class="form-control input-lg" placeholder="Inicio" tabindex="3" required>
                            </div>
                            <div class="form-group col-xs-12 col-sm-6 col-md-6">
                                <input type="date" name="rangoFin" id="rangoFin" class="form-control input-lg" placeholder="Fin" tabindex="4" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <select name="motivo" id="motivo" class="form-control input-lg" tabindex="5" required>
                                <option hidden>Motivo</option>
                                <option>Incapacidad</option>
                                <option>Licencia</option>
                                <option>Comisión</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <textarea name="observaciones" id="observaciones" rows="4" class="form-control input-lg" tabindex="6" placeholder="Observaciones"></textarea>
                        </div>

                        <div class="row">
                            <div class="col-xs-12 col-md-6">
                                <input type="button" id="guardar" class="btn btn-primary btn-block btn-lg" value="Guardar"></input>
                                <input type="hidden" name="guardarIncapacidad"/>
                            </div>
                            <div class="col-xs-12 col-md-6">
                                <a href="index.php">
                                    <button type="button" class="btn btn-block btn-lg" tabindex="7">Salir</button>
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </body>
</html>
