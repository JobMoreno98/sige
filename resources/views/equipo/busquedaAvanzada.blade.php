@extends('layouts.app')

@section('content')
    @if(Auth::check() && Auth::user()->role == 'admin')
        Próximamente
    @else
        Acceso No válido
    @endif
@endsection
