<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title inertia>{{ config('app.name', 'Laravel') }}</title>
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div id="app" data-page="{{ json_encode($page) }}"></div>
</body>
</html>