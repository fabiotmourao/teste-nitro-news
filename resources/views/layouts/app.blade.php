<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link href="/bootstrap-5.3.3-dist/css/bootstrap.css" rel="stylesheet">
    </head>
<body>
    <header>
    </header>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="text-center py-3">
    </footer>

    <script src="/bootstrap-5.3.3-dist/js/bootstrap.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

    @yield("script")
    </body>
</html>
