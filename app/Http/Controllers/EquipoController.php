<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\complementos_switch;
use App\Models\Equipo;
use App\Models\Empleado;
use App\Models\VsEquipo;
use App\Models\VsPrestamo;
use App\Models\EquipoPorPrestamo;
use App\Models\InventarioDetalle;
use App\Models\VsEquiposPorTicket;
use App\Models\VsTicket;
use App\Models\MovimientoEquipo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Ip;
use App\Models\Subred;
use equipo as GlobalEquipo;
use Faker\Calculator\Ean;

class EquipoController extends Controller
{
    public function index()
    {



    }


    public function create()
    {
        $empleados = Empleado::all()->sortBy('nombre');
        $areas = Area::all();
	$tipo_equipos = Equipo::distinct()->orderby('tipo_equipo','asc')->get(['tipo_equipo']);
	$ip = IP::join('subredes','ips.id_subred','=','subredes.id')
        ->select('subredes.*','ips.*')
        ->where('ips.disponible','=','si')->get();
        return view('equipo.create')->with('empleados', $empleados)->with('areas', $areas)->with('tipo_equipos', $tipo_equipos)->with('ips',$ip);
    }

    public function store(Request $request)
    {
        $validateData = $this->validate($request,[
            'udg_id'=>'required',
            'ip_id'=>'required',
            'tipo_equipo'=>'required',
            'marca'=>'required',
            'modelo'=>'required',
            'numero_serie'=>'required',
            'mac'=>'required',
            'tipo_conexion'=>'required',
            'detalles'=>'required'
            ]);
        $equipo = new equipo();
        $equipo->udg_id = $request->input('udg_id');
        $equipo->tipo_equipo = $request->input('tipo_equipo');
        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->numero_serie = $request->input('numero_serie');
        $equipo->mac = $request->input('mac');
        if($request->input('ip_id')=="null"){
            $equipo->ip = null;
        }else{
            $equipo->ip = $request->input('ip_id');
            
        }

    	$equipo->tipo_conexion = $request->input('tipo_conexion');
        $equipo->detalles = $request->input('detalles');
        $equipo->id_resguardante = $request->input('id_resguardante');
	    $equipo->resguardante = $request->input('resguardante');
    	$equipo->localizado_sici = 'No especificado';
        // $equipo->localizado_sici = $request->input('localizado_sici');
        $equipo->save();

	if($request->input('ip_id')!='null'){
        $ip = Ip::where('ip','=',$request->input('ip_id'))->first();
        $ip->gateway = $request->input('gateway');
        $ip->mascara = $request->input('mascara');
        $ip->disponible = 'no';
        $ip->update();
    }





	$movimiento_equipo = new MovimientoEquipo;
	$movimiento_equipo->id_equipo = $equipo->id;
	$movimiento_equipo->id_area = $request->input('area_id');
	$movimiento_equipo->id_usuario = $request->input('id_resguardante');
	$movimiento_equipo->registro = 'Alta de equipo';
	$movimiento_equipo->fecha = now();
	$movimiento_equipo->comentarios = 'Alta equipo';
	$movimiento_equipo->save();

	//
        $log = new Log();
        $log->tabla = "equipos";
        $mov="";
        $mov=$mov." udg_id:".$equipo->udg_id ." tipo_equipo:". $equipo->tipo_equipo ." marca:" .$equipo->marca;
        $mov=$mov." modelo:".$equipo->modelo ." numero_serie:". $equipo->numero_serie ." mac:" .$equipo->mac;
        $mov=$mov." ip:".$equipo->ip ." tipo_conexion:". $equipo->tipo_conexion ." detalles:" .$equipo->detalles;
        $mov=$mov." id_resguardante:".$equipo->id_resguardante ." resguardante:". $equipo->resguardante ." localizado_sici:" .$equipo->localizado_sici;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('/')->with(array(
            'message'=>'El equipo se guardo Correctamente'
        ));
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $empleados = Empleado::all()->sortBy('nombre');
	$tipo_equipos = Equipo::distinct()->orderby('tipo_equipo','asc')->get(['tipo_equipo']);



        $equipo = Equipo::find($id);
        $ip_equipo=null;
        if($equipo->id!=null){
            //si el equipo tiene ip asignada
            $ip_equipo=Ip::where('ip','=',$equipo->ip)->first();
            $subred_equipo=Ip::
            join('subredes','ips.id_subred','=','subredes.id')
            ->select('subredes.*')
            ->where('ips.ip','=',$equipo->ip)->first();

        }

        $ip = IP::join('subredes','ips.id_subred','=','subredes.id')
        ->select('subredes.*','ips.*')
        ->where('ips.disponible','=','si')->get();
        
        if($equipo){
            $idResguardante=$equipo->id_resguardante;
            if($idResguardante==0){
                $idResguardante=39;
            }
            $resguardante = Empleado::find($idResguardante);
            return view('equipo.edit')->with('equipo', $equipo)->with('empleados', $empleados)->with('resguardante',$resguardante)->with('tipo_equipos', $tipo_equipos)->with('ips',$ip)->with('ip_equipo',$ip_equipo)->with('subred_equipo',$subred_equipo);
        }else{
            return redirect('/')->with(array(
                'message'=>'El Id que desea modificar no existe'
            ));
        }


    }


    public function update(Request $request, $id)
    {
        
        $equipo = Equipo::find($id);
	    $equipo_ip = $equipo->ip;
        $equipo->udg_id = $request->input('udg_id');
        $equipo->tipo_equipo = $request->input('tipo_equipo');
        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->numero_serie = $request->input('numero_serie');
        $equipo->mac = $request->input('mac');

        if($request->input('ip_id')=="No Especificado"){
            $equipo->ip = 'No Especificado';
            

        }else{
            $equipo->ip = $request->input('ip_id');
            $ip = Ip::where('ip','=',$request->input('ip_id'))->first();
            $ip->disponible = 'no';
            $ip->gateway = $request->input('gateway');
            $ip->mascara = $request->input('mascara');
            $ip->update();  
        }


        $equipo->tipo_conexion = $request->input('tipo_conexion');
        $equipo->detalles = $request->input('detalles');
        $equipo->id_resguardante = $request->input('id_resguardante');
	    $equipo->resguardante = $request->input('resguardante');
        $equipo->localizado_sici = $request->input('localizado_sici');
	$equipo->update();

    if($equipo_ip=="No Especificado"){//antes era null y veremos que es ahora
        if($equipo->ip!="No Especificado"){//la selecionada no es null
            $ip = Ip::where('ip','=',$request->input('ip_id'))->first();
            $ip->disponible = 'no';
            $ip->update();
        }
    }else{//antes tenia una ip
        if($equipo_ip!=$equipo->ip){//la ip va a cambiar
            $ip = Ip::where('ip','=',$equipo_ip)->first();
            $ip->disponible = 'si';
            $ip->gateway = $request->input('No Especificado');
            $ip->mascara = $request->input('No Especificado');
            $ip->update();
            if($equipo->ip!="No Especificado"){//la seleccionada no es null
                $ip = Ip::where('ip','=',$equipo->ip)->first();
                $ip->disponible = 'no';
                
                $ip->update();
            }else{
                $ip = Ip::where('ip','=',$equipo_ip)->first();
                $ip->gateway = $request->input('No Especificado');
                $ip->mascara = $request->input('No Especificado');
                $ip->update();
            }
        }


    }




	//
        $log = new Log();
        $log->tabla = "equipos";
        $mov="";
        $mov=$mov." udg_id:".$equipo->udg_id ." tipo_equipo:". $equipo->tipo_equipo ." marca:" .$equipo->marca;
        $mov=$mov." modelo:".$equipo->modelo ." numero_serie:". $equipo->numero_serie ." mac:" .$equipo->mac;
        $mov=$mov." ip:".$equipo->ip ." tipo_conexion:". $equipo->tipo_conexion ." detalles:" .$equipo->detalles;
        $mov=$mov." id_resguardante:".$equipo->id_resguardante ." resguardante:". $equipo->resguardante ." localizado_sici:" .$equipo->localizado_sici;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Edicion";
        $log->save();
        //
        return redirect('/')->with(array(
            'message'=>'El equipo se actualizó correctamente'
        ));
    }


    public function destroy($id)
    {
        //
    }


    public function revisionInventario(){
        return view('equipo.revision-inventario');
    }
    public function busquedaAvanzada(){
        return view('equipo.busquedaAvanzada');
    }
    public function busqueda(Request $request){
        $validateData = $this->validate($request,[
           'busqueda'=>'required'
           ]);

       $busqueda = $request->input('busqueda');
       if(isset($busqueda) && !is_null($busqueda)){
           $vsequipos = VsEquipo::where('activo','=',1)
               ->where('id','=',$busqueda)
               ->orWhere('udg_id','LIKE','%'.$busqueda.'%')
               ->orWhere('marca','LIKE','%'.$busqueda.'%')
               ->orWhere('modelo','LIKE','%'.$busqueda.'%')
               ->orWhere('numero_serie','LIKE','%'.$busqueda.'%')
               ->orWhere('mac','LIKE','%'.$busqueda.'%')
               ->orWhere('ip','LIKE','%'.$busqueda.'%')
	       ->orWhere('detalles','LIKE','%'.$busqueda.'%')
               ->orWhere('tipo_conexion','LIKE','%'.$busqueda.'%')
               ->orWhere('tipo_equipo','LIKE','%'.$busqueda.'%')
               ->orWhere('area','LIKE','%'.$busqueda.'%')->get();

	   $equipos = $this->cargarDT($vsequipos );

           return view('equipo.busqueda')->with('equipos',$equipos)->with('busqueda', $busqueda);
       }else{
           return redirect('home')->with(array(
               'message'=>'Debe introducir un término de búsqueda'
           ));
       }

    }
    public function busquedaEquiposTicket(Request $request){
        $validateData = $this->validate($request,[
            'busqueda'=>'required'
        ]);

        $busqueda = $request->input('busqueda');
        $ticket_id = $request->input('ticket_id');
        $ticket = VsTicket::find($ticket_id);
        if(isset($busqueda) && !is_null($busqueda)){
            $equipos = VsEquipo::where('id','=',$busqueda)
                ->orWhere('udg_id','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('modelo','LIKE','%'.$busqueda.'%')
                ->orWhere('numero_serie','LIKE','%'.$busqueda.'%')
                ->orWhere('mac','LIKE','%'.$busqueda.'%')
                ->orWhere('ip','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_conexion','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_equipo','LIKE','%'.$busqueda.'%')
                ->orWhere('area','LIKE','%'.$busqueda.'%')->get();
            $equipoPorTickets = VsEquiposPorTicket::where('ticket_id','=', $ticket_id)->get();
            return view('ticket.agregarEquiposTicket')->with('equipos',$equipos)->with('busqueda', $busqueda)
                ->with('ticket', $ticket)->with('ticket_id', $ticket_id)->with('equipoPorTickets', $equipoPorTickets);
        }else{
            return redirect('home')->with(array(
                'message'=>'Debe introducir un término de búsqueda'
            ));
        }

    }

public function busquedaEquiposPrestamo(Request $request){
        $validateData = $this->validate($request,[
            'busqueda'=>'required'
        ]);

        $busqueda = $request->input('busqueda');
        $prestamo_id = $request->input('prestamo_id');
        $prestamo = VsPrestamo::find($prestamo_id);
        if(isset($busqueda) && !is_null($busqueda)){
            $equipos = VsEquipo::where('id','=',$busqueda)
                ->orWhere('udg_id','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('marca','LIKE','%'.$busqueda.'%')
                ->orWhere('modelo','LIKE','%'.$busqueda.'%')
                ->orWhere('numero_serie','LIKE','%'.$busqueda.'%')
                ->orWhere('mac','LIKE','%'.$busqueda.'%')
                ->orWhere('ip','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_conexion','LIKE','%'.$busqueda.'%')
                ->orWhere('tipo_equipo','LIKE','%'.$busqueda.'%')
                ->orWhere('area','LIKE','%'.$busqueda.'%')->get();
            $equipoPorPrestamo = EquipoPorPrestamo::where('id_prestamo','=', $prestamo_id)->get();
            return view('prestamo.agregarEquiposPrestamo')->with('equipos',$equipos)->with('busqueda', $busqueda)
                ->with('prestamo', $prestamo )->with('prestamo_id', $prestamo_id)->with('equipoPorPrestamo', $equipoPorPrestamo);
        }else{
            return redirect('home')->with(array(
                'message'=>'Debe introducir un término de búsqueda'
            ));
        }

    }
    public function inventario_cta(){
        //Se hace la ruta, la ruta manda llamar el método y el método manda llamar la plantilla
        $vsequipos = VsEquipo::where('activo', '=', 1)
            ->Where('resguardante', '=', 'CTA')->get();
	$equipos = $this->cargarDT($vsequipos );
        return view('equipo.inventariocta', array(
            'equipos' => $equipos

        ));

    }


    public function cargarDT($consulta)
    {
        $equipos = [];

        foreach ($consulta as $key => $value){

            $cambiarubicacion = route('cambiar-ubicacion', $value['id']);
            $actualizar =  route('equipos.edit', $value['id']);
            $expediente = "expediente/".$value['id'];
            $prestamo = route('generar-prestamo', $value['id']);
	    $historial = route('historial', $value['id']);
	    $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-equipo', $value['id']);
            if(Auth::user()->role != 'general') {
                $acciones = '
			<div class="btn-acciones">
                    	    <div class="btn-circle">
				<a href="' . $actualizar . '" title="Actualizar">
				<span class="text-success"><span class="material-icons">edit</span></span>
                        	</a>
                        	<a href="' . $prestamo . '"  title="Prestamo">
                            	<span class="text-info"><span class="material-icons">feed</span></span>
                        	</a>
				<a href="' . $cambiarubicacion . '"  title="Reubicar">
                            	<span class="text-danger"><span class="material-icons">location_on</span></span>
				</a>
				<a href="' . $historial . '"  title="Historial">
                            	<span class="text-secondary"><span class="material-icons">history</span></span>
				</a>
                <a href="'.$expediente.'" role="button" class="btn btn-success"  title="expediente">
                               <i class="fas fa-clipboard"></i>
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
                                       <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este equipo?</h5>
                                       <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        	       <span aria-hidden="true">&times;</span>
                                       </button>
                                 </div>
                    		 <div class="modal-body">
		                    <p class="text-primary">
                		      <small>
                                          Marca: ' . $value['marca'] . ', Modelo:' . $value['modelo'] . ', N/S: ' . $value['numero_serie'] . '
		                      </small>
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
            }
		$localizado_en_sici='';
		if($value['resguardante']=='CTA'){

                                if($value['localizado_sici']=='Si')
                                     $localizado_en_sici.='Localizado';
                                else
                                    $localizado_en_sici.='No localizado';

                }
        if(Auth::user()->role != 'general'){
            $equipos[$key] = array(
                $acciones,
                $value['id'],
                $value['udg_id'],
                $value['tipo_equipo'],
                $value['marca'],
                $value['modelo'],
                $value['numero_serie'],
                $value['detalles'].' SICI: '.$localizado_en_sici,
                $value['area']
            );
        }else{
            $equipos[$key] = array(
                $value['id'],
                $value['udg_id'],
                $value['tipo_equipo'],
                $value['marca'],
                $value['modelo'],
                $value['numero_serie'],
                $value['detalles'].' SICI: '.$localizado_en_sici,
                $value['area']
            );
        }


        }
        // dd("No equipoController");
        return $equipos;
    }

    public function delete_equipo($equipo_id){

        $equipo = Equipo::find($equipo_id);

        if($equipo){

            $equipo->activo = 0;
            $equipo->update();
	     //
            $log = new Log();
        $log->tabla = "Equipos";
        $mov="";
        $mov=$mov."Eliminaci�n l�gica del Equipo: ".$equipo_id;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Borrrado";
        $log->save();
        //

            return redirect()->route('home')->with(array(
                "message" => "El equipo se ha eliminado correctamente"
            ));

        }else{

            return redirect()->route('home')->with(array(
                "message" => "El equipo que trata de eliminar no existe"
            ));
        }

    }

    //Funciones para los switches
    public function switches(){
        $switches = VsEquipo::
            join('complementos_switch','vs_equipos.id','=','complementos_switch.id_equipo')
            ->select('vs_equipos.*','complementos_switch.switch as switchS','complementos_switch.licencias as licencias','complementos_switch.enlace as enlace' ,'complementos_switch.accesso as acceso' ,'complementos_switch.descripcion as descripcion')
            ->where('vs_equipos.tipo_equipo','=','Switch')->get();

            $switch=$this-> cargarSW($switches);

            return view('equipo.equipo-switches')->with('switch',$switch);
            
    }

    //cargar switches

    public function cargarSW($consulta){
        $switches = [];
        foreach ($consulta as $key => $value){
            $cambiarubicacion = route('cambiar-ubicacion', $value['id']);
            $actualizar =  route('equipo.edit_switch', $value['id']);

            $acciones = '
			<div class="btn-acciones">
                    	    <div class="btn-circle">
				<a href="' . $actualizar . '" title="Actualizar">
                <span class="text-success"><span class="material-icons">edit</span></span>
                        	</a>
                
                <a href="' . $cambiarubicacion . '"  title="Reubicar">
                            	<span class="text-danger"><span class="material-icons">location_on</span></span>
				</a>
                </div>
            </div>'
            
                ;

            $switches[$key] = array(
            $acciones,
            $value['id'],
            $value['udg_id'],
            $value['switchS'],
            $value['licencias'],
            $value['ip'],
            $value['mac'],
            $value['acceso'],
            $value['descripcion'],
            $value['enlace'],
            $value['modelo'],
            $value['marca'],
            $value['numero_serie'],
            $value['area']

            
        );


        }

        return $switches;

    }

    //Filtrar switch por numero de serie
    public function filtroNumero_serie(Request $request){
        if($request->input('numero')==0){
            return redirect()->route('switches')->with(array(
                "message" => "Filtros no seleccionados"
            ));
        }
        $switches =VsEquipo::
            join('complementos_switch','vs_equipos.id','=','complementos_switch.id_equipo')
            ->select('vs_equipos.*','complementos_switch.switch as switchS','complementos_switch.licencias as licencias','complementos_switch.enlace as enlace' ,'complementos_switch.accesso as acceso' ,'complementos_switch.descripcion as descripcion')
            ->where('vs_equipos.tipo_equipo','=','Switch')->get();
        $switch = $request->input('numero');
        
        $switchElegido = VsEquipo::
        join('complementos_switch','vs_equipos.id','=','complementos_switch.id_equipo')
        ->select('vs_equipos.*','complementos_switch.switch as switchS','complementos_switch.licencias as licencias','complementos_switch.enlace as enlace' ,'complementos_switch.accesso as acceso' ,'complementos_switch.descripcion as descripcion')
        ->where('vs_equipos.numero_serie','=',$switch)->get();

        if((isset($switch) && !is_null($switch))){
            if($switchElegido){
                $filtro = VsEquipo::
                join('complementos_switch','vs_equipos.id','=','complementos_switch.id_equipo')
                ->select('vs_equipos.*','complementos_switch.switch as switchS','complementos_switch.licencias as licencias','complementos_switch.enlace as enlace' ,'complementos_switch.accesso as acceso' ,'complementos_switch.descripcion as descripcion')
                ->where('vs_equipos.numero_serie','=',$switch)->get();

                $switchess = $this->cargarSW($filtro);
            
            }
            

        } else {
            $switches = VsEquipo::
                join('complementos_switch','vs_equipos.id','=','complementos_switch.id_equipo')
                ->select('vs_equipos.*','complementos_switch.switch as switchS','complementos_switch.licencias as licencias','complementos_switch.enlace as enlace' ,'complementos_switch.accesso as acceso' ,'complementos_switch.descripcion as descripcion')
                ->where('vs_equipos.tipo_equipo','=','Switch')->get();
        }

        return view('equipo.equipo-switches')
            ->with('switch', $switchess)
            ->with('switches',$switches)
            ->with('switchElegido',$switchElegido);

    }

    public function createSw(){
        $empleados = Empleado::all()->sortBy('nombre');
        $areas = Area::all();
        $ip = Ip::where('disponible','=','si')->get();
        return view('equipo.capturar_switches')->with('empleados', $empleados)->with('areas', $areas)->with('ips',$ip);

    }

    //capturar switch

    public function storeSw(Request $request)
    {
        $validateData = $this->validate($request,[
            'udg_id'=>'required',
            'ip_id'=>'required',
            
            'marca'=>'required',
            'modelo'=>'required',
            'numero_serie'=>'required',
            'mac'=>'required',
            'tipo_conexion'=>'required',
            'detalles'=>'required'
            ]);
        $equipo = new equipo();
        $equipo->udg_id = $request->input('udg_id');
        $equipo->tipo_equipo = "Switch"; 
        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->numero_serie = $request->input('numero_serie');
        $equipo->mac = $request->input('mac');
        if($request->input('ip_id')=="null"){
            $equipo->ip = null;
        }else{
            $equipo->ip = $request->input('ip_id');
        }

    	$equipo->tipo_conexion = $request->input('tipo_conexion');
        $equipo->detalles = $request->input('detalles');
        $equipo->id_resguardante = $request->input('id_resguardante');
	    $equipo->resguardante = $request->input('resguardante');
    	$equipo->localizado_sici = 'No especificado';
        // $equipo->localizado_sici = $request->input('localizado_sici');
        $equipo->save();

        if($request->input('ip_id')!='null'){
            $ip = Ip::where('ip','=',$request->input('ip_id'))->first();
            $ip->disponible = "no";
            $ip->update();
        }

        $complementos_swtich= new complementos_switch();
        $complementos_swtich->id_equipo = $equipo->id;
        $complementos_swtich->switch=$request->input('switch');
        $complementos_swtich->licencias = $request->input('licencias');
        $complementos_swtich->enlace = $request->input('enlace');
        $complementos_swtich->accesso= $request->input('acceso');
        $complementos_swtich->descripcion = $request->input('descripcion');

        $complementos_swtich->save();

        

	

    $movimiento_equipo = new MovimientoEquipo;
	$movimiento_equipo->id_equipo = $equipo->id;
	$movimiento_equipo->id_area = $request->input('area_id');
	$movimiento_equipo->id_usuario = $request->input('id_resguardante');
	$movimiento_equipo->registro = 'Alta de equipo';
	$movimiento_equipo->fecha = now();
	$movimiento_equipo->comentarios = 'Alta equipo';
	$movimiento_equipo->save();

	//
        $log = new Log();
        $log->tabla = "equipos";
        $mov="";
        $mov=$mov." udg_id:".$equipo->udg_id ." tipo_equipo:". $equipo->tipo_equipo ." marca:" .$equipo->marca;
        $mov=$mov." modelo:".$equipo->modelo ." numero_serie:". $equipo->numero_serie ." mac:" .$equipo->mac;
        $mov=$mov." ip:".$equipo->ip ." tipo_conexion:". $equipo->tipo_conexion ." detalles:" .$equipo->detalles;
        $mov=$mov." id_resguardante:".$equipo->id_resguardante ." resguardante:". $equipo->resguardante ." localizado_sici:" .$equipo->localizado_sici;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('switches')->with(array(
            'message'=>'El equipo se guardo Correctamente'
        ));
    }

//Editar switches




    public function editSW($id){
        $empleados = Empleado::all()->sortBy('nombre');

        $equipo = Equipo::find($id);
        $switch = complementos_switch::where('id_equipo','=',$id)->first();
        $area_actual = VsEquipo::find($id);
        $ip_equipo=null;
        if($equipo->id!=null){

            $ip_equipo=Ip::where('id','=',$equipo->ip)->first();

        }

        $ip = Ip::where('disponible','=','si')->get();
        if($equipo){
            $idResguardante=$equipo->id_resguardante;
            if($idResguardante==0){
                $idResguardante=39;
            }
            $resguardante = Empleado::find($idResguardante);
            return view('equipo.editar_switch')->with('equipo', $equipo)->with('area_actual',$area_actual)->with('empleados', $empleados)->with('switch', $switch)->with('resguardante',$resguardante)->with('ips',$ip)->with('ip_equipo',$ip_equipo);
        }else{
            return redirect('switches')->with(array(
                'message'=>'El Id que desea modificar no existe'
            ));
        }
    }

    public function updateSW(Request $request, $id){

        
        
        $validateData = $this->validate($request,[
            'udg_id'=>'required',
            
            'marca'=>'required',
            'modelo'=>'required',
            'numero_serie'=>'required',
            'mac'=>'required',
            'ip_id'=>'required',
            'tipo_conexion'=>'required',
            'detalles'=>'required'
        ]);
        $equipo = Equipo::find($id);
        $equipo_ip = $equipo->ip;
        $equipo->udg_id = $request->input('udg_id');
        $equipo->tipo_equipo = 'switch';
        $equipo->marca = $request->input('marca');
        $equipo->modelo = $request->input('modelo');
        $equipo->numero_serie = $request->input('numero_serie');
        $equipo->mac = $request->input('mac');
    
        if($request->input('ip_id')=="null"){
            $equipo->ip = null;
        }else{
            $equipo->ip = $request->input('ip_id');
        }
    
    
        $equipo->tipo_conexion = $request->input('tipo_conexion');
        $equipo->detalles = $request->input('detalles');
        $equipo->id_resguardante = $request->input('id_resguardante');
        $equipo->resguardante = $request->input('resguardante');
        $equipo->localizado_sici = $request->input('localizado_sici');
        $equipo->update();

        $complementos_swtich = complementos_switch::where('id_equipo','=',$id)->first();
        $complementos_swtich->id_equipo = $equipo->id;
        $complementos_swtich->switch= $request->input('switch');
        $complementos_swtich->licencias = $request->input('licencias');
        $complementos_swtich->enlace = $request->input('enlace');
        $complementos_swtich->accesso= $request->input('acceso');
        $complementos_swtich->descripcion = $request->input('descripcion');

        $complementos_swtich->update();

        $movimiento_equipo = new MovimientoEquipo;
        $movimiento_equipo->id_area = $request->input('area_id');
        $movimiento_equipo->update();

       


    
    if($equipo_ip==null){//antes era null y veremos que es ahora
        if($equipo->ip!=null){//la selecionada no es null
            $ip = Ip::where('ip','=',$equipo->ip)->get()[0];
            $ip->disponible = 'no';
            $ip->update();
        }
    }else{//antes tenia una ip
        if($equipo_ip!=$equipo->ip){//la ip va a cambiar
            $ip = Ip::where('ip','=',$equipo_ip)->get()[0];
            $ip->disponible = 'si';
            $ip->update();
            if($equipo->ip!=null){//la seleccionada no es null
                $ip = Ip::where('ip','=',$equipo->ip)->get()[0];
                $ip->disponible = 'no';
                $ip->update();
            }
        }}

        return redirect()->route('switches')->with(array(
            'message'=>'Los se actualizaron Correctamente'
        ));;


    }

}
