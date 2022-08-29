<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Sistemas') {
    header('location: index.php');
}
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de usuarios';
        $('#dtPlantilla').DataTable( {
//          destroy: Es para borrar la tabla principal y  no interfiera con la nueva
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
include 'usuario.php';
$obj = new usuario();
$obj ->setNombreUsuario($_POST['filtro1']);
$obj ->setUsuario($_POST['filtro2']);
$obj ->setPrivilegios($_POST['filtro3']);
$obj ->setIdEmpleado($_POST['filtro4']);
?>
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosUsuario(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosUsuario(); ?>
        </tfoot>
        <tbody>
            <?php $obj ->consultaUsuario() ?>
        </tbody>
    </table>