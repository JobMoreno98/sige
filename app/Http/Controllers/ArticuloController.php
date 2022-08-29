<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Articulo;
use App\Models\Requisicion;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use requisicion as GlobalRequisicion;

class ArticuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $articulos = Articulo::where('requisicion_id',$id)->where('activo',1)->get();
        return view('articulos.index',compact('id'))->with('articulos', $articulos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Requisicion $id)
    {
        $requisicion = $id->id;
        return view('articulos.create',compact('requisicion'));
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
            'codigo'=>'required',
            'descripcion'=>'required',
            'cantidad'=>'required',
            'observacion'=>'required',
        ]);

        $articulos = new Articulo();
        $articulos->codigo = $request->get('codigo');
        $articulos->cantidad = $request->get('cantidad');
        $articulos->descripcion = $request->get('descripcion');
        $articulos->observacion = $request->get('observacion');
        $articulos->status = $request->get('status');
        $articulos->requisicion_id	 = $request->get('requisicion_id');

        $articulos->save();

        return redirect()->route('requisiciones.index');
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
        $articulo = Articulo::find($id);
        return view('articulos.edit')->with('articulo', $articulo);
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
        $articulo = Articulo::find($id);

        $articulo->codigo = $request->get('codigo');
        $articulo->cantidad = $request->get('cantidad');
        $articulo->descripcion = $request->get('descripcion');
        $articulo->observacion = $request->get('observacion');
        $articulo->status = $request->get('status');
        $articulo->requisicion_id = $request->get('requisicion_id');
        //dd($articulo);
        $articulo->save();

        return redirect()->route('requisicion.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $articulo = Articulo::find($id);
        $articulo->activo = 0;

        return redirect()->route('requisicion.index');

    }
}
