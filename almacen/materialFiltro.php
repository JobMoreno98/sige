<?php
 include './loginSecurity.php';
    if ($_SESSION['privilegios'] != 'Administrador' and $_SESSION['privilegios'] != 'Encargado Almacén' and $_SESSION['privilegios'] != 'Ayudante Almacén' and $_SESSION['privilegios'] != 'RH-Almacen') {
    header('location: index.php');
}
include 'material.php';
$obj = new material();
$obj ->setDescripcion($_POST['filtro1']);
$obj ->setExistencia($_POST['filtro3']);
$obj ->setStock($_POST['filtro4']);
$obj ->setCaducidad($_POST['filtro5']);
$obj ->setNivelExistencia($_POST['filtro6']);
$obj ->setUso($_POST['filtro7']);
$obj ->setTipo($_POST['filtro8']);
?>
<!--este documento devuelve la respuesta de AJAX dentro del <div id="respuestaFiltro"> actualizando la tabla-->
<script>
    $(document).ready(function(){
//        Cambiar el titulo de la variable según el nombre del módulo o tabla
        var t = 'Listado de Materiales';
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

    <table id="dtPlantilla" class="display" cellspacing="0" width="100%">
        <thead>
            <?php $obj ->titulosMaterial(); ?>
        </thead>
        <tfoot>
            <?php $obj ->titulosMaterial(); ?>
        </tfoot>
        <tbody>
            <?php $obj->consultaMaterial(); ?>
        </tbody>
    </table>