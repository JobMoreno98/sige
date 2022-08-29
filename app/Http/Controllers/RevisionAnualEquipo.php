<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VsRevisionanualEquipos;

class RevisionAnualEquipo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $revisioninventarioanual1 = VsRevisionanualEquipos::where('activo','=',1)->get();
        $revisioninventarioanual = $this->cargarDT($revisioninventarioanual1);
        return view('revision-inventario-anual.index')->with('revision-inventario-anual', $revisioninventarioanual);
    }
    public function revision_inventario_anual()
    {
        $revisioninventarioanual1 = VsRevisionanualEquipos::where('activo','=',1)->get();
        $revisioninventarioanual = $this->cargarDT($revisioninventarioanual1);
        return view('revision-inventario-anual.index')->with('revisioninventarioanual', $revisioninventarioanual);
    }
    public function cargarDT($consulta)
    {
        $revisioninventarioanual = [];

        foreach ($consulta as $key => $value){
           
            $cambiarubicacion = route('cambiar-ubicacion', $value['id']);
            $actualizar =  route('equipos.edit', $value['id']);
            $prestamo = route('generar-prestamo', $value['id']);
	        $historial = route('historial', $value['id']);

            $acciones = '
                <div class="btn-acciones">
                    <div class="btn-circle">
                        <a href="'.$actualizar.'" class="btn btn-success" title="Actualizar">
                            <i class="far fa-edit"></i>
                        </a>
                        <a href="'.$prestamo.'" class="btn btn-primary"  title="Prestamo">
                            <i class="far fa-file-alt"></i>
                        </a>
			<a href="'.$cambiarubicacion.'" class="btn btn-danger" title="Reubicar">
                            <i class="far fa-map-marker-alt"></i>
                        </a>
			<a href="'.$historial.'" class="btn btn-primary" title="Historial">
                            <i class="far fa-calendar-alt"></i>
                        </a>

                    </div>
                </div>
               
            ';

            $revisioninventarioanual[$key] = array(
                $acciones,
                $value['id'],
                $value['udg_id'],
                $value['detalles'].' - '.'Localizado SICI -'. '  '. $value['localizado_sici'],
                $value['marca'],
                $value['modelo'],
                $value['numero_serie'],
                $value['tipo_equipo'],
                $value['area'],
                $value['fechaHora'],
                $value['inventario'],
                $value['estatus'],
                $value['notas']


            );

        }

        return $revisioninventarioanual;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('revisioninventarioanual.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
}
