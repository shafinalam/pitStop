<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Online Car Workshop Appointment System</title>
        @viteReactRefresh
        @vite([
            'resources/css/app.css',
            'resources/css/navbar.css',
            'resources/css/home.css',
            'resources/css/appointment-form.css',
            'resources/css/mechanics.css',
            'resources/js/app.jsx'
        ])
        @inertiaHead
    </head>
    <body>
        @inertia
    </body>
</html> 