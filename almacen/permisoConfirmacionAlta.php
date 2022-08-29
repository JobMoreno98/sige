<!DOCTYPE html>
<?php
 include './loginSecurity.php';

?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!--bootstrap-->
        <link rel="stylesheet" href="css/bootstrap.css"><!-- Editado para el menu -->
        <!--jquery-->
        <script src="js/jquery-3.2.1.min.js"></script>
        <!--bootstrap-js-->
        <script src="js/bootstrap.min.js"></script>
        
        <script src='js/pdfmake.min.js'></script>
        <script src='js/vfs_fonts.js'></script>
    </head>
    <body>
        <?php 
        include 'barraMenu.php';
        $menu = new menu();
        $menu ->barraMenu();
        
        
        
        if(isset($_POST['permisoAlta']))//Valida si se envía el formulario
        {
            include 'permiso.php';
            $obj = new permiso();
            
            $obj ->setIdEmpleado($_POST['idEmpleado']);
            $obj ->setFechaSolicitud($_POST['fechaSolicitud']);
            $obj ->setFechaPermiso($_POST['fechaPermiso']);
            $obj ->setJefeInmediato($_POST['jefeInmediato']);
            $obj ->setMotivo($_POST['motivo']);
            $obj ->setObservaciones($_POST['observaciones']);
            if (isset($_POST['estatus'])) {
                $obj->setEstatus($_POST['estatus']);
            }
            else 
            {
                $obj->setEstatus('Pendiente');

            }
            $obj ->permisoAlta();
            $nombreArea = $obj->consultaNombreAreaEmpleado();
            ?>
<script>
      var folio = '<?php echo $obj->consultaIdPermiso();?>';
      var empleado = '<?php print_r($nombreArea[0]); ?>';
      var codigoUDG = '<?php print_r($nombreArea[2]); ?>';
      var area = '<?php print_r($nombreArea[1]); ?>';
      var fechaSolicitud = '<?php echo $obj->getFechaSolicitud();?>';
      var fechaPermiso = '<?php echo $obj->getFechaPermiso();?>';
      var jefeInmediato = '<?php echo $obj->getJefeInmediato();?>';
      var motivo = '<?php echo $obj->getMotivo();?>';
      var observaciones = '<?php echo $obj->getObservaciones();?>';
      var m1 = '';
      var m2 = '';
      var m3 = '';
      var m4 = '';
      var m5 = '';
      var m6 = '';
      var m7 = '';
      var m8 = '';
      var m9 = '';
      var m10 = '';
      var m11 = '';
      var m12 = '';
      
      switch (motivo) {
        case 'Permiso sin goce de salario':
            m1 = '*';
            break;
        case 'Permiso de ocho dias con goce de salario por matrimonio civil':
            m2 = '*';
            break;
        case 'Incapacidad(diferida)':
            m3 = '*';
            break;
        case 'Permiso para asistir a cursos':
            m4 = '*';
            break;
        case 'Permiso con reposición de tiempo':
            m5 = '*';
            break;
        case  'Permiso de cuatro días hábiles con goce de salario cuando fallezca familiar directo':
            m6 = '*';
            break;
        case  'Entrada/Salida irregulares (reposición de horas)':
            m7 = '*';
            break;
        case  'Cumpleaños (diferido)':
            m8 = '*';
            break;
        case  'Permiso por encomienda oficial':
            m9 = '*';
            break;
        case  'Día de descanso por cumpleaños':
            m10 = '*';
            break;
        case  'Cláusula Núm. 65 Fracción II':
            m11 = '*';
            break;
        case  'Cláusula Núm. 65 Fracción III':
            m12 = '*';
            break;
     }
  var prueba = {
    
    info: {
        title:'Formato de Permisos',
        author:'Sistema Integral de Gestión BPEJ',
        subject:'Permisos',
        keywords:'Permisos'
    },
    
    pageSize:'A4',
    pageMargins:[50,60,50,85],
    
    header: function(currentPage,pageCount) {
        return {
            text: currentPage.toString() + ' de ' + pageCount,
            alignment: 'right',
            margin:[0,30,20,0]
        };
    },
    footer: [
        {
            image: 'udg',
            width: 50,
            alignment:'right',
            margin: [0, 0, 25, 0]
        }
    ],
    
    content: [
        {text: 'UNIVERSIDAD DE GUADALAJARA\n\
CENTRO UNIVERSITARIO DE CIENCIAS SOCIALES Y HUMANIDADES\n\
BIBLIOTECA PÚBLICA DEL ESTADO DE JALISCO\n\
"JUAN JOSÉ ARREOLA"\n\
\n\
REGISTRO DE INCIDENCIAS Y FALTAS DE ASISTENCIA', style: 'header', alignment:'center'},
        {
                style: 'tableExample',
                table: {
                        widths: ['auto', '*'],
                        body: [
                                ['Folio:', folio],
                                ['Nombre del solicitante:', empleado],
                                ['Código UDG:', codigoUDG],
                                ['Coordinación a la que pertenece:', area],
                                ['Fecha de solicitud:', fechaSolicitud],
                                ['Fecha del permiso:', fechaPermiso]
                        ]
                }
        },
        {
            style: 'tableExample',
            table: {
                    widths: [ 210, 19, 210, 19],
                    body: [
                            [{text: 'Motivo del permiso', style: 'tableHeader', colSpan: 4, alignment: 'center'}, {}, {}, {}],
                            ['Permiso sin goce de salario\n\ ', {text: m1, alignment: 'center'}, 'Entrada/Salida irregulares (reposición de horas)', {text: m7, alignment: 'center'}],
                            ['Permiso de ocho dias con goce de salario por matrimonio civil', {text: m2, alignment: 'center'}, 'Cumpleaños (diferido)\n\ \n\ ', {text: m8, alignment: 'center'}],
                            ['Incapacidad(diferida)\n\ ', {text: m3, alignment: 'center'}, 'Permiso por encomienda oficial', {text: m9, alignment: 'center'}],
                            ['Permiso para asistir a cursos\n\ ', {text: m4, alignment: 'center'}, 'Día de descanso por cumpleaños', {text: m10, alignment: 'center'}],
                            ['Permiso con reposición de tiempo\n\ ', {text: m5, alignment: 'center'}, 'Cláusula Núm. 65 Fracción II', {text: m11, alignment: 'center'}],
                            ['Permiso de cuatro días hábiles con goce de salario cuando fallezca familiar directo', {text: m6, alignment: 'center'}, 'Cláusula Núm. 65 Fracción III', {text: m12, alignment: 'center'}],
                            [{text: 'Observaciones:\n\ '+observaciones, colSpan: 4}, {}, {}, {}]
                    ]
            }
        },
        {
            style: 'tableExample',
            table: {
                    widths: [ '*', '*', '*'],
                    body: [
                            [{text: empleado, fontSize: 9, alignment: 'center'}, {text: jefeInmediato, fontSize: 9, alignment: 'center'}, '\n\ \n\ \n\ '],
                            [{text: 'Nombre y firma del trabajador', alignment: 'center'}, {text: 'Jefe inmediato\n\(nombre y firma)', alignment: 'center'}, {text: 'C.P Y LAE.\n\CARLOS PEÑA RAZO\n\Coordinador de Recursos Humanos', alignment: 'center'}]
                    ]
            }
        }
    ],
    images: {
		udg: 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAJ4AAADdCAYAAABKScu5AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS5\n\
4bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1j\n\
MDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbi\n\
ByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9i\n\
ZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6Mjk4MUE4RENERTFBMTFFN0IwN\n\
ERFNTA4RkUxNzcwOTgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6Mjk4MUE4RERERTFBMTFFN0IwNERFNTA4RkUxNzcwOTgiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoyOTgxQTh\n\
EQURFMUExMUU3QjA0REU1MDhGRTE3NzA5OCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDoyOTgxQThEQkRFMUExMUU3QjA0REU1MDhGRTE3NzA5OCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wb\n\
WV0YT4gPD94cGFja2V0IGVuZD0iciI/Pnh7Tv0AAChySURBVHja7F3tdZtKt5545b3ve39ZpwKRCkQqMK7AnAqMKwipILiC4AqMK4hcgVEFQRUEVXDkX/eu+8dX4zw72tqe4UuAkMysxbKFxAAzz+zv2fvDy8uLGtvY+m5n4xC\n\
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'
            },
    styles: {
		header: {
			fontSize: 14,
			bold: true,
			margin: [0, 0, 0, 0]
		},
		subheader: {
			fontSize: 16,
			bold: true,
			margin: [0, 0, 0, 0]
		},
		tableExample: {
			margin: [0, 0, 0, 5]
		},
		tableHeader: {
			bold: true,
			fontSize: 13,
			color: 'black'
		}
	}
};

$(document).ready(function() {
    $('#btnAdd').click(function() {
         pdfMake.createPdf(prueba).download('Permiso.pdf');
    });
 });
  </script>
        <div class="container">
            <center><button type="button" class="btn btn-success" id="btnAdd">Descargar Documento</button></center>
        </div>
        <div class="container">
            <br>
            <center><a href="permisoAlta.php" class="btn btn-default">Crear nuevo</a>
                <a href="index.php" class="btn btn-default">Salir</a></center>
        </div>
        <?php
        }
        ?>
    </body>
</html>
