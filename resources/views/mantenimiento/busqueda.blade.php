@if ($termino != '')
    @if (isset($consulta))
        <h3 class="text-center">Búsqueda:<br />{{ $termino }}</h3>
        <div class="row">
            @foreach ($consulta as $equipo)
                <div class="col-sm-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">ID UdeG: {{ $equipo->udg_id }} - Equipo: {{ $equipo->tipo_equipo }}
                            </h5>
                            <p class="card-text">Núm de serie:{{ $equipo->numero_serie }} - Modelo:
                                {{ $equipo->modelo }} - Área: {{ $equipo->area }}</p>
                            <a href="{{ route('agregarequipomantenimiento', [$infomantenimiento->id, $equipo->id]) }}"
                                class="btn btn-outline-success">Agregar</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
        <hr>
    @endif
@endif
