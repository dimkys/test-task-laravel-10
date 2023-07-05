<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Test Task</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite([
            'resources/css/app.css',
            'resources/js/app.js'
        ])
    </head>
    <body class="antialiased">
        <div>
            <label>
                <input id="link" name="link" placeholder="enter link...">
            </label>
            <button id="submit"
                    data-target="{{route('make.short.link')}}"
                    data-token="{{ csrf_token() }}"
                    data-last-shorts="{{ route('get.last.shorts') }}"
            >Сократить</button>
        </div>
        <div class="last-shorts">
            @include('last-shorts')
        </div>
    </body>
</html>
