<?php

namespace App\Http\Controllers;

use App\Models\Ip;
use App\Models\Subred;
use App\Models\VsIps;
use Illuminate\Http\Request;

class SubredController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subredes = Subred::where('activo','=',1)
            ->get();
        $listasubredes = $this->cargarDT($subredes);

        return view('subredes.index')
            ->with('subredes', $subredes)
            ->with('listasubredes', $listasubredes);
    }
    public function cargarDT($consulta)
    {
        $listasubredes= [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('deletesubred', $value['id']);
            $actualizar =  route('subredes.edit', $value['id']);

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="' . $actualizar . '" class="btn btn-success" title="Actualizar">
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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar esta Ip?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small>
                        Id: '.$value['id'].' /
                           Subred: '.$value['subred'].' /
                           Mascara: '.$value['mascara'].' /
                           Gateway: '.$value['gateway'].'

                        </small>
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

            $listasubredes[$key] = array(
                $acciones,
                $value['id'],
                $value['subred'],
                $value['mascara'],
                $value['gateway'],
                



            );

        }

        return $listasubredes;
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $subred = Subred::where('activo','=',1)
            ->get();


        return view('subredes.create')

            ->with('subredes', $subred);
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
            'subred'=>'required|unique:subredes,subred',
            'mascara'=>'required',
            'gateway'=>'required',
            

        ]);


        $subred = new Subred();
        $subred->subred = $request->input('subred');
        $subred->mascara = $request->input('mascara');
        $subred->gateway = $request->input('gateway');
        $subred->disponible = 'si';
        $subred->save();
        return redirect('subredes')->with(array(
            'message'=>'Subred añadida'
        ));

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subred  $subred
     * @return \Illuminate\Http\Response
     */

    public function show($subred)

    {
        $subredes= Subred::where('activo','=',1)
            ->get();
$subredElegida= Subred::all()
    ->where('id','=',$subred)
    ->get();

$subred =$this->cargarDT($subredElegida);

        return view('subredes.index')
            ->with('subredes',$subred)
            ->with('subredes', $subredes);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subred  $subred
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $subred = Subred::find($id);
        return view('subredes.edit')
            ->with('subred', $subred);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subred  $subred
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request,[
            'subred'=>'required',
            'mascara'=>'required',
            'gateway'=>'required',
            
        ]);


        $subred = Subred::find($id);
        $subred->subred = $request->input('subred');
        $subred->mascara = $request->input('mascara');
        $subred->gateway = $request->input('gateway');
        $subred->disponible = 'si';
        $subred->update();
        return redirect('subredes')->with(array(
            'message'=>'Subred actualizado'
        ));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subred  $subred
     * @return \Illuminate\Http\Response
     */
    public function destroy(subred $subred)
    {
        //
    }



    public function deletesubred($subred_id){

        $subred = Subred::find($subred_id);

        if($subred){

            $subred->activo = 0;
            $subred->update();

            return redirect()->route('subredes.index')->with(array(
                "message" => "La subred se ha eliminado correctamente"
            ));

        }else{

            return redirect()->route('home')->with(array(
                "message" => "La subred que trata de eliminar no existe"
            ));
        }

    }
    public function filtroIps(Request $request){
        $subredes= Subred::where('activo','=',1)
            ->get();
        $subred = $request->input('id');
        //$estatus = $request->input('estatus');
        $subredElegida = Subred::find($subred);


        if((isset($subred) && !is_null($subred))){
            $filtro = Ip::where('id_subred','=',$subred)
                ->where('activo','=', 1)
                ->get();

            $ips = $this->cargarDT($filtro);

        } else {
            $ips = Ip::where('activo','=',1)->get();
        }

        return view('ips.index')
            ->with('ips',$ips)
            ->with('subredes',$subredes)
            ->with('subredElegida',$subredElegida);

    }

}
