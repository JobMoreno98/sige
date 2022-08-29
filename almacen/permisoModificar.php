<?php
include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Modificar Catálogo Mueble. BPEJ. Sistema Integral de GestiÃ³n</title>
        <title>Catálogo Mobiliario. SIGE. BPEJ</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo Desarrollo BPEJ">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <script>
            var cont= 1;
            $(document).ready(function() {
                $('#btnAddP').click(function() {
                    var newNum = new Number(cont+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo1PN').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'numPN' + newNum).attr('name', 'numPN').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNuevaP').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDelP').attr('disabled',false);// enable the "remove" button
                    if (newNum == 50)//     business rule: you can only add 10 names
                      $('#btnAddP').attr('disabled','disabled');
                });

                $('#btnAddP').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo2PN').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'fechaPermisoN' + newNum).attr('name', 'fechaPermisoN' + newNum);
                    $('#copiaNuevaP').before(newElem);                   
                    cont=cont+1;
                });
                                
                $('#btnDelP').click(function() {
                    var num = cont; // how many "duplicatable" input fields we currently have
                    $('#numPN' + num).remove(); // remove the last element
                    $('#fechaPermisoN' + num).remove(); // remove the last element                    
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
                    var newElem = $('#campo1RN').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'numRN' + newNum).attr('name', 'numRN').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNuevaR').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDelR').attr('disabled',false);// enable the "remove" button
                    if (newNum == 50)//     business rule: you can only add 10 names
                      $('#btnAddR').attr('disabled','disabled');
                });

                $('#btnAddR').click(function() {
                    var newNum = new Number(cont2+1);
                    var newElem = $('#campo2RN').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'fechaReposicionN' + newNum).attr('name', 'fechaReposicionN' + newNum);
                    $('#copiaNuevaR').before(newElem);                   
                    cont2=cont2+1;
                });
                                
                $('#btnDelR').click(function() {
                    var num = cont2; // how many "duplicatable" input fields we currently have
                    $('#numRN' + num).remove(); // remove the last element
                    $('#fechaReposicionN' + num).remove(); // remove the last element                    
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
        $obj->setIdFalta($_GET['id']);
        $arregloPeMod = $obj->permisoModificar();
        $fechPer = $obj->fechaPermiso();
        $fechRep = $obj->fechaReposicion();
        ?>
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Modificar Incidencias y Faltas de Asistencia</h3>
            </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
                
                    <label class="control-label col-sm-2" for="IdFalta">Folio:</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="IdFalta" name="IdFalta" value="<?php print_r($arregloPeMod[0]) ?>" readonly>
                    </div>
                    <label class="control-label col-sm-2" for="IdEmpleado">Empleado:</label>
                    <div class="col-sm-10">
                        <?php
                        if ($_SESSION['privilegios'] == 'Administrador' || $_SESSION['privilegios'] == 'Recursos Humanos' || $_SESSION['privilegios'] == 'RH-Almacen'){
                        ?>
                            <select class="form-control" id="IdEmpleado" name="IdEmpleado" required>
                                <option value="<?php print_r($arregloPeMod[1]) ?>"><?php print_r($arregloPeMod[1]) ?> - <?php print_r($arregloPeMod[8]) ?></option>
                                <?php $obj->consultaEmpleados(); ?>
                            </select>
                        <?php
                        }else{
                            $obj->setIdEmpleado($_SESSION['IdEmpleado']);
                        ?>
                            <select class="form-control" id="IdEmpleado" name="IdEmpleado">
                                <?php $obj->consultaNombreEmpleado();?>
                            </select>
                        <?php
                        }
                        ?>
                    </div>
                    <label class="control-label col-sm-2" for="IdJefeInmediato">Jefe inmediato:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="IdJefeInmediato" name="IdJefeInmediato" required>
                            <option value="<?php print_r($arregloPeMod[2]) ?>"><?php print_r($arregloPeMod[2]) ?> - <?php print_r($arregloPeMod[9]) ?></option>
                            <?php $obj->consultaJefeInmediato(); ?>
                        </select>
                    </div>
                    <label class="control-label col-sm-2" for="fechaSolicitud">Fecha solicitud:</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="fechaSolicitud" name="fechaSolicitud" value="<?php print_r($arregloPeMod[3]) ?>">
                    </div>
                    <label class="control-label col-sm-2" for="fechaSolicitud">Fecha(s) de permiso:</label>
                    <div class="col-sm-12">
                        <br>
                    </div>
                    <?php
                        for ($i = 0; $i < count($fechPer); $i++){
                            if($fechPer[0][0]== "" && $fechPer[0][1] == ""){
                                echo '
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <input class="form-control" readonly value="No hay datos para mostrar">
                                    </div>
                                ';
                            }else{
                                echo '
                                    <div id="campo1P" class="col-sm-1 col-sm-offset-1">
                                        <input class="form-control" id="numP'.$fechPer[$i][0].'" name="numP" value="'.$fechPer[$i][0].'" readonly>
                                    </div>
                                    <div id="campo2P" class="col-sm-10">
                                        <input id="fechaPermiso'.$fechPer[$i][0].'" type="date" class="form-control" name="fechaPermiso'.$fechPer[$i][0].'" value="'.$fechPer[$i][1].'">
                                    </div>
                                ';
                            }
                        }
                    ?>
                    <div class="col-sm-12">
                        <br>
                        <h4 style="text-align: center">Agregar fecha(s) (Opcional)</h4>
                    </div>
                    <?php
                        for ($i = 1; $i < 2; $i++){
                            echo '
                                <div id="campo1PN" class="col-sm-1 col-sm-offset-1">
                                    <input class="form-control" id="numPN'.$i.'"  name="numPN" value="'.$i.'" readonly>
                                </div>
                                <div id="campo2PN" class="col-sm-10">
                                    <input id="fechaPermisoN'.$i.'" type="date" class="form-control" name="fechaPermisoN'.$i.'">
                                </div>
                            ';
                        }
                    ?>
                    <div id="copiaNuevaP"></div>
                    <div class="col-sm-11"></div>
                    <div class="col-sm-1">
                        <button type="button" class="btn btn-default pull-left" id="btnAddP">+</button>
                        <button type="button" class="btn btn-default pull-right" id="btnDelP">-</button>
                    </div>
                    <div class="col-sm-12">
                        <br>
                    </div>
                    <label class="control-label col-sm-2" for="motivo">Motivo del permiso:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="motivo" name="motivo" required>
                            <option value="<?php print_r($arregloPeMod[4]) ?>"><?php print_r($arregloPeMod[4]) ?></option>
                            <option value="Sin goce de salario">Sin goce de salario</option>
                            <option value="Ocho días con salario por matrimonio">Ocho días con salario por matrimonio</option>
                            <option value="Incapacidad">Incapacidad</option>
                            <option value="Asistencia a cursos">Asistencia a cursos</option>
                            <option value="Con reposición de tiempo">Con reposición de tiempo</option>
                            <option value="Cuatro días con salario por fallecimiento de familiar directo">Cuatro días con salario por fallecimiento de familiar directo</option>
                            <option value="Entrada / salida irregulares">Entrada / salida irregulares</option>
                            <option value="Cumpleaños diferido">Cumpleaños diferido</option>
                            <option value="Encomienda oficial">Encomienda oficial</option>
                            <option value="Cumpleaños puntualidad">Cumpleaños puntualidad</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <label class="control-label col-sm-2" for="motivoDiferente">Motivo diferente:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4" id="motivoDiferente" name="motivoDiferente" maxlength="280" required><?php print_r($arregloPeMod[5]) ?></textarea>
                    </div>
                    <label class="control-label col-sm-2" for="fechaSolicitud">Fecha(s) de reposición:</label>
                    <div class="col-sm-12">
                        <br>
                    </div>
                    <?php
                        for ($i = 0; $i < count($fechRep); $i++){
                            if($fechPer[0][0]== "" && $fechPer[0][1] == ""){
                                echo '
                                    <div class="col-sm-10 col-sm-offset-2">
                                        <input class="form-control" readonly value="No hay datos para mostrar">
                                    </div>
                                ';
                            }else{
                                echo '
                                    <div id="campo1P" class="col-sm-1 col-sm-offset-1">
                                        <input class="form-control" id="numR'.$fechRep[$i][0].'" name="numR" value="'.$fechRep[$i][0].'" readonly>
                                    </div>
                                    <div id="campo2P" class="col-sm-10">
                                        <input id="fechaReposicion'.$fechRep[$i][0].'" type="date" class="form-control" name="fechaReposicion'.$fechRep[$i][0].'" value="'.$fechRep[$i][1].'">
                                    </div>
                                ';
                            }
                        }
                    ?>
                    <div class="col-sm-12">
                        <br>
                        <h4 style="text-align: center">Agregar fecha(s) (Opcional)</h4>
                    </div>
                    <?php
                        for ($i = 1; $i < 2; $i++){
                            echo '
                                <div id="campo1RN" class="col-sm-1 col-sm-offset-1">
                                    <input class="form-control" id="numRN'.$i.'"  name="numRN" value="'.$i.'" readonly>
                                </div>
                                <div id="campo2RN" class="col-sm-10">
                                    <input id="fechaReposicionN'.$i.'" type="date" class="form-control" name="fechaReposicionN'.$i.'">
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
                    <div class="col-sm-12">
                        <br>
                    </div>
                    <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" rows="4" id="observaciones" name="observaciones" maxlength="280" required><?php print_r($arregloPeMod[6]) ?></textarea>
                    </div>
                    <label class="control-label col-sm-2" for="estatus">Estado:</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="motivo" name="estatus" required>
                            <option value="<?php print_r($arregloPeMod[7]) ?>"><?php print_r($arregloPeMod[7]) ?></option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="No aprobado">No aprobado</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-primary" name="permisoModificar">Guardar</button>
                        <a href="permisoConsulta.php" class="btn btn-default">Regresar</a>
                        <a href="index.php" class="btn btn-default">Salir</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>

