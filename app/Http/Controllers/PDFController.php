<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Personal;
use App\Models\VsEquiposPorTicket;
use App\Models\VsMantenimiento;
use App\Models\VsPrestamo;
use App\Models\VsTicket;
use App\Models\Requisicion;
use Illuminate\Http\Request;

class PDFController extends Controller
{

    public function imprimirPrestamo($prestamo_id){
     $prestamo = VsPrestamo::where('id','=',$prestamo_id)->first();
        $pdf = \PDF::loadView('prestamo.formatoPrestamo', compact('prestamo'));
        return $pdf->stream('formatoPrestamo.pdf');

    }
    public function imprimirRecibo($ticket_id){
        $ticket = VsTicket::where('id','=',$ticket_id)->first();
        $equipoPorTickets = VsEquiposPorTicket::where('ticket_id','=', $ticket_id)->get();
        $pdf = \PDF::loadView('ticket.formatoEquipoRecibido', compact('ticket', 'equipoPorTickets'));

        return $pdf->stream('formatoRecibo.pdf');

    }
    public function imprimirpersonal($id){
        $personal = Personal::find ($id);
        $pdf = \PDF::loadView('personal.formatopersonal', compact('personal'));

        return $pdf->stream('formatopersonal.pdf');
    }
    public function imprimirrequisicion($id){
        $requisicion = Requisicion::find($id);
        $articulos = Articulo::where('requisicion_id',$requisicion->id)->get();
        $pdf = \PDF::loadView('requisiciones.formatorequisicion', compact('requisicion','articulos'));

        return $pdf->stream('formatorequisicion.pdf');

    }
}
