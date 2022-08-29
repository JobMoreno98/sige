<!DOCTYPE html>
<?php
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
        <meta name="author" content="Valentín Camacho Veloz, Daniel Flores Rodriguez, Brian Valentín Franco, Nancy García Mesillas">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <script>
        function check(that) {
            if ((that.value == "Sin goce de salario") || (that.value == "Con reposición de tiempo") || (that.value == "Entrada / salida irregulares") || (that.value == "Otro")){
                document.getElementById("fecha").style.display = "block";
            } else {
                document.getElementById("fecha").style.display = "none";
            }
        }
        
        function check2(that) {
            if ((that.value == "Otro")){
                document.getElementById("otro").style.display = "block";
            } else {
                document.getElementById("otro").style.display = "none";
            }
        }
        </script>
        <script>
            var cont= 1;
            $(document).ready(function() {
                $('#btnAddP').click(function() {
                    var newNum = new Number(cont+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo1P').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'numP' + newNum).attr('name', 'numP').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNuevaP').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDelP').attr('disabled',false);// enable the "remove" button
                    if (newNum == 50)//     business rule: you can only add 10 names
                      $('#btnAddP').attr('disabled','disabled');
                });

                $('#btnAddP').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo2P').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'fechaPermiso' + newNum).attr('name', 'fechaPermiso' + newNum);
                    $('#copiaNuevaP').before(newElem);                   
                    cont=cont+1;
                });
                                
                $('#btnDelP').click(function() {
                    var num = cont; // how many "duplicatable" input fields we currently have
                    $('#numP' + num).remove(); // remove the last element
                    $('#fechaPermiso' + num).remove(); // remove the last element                    
//                     enable the "add" button
                    $('#btnAddP').attr('disabled',false);
                    if (num == 2)//     business rule: you can only add 10 names
                      $('#btnDelP').attr('disabled',true);
                    cont=cont-1;
                });
            });
            
            var cont2= 1;
            $(document).ready(function() {
                $('#btnAddR').click(function() {
                    var newNum = new Number(cont2+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo1R').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'numR' + newNum).attr('name', 'numR').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNuevaR').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDelR').attr('disabled',false);// enable the "remove" button
                    if (newNum == 50)//     business rule: you can only add 10 names
                      $('#btnAddR').attr('disabled','disabled');
                });

                $('#btnAddR').click(function() {
                    var newNum = new Number(cont2+1);
                    var newElem = $('#campo2R').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'fechaReposicion' + newNum).attr('name', 'fechaReposicion' + newNum);
                    $('#copiaNuevaR').before(newElem);                   
                    cont2=cont2+1;
                });
                                
                $('#btnDelR').click(function() {
                    var num = cont2; // how many "duplicatable" input fields we currently have
                    $('#numR' + num).remove(); // remove the last element
                    $('#fechaReposicion' + num).remove(); // remove the last element                    
//                     enable the "add" button
                    $('#btnAddR').attr('disabled',false);
                    if (num == 2)//     business rule: you can only add 10 names
                      $('#btnDelR').attr('disabled',true);
                    cont2=cont2-1;
                });
            });
            
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
        <div class="container">
            <div class="page-header">
                <h3 align="center">Captura Incidencias y Faltas de Asistencia</h3>
            </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">                                
                <div class="input-group">
                    <span class="input-group-addon">Empleado:</span>
                        <?php
                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Recursos Humanos' || $_SESSION['privilegios'] == 'RH-Almacen'){
                        ?>
                            <select class="form-control" id="IdEmpleado" name="IdEmpleado" required>
                                <option value="" disabled selected>Sin seleccionar</option>
                                <?php $obj->consultaEmpleados(); ?>
                            </select>
                        <?php
                        }else{
                            $obj->setIdEmpleado($_SESSION['IdEmpleado']);
                        ?>
                            <select class="form-control" id="IdEmpleado" name="IdEmpleado">
                                <?php $obj->consultaNombreEmpleado();
                                ?>
                            </select>
                        <?php
                        }
                        ?>
                    <span class="input-group-addon">Fecha de Solicitud:</span>
                        <input id="fechaSolicitud" type="date" class="form-control" name="fechaSolicitud" required>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">Jefe Inmediato:</span>
                    <select class="form-control" id="IdJefeInmediato" name="IdJefeInmediato" required>
                        <option value="" disabled selected>Sin Seleccionar</option>
                        <?php $obj->consultaJefeInmediato(); ?>
                    </select>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="fechaPermiso">Fecha(s) de permiso:</label>
                </div>
                <div class="form-group">
                    <?php
                        for ($i = 1; $i < 2; $i++){
                            echo '
                                <div id="campo1P" class="col-sm-1 col-sm-offset-1">
                                    <input class="form-control" id="numP'.$i.'"  name="numP" value="'.$i.'" readonly>
                                </div>
                                <div id="campo2P" class="col-sm-10">
                                    <input id="fechaPermiso'.$i.'" type="date" class="form-control" name="fechaPermiso'.$i.'">
                                </div>
                            ';
                        }
                    ?>
                    <div id="copiaNuevaP"></div>
                </div>
                <div class="form-group">
                    <div class="col-sm-11"></div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-default pull-left" id="btnAddP">+</button>
                        <button type="button" class="btn btn-default pull-right" id="btnDelP">-</button>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="motivo">Motivo del permiso:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="motivo" name="motivo" onchange="check(this); check2(this);" required>
                            <option value="" disabled selected>Sin seleccionar</option>                                
                            <option value="Sin goce de salario">Sin goce de salario</option>
                            <option value="Ocho días con salario por matrimonio">Ocho días con salario por matrimonio</option>
                            <option value="Incapacidad">Incapacidad</option>
                            <option value="Asistencia a cursos">Asistencia a cursos</option>
                            <option value="Con reposición de tiempo">Con reposición de tiempo</option>
                            <option value="Cuatro días con salario por fallecimiento de familiar directo">Cuatro días con salario por fallecimiento de familiar directo</option>
                            <option value="Entrada / salida irregulares">Entrada / salida irregulares</option>
                            <option value="Cumpleaños diferido">Cumpleaños diferido</option>
                            <option value="Encomienda oficial">Encomienda oficial</option>
                            <option value="Cumpleaños puntualidad">Cumpleaños</option>
                            <option value="Puntualidad">Puntualidad</option>
                            <option value="Asistencia al IMSS">Asistencia al IMSS</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="fecha" style="display: none;">
                    <label class="control-label col-sm-2" for="fecha">Fecha(s) de reposición:</label>                        
                        <br>
                        <br>
                        <?php
                        for ($i = 1; $i < 2; $i++){
                            echo '
                                <div id="campo1R" class="col-sm-1 col-sm-offset-1">
                                    <input class="form-control" id="numR'.$i.'"  name="numR" value="'.$i.'" readonly>
                                </div>
                                <div id="campo2R" class="col-sm-10">
                                    <input id="fechaReposicion'.$i.'" type="date" class="form-control" name="fechaReposicion'.$i.'">
                                </div>
                            ';
                        }
                        ?>
                    <div id="copiaNuevaR"></div>
                    <div class="col-sm-11"></div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-default pull-left" id="btnAddR">+</button>
                        <button type="button" class="btn btn-default pull-right" id="btnDelR">-</button>
                    </div>
                </div>
                <div class="form-group" id="otro" style="display: none;">
                    <label class="control-label col-sm-2" for="motivoDiferente">Motivo:</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" rows="4" id="motivoDiferente" name="motivoDiferente" maxlength="280"></textarea>
                        </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4" id="observaciones" name="observaciones" maxlength="280" required>-</textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" name="permisoAlta">Guardar</button>
                        <a href="index.php" class="btn btn-default">Salir</a>
                    </div>
                </div>                
            </form>
        </div>
    </body>
</html>
