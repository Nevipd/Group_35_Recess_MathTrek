<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- Meta, title, styles, etc. -->
    </head>
    <body>
        @include('layouts.navigation')
        <main>
            {{ $slot }}
        </main>
    </body>
</html>
