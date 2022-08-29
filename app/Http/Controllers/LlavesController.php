<?php

namespace App\Http\Controllers;

use App\Models\Llaves;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Models\Vs_llaves;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LlavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $llaves = Vs_llaves::where('activo', '=', 1)->get();
        $vsllaves = $this->cargarDT($llaves);
        return view('llaves.index')->with('llaves', $vsllaves);
    }
    public function cargarDT($consulta)
    {
        $llaves = [];

        foreach ($consulta as $key => $value) {

            $ruta = "eliminar" . $value['id_llave'];
            $eliminar = route('delete_llaves', $value['id_llave']);
            $actualizar =  route('llaves.edit', $value['id_llave']);

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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar las llaves?</h5>
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

            $llaves[$key] = array(
                $acciones,
                $value['id_llave'],
                $value['area'],
                $value['num_copias'],
                $value['comentarios'],
                $value['usuario'],
            );
        }

        return $llaves;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('llaves.create');
    }

    public function agregarllaves(Request $request)
    {

        if (Auth::check()) {
            $user = Auth::user()->name;
            $llaves_disponibles = Llaves::where('activo', '=', 1)->where('id_usuario', '=', 0)->get();
            $llaves_agregadas = Llaves::where('activo', '=', 0)->where('id_usuario', '=', Auth::user()->id)->get();
            return view('llaves.agregarllaves')->with('user', $user)->with('llaves_disponibles', $llaves_disponibles)->with('llaves_agregadas', $llaves_agregadas);
        } else {
            return redirect()->route('home')->with(array(
                "message" => "Usuario no logeado"
            ));
        }
    }
    public function devolverllave($id)
    {

        $llave = Llaves::find($id);
        $llave->id_usuario = 0;
        $llave->activo = 1;
        $llave->update();
        //
        $log = new Log();
        $log->tabla = "llaves";
        $mov = "";
        $mov = $mov . " nombre" . $llave->nombre . " num_copias" . $llave->num_copias . " comentarios" . $llave->comentarios;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Devolución de Llave";
        $log->save();
        //
        if (Auth::check()) {
            return redirect()->route('agregarllaves');
        } else {
            return redirect()->route('home')->with(array(
                "message" => "Usuario no logeado"
            ));
        }
    }
    public function seleccionarllave($id)
    {

        $llave = Llaves::find($id);
        $llave_usuario_anterior = $llave->id_usuario;
        $llave->id_usuario = Auth::user()->id;
        $llave->activo = 0;
        $llave->update();
        //
        $log = new Log();
        $log->tabla = "llaves";
        $mov = "";
        $mov = $mov . " nombre" . $llave->nombre . " num_copias" . $llave->num_copias . " comentarios" . $llave->comentarios;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        if ($llave_usuario_anterior != 0) {
            $log->acciones = "Tomaste la Llave.";
        } else {
            $log->acciones = "Alguien te pasó esta llave.";
        }

        $log->save();
        //
        if (Auth::check()) {
            return redirect()->route('agregarllaves');
        } else {
            return redirect()->route('home')->with(array(
                "message" => "Usuario no logeado"
            ));
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
        $validateData = $this->validate($request, [
            'area' => 'required',
        ]);

        $llaves = new Llaves();
        $llaves->area = $request->input('area');
        $llaves->num_copias = $request->input('num_copias');;
        $llaves->comentarios = $request->input('comentarios');

        $llaves->save();
        //
        $log = new Log();
        $log->tabla = "llaves";
        $mov = "";
        $mov = $mov . " nombre" . $llaves->nombre . " num_copias" . $llaves->num_copias . " comentarios" . $llaves->comentarios;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('llaves')->with(array(
            'message' => 'La llave se guardó Correctamente'
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Llaves  $llaves
     * @return \Illuminate\Http\Response
     */
    public function show(Llaves $llaves)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Llaves  $llaves
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $llaves = Llaves::find($id);
        return view('llaves.edit')->with('llaves', $llaves);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Llaves  $llaves
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request, [
            'area' => 'required',
        ]);

        $llaves = Llaves::find($id);
        $llaves->area = $request->input('area');
        $llaves->num_copias = $request->input('num_copias');;
        $llaves->comentarios = $request->input('comentarios');

        $llaves->update();
        //
        $log = new Log();
        $log->tabla = "llaves";
        $mov = "";
        $mov = $mov . " nombre" . $llaves->nombre . " num_copias" . $llaves->num_copias . " comentarios" . $llaves->comentarios;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('llaves')->with(array(
            'message' => 'La Llave se actualizó Correctamente'
        ));
    }
    public function delete_llaves($id)
    {
        $llaves = Llaves::find($id);
        if ($llaves) {
            $llaves->activo = 0;
            $llaves->update();
            //
            $log = new Log();
            $log->tabla = "llaves";
            $mov = "";
            $mov = $mov . " nombre" . $llaves->nombre . " num_copias" . $llaves->num_copias . " comentarios" . $llaves->comentarios;
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Borrado";
            $log->save();
            //
            return redirect()->route('llaves.index')->with(array(
                "message" => "La Llave se ha eliminado correctamente"
            ));
        } else {
            return redirect()->route('home')->with(array(
                "message" => "La Llave que trata de eliminar no existe"
            ));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Llaves  $llaves
     * @return \Illuminate\Http\Response
     */
    public function destroy(Llaves $llaves)
    {
        //
    }
    public function buscador(Request $request)
    {
        if ($request->ajax()) {
            $consulta = Llaves::select('id', 'area', 'comentarios', 'num_copias', 'activo')->where('area', 'like', '%' . $request->buscador . '%')->orwhere('comentarios', 'like', '%' . $request->buscador . '%')->get();
            $termino = $request->buscador;
            return view('llaves.busqueda', compact('consulta', 'termino'))->render();
        }
    }
}
