<?php

namespace App\Http\Controllers;

use App\Models\Licencia;
use App\Models\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LicenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $licencias = Licencia::where('activo','=',1)->get();
        $licencias = $this->cargarDT($licencias );
        return view('licencias.index')->with('licencias',$licencias);
    }
    public function cargarDT($consulta)
    {
        $licencia = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-licencia', $value['id']);
            $actualizar =  route('licencias.edit', $value['id']);
         

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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar  esta licencia?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small> 
                            '.$value['id'].', '.$value['numero_de_licencia'].'                 </small>
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

            $licencia[$key] = array(
               $acciones,
                $value['id'],
                $value['numero_de_requisicion'],
                $value['presupuesto'],
                $value['fecha_compra'],
                $value['proveedor'],
                $value['producto'],
                $value['numero_de_licencia'],
                $value['solicitante'],
                $value['fecha_de_instalacion'],
                $value['correo_de_contacto'],
                $value['telefono_de_contacto'],
                $value['observaciones'],
            );

        }

        return $licencia;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('licencias.create');
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
            'proveedor'=>'max:200',
            'producto'=>'max:200',
            'numero_de_licencia'=>'max:100',
            'solicitante'=>'max:100',
            'correo_de_contacto'=>'email|max:100',
            'telefono_de_contacto'=>'max:50'
        ]);

        $licencia = new Licencia();
        $licencia->fecha_compra = $request->input('fecha_compra');
        $licencia->proveedor = $request->input('proveedor');
        $licencia->producto = $request->input('producto');
        $licencia->numero_de_licencia = $request->input('numero_de_licencia');
        $licencia->solicitante = $request->input('solicitante');
        $licencia->fecha_de_instalacion = $request->input('fecha_de_instalacion');
        $licencia->correo_de_contacto = $request->input('correo_de_contacto');
        $licencia->telefono_de_contacto = $request->input('telefono_de_contacto');
        $licencia->observaciones = $request->input('observaciones');
        

        $licencia->save();
	//
        $log = new Log();
        $log->tabla = "licencias";
        $mov="";
        $mov=$mov." fecha_compra:".$licencia->fecha_compra ." proveedor:". $licencia->proveedor ." producto:" .$licencia->producto;
        $mov=$mov." numero_de_licencia:".$licencia->numero_de_licencia ." solicitante:". $licencia->solicitante ." fecha_de_instalacion" .$licencia->fecha_de_instalacion;
        $mov=$mov." correo_de_contacto:".$licencia->correo_de_contacto ." telefono_de_contacto:". $licencia->telefono_de_contacto ." observaciones:". $licencia->observaciones .".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('licencias')->with(array(
            'message'=>'La licencia se guardo Correctamente'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Licencia  $licencia
     * @return \Illuminate\Http\Response
     */
    public function show(Licencia $licencia)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Licencia  $licencia
     * @return \Illuminate\Http\Response
     */
    public function edit( $id)
    {
        $licencia = Licencia::find($id);
        return view('licencias.edit')->with('licencia', $licencia);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Licencia  $licencia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request,[
            'proveedor'=>'max:200',
            'producto'=>'max:200',
            'numero_de_licencia'=>'max:100',
            'solicitante'=>'max:100',
            'correo_de_contacto'=>'email|max:100',
            'telefono_de_contacto'=>'max:50'
        ]);

        $licencia = Licencia::find($id);
        $licencia->fecha_compra = $request->input('fecha_compra');
        $licencia->proveedor = $request->input('proveedor');
        $licencia->producto = $request->input('producto');
        $licencia->numero_de_licencia = $request->input('numero_de_licencia');
        $licencia->solicitante = $request->input('solicitante');
        $licencia->fecha_de_instalacion = $request->input('fecha_de_instalacion');
        $licencia->correo_de_contacto = $request->input('correo_de_contacto');
        $licencia->telefono_de_contacto = $request->input('telefono_de_contacto');
        $licencia->observaciones = $request->input('observaciones');
        

        $licencia->update();
	//
        $log = new Log();
        $log->tabla = "licencias";
        $mov="";
        $mov=$mov." fecha_compra:".$licencia->fecha_compra ." proveedor:". $licencia->proveedor ." producto:" .$licencia->producto;
        $mov=$mov." numero_de_licencia:".$licencia->numero_de_licencia ." solicitante:". $licencia->solicitante ." fecha_de_instalacion" .$licencia->fecha_de_instalacion;
        $mov=$mov." correo_de_contacto:".$licencia->correo_de_contacto ." telefono_de_contacto:". $licencia->telefono_de_contacto ." observaciones:". $licencia->observaciones .".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "edicion";
        $log->save();
        //
        return redirect('licencias')->with(array(
            'message'=>'La licencia se actualizo Correctamente'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Licencia  $licencia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Licencia $licencia)
    {
        //
    }
    public function delete_licencia($licencia_id){
        $licencia = Licencia::find($licencia_id);
        if($licencia){
            $licencia->activo = 0;
            $licencia->update();
	    //
            $log = new Log();
            $log->tabla = "licencia";
            $mov="";
            $mov=$mov." fecha_compra:".$licencia->fecha_compra ." proveedor:". $licencia->proveedor ." producto" .$licencia->producto;
            $mov=$mov." numero_de_licencia:".$licencia->numero_de_licencia ." solicitante:". $licencia->solicitante ." fecha_de_instalacion:" .$licencia->fecha_de_instalacion;
            $mov=$mov." correo_de_contacto:".$licencia->correo_de_contacto ." telefono_de_contacto:". $licencia->telefono_de_contacto ." observaciones:". $licencia->observaciones .".";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Borrado";
            $log->save();
            //
            return redirect()->route('licencias.index')->with(array(
               "message" => "La licencia se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
               "message" => "La licencia que trata de eliminar no existe"
            ));
        }

    }
}
