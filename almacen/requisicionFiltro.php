<?php
 include './loginSecurity.php';
         if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Ayudante Almacén' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
include 'requisicion.php';
$obj = new requisicion();
$obj ->setFolio($_POST['filtro1']);
$obj ->setFechaRequisicion($_POST['filtro2']);
$obj ->setResponsableAlmacen($_POST['filtro4']);
$obj ->setIdEmpleado($_POST['filtro5']);
$obj ->setTipo($_POST['filtro6']);
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
    var arregloDT = <?php echo json_encode($obj->requisicionConsulta()); ?>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de requisiciones';
        $('#dtPlantilla').DataTable( {
//          destroy: Es para borrar la tabla principal y  no interfiera con la nueva
            destroy: true,
            "data": arregloDT,
            "order": [[ 0, "desc" ]],
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

?>
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosRequisicion(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosRequisicion(); ?>
        </tfoot>
        <tbody>
        </tbody>
    </table>