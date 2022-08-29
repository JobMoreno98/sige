<?php

namespace App\Http\Controllers;

use App\Models\Log;
use App\Models\Personal;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PersonalsExport;
use Dompdf\Dompdf;



use function Symfony\Component\String\b;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $personal = Personal::where('activo','=',1)->get();
        $vspersonal = $this->cargarDT($personal);
        return view('personal.index')->with('personal',$vspersonal);
    }

    public function search(Request $request)
    {

      if($request->ajax()){
        if($request->input('filterBy') == 'nombre'){
          $data = Personal::where('NombreYApellidos', 'like', '%'.$request->input('filter'). '%')->get();
        }else if($request->input('filterBy') == 'codigo'){
          $data = Personal::where('Codigo',$request->input('filter') )->get();
        }
      }

      $output = '';
      if(count($data) > 0){
              foreach ($data as $row) {

                $ruta = "eliminar".$row['id'];
                $eliminar = route('delete-personal', $row['id']);
                $actualizar =  route('personal.edit', $row['id']);
                $acciones = '';

                $acciones = `
                @can('cNormal_PERSONAL#editar')
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
                          <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este persoanl?</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <a href="'.$eliminar.'" type="button" class="btn btn-danger">Eliminar</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  @endcan
                `;



                $output .= '
                <tr>
                  <td>'.$acciones.'</td>
                  <td>'.$row->Codigo.'</td>
                  <td>'.$row->NombreYApellidos.'</td>
                  <td>'.$row->Sexo.'</td>
                  <td>'.$row->RFC.'</td>
                  <td>'.$row->CURP.'</td>
                  <td> Division: '.$row->Division.'
                  Depto: '.$row->DepartamentoAdscripcion .'
                  Depto Laboral: '.$row->DepartamentoLabora .'
                  Categoría: '.$row->Categoria .'
                  Observaciones: '.$row->OBSERVACIONES_1 .'
                  Nombramiento: '.$row->NombramientoDirectivoTemporal.'

                   </td>
                  <td>

                  Division: '.$row->Division .'
                  Depto: '.$row->DepartamentoAdscripcion .'
                  Depto Laboral: '.$row->DepartamentoLabora .'
                  Categoría: '.$row->Categoria .'
                  Observaciones: '.$row->OBSERVACIONES_1 .'
                  Nombramiento: '.$row->NombramientoDirectivoTemporal.'

                  </td> </tr> ';
              }
      }else{
        $output = "no data found";
      }
      return $output;
    }

    public function DT_exportExcel()
    {
        $perExport = new PersonalsExport;
        // $perExport->setValue($valueParameter);
        return Excel::download($perExport , 'personal.xlsx' );
    }

    public function DT_exportPDF()
    {
        $query = Personal::select(
            'NombreYApellidos',
            'Codigo',
            'Telefono',
            'TelefonoCelular',
            'Division',
            'Categoria',
            'DepartamentoLabora',
            'DepartamentoAdscripcion',
            'NombramientoDefinitivo',
            'NombramientoTemporal',
            'FECHA_DE_EMISION_NOMBRAMIENTO_DEF',
            'FechaInicioNombramientoDir',
            'FechaTerminoNombramientoDir',
            'FechaInicioContratoLaboral',
            'FechaFinContratoLaboral',
        )->get();

         $dompdf = new Dompdf();
         $dompdf->loadHtml($this->table_to_PDF($query));
         $dompdf->setPaper('A2', 'landscape');
         $dompdf->render();
         $dompdf->stream('Infomes.pdf', ['Attachment'=>false]);
    }

    private function table_to_PDF($query)
    {
        $output = '
              <h3 align="center"> Reporte (100 registros solamente)</h3>
              <table width="100%" style="border-collapse: collapse; border: 0px;">
              <tr>

                  <th style="border: 1px solid; padding:5px;">
                      Nombres Y apellidos
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Código
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Telefono
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Telefono celular
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Divición
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Categoría
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Departamento en donde labora
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Departamento adscripción
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                        Nombramiento definitivo
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Nombramiento temporal
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                    Fecha de emision de nombramiento DEF
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                    Fecha inicio nombramiento Dir
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                    Fecha termino nombramiento Dir
                  </th>
                  <th style="border: 1px solid; padding:5px;">
                      Fecha inicio contrato laboral
                   </th>
                  <th style="border: 1px solid; padding:5px;">
                       Fecha fin contrato laboral
                   </th>
              </tr>
              ';

              $i = 0;
        foreach($query as $row){
            // if($i > 100)
            //     break;
              $output .= '
               <tr>
                   <td style="border: 1px solid; padding:5px;">
                       '.$row->NombreYApellidos.'
                   </td>
                   <td style="border: 1px solid; padding:5px;">
                      '.$row->Codigo.'
                  </td>

                  <td style="border: 1px solid; padding:5px;">
                       '.$row->Telefono.'
                   </td>
                   <td style="border: 1px solid; padding:5px;">
                         '.$row->TelefonoCelular.'
                     </td>
                     <td style="border: 1px solid; padding:5px;">
                        '.$row->Division.'
                    </td>
                    <td style="border: 1px solid; padding:5px;">
                        '.$row->Categoria.'
                    </td>
                    <td style="border: 1px solid; padding:5px;">
                        '.$row->DepartamentoLabora.'
                    </td>
                    <td style="border: 1px solid; padding:5px;">
                        '.$row->DepartamentoAdscripcion.'
                    </td>
                    <td style="border: 1px solid; padding:5px;">
                          '.$row->NombramientoDefinitivo.'
                      </td>
                      <td style="border: 1px solid; padding:5px;">
                         '.$row->NombramientoTemporal.'
                     </td>
                     <td style="border: 1px solid; padding:5px;">
                         '.$row->FECHA_DE_EMISION_NOMBRAMIENTO_DEF.'
                     </td>
                     <td style="border: 1px solid; padding:5px;">
                         '.$row->FechaInicioNombramientoDir.'
                     </td>
                     <td style="border: 1px solid; padding:5px;">
                         '.$row->FechaTerminoNombramientoDir.'
                     </td>
                     <td style="border: 1px solid; padding:5px;">
                            '.$row->FechaInicioContratoLaboral.'
                      </td>
                     <td style="border: 1px solid; padding:5px;">
                            '.$row->FechaFinContratoLaboral.'
                     </td>

              </tr>
              ';
              $i++;
          }
         $output .= '</table>';
        return $output;
    }

    public function cargarDT($consulta)
    {
        $personal = [];

        foreach ($consulta as $key => $value){

            $ruta = "eliminar".$value['id'];
            $eliminar = route('delete-personal', $value['id']);
            $actualizar =  route('personal.edit', $value['id']);
            $recibo = route('imprimirpersonal', $value['id']);

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="'.$actualizar.'" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="'.$recibo .'" class="btn btn-primary" title="Detalle Personal">
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
                      <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este persoanl?</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <a href="'.$eliminar.'" type="button" class="btn btn-danger">Eliminar</a>
                    </div>
                  </div>
                </div>
              </div>
            ';

            $personal [$key] = array(
                $acciones,
                $value['Codigo'],
                $value['NombreYApellidos'],
                $value['Sexo'],
                $value['RFC'],
                $value['CURP'],
                " <b> Division: </b>".$value['Division']." "."<b>Depto: </b> ".$value['DepartamentoAdscripcion']." "."<b> Depto Laboral:</b> ".$value['DepartamentoLabora']." "."<b> Categoría:</b> ".$value['Categoria']." "."<b> Observaciones:</b> ".$value['OBSERVACIONES_1']." "."<b> Nombramiento:</b> ".$value['NombramientoDirectivoTemporal'],
                "<b> Domicilio:</b> ".$value['Domicilio']." "."<b> Telefono:</b> ".$value['Telefono']." "."<b> Telefono Celular:</b> ".$value['TelefonoCelular']." "."<b> CP:</b> ".$value['CodigoPostal']." "."<b> Correo Electrónico:</b> ".$value['CorreoE'],
            );

        }

        return $personal;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('personal.create');
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
            'NombreYApellidos'=>'required',
        ]);

        $personal = new Personal();
        $personal->NombreYApellidos = $request->input('NombreYApellidos');
        $personal->Sexo = $request->input('Sexo');
        $personal->RFC = $request->input('RFC');
        $personal->CURP = $request->input('CURP');
        $personal->Nacionalidad = $request->input('Nacionalidad');
        $personal->Escolaridad = $request->input('Escolaridad');
        $personal->Division = $request->input('Division');
        $personal->DepartamentoAdscripcion = $request->input('DepartamentoAdscripcion');
        $personal->DepartamentoLabora = $request->input('DepartamentoLabora');
        $personal->Categoria = $request->input('Categoria');
        $personal->Domicilio = $request->input('Domicilio');
        $personal->Telefono = $request->input('Telefono');
        $personal->TelefonoCelular = $request->input('TelefonoCelular');
        $personal->CodigoPostal = $request->input('CodigoPostal');
        $personal->CorreoE = $request->input('CorreoE');

        $personal->save();
	//
        $log = new Log();
        $log->tabla = "archivo_personal";
        $mov="";
        $mov=$mov." NombreYApellidos:".$personal->NombreYApellidos ." Sexo:". $personal->Sexo ." RFC" .$personal->RFC;
        $mov=$mov." CURP:".$personal->CURP ." Nacionalidad:". $personal->Nacionalidad ." Escolaridad" .$personal->Escolaridad ." Division" .$personal->Division. "DepartamentoAdscripcion" .$personal->DepartamentoAdscripcion. "DepartamentoLabora" .$personal->DepartamentoLabora. "Categoria" .$personal->Categoria. "Domicilio" .$personal->Domicilio. "Telefono" .$personal->Telefono. "TelefonoCelular" .$personal->TelefonoCelular. "CodigoPostal" .$personal->CodigoPostal. "CorreoE" .$personal->CorreoE;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Insercion";
        $log->save();
        //
        return redirect('personal')->with(array(
            'message'=>'El personal se guardó Correctamente'
        ));
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function show(Personal $personal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $personal = Personal::find($id);
        return view('personal.edit')->with('personal', $personal);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validateData = $this->validate($request,[
            'NombreYApellidos'=>'required',


        ]);

        $personal = Personal::find($id);
        $personal->NombreYApellidos = $request->input('NombreYApellidos');
        $personal->Sexo = $request->input('Sexo');
        $personal->RFC = $request->input('RFC');
        $personal->CURP = $request->input('CURP');
        $personal->Nacionalidad = $request->input('Nacionalidad');
        $personal->Escolaridad = $request->input('Escolaridad');
        $personal->Division = $request->input('Division');
        $personal->DepartamentoAdscripcion = $request->input('DepartamentoAdscripcion');
        $personal->DepartamentoLabora = $request->input('DepartamentoLabora');
        $personal->Categoria = $request->input('Categoria');
        $personal->Domicilio = $request->input('Domicilio');
        $personal->Telefono = $request->input('Telefono');
        $personal->TelefonoCelular = $request->input('TelefonoCelular');
        $personal->CodigoPostal = $request->input('CodigoPostal');
        $personal->CorreoE = $request->input('CorreoE');

        $personal->update();
	//
        $log = new Log();
        $log->tabla = "archivo_personal";
        $mov="";
        $mov=$mov." NombreYApellidos:".$personal->NombreYApellidos ." Sexo:". $personal->Sexo ." RFC" .$personal->RFC;
        $mov=$mov." CURP:".$personal->CURP ." Nacionalidad:". $personal->Nacionalidad ." Escolaridad" .$personal->Escolaridad ." Division" .$personal->Division. "DepartamentoAdscripcion" .$personal->DepartamentoAdscripcion. "DepartamentoLabora" .$personal->DepartamentoLabora. "Categoria" .$personal->Categoria. "Domicilio" .$personal->Domicilio. "Telefono" .$personal->Telefono. "TelefonoCelular" .$personal->TelefonoCelular. "CodigoPostal" .$personal->CodigoPostal. "CorreoE" .$personal->CorreoE;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
        $log->acciones = "Edicion";
        $log->save();
        //
        return redirect('personal')->with(array(
            'message'=>'El personal se actualizó Correctamente'
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Personal  $personal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Personal $personal)
    {
        //
    }

    public function delete_personal($id){
        $personal = Personal::find($id);
        if($personal){
            $personal->activo = 0;
            $personal->update();
	    //
        $log = new Log();
        $log->tabla = "archivo_personal";
        $mov="";
        $mov=$mov." NombreYApellidos:".$personal->NombreYApellidos ." Sexo:". $personal->Sexo ." RFC" .$personal->RFC;
        $mov=$mov." CURP:".$personal->CURP ." Nacionalidad:". $personal->Nacionalidad ." Escolaridad" .$personal->Escolaridad ." Division" .$personal->Division. "DepartamentoAdscripcion" .$personal->DepartamentoAdscripcion. "DepartamentoLabora" .$personal->DepartamentoLabora. "Categoria" .$personal->Categoria. "Domicilio" .$personal->Domicilio. "Telefono" .$personal->Telefono. "TelefonoCelular" .$personal->TelefonoCelular. "CodigoPostal" .$personal->CodigoPostal. "CorreoE" .$personal->CorreoE;
        $log->movimiento = $mov;
        $log->usuario_id = Auth::user()->id;
            $log->acciones = "Borrado";
            $log->save();
            //
            return redirect()->route('personal.index')->with(array(
               "message" => "El personal se ha eliminado correctamente"
            ));
        }else{
            return redirect()->route('home')->with(array(
               "message" => "El personal que trata de eliminar no existe"
            ));
        }

    }

    public function recibo($id)
    {
        $personal = Personal::find($id);
            return view('personal.index')->with('personal', $personal);
    }

}
