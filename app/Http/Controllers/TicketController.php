<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Empleado;
use App\Models\Equipo;
use App\Models\Tecnico;
use App\Models\Ticket;
use App\Models\VsAreaTicket;
use App\Models\VsEquiposPorTicket;
use App\Models\VsTicket;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\EquipoTicket;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //este es el que tengo que modificar DZ-- inicia la modificacion 1
     public function index()
    {
        $vstickets = VsTicket::where('activo','=',1)
            ->where('estatus','=','Abierto')->get();

        $tecnicos = Tecnico::where('activo','=',1)->get();
        $tickets = $this->cargarDT($vstickets);
        return view('ticket.index')->with('tickets',$tickets)->with('tecnicos', $tecnicos);
    }
    //este el que se modificó fin de la modificación 1
    public function cargarDT($consulta)
    {
        
        $tickets = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-ticket', $value['id']);
            $actualizar =  route('tickets.edit', $value['id']);
            $recibo = route('recepcionEquipo',  $value['id']);
            $tomar = route('tomar-ticket',$value['id']);

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        
                        <a href="'.$actualizar.'" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
                        </a>
			            <a href="'.$recibo .'" class="btn btn-primary" title="Recibo de Equipo">
                            <i class="far fa-file"></i>
                        </a>
                        <a href="'.$tomar.'" role="button" class="btn btn-warning" title="Tomar Ticket">
                            <i class="far fa-hand-paper"></i>
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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este ticket?</h5>
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
            $area = $value['area'];
            if(str_contains($area,'Belenes')){
                $area = str_replace('- Belenes ',"",$area);
                $area = '<b>Belenes</b> - '.$area;
            }else{
                $area = str_replace('- La Normal ',"",$area);
                $area = '<b>La Normal</b> - '.$area;
            }
            
            $tickets[$key] = array(
                $acciones,
                $value['id'],
                $value['fecha_reporte'] = \Carbon\Carbon::parse($value->fecha_reporte)->format('d/m/Y H:i'),
                $area,
                $value['solicitante'],
                $value['contacto'],
                $value['tecnico'],
                $value['categoria'].". Prioridad: ".$value['prioridad'],
                $value['datos_reporte'],
            );

        }

        return $tickets;
    }
    public function revisionTickets()
    {
        $vstickets = VsTicket::where('activo','=',1)->get();
        $tecnicos = Tecnico::where('activo','=',1)->get();
        $tickets = $this->cargarDT($vstickets);
        return view('ticket.revisionTickets')->with('tickets',$tickets)->with('tecnicos', $tecnicos);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $equipos = Equipo::all();
        //$areas = Area::pluck('id','area')->prepend('seleciona');
        $areas = Area::all();
        $tecnicos = Tecnico::where('activo','=',1)->get();
        return view('ticket.create')->with('equipos', $equipos)->with('areas', $areas)->with('tecnicos', $tecnicos);
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
            'area_id'=>'required',
            'solicitante'=>'required',
            'contacto'=>'required',
            'tecnico_id'=>'required',
            'categoria'=>'required',
            'prioridad'=>'required',
            'estatus'=>'required',
            'area' => 'required',
            'datos_reporte'=>'required',
            'fecha_reporte'=>'required'
        ]);
        $ticket = new Ticket();
        $ticket->area_id = $request->input('area_id');
        $ticket->solicitante = $request->input('solicitante');
        $ticket->contacto = $request->input('contacto');
        $ticket->tecnico_id = $request->input('tecnico_id');
        $ticket->categoria = $request->input('categoria');
        $ticket->prioridad = $request->input('prioridad');
        $ticket->estatus = $request->input('estatus');
        $ticket->datos_reporte = $request->input('datos_reporte');
        $ticket->fecha_reporte = $request->input('fecha_reporte');
        $ticket->fecha_inicio  = $request->input('fecha_inicio ');
        $ticket->fecha_termino = $request->input('fecha_termino');
        $ticket->problema = $request->input('problema');
        $ticket->solucion = $request->input('solucion');
        $ticket->save();
//
        $log = new Log();
        $log->tablas = 'tickets';
        $log->movimimiento = "�rea id: ".$ticket->area_id. "Solicitante: " .$ticket->solicitante. "Contacto: ". $ticket->contacto. "T�cnico: ". $ticket->tecnico_id."Categoria: ".$ticket->categoria."Prioridad: ".$ticket->prioridad."Estatus: ".$ticket->estatus."Datos de reporte: ".$ticket->datos_reporte."Fecha de reporte: ".$ticket->fecha_reporte."Fecha de inicio: ".$ticket->fecha_inicio. "Fecha de termino: ". $ticket->fecha_termino."Problema: ".$ticket->problema."Soluci�n: ".$ticket->solucion;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = 'Insertar';
        $ticket->save();
        //
        return redirect('tickets')->with(array(
            'message'=>'El Ticket se guardo Correctamente'
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
        $equipos = Equipo::all();
        //$areas = Area::pluck('id','area')->prepend('seleciona');
        $areas = Area::all();
        $ticket = VsTicket::find($id);
        $tecnicos = Tecnico::where('activo','=',1)->get();
        return view('ticket.edit')->with('ticket', $ticket)->with('equipos', $equipos)->with('areas', $areas)->with('tecnicos',$tecnicos);
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
            'area_id'=>'required',
            'solicitante'=>'required',
            'contacto'=>'required',
            'tecnico_id'=>'required',
            'categoria'=>'required',
            'prioridad'=>'required',
            'estatus'=>'required',
            'datos_reporte'=>'required',
            'fecha_reporte'=>'required'
        ]);

        $ticket = Ticket::find($id);
        $ticket->area_id = $request->input('area_id');
        $ticket->solicitante = $request->input('solicitante');
        $ticket->contacto = $request->input('contacto');
        $ticket->tecnico_id = $request->input('tecnico_id');
        $ticket->categoria = $request->input('categoria');
        $ticket->prioridad = $request->input('prioridad');
        $ticket->estatus = $request->input('estatus');
        $ticket->datos_reporte = $request->input('datos_reporte');
        //$ticket->fecha_reporte = $request->input('fecha_reporte');
        $ticket->fecha_inicio  = $request->input('fecha_inicio ');

        $ticket->fecha_termino = $request->input('fecha_termino');
        if(!is_null($ticket->fecha_termino) && isset($ticket->fecha_termino)){
            $ticket->estatus='Cerrado';
        }
        $ticket->problema = $request->input('problema');
        $ticket->solucion = $request->input('solucion');
        $ticket->update();
//
        $log = new Log();
        $log->tabla = "tickets";
        $mov="";
        $mov=$mov." area_id:".$ticket->area_id ." solicitante:". $ticket->solicitante ." contacto" .$ticket->contacto;
        $mov=$mov." tecnico_id:".$ticket->tecnico_id ." categoria:". $ticket->categoria ." prioridad" .$ticket->prioridad;
        if(!is_null($ticket->fecha_termino) && isset($ticket->fecha_termino)){
            $mov=$mov." estatus: Cerrado";
        }
        else{
            $mov=$mov." estatus:".$ticket->estatus;
        }
        $mov=$mov ." datos_reporte:". $ticket->datos_reporte ." fecha_reporte" .$ticket->fecha_reporte;
        $mov=$mov." fecha_inicio:".$ticket->fecha_inicio ." datos_reporte:". $ticket->datos_reporte ." fecha_termino" .$ticket->fecha_termino;
        $mov=$mov." problema:".$ticket->problema ." solucion:". $ticket->solucion . ".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Edicion";
        $log->save();
        //
        return redirect('tickets')->with(array(
            'message'=>'El Ticket se guardo Correctamente'
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

    public function filtroTickets(Request $request){
        $tecnicos = Tecnico::where('activo','=',1)->get();
        $tecnico = $request->input('tecnico_id');
        $estatus = $request->input('estatus');
        $tecnicoElegido = Tecnico::find($tecnico);
        return $request;

        if((isset($tecnico) && !is_null($tecnico)) && (isset($estatus) && !is_null($estatus))){
            $vstickets = VsTicket::where('tecnico_id','=',$tecnico)
                ->Where('activo','=', 1)
                ->Where('estatus','=', $estatus)
                ->get();
        }elseif((isset($tecnico) && !is_null($tecnico)) && (!isset($estatus) && is_null($estatus))){
            $vstickets = VsTicket::where('tecnico_id','=',$tecnico)
                ->Where('activo','=', 1)
                ->get();
        }elseif((!isset($tecnico) && is_null($tecnico)) && (isset($estatus) && !is_null($estatus))){
            $vstickets = VsTicket::where('estatus','=',$estatus)
                ->Where('activo','=', 1)
                ->get();
        }else{
            $vstickets = VsTicket::where('activo','=',1)->get();
        }
	$tickets = $this->cargarDT($vstickets);

        return view('ticket.index')->with('tickets',$tickets)->with('tecnicos', $tecnicos)
            ->with('tecnicoElegido',$tecnicoElegido)->with('estatus',$estatus);
    }
    public function recepcionEquipo($ticket_id)
    {
        $ticket = VsTicket::find($ticket_id);
        $equipoPorTickets = VsEquiposPorTicket::where('ticket_id', '=', $ticket_id)->get();
        //$cuentaEquipoPorTickets = VsEquiposPorTicket::where('ticket_id', '=', $ticket_id)->count();

            return view('ticket.agregarEquiposTicket')->with('ticket', $ticket)->with('ticket_id', $ticket_id)->with('equipoPorTickets', $equipoPorTickets);
    }
    public function registrarEquipoTicket($equipo_id, $ticket_id){
         $equipoTicket = new EquipoTicket();
        $equipoTicket->ticket_id = $ticket_id;
        $equipoTicket->equipo_id = $equipo_id;
        $equipoTicket->save();
        return redirect('recepcionEquipo/'.$ticket_id)->with(array(
            'message'=>'El Equipo se agregó Correctamente al Ticket'
        ));
    }
    public function eliminarEquipoTicket($equipo_id, $ticket_id){
        EquipoTicket::where('ticket_id','=',$ticket_id)->where('equipo_id','=',$equipo_id)->delete();
        return redirect('recepcionEquipo/'.$ticket_id)->with(array(
            'message'=>'El Equipo se agregó Correctamente al Ticket'
        ));
    }
    public function delete_ticket($ticket_id){
        $ticket = Ticket::find($ticket_id);
        if($ticket){
            $ticket->activo = 0;
            $ticket->update();
            //
            $log = new Log();
        $log->tabla = "tickets";
        $mov="";
        $mov=$mov." area_id:".$ticket->area_id ." solicitante:". $ticket->solicitante ." contacto" .$ticket->contacto;
        $mov=$mov." tecnico_id:".$ticket->tecnico_id ." categoria:". $ticket->categoria ." prioridad" .$ticket->prioridad;
        if(!is_null($ticket->fecha_termino) && isset($ticket->fecha_termino)){
            $mov=$mov." estatus: Cerrado";
        }
        else{
            $mov=$mov." estatus:".$ticket->estatus;
        }
        $mov=$mov ." datos_reporte:". $ticket->datos_reporte ." fecha_reporte" .$ticket->fecha_reporte;
        $mov=$mov." fecha_inicio:".$ticket->fecha_inicio ." datos_reporte:". $ticket->datos_reporte ." fecha_termino" .$ticket->fecha_termino;
        $mov=$mov." problema:".$ticket->problema ." solucion:". $ticket->solucion . ".";
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Borrrado";
        $log->save();
        //
            return redirect()->route('tickets.index')->with(array(
                "message" => "El ticket se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
                "message" => "El ticket que trata de eliminar no existe"
            ));
        }

    }
    public function agregarComentario(Request $request){
       $ticket_equipo = EquipoTicket::where('ticket_id','=',$request->input('ticket_id'))->where('equipo_id','=',$request->input('equipo_id'))->first();
       $ticket_equipo->comentarios = $request->input('comentarios');
       $ticket_equipo->update();
       return redirect('recepcionEquipo/'.$request->input('ticket_id'))->with(array(
            'message'=>'El Equipo se agregó Correctamente al Ticket'
       ));
    }
    public function historial($id){
       //return $id;
       $tickets = VsTicket::where('activo','=',1)->where('area_id','=',$id)->get();
       $tecnicos = Tecnico::where('activo','=',1)->get();
       $tickets = $this->cargarDT($tickets);
       return view('ticket.index')->with('tickets',$tickets)->with('tecnicos',$tecnicos);
    }

    public function tomar_ticket($id){

        $ticket = Ticket::find($id);
        $ticket->tecnico_id = Auth::user()->id;
        $ticket->save();
        return $ticket;
        $vstickets = VsTicket::where('activo','=',1)
            ->where('estatus','=','Abierto')->get();

        $tecnicos = Tecnico::where('activo','=',1)->get();
        $tickets = $this->cargarDT($vstickets);
        return view('ticket.index')->with('tickets',$tickets)->with('tecnicos', $tecnicos);
     }

}
