<!DOCTYPE html>
<?php
//Consultar librerias de pdfMaker para mayor información y cambios.
include './loginSecurity.php';
include 'requisicion.php';
$obj = new requisicion();
$obj->setIdRequisicion($_GET['id']);
?>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>BPEJ. Sistema Integral de Gestión</title>
        <link rel="shortcut icon" href="favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="author" content="Valentín Camacho Veloz, Daniel Flores Rodriguez, Brian Valentín Franco, Nancy García Mesillas">
        <script src='js/pdfmake.min.js'></script>
        <script src='js/vfs_fonts.js'></script>
    </head>
    <body>
    <script>
      var reqMatPDF = <?php echo json_encode($obj->consultaRequisicionMaterialPDF()); ?>;
       var reqPDF = <?php echo json_encode($obj->consultaRequisicionPDF()); ?>;
      var tabla = [];
for (i = 0; i < reqMatPDF.length; i++) {
    tabla.push([reqMatPDF[i][0], reqMatPDF[i][1], reqMatPDF[i][2]]);
}
      
  var prueba = {
    
    info: {
        title:'Formato de Requisición',
        author:'Sistema Integral de Gestión BPEJ',
        subject:'Requisición',
        keywords:'Requisición'
    },
    
    pageSize:'A4',
    pageMargins:[50,45,50,85],
    
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
         {
            image: 'biblioteca',
            width: 200,
            alignment:'left',
            margin: [0, 0, 0, 25]
        },
        {text: 'UNIVERSIDAD DE GUADALAJARA\n\
BIBLIOTECA PÚBLICA DEL ESTADO DE JALISCO\n\
"JUAN JOSÉ ARREOLA"\n\
\n\ Requisición de Material de '+ reqPDF[0] +'\n\ ', style: 'header', alignment:'center'},
        {
                style: 'tableExample',
                table: {
                        widths: ['auto', '*'],
                        body: [
                                [{text: 'Folio:', bold: true}, reqPDF[1]],
                                [{text: 'IdWeb:', bold: true}, reqPDF[2]],
                                [{text: 'Fecha:', bold: true}, reqPDF[3]],
                                [{text: 'Nombre del solicitante:', bold: true}, reqPDF[4]],
                                [{text: 'Coordinación a la que pertenece:', bold: true}, reqPDF[5]]
                        ]
                }
        },
        
        {
            style: 'tableHead',
            table: {
                    widths: [ 35, 372, 60],
                    body: [
                            [{border: [true, true, true, false], text: 'Núm.', style: 'tableHeader', alignment: 'center'}, 
                                {border: [true, true, true, false], text: 'Artículo', style: 'tableHeader', alignment: 'center'}, 
                                {border: [true, true, true, false], text: 'Cantidad', style: 'tableHeader', alignment: 'center'}],
                    ]
            }
        },
        
        {
            style: 'tableExample',
            table: {
                    widths: [ 35, 372, 60],
                    body: tabla
            }
        },
        {
            style: 'tableExample',
            table: {
                    widths: [ '*', '*'],
                    body: [
                            ['\n\ \n\ \n\ ', ''],
                            [{text: 'Nombre y Firma del Coordinador', alignment: 'center'}, {text: 'Responsable de Almacén\n\(nombre y firma)', alignment: 'center'}]
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
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',
        
        biblioteca: 'data:image/jpeg;base64,/9j/4QAYRXhpZgAASUkqAAgAAAAAAAAAAAAAAP/sABFEdWNreQABAAQAAAA8AAD/4QP3aHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wLwA8P3hwYWNrZXQgYmVnaW4\n\
9Iu+7vyIgaWQ9Ilc1TTBNcENlaGlIenJlU3pOVGN6a2M5ZCI/PiA8eDp4bXBtZXRhIHhtbG5zOng9ImFkb2JlOm5zOm1ldGEvIiB4OnhtcHRrPSJBZG9iZSBYTVAgQ29yZSA1LjMtYzAxMSA2Ni4xNDU2NjEsIDIwMTIvMDIvMDY\n\
tMTQ6NTY6MjcgICAgICAgICI+IDxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyI+IDxyZGY6RGVzY3JpcHRpb24gcmRmOmFib3V0PSIiIHhtbG5zOnhtcE1NPS\n\
JodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvbW0vIiB4bWxuczpzdFJlZj0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL3NUeXBlL1Jlc291cmNlUmVmIyIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC\n\
8xLjAvIiB4bWxuczpkYz0iaHR0cDovL3B1cmwub3JnL2RjL2VsZW1lbnRzLzEuMS8iIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0idXVpZDo1RDIwODkyNDkzQkZEQjExOTE0QTg1OTBEMzE1MDhDOCIgeG1wTU06RG9jdW1lb\n\
nRJRD0ieG1wLmRpZDo0NDAxMkFGMkQxODAxMUU3Qjk1Rjk5MkU0N0EwNUYwOSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDo0NDAxMkFGMUQxODAxMUU3Qjk1Rjk5MkU0N0EwNUYwOSIgeG1wOkNyZWF0b3JUb29sPSJBZG9i\n\
ZSBJbGx1c3RyYXRvciBDUzYgKE1hY2ludG9zaCkiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDoxM0ExNkU2NkNFNjExMUU3OEREQkIxQThEMTFCQUY5NCIgc3RSZWY6ZG9jdW1lbnRJRD0\n\
ieG1wLmRpZDoxM0ExNkU2N0NFNjExMUU3OEREQkIxQThEMTFCQUY5NCIvPiA8ZGM6dGl0bGU+IDxyZGY6QWx0PiA8cmRmOmxpIHhtbDpsYW5nPSJ4LWRlZmF1bHQiPkltcHJpbWlyPC9yZGY6bGk+IDwvcmRmOkFsdD4gPC9kYz\n\
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
pdfMake.createPdf(prueba).download('Requisicion.pdf');
    </script>
    </body>
</html>