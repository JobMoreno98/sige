<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Equipo;
use Illuminate\Http\Request;
use App\Models\EquipoPorPrestamo;
use App\Models\PrestamoEquipo;
use App\Models\Prestamo;
use App\Models\VsPrestamo;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PrestamoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $vsprestamos = VsPrestamo::where('activo','=',1)
            ->where('estado','En préstamo')->get();

        $prestamos = $this->cargarDT($vsprestamos);

       return view('prestamo.index')->with('prestamos',$prestamos);
    }
    public function cargarDT($consulta)
    {
        $prestamos = [];

        foreach ($consulta as $key => $value){

        $ruta = "borrarPrestamo".$value['id'];    
        $cambiarubicacion = route('cambiar-ubicacion', $value['id']);
        $actualizar =  route('prestamos.edit', $value['id']);
	    $prestamo = route('imprimirPrestamo', $value['id']);
        $borrarPrestamo = route('borrarPrestamo', $value['id']);
        $devolverPrestamo = route('devolverPrestamo', $value['id']);

        $acciones = '';

        $acciones = '
            <div class="btn-acciones">
                <div class="btn-circle">
                    <a href="'.$actualizar.'" class="btn btn-success" title="Actualizar">
                        <i class="far fa-edit"></i>
                    </a>
                    <a href="'.$prestamo.'" class="btn btn-primary"  title="Formato de Préstamo" target="_blank">
                        <i class="far fa-file-alt"></i>
                    </a>
                </div>
            </div>
                <div class="btn-acciones">
                <div class="btn-circle">
                    <a href="#'.$ruta.'" role="button" class="btn btn-danger" data-toggle="modal" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                    </a>
                    <a href="'.$devolverPrestamo.'" class="btn btn-success"  title="Devolución de Préstamo">
                    <i class="fas fa-check"></i>
                    </a>
                </div>    
                </div>
            </div>
            <div class="modal fade" id="'.$ruta.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este préstamo?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small>
                            '.$value['id'].',<br> '.$value['solicitante'].'
                        </small>
                        <small><br><br>
                        '.$value['lista_equipos'].'
                        </small>
                      </p>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a href="'.$borrarPrestamo.'" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
        ';

        $prestamos[$key] = array(
            $acciones,
            $value['id'],
            $value['solicitante'],
            $value['cargo'],
            $value['lugar'],
            $value['contacto'],
            $value['estado'],
            $value['lista_equipos'],
            $value['fecha_actualizacion'] = \Carbon\Carbon::parse($value->fecha_actualizacion)->format('d/m/Y H:i'),
            $value['observaciones'],
            $value['documento'],
        );

        }
        return $prestamos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('prestamos.create');

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
            'id_area'=>'required',
            'solicitante'=>'required',
            'cargo'=>'required',
            'estado'=>'required',
            'fecha_inicio'=>'required',
            'observaciones'=>'required'
        ]);
        $prestamo = new Prestamo();
        $prestamo->id_area = $request->input('id_area');
        $prestamo->telefono = $request->input('telefono');
        $prestamo->solicitante = $request->input('solicitante');
        $prestamo->correo = $request->input('correo');
        $prestamo->cargo = $request->input('cargo');
        $prestamo->estado = $request->input('estado');
        $prestamo->fecha_inicio = $request->input('fecha_inicio');
        $prestamo->observaciones = $request->input('observaciones');

	$prestamo->save();

        $lastPrestamo = $prestamo->id;

        $prestamo_equipo = new PrestamoEquipo();
        $prestamo_equipo->id_prestamo = $lastPrestamo;
        $prestamo_equipo->id_equipo = $request->input('equipo_id');
        $prestamo_equipo->accesorios = $request->input('accesorios');
        $prestamo_equipo->save();
	//
        $log = new Log();
        $log->tabla = "Prestamo_y_PrestamoEquipo";
        $mov="";
        $mov=$mov." id_area:".$prestamo->id_area ." telefono:". $prestamo->telefono ." solicitante" .$prestamo->solicitante;
        $mov=$mov." correo:".$prestamo->correo ." cargo:". $prestamo->cargo ." estado:". $prestamo->estado ;
        $mov=$mov." fecha_inicio:".$prestamo->fecha_inicio ." observaciones:". $prestamo->observaciones;
        $mov=$mov." id_prestamo:".$prestamo_equipo->id_prestamo ." id_equipo:". $prestamo_equipo->id_equipo." accesorios:". $prestamo_equipo->accesorios .".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('prestamos')->with(array(
            'message'=>'El pr�stamo se guardo Correctamente'
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
        $prestamo = VsPrestamo::find($id);
        $equiposPorPrestamo = EquipoPorPrestamo::where('activo', '=', 1)
            ->where('id_prestamo','=',$id)->get();
        return view('prestamo.agregarEquipoEdit')
            ->with('prestamo', $prestamo)->with('equiposPorPrestamo', $equiposPorPrestamo);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $prestamo = Prestamo::find($id);
        $vsPrestamo = VsPrestamo::find($id);
        $equiposPrestados = EquipoPorPrestamo::where('id_prestamo','=',$id)
            ->where('activo','=',1)->get();

        $areas = Area::all();
        return view('prestamo.edit')->with('prestamo',$prestamo)->with('vsPrestamo',$vsPrestamo)->with('equiposPrestados',$equiposPrestados)->with('areas',$areas);
    }

    ////////////////////////////////////////////////////////////////



    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request,[
            'id_area'=>'required',
            'solicitante'=>'required',
            'cargo'=>'required',
            'estado'=>'required',
            'fecha_inicio'=>'required',
            'observaciones'=>'required'
        ]);
        $prestamo = Prestamo::find($id);
        $prestamo->id_area = $request->input('id_area');
        $prestamo->telefono = $request->input('telefono');
        $prestamo->solicitante = $request->input('solicitante');
        $prestamo->correo = $request->input('correo');
        $prestamo->cargo = $request->input('cargo');
        $prestamo->estado = $request->input('estado');
        $prestamo->fecha_inicio = $request->input('fecha_inicio');
        $prestamo->observaciones = $request->input('observaciones');
        $documento = $request->file('documento');
        if($documento){
            $documento_path = time().$documento->getClientOriginalName();
            \Storage::disk('documentos')->put($documento_path, \File::get($documento));
            $prestamo->documento = $documento_path;
        }
        $prestamo->update();
	//
        $log = new Log();
        $log->tabla = "Prestamo";
        $mov="";
        $mov=$mov." id_area:".$prestamo->id_area ." telefono:". $prestamo->telefono ." solicitante" .$prestamo->solicitante;
        $mov=$mov." correo:".$prestamo->correo ." cargo:". $prestamo->cargo ." estado:". $prestamo->estado ;
        $mov=$mov." fecha_inicio:".$prestamo->fecha_inicio ." observaciones:". $prestamo->observaciones . ".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Edicion";
        $log->save();
        //
        return redirect('prestamos')->with(array(
            'message'=>'El préstamo se guardo Correctamente'
        ));
    }


    public function destroy($id)
    {

    }
    public function generarPrestamo($equipo_id){
        $areas = Area::where('activo','=', 1)->get();
        $equipoPrestamo = Equipo::find($equipo_id);
        return view('prestamo.create')->with('areas', $areas)->with('equipoPrestamo', $equipoPrestamo);
    }

    public function quitarEquipoPrestado($equipo_prestado_id, $prestamo_id){

        $equipoPrestado = PrestamoEquipo::find($equipo_prestado_id);
        $equipoPrestado->activo = 0;
        $equipoPrestado->update();
	//
        $log = new Log();
        $log->tabla = "PrestamoEquipo";
        $mov="";
        $mov=$mov." id_prestamo:".$equipoPrestado->id_prestamo ." id_equipo:". $equipoPrestado->id_equipo." accesorios:". $equipoPrestado->accesorios.".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Borrado";
        $log->save();
        //
        return view('home');
    }
    public function delete_prestamo($prestamo_id){
        $prestamo = Prestamo::find($prestamo_id);
        if($prestamo){
            $prestamo->activo = 0;
            $prestamo->update();
	    //
            $log = new Log();
            $log->tabla = "Prestamo";
            $mov="";
            $mov=$mov." id_area:".$prestamo->id_area ." telefono:". $prestamo->telefono ." solicitante" .$prestamo->solicitante;
            $mov=$mov." correo:".$prestamo->correo ." cargo:". $prestamo->cargo ." estado:". $prestamo->estado ;
            $mov=$mov." fecha_inicio:".$prestamo->fecha_inicio ." observaciones:". $prestamo->observaciones . ".";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Borrado";
            $log->save();
            //
            return redirect()->route('prestamos.index')->with(array(
                "message" => "El prestamo se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
                "message" => "El prestamo que trata de eliminar no existe"
            ));
        }
    }

    public function devolver_prestamo($id) {
        $prestamo = Prestamo::find($id);
        // dd($prestamo);
        if($prestamo){
            $prestamo->estado = 'Devuelto';
            $prestamo->update();

            //
            $log = new Log();
            $log->tabla = "Prestamo";
            $mov="";
            $mov=$mov." id_area:".$prestamo->id_area ." telefono:". $prestamo->telefono ." solicitante" .$prestamo->solicitante;
            $mov=$mov." correo:".$prestamo->correo ." cargo:". $prestamo->cargo ." estado:". $prestamo->estado ;
            $mov=$mov." fecha_inicio:".$prestamo->fecha_inicio ." observaciones:". $prestamo->observaciones . ".";
            $log->movimiento = $mov;
            $log->usuario_id = Auth::user()->id;
            $log->acciones = "Marcado como devuelto";
            $log->save();
            //

            return redirect()->route('prestamos.index')->with(array(
                'message'=>'El préstamo se ha cambiado de estado a devuelto Correctamente'
            ));
        }else{
            return redirect()->route('prestamos.index')->with(array(
                "message" => "El prestamo que trata de devolver no existe"
            ));
        }


    }

    public function obtenerdocumento($filename){
        $file = Storage::disk('documentos')->get($filename);
        return new Response($file, 200);
    }
    public function prestamoEquipos($prestamo_id){
        $prestamo = VsPrestamo::find($prestamo_id);
        $equiposPorPrestamo = EquipoPorPrestamo::where('id_prestamo','=', $prestamo_id)->get();
        return view('prestamo.agregarEquipoEdit')->with('prestamo', $prestamo )
            ->with('prestamo_id', $prestamo_id)->with('equiposPorPrestamo', $equiposPorPrestamo);
    }
 public function registrarEquipoPrestamo($equipo_id, $prestamo_id){
        $prestamoEquipo = new PrestamoEquipo();
        $prestamoEquipo->id_prestamo = $prestamo_id;
        $prestamoEquipo->id_equipo = $equipo_id;
	    //$prestamoEquipo->accesorios = $accesorios;
        $prestamoEquipo->save();
	//
        $log = new Log();
        $log->tabla = "PrestamoEquipo";
        $mov="";
        $mov=$mov." id_prestamo:".$prestamoEquipo->id_prestamo ." id_equipo:". $prestamoEquipo->id_equipo.".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('prestamos/'.$prestamo_id)->with(array(
            'message'=>'El equipo se agregó correctamente al préstamo'
        ));
    }

 public function eliminarEquipoPrestamo($item_id){
        $equipoPorPrestamo=PrestamoEquipo::find($item_id);
        //
        $log = new Log();
        $log->tabla = "PrestamoEquipo";
        $mov="";
        $mov=$mov." id_prestamo:".$equipoPorPrestamo->id_prestamo ." id_equipo:". $equipoPorPrestamo->id_equipo." accesorios".$equipoPorPrestamo->accesorios.".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Borrado";
        $log->save();
        //
     $prestamo_id = $equipoPorPrestamo->id_prestamo;
     $equipoPorPrestamo->delete();
        return redirect('prestamos/'.$prestamo_id)->with(array(
            'message'=>'El equipo se quitó  correctamente al préstamo'
        ));
    }
    public function nuevoPrestamo(){
        $areas = Area::where('activo','=', 1)->get();
        return view ('prestamo.nuevo')->with('areas', $areas);
        //return 'si charcha';
    }
    public function guardarPrestamo(Request $request)
    {
        $validateData = $this->validate($request,[
            'id_area'=>'required',
            'solicitante'=>'required',
            'cargo'=>'required',
            'estado'=>'required',
            'fecha_inicio'=>'required',
            'observaciones'=>'required'
        ]);
        $prestamo = new Prestamo();
        $prestamo->id_area = $request->input('id_area');
        $prestamo->telefono = $request->input('telefono');
        $prestamo->solicitante = $request->input('solicitante');
        $prestamo->correo = $request->input('correo');
        $prestamo->cargo = $request->input('cargo');
        $prestamo->estado = $request->input('estado');
        $prestamo->fecha_inicio = $request->input('fecha_inicio');
        $prestamo->observaciones = $request->input('observaciones');

        $prestamo->save();
        $prestamo_id = Prestamo::latest('id')->first();

        return redirect('prestamos/'.$prestamo_id->id)->with(array(
            'message'=>'El préstamo se creó correctamente'
        ));
    }
    public function agregarAccesorio(Request $request){

        $prestamo_equipo = PrestamoEquipo::find($request->input('filaprestamo_id'));
        $prestamo_equipo->accesorios = $request->input('accesorios');
        $prestamo_equipo->update();
        return redirect('prestamos/'.$request->input('prestamo_id'))->with(array(
            'message'=>'El Equipo se agregó Correctamente al prestamo'
        ));
    }
    public function prestamos_all(){
        $vsprestamos = VsPrestamo::where('activo',1)->get();
        $prestamos = $this->cargarDT($vsprestamos);
        return view('prestamo.indexall')->with('prestamos', $prestamos );
    }
}
