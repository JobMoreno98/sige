<?php

namespace App\Http\Controllers;
use App\Models\Area;
use App\Models\Equipo;
use App\Models\Empleado;
use App\Models\VsEquipo;
use App\Models\VsPrestamo;
use App\Models\Proyecto;
use App\Models\EquipoPorPrestamo;
use App\Models\InventarioDetalle;
use App\Models\VsEquiposPorTicket;
use App\Models\VsTicket;
use App\Models\expediente;
use App\Models\MovimientoEquipo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Log;
use App\Models\Tecnico;
use App\Models\Mantenimiento;
use App\Models\mantenimientoEquipo;
use App\Models\ProyectoActividad;
use App\Models\RelMttoEquipo;
use equipo as GlobalEquipo;
use Illuminate\Support\Facades\Auth;


class ExpedienteController extends Controller
{
    
    public function index()
    {   
        $Vsexpediente = expediente::where('activo', '=', 1)->get();
        $expedientes = $this->cargarDT($Vsexpediente);
        
    }

        public function show($id)
    {
        //
    }

    public function expediente($equipo_id){
        $VsEquipo = Equipo::where('id',$equipo_id)->get();
        $equipo = $this->cargarEquipo($VsEquipo);

        //tickets
        $VsTicket = VsEquiposPorTicket::where('id','=',$equipo_id)->get();
        $ticket = $this->cargarTicket($VsTicket);

        //mantenimiento
        $Vsmantenimiento = mantenimientoEquipo::where('equipo_id','=',$equipo_id)->get();
        $mantenimiento = $this->cargarMan($Vsmantenimiento);

        $tecnicos = Tecnico::where('activo', 1)->get();
        $areas = Area::where('activo', 1)->get();
        //proyectos
        $Vsproyecto = Equipo::join('proyectos','equipos.proyecto_id', '=', 'proyectos.id')
        ->select('proyectos.*')
        ->where('equipos.id','=',$equipo_id)->get();
        $proyecto = $this->cargarProyectos($Vsproyecto);

        //inventario
        $Vsrevicion = Equipo::join('inventariodetalle','equipos.id','=','inventariodetalle.idEquipo')
        ->join('areas', 'inventariodetalle.IdArea','=', 'areas.id')
        ->select('areas.*','inventariodetalle.estatus','inventariodetalle.fechaHora')
        ->where('equipos.id','=',$equipo_id)->get();

        $revicion = $this->cargarRevicion($Vsrevicion);

        //expediente

        
        

        //$this->Imprimirexpediente($Vsexpediente);

        return view('expediente.index')->with('equipo', $equipo)->with('proyecto', $proyecto)->with('ticket', $ticket)->with('mantenimiento',$mantenimiento)->with('tecnicos', $tecnicos)->with('areas', $areas)->with('revicion',$revicion);
    }

    public function cargarEquipo($consulta)
    {
        $equipoConsulta = [];

        foreach ($consulta as $key => $value){
          
            $equipoConsulta[$key] = array(
                $value['id'],//0
                $value['udg_id'],//1
                $value['tipo_equipo'],//2
                $value['marca'],//3
                $value['modelo'],//4
                $value['numero_serie'],//5
                $value['detalles'],//6
                $value['activo'],//7
                $value['requisicion'],//8
                $value['cotizacion'],//9
                $value['factura'],//10
                $value['otros']//11
            );

        }
        return $equipoConsulta;
    }
    //mostrar proyectos
    public function cargarProyectos($consulta)
    {
       
        
        $proyectos = [];

        foreach ($consulta as $key => $value){
          
            $proyectos[$key] = array(
                $value['id'],
                $value['titulo'],
                $value['area_interna']
                
            );

        }
        return $proyectos;
    }
    //datos del equipo
    public function cargarDT($consulta)
    {
        $expediente = [];

        foreach ($consulta as $key => $value){  
            $expediente[$key] = array(
                $value['id'],
                $value['id_udg'],
                $value['realizo'],
                $value['id_proyecto'],
                $value['id_requisicion'],
                $value['activo'], //mostrado temporalmente
                $value['factura']
            );

        }
        return $expediente;
    }
    //tickets
    public function cargarTicket($consulta)
    {
        $tickets = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['ticket_id'];
            $eliminar = route('delete-ticket', $value['ticket_id']);
            $actualizar =  route('tickets.edit', $value['ticket_id']);
         $recibo = route('recepcionEquipo',  $value['ticket_id']);

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="'.$actualizar.'" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
                        </a>
      <a href="'.$recibo .'" class="btn btn-primary" title="Recibo de Equipo">
                            <i class="far fa-file"></i>
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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este curso?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small> 
                            '.$value['id'].', '.$value['datos_reporte'].', '.$value['fecha_reporte'].', '.$value['solicitante'].'
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

            $tickets[$key] = array(
                $acciones,
                $value['ticket_id'],
                $value['resguardante'],
                $value['activo'],
                
                
            );

        }


        return $tickets;
    }
    //Mostrar mantenimientos
    public function cargarMan($consulta){
        $mantenimientos=[];
        foreach ($consulta as $key => $value){
            $mantenimientos[$key] = array(
                $value['id'],
               $value['detalles'],
               $value['created_at'],
               
            );

        }
        return $mantenimientos;

    }

    //Mostrar revicion express
    public function cargarRevicion($consulta){
        $reviciones=[];
        foreach ($consulta as $key => $value){
            $reviciones[$key] = array(
                $value['id'],
                $value['sede'],
                $value['edificio'],
                $value['piso'],
                $value['area'],
                $value['estatus'],
                $value['fechaHora']
               
               
            );

        }
        return $reviciones;

    }

     public function create()
    {
        $Ufolio = expediente::select('folio')->max('folio');
        $proyectos = proyecto::all();
        $usuario = User::all();
        return view('expediente.create')->with('Ufolio', $Ufolio)->with('proyectos', $proyectos)->with('usuarios', $usuario);
    }

    public function store(Request $request)
    {
        $validateData = $this->validate($request, [       
            'realizo' => 'required',
            'id_proyecto' => 'required',
            'id_requisicion' => 'required',
            'factura' => 'required'
        ]);
        $expediente = new Expediente();

        $expediente->realizo = $request->input('realizo');
        $expediente->id_proyecto = $request->input('id_proyecto');
        $expediente->id_requisicion = $request->input('id_requisicion');
        if($request->hasfile('factura')){
          $file=$request->file('factura');  
          $nombreArchivo=$file->getClientOriginalName();
          \Storage::disk('documentos')->put($nombreArchivo, \File::get($file));
          $expediente->factura = $nombreArchivo;
      }
        $expediente->save();
	//
         $log = new Log();
         $log->tablas = 'expedientes';
         $log->movimimiento = "ID UdeG: ".$expediente->id."ID realizo: ".$expediente->realizo."fecha: ".$expediente->fecha."factura".$expediente->factura;
         $log->usuario_id = Auth::user()->id;
         $log->acciones = 'Insertar';
         $expediente->save();
         //
        return redirect('expedientes')->with(array(
            'message' => 'El Expediente se guardo Correctamente'
        ));
    }

    public function update(Request $request, $id)
        {
      
        if($request->input('requisicion') == 1){
          $validateData = $this->validate($request,[
            'requisicion'=>'required'
           
        ]);
            $equipo = Equipo::find($id);
             $date = date("d") . "-" . date("m") . "-" . date("Y");
            $file=$request->file('file');
            $nombreArchivo=$id."_".$date."_requisicion"."_".$file->getClientOriginalName();
            \Storage::disk('documentos')->put($nombreArchivo, \File::get($file));
            $equipo->requisicion = $nombreArchivo;
        $equipo->update();
        }
        elseif ($request->input('cotizacion') == 2) {
          $validateData = $this->validate($request,[
            'cotizacion'=>'required'
            
        ]);
           $equipo = Equipo::find($id);
             $date = date("d") . "-" . date("m") . "-" . date("Y");
            $file=$request->file('file');
            $nombreArchivo=$id."_".$date."_cotizacion"."_".$file->getClientOriginalName();
            \Storage::disk('documentos')->put($nombreArchivo, \File::get($file));
            $equipo->cotizacion = $nombreArchivo;
        $equipo->update();
          
        }

         elseif ($request->input('factura') == 3) {
          $validateData = $this->validate($request,[
            'factura'=>'required'
        ]);
           $equipo = Equipo::find($id);
             $date = date("d") . "-" . date("m") . "-" . date("Y");
            $file=$request->file('file');
            $nombreArchivo=$id."_".$date."_factura"."_".$file->getClientOriginalName();
            \Storage::disk('documentos')->put($nombreArchivo, \File::get($file));
            $equipo->factura = $nombreArchivo;
        $equipo->update();
          
        }
         elseif ($request->input('otros') == 4) {
          $validateData = $this->validate($request,[
            'otros'=>'required'
        ]);
           $equipo = Equipo::find($id);
             $date = date("d") . "-" . date("m") . "-" . date("Y");
            $file=$request->file('file');
            $nombreArchivo=$id."_".$date."_otros"."_".$file->getClientOriginalName();
            \Storage::disk('documentos')->put($nombreArchivo, \File::get($file));
            $equipo->otros = $nombreArchivo;
        $equipo->update();
          
        }
        
        
  //
        
        //
        return redirect('expediente/'.$id)->with(array(
            'message'=>'El archivo se asigno correctamente'
        ));
    }

    //nuevos mantenimientos
    public function mantenimientoEquipo($equipo_id, Request $request){
        $mantenimientoEquipo = new mantenimientoEquipo();
        $mantenimientoEquipo->equipo_id = $equipo_id;
        $mantenimientoEquipo->detalles = $request->detalles;

        $mantenimientoEquipo->save();

        $mantenimiento = new Mantenimiento();
        $mantenimiento->tecnico_id = $request->input('tecnico_id');
        $mantenimiento->area_id = $request->input('area_id');

        $mantenimiento->save();

        $rel = new RelMttoEquipo();
        $rel-> mantenimiento_id = $mantenimiento->id;
        $rel ->equipo_id =  $equipo_id;
        $rel->save();

        

        return redirect ()->route('expediente',$equipo_id);

    }

    //quitar mantenimientos
    public function delete_mantenimiento($man_id){
        $rel = new RelMttoEquipo();
        $rel = RelMttoEquipo::find($rel->mantenimiento_id=$man_id);

        $mantenimiento = new Mantenimiento();
        $mantenimiento = Mantenimiento::find($rel->mantenimiento_id);
        $mantenimiento->activo=0;

        

        $mantenimientoEquipo = new mantenimientoEquipo();
        $mantenimientoEquipo = mantenimientoEquipo::find($man_id);
        $mantenimientoEquipo->delete();

       
        

        return redirect ()->route('expediente',$mantenimientoEquipo->equipo_id);

    }
    public function Imprimirexpediente($equipo_id){

        $VsExpediente = Equipo::where('equipos.id','=',$equipo_id)
        
        
        ->select('equipos.id as idE','equipos.tipo_equipo as tipoE','equipos.marca as marcaE','equipos.modelo as modeloE','equipos.detalles as detalleE')
        ->get();

        $expediente = $VsExpediente[key([[$VsExpediente]])];

        $Vsmantenimiento = mantenimientoEquipo::where('equipo_id','=',$equipo_id)->get();

        $VsTicket = VsEquiposPorTicket::where('id','=',$equipo_id)->get();

        $Vsproyecto = Equipo::join('proyectos','equipos.proyecto_id', '=', 'proyectos.id')
        ->select('proyectos.*')
        ->where('equipos.id','=',$equipo_id)->get();
           
        $Vsrevicion = Equipo::join('inventariodetalle','equipos.id','=','inventariodetalle.idEquipo')
        ->join('areas', 'inventariodetalle.IdArea','=', 'areas.id')
        ->select('areas.*','inventariodetalle.estatus','inventariodetalle.fechaHora')
        ->where('equipos.id','=',$equipo_id)->get();

        $pdf = \PDF::loadView('expediente.expediente', compact('expediente'), compact('Vsmantenimiento','VsTicket','Vsproyecto','Vsrevicion'));
        return $pdf->stream('expediente.pdf');


    }

}
