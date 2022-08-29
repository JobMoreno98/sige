<!DOCTYPE html>
<?php
    include './loginSecurity.php';
    require_once("Asistencia_gr.php");
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas' and $_SESSION['privilegios'] != 'Recursos Humanos') {
            header('location: index.php');
        }else {
            if(isset($_POST['tag'])){
                require_once('horarioCumplido.php');
                $obj = new horarioCumplido();

                $obj->actualizarHorarioBD($_POST['tag'], $_POST['horaEntrada'], $_POST['horaSalida']);
                $fromUpdate = array();
                $fromUpdate['fecha'] = $_POST['fecha'];
                $fromUpdate['idEmpleado'] = $_POST['idEmpleado'];
                $_SESSION['fromUpdate'] = $fromUpdate;

                header('location: asistenciaMesBusqueda.php');
            }elseif (isset($_POST['actualizarHora'])){
                // Posible accion
            }else{
                header('location: index.php');
            }
        }

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Cargar Asistencia</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        <!--Datatables-->
        <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="js/jquery.dataTables.js"></script><!-- Editado -->
        <!--Datatables responsive-->
        <link rel="stylesheet" type="text/css" href="css/responsive.dataTables.min.css"/>
        <script type="text/javascript" src="js/dataTables.responsive.min.js"></script>
        <!--Datatables Buttons-->
        <link rel="stylesheet" type="text/css" href="css/buttons.dataTables.css"/><!-- Editado y menu -->
        <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="js/buttons.html5.min.js"></script>
        <script type="text/javascript" src="js/pdfmake.min.js"></script><!--Imprimir PDF-->
        <script type="text/javascript" src="js/vfs_fonts.js"></script><!-- Imprimir PDF-->
        <script type="text/javascript" src="js/jszip.min.js"></script><!--Imprimir Excel-->
        <script type="text/javascript" src="js/buttons.print.min.js"></script><!--Imprimir pantalla-->

        <script >
            window.onload = function(){
                document.getElementById("cambiar").onclick = function() {cambiarHoras()};
                document.getElementById("go").onclick = function() {comparar()};
            }

            function cambiarHoras() {
                var a = document.getElementById("horaEntrada").value;
                var b = document.getElementById("horaSalida").value;
                document.getElementById("horaEntrada").value = b;
                document.getElementById("horaSalida").value = a;
            }

            function comparar(){
                var strHoraEntrada = document.getElementById("horaEntrada").value;
                var strHoraSalida = document.getElementById("horaSalida").value;
                if (strHoraSalida == "" || strHoraEntrada == ""){
                    alert("Ambos campos son obligatorios");
                }else{
                    var arregloEntrada = strHoraEntrada.split(":");
                    var arregloSalida = strHoraSalida.split(":");
                    var hhEntrada = parseInt(arregloEntrada[0], 10);
                    var mmEntrada = parseInt(arregloEntrada[1], 10);
                    var hhSalida = parseInt(arregloSalida[0], 10);
                    var mmSalida = parseInt(arregloSalida[1], 10);

                    if (hhEntrada<hhSalida || (hhEntrada==hhSalida && mmEntrada<mmSalida)){
                        document.getElementById("formActualizar").submit();
                    }else{
                        alert("La hora de salida no puede ser menor que la de entrada");
                    }
                }
            }
        </script>

    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>

        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Actualizar horario capturado</h3>
                <h4 style="text-align: center">
                    <?php echo $_POST['fecha']?> - <?php echo $_POST['nombre']?>
                </h4>
            </div>

            <form class="form-horizontal" role="form" id="formActualizar"
                  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <input type="hidden" name="tag" value="<?php echo $_POST['idRegistro'] ?>"/>
                <input type="hidden" name="fecha" value="<?php echo $_POST['fecha'] ?>"/>
                <input type="hidden" name="idEmpleado" value="<?php echo $_POST['idEmpleado'] ?>"/>

                <div class="col-sm-2"></div>

                <div class="form-group col-sm-4">
                    <label class="control-label" for="horaEntrada">Hora de entrada actual:</label>
                    <div>
                        <input id="horaEntrada" type="time" class="form-control" name="horaEntrada" required
                               value="<?php echo $_POST['horaEntrada'] ?>"/>
                    </div>
                </div>


                <div class="form-group col-sm-4">
                    <label class="control-label" for="horaSalida">Hora de salida actual:</label>
                    <div>
                        <input id="horaSalida" type="time" class="form-control" name="horaSalida" required/>
                    </div>
                </div>

                <div class="col-sm-2"></div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button name="cambiar" id="cambiar" type="button" class="btn">
                            <span class="glyphicon glyphicon-resize-horizontal"></span>
                        </button>
                        <button id="go" type="button" class="btn btn-primary">Actualizar</button>
                        <a href="index.php" class="btn btn-default">Regresar</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>
