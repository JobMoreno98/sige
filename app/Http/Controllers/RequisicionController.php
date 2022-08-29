<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Requisicion;
use function Ramsey\Uuid\v1;

class RequisicionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisiciones = Requisicion::all();
        return view('requisiciones.index')->with('requisiciones', $requisiciones);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('requisiciones.create');
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
            'num_sol'=>'required',
            'fecha'=>'required',
            'user'=>'required',
            'proyecto'=>'required',
            'fondo'=>'required',
            'fecha_recibido'=>'required',
            'quien_recibe'=>'required',
        ]);

        $requisiciones = new Requisicion();
        $requisiciones->num_sol = $request->get('num_sol');
        $requisiciones->fecha = $request->get('fecha');
        $requisiciones->user = $request->get('user');
        $requisiciones->proyecto = $request->get('proyecto');
        $requisiciones->fondo = $request->get('fondo');
        $requisiciones->fecha_recibido = $request->get('fecha_recibido');
        $requisiciones->quien_recibe = $request->get('quien_recibe');
        if($request->hasFile('pdf'))
        {
            $archivo=$request->file('pdf');
            $archivo->move(public_path().'/almacen/requis/',$archivo->getClientOriginalName());
            $requisiciones->documento=$archivo->getClientOriginalName();
        }
        $requisiciones->save();

        return redirect('/requisiciones');  
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
        $requisicion = Requisicion::find($id);
        return view('requisiciones.edit')->with('requisicion', $requisicion);
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
        $requisicion = Requisicion::find($id);

        $requisicion->num_sol = $request->get('num_sol');
        $requisicion->fecha = $request->get('fecha');
        $requisicion->user = $request->get('user');
        $requisicion->proyecto = $request->get('proyecto');
        $requisicion->fondo = $request->get('fondo');
        $requisicion->fecha_recibido = $request->get('fecha_recibido');
        $requisicion->quien_recibe = $request->get('quien_recibe');
        if($request->hasFile('pdf'))
        {
            $archivo=$request->file('pdf');
            $archivo->move(public_path().'/almacen/requis/',$archivo->getClientOriginalName());
            $requisicion->documento=$archivo->getClientOriginalName();
        }
        $requisicion->save();

        return redirect('/requisiciones');  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $requisicion = Requisicion::find($id);
        $requisicion->delete();

        return redirect('/requisiciones');

    }
}
