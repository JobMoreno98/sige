// Función para cargar las propiedades del DataTable
$(document).ready(function(){
//     Cambiar el titulo de la variable según el nombre del módulo o tabla
     var t = 'Listado de compras';
    $('#dtPlantilla').DataTable( {
        "data": arregloDT,
        "order": [[ 0, "desc" ]],
        responsive: true,
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
});