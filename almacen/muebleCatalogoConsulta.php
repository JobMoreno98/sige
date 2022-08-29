<!DOCTYPE html>
<?php
 include './loginSecurity.php';
    
include 'mueble.php';
$mueble = new mueble();
if(isset($_GET['tipo']) and $_GET['tipo']!='') $mueble->setTipo($_GET['tipo']); else  $mueble->setTipo("Todos");
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
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
        <script>
            var arregloDT = <?php echo json_encode($mueble->muebleCatalogoConsulta($mueble->getTipo())); ?>;
            $(document).ready(function(){
                 var t = 'Listado de Cuentas';
                $('#dtPlantilla').DataTable( {
                    "data": arregloDT,
                    "order": [[ 3, "asc" ]],
                    responsive: true,
                    dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
            //                    dom: es el orden de las funciones de la tabla
            //                    l: es la lista de numero de registros que se muestran 
            //                    B: son los botones para imprimir
            //                    f: es el filtro de busqueda
            //                    rt: son los registros de la tabla
            //                    i: es la información de registros
            //                    p: es la barra de paginación
            //tipo='Contemporáneo 2da Generación'tipo='Contemporáneo Belenes'"
                    buttons: [
                        {
                            extend: 'print',
                            title: t
                        },
                        {
                            extend: 'pdf',
                            title: t
                        },

                        {
                            extend: 'excel',
                            title: t
                        }
                    ]
                });
            });
        </script>
    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        ?>
        
        <div class="container-fluid">
            <div class="page-header">
                <h3 style="text-align: center">
                    
                    
                    <?php
                    if ($mueble->getTipo()=='Histórico') {
                    echo'<img src="../../sige/images/librero.png">';
                    }
                    ?>
                    <?php
                    if ($mueble->getTipo()=='Contemporáneo 2da Generación') {
                    echo'<img src="../../sige/images/biblioteca.png">';
                    }
                    ?>
                    <?php
                    if ($mueble->getTipo()=='Contemporáneo Belenes') {
                    echo'<img src="../../sige/images/anaquel.png">';
                    }
                    ?>
                    <?php
                    if ($mueble->getTipo()=='Todos') {
                    echo'<img src="../../sige/images/cajon.png">';
                    }
                    ?>
                    
                    
                    Catálogo de Mobiliario <?php echo $mueble->getTipo(); 
                    echo "<br>";
                    
                        if($mueble->getTipo()=='Histórico') $descripcion="Estos muebles incluyen mobiliario histórico que actualmente ya no es usuado pero se tiene como decorativo, además de pinturas y esculturas";
                        if($mueble->getTipo()=='Contemporáneo 2da Generación') $descripcion="Estos muebles incluyen mobiliario gran parte del mobiliario que se encuentra en la sede Agua Azul";
                        if($mueble->getTipo()=='Contemporáneo Belenes') $descripcion="Estos muebles incluyen la compra que se realizó para la sede Belenes cuando se inaguró";
                        echo "<small>".$descripcion."</small>";
                    ?>
                    
                </h3>
          </div>
             <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>IdCatálogo</th>        
                            <th>Origen</th> 
                            <th>Tipo</th>
                            <th>Descripción</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Medidas</th>
                            <th>Categoría</th>
                            <th>ImgFrente</th>
                            <th>ImgLateral</th>  
                            <?php
                            if($_SESSION['privilegios'] == 'Administrador' or $_SESSION['privilegios'] == 'Sistemas'){
                                echo "<th>IdTipoSIIAU</th>";
                                echo "<th>Acción</th>";
                            }
                            if($mueble->getTipo()=='Histórico' and $_SESSION['privilegios'] == 'EncargadoCatHist'){
                                echo "<th>Acción</th>";
                            }
                            if($mueble->getTipo()=='Contemporáneo 2da Generación' and $_SESSION['privilegios'] == 'EncargadoCat2daG'){
                                echo "<th>Acción</th>";
                            }
                            if($mueble->getTipo()=='Contemporáneo Belenes' and $_SESSION['privilegios'] == 'EncargadoCat3raG'){
                                echo "<th>Acción</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
             <!--tabla de consulta-->
             <a href="index.php" class="btn btn-default">Salir</a>    
        </div>
        
        <br>
    </body>
</html>