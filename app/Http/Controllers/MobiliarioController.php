<?php

namespace App\Http\Controllers;

use App\Models\Mobiliario;
use App\Models\Empleado;
use App\Models\Area;
use App\Models\VsEmpleado;
use App\Models\VsMobiliario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MobiliarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //Este es el que tengo que modificar DZ 
     public function index()
    {
        $Vsmobiliarios = VsMobiliario::where('activo', '=', 1)->get();
        $mobiliarios = $this->cargarDT($Vsmobiliarios );
        $user = Auth::user()->role;
        return view('mobiliario.index',compact('mobiliarios','user'));
    }
    public function cargarDT($consulta)
    {
        $mobiliario = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-mobiliario', $value['id']);
            $actualizar =  route('mobiliarios.edit', $value['id']);

            if(Auth::user()->role != 'general') {
                $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="' . $actualizar . '" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este curso?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small> 
                            ' . $value['id'] . ', ' . $value['descripcion'] . '                 </small>
                      </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a href="' . $eliminar . '" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
            ';
                $mobiliario[$key] = array(
                    $acciones,
                    $value['id'],
                    $value['id_udg'],
                    $value['id_resguardante'],
                    $value['nombre'],
                    $value['area_id'],
                    $value['area'],
                    $value['descripcion'],
                    $value['fecha_adquisicion'],
                    $value['ubicacion'],
                    $value['estatus_sici'],
                    $value['localizado_sici']
                );
            }
            else{
                $mobiliario[$key] = array(
                    $value['id'],
                    $value['id_udg'],
                    $value['id_resguardante'],
                    $value['nombre'],
                    $value['area_id'],
                    $value['area'],
                    $value['descripcion'],
                    $value['fecha_adquisicion'],
                    $value['ubicacion'],
                    $value['estatus_sici'],
                    $value['localizado_sici']
                );
            }



        }

        return $mobiliario;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $empleados = VsEmpleado::all()->sortBy('nombre');

        $areas = Area::all();
        return view('mobiliario.create')->with('empleados', $empleados)->with('areas', $areas);
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
            'id_udg' => 'required',
            'id_resguardante' => 'required',
            'area_id' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
            'fecha_adquisicion' => 'required',
            'estatus_sici' => 'required',
            'localizado_sici' => 'required'
        ]);
        $mobiliario = new Mobiliario();
        $mobiliario->id_udg = $request->input('id_udg');
        $mobiliario->id_resguardante = $request->input('id_resguardante');
        $mobiliario->area_id = $request->input('area_id');
        $mobiliario->descripcion = $request->input('descripcion');
        $mobiliario->ubicacion = $request->input('ubicacion');
        $mobiliario->fecha_adquisicion = $request->input('fecha_adquisicion');
        $mobiliario->estatus_sici = $request->input('estatus_sici');
        $mobiliario->localizado_sici = $request->input('localizado_sici');
        $mobiliario->save();
	//
         $log = new Log();
         $log->tablas = 'mobiliarios';
         $log->movimimiento = "ID UdeG: ".$mobiliario->id_udg."ID resguardante: ".$mobiliario->id_resguardante."�rea: ".$mobiliario->area_id."Descripci�n: ".$mobiliario->descripcion."Ubicaci�n".$mobiliario->ubicacion."Fecha de aquisicion: ".$mobiliario->fecha_adquisicion."Estatus SICI: ".$mobiliario->estatus_sici."Localizado SICI: ".$mobiliario->localizado_sici;
         $log->usuario_id = Auth::user()->id;
         $log->acciones = 'Insertar';
         $mobiliario->save();
         //
        return redirect('mobiliarios')->with(array(
            'message' => 'El mobiliário se guardo Correctamente'
        ));
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
        $empleados = VsEmpleado::all()->sortBy('nombre');

        $mobiliario = VsMobiliario::find($id);
        $areas = Area::all();
        return view('mobiliario.edit')->with('empleados', $empleados)->with('mobiliario', $mobiliario)->with('areas', $areas);
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
        $validateData = $this->validate($request, [
            'id_udg' => 'required',
            'id_resguardante' => 'required',
            'area_id' => 'required',
            'descripcion' => 'required',
            'ubicacion' => 'required',
            'fecha_adquisicion' => 'required',
            'estatus_sici' => 'required',
            'localizado_sici' => 'required'
        ]);
        $mobiliario = Mobiliario::find($id);
        $mobiliario->id_udg = $request->input('id_udg');
        $mobiliario->id_resguardante = $request->input('id_resguardante');
        $mobiliario->area_id = $request->input('area_id');
        $mobiliario->descripcion = $request->input('descripcion');
        $mobiliario->ubicacion = $request->input('ubicacion');
        $mobiliario->fecha_adquisicion = $request->input('fecha_adquisicion');
        $mobiliario->estatus_sici = $request->input('estatus_sici');
        $mobiliario->localizado_sici = $request->input('localizado_sici');
        $mobiliario->save();
	//
       $log = new Log();
       $log->tabla = "mobiliarios";
       $mov="";
       $mov=$mov."ID UdeG: ".$mobiliario->id_udg."ID resguardante: ".$mobiliario->id_resguardante."�rea: ".$mobiliario->area_id."Descripci�n: ".$mobiliario->descripcion."Ubicaci�n".$mobiliario->ubicacion."Fecha de aquisicion: ".$mobiliario->fecha_adquisicion."Estatus SICI: ".$mobiliario->estatus_sici."Localizado SICI: ".$mobiliario->localizado_sici;
       if(!is_null($mobiliario->fecha_termino) && isset($mobiliario->fecha_termino)){
           $mov=$mov." estatus: Cerrado";
       }
       else{
           $mov=$mov." estatus:".$mobiliario->estatus;
       }
       $mov=$mov ."ID UdeG: ".$mobiliario->id_udg."ID resguardante: ".$mobiliario->id_resguardante."�rea: ".$mobiliario->area_id."Descripci�n: ".$mobiliario->descripcion."Ubicaci�n".$mobiliario->ubicacion."Fecha de aquisicion: ".$mobiliario->fecha_adquisicion."Estatus SICI: ".$mobiliario->estatus_sici."Localizado SICI: ".$mobiliario->localizado_sici;
       $log->movimiento = $mov;
       $log->usuario_id = Auth::user()->id;
       $log->acciones = "Edicion";
       $log->save();
       //
        return redirect('mobiliarios')->with(array(
            'message' => 'El mobiliário se actualizo correctamente'
        ));
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

    public function delete_mobiliario($mobiliario_id)
    {
        $mobiliario = Mobiliario::find($mobiliario_id);
        if ($mobiliario) {
            $mobiliario->activo = 0;
            $mobiliario->update();
//
            $log = new Log();
        $log->tabla = "mobiliarios";
        $mov="";
        $mov=$mov."ID UdeG: ".$mobiliario->id_udg."ID resguardante: ".$mobiliario->id_resguardante."�rea: ".$mobiliario->area_id."Descripci�n: ".$mobiliario->descripcion."Ubicaci�n".$mobiliario->ubicacion."Fecha de aquisicion: ".$mobiliario->fecha_adquisicion."Estatus SICI: ".$mobiliario->estatus_sici."Localizado SICI: ".$mobiliario->localizado_sici;
        if(!is_null($mobiliario->fecha_termino) && isset($mobiliario->fecha_termino)){
            $mov=$mov." estatus: Cerrado";
        }
        else{
            $mov=$mov." estatus:".$mobiliario->estatus;
        }
        $mov=$mov ."ID UdeG: ".$mobiliario->id_udg."ID resguardante: ".$mobiliario->id_resguardante."�rea: ".$mobiliario->area_id."Descripci�n: ".$mobiliario->descripcion."Ubicaci�n".$mobiliario->ubicacion."Fecha de aquisicion: ".$mobiliario->fecha_adquisicion."Estatus SICI: ".$mobiliario->estatus_sici."Localizado SICI: ".$mobiliario->localizado_sici;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Borrrado";
        $log->save();
        //
            return redirect()->route('mobiliarios.index')->with(array(
                "message" => "El mobiliário se ha eliminado correctamente"
            ));
        } else {
            return redirect()->route('home')->with(array(
                "message" => "El mobiliário que trata de eliminar no existe"
            ));
        }
    }
}
