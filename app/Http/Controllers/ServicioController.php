<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use App\Models\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::where('activo','=',1)->get();
        $servicios = $this->cargarDT($servicios );
        return view('servicios.index_consulta')->with('servicios',$servicios);
    }
    public function cargarDT($consulta)
    {
        $servicios = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-servicio', $value['id']);
            $actualizar =  route('servicios.edit', $value['id']);
         

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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar  este servicio?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small> 
                            '.$value['id'].', '.$value['nombre'].'                 </small>
                      </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a href="'.$eliminar.'" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
            ';

            $servicios[$key] = array(
               $acciones,
                $value['id'],
                $value['nombre'],
                $value['categoria'],
                $value['descripcion'],                
                $value['requisitos'],
                $value['procedimiento'],
                $value['contacto'],
                $value['tiempo_de_respuesta'], 
            );

        }

        return $servicios;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('servicios.create');
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
            'nombre'=>'required|max:150',
            'descripcion'=>'required',
            'contacto'=>'required',
            'requisitos'=>'required',
            'procedimiento'=>'required',
            'tiempo_de_respuesta'=>'required',
            'categoria'=>'required',
        ]);

        $servicio = new Servicio();
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->contacto = $request->input('contacto');
        $servicio->requisitos = $request->input('requisitos');
        $servicio->procedimiento = $request->input('procedimiento');
        $servicio->tiempo_de_respuesta = $request->input('tiempo_de_respuesta');
        $servicio->categoria = $request->input('categoria');

        

        $servicio->save();
	//
        $log = new Log();
        $log->tabla = "servicios";
        $mov="";
        $mov=$mov." nombre:".$servicio->nombre ." descripcion:". $servicio->descripcion ." contacto:" .$servicio->contacto;
        $mov=$mov." requisitos:".$servicio->requisitos ." procedimiento:". $servicio->procedimiento ." tiempo_de_respuesta" .$servicio->tiempo_de_respuesta;
        $mov=$mov." categoria:".$servicio->categoria .".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('servicios')->with(array(
            'message'=>'El servicio se guardo Correctamente'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function show(Servicio $servicio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $servicio = Servicio::find($id);
        return view('servicios.edit')->with('servicio', $servicio);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $validateData = $this->validate($request,[
            'nombre'=>'required|max:150',
            'descripcion'=>'required',
            'contacto'=>'required',
            'requisitos'=>'required',
            'procedimiento'=>'required',
            'tiempo_de_respuesta'=>'required',
            'categoria'=>'required',
        ]);

        $servicio = Servicio::find($id);
        $servicio->nombre = $request->input('nombre');
        $servicio->descripcion = $request->input('descripcion');
        $servicio->contacto = $request->input('contacto');
        $servicio->requisitos = $request->input('requisitos');
        $servicio->procedimiento = $request->input('procedimiento');
        $servicio->tiempo_de_respuesta = $request->input('tiempo_de_respuesta');
        $servicio->categoria = $request->input('categoria');

        

        $servicio->update();
	//
        $log = new Log();
        $log->tabla = "servicios";
        $mov="";
        $mov=$mov." nombre:".$servicio->nombre ." descripcion:". $servicio->descripcion ." contacto:" .$servicio->contacto;
        $mov=$mov." requisitos:".$servicio->requisitos ." procedimiento:". $servicio->procedimiento ." tiempo_de_respuesta" .$servicio->tiempo_de_respuesta;
        $mov=$mov." categoria:".$servicio->categoria .".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "edicion";
        $log->save();
        //
        return redirect('servicios')->with(array(
            'message'=>'El servicio se actualizo Correctamente'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Servicio  $servicio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Servicio $servicio)
    {
        //
    }
    public function delete_servicio($servicio_id){
        $servicio = Servicio::find($servicio_id);
        if($servicio){
            $servicio->activo = 0;
            $servicio->update();
	    //
            $log = new Log();
            $log->tabla = "servicios";
            $mov="";
            $mov=$mov." nombre:".$servicio->nombre ." descripcion:". $servicio->descripcion ." contacto:" .$servicio->contacto;
            $mov=$mov." requisitos:".$servicio->requisitos ." procedimiento:". $servicio->procedimiento ." tiempo_de_respuesta" .$servicio->tiempo_de_respuesta;
            $mov=$mov." categoria:".$servicio->categoria .".";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Borrado";
            $log->save();
            //
            return redirect()->route('servicios.index')->with(array(
               "message" => "El servicio se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
               "message" => "El servicio que trata de eliminar no existe"
            ));
        }

    }
    public function inicio(){
        $servicios= Servicio::where('top', '<>', 0)->get();
        return view('servicios.index') ->with('servicios', $servicios);

    }
}
