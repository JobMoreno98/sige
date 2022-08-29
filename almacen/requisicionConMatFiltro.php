<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'Ayudante Almacén' and $_SESSION['privilegios'] != 'RH-Almacen' and $_SESSION['privilegios'] != 'Dirección') {
    header('location: index.php');
}
include 'requisicion.php';
$obj = new requisicion();
$obj->setIdMaterial($_POST['id']);
$obj ->setFechaRequisicion($_POST['filtro1']);
$obj ->setCantidad($_POST['filtro2']);
$obj ->setIdArea($_POST['filtro3']);
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
    var t = 'Detalle de Entregas por Artículo';
    var arregloDT = <?php echo json_encode($obj->consultaSalidasPorMaterial()); ?>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
        $('#dtPlantilla').DataTable( {
//          destroy: Es para borrar la tabla principal y  no interfiera con la nueva
            destroy: true,
            "data": arregloDT,
            "order": [[ 0, "desc" ]],
            dom: '<"col-sm-5"l><"col-sm-3"B><"col-sm-4"f>rtip',
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
            ],
        
            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages
                total = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Total over this page
                pageTotal = api
                    .column( 6, { page: 'current'} )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                // Update footer
                $( api.column( 6 ).footer() ).html(
                    ''+pageTotal +' ( '+ total +' en total)'
                );
            }
        } );
    } );
</script>
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
                    <thead>
                        <tr>   
                            <th>ID Req.</th>      
                            <th>Folio</th>      
                            <th>Fecha</th>      
                            <th>Área</th>      
                            <th>Piso</th>      
                            <th>Edificio</th>      
                            <th>Cantidad</th>         
                            <th>Mostrar</th>         
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th colspan="6" style="text-align:right">Suma de registros:</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                    <tbody>
                    </tbody>
                </table>