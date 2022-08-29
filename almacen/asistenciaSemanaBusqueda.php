<!DOCTYPE html>
<?php
ini_set('session.cache_limiter','public');
session_cache_limiter(false);
    include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
         header('location: index.php');
    }
    if (sizeof($_POST) == 0 || !isset($_POST)) {
      header('location: asistenciaSemana.php');
    }
    require_once('horarioCumplido.php');
    require_once('pdf_make.php');
    $pdf = new pdf_make();
    $meses = array(
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
    );


    if (isset($_POST['semanaBusquedaSubmit'])) {
        $date = new DateTime($_POST['semanaBusqueda']);
    }elseif (isset($_POST['semanaAnterior'])) {
        $date = new DateTime($_POST['semanaAnterior']);
    }elseif (isset($_POST['semanaSiguiente'])) {
        $date = new DateTime($_POST['semanaSiguiente']);
    }else{
        $date = new DateTime($_POST['semana']);
    }

    $semana = $date->format("Y")."W".$date->format("W");

    $obj = new horarioCumplido();
    $data = $obj->getTable($semana, $_POST['tipoReporte']);
    $inicio = explode("/", date('Y/m/d', strtotime($semana."1")));
    $fin = explode("/", date('Y/m/d', strtotime($semana."7")));
    $titulo = "";
    if ($inicio[1] == $fin[1]) {
        $titulo = $_POST['tipoReporte']." - del ".$inicio[2]." al ".$fin[2]." de "
        .$meses[intval($inicio[1])-1]." ".$inicio[0];
    }else{
        $titulo = $_POST['tipoReporte']." - del ".$inicio[2]." de ".$meses[intval($inicio[1])-1]
        ." al ".$fin[2]." de ".$meses[intval($fin[1])-1]." ".$inicio[0];
    }

    $tituloPDF = explode("-", $titulo);
    $tituloPDF[1] = trim($tituloPDF[1]);
    $tituloPDF[0] = trim($tituloPDF[0]);

    $encode = $pdf->getWeekEncode($data);

    // Semana siguiente
    $siguiente = date('Y-m-d', strtotime('+1 day', strtotime(
        $fin[0]."-".$fin[1]."-".$fin[2]
    )));
    //$siguiente = new DateTime($siguiente);
    //$siguiente = $siguiente->format("Y")."W".$siguiente->format("W");

    // Semana anterior
    $anterior = date('Y-m-d', strtotime('-1 day', strtotime(
        $inicio[0]."-".$inicio[1]."-".$inicio[2]
    )));



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
            var arregloDT = <?php echo json_encode($data); ?>;
            $(document).ready(function(){
                 var t = 'Reporte Semanal de Asistencias';
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
                                    pageOrientation: 'landscape',
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
                                                margin: [420, 0, 0, 0],
                                                alignment: 'right',
                                                layout: { defaultBorder: false},
                                                table: {
                                                    body: [
                                                        [
                                                            {text: '<?php echo $tituloPDF[0] ?>', fontSize: 14, bold:true}
                                                        ],
                                                        [
                                                            {text: 'Semana <?php echo $tituloPDF[1] ?>', fontSize: 10}
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
                                            text: 'Registros de asistencia',
                                            margin: [0, 0, 0, 5]
                                        },
                                        {
                                            fontSize: 11.5,
                                            margin: [0, 0, 0, 100],
                                            table: {
                                                widths: [
                                                    '22%',
                                                    '3%',
                                                    '5%',
                                                    '10%',
                                                    '10%',
                                                    '10%',
                                                    '10%',
                                                    '10%',
                                                    '10%',
                                                    '10%'
                                                        ],
                                                headerRows: 1,
                                                body: [
                                                    [
                                                        { text: 'Nombre', bold: true },
                                                        { text: 'CH', bold: true },
                                                        { text: 'Hrs. x Sem.', bold: true },
                                                        { text: 'Lunes <?php echo date('d', strtotime($semana."1"))?>', bold: true },
                                                        { text: 'Martes <?php echo date('d', strtotime($semana."2"))?>', bold: true },
                                                        { text: 'Miércoles <?php echo date('d', strtotime($semana."3"))?>', bold: true },
                                                        { text: 'Jueves <?php echo date('d', strtotime($semana."4"))?>', bold: true },
                                                        { text: 'Viernes <?php echo date('d', strtotime($semana."5"))?>', bold: true },
                                                        { text: 'Sabado <?php echo date('d', strtotime($semana."6"))?>', bold: true },
                                                        { text: 'Domingo <?php echo date('d', strtotime($semana."7"))?>', bold: true }
                                                    ],
                                                    <?php echo $encode ?>
                                                ]
                                            }

                                        },
                                        {
                                            alignment: 'center',
                                            canvas: [ { type: 'rect', x: 300, y: 0, w: 170, h: 40 } ],
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
                                } //dd
                                pdfMake.createPdf(docDefinition)
                                    .download('<?php echo $titulo?>.pdf');
                            }
                        },

                        {
                            extend: 'excel',
                            title: t
                        }
                    ]
                });
            });
        </script>

        <style>
            #dateArea{
                width: 10%;
                margin-top: 10px;
                margin-bottom: 35pt;
                background-color: red;
            }
            #boton{
                float: right;
                position: relative;
            }
            #semana{
                width: 72%;
                float: left;
            }
        </style>

    </head>
    <body>
        <?php
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();

        ?>
        <div class="container-fluid">
            <div class="page-header">
                <h3 style="text-align: center"><?php echo $titulo; ?></h3>

                <div class="d-flex justify-content-center" align="center">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                        <input name="tipoReporte" type="hidden" value="<?php echo $_POST['tipoReporte'] ?>"/>

                        <button type="submit" class="btn btn-default" name="semanaAnterior"
                        value="<?php echo $anterior ?>">
                             <span class="glyphicon glyphicon-chevron-left"></span>
                        </button>
                        <button type="submit" class="btn btn-default" name="semanaSiguiente"
                        value="<?php echo $siguiente ?>">
                             <span class="glyphicon glyphicon-chevron-right"></span>
                        </button>

                        <div id="dateArea">
                            <input id="semana" type="date" class="form-control" name="semanaBusqueda"
                            value="<?php echo $date->format('m-d-Y') ?>"/>

                            <button id="boton" type="submit" class="btn btn-default" name="semanaBusquedaSubmit">
                                 <span class="glyphicon glyphicon-arrow-right"></span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>

            <!--tabla de consulta-->
            <div id="respuestaFiltro">
                <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>CH</th>
                            <th>Hrs. x Sem.</th>
                            <th>Lunes <?php echo date('d', strtotime($semana."1"))?></th>
                            <th>Martes <?php echo date('d', strtotime($semana."2"))?></th>
                            <th>Miércoles <?php echo date('d', strtotime($semana."3"))?></th>
                            <th>Jueves <?php echo date('d', strtotime($semana."4"))?></th>
                            <th>Viernes <?php echo date('d', strtotime($semana."5"))?></th>
                            <th>Sábado <?php echo date('d', strtotime($semana."6"))?></th>
                            <th>Domingo <?php echo date('d', strtotime($semana."7"))?></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

             <!--tabla de consulta-->
             <a href="asistenciaSemana.php" class="btn btn-default">Regresar</a>
             <a href="index.php" class="btn btn-default">Salir</a>
        </div>

        <br>
    </body>
</html>
