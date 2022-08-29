<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de productos';
        $('#dtPlantilla').DataTable( {
    //      destroy: Es para borrar la tabla principal y  no interfiera con la nueva
            destroy: true,
            responsive: true,
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
            ]
        } );
    } );
</script>
<?php
include 'prestadores.php';
$con = new prestadores();
$filtro1 = $_POST["filtro1"];
$filtro2 = $_POST["filtro2"];
$filtro3 = $_POST["filtro3"];
$filtro4 = $_POST["filtro4"];

$con ->setFiltro1($filtro1);
$con ->setFiltro2($filtro2);
$con ->setFiltro3($filtro3);
$con ->setFiltro4($filtro4);

?>
<table id="dtPlantilla" class="display" cellspacing="0" width="100%">
    <thead>
        <?php $con ->tituloConsulta1(); ?>
    </thead>
    <tfoot>
        <?php $con ->tituloConsulta1(); ?>
    </tfoot>
    <tbody>
        <?php $con ->consultaFiltro();?>
    </tbody>
</table>

<!--Desarrollado por: Carlos Valentín Camacho Veloz-->