// Función para cargar las propiedades del DataTable
$(document).ready(function(){
//     Cambiar el titulo de la variable según el nombre del módulo o tabla
     var t = 'Listado de Áreas';
    $('#dtPlantilla').DataTable( {
        responsive: true,
        "order": [[ 2, "asc" ]],
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
    });
//                Función AJAX para filtrar datatables
//                keyup es el evento para realizar la función cada que se suelte una tecla presionada dentro del formulario
    $("#filtros").keyup(function()
    {
        var x = $(this).serialize();
        $.ajax(
                {
                url: 'areaFiltro.php',
                type: 'POST',
                data: x,
                beforeSend:function() {
                    $("#respuestaFiltro").html('Cargando..');
                },
                success: function(data) {
                    $("#respuestaFiltro").html(data);
                }
                });
    }
    );

//    Función AJAX para limpiar filtros de datatables y actualizar tabla
    $("#limpiar").click(function()
    {
        $('input[type="text"]').val('');
        $('input[type="number"]').val('');
        var x = $("#filtros").serialize("");
        $.ajax(
                {
                url: 'areaFiltro.php',
                type: 'POST',
                data: x,
                beforeSend:function() {
                    $("#respuestaFiltro").html('Cargando..');
                },
                success: function(data) {
                    $("#respuestaFiltro").html(data);
                }
                });
    });
});
