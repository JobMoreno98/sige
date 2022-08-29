<?php
include './loginSecurity.php';
     if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
include 'permiso.php';
$obj = new permiso();

$obj ->setIdEmpleado($_POST['filtro1']);
$obj ->setFechaSolicitud($_POST['filtro2']);
$obj ->setFechaPermiso($_POST['filtro3']);
$obj ->setMotivo($_POST['filtro4']);
$obj ->setEstatus($_POST['filtro5']);
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
    var arregloDT = <?php echo json_encode($obj->consultaPermiso()); ?>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de Permisos';
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
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosPermiso(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosPermiso(); ?>
        </tfoot>
        <tbody>
        </tbody>
    </table>