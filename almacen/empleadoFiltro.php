<?php
 include './loginSecurity.php';
  if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Recursos Humanos' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
//    Este script actualiza las propiedades del DataTable en cada cambio
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de Personal';
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
include 'empleado.php';
$obj = new empleado();
$obj ->setCodigoUDG($_POST['filtro1']);
$obj ->setNombre($_POST['filtro2']);
$obj ->setIdArea($_POST['filtro3']);
$obj ->setIdNombramiento($_POST['filtro4']);
$obj ->setCargaHoraria($_POST['filtro5']);
$obj ->setExtension($_POST['filtro6']);
$obj ->setEstado($_POST['filtro7']);
?>
    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosEmpleado(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosEmpleado(); ?>
        </tfoot>
        <tbody>
            <?php $obj ->consultaEmpleado() ?>
        </tbody>
    </table>