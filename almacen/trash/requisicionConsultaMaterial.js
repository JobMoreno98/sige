$(document).ready(function(){
    $('#dtPlantilla').DataTable( {
        "data": arregloDT,
        "order": [[ 0, "desc" ]],
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
    });
    

    
       $("#filtros").keyup(function()
    {
        var x = $(this).serialize();
        $.ajax(
                {
                url: 'requisicionConMatFiltro.php',
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
        $('input[type="date"]').val('');
        var x = $("#filtros").serialize("");
        $.ajax(
                {
                url: 'requisicionConMatFiltro.php',
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

