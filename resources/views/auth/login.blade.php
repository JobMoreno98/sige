@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card ">


                    <div class="card-header text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-4">
                                <img src="{{ asset('images/cta-logo.jpeg') }}" class="w-100" alt="">
                            </div>
                        </div>

                        {{ __('Acceso') }} Sistema de Gesti&oacute;n CTA CUCSH
                    </div>


                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-12">
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="form-group row">
                                        <label for="email"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Correo electrónico') }}</label>

                                        <div class="col-md-6">
                                            <input id="email" type="email"
                                                class="form-control @error('email') is-invalid @enderror" name="email"
                                                value="{{ old('email') }}" required autocomplete="email" autofocus>

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password"
                                            class="col-md-4 col-form-label text-md-right">{{ __('Contraseña') }}</label>

                                        <div class="col-md-6">
                                            <input id="password" type="password"
                                                class="form-control @error('password') is-invalid @enderror" name="password"
                                                required autocomplete="current-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-6 offset-md-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember"
                                                    id="remember" {{ old('remember') ? 'checked' : '' }}>

                                                <label class="form-check-label" for="remember">
                                                    {{ __('Recordarme') }}
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                {{ __('Acceder') }}
                                            </button>

                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                                    {{ __('¿Olvido su contraseña?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
        <br>
        <br>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-12">
                <a href="{{ route('lista_servicios') }}"><img src="{{ asset('images/imagen_servicios.jpeg') }}"
                        class="img-fluid" alt=""></a>

            </div>

        </div>
        <div class="row justify-content-center">
            <div class="col-md-4">

                <div class="card text-dark bg-light mb-3">
                    <div class="card-header text-center">Tutor&iacute;as</div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">Sistema de Tutor&iacute;as de la Licenciatura en Relaciones
                            Internacionales</h5>
                        <p class="card-text"><a href="http://sige.cucsh.udg.mx/tutorias/public">Sistema de
                                Tutor&iacute;as</a></p>
                    </div>
                </div>

            </div>

            <div class="col-md-4">

                <div class="card text-dark bg-light mb-3">
                    <div class="card-header text-center">Investigaci&oacute;n</div>
                    <div class="card-body">
                        <h5 class="card-title text-dark">Sistema de Registro de Proyectos de Investigaci&oacute;n</h5>
                        <p class="card-text"><a href="http://sige.cucsh.udg.mx/investigacion/public">Sistema de
                                Registro de Proyectos de Investigaci&oacute;n</a></p>
                    </div>
                </div>

            </div>
        </div>
    @endsection
