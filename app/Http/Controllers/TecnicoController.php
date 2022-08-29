<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use App\Models\Tecnico;
use Illuminate\Support\Facades\Auth;


class TecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tecnicos = Tecnico::where('activo','=',1)->get();
        $vstecnicos = $this->cargarDT($tecnicos);
        return view('tecnicos.index')->with('tecnicos',$vstecnicos);
    }

    public function cargarDT($consulta)
    {
        $tecnicos = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-tecnico', $value['id']);
            $actualizar =  route('tecnicos.edit', $value['id']);

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="'.$actualizar.'" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="#'.$ruta.'" role="button" class="btn btn-danger" data-toggle="modal" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="modal fade" id="'.$ruta.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este técnico?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a href="'.$eliminar.'" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
            ';

            $tecnicos[$key] = array(
                $acciones,
                $value['id'],
                $value['ciclo_inicio'],
                $value['nombre'],
                $value['telefono'],
                $value['telefono_emergencia'],
                $value['asistencia'],
                $value['carrera'],
                $value['institucion'],
                $value['orden'],
                $value['comentarios'],
            );

        }

        return $tecnicos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tecnicos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'nombre'=>'required',
            'telefono'=>'required',
            'asistencia'=>'required',
            'carrera'=>'required',
            'institucion'=>'required',
            'ciclo_inicio'=>'required',


        ]);

        $tecnico = new Tecnico();
        $tecnico->nombre = $request->input('nombre');
        $tecnico->telefono = $request->input('telefono');
        $tecnico->telefono_emergencia = $request->input('telefono_emergencia');
        $tecnico->asistencia = $request->input('asistencia');
        $tecnico->carrera = $request->input('carrera');
        $tecnico->institucion = $request->input('institucion');
        $tecnico->ciclo_inicio = $request->input('ciclo_inicio');
        $tecnico->comentarios = $request->input('comentarios');

        $tecnico->save();
	//
        $log = new Log();
        $log->tabla = "tecnicos";
        $mov="";
        $mov=$mov." nombre:".$tecnico->nombre ." telefono:". $tecnico->telefono ." telefono_emergencia" .$tecnico->telefono_emergencia;
        $mov=$mov." asistencia:".$tecnico->asistencia ." carrera:". $tecnico->carrera ." institucion" .$tecnico->institucion ." ciclo_inicio" .$tecnico->ciclo_inicio. " comentarios" .$tecnico->comentarios;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('tecnicos')->with(array(
            'message'=>'El técnico se guardo Correctamente'
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
        $tecnico = Tecnico::find($id);
        return view('tecnicos.edit')->with('tecnico', $tecnico);
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
        $validateData = $this->validate($request,[
            'nombre'=>'required',
            'telefono'=>'required',
            'asistencia'=>'required',
            'carrera'=>'required',
            'institucion'=>'required',
            'ciclo_inicio'=>'required',


        ]);

        $tecnico = Tecnico::find($id);
        $tecnico->nombre = $request->input('nombre');
        $tecnico->ciclo_inicio = $request->input('ciclo_inicio');
        $tecnico->telefono = $request->input('telefono');
        $tecnico->telefono_emergencia = $request->input('telefono_emergencia');
        $tecnico->asistencia = $request->input('asistencia');
        $tecnico->carrera = $request->input('carrera');
        $tecnico->institucion = $request->input('institucion');
        $tecnico->comentarios = $request->input('comentarios');


        $tecnico->update();
	//
        $log = new Log();
        $log->tabla = "tecnicos";
        $mov="";
        $mov=$mov." nombre:".$tecnico->nombre ." telefono:". $tecnico->telefono ." telefono_emergencia" .$tecnico->telefono_emergencia;
        $mov=$mov." asistencia".$tecnico->asistencia ." carrera:". $tecnico->carrera ." institucion" .$tecnico->institucion . " ciclo_inicio" .$tecnico->ciclo_inicio. " comentarios" .$tecnico->comentarios;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Edicion";
        $log->save();
        //
        return redirect('tecnicos')->with(array(
            'message'=>'El técnico se actualizó Correctamente'
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

    public function delete_tecnico($id){
        $tecnico = Tecnico::find($id);
        if($tecnico){
            $tecnico->activo = 0;
            $tecnico->update();
	    //
        $log = new Log();
        $log->tabla = "tecnicos";
        $mov="";
        $mov=$mov." nombre:".$tecnico->nombre ." telefono:". $tecnico->telefono ." telefono_emergencia" .$tecnico->telefono_emergencia;
        $mov=$mov." asistencia".$tecnico->asistencia ." carrera:". $tecnico->carrera ." institucion" .$tecnico->institucion ." ciclo_inicio" .$tecnico->ciclo_inicio. " comentarios" .$tecnico->comentarios;
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Borrado";
            $log->save();
            //
            return redirect()->route('tecnicos.index')->with(array(
               "message" => "El técnico se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
               "message" => "El técnico que trata de eliminar no existe"
            ));
        }

    }
}
