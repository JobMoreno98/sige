<?php
/** @author @mikedloera */
namespace App\Http\Controllers;

use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\Area;
use App\Models\Tecnico;
use App\Models\Empleado;
use Illuminate\Http\Request;

class ProyectoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Consulata a los proyectos activos y en ordenados de forma descendente por id
        $proyectos = Proyecto::where('proyectos.activo', 1)
            ->join('tecnicos', 'tecnicos.id', '=', 'proyectos.id_tecnico')
            ->join('areas', 'areas.id', '=', 'proyectos.id_area')
            ->select('proyectos.*', 'tecnicos.nombre as responsable', 'areas.sede', 'areas.division', 'areas.coordinacion', 'areas.area')
            ->orderBy('id', 'DESC')
            ->get();

        return view('proyecto.index')
            ->with('proyectos', $proyectos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Cunsulta de áreas activas y ordenados de forma ascendente de varios campos
        $areas = Area::where('activo', 1)
            ->orderBy('sede', 'ASC')
            ->orderBy('division', 'ASC')
            ->orderBy('coordinacion', 'ASC')
            ->orderBy('area', 'ASC')
            ->get();

        // Consulta de técnicos activos y ordenados de forma ascendente por nombre
        $tecnicos = Tecnico::where('activo', 1)
            ->orderBy('nombre', 'ASC')
            ->get();

        // Consulta de empleados activos y ordenados de forma ascendente por nombre
        $empleados = Empleado::where('activo', 1)
            ->orderBy('nombre', 'ASC')
            ->get();

        return view('proyecto.create')
            ->with('areas', $areas)
            ->with('tecnicos', $tecnicos)
            ->with('empleados', $empleados);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validaciones requeridas
        $validateData = $this->validate($request, [
            'titulo' => 'required',
            'area_interna' => 'required',
            'ubicacion' => 'required',
            'responsable' => 'required',
            'contacto' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ]);

        // Crea el proyecto
        $proyecto = new Proyecto();
        $proyecto->titulo = $request->input('titulo');
        $proyecto->area_interna = $request->input('area_interna');
        $proyecto->id_area = $request->input('ubicacion');
        $proyecto->id_tecnico = $request->input('responsable');
        $proyecto->id_empleado = $request->input('contacto');
        $proyecto->fecha_inicio = $request->input('fecha_inicio');
        $proyecto->fecha_fin = $request->input('fecha_fin');

        $proyecto->save();

        return redirect('proyectos')
            ->with('message', 'El proyecto se guardó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Busca el proyecto
        $proyecto = Proyecto::find($id);

        // Si el proyecto no existe retorna un error 404
        $this->abortIfNull($proyecto);

        // Consulta de las actividades de ese proyecto que esten activas
        $actividades = ProyectoActividad::where('activo', 1)
            ->where('id_proyecto', $id)
            ->orderBy('fecha_inicio', 'ASC')
            ->orderBy('fecha_fin', 'ASC')
            ->get();

        return view('proyecto.show')
            ->with('proyecto', $proyecto)
            ->with('actividades', $actividades);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Busca el proyecto
        $proyecto = Proyecto::find($id);

        // Si el proyecto no existe retorna un error 404
        $this->abortIfNull($proyecto);

        // Cunsulta de áreas activas y ordenados de forma ascendente de varios campos
        $areas = Area::where('activo', 1)
            ->orderBy('sede', 'ASC')
            ->orderBy('division', 'ASC')
            ->orderBy('coordinacion', 'ASC')
            ->orderBy('area', 'ASC')
            ->get();

        // Consulta de técnicos activos y ordenados de forma ascendente por nombre
        $tecnicos = Tecnico::where('activo', 1)
            ->orderBy('nombre', 'ASC')
            ->get();

        // Consulta de empleados activos y ordenados de forma ascendente por nombre
        $empleados = Empleado::where('activo', 1)
            ->orderBy('nombre', 'ASC')
            ->get();

        return view('proyecto.edit')
            ->with('proyecto', $proyecto)
            ->with('areas', $areas)
            ->with('tecnicos', $tecnicos)
            ->with('empleados', $empleados);
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
        // Validaciones requeridas
        $validateData = $this->validate($request, [
            'titulo' => 'required',
            'area_interna' => 'required',
            'ubicacion' => 'required',
            'responsable' => 'required',
            'contacto' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required'
        ]);

        // Edita el proyecto
        $proyecto = Proyecto::find($id);
        $proyecto->titulo = $request->input('titulo');
        $proyecto->area_interna = $request->input('area_interna');
        $proyecto->id_area = $request->input('ubicacion');
        $proyecto->id_tecnico = $request->input('responsable');
        $proyecto->id_empleado = $request->input('contacto');
        $proyecto->fecha_inicio = $request->input('fecha_inicio');
        $proyecto->fecha_fin = $request->input('fecha_fin');

        $proyecto->update();

        return redirect('proyectos')
            ->with('message', 'El proyecto se actualizó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Busca el proyecto
        $proyecto = Proyecto::find($id);

        // Condición si existe el proyecto
        if ($proyecto) {
            // Edita el campo activo
            $proyecto->activo = 0;
            $proyecto->update();
            
            return redirect()->route('proyectos.index')
                ->with("message", "El proyecto se ha eliminado correctamente");
        } else {
            return redirect()->route('proyectos.index')
                ->with("message", "El proyecto que trata de eliminar no existe");
        }
    }

    // Si el parametro $e es nulo o indefinido muestra una vista de error 404
    private function abortIfNull($e)
    {
        if (!isset($e)) {
            abort(404);
        }
    }
}
