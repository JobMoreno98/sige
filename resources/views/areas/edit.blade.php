@extends('layouts.app')
@section('content')
<div class="container">
    @if (Auth::check())
    @if (session('message'))
    <div class="alert alert-success">
        <h2>{{ session('message') }}</h2>

    </div>
    @endif
    <div class="row">
        <div class="col-md-auto ml-3">
            <h2>Edici&oacute;n de Área</h2>
        </div>
        <hr>
    </div>

    <div class="row">
        <div class="col-12">
            <form action="{{route('areas.update',$area->id)}}" method="post" enctype="multipart/form-data" class="col-12">
                {!! csrf_field() !!}
                {{ method_field('PUT') }}
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        Debe de llenar los campos marcados con un asterisco (*).
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <br>
                <div class="row align-items-center">
                    <div class="col-md-3">
                        <label class="font-weight-bold" for="tipo_espacio">Tipo de Espacio </label>
                        <select class="form-control" id="tipo_espacio" name="tipo_espacio">
                            <option value="{{$area->tipo_espacio}}" selected>{{$area->tipo_espacio}}</option>
                            @if($area->tipo_espacio == 'Administrativo')
                            <option value="Aula">Aula</option>
                            <option value="Laboratorio">Laboratorio</option>
                            @endif
                            @if($area->tipo_espacio == 'Aula')
                            <option value="Administrativo">Administrativo</option>
                            <option value="Laboratorio">Laboratorio</option>
                            @endif
                            @if($area->tipo_espacio == 'Laboratorio')
                            <option value="Administrativo">Administrativo</option>
                            <option value="Aula">Aula</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold" for="sede">Sede </label>
                        <select class="form-control" id="sede" name="sede">
                            <option value="{{$area->sede}}" selected>{{$area->sede}}</option>
                            <option disabled>Elegir</option>
                            <option value="Belenes">Belenes</option>
                            <option value="La Normal">La Normal</option>
                            <option value="Juan Manuel 130">Juan Manuel 130</option>
                            <option value="C.U. DE CS. SOCIALES Y HUMANIDADES">C.U. DE CS. SOCIALES Y HUMANIDADES</option>
                            <option value="Papirolas">Papirolas</option>
                            <option value="FIL">FIL Expo</option>
                            <option value="Prestamo Externo">Pr&eacute;stamo Externo</option>

                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold" for="edificio">Edificio </label>
                        <select class="form-control" id="edificio" name="edificio">
                            <option value="{{$area->edificio}}" selected>{{$area->edificio}}</option>
                            <option disabled>Elegir</option>
                            <option value="Edificio A">Edificio A</option>
                            <option value="Edificio B">Edificio B</option>
                            <option value="Edificio C">Edificio C</option>
                            <option value="Edificio D">Edificio D</option>
                            <option value="Edificio E">Edificio E</option>
                            <option value="Edificio F">Edificio F</option>
                            <option value="Edificio G">Edificio G</option>
                            <option value="Edificio H">Edificio H</option>
                            <option value="Edificio I">Edificio I</option>
                            <option value="Edificio J">Edificio J</option>
                            <option value="Edificio K">Edificio K</option>
                            <option value="Edificio L">Edificio L</option>
                            <option value="Edificio M">Edificio M</option>
                            <option value="Edificio N">Edificio N</option>
                            <option value="Edificio O">Edificio O</option>
                            <option value="Edificio P">Edificio P</option>
                            <option value="Edificio Q">Edificio Q</option>
                            <option value="Edificio R">Edificio R</option>
                            <option value="Edificio S">Edificio S</option>
                            <option value="Edificio T">Edificio T</option>
                            <option value="Edificio U">Edificio U</option>
                            <option value="Edificio Servicios Generales Belenes">Servicios Generales Belenes</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="font-weight-bold" for="piso">Piso </label>
                        <select class="form-control" id="piso" name="piso">
                            <option value="{{$area->piso}}" selected>{{$area->piso}}</option>
                            <option disabled>Elegir</option>
                            <option value="Planta Baja">Planta Baja</option>
                            <option value="Piso 1">Piso 1</option>
                            <option value="Piso 2">Piso 2</option>
                            <option value="Piso 3">Piso 3</option>
                            <option value="Piso 4">Piso 4</option>
                            <option value="Piso 5">Piso 5</option>
                            <option value="Piso 6">Piso 6</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <label class="font-weight-bold" for="division">División </label>
                        <select class="form-control" id="division" name="division">
                            <option value="{{$area->division}}" selected>{{$area->division}}</option>
                            <option disabled>Elegir</option>
                            <option value="Rectoría">Rectoría</option>
                            <option value="Secretaría Académica">Secretaría Académica</option>
                            <option value="Secretaría Administrativa">Secretaría Administrativa</option>
                            <option value="División de Estudios Históricos y Humanos">División de Estudios
                                Históricos y Humanos</option>
                            <option value="División de Estudios Jurídicos">División de Estudios Jurídicos</option>
                            <option value="División de Estudios de la Cultura">División de la Cultura</option>
                            <option value="División de Estudios Políticos y Sociales">División de Estudios Politicos y Sociales
                            </option>
                            <option value="División de Estudios de Estado y Sociedad">División de Estudios de Estado y sociedad
                            </option>
                            <option value="C.U. DE CS. SOCIALES Y HUMANIDADES">C.U. DE CS. SOCIALES Y HUMANIDADES</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="font-weight-bold" for="coordinacion">Coordinación </label>
                        <select class="form-control" id="coordinacion" name="coordinacion">
                            <option value="{{$area->coordinacion}}" selected>{{$area->coordinacion}}</option>
                            <option disabled>Elegir</option>
                            <option value='Auditorio Belenes'>Auditorio Belenes</option>
                            <option value='Auditorio Salvador Allende'>Auditorio Salvador Allende</option>
                            <option value='Biblioteca Central La Normal'>Biblioteca Central La Normal</option>
                            <option value='Bufetes jurídicos'>Bufetes jurídicos</option>
                            <option value='CALAS'>CALAS</option>
                            <option value='Cátedra Emile Durkheim.'>Cátedra Emile Durkheim.</option>
                            <option value='Cátedra José Martí'>Cátedra José Martí</option>
                            <option value='Cátedra Latinoamericana Julio Cortázar'>Cátedra Latinoamericana Julio
                                Cortázar</option>
                            <option value='Cátedra UNESCO'>Cátedra UNESCO</option>
                            <option value='Ciencias Sociales, Doctorado'>Ciencias Sociales, Doctorado</option>
                            <option value='Comité de Alumnos'>Comité de Alumnos</option>
                            <option value='Contraloría'>Contraloría</option>
                            <option value='Control Escolar'>Control Escolar</option>
                            <option value='CTA'>CTA</option>
                            <option value='CTA - Espacion comunes'>CTA - Espacion comunes</option>
                            <option value="C.U. DE CS. SOCIALES Y HUMANIDADES">C.U. DE CS. SOCIALES Y HUMANIDADES</option>
                            <option value='Departamento de Estudios de Lenguas Modernas'>Departamento de Estudios de
                                Lenguas Modernas</option>
                            <option value='Departamento de Estudios del Pacífico'>Departamento de Estudios del
                                Pacífico</option>
                            <option value='Departamento de Estudios en Educación'>Departamento de Estudios en
                                Educación</option>
                            <option value='Departamento de Estudios Ibéricos y Latinoamericanos'>Departamento de
                                Estudios Ibéricos y Latinoamericanos</option>
                            <option value='Departamento de Estudios Socio Urbanos'>Departamento de Estudios Socio
                                Urbanos</option>
                            <option value='Derecho Global, Departamento de '>Derecho Global, Departamento de
                            </option>
                            <option value='Derecho Privado, Departamento de '>Derecho Privado, Departamento de
                            </option>
                            <option value='Derecho Público, Departamento de'>Derecho Público, Departamento de
                            </option>
                            <option value='Derecho Social, Departamento de'>Derecho Social, Departamento de</option>
                            <option value='Desarrollo local y territorio, Maestría'>Desarrollo local y territorio,
                                Maestría</option>
                            <option value='Desarrollo Social , Departamento de'>Desarrollo Social , Departamento de
                            </option>
                            <option value='DESMOS. Departamento de Estudios sobre Movimientos Sociales'>DESMOS.
                                Departamento de Estudios sobre Movimientos Sociales</option>
                            <option value='Difusión, Coordinación'>Difusión, Coordinación</option>
                            <option value='Disciplinas sobre el Derecho, Departamento de'>Disciplinas sobre el
                                Derecho, Departamento de</option>
                            <option value='División de Estudios de Estado y Sociedad'>División de Estudios de Estado
                                y Sociedad</option>
                            <option value='División de Estudios de la Cultura'>División de Estudios de la Cultura
                            </option>
                            <option value='División de Estudios Históricos y Humanos'>División de Estudios
                                Históricos y Humanos</option>
                            <option value='División de Estudios Jurídicos'>División de Estudios Jurídicos</option>
                            <option value='División de Estudios Políticos y Sociales'>División de Estudios Políticos
                                y Sociales</option>
                            <option value='Docencia, Coordinación'>Docencia, Coordinación</option>
                            <option value='Doctorado en Derecho'>Doctorado en Derecho</option>
                            <option value='Enseñanza Incorporada, Unidad'>Enseñanza Incorporada, Unidad</option>
                            <option value='Estudios de la Comunicación Social, , Departamento de'>Estudios de la
                                Comunicación Social, , Departamento de</option>
                            <option value='Estudios del Pacífico'>Estudios del Pacífico</option>
                            <option value='Estudios Internacionales, Departamento de'>Estudios Internacionales,
                                Departamento de</option>
                            <option value='Estudios Literarios, Departamento de'>Estudios Literarios, Departamento
                                de</option>
                            <option value='Estudios Políticos, Departamento de'>Estudios Políticos, Departamento de
                            </option>
                            <option value='Extensión, , Coordinación'>Extensión, , Coordinación</option>
                            <option value='Festival Internacional de Cine de Guadalajara (FICG)'>Festival
                                Internacional de Cine de Guadalajara (FICG)</option>
                            <option value='Filosofía, Departamento de'>Filosofía, Departamento de</option>
                            <option value='Finanzas, Coordinación'>Finanzas, Coordinación</option>
                            <option value='Geografía y Ordenación Territorial'>Geografía y Ordenación Territorial
                            </option>
                            <option value='Historia, Departamento de'>Historia, Departamento de</option>
                            <option value='Investigación, Coordinación'>Investigación, Coordinación</option>
                            <option value='Laboratorio Estudios Históricos y Humanos I'>Laboratorio Estudios
                                Históricos y Humanos I</option>
                            <option value='Laboratorio Estudios Históricos y Humanos II'>Laboratorio Estudios
                                Históricos y Humanos II</option>
                            <option value='Laboratorios Consulta de Acervo Bibliográfico'>Laboratorios Consulta de
                                Acervo Bibliográfico</option>
                            <option value='Laboratorios Documentación Electrónica'>Laboratorios Documentación
                                Electrónica</option>
                            <option value='Laboratorios Estudios Internacionales (Deshabilitado)'>Laboratorios
                                Estudios Internacionales (Deshabilitado)</option>
                            <option value='Lenguas Indígenas, , Departamento de'>Lenguas Indígenas, , Departamento
                                de</option>
                            <option value='Lenguas Modernas, Departamento de'>Lenguas Modernas, Departamento de
                            </option>
                            <option value='Letras, Departamento de'>Letras, Departamento de</option>
                            <option value='Licenciatura en Comunicación Pública'>Licenciatura en Comunicación
                                Pública</option>
                            <option value='Maestría en Ciencias Sociales'>Maestría en Ciencias Sociales</option>
                            <option value='Maestría en Derecho'>Maestría en Derecho</option>
                            <option value='Maestría Interinstitucional en deutsch als fremdes...'>Maestría
                                Interinstitucional en deutsch als fremdes...</option>
                            <option value='Mesoamericanos y Mexicanos, Departamento de'>Mesoamericanos y Mexicanos,
                                Departamento de</option>
                            <option value='Observatorio (Division Jurídicos)'>Observatorio (Division Jurídicos)
                            </option>
                            <option value='Personal, Coordinación'>Personal, Coordinación</option>
                            <option value='Planeación, Coordinación'>Planeación, Coordinación</option>
                            <option value='Posgrado, Coordinación'>Posgrado, Coordinación</option>
                            <option value='Rectoría'>Rectoría</option>
                            <option value='Secretaría Académica'>Secretaría Académica</option>
                            <option value='Secretaría Administrativa'>Secretaría Administrativa</option>
                            <option value='Secretaría Particular'>Secretaría Particular</option>
                            <option value='Servicio Social'>Servicio Social</option>
                            <option value='Servicios Academicos, Coordinación'>Servicios Academicos, Coordinación
                            </option>
                            <option value='Servicios Generales'>Servicios Generales</option>
                            <option value='Servicios Generales Belenes'>Servicios Generales Belenes</option>
                            <option value='Servicios Generales La Normal'>Servicios Generales La Normal</option>
                            <option value='Servicios Generales, Coordinación'>Servicios Generales, Coordinación
                            </option>
                            <option value='Sociología, Departamento de'>Sociología, Departamento de</option>
                            <option value='Trabajo Social, Departamento de'>Trabajo Social, Departamento de</option>
                            <option value='Vinculación'>Vinculación</option>

                        </select>
                    </div>
                </div>
                <br>
                <div class="row align-items-center">
                    <div class="col-md-4">
                        <label class="font-weight-bold" for="imagen_1">Imagen 1</label>
                        <div class="custom-file">
                            <input name="imagen_1" type="file" class="custom-file-input" id="customFileLang" lang="es" value="{{$area->imagen_1}}">
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                        </div>
                        {{--<a href="storage/app/images/{{$area->imagen_1}}" class="thumb" title="Nombre imagen" target="_blank">Nombre imagen</a>--}}
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold" for="imagen_2">Imagen 2</label>
                        <div class="custom-file">
                            <input name="imagen_2" type="file" class="custom-file-input" id="customFileLang" lang="es" value="{{$area->imagen_2}}">
                            <label class="custom-file-label" for="customFileLang">Seleccionar Archivo</label>
                        </div>
                        {{--<a href="storage/app/images/{{$area->imagen_2}}" class="thumb" title="Nombre imagen" target="_blank">Nombre imagen</a>--}}
                    </div>
                    <div class="col-md-4">
                        <label class="font-weight-bold" for="Equipamiento">Equipamiento</label>
                        <select class="form-control" id="equipamiento" name="equipamiento">
                            <option {{($area->equipamiento =='Sin Equipo')? 'selected': ''}} value="Sin Equipo">Sin equipo</option>
                            <option {{($area->equipamiento =='PC')? 'selected': ''}} value="PC">PC</option>
                            <option {{($area->equipamiento =='TV,PC')? 'selected': ''}} value="TV,PC">Pantalla TV - PC</option>
                            <option {{($area->equipamiento =='Proyector,PC')? 'selected': ''}} value="Proyector,PC">Proyector - PC</option>
                        </select>
                    </div>
                </div>
                <div class="row align-items-center mt-4">
                    <div class="col-md-12">
                        <label class="font-weight-bold" for="area">Área</label>
                        <input type="text" class="form-control" id="area" name="area" value="{{$area->area}}">
                    </div>
                </div>
                <br>
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                        <button type="submit" class="btn btn-success">
                            Guardar datos
                            <i class="ml-1 fas fa-save"></i>
                        </button>
                    </div>
                </div>
                <br>
            </form>
        </div>
    </div>
    <br>
    <div class="row align-items-center">

        <br>
        <hr>
        <h5>Coordinación de Tecnologías para el Aprendizaje. CUCSH</h5>


    </div>
</div>

@else
El periodo de Registro de Proyectos a terminado
@endif

@endsection