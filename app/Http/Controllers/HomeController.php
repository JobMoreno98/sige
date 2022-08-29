<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VsTicket;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
	$ticketsBelenes=VsTicket::where('activo','=',1)
            ->where('estatus','=','Abierto')
	    ->where('sede','=','Belenes')
            ->where('categoria','<>','Reporte de aula')->count();

	$ticketsNormal=VsTicket::where('activo','=',1)
            ->where('estatus','=','Abierto')
	    ->where('sede','=','La Normal')
            ->where('categoria','<>','Reporte de aula')->count();

        return view('home')->with('ticketsNormal',$ticketsNormal)->with('ticketsBelenes',$ticketsBelenes);
    }
}
