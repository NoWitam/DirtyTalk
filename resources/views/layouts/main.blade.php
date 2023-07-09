<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>
            @hasSection ('title')
                @yield('title') | 
            @endif
            Dirty Talk
        </title>

        @stack('head')
        @livewireStyles
    </head>
    <body>

        @yield('body')
        @stack('js')
        @livewireScripts
    </body>
</html>
