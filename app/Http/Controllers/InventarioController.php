<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\InventarioDetalle;
use App\Models\Vs_Conteo_Por_Area;
use App\Models\Vs_Equipo_Localizado;
use App\Models\Vs_Equipo_Detalle;
use App\Models\VsEquipo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isNull;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*Equipos*/
        $total_equipos = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->first();

        $total_equipos_localizados_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos_localizados_sici"))
            ->where("resguardante", "=", "CTA")
            ->where("localizado_sici", "=", "Si")
            ->first();
        $total_equipos_no_localizados_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos_no_localizados_sici"))
            ->where("resguardante", "=", "CTA")
            ->where("localizado_sici", "=", "No")
            ->first();
        /*Muebles*/
        $total_mobiliario = DB::table("mobiliario")
            ->select(DB::raw("COUNT(*) as cuenta_mobiliario"))
            ->first();
        $total_mobiliario_localizado_sici = DB::table("mobiliario")
            ->select(DB::raw("COUNT(*) as cuenta_mobiliario_localizado_sici"))
            ->where("localizado_sici", "=", "S")
            ->first();
        $total_mobiliario_no_localizado_sici = DB::table("mobiliario")
            ->select(
                DB::raw("COUNT(*) as cuenta_mobiliario_no_localizado_sici")
            )
            ->where("localizado_sici", "=", "N")
            ->first();
        /*Localizados*/
        $total_localizados = DB::table("inventariodetalle")
            ->select(DB::raw("COUNT(*) as cuenta_localizados"))
            ->where("estatus", "=", "Localizado")
            ->first();

        /*Con incidentes*/
        $total_incidentes = DB::table("inventariodetalle")
            ->select(DB::raw("COUNT(*) as cuenta_incidentes"))
            ->where("estatus", "=", "Revision")
            ->first();

        /*No localizados*/
        $total_no_localizados =
            $total_equipos_localizados_sici->cuenta_equipos_localizados_sici -
            $total_incidentes->cuenta_incidentes -
            $total_localizados->cuenta_localizados;

        /*Reportados a contralor�a*/
        $total_equipos_reportados = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos_reportados"))
            ->where("resguardante", "=", "CTA")
            ->where("localizado_sici", "=", "No")
            ->first();
        $total_mobiliario_reportados = DB::table("mobiliario")
            ->select(DB::raw("COUNT(*) as cuenta_mobiliario_reportados"))
            ->where("localizado_sici", "=", "N")
            ->first();
        $total_equipos_reportados->cuenta_equipos_reportados +=
            $total_mobiliario_reportados->cuenta_mobiliario_reportados;

        /*AREAS*/
        $areas = Area::all();

        /*DATA TABLE*/
        //$equipos = VsEquipo::where('id_area','=',$area_id)->get();
        $conteo_por_area = Vs_Conteo_Por_Area::all();
        return view("inventario.estadisticas-generales")
            ->with("total_equipos", $total_equipos)
            ->with("total_mobiliario", $total_mobiliario)
            ->with("total_mobiliario_localizado_sici",$total_mobiliario_localizado_sici)
            ->with("total_mobiliario_no_localizado_sici", $total_mobiliario_no_localizado_sici)
            ->with("total_localizados", $total_localizados)
            ->with("total_incidentes", $total_incidentes)
            ->with("total_no_localizados", $total_no_localizados)
            ->with("total_equipos_reportados", $total_equipos_reportados)
            ->with("conteo_por_area", $conteo_por_area)
            ->with("total_equipos_localizados_sici",$total_equipos_localizados_sici)
            ->with("total_equipos_no_localizados_sici",$total_equipos_no_localizados_sici)
            ->with("areas", $areas);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    //localizado
    public function inventario_localizado()
    {
        $Vsinventario_localizado = Vs_Equipo_Detalle::where(
            "activo",
            "=",
            1
        )->get();
        $inventariolocalizado = $this->cargarDT($Vsinventario_localizado);
        return view("inventario.inventario-localizado")->with(
            "inventariolocalizado",
            $inventariolocalizado
        );
    }

    public function cargarDT($consulta)
    {
        $inventario_localizado = [];

        foreach ($consulta as $key => $value) {
            $ruta = "eliminar" . $value["id"];
            $eliminar = route("delete-ticket", $value["id"]);
            $actualizar = route("tickets.edit", $value["id"]);

            $acciones =
                '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="' .
                $actualizar .
                '" class="btn btn-success" title="Actualizar">
                            <i class="fa fa-edit"></i>
                        </a>
                        <a href="#' .
                $ruta .
                '" role="button" class="btn btn-danger" data-toggle="modal" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="modal fade" id="' .
                $ruta .
                '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">�Seguro que deseas eliminar este curso?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small>
                            ' .
                $value["id"] .
                ", " .
                $value["datos_reporte"] .
                ", " .
                $value["fecha_reporte"] .
                ", " .
                $value["solicitante"] .
                '
                        </small>
                      </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a href="' .
                $eliminar .
                '" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
            ';

            $inventario_localizado[$key] = [
                $acciones,
                $value["id"],
                $value["udg_id"],
                $value["localizado_sici"],
                $value["marca"],
                $value["modelo"],
                $value["numero_serie"],
                $value["detalles"],
                $value["tipo_equipo"],
                $value["area"],
                $value["estatus"],
            ];
        }

        return $inventario_localizado;
    }

    public function inventario_express()
    {
        return view("inventario.inventario_express");
    }

    public function inventario_express2()
    {
        $total_SICI_localizados = DB::table("equipos")
            ->select(DB::raw("count(*) as count"))
            ->where("localizado_sici", "=", "si")
            ->where("resguardante", "=", "CTA")
            ->groupBy("localizado_sici")
            ->first();

        $total_22B_detalleInventario = DB::table("vs_inventariodetalle")
            ->select(DB::raw("count(*) as count"))
            // ->where("inventario", "=", "2022A")
            ->first();
            // dd($total_22B_detalleInventario);
//
         $subquery_equipos = DB::table('vs_equipos')
                        ->select(DB::raw("COUNT(*) as eCO, id_area, area"))
                        ->where('resguardante', 'CTA')
                        ->groupBy('id_area')
                        ->get()
                        ;

         $subquery_inventariados = DB::table('vs_inventariodetalle')
                        ->select(DB::raw("COUNT(*) as iCO, IdArea"))
                        ->groupBy('IdArea')
                        ->get()
                        ;
        // dd($subquery_inventariados);

        $subquery_equipos = json_decode(json_encode($subquery_equipos), true);
        $subquery_inventariados = json_decode(json_encode($subquery_inventariados), true);
        $arrayQ = array();

        $index = 0;
        foreach( $subquery_equipos as $sub_eq){
            $percentage = '';
            $iv_count = '';

            $key_iv = array_search($sub_eq['id_area'], array_column($subquery_inventariados, 'IdArea'));

            // $iv_count = $subquery_inventariados[$key_iv]['iCO'];

            $e_id = $sub_eq['id_area'];
            $e_area = $sub_eq['area'];
            if(!$e_area)
                $e_area = "No asignado";
            if(!$e_id)
                $e_id = "No asignado";

            if($key_iv == false && !is_numeric($key_iv) ){
                $iv_count = 0;
                $percentage .= '0';
            }else{
                $iv_count = $subquery_inventariados[$key_iv]['iCO'];
                $percentage = number_format(($iv_count / $sub_eq['eCO']) * 100, 1);
                if($percentage > 100)
                    $percentage = 100.0;
            }


                $arrayQ[$index] = array (
                    "equipos_count" => $sub_eq['eCO'],
                    "eq_id_area" => $e_id,
                    "area" => $e_area,
                    "iv_count" => $iv_count,
                    "Porcentaje" => $percentage,
                );
            $index++;
        }
            // dd($arrayQ);

        $total_equipos = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->first();

        $total_SICI_localizados = $total_SICI_localizados->count;
        $total_equipos = $total_equipos->cuenta_equipos;
        $total_22B_detalleInventario = $total_22B_detalleInventario->count;


        return view("inventario.inventario_express2")
                // ->with("dataTable", $dataTable)
                ->with("DtQuery", $arrayQ)
                ->with("total_SICI_localizados", $total_SICI_localizados)
                ->with("total_equipos", $total_equipos)
                ->with( "total_22B_detalleInventario", $total_22B_detalleInventario );
    }

    public function AutomaticallyUpdateArea($area_id)
    {
        $area = Area::find($area_id);
        if ($area) {
            $area->ultimo_inventario = "2022";
            $area->update();
            //
            $log = new Log();
            $log->tabla = "area";
            $mov = "";
            $mov =
                $mov .
                " IdEquipo:" .
                $area->ultimo_inventario .
                "se modifico desde:actualizacion_inventario.";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Edicion";
            $log->save();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $equipo_id = $request->input("equipo_id");
        $area_id = $request->input("area_id");
        $user_id = $request->input("user_id");
        $inventario = "2022B";
        $nota = $request->input("nota");
        $articulosRegistrados = InventarioDetalle::where([
            ["IdEquipo", "=", $equipo_id],
            ["inventario", "=", $inventario],
        ])->count();
        if ($articulosRegistrados == 0) {
            $listadoEquipos = VsEquipo::where("id", "=", $equipo_id)->first();
            $registroInventario = new InventarioDetalle();
            $registroInventario->IdEquipo = $equipo_id;
            $registroInventario->IdArea = $area_id;
            $registroInventario->IdRevisor = $user_id;
            $registroInventario->fechaHora = Carbon::now();
            $registroInventario->inventario = $inventario;
            $registroInventario->estatus = "Localizado";
            $registroInventario->notas = $nota;
            $registroInventario->save();
            //
            $log = new Log();
            $log->tabla = "InventarioDetalle";
            $mov = "";
            $mov =
                $mov .
                " IdEquipo:" .
                $registroInventario->IdEquipo .
                " IdArea:" .
                $registroInventario->IdArea .
                " IdRevisor" .
                $registroInventario->IdRevisor;
            $mov =
                $mov .
                " fechaHora:" .
                $registroInventario->fechaHora .
                " inventario:" .
                $registroInventario->inventario .
                " estatus" .
                $registroInventario->estatus;
            $mov = $mov . " notas:" . $registroInventario->notas . ".";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Insercion";
            $log->save();
            //
            $mensaje = "El articulo se registro como Localizado con Nota";
        } else if($articulosRegistrados == 1 && $nota){

            $ArticuloSeleccionado = InventarioDetalle::where("IdEquipo", $equipo_id)
                ->where("inventario", $inventario)
                ->first();
            $ArticuloSeleccionado->IdRevisor = $request->input('user_id');
            $ArticuloSeleccionado->notas = $nota;
            $ArticuloSeleccionado->update();
            $mensaje = "El articulo se registro como Localizado con Nota";
        }else{
            $mensaje = "El articulo ya se habia registrado como Localizado";
        }
        return redirect("revision-inventario")->with([
            "message" => $mensaje,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function panel(Request $request)
    {
        $id_area = $request->input("id_area");

        return $this->index($id_area);
    }
    /*public function cambiar_area_inventario(Request $request){
        $id_area = $request->input('id_area');
        return $this->inventario_por_area($id_area);
    }*/
    public function inventario_por_area($area_id = 249)
    {
        /*Total equipos_en_sici*/
        $equipos_en_sici = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->where("id_area", "=", $area_id)
            ->first();
        /*Total equipos_localizados_sici*/
        $equipos_en_sici_localizados = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->where("localizado_sici", "=", "Si")
            ->where("id_area", "=", $area_id)
            ->first();
        /*Total equipos_no_localizados_sici*/
        $equipos_en_sici_no_localizados = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->where("localizado_sici", "=", "No")
            ->where("id_area", "=", $area_id)
            ->first();
        /* Localizados inventario Express*/
        $total_equipos_localizados = DB::table('vs_inventariodetalle as iv')
              ->select( DB::raw("COUNT(*) as total_locales"))
              ->whereIn('iv.IdEquipo',
                    DB::table('vs_equipos as eq')
                    ->select('eq.id')
                    ->where('eq.resguardante', 'CTA')
                    ->where('eq.id_area', $area_id)
          )
              ->where('iv.IdArea', $area_id)
              ->where("inventario", "2022B")
              ->first();
         $total_equipos_localizados = $total_equipos_localizados->total_locales;

         $total_equipos_del_area = DB::table("vs_equipos")
         ->select(DB::raw("COUNT(*) as totalE"))
         ->where("resguardante","CTA")
         ->where("id_area", $area_id)
         ->first();
         $total_equipos_del_area = $total_equipos_del_area->totalE;

        $total_equipos_localizados_externos = DB::table('vs_inventariodetalle as iv')
              ->select( DB::raw("COUNT(*) as total_externos"))
              ->whereNotIn('iv.IdEquipo',
                    DB::table('vs_equipos as eq')
                    ->select('eq.id')
                    ->where('eq.resguardante', 'CTA')
                    ->where('eq.id_area', $area_id)
          )
              ->where('iv.IdArea', $area_id)
              ->where("inventario", "2022B")
              ->first();
              $total_equipos_localizados_externos = $total_equipos_localizados_externos->total_externos;



        /* Revision con Nota*/

        // $total_equipos_revision = DB::table('inventariodetalle')
        //     ->select(DB::raw('COUNT(*) as revisiones'))
        //     ->where('estatus', '=', 'Revision')
        //     ->where('IdArea', '=', $area_id)
        //     ->first();

        // $total_equipos_revision = DB::table('inventariodetalle')
        //     ->select(DB::raw('COUNT(*) as revisiones'))
        //     ->where('estatus', '=', 'Localizado')
        //     ->where('IdArea', '=', $area_id)
        //     ->first();
        // $total_equipos_revision = DB::table('inventariodetalle')
        //     ->select(DB::raw('COUNT(*) as revisiones'))
        //     ->where('estatus', '=', 'Localizado')
        //     ->where('IdArea', '=', $area_id)
        //     ->first();

        /*AREAS*/
        $origen = "inventario-area";

        /*DATA TABLE*/

        // $equipos_dataTable_externos = DB::table('vs_inventariodetalle')
        // ->leftJoin('vs_equipos', 'vs_inventariodetalle.IdEquipo', '=', 'vs_equipos.id')
        // ->where('vs_inventariodetalle.IdArea', $area_id)
        // // ->where("vs_inventariodetalle.inventario", "2022A") // ya viene filtrado en la vista vs_inventariodetalle
        // ->where('vs_equipos.resguardante','CTA')
        // ->get( array(
        //     'vs_equipos.*',
        //     'estatus',
        //     'notas'
        // ));
        $equipos_dataTable_externos = DB::table('vs_inventariodetalle as iv')
            ->join('vs_equipos', 'iv.IdEquipo', '=', 'vs_equipos.id')
              // ->select( DB::raw("eq.*"), 'iv.estatus', 'iv.notas')
              ->whereNotIn('iv.IdEquipo',
                    DB::table('vs_equipos as eq')
                    ->select('eq.id')
                    ->where('eq.resguardante', 'CTA')
                    ->where('eq.id_area', $area_id)
          )
              ->where('iv.IdArea', $area_id)
              ->where("inventario", "2022B")
              ->get(
                  array(
                      'vs_equipos.*',
                      'iv.estatus',
                      'iv.notas'
                  )
              );

        $equipos2_dataTable_locales = DB::table('vs_equipos')
        ->leftJoin('vs_inventariodetalle', 'vs_equipos.id', '=', 'vs_inventariodetalle.IdEquipo')
        ->where('vs_equipos.id_area', $area_id)
        ->where('vs_equipos.resguardante','CTA')
        ->get(
            array(
                'vs_equipos.*',
                'vs_inventariodetalle.estatus',
                'vs_inventariodetalle.notas'
        )
        );

        $equiposExt = json_decode(json_encode($equipos_dataTable_externos), true);
        $equiposLcl = json_decode(json_encode($equipos2_dataTable_locales), true);
        $equipos = array_merge($equiposExt, $equiposLcl );
        // dd($equipos);
        /*
        SELECT id,
        CONCAT(sede,' - ' , division,' - ',coordinacion,' - ',area) as Area FROM `areas`;

        */

        $currentArea = Area::
            select('id', DB::raw("CONCAT(sede,' - ' , division,' - ',coordinacion,' - ',area) as Area"))
            ->where('id', $area_id)
            ->first();


        return view("inventario.inventario-area")
            ->with("area_actual", $currentArea)
            ->with("total_equipos_del_area", $total_equipos_del_area)
            ->with("total_equipos_localizados", $total_equipos_localizados)
            ->with("total_equipos_localizados_externos", $total_equipos_localizados_externos)
            ->with("equipos", $equipos)
            ->with("equipos_en_sici", $equipos_en_sici)
            ->with("equipos_en_sici_localizados", $equipos_en_sici_localizados)
            ->with( "equipos_en_sici_no_localizados", $equipos_en_sici_no_localizados )
            ->with("origen", $origen)
            ->with("area_id", $area_id);
    }
    public function listarEquipoEncontrado(Request $request)
    {
        //Se hace la ruta, la ruta manda llamar el m�todo y el m�todo manda llamar la plantilla
        $listadoEquipos = DB::table('vs_equipo_detalles')
            ->leftJoin('vs_inventariodetalle', 'vs_inventariodetalle.IdEquipo', '=', 'vs_equipo_detalles.id')
            ->where("vs_equipo_detalles.id", "=", $request->input("id"))
            ->orWhere("vs_equipo_detalles.udg_id", "=", $request->input("id"))
            ->orWhere("vs_equipo_detalles.numero_serie", "like", "%" . $request->input("id") . "%")
            ->get( array(
                'vs_equipo_detalles.*',
                'notas'
            ));

        // dd($listadoEquipos);

        if ($request->input("nota") != null) {
            $nota = $request->input("nota");
        } else {
            $nota = "-";
        }
        $origen = $request->input("origen");

        return view("equipo.equipo-encontrado", [
            "message" => "El equipo se registro correctamente 2022B",
            "listadoEquipos" => $listadoEquipos,
            "nota" => $nota,
            "origen" => $origen,
        ]);
    }
    public function registroInventario($equipo_id, $origen = "revision-inventario")
    {
        $inventario = '2022B';
        $revisor_id = Auth::user()->id;
        $articulosRegistrados = InventarioDetalle::where('IdEquipo',$equipo_id )
            ->where('inventario', $inventario)->count();

        if ($articulosRegistrados == 0){
            $listadoEquipos = VsEquipo::where("id", "=", $equipo_id)->first();
            $registroInventario = new InventarioDetalle();
            $registroInventario->IdEquipo = $equipo_id;
            $registroInventario->IdArea = $listadoEquipos->id_area;
            $registroInventario->IdRevisor = $revisor_id;
            $registroInventario->fechaHora = Carbon::now();
            $registroInventario->inventario = $inventario;
            $registroInventario->estatus = "Localizado";
            $registroInventario->notas = "-";
            $registroInventario->save();
            //
            $log = new Log();
            $log->tabla = "InventarioDetalle";
            $mov = "";
            $mov =
                $mov .
                " IdEquipo:" .
                $registroInventario->IdEquipo .
                " IdArea:" .
                $registroInventario->IdArea .
                " IdRevisor" .
                $registroInventario->IdRevisor;
            $mov =
                $mov .
                " fechaHora:" .
                $registroInventario->fechaHora .
                " inventario:" .
                $registroInventario->inventario .
                " estatus" .
                $registroInventario->estatus;
            $mov = $mov . " notas:" . $registroInventario->notas . ".";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Insercion";
            $log->save();
            //
            $mensaje = "El articulo se registro como Localizado";
        } else {
            $mensaje = "El articulo ya se habia registrado como Localizado";
        }

        //if($origen='inventario-area'){
        //  return redirect()->route('inventario-por-area', $listadoEquipos->id_area)->with(array('message' => $mensaje));
        //}else{
        return redirect()
            ->route("revision-inventario")
            ->with([
                "message" => $mensaje,
            ]);
        //}
    }
    public function actualizacion_inventario($area_id)
    {
        $area = Area::find($area_id);
        if ($area) {
            $area->ultimo_inventario = "2022";
            $area->update();
            //
            $log = new Log();
            $log->tabla = "area";
            $mov = "";
            $mov =
                $mov .
                " IdEquipo:" .
                $area->ultimo_inventario .
                "se modifico desde:actualizacion_inventario.";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Edicion";
            $log->save();
            //
            return redirect()
                ->route("inventario-express-detalle2")
                ->with([
                    "message" => "Se marco como último inventario 2022",
                ]);
        }
    }
    public function inventario_detalle($area_id)
    {
        /*Total equipos_en_sici*/
        $equipos_en_sici = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->where("id_area", "=", $area_id)
            ->first();
        /*Total equipos_localizados_sici*/
        $equipos_en_sici_localizados = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->where("localizado_sici", "=", "S")
            ->where("id_area", "=", $area_id)
            ->first();
        /*Total equipos_no_localizados_sici*/
        $equipos_en_sici_no_localizados = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as cuenta_equipos"))
            ->where("resguardante", "=", "CTA")
            ->where("localizado_sici", "=", "No Encontrado")
            ->where("id_area", "=", $area_id)
            ->first();
        /* Localizados inventario Express*/
        $total_equipos_localizados = DB::table("inventariodetalle")
            ->select(DB::raw("COUNT(*) as localizados"))
            ->where("estatus", "=", "Localizado")
            ->where("IdArea", "=", $area_id)
            ->first();
        /* Localizados*/
        $total_equipos_localizados = DB::table("inventariodetalle")
            ->select(DB::raw("COUNT(*) as localizados"))
            ->where("estatus", "=", "Localizado")
            ->where("IdArea", "=", $area_id)
            ->first();

        /* Revisi�n con Nota*/
        $total_equipos_revision = DB::table("inventariodetalle")
            ->select(DB::raw("COUNT(*) as revisiones"))
            ->where("estatus", "=", "Revision")
            ->where("IdArea", "=", $area_id)
            ->first();

        /*AREAS*/
        $origen = "inventario-area";

        /*DATA TABLE*/
        $equipos = VsEquipo::where("id_area", "=", $area_id)->get();
        $total_equipos = count($equipos);

        //Cargar vista vs_equipos_detalles
        $equipos_detalle = Vs_Equipo_Detalle::where(
            "id_area",
            "=",
            $area_id
        )->get();

        return view("inventario.inventario_detalle")
            ->with("total_equipos", $total_equipos)
            ->with("total_equipos_localizados", $total_equipos_localizados)
            ->with("total_equipos_revision", $total_equipos_revision)
            ->with("equipos", $equipos)
            ->with("equipos_en_sici", $equipos_en_sici)
            ->with("equipos_en_sici_localizados", $equipos_en_sici_localizados)
            ->with(
                "equipos_en_sici_no_localizados",
                $equipos_en_sici_no_localizados
            )
            ->with("origen", $origen)
            ->with("equipos_detalle", $equipos_detalle);
    }

    public function dashboard_inventario()
    {
        // $total_equipos = Equipo::count();
        $total_equipos = DB::table("vs_equipos")
            ->select(DB::raw("COUNT(*) as localizados"))
            ->where("tipo_sici", "equipo")
            ->where("resguardante", "CTA")
            ->first();

        // $total_equipos_localizados_sici = Equipo::where('localizado_sici','Si')->get();
        $total_equipos_localizados_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as localizados_sici"))
            ->where("tipo_sici", "equipo")
            ->where("localizado_sici", "Si")
            ->where("resguardante", "CTA")
            ->first();

        $total_cpu_localizados_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as cpu_localizados"))
            ->where("localizado_sici", "Si")
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "CPU")
            ->first();

        $total_lap_localizadas_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as lap_localizadas"))
            ->where("localizado_sici", "Si")
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "Laptop")
            ->first();

        $total_imp_localizadas_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as imp_localizadas"))
            ->where("localizado_sici", "Si")
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "Impresora")
            ->first();

        $total_tablets_cta = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as total_tablet_cta"))
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "Tablet")
            ->first();

        $total_tablets_android = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as total_tablet_android"))
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "Tablet")
            ->where("marca", "<>", "APPLE")
            ->first();

        $total_tablets_apple = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as total_tablet_apple"))
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "Tablet")
            ->where("marca", "APPLE")
            ->first();

        $total_equipos_no_localizados_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as no_localizados_sici"))
            ->where("tipo_sici", "equipo")
            ->where("localizado_sici", "No")
            ->where("resguardante", "CTA")
            ->first();

        $total_cpu_no_localizados_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as cpu_localizados"))
            ->where("localizado_sici", "No")
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "CPU")
            ->first();

        $total_lap_no_localizadas_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as lap_localizadas"))
            ->where("localizado_sici", "No")
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "Laptop")
            ->first();

        $total_imp_no_localizadas_sici = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as imp_localizadas"))
            ->where("localizado_sici", "No")
            ->where("resguardante", "CTA")
            ->where("tipo_equipo", "Impresora")
            ->first();

        $total_equipos_localizados_inventario_anual = DB::table(
            "inventariodetalle"
        )
            ->select(DB::raw("COUNT(*) as localizados_inv"))
            ->where("estatus", "Localizado")
            ->first();

        $total_equipos_localizados_con_nota = DB::table("inventariodetalle")
            ->select(DB::raw("COUNT(*) as localizados_nota"))
            ->where("notas", "<>", "-")
            ->first();

        // $vs_inventario_general = DB::table('vs_inventariogeneral')
        // ->select('*')
        // ->get();

        $total_cpu = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as cpus"))
            ->where("tipo_equipo", "CPU")
            ->where("resguardante", "CTA")
            ->first();

        $total_lap = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as laptop"))
            ->where("tipo_equipo", "Laptop")
            ->where("resguardante", "CTA")
            ->first();

        $total_imp = DB::table("equipos")
            ->select(DB::raw("COUNT(*) as impresora"))
            ->where("tipo_equipo", "Impresora")
            ->where("resguardante", "CTA")
            ->first();

        $vs_prestamos_porEntregar = DB::table("vs_prestamos")
            ->select(DB::raw("COUNT(*) as porEntregar"))
            ->where("estado", "Por Entregar")
            ->first();

        $vs_prestamos_trasladado = DB::table("vs_prestamos")
            ->select(DB::raw("COUNT(*) as traladado"))
            ->where("estado", "Traslado")
            ->first();

        $vs_prestamos_devuelto = DB::table("vs_prestamos")
            ->select(DB::raw("COUNT(*) as devuelto"))
            ->where("estado", "Devuelto")
            ->first();

        $vs_prestamos_enPrestamo = DB::table("vs_prestamos")
            ->select(DB::raw("COUNT(*) as enPrestamo"))
            ->where("estado", "En prestamo")
            ->first();

        // dd($vs_prestamos_enPrestamo);

        $dataTable[] = [
            $vs_prestamos_porEntregar,
            $vs_prestamos_trasladado,
            $vs_prestamos_devuelto,
            $vs_prestamos_enPrestamo,
        ];

        // dd($dataTable);

        return view("inventario.estadistica")
            ->with("total_equipos", $total_equipos)
            ->with(
                "total_equipos_localizados_sici",
                $total_equipos_localizados_sici
            )
            ->with("total_cpu_localizados_sici", $total_cpu_localizados_sici)
            ->with("total_lap_localizadas_sici", $total_lap_localizadas_sici)
            ->with("total_imp_localizadas_sici", $total_imp_localizadas_sici)
            ->with(
                "total_equipos_no_localizados_sici",
                $total_equipos_no_localizados_sici
            )
            ->with(
                "total_cpu_no_localizados_sici",
                $total_cpu_no_localizados_sici
            )
            ->with(
                "total_lap_no_localizadas_sici",
                $total_lap_no_localizadas_sici
            )
            ->with(
                "total_imp_no_localizadas_sici",
                $total_imp_no_localizadas_sici
            )
            ->with(
                "total_equipos_localizados_inventario_anual",
                $total_equipos_localizados_inventario_anual
            )
            ->with(
                "total_equipos_localizados_con_nota",
                $total_equipos_localizados_con_nota
            )
            ->with("total_cpu", $total_cpu)
            ->with("total_lap", $total_lap)
            ->with("total_imp", $total_imp)
            ->with("total_tablets_cta", $total_tablets_cta)
            ->with("total_tablets_android", $total_tablets_android)
            ->with("total_tablets_apple", $total_tablets_apple)
            ->with("dataTable", $dataTable);
        // ->with('vs_inventario_general',$vs_inventario_general);
    }
}
