<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">

        <title>Pokedex</title>

        <style>
        </style>
    </head>
    <body>
        {{ $slot }}
    </body>
</html>