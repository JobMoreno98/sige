<!DOCTYPE html>
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
    include './loginSecurity.php';
         if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
        header('location: index.php');
    }
    include 'horarioCumplido.php';
    require_once('pdf_make.php');

    if(isset($_SESSION['fromUpdate']) && !isset($_POST['fromQuery'])){
        $_POST['mes'] = substr($_SESSION['fromUpdate']['fecha'], -10);
        $_POST['IdEmpleado'] = $_SESSION['fromUpdate']['idEmpleado'];
        //$_SESSION['fromUpdate'] = null;
    }

    if (isset($_POST['mes'])) {
        $obj = new horarioCumplido();
        $obj->setIdEmpleado($_POST['IdEmpleado']);
        $nombre = $obj->consultaNombreEmpleado();
        $obj->setMes($_POST['mes']);
        $datos = $obj->horarioCumplidoConsulaMes();
        $permisos = $obj->permisosMes();
    }else{
        header('location: asistenciaMes.php');
    }


/*}elseif(isset($_SESSION['fromUpdate'])) {
        $obj = new horarioCumplido();
        $obj->setMes($_SESSION['fromUpdate']['fecha']);
        $obj->setIdEmpleado($_SESSION['fromUpdate']['idEmpleado']);
        $nombre = $obj->consultaNombreEmpleado();
        $datos = $obj->horarioCumplidoConsulaMes();
        $_SESSION['fromUpdate'] = null;*/

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Equipo de desarollo BPEJ">
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

        <?php
            $datos = $obj->horarioCumplidoConsulaMes();
            $pdf = new pdf_make();
            $encode = $pdf->getMonthEncode($datos, $nombre[1]);
            $permisoEncode = $pdf->permisoEncode($permisos);
        ?>
        <?php
            $empleado = $obj->getIdEmpleado();
            $horarios = $obj->getHorarioCumplir($empleado);
            $formato = array();

            $x = 0;
            while($x < sizeof($horarios)){
                switch($horarios[$x]['dia']){
                    case "Lunes":
                    $formato[0] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                    case "Martes":
                    $formato[1] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                    case "Miercoles":
                    $formato[2] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                    case "Jueves":
                    $formato[3] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                    case "Viernes":
                    $formato[4] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                    case "Sabado":
                    $formato[5] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                    case "Domingo":
                    $formato[6] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                    case "Vacacional":
                    $formato[7] = $horarios[$x]['horaEntrada']." - ".$horarios[$x]['horaSalida'];
                    break;
                }
                $x++;
            }
        ?>


        <script>
            var arregloDT = <?php echo json_encode($datos); ?>;

            $(document).ready(function(){
                 var t = 'Reporte Mensual de Asistencias';
                $('#dtPlantilla').DataTable( {
                    "data": arregloDT,
                    "order": [[ 0, "asc" ]],
                    responsive: true,
                    dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
            //                    dom: es el orden de las funciones de la tabla
            //                    l: es la lista de numero de registros que se muestran
            //                    B: son los botones para imprimir
            //                    f: es el filtro de busqueda
            //                    rt: son los registros de la tabla
            //                    i: es la información de registros
            //                    p: es la barra de paginación
                    buttons: [

                        {
                            text: 'PDF',
                            action: function ( e, dt, node, config ) {
                                var docDefinition = {
                                    pageMargins: [30, 80, 30, 40],
                                    header: {
                                        margin: 10,
                                        columns: [
                                            {
                                                image: '<?php echo $pdf->getImage64() ?>',
                                                width: 180,
                                                margin: [20, 0, 0, 0]
                                            },
                                            {
                                                margin: [170, 0, 0, 0],
                                                alignment: 'right',
                                                layout: { defaultBorder: false},
                                                table: {
                                                    body: [
                                                        [
                                                            {text: 'Reporte de <?php echo $pdf->monthName($obj->getMes())?>', fontSize: 14, bold:true}
                                                        ],
                                                        [
                                                            {text: '<?php echo $nombre[0]?>', fontSize: 10}
                                                        ],
                                                        [
                                                            {text: 'Codigo UDG: <?php echo $nombre[1]?>', fontSize: 8}
                                                        ]
                                                    ]
                                                }
                                            }
                                        ]
                                    },
                                    footer: function(page, pages) {
                                        return {
                                            columns: [
                                                '',
                                                {
                                                    alignment: 'right',
                                                    text: [
                                                        { text: page.toString(), italics: true },
                                                        ' de ',
                                                        { text: pages.toString(), italics: true }
                                                    ]
                                                }
                                            ],
                                            margin: [10, 0]
                                        };
                                    },
                                    content: [
                                        {
                                            text: 'Horario a cumplir',
                                            margin: [0, 0, 0, 5]
                                        },
                                        {
                                            margin: [0, 0, 0, 20],
                                            style: 'horario',
                                            table:{
                                                widths: ['12.5%', '12.5%', '12.5%', '12.5%', '12.5%', '12.5%', '12.5%', '12.5%'],
                                                headerRows:1,
                                                body: [
                                                    [
                                                        {text: 'Lunes', bold: true},
                                                        {text: 'Martes', bold: true},
                                                        {text: 'Miércoles', bold: true},
                                                        {text: 'Jueves', bold: true},
                                                        {text: 'Viernes', bold: true},
                                                        {text: 'Sábado', bold: true},
                                                        {text: 'Domingo', bold: true},
                                                        {text: 'Vacacional', bold: true}
                                                    ],
                                                    [
                                                        '<?php echo $formato[0] ?>',
                                                        '<?php echo $formato[1] ?>',
                                                        '<?php echo $formato[2] ?>',
                                                        '<?php echo $formato[3] ?>',
                                                        '<?php echo $formato[4] ?>',
                                                        '<?php echo $formato[5] ?>',
                                                        '<?php echo $formato[6] ?>',
                                                        '<?php echo $formato[7] ?>'
                                                    ]
                                                ]
                                            }
                                        },
                                        {
                                            text: 'Permisos',
                                            margin: [0, 0, 0, 5]
                                        },
                                        {
                                            alignment: 'center',
                                            margin: [0, 0, 0, 20],
                                            style: 'horario',
                                            table:{
                                                widths: ['100%'],
                                                headerRows:1,
                                                body: [
                                                    [
                                                        {text: 'Fecha y motivo del permiso', bold: true}
                                                    ], <?php echo $permisoEncode ?>
                                                ]
                                            }
                                        },
                                        {
                                            text: 'Registros de asistencia',
                                            margin: [0, 0, 0, 5]
                                        },
                                        {
                                            margin: [0, 0, 0, 100],
                                            table: {
                                                widths: ['10%', '20%', '17.5%', '17.5%', '17.5%', '17.5%'],
                                                headerRows: 1,
                                                body: [
                                                    [ { text: 'Codigo UDG', bold: true },
                                                    { text: 'Fecha', bold: true },
                                                    { text: 'Hora Entrada', bold: true },
                                                    { text: 'Hora Salida', bold: true },
                                                    { text: 'Diferencia', bold: true },
                                                    { text: 'Permiso', bold: true } ],
                                                    <?php echo $encode ?>
                                                ]
                                            }
                                        },
                                        {
                                            alignment: 'center',
                                            canvas: [ { type: 'rect', x: 180, y: 0, w: 170, h: 40 } ],
                                            margin: [0, 0, 0, 2]
                                        },
                                        {
                                            text: 'Firma de visto bueno',
                                            alignment: 'center'
                                        },
                                    ],
                                    styles: {
                                        header: {fontSize: 16, bold: true},
                                        subheader: {fontSize: 14, bold:false},
                                        distinct: {fontSize: 8, italics:true},
                                        horario: {fontSize: 10}
                                    }
                                } //docDefinition
                                pdfMake.createPdf(docDefinition)
                                    .download('<?php echo $pdf->monthName($obj->getMes())." - ".$nombre[0]?>.pdf');
                            }// action

                        },
                        {extend: 'excel',
                        title: t}
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
        <div class="container">
            <div class="page-header">
                <h3 style="text-align: center">Reporte Mensual de Asistencias - <?php echo $nombre[0] ?></h3>
            </div>

            <div id="horarioCumplir" class="table-responsive-md">
                <div class="col-sm-12">
                    <h4>Horario a cumplir</h4>
                    <table class="table table-hover table-condesed table-bordered">
                        <thead align="center" style="font-weight:bold;">
                            <tr>
                                <td>Lunes</td>
                                <td>Martes</td>
                                <td>Miércoles</td>
                                <td>Jueves</td>
                                <td>Viernes</td>
                                <td>Sábado</td>
                                <td>Domingo</td>
                                <td>Vacacional</td>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>
                                <td><?php echo $formato[0];?></td>
                                <td><?php echo $formato[1];?></td>
                                <td><?php echo $formato[2];?></td>
                                <td><?php echo $formato[3];?></td>
                                <td><?php echo $formato[4];?></td>
                                <td><?php echo $formato[5];?></td>
                                <td><?php echo $formato[6];?></td>
                                <td><?php echo $formato[7];?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="permisos" class="table-responsive-md">
                <div class="col-sm-12">
                    <h4>Permisos</h4>
                    <table class="table table-hover table-condesed table-bordered">
                        <thead align="center" style="font-weight:bold;">
                            <tr>
                                <td>Fecha</td>
                            </tr>
                        </thead>
                        <tbody align="center">
                            <tr>
                                <?php
                                foreach ($permisos as $p) {
                                    echo "<tr>";
                                    echo $p;
                                    echo "</tr>";
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Fecha</th>
                            <th>Hora de entrada</th>
                            <th>Hora de salida</th>
                            <th>Diferencia</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

             <!--tabla de consulta-->
             <a href="asistenciaMes.php" class="btn btn-default">Regresar</a>
             <a href="index.php" class="btn btn-default">Salir</a>
        </div>

        <br>
    </body>
</html>
