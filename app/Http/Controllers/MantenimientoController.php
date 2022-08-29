<?php

namespace App\Http\Controllers;

use App\Models\Mantenimiento;
use App\Models\Area;
use App\Models\Tecnico;
use App\Http\Controllers\Controller;
use App\Models\EquipoPorPrestamo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Log;
use App\Models\RelMttoEquipo;
use App\Models\Vs_Relmantenimiento;
use App\Models\VsEquipo;
use App\Models\VsMantenimiento;
use App\Models\VsPrestamo;
use Illuminate\Support\Facades\DB;

class MantenimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vsmantenimiento = VsMantenimiento::where('activo', 1)->get();
        $mantenimiento = $this->cargarDT($vsmantenimiento);
        return view('mantenimiento.index')->with('mantenimientos', $mantenimiento);
    }

    public function mantenimiento_detalle()
    {
        $total_area_equipos = DB::table('vs_equipos')->count();
        // dd($total_area_equipos);
        $total_area_belenes = DB::table('vs_equipos')
            ->where('area', 'like', '%Belenes%')
            ->count();
        $total_area_la_normal = DB::table('vs_equipos')
            ->where('area', 'like', '%Belenes%')
            ->count();
        $total_terminado = DB::table('vs_mantenimiento_equipo')
            ->where('terminado')
            ->count();
        //return ($total_area_equipos->count);
        return view('mantenimiento.mantenimiento_detalle')->with('total_area_equipos', $total_area_equipos)->with('total_area_belenes', $total_area_belenes)->with('total_area_la_normal', $total_area_la_normal)->with('total_terminado', $total_terminado);
    }


    public function cargarDT($consulta)
    {
        $mantenimiento = [];

        foreach ($consulta as $key => $value) {

            $ruta = "eliminar" . $value['id'];
            $eliminar = route('delete-mantenimiento', $value['id']);
            $actualizar =  route('mantenimiento.edit', $value['id']);
            $agregarequipo = route('mantenimiento.show', $value['id']);

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="' . $actualizar . '" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="' . $agregarequipo . '" class="btn btn-warning" title="Agregar Equipo">
                            <i class="far fa-plus"></i>
                        </a>
                        <a href="#' . $ruta . '" role="button" class="btn btn-danger" data-toggle="modal" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="modal fade" id="' . $ruta . '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este mantenimiento?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a href="' . $eliminar . '" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
            ';

            $mantenimiento[$key] = array(
                $acciones,
                $value['id'],
                $value['fecha_mantenimiento'],
                $value['nombre'],
                $value['telefono'],
                $value['sede'] . ' - ' . $value['edificio'] . ' - ' . $value['piso'] . ' - ' . $value['division'] . ' - ' . $value['coordinacion'] . ' - ' . $value['area']
            );
        }

        return $mantenimiento;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::where('activo', 1)->get();
        $tecnicos = Tecnico::where('activo', 1)->get();


        return view('mantenimiento.create')->with('areas', $areas)->with('tecnicos', $tecnicos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request, [

            'tecnico_id' => 'required',
            'area_id' => 'required',
            'fecha_mantenimiento' => 'required'
        ]);
        $mantenimiento = new Mantenimiento();

        $mantenimiento->tecnico_id = $request->input('tecnico_id');
        $mantenimiento->area_id = $request->input('area_id');
        $mantenimiento->fecha_mantenimiento = $request->input('fecha_mantenimiento');
        $mantenimiento->save();

        $lastmantenimiento = $mantenimiento->id;
        //
        $log = new Log();
        $log->tabla = "mantenimientos";
        $mov = "";
        $mov = $mov . " id:" . $mantenimiento->id . " tecnico_id:" . $mantenimiento->tecnico_id . " area_id" . $mantenimiento->area_id;
        $mov = $mov . " fecha_mantenimiento:" . $mantenimiento->fecha_mantenimiento;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('mantenimiento/' . $lastmantenimiento)->with(array(
            'message' => 'El mantenimiento se guardó correctamente'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vsmantenimiento =VsMantenimiento::find($id);
        $infomantenimiento = Mantenimiento::find($id);
        $equipos_en_este_mantenimiento = Vs_Relmantenimiento::where('id_mantenimiento', '=', $id)->get();
        $equipos = VsEquipo::where('id_area', '=', $infomantenimiento->area_id)->where('tipo_equipo','cpu')->get();
        foreach ($equipos_en_este_mantenimiento as $key1 => $value1) {
            foreach ($equipos as $key2 => $value2) {
                    if ( $value1->udg_id == $value2->udg_id) {
                        unset($equipos [$key2]);
                        // array_push($unmatch,$value2);
                    }
            }
        }

        return view('mantenimiento.agregarMantenimientoEdit')->with('infomantenimiento', $infomantenimiento)->with('equipos_en_este_mantenimiento', $equipos_en_este_mantenimiento)->with('equipos', $equipos)->with('vsmantenimiento',$vsmantenimiento);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        $equiposmantenimiento = Vs_Relmantenimiento::all();
        $areas = Area::all();
        $tecnicos = Tecnico::where('activo', 1)->get();
        return view('mantenimiento.edit')->with('mantenimiento', $mantenimiento)->with('equiposmantenimiento', $equiposmantenimiento)->with('areas', $areas)->with('tecnicos', $tecnicos);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request, [
            'tecnico_id' => 'required',
            'area_id' => 'required',
            'fecha_mantenimiento' => 'required'
        ]);
        $mantenimiento = Mantenimiento::find($id);
        $mantenimiento->id = $request->input('id');
        $mantenimiento->tecnico_id = $request->input('tecnico_id');
        $mantenimiento->area_id = $request->input('area_id');
        $mantenimiento->fecha_mantenimiento = $request->input('fecha_mantenimiento');
        $mantenimiento->update();
        //
        $log = new Log();
        $log->tabla = "mantenimientos";
        $mov = "";
        $mov = $mov . " id:" . $mantenimiento->id . " tecnico_id:" . $mantenimiento->tecnico_id . " area_id" . $mantenimiento->area_id;
        $mov = $mov . " fecha_mantenimiento:" . $mantenimiento->fecha_mantenimiento;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Inserción";
        $log->save();
        //
        return redirect('mantenimiento')->with(array(
            'message' => 'El mantenimiento se guardó Correctamente'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Mantenimiento  $mantenimiento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Mantenimiento $mantenimiento)
    {
        //
    }
    // public function busquedaEquiposMantenimiento(Request $request)
    // {
    //     $validateData = $this->validate($request, [
    //         'busqueda' => 'required'
    //     ]);
    //     $busqueda = $request->input('busqueda');

    //     if (isset($busqueda) && !is_null($busqueda)) {
    //         $id = $request->input('id');
    //         $mantenimiento = Mantenimiento::find($id);
    //         $infomantenimiento = VsMantenimiento::find($id);
    //         $equipos = VsEquipo::where('area', '=', $mantenimiento->area_id)
    //             // ->where('id','LIKE','%'.$busqueda.'%')
    //             ->orWhere('udg_id','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('marca','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('marca','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('modelo','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('numero_serie','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('mac','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('ip','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('tipo_conexion','LIKE','%'.$busqueda.'%')
    //             // ->orWhere('tipo_equipo','LIKE','%'.$busqueda.'%')
    //             ->orWhere('area', 'LIKE', '%' . $busqueda . '%')->get();

    //         $equipos_en_este_mantenimiento = Vs_Relmantenimiento::where('id_mantenimiento', '=', $id)->get();

    //         return view('mantenimiento.agregarMantenimientoEdit')
    //             ->with('vsmantenimiento', $infomantenimiento)->with('equipos_en_este_mantenimiento', $equipos_en_este_mantenimiento)->with('equipos', $equipos);
    //     } else {
    //         return redirect('home')->with(array(
    //             'message' => 'Debe introducir un término de búsqueda'
    //         ));
    //     }
    // }
    public function agregarequipomantenimiento($mantenimiento_id, $equipo_id)
    {

        $relmantenimientoequipo = new RelMttoEquipo();
        $relmantenimientoequipo->mantenimiento_id = $mantenimiento_id;
        $relmantenimientoequipo->equipo_id = $equipo_id;
        $relmantenimientoequipo->save();

        return redirect('mantenimiento/' . $mantenimiento_id)->with(array(
            'message' => 'El Equipo se agregó Correctamente al mantenimiento'
        ));
    }
    public function eliminarequipomantenimiento($mantenimiento_id, $equipo_id)
    {

        $relmantenimientoequipo = RelMttoEquipo::where('mantenimiento_id', '=', $mantenimiento_id)->where('equipo_id', '=', $equipo_id);
        $relmantenimientoequipo->delete();

        return redirect('mantenimiento/' . $mantenimiento_id)->with(array(
            'message' => 'El Equipo se quitó Correctamente del mantenimiento'
        ));
    }
    public function estadoMantenimiento($mantenimiento_id, $equipo_id)
    {

        $relmantenimientoequipo = RelMttoEquipo::where('mantenimiento_id', '=', $mantenimiento_id)->where('equipo_id', '=', $equipo_id)->first();
        $bool = $relmantenimientoequipo->terminado;

        $relmantenimientoequipo->terminado = !$bool;
        $relmantenimientoequipo->update();

        return redirect('mantenimiento/' . $mantenimiento_id)->with(array(
            'message' => 'El Equipo se modificó correctamente del mantenimiento'
        ));
    }


    public function delete_mantenimiento($id)
    {
        $mantenimiento = Mantenimiento::find($id);
        if ($mantenimiento) {
            $mantenimiento->activo = 0;
            $mantenimiento->update();
            //
            $log = new Log();
            $log->tabla = "mantenimientos";
            $mov = "";
            $mov = $mov . " id:" . $mantenimiento->id . " tecnico_id:" . $mantenimiento->tecnico_id . " area_id" . $mantenimiento->area_id;
            $mov = $mov . " fecha_mantenimiento:" . $mantenimiento->fecha_mantenimiento;
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Borrado";
            $log->save();
            //
            return redirect()->route('mantenimiento.index')->with(array(
                "message" => "El mantenimiento se ha eliminado correctamente"
            ));
        } else {
            return redirect()->route('home')->with(array(
                "message" => "El mantenimiento que trata de eliminar no existe"
            ));
        }
    }

    public function buscador(Request $request, $vsmantenimiento)
    {
        if($request->ajax()){

            $infomantenimiento = VsMantenimiento::select('id')->where('id','=',$vsmantenimiento)->get()[0];
            $consulta = VsEquipo::select('id','udg_id','resguardante','marca','modelo','numero_serie','detalles','tipo_equipo','activo','area')
            // ->where('id', 'LIKE', '%' . $request->buscador . '%')
            ->Where('udg_id', 'LIKE', '%' . $request->buscador . '%')
            // ->orwhere('resguardante', 'LIKE', '%' . $request->buscador . '%')
            ->orWhere('marca', 'LIKE', '%' . $request->buscador . '%')
            ->orWhere('modelo', 'LIKE', '%' . $request->buscador . '%')
            ->orWhere('numero_serie', 'LIKE', '%' . $request->buscador . '%')->paginate(12);
            // ->orWhere('detalles', 'LIKE', '%' . $request->buscador . '%')
            // ->orWhere('tipo_equipo', 'LIKE', '%' . $request->buscador . '%')
            // ->orWhere('activo', 'LIKE', '%' . $request->buscador . '%')
            // ->orWhere('area', 'LIKE', '%' . $request->buscador . '%')
        $termino = $request->buscador;
        return view('mantenimiento.busqueda', compact('termino','consulta','infomantenimiento'))->render();
        }

    }
}
