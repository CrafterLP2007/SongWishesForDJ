<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config("app.name")  }}</title>

    <link rel="icon" type="image/svg" href="{{ asset('img/Logo.svg') }}">

    @filamentStyles
    @vite('resources/css/app.css')
    @livewireStyles
    @livewireScripts
</head>
<body class="antialiased flex flex-col min-h-screen">
<x-navigation.navbar :content="$slot"/>

<x-navigation.footer :content="$slot"/>
@filamentScripts
@livewire('notifications')
@vite('resources/js/app.js')
</body>
</html>
