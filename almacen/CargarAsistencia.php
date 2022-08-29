<!DOCTYPE html>
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
    include './loginSecurity.php';
    require_once("Asistencia_gr.php");
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas' and $_SESSION['privilegios'] != 'Recursos Humanos') {
            header('location: index.php');
        }else {
        /*
        Esta clase tiene relacion con Asistencia_gr.
        Esta pagina incluye un formulario que manda con POST
        2 parametros, uno es el mes que se desea cargar y otro
        es una bandera. El formulario redirecciona a esta misma pagina
        2 veces de forma que divide el numero total de registros
        y los carga por partes.
        */
            if (!isset($_SESSION['post'])) {
                /*
                Esto inicializa la variable de cache en sesion
                */
                $_SESSION['post'] = null;
            }
            if (isset($_POST['sumbit'])) {
                /*
                submit es una bandera, si esta seteada significa que es
                la primera pasada.
                */
                $_SESSION['post'] = $_POST;
                /*
                Se inicializa una variable de cache en la sesion
                para almacenar la segunda parte de los registros
                */
                $cargarAsistencia = new Asistencia_gr();
                // Obtener los registros que se van a cargar
                $inputArray = $cargarAsistencia->getRegistros($_POST['date']);
                // Obtener el numero de registros totales para dividirlos
                $len = sizeof($inputArray);
                // Partir el arreglo que contiene los registros en 2
                //$primeraParte = array_slice($inputArray, 0, $len/2);
                //$segundaParte = array_slice($inputArray, $len/2);

                $primeraParte = array_splice($inputArray, 0, ceil($len / 2));
                $segundaParte = $inputArray;
                /*
                Inicializar una variable para saber el numero de registros
                que ya existen en la base de datos y por lo tanto no se van
                a insertar. La funcion de cargar requiere como parametro
                un arreglo que contenga los registros y devuelve el numero
                de registros duplicados en la base de datos.
                */ 
                $repetidos = $cargarAsistencia->cargar($primeraParte);
                /*
                Guarda la segunda parte de los registros asi como
                el resto de la informacion necesaria en el cache
                para utilizarlos en la segunda pasada.
                Redirecciona a esta misma pagina.
                */
                $_SESSION['post']['segunda'] = $segundaParte;
                $_SESSION['post']['repetidos'] = $repetidos;
                $_SESSION['post']['len'] = $len;
                header('location: CargarAsistencia.php');
            }else{
                try{
                    if (isset($_SESSION['post'])){
                        // Esta condicion solo es valida en la segunda pasada
                        // Obtiene los datos almacenados del cache
                        $cargarAsistencia = new Asistencia_gr();
                        $segundaParte = $_SESSION['post']['segunda'];
                        $repetidos = $_SESSION['post']['repetidos'];
                        $len = $_SESSION['post']['len'];
                        // Comienza la carga de la segunda parte
                        $repetidos = $repetidos + ($cargarAsistencia->cargar($segundaParte));
                        // Hace el calculo del total de registros insertados y repetidos
                        $cargados = $len - $repetidos;
                        // Borra el cache
                        $_SESSION['post'] = null;
                        // Arroja un mensaje en pantalla
                        $mensaje = "Fueron cargados $cargados registros nuevos, $repetidos repetidos.";
                        echo "<script type='text/javascript'>alert('$mensaje');</script>";
                    }
                }catch(Exception $e){
                    $_SESSION['post'] = null;
                    header('location: CargarAsistencia.php');
                }
            }
        }

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Cargar Asistencia</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Valentín Camacho Veloz, Daniel Flores Rodriguez, Brian Valentín Franco, Nancy García Mesillas">
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


    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>

        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Cargar asistencia por mes</h3>
            </div>

            <form class="form-horizontal" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div class="form-group">
                    <label class="control-label col-sm-2" for="mes">Mes:</label>
                    <div class="col-sm-10">
                        <input id="mes" type="date" class="form-control" name="date" required/>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button name="sumbit" type="submit" class="btn btn-primary">Cargar</button>
                        <a href="index.php" class="btn btn-default">Salir</a>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>