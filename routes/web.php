<?php

use Illuminate\Routing\Route as RoutingRoute;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
//     return view('home');
// })->name('dashboard');

Route::middleware(["auth:sanctum", "verified"])
    ->get("/", [App\Http\Controllers\HomeController::class, "index"])
    ->name("home");

Route::resource("usuarios", "App\Http\Controllers\UsuariosController");
Route::resource("roles", "App\Http\Controllers\RolesController");
Route::resource("permisos", "App\Http\Controllers\PermisosController");

Route::get("asignar-permisos/{id}", [
    "as" => "asignar_permisos",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\RolesController@relacionar",
]);

Route::post("guardar-relacion-permisos", [
    "as" => "guardar_relacion_permisos",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\RolesController@guardarRelacion",
]);

Route::resource("equipos", "App\Http\Controllers\EquipoController");
Route::resource("areas", "App\Http\Controllers\AreaController");
Route::resource("movimientos", "App\Http\Controllers\MovimientoController");
Route::resource("inventario", "App\Http\Controllers\InventarioController");
Route::resource("tickets", "App\Http\Controllers\TicketController");
Route::resource("prestamos", "App\Http\Controllers\PrestamoController");
Route::resource("mobiliarios", "App\Http\Controllers\MobiliarioController");
Route::resource("cursos", "App\Http\Controllers\CursoController");
Route::resource("logs", "App\Http\Controllers\LogController");
Route::resource("licencias", "App\Http\Controllers\LicenciaController");
Route::resource("servicios", "App\Http\Controllers\ServicioController");
Route::resource("tecnicos", "App\Http\Controllers\TecnicoController");
Route::resource(
    "mantenimiento",
    "App\Http\Controllers\MantenimientoController"
);
Route::resource("llaves", "App\Http\Controllers\LlavesController");
Route::resource("personal", "App\Http\Controllers\PersonalController");
Route::resource("bajas", "App\Http\Controllers\BajaController");

Route::resource("expedientes", "App\Http\Controllers\ExpedienteController");
/*Route::resource(
    "mantenimientoEquipos",
    "App\Http\Controllers\mantenimientoEquipoController"
);*/
Route::resource('requisicion', 'App\Http\Controllers\RequisicionController');
Route::resource('articulo', 'App\Http\Controllers\ArticuloController');

Route::post("personal_search", [
    // 'as' => 'personal_search',
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PersonalController@search",
])->name("personal.search");

Route::get("/personal_export-pdf", [
    // 'as' => 'personal_search',
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PersonalController@DT_exportPDF",
])->name("personal.exportPDF");

Route::get("/personal_export-excel", [
    // 'as' => 'managestaff',
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PersonalController@DT_exportExcel",
])->name("personal.exportExcel");

Route::get("/cambiar-ubicacion/{equipo_id}/{tipo?}", [
    "as" => "cambiar-ubicacion",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\MovimientoController@create",
]);
Route::get("/revision-inventario", [
    "as" => "revision-inventario",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@revisionInventario",
]);
Route::get("/inventario-cta", [
    "as" => "inventario-cta",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@inventario_cta",
]);
///Prueba Inventario express////
Route::get("/inventario-express-detalle", [
    "as" => "inventario-express-detalle",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@inventario_express",
]);

Route::get("/inventario-express-detalle2", [
    "as" => "inventario-express-detalle2",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@inventario_express2",
]);

///Prueba Inventario express////

Route::post("/equipo-encontrado/{origen?}", [
    "as" => "equipo-encontrado",
    "middleware" => "auth",
    "uses" =>
        "\App\Http\Controllers\InventarioController@listarEquipoEncontrado",
]);
Route::get("/delete-equipo/{equipo_id}", [
    "as" => "delete-equipo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@delete_equipo",
]);
Route::get("/registro-inventario/{equipo_id}/{origen}", [
    "as" => "registro-inventario",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@registroInventario",
]);
Route::post("/busqueda", [
    "as" => "busqueda",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@busqueda",
]);
Route::post("/busquedaEquiposTicket", [
    "as" => "busquedaEquiposTicket",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@busquedaEquiposTicket",
]);
Route::post("/busquedaEquiposPrestamo", [
    "as" => "busquedaEquiposPrestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@busquedaEquiposPrestamo",
]);
Route::get("/prestamos-all", [
    "as" => "prestamos-all",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@prestamos_all",
]);
Route::get("/busquedaAvanzada", [
    "as" => "busquedaAvanzada",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@busquedaAvanzada",
]);
Route::post("/filtroTickets", [
    "as" => "filtroTickets",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TicketController@filtroTickets",
]);
Route::get("/generar-prestamo/{equipo_id}", [
    "as" => "generar-prestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@generarPrestamo",
]);
Route::get("/nuevo-prestamo", [
    "as" => "nuevo-prestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@nuevoPrestamo",
]);
Route::post("/agregar-accesorio", [
    "as" => "agregar-accesorio",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@agregarAccesorio",
]);
Route::post("/busquedaEquiposPrestamo", [
    "as" => "busquedaEquiposPrestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@busquedaEquiposPrestamo",
]);
Route::post("/guardar-nuevo-prestamo", [
    "as" => "guardar-nuevo-prestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@guardarPrestamo",
]);
Route::get("/quitar-equipo-prestado/{equipo_prestado}/{prestamo_id}", [
    "as" => "quitar-equipo-prestado",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@quitarEquipoPrestado",
]);
Route::get("/historial/{equipo_id}", [
    "as" => "historial",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\MovimientoController@historial",
]);

Route::get("/imprimirPrestamo/{prestamo_id}", [
    "as" => "imprimirPrestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PDFController@imprimirPrestamo",
]);

/////////
Route::get("/borrarPrestamo/{prestamo_id}", [
    "as" => "borrarPrestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@delete_Prestamo",
]);

Route::get("/devolverPrestamo/{prestamo_id}", [
    "as" => "devolverPrestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@devolver_prestamo",
]);
//////////

Route::get("/revisionTickets", [
    "as" => "revisionTickets",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TicketController@revisionTickets",
]);
Route::get("/recepcionEquipo/{ticket_id}", [
    "as" => "recepcionEquipo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TicketController@recepcionEquipo",
]);
Route::get("/prestamoEquipos/{prestamo_id}", [
    "as" => "prestamoEquipos",
    "middleware" => "auth",
    "uses" => "\App\Http\Controllers\PrestamoController@prestamoEquipos",
]);

Route::get("/registrarEquipoTicket/{equipo_id}/{ticket_id}", [
    "as" => "registrarEquipoTicket",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TicketController@registrarEquipoTicket",
]);
Route::get("/registrarEquipoPrestamo/{equipo_id}/{prestamo_id}", [
    "as" => "registrarEquipoPrestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@registrarEquipoPrestamo",
]);

Route::get("/eliminarEquipoTicket/{equipo_id}/{ticket_id}", [
    "as" => "eliminarEquipoTicket",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TicketController@eliminarEquipoTicket",
]);
Route::get("/eliminarEquipoPrestamo/{item_id}", [
    "as" => "eliminarEquipoPrestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@eliminarEquipoPrestamo",
]);

Route::get("/imprimirRecibo/{ticket_id}", [
    "as" => "imprimirRecibo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PDFController@imprimirRecibo",
]);
Route::get("/delete-ticket/{ticket_id}", [
    "as" => "delete-ticket",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TicketController@delete_ticket",
]);
Route::get("/delete-area/{area_id}", [
    "as" => "delete-area",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\AreaController@delete_area",
]);
Route::get("/delete-licencia/{licencia_id}", [
    "as" => "delete-licencia",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\LicenciaController@delete_licencia",
]);
Route::get("/delete-servicio/{servicio_id}", [
    "as" => "delete-servicio",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\ServicioController@delete_servicio",
]);
Route::get("/delete-prestamo/{prestamo_id}", [
    "as" => "delete-prestamo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@delete_prestamo",
]);
Route::get("/delete-mobiliario/{mobiliario_id}", [
    "as" => "delete-mobiliario",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\MobiliarioController@delete_mobiliario",
]);
Route::get("/panel-inventario/{area_id?}", [
    "as" => "panel-inventario",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@inventario_express2",
]);
Route::post("/panel-inventario/{area_id?}", [
    "as" => "panel-prueba",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@panel",
]);
Route::get("/inventario-por-area/{area_id}", [
    "as" => "inventario-por-area",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@inventario_por_area",
]);
Route::get("/actualizacion-inventario/{area_id}", [
    "as" => "actualizacion-inventario",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\InventarioController@actualizacion_inventario",
]);
Route::get("/revision-inventario-anual", [
    "as" => "revision-inventario-anual",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\RevisionAnualEquipo@revision_inventario_anual",
]);
Route::get("/inventario-localizado", [
    "as" => "inventario-localizado",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@inventario_localizado",
]);
Route::get("/documento/{filename}", [
    "as" => "documento",
    "uses" => "App\Http\Controllers\PrestamoController@obtenerdocumento",
]);
Route::get("/inventario-detalle/{area_id}", [
    "as" => "inventario-detalle",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@inventario_detalle",
]);
Route::get("/imprimir-ticket/{ticket_id}", [
    "as" => "imprimir-ticket",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PrestamoController@generarPrestamo",
]);
Route::post("/agregar-comentario", [
    "as" => "agregar-comentario",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TicketController@agregarComentario",
]);
Route::post("/filtroCursos", [
    "as" => "filtroCursos",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\CursoController@filtroCursos",
]);
Route::post("/busqueda-Curso", [
    "as" => "busqueda-curso",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\CursoController@busquedaCurso",
]);
Route::post("/filtro-Curso", [
    "as" => "filtro-curso",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\CursoController@filtroCurso",
]);
Route::get("/delete-curso/{curso_id}", [
    "as" => "delete-curso",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\CursoController@delete_curso",
]);
Route::get("/cursos-presenciales/{ciclo}", [
    "as" => "cursos-presenciales",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\CursoController@cursos_presenciales",
]);
Route::get("/cursos-laboratorios/{ciclo}", [
    "as" => "cursos-laboratorios",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\CursoController@cursos_laboratorios",
]);

Route::get("/area-ticket/{sede}", [
    "as" => "area-ticket",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\AreaController@area_ticket",
]);
Route::get("/images/{filename}", [
    "as" => "images",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\AreaController@getImage",
]);
Route::get("/ticket-historial/{id}", [
    "as" => "ticket-historial",
    "uses" => "App\Http\Controllers\TicketController@historial",
]);

Route::resource("proyectos", "App\Http\Controllers\ProyectoController");
Route::resource(
    "proyecto-actividad",
    "App\Http\Controllers\ProyectoActividadController"
);
Route::get("/proyecto-actividad/{id_proyecto}/create", [
    "as" => "proyecto-actividad",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\ProyectoActividadController@create",
]);
Route::get("/select/equipo", [
    "as" => "select-equipo",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\ProyectoActividadController@getEquipos",
]);
Route::get("/estadisticas", [
    "as" => "estadisticas",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\InventarioController@dashboard_inventario",
]);
Route::get("/lista_servicios", [
    "as" => "lista_servicios",
    "uses" => "App\Http\Controllers\ServicioController@inicio",
]);

/* Apartado de Subredes e IP´S*/
Route::resource("subredes", "App\Http\Controllers\SubredController");
Route::resource("ips", "App\Http\Controllers\IpController");
Route::get("/delete-subred/{subred_id}", [
    "as" => "deletesubred",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\SubredController@delete_subred",
]);
Route::post("/filtroSubredes", [
    "as" => "filtroSubredes",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\SubredController@filtroSubredes",
]);

Route::post("/filIps", [
    "as" => "filIps",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\IpController@filtro_p_ip",
]);

Route::post("/filtroIps", [
    "as" => "filtroIps",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\IpController@filtroIps",
]);
Route::post("/filtroIpsasig", [
    "as" => "filtroIpsasig",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\IpController@filtroIpsasig",
]);
Route::get("/asignadas", [
    "as" => "asignadas",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\IpController@asignadas",
]);
Route::get("/delete-ip/{ip_id}", [
    "as" => "delete-ip",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\IpController@delete_ip",
]);

// Tecnicos
Route::get("/lista_de_tecnicos", [
    "as" => "lista_de_tecnicos",
    "uses" => "App\Http\Controllers\TecnicoController@index",
]);
Route::get("/delete-tecnico/{tecnico_id}", [
    "as" => "delete-tecnico",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\TecnicoController@delete_tecnico",
]);

// Mantenimiento
Route::get("/lista_de_mantenimiento", [
    "as" => "lista_de_mantenimiento",
    "uses" => "App\Http\Controllers\MantenimientoController@index",
]);
Route::get("/delete-mantenimiento/{id}", [
    "as" => "delete-mantenimiento",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\MantenimientoController@delete_mantenimiento",
]);
Route::get("/update-mantenimiento", [
    "as" => "update-mantenimiento",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\MantenimientoController@update",
]);
Route::post("/busquedaEquiposMantenimiento", [
    "as" => "busquedaEquiposMantenimiento",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\MantenimientoController@busquedaEquiposMantenimiento",
]);
Route::get("/agregarequipomantenimiento/{mantenimiento_id}/{equipo_id}", [
    "as" => "agregarequipomantenimiento",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\MantenimientoController@agregarequipomantenimiento",
]);
Route::get("/eliminarequipomantenimiento/{mantenimiento_id}/{equipo_id}", [
    "as" => "eliminarequipomantenimiento",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\MantenimientoController@eliminarequipomantenimiento",
]);
Route::get("/estadoMantenimiento/{mantenimiento_id}/{equipo_id}", [
    "as" => "estadoMantenimiento",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\MantenimientoController@estadoMantenimiento",
]);
Route::get("/mantenimiento_detalle", [
    "as" => "mantenimiento_detalle",
    "middleware" => "auth",
    "uses" =>
        "App\Http\Controllers\MantenimientoController@mantenimiento_detalle",
]);
Route::get("/agregar-equipos", [
    "as" => "agregar-equipos",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\MantenimientoController@show",
]);
Route::post("buscador-mantenimiento/{infomantenimiento}", [
    "as" => "buscador-mantenimiento",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\MantenimientoController@buscador",
]);
Route::post('/mantenimiento-equipo{equipo_id}', array(
    'as' => 'mantenimiento-equipo',
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\ExpedienteController@mantenimientoEquipo'
));

Route::get('/delete-man-equipo{man_id}', array(
    'as' => 'delete-man-equipo',
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\ExpedienteController@delete_mantenimiento'
));
//Expediente
Route::get("/expediente/{equipo_id}", [
    "as" => "expediente",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\ExpedienteController@expediente",
]);


Route::get('/Imprimirexpediente/{equipo}/', array(
    'as' => 'Imprimirexpediente',
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\ExpedienteController@Imprimirexpediente'
));

//Requisicion
Route::post("/crear_requisicion", [
    "as" => "crear_requisicion",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\RequisicionController@store",
]);
//Llaves
Route::get("/delete_llaves/{id}", [
    "as" => "delete_llaves",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\LlavesController@delete_llaves",
]);
Route::get("/agregarllaves", [
    "as" => "agregarllaves",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\LlavesController@agregarllaves",
]);
Route::get("/devolverllave/{llave_id}", [
    "as" => "devolverllave",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\LlavesController@devolverllave",
]);
Route::get("/seleccionarllave/{llave_id}", [
    "as" => "seleccionarllave",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\LlavesController@seleccionarllave",
]);
Route::post("buscador-llaves", [
    "as" => "buscador-llaves",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\LlavesController@buscador",
]);
//Personal
Route::get("/delete-personal/{id}", [
    "as" => "delete-personal",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PersonalController@delete_personal",
]);
Route::get("/imprimirpersonal/{id}", [
    "as" => "imprimirpersonal",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\PDFController@imprimirpersonal",
]);

//Bajas

Route::get("/delete-baja/{baja_id}", [
    "as" => "delete-baja",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\BajaController@delete_baja",
]);

Route::put("baja/{baja_id}", [
    "as" => "update-baja",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\BajaController@update",
]);

Route::get("/delete-item/{item_id}", [
    "as" => "delete-item",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\BajaController@delete_item",
]);

Route::get("/{id}/edit", [
    "as" => "bajas.edit",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\BajaController@edit",
]);

Route::get("/imprimirBaja/{baja_id}", [
    "as" => "imprimirBaja",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\BajaController@imprimirBaja",
]);

Route::get('../storage/app/documentos/{filename}', array(
    'as' => 'documentos',
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\BajaController@getDocument'
));

//Rutas para los switches

//filtrar switches
Route::post("/filtroNumero_serie", [
    "as" => "filtroNumero_serie",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@filtroNumero_serie",
]);


Route::get("/switches", [
    "as" => "switches",
    "uses" => "App\Http\Controllers\EquipoController@switches",
]);

 Route::get("/create_switch",[
    "as" => "create_switch",
    "uses" => "App\Http\Controllers\EquipoController@createSw",
 ]);

 Route::post("/created_switch",[
    "as" => "created_switch",
    "uses" => "App\Http\Controllers\EquipoController@storeSw",
 ]);

 Route::get("/{id}/edit_switch",[
    "as" => "equipo.edit_switch",
    "uses" => "App\Http\Controllers\EquipoController@editSW",
 ]);

 
 Route::post("update-switch/{id}", [
    "as" => "update-switch",
    "middleware" => "auth",
    "uses" => "App\Http\Controllers\EquipoController@updateSW",
]);
//Requisicion
Route::resource('requisiciones', '\App\Http\Controllers\RequisicionController');

Route::get('/imprimirrequisicion/{id}', array(
    'as' => 'imprimirrequisicion',
    'middleware' => 'auth',
    'uses' => 'App\Http\Controllers\PDFController@imprimirrequisicion'
));
//Articulo_requisicion
Route::resource('articulos', '\App\Http\Controllers\ArticuloController');

Route::get('requisicion/{id}/articulos/create',);

Route::get('requisicion/{id}/articulos/create', array(
    'as' => 'requisicion-articulos-create',
    'middleware' => 'auth',
    'uses' => '\App\Http\Controllers\ArticuloController@create'
));
Route::get('requisicion/{id}/articulos/', array(
    'as' => 'requisicion-articulos',
    'middleware' => 'auth',
    'uses' => '\App\Http\Controllers\ArticuloController@index'
));

Route::get('/tickets/tomar-ticket/{id}', array(
    'as' => 'tomar-ticket',
    'middleware' => 'auth',
    'uses' => '\App\Http\Controllers\TicketController@tomar_ticket'
));

Route::get('/equipo-area/{id}', array(
    'as' => 'equipo-area',
    'middleware' => 'auth',
    'uses' => '\App\Http\Controllers\AreaController@equipo_area'
));