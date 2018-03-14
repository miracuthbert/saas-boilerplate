<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    @include('layouts.partials._head')
</head>
<body>
    <div id="app">

        @include('layouts.partials._navigation')

        <main class="py-4">
            <div class="container">
                @include('layouts.partials.alerts._alerts')
            </div>

            @yield('content')
        </main>
    </div>

    @include('layouts.partials._scripts')
</body>
</html>
