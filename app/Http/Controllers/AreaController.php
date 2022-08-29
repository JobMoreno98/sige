<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Log;
use App\Models\VsTicket;
use App\Models\VsEquipo;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class AreaController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      $vsareas = Area::where('activo', '=', 1)->get();
      $areas = $this->cargarDT($vsareas);
      return view('areas.index')->with('areas', $areas);
   }
   public function cargarDT($consulta)
   {
      $area = [];

      foreach ($consulta as $key => $value) {

         $ruta = "eliminar" . $value['id'];
         $eliminar = route('delete-area', $value['id']);
         $actualizar =  route('areas.edit', $value['id']);


         $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="' . $actualizar . '" role="button" class="btn btn-success" title="Actualizar">
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

         $area[$key] = array(
            $acciones,
            $value['id'],
            $value['tipo_espacio'],
            $value['sede'],
            $value['edificio'],
            $value['piso'],
            $value['division'],
            $value['coordinacion'],
            $value['area'],
         );
      }

      return $area;
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
      return view('areas.create');
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
         'tipo_espacio' => 'required',
         'sede' => 'required',
         'edificio' => 'required',
         'piso' => 'required',
         'division' => 'required',
         'coordinacion' => 'required',
         'equipamiento' => 'required',
         'area' => 'required'
      ]);

      $area = new Area();
      $area->tipo_espacio = $request->input('tipo_espacio');
      $area->sede = $request->input('sede');
      $area->edificio = $request->input('edificio');
      $area->piso = $request->input('piso');
      $area->division = $request->input('division');
      $area->coordinacion = $request->input('coordinacion');
      $area->equipamiento = $request->input('equipamiento');
      $area->area = $request->input('area');

      $imagen_1 = $request->file('imagen_1');
      if ($imagen_1) {
         $image_path = time() . $imagen_1->getClientOriginalName();
         \Storage::disk('images')->put($image_path, \File::get($imagen_1));

         $area->imagen_1 = $image_path;
      }

      $imagen_2 = $request->file('imagen_2');
      if ($imagen_2) {
         $image_path = time() . $imagen_2->getClientOriginalName();
         \Storage::disk('images')->put($image_path, \File::get($imagen_2));

         $area->imagen_2 = $image_path;
      }

      $area->save();
      //
      $log = new Log();
      $log->tabla = "areas";
      $mov = "";
      $mov = $mov . " tipo_espacio:" . $area->tipo_espacio . " sede:" . $area->sede . " edificio" . $area->edificio;
      $mov = $mov . " piso:" . $area->piso . " division:" . $area->division . " coordinacion" . $area->coordinacion;
      $mov = $mov . " equipamiento:" . $area->equipamiento . " area:" . $area->area . ".";
      $log->movimiento = $mov;
      $log->usuario_id = Auth::user()->id;
      $log->acciones = "Insercion";
      $log->save();
      //
      return redirect('areas')->with(array(
         'message' => 'El área se guardo Correctamente'
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
      $area = Area::find($id);
      return view('areas.edit')->with('area', $area);
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
         'tipo_espacio' => 'required',
         'sede' => 'required',
         'edificio' => 'required',
         'piso' => 'required',
         'division' => 'required',
         'coordinacion' => 'required',
         'equipamiento' => 'required',
         'area' => 'required'
      ]);

      $area = Area::find($id);
      $area->tipo_espacio = $request->input('tipo_espacio');
      $area->sede = $request->input('sede');
      $area->edificio = $request->input('edificio');
      $area->piso = $request->input('piso');
      $area->division = $request->input('division');
      $area->coordinacion = $request->input('coordinacion');
      $area->equipamiento = $request->input('equipamiento');
      $area->area = $request->input('area');

      $imagen_1 = $request->file('imagen_1');
      if ($imagen_1) {
         $image_path = time() . $imagen_1->getClientOriginalName();
         \Storage::disk('images')->put($image_path, \File::get($imagen_1));

         $area->imagen_1 = $image_path;
      }

      $imagen_2 = $request->file('imagen_2');
      if ($imagen_2) {
         $image_path = time() . $imagen_2->getClientOriginalName();
         \Storage::disk('images')->put($image_path, \File::get($imagen_2));

         $area->imagen_2 = $image_path;
      }

      $area->update();
      //
      $log = new Log();
      $log->tabla = "areas";
      $mov = "";
      $mov = $mov . " tipo_espacio:" . $area->tipo_espacio . " sede:" . $area->sede . " edificio" . $area->edificio;
      $mov = $mov . " piso:" . $area->piso . " division:" . $area->division . " coordinacion" . $area->coordinacion;
      $mov = $mov . " equipamiento:" . $area->equipamiento . " area:" . $area->area . ".";
      $log->movimiento = $mov;
      $log->usuario_id = Auth::user()->id;
      $log->acciones = "Edicion";
      $log->save();
      //
      return redirect('areas')->with(array(
         'message' => 'El área se actualizo Correctamente'
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

   public function delete_area($area_id)
   {
      $area = Area::find($area_id);
      if ($area) {
         $area->activo = 0;
         $area->update();
         //
         $log = new Log();
         $log->tabla = "areas";
         $mov = "";
         $mov = $mov . " tipo_espacio:" . $area->tipo_espacio . " sede:" . $area->sede . " edificio" . $area->edificio;
         $mov = $mov . " piso:" . $area->piso . " division:" . $area->division . " coordinacion" . $area->coordinacion;
         $mov = $mov . " equipamiento:" . $area->equipamiento . " area:" . $area->area . ".";
         $log->movimiento = $mov;
         $log->usuario_id = Auth::user()->id;
         $log->acciones = "Borrado";
         $log->save();
         //
         return redirect()->route('areas.index')->with(array(
            "message" => "El área se ha eliminado correctamente"
         ));
      } else {
         return redirect()->route('home')->with(array(
            "message" => "El área que trata de eliminar no existe"
         ));
      }
   }

   public function getImage($filename)
   {
      $file = Storage::disk('images')->get($filename);
      return new Response($file, 200);
   }

   public function area_ticket($sede)
   {
      // Se obtienen las Aulas
      $areas = Area::select('id', 'ultimo_inventario', 'tipo_espacio', 'equipamiento', 'edificio', 'piso', 'area','imagen_1','imagen_2')
         ->where('sede', '=', $sede)->where('activo', 1)->where('tipo_espacio', '!=', 'Administrativa')->where('tipo_espacio', '!=', 'Administrativo')->orderBy('edificio')->get();
      // Se crea el contenedor principal
      $areas_f = array();
      foreach ($areas as $item) {
         $edificio = explode(' ', $item->edificio)[1];
         // Se obtienen los tickets abiertos para el aula
         $ticket = VsTicket::select('id', 'datos_reporte', 'area', 'area_id', 'solicitante','fecha_reporte','prioridad','contacto')->where('activo', 1)->where('area_id', '=', $item->id)->where('estatus', 'Abierto')->get();
         if (strcmp('Planta Baja', $item->piso) == 0) {
            $item->piso = 'Piso 0';
         }
         // Verifica si tiene ticket's si no los tiene guarda directamente el aula, en caso contrario recupera los tickets
         if (count($ticket) > 0) {
            if (array_key_exists($edificio, $areas_f)) {
               $item->tickets = $ticket;
               if (array_key_exists($item->piso, $areas_f[$edificio])) {
                  array_push($areas_f[$edificio][$item->piso], $item->toArray());
               } else {
                  $areas_f[$edificio][$item->piso] = [$item->toArray()];
               }
            } else {
               $areas_f[$edificio][$item->piso] = $ticket;
            }
         } else {
            if (isset($areas_f[$edificio])) {
               if (array_key_exists($item->piso, $areas_f[$edificio])) {
                  array_push($areas_f[$edificio][$item->piso], $item->toArray());
               } else {
                  $areas_f[$edificio][$item->piso] = [$item->toArray()];
               }
            } else {

               $areas_f[$edificio][$item->piso] = [$item->toArray()];
            }
         }
         ksort($areas_f[$edificio]);
      }
      $areas = collect($areas_f);
      return view('areas.area-ticket', compact('areas', 'sede'));

   }
   public function equipo_area($id){
      $area = Area::select('ultimo_inventario','tipo_espacio','sede','edificio','piso','division','coordinacion','area')
      ->where('id', $id)->first();
      $equipo = VsEquipo::where('activo','=',1)->where('id_area','=',$id)->get();      
      return view('areas.equipos',compact('area','equipo'));
   }
}
