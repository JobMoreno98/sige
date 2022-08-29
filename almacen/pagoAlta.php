<?php
session_start();
include '../sige/loginSecurity.php';
if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Finanzas' and $_SESSION['privilegios'] != 'Dirección') {
    header('location: index.php');
}
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="BPEJ">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <style>
            .form-control {
                margin-bottom: 12px;
            }
        </style>
 <script>
            var cont= 1;
            $(document).ready(function() {
//                $('#btnDel').attr('disabled','disabled');
                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1); // the numeric ID of the new input field being added
                    var newElem = $('#campo1').clone().attr('id', 'Add' + newNum);// create the new element via clone(), and manipulate it's ID using newNum value
                    newElem.children(':last').attr('id', 'num' + newNum).attr('name', 'num').val(newNum);// manipulate the name/id values of the input inside the new element
                    $('#copiaNueva').before(newElem); // insert the new element after the last "duplicatable" input field
                    $('#btnDel').attr('disabled',false);// enable the "remove" button
                    if (newNum == 50)//     business rule: you can only add 10 names
                      $('#btnAdd').attr('disabled','disabled');
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo2').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'IdCuenta' + newNum).attr('name', 'IdCuenta' + newNum);
                    $('#copiaNueva').before(newElem);
                    $('#idMaterial'+newNum).focus();//enfoca el articulo al clonar
                });

                $('#btnAdd').click(function() {
                    var newNum = new Number(cont+1);
                    var newElem = $('#campo3').clone().attr('id', 'Add' + newNum);
                    newElem.children(':last').attr('id', 'cantidad' + newNum).attr('name', 'cantidad' + newNum).val('');
                    $('#copiaNueva').before(newElem);
//                    cont = newNum;
                    cont=cont+1;
                });
                
                $('#btnDel').click(function() {
                    var num = cont; // how many "duplicatable" input fields we currently have
                    $('#num' + num).remove(); // remove the last element
                    $('#IdCuenta' + num).remove(); // remove the last element
                    $('#cantidad' + num).remove(); // remove the last element
//                     enable the "add" button
                    $('#btnAdd').attr('disabled',false);
                    if (num == 2)//     business rule: you can only add 10 names
                      $('#btnDel').attr('disabled','disabled');
                    cont=cont-1;
                    $('#idMaterial'+cont).focus();
                });
            });
        </script>
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        
        include 'pago.php';
        $pago = new pago();
        $pago->setAnio($_GET['anio']);
        ?>
        <div class="container">
          <div class="page-header">
              <h3 style="text-align: center">Captura Nuevo Pago</h3>
          </div>
            <form class="form-horizontal" action="aplicarMovimiento.php" method="post" onsubmit="return confirm('¿Seguro que quieres guardar este formulario?');">
            <div class="form-group">
              <label class="control-label col-sm-2" for="numDoctoAfin">Núm. Docto. AFIN:</label>
              <div class="col-sm-10">
                  <input type="number" class="form-control" id="numDoctoAfin" name="numDoctoAfin" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="tipo">Tipo de Trámite:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="tipoTramite" name="tipoTramite" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                    <option>Compra</option>
                    <option>Recibo</option>
                    <option>Reposición</option>
                    <option>Vale</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="beneficiario">Beneficiario:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="beneficiario"  name="beneficiario" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="concepto">Concepto:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="concepto" name="concepto" required>
              </div>
            </div>
           
            <div class="form-group">
            <?php 
                    for ($i = 1; $i < 2; $i++) 
                    {
                        echo '
                        <div class="col-sm-12"><label class="control-label col-sm-2" for="concepto">Cuenta (s):</label>     </div>
                        <div id="campo1" class="col-xs-12 col-sm-3 col-md-2">
                         
                            <input class="form-control" id="num'.$i.'"  name="num" value="'.$i.'" readonly>
                        </div>
                        <div id="campo2" class="col-xs-12 col-sm-7 col-md-8">
                            <select class="form-control" id="IdCuenta'.$i.'" name="IdCuenta'.$i.'" autofocus required>
                                <option value="" disabled selected>Cuenta:</option>'; 
                        $pago->cuentasListado();
                        echo '
                            </select>
                        </div>
                        <div id="campo3" class="col-xs-12 col-sm-2 col-md-2">
                            <input class="form-control" id="cantidad'.$i.'" name="cantidad'.$i.'" placeholder="Cantidad" required="number">
                        </div>
                        ';
                    }
            ?>

                    <div id="copiaNueva"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-11"></div>
                        <div class="col-sm-1">
                            <button type="button" class="btn btn-default pull-left" id="btnAdd">+</button>
                            <button type="button" class="btn btn-default pull-right" id="btnDel">-</button>
                        </div>
                    </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="noCheque">Núm. Cheque:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="noCheque" name="noCheque" value="0" required>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="estatus">Estatus:</label>
              <div class="col-sm-10">          
                  <select class="form-control" id="estatus" name="estatus" required>
                    <option value="" disabled selected>Sin seleccionar</option>
                    <option>Pagado</option>
                    <option>Sin Pagar</option>
                    <option>CUCSH</option>
                  </select>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2" for="observaciones">Observaciones:</label>
              <div class="col-sm-10">
                  <input type="text" class="form-control" id="observaciones" name="observaciones" value ="-" required>
              </div>
            </div>
              <div class="form-group">        
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary" name="pagoAlta">Guardar</button>
                <a href="pagoConsulta.php" class="btn btn-default">Regresar</a>
              </div>
            </div>
          </form>
        </div>  
    </body>
</html>

