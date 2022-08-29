<?php

namespace App\Http\Controllers;

use App\Models\Baja;
use App\Models\item_baja;
use App\Models\re_baja_item_baja;
use Illuminate\Foundation\Console\StorageLinkCommand;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BajaController extends Controller
{
    public function index(){
        $vsbajas = Baja::where('estatus','=',1)->get();
        $bajas = $this->cargarDT($vsbajas);
        return view('bajas.index')->with('bajas',$bajas);
    }

    //listar 
    public function cargarDT($consulta)
    {
        $baja = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-baja', $value['id']);
            $ticket = route('imprimirBaja', $value['id']);
            $actualizar =  route('bajas.edit', $value['id']);
            $documento = '../../storage/app/documentos/'.$value['documento'];
            
         

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="'.$actualizar.'" role="button" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="'.$ticket.'" class="btn btn-primary" title="Formato bajas">
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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este 
                      registro?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small> 
                            '.$value['id'].', '.$value['dependencia'].'                 </small>
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
        

            $baja[$key] = array(
                $acciones,
                $value['id'],
                $value['dependencia'],
                \Carbon\Carbon::parse($value['fecha_de_creacion'])->format('d/m/y'),
                \Carbon\Carbon::parse($value['fecha_de_finalizacion'])->format('d/m/y')
                
            );

        }

        return $baja;
    }


    public function create(){
        return view('bajas.create');
    }

    public function store(Request $request){
          $validateData = $this->validate($request,[
            'dependencia'=>'required',
            'fecha_de_creacion'=>'required',
            'fecha_de_finalizacion'=>'required',
            'descripcion'=>'required',
            'ano_adquisicion'=>'required',
            'motivo_baja'=>'required',
            'fecha_revision'=>'required',
            'encargado_revicion'=>'required',
            'encargado_revicion_mantenimiento'=>'required',
            'motivo_de_no_reparacion'=>'required',
          
        ]);
        $baja = new Baja();
        $baja->dependencia=$request->dependencia;
        $baja->fecha_de_creacion=$request->fecha_de_creacion;
        $baja->fecha_de_finalizacion=$request->fecha_de_finalizacion;

        $documento= $request->file('documento');
        if($documento){
          $doc_path = time().$documento->getClientOriginalName();
          \Storage::disk('documentos')->put($doc_path, \File::get($documento));
          $baja->documento = $doc_path;
        } 

        $baja->save();

        $item = new item_baja();

        $item->descripcion=$request->descripcion;
        
        $item->ano_adquisicion = $request->ano_adquisicion;
        $item->motivo_baja =$request->motivo_baja;
        $item->fecha_revision= $request->fecha_revision;
        $item->encargado_revicion =$request->encargado_revicion;
        $item->encargado_revicion_mantenimiento =$request->encargado_revicion_mantenimiento;
        $item->motivo_de_no_reparacion = $request->motivo_de_no_reparacion;

        $item->save();

        $rel = new re_baja_item_baja();

        $rel->id_baja=$baja->id;
        $rel->id_itemBaja = $item->id;

        $rel->save();
        return redirect('bajas')->with(array(
            'message'=>'La baja se guardo Correctamente'
        ));
        
    }

    

    //eliminar registro de baja
    public function delete_baja($baja_id){
      $baja = Baja::find($baja_id);
      if($baja){
        $baja->estatus =0;
        $baja->update();

        return redirect('bajas')->with(array(
          'message'=>'La baja se elimino Correctamente'
      ));
      }else{
        return redirect()->route('home')->with(array(
          "message" => "El registro que trata de eliminar no existe"
       ));
      }
      

    }

    


    public function edit($id){

      $baja= Baja::find($id);


      $vsitem = Baja::
        join('re_baja_item_baja','bajas.id','=','re_baja_item_baja.id_baja')
        ->join('item_baja','re_baja_item_baja.id_itemBaja','=','item_baja.id')
        ->select('item_baja.*')
        ->where('bajas.id','=',$id)->get();

        


        $items = $this->cargarIT($vsitem);

        
        
        return view('bajas.edit')->with('baja', $baja)->with('items',$items);
       
      }

      

      public function update(Request $request,Baja $baja ){

        //Editar Baja
        if($request->edit_baja){

          $validateData = $this->validate($request,[
            'dependencia'=>'required',
            'fecha_de_creacion'=>'required',
            'fecha_de_finalizacion'=>'required',
           
        ]);
        
        $baja->dependencia=$request->dependencia;
        $baja->fecha_de_creacion=$request->fecha_de_creacion;
        $baja->fecha_de_finalizacion=$request->fecha_de_finalizacion;
        
        $documento= $request->file('documento');

        if($documento){
          
          $doc_path = time().$documento->getClientOriginalName();
          \Storage::disk('documentos')->put($doc_path, \File::get($documento));
          $baja->documento = $doc_path;
        } 

        $baja->update();


            return redirect('bajas')->with(array(
              'message'=>'La baja se edito Correctamente'
          ));
        }
        if($request->guardar){
          $validateData = $this->validate($request,[
            'descripcion'=>'required',
            'ano_adquisicion'=>'required',
            'motivo_baja'=>'required',
            'fecha_revision'=>'required',
            'encargado_revicion'=>'required',
            'encargado_revicion_mantenimiento'=>'required',
            'motivo_de_no_reparacion'=>'required',
           
        ]);

            $item = new item_baja();

            $item->descripcion=$request->descripcion;
            $item->ano_adquisicion = $request->ano_adquisicion;
            $item->motivo_baja =$request->motivo_baja;
            $item->fecha_revision= $request->fecha_revision;
            $item->encargado_revicion =$request->encargado_revicion;
            $item->encargado_revicion_mantenimiento =$request->encargado_revicion_mantenimiento;
            $item->motivo_de_no_reparacion = $request->motivo_de_no_reparacion;

            $item->save();

            $rel = new re_baja_item_baja();

            $rel->id_baja = $request->id_baja;
            $rel->id_itemBaja = $item->id;

            $rel->save();

             return redirect()->route('bajas.edit',$baja->id);
            


        }elseif ($request->cancelar) {
             
          return redirect()->route('bajas.edit',$baja->id);
             
            
             
             
        }

          


       
      }

      //listar bienes
      public function cargarIT($consulta){

        $item = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-item', $value['id']);
            
            
         

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        
                        
                        <a href="#'.$ruta.'" role="button" class="btn btn-danger" data-toggle="modal" title="Eliminar">
                            <i class="far fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <div class="modal fade" id="'.$ruta.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este 
                      registro?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <p class="text-primary">
                        <small> 
                            '.$value['id'].', '.$value['descripcion'].'                 </small>
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

            $item[$key] = array(
                $acciones,
                $value['id'],
                $value['descripcion'],
                $value['ano_adquisicion'],
                $value['motivo_baja'],
                \Carbon\Carbon::parse($value['fecha_revision'])->format('d/m/Y'),
                ucwords($value['encargado_revicion']),
                ucwords($value['encargado_revicion_mantenimiento']),
                $value['motivo_de_no_reparacion']
                
                
            );

        }

        return $item;

      }

      //eliminar item de la baja
      public function delete_item($item_id){

        $item = item_baja::find($item_id);

        $baja  = item_baja:: 
        join('re_baja_item_baja','item_baja.id','=','re_baja_item_baja.id_itemBaja')
        ->join('bajas','re_baja_item_baja.id_baja','=','bajas.id')
        ->select('bajas.*')
        ->where('item_baja.id','=',$item_id)->get();

        //obtener ide de la baja

         $id_baja =$baja[key(['id'])];
        
         $item->delete(); 
      
        return redirect()->route('bajas.edit',$id_baja->id);
  

      }


      public function imprimirBaja($id){
        $item= Baja::
        join('re_baja_item_baja','bajas.id','=','re_baja_item_baja.id_baja')
        ->join('item_baja','re_baja_item_baja.id_itemBaja','=','item_baja.id')
        ->select('item_baja.*','bajas.*')
        ->where('bajas.id','=',$id)->get();
        
        $baja= Baja::find($id);

          $items = $baja [key([$baja])];

           $pdf = \PDF::loadView('bajas.formatoBaja', compact('item'),compact('baja'));
           return $pdf->stream('formatoBaja.pdf');
           //return $pdf->download('bajas.formatoBaja.pdf');   
      }

      public function getDocument($filename){
        $file = Storage::disk('documentos')->get($filename);
        return new Response ($file,200);
        
     }
}
