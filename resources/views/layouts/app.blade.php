<!DOCTYPE html>
<html lang="es">
    <head>
        @include('layouts.head')
    </head>
    <body>
        <div id="app">
            @include('layouts.navbar')
            <main class="py-4">
                @yield('content')
            </main>
        </div>
        @include('layouts.scripts')
    </body>
</html>
