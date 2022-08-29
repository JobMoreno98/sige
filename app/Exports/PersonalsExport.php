<?php

namespace App\Exports;

use App\Models\Personal;
use App\Http\Controllers\PersonalController;
// use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonalsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings():array
    {
        return [
            'Nombres Y apellidos',
            'Código',
            'RFC',
            'CURP',
            'Telefono',
            'Telefono celular',
            'Divición',
            'Categoría',
            'Departamento en donde labora',
            'Departamento adscripción',
            'Nombramiento definitivo',
            'Nombramiento temporal',
            'Fecha de emision de nombramiento DEF',
            'Fecha inicio nombramiento Dir',
            'Fecha termino nombramiento Dir',
            'Fecha inicio contrato laboral',
            'Fecha fin contrato laboral'


        ];
    }

    public function collection()
    {
        $query = Personal::select(
            'NombreYApellidos',
            'Codigo',
            'RFC',
            'CURP',
            'Telefono',
            'TelefonoCelular',
            'Division',
            'Categoria',
            'DepartamentoLabora',
            'DepartamentoAdscripcion',
            'NombramientoDefinitivo',
            'NombramientoTemporal',
            'FECHA_DE_EMISION_NOMBRAMIENTO_DEF',
            'FechaInicioNombramientoDir',
            'FechaTerminoNombramientoDir',
            'FechaInicioContratoLaboral',
            'FechaFinContratoLaboral',

        )->get();
        return $query;
    }
}
