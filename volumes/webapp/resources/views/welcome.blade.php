<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{config('app.name')}}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased dark:bg-black dark:text-white/50">
        <div>
            <div class="font-bold p-5">
                Project Task Manager
                <span>Click an option below to get started:</span>
            </div>
            <ol class="p-5 list-decimal list-outside pl-[revert]">
                <li class=""><a href="{{ url("/projects") }}">Projects</a></li>
                <li><a href="{{ url("/tasks") }}">Tasks</a></li>
            </ol>
        </div>
    </body>
</html>
