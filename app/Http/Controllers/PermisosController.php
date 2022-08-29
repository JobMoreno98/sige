<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permisos = Permission::all();
        $dataReturn = [];
        foreach ($permisos as $permiso) {
            $tmp = explode("#", strtolower($permiso->name));
            $push['id'] = $permiso->id;
            $push['modulo'] = str_replace("_"," ",$tmp[0]);
            $push['modulo'] = Str::title($push['modulo']);
            $push['permiso'] = str_replace("_"," ",$tmp[1]);
            $push['permiso'] = Str::ucfirst($tmp[1]);
            $dataReturn[] = $push;
        }
        return view('permisos.index')->with('permisos', $dataReturn);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permisos = Permission::create(['name' => $request['permiso']]);
        $permisos = Permission::all();
        $dataReturn = [];
        foreach ($permisos as $permiso) {
            $tmp = explode("#", strtolower($permiso->name));
            $push['id'] = $permiso->id;
            $push['modulo'] = str_replace("_"," ",$tmp[0]);
            $push['modulo'] = Str::title($tmp[0]);
            $push['permiso'] = str_replace("_"," ",$tmp[1]);
            $push['permiso'] = Str::ucfirst($tmp[1]);
            $dataReturn[] = $push;
        }
        return view('permisos.index')->with('permisos', $dataReturn);
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
        $permiso = Permission::findOrFail($id);
        $permiso->name = str_replace("#"," - ",$permiso->name);
        $permiso->name = str_replace("_"," ",$permiso->name);
        $permiso->name = Str::title($permiso->name);
        return view('permisos.edit')->with("permiso", $permiso);
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
        $permiso = Permission::findOrFail($id);
        $permiso->delete();
        $permisos = Permission::all();
        $dataReturn = [];
        foreach ($permisos as $permiso) {
            $tmp = explode("#", strtolower($permiso->name));
            $push['id'] = $permiso->id;
            $push['modulo'] = str_replace("_"," ",$tmp[0]);
            $push['modulo'] = Str::title($tmp[0]);
            $push['permiso'] = str_replace("_"," ",$tmp[1]);
            $push['permiso'] = Str::ucfirst($tmp[1]);
            $dataReturn[] = $push;
        }
        return view('permisos.index')->with('permisos', $dataReturn);
    }
}
