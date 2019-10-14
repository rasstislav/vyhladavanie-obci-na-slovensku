<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title', app_name()) | {{ app_name() }}</title>

        <!-- Styles -->
        <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    </head>
    <body class="h-100">
        <div id="app" class="d-flex flex-column h-100">
            @include('includes.header')
            <main role="main" class="flex-grow-1 d-flex">
                @yield('content')
            </main>
            @include('includes.footer')
        </div>

        <!-- Scripts -->
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
