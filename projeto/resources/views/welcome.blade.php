<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite(['resources/js/app.js','resources/css/app.css',])


        <title>Marca Site</title>
    </head>
    <body>
        <div id='app'></div>
    </body>
</html>
