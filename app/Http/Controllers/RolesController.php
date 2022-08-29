<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles = Role::all();
        return view('roles.index')->with('roles', $roles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'rol' => 'unique:roles,name'
        ];
        $message = [
            'rol.unique' => 'El rol ya existe'
        ];

        $validator = Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            return view('roles.create')->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $rol = Role::create($request->all());
            $roles = Role::all();
            DB::commit();
            return view('roles.index')
                ->withSuccess("Rol guardado con éxito.")
                ->with('roles', $roles);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return view('roles.create')->withErrors("Error al guardar el Rol.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    # AGARRE PARA ELIMINAR
    public function show($id)
    {
        $role = Role::findOrFail($id);

        if (! $role) {
            return view('roles.index')->withErrors("El no existe.");
        }

        return view('roles.show')->with('rol', $role);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::findOrFail($id);

        if (! $role) {
            return view('roles.index')->withErrors("El no existe.");
        }

        return view('roles.edit')->with('rol', $role);
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
        $rules = [
            'rol' => 'unique:roles,name'
        ];
        $message = [
            'rol.unique' => 'El rol ya existe'
        ];

        $validator = Validator::make($request->all(),$rules,$message);
        if ($validator->fails()) {
            return view('roles.create')->withErrors($validator);
        }

        DB::beginTransaction();
        try {
            $role = new Role();
            $role->fill($request->all());
            $role->save();
            $roles = Role::all();
            DB::commit();
            return view('roles.index')
                ->withSuccess("Rol guardado con éxito.")
                ->with('roles', $roles);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            return view('roles.create')->withErrors("Error al guardar el Rol.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Role::destroy($id);
            DB::commit();
            $roles = Role::all();
            return view('roles.index')
                ->withSuccess("Rol Eliminado con éxito.")
                ->with('roles', $roles);
        } catch (Exception $e) {
            Log::error($e);
            DB::rollBack();
            $roles = Role::all();
            return view('roles.index')
                ->withErrors("Error al eliminar el Rol.")
                ->with('roles', $roles);
        }



    }

    public function relacionar($id)
    {
        #Obteniendo permisos asignados al rol
        $soloIdAsignados = [];
        $asignados = DB::table('role_has_permissions')
            ->where('role_id', $id)
            ->get();
        foreach ($asignados as $item) {
            $soloIdAsignados[] = $item->permission_id;
        }

        #Obteninedo Roles y Permisos
        $rol = Role::findOrFail($id);
        $permisos = Permission::orderBy('name')->get();
        $dataReturn = [];

        foreach ($permisos as $permiso) {
            $tmp = explode("#", strtolower($permiso->name));
            $push['id'] = $permiso->id;
            $push['modulo'] = str_replace("_"," ",$tmp[0]);
            $push['modulo'] = Str::title($tmp[0]);
            $push['permiso'] = str_replace("_"," ",$tmp[1]);
            $push['permiso'] = Str::ucfirst($tmp[1]);
            $push['valor'] = $permiso->name;
            $push['checked'] = in_array($permiso->id, $soloIdAsignados) ? 'true' : 'false';
            $checked = in_array($permiso->id, $soloIdAsignados) ? 'checked' : '';
            $push['input'] = "<input type='checkbox' value='".$permiso->id."' ".$checked." onclick='setPermiso(this)'>";
            $dataReturn[] = $push;
        }


        return view('roles.relacionar')
            ->with('permisos', $dataReturn)
            ->with('rol',$rol);
    }

    public function guardarRelacion(Request $request)
    {
        $permisos = base64_decode($request->get('permisos_seleccionados'));
        $array_permisos = explode(",",$permisos);
        $role = Role::findOrFail($request->get('role_id'));
        //$role->givePermissionTo($permisos);
        $role->syncPermissions($array_permisos);

        $roles = Role::all();
        return view('roles.index')->with('roles', $roles)->with('success', 'Permisos asignados correctamente.');
    }
}
