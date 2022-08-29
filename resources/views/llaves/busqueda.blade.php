@if ($termino != '')
    @if (isset($consulta))
        <h3 class="text-center">Búsqueda:<br />{{ $termino }}</h3>
        <div class="row">
            @foreach ($consulta as $llave)
                @if ($llave->activo != 0)
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">ID: {{ $llave->id }} - Área de Llave: {{ $llave->area }}
                                </h5>
                                <p class="card-text">Num de LLaves: {{ $llave->num_copias }} <br>
                                    {{ $llave->comentarios }}</p>
                                <a href="{{ route('seleccionarllave', $llave->id) }}"
                                    class="btn btn-outline-success">Agregar</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
        <hr>
    @endif
@endif
