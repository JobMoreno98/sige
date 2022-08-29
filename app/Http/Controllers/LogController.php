<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

use App\Models\VsLog;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vlogs = VsLog::all();
        $logs=$this->cargarDT($vlogs);
        return view('log.index')->with('logs',$logs);
    }
    public function cargarDT($consulta)
    {
        $logs = [];

        foreach ($consulta as $key => $value){

           

            

            $logs[$key] = array(
                $value['folio'],
                $value['tabla'],
                $value['movimiento'],
                $value['usuario'],
                $value['accion'],
                $value['fecha']
            );

        }

        return $logs;
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
	/*
        $validateData = $this->validate($request,[
            'tabla'=>'required',
            'movimiento'=>'required',
            'usuario_id'=>'required',
            'acciones'=>'required',
        ]);
        $log = new Log();
        $log->tablas = $request->input('solicitante');
        $log->movimimiento = $request->input('contacto');
        $log->usuario_id = $request->input('tecnico_id');
        $log->acciones = $request->input('tecnico_id');
        $ticket->save();
        return redirect('log.index')->with(array(
            'message'=>'El Log se guardó Correctamente'
        ));
	*/
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function show(Log $log)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function edit(Log $log)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Log $log)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Log  $log
     * @return \Illuminate\Http\Response
     */
    public function destroy(Log $log)
    {
        //
    }
}
