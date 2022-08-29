<?php
/** @author @mikedloera */
namespace App\Http\Controllers;

use App\Models\Equipo;
use App\Models\Proyecto;
use App\Models\ProyectoActividad;
use App\Models\Tecnico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProyectoActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Muestra página de error 404
        $this->abortIfNull(null);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id_proyecto = null)
    {
        // Si $id_proyecto es nulo muestra un error 404
        $this->abortIfNull($id_proyecto);

        // Busca el proyecto y si no existe muestra error 404
        $proyecto = Proyecto::find($id_proyecto);
        $this->abortIfNull($proyecto);

        // Consulta de técnicos activos y ordenados de forma ascendente por nombre
        $tecnicos = Tecnico::where('activo', 1)
            ->orderBy('nombre', 'ASC')
            ->get();

        // Consulta de actividades previas y ordenados de forma ascendente por nombre
        $actividades_previas = ProyectoActividad::where('activo', 1)
            ->where('id_proyecto', $id_proyecto)
            ->orderBy('nombre', 'ASC')
            ->get();

        return view('proyecto.actividad.create')
            ->with('proyecto', $proyecto)
            ->with('tecnicos', $tecnicos)
            ->with('actividades_previas', $actividades_previas);
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
            'id_proyecto' => 'required',
            'nombre' => 'required',
            'descripcion' => 'required',
            'tiempo' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'tecnicos' => 'required',
            'equipos' => 'required',
            'actividades_previas' => 'required'
        ]);

        $id_proyecto = $request->input('id_proyecto');

        // Crea la actividad
        $actividad = new ProyectoActividad();
        $actividad->id_proyecto = $id_proyecto;
        $actividad->nombre = $request->input('nombre');
        $actividad->descripcion = $request->input('descripcion');
        $actividad->tiempo = $request->input('tiempo');
        $actividad->id_tecnicos = $request->input('tecnicos');
        $actividad->id_equipos = $request->input('equipos');
        $actividad->id_actividades_previas = $request->input('actividades_previas');
        $actividad->fecha_inicio = $request->input('fecha_inicio');
        $actividad->fecha_fin = $request->input('fecha_fin');

        $actividad->save();

        return redirect('proyectos/' . $id_proyecto)
            ->with('message', 'La actividad se guardó correctamente');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Muestra página de error 404
        $this->abortIfNull(null);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Busca la actividad
        $actividad = ProyectoActividad::find($id);

        // Si la actividad no existe muestra un error 404
        $this->abortIfNull($actividad);

        // Consulta de técnicos activos y ordenados de forma ascendente por nombre
        $tecnicos = Tecnico::where('activo', 1)
            ->orderBy('nombre', 'ASC')
            ->get();

        // Consulta de actividades previas y ordenados de forma ascendente por nombre
        $actividades_previas = ProyectoActividad::where('activo', 1)
            ->where('id_proyecto', $actividad->id_proyecto)
            ->orderBy('nombre', 'ASC')
            ->get();

        // Consulta el proyecto
        $proyecto = Proyecto::find($actividad->id_proyecto);

        // Consulta para mostrar los equipos asignados
        $equipos_seleccionados = [];
        $id_equipos = json_decode($actividad->id_equipos . '', true);

        // Bucle de los id de equipos guardados
        for ($i=0; $i < count($id_equipos); $i++) { 
            // Consulta el equipo
            $equipo = Equipo::where('id', $id_equipos[$i])
                ->select(DB::raw('id, CONCAT(tipo_equipo, " - ", marca, " - ", modelo, " - ", numero_serie) as value'))
                ->get()
                ->toArray();

            if (count($equipo) > 0) {
                // Añade el equipo al arreglo $equipos_seleccionados
                array_push($equipos_seleccionados, $equipo[0]);
            }
        }

        return view('proyecto.actividad.edit')
            ->with('proyecto', $proyecto)
            ->with('actividad', $actividad)
            ->with('tecnicos', $tecnicos)
            ->with('actividades_previas', $actividades_previas)
            ->with('equipos_seleccionados', $equipos_seleccionados);
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
            'nombre' => 'required',
            'descripcion' => 'required',
            'tiempo' => 'required',
            'fecha_inicio' => 'required',
            'fecha_fin' => 'required',
            'tecnicos' => 'required',
            'equipos' => 'required',
            'actividades_previas' => 'required'
        ]);

        // Edita la actividad
        $actividad = ProyectoActividad::find($id);
        $actividad->nombre = $request->input('nombre');
        $actividad->descripcion = $request->input('descripcion');
        $actividad->tiempo = $request->input('tiempo');
        $actividad->id_tecnicos = $request->input('tecnicos');
        $actividad->id_equipos = $request->input('equipos');
        $actividad->id_actividades_previas = $request->input('actividades_previas');
        $actividad->fecha_inicio = $request->input('fecha_inicio');
        $actividad->fecha_fin = $request->input('fecha_fin');

        $actividad->update();

        return redirect('proyectos/' . $actividad->id_proyecto)
            ->with('message', 'La actividad se actualizó correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Busca la actividad
        $actividad = ProyectoActividad::find($id);

        // Condición si existe el proyecto
        if ($actividad) {
            // Edita el campo activo
            $actividad->activo = 0;
            $actividad->update();

            return redirect()->route('proyectos.show', [$actividad->id_proyecto])
                ->with("message", "La actividad se ha eliminado correctamente");
        } else {
            return redirect()->route('proyectos.show', [$actividad->id_proyecto])
                ->with("message", "La actividad que trata de eliminar no existe");
        }
    }

    // Método para buscar equipos con Ajax en Select2 
    // https://select2.org/data-sources/ajax
    public function getEquipos(Request $request)
    {
        // Una petición GET con un parametro q
        $busqueda = $request->input('q');

        // Consulta equpos que coincida con la busqueda y solo muestra un maximo de 20 registros
        $equipos = Equipo::where('activo', 1)
            ->where(DB::raw('CONCAT(tipo_equipo, " - ", marca, " - ", modelo, " - ", numero_serie)'), 'LIKE', '%' . $busqueda . '%')
            ->select(DB::raw('id, CONCAT(tipo_equipo, " - ", marca, " - ", modelo, " - ", numero_serie) as text'))
            ->orderBy('text', 'ASC')
            ->paginate(20);

        // Retorna el resultado
        $result = ["results" => $equipos->toArray()["data"]];
        return $result;
    }

    // Si el parametro $e es nulo o indefinido muestra una vista de error 404
    private function abortIfNull($e)
    {
        if (!isset($e)) {
            abort(404);
        }
    }
}
